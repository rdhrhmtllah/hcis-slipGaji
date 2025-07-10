<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\N_HRIS_USER;
use App\Models\TokenUsage;
use Carbon\Carbon;
use App\Helpers\Whatsapp;
use App\Http\Controllers\Api\HashController;


class TokenController extends Controller
{
    protected $hashController;

    public function generateToken(Request $request)
    {
        $request->validate([
        'datanik' => 'required|string',
        'nohp' => 'required|string',
        ]);

        $user = N_HRIS_USER::where('NIK', $request->datanik)
                ->where('No_HP', $request->nohp)
                ->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data NIK atau No HP tidak ditemukan di sistem.'
            ], 404);
        }

        $customClaims = [
            'sub' => $request->datanik,
            'nohp' => $request->nohp,
            'purpose' => 'whatsapp_access',
            'jti' => Str::uuid()->toString(),
            'user_type' => 'hris_user',
            'exp' => now()->addHours(1)->timestamp
        ];
        try {

        $token = JWTAuth::claims($customClaims)->fromUser($user);

        return response()->json([
            'status' => 'success',
            'token' => $token,
            'expires_in' => 3600 // 1 jam dalam detik
        ]);
        } catch (JWTException $e) {
            Log::error('Gagal membuat token JWT: ' . $e->getMessage(), [
                'request_data' => $request->all(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal membuat token: ' . $e->getMessage()
            ], 500);
        }
    }

    public function accessPasswordForm($token)
    {
        try {
            DB::beginTransaction();

            $payload = JWTAuth::setToken($token)->getPayload();

            $requiredClaims = ['sub', 'nohp', 'jti']; // 'sub' berisi NIK berdasarkan payload

            foreach ($requiredClaims as $claim) {
                if (!isset($payload[$claim])) {
                    throw new TokenInvalidException("Klaim $claim tidak ditemukan dalam token");
                }
            }

            // Ambil nilai dari payload
            $jti = $payload['jti'];
            $datanik = $payload['sub']; // Gunakan 'sub' yang berisi NIK
            $nohp = $payload['nohp'];

            $purpose = $payload['purpose'] ?? null;
            if ($purpose !== 'whatsapp_access') {
                DB::rollBack();
                return view('error', ['message' => 'Token bukan untuk akses WhatsApp.']);
            }


            // if (TokenUsage::where('jti', $jti)->exists()) {
            //     DB::rollBack();
            //     return view('error', ['message' => 'Link ini sudah pernah digunakan atau kedaluwarsa.']);
            // }


            $userExists = N_HRIS_USER::where('NIK', $datanik)
                            ->where('No_HP', $nohp)
                            ->exists();
            if (!$userExists) {
                DB::rollBack();
                return view('error', ['message' => 'Data pengguna tidak ditemukan.']);
            }

            // TokenUsage::create([
            //     'jti' => $jti,
            //     'expires_at' => Carbon::createFromTimestamp($payload['exp']),
            //     'used_at' => Carbon::now(),
            // ]);
            DB::commit();

            session([
                'temp_nohp' => $nohp,
                'temp_nik' => $datanik,
            ]);

            return view('setPass', [
                'message' => 'Akses Berhasil!',
                'datanik' => $datanik,
            ]);
        }catch (TokenExpiredException $e) {
            return view('error', ['message' => 'Token telah kadaluarsa. Silakan minta link baru.']);
        }catch (TokenInvalidException $e) {
            Log::error('Token invalid: ' . $e->getMessage(), [
                'payload' => $payload->toArray()
            ]);
            return view('error', ['message' => 'Token tidak valid: ' . $e->getMessage()]);
        }catch (JWTException $e) {
            DB::rollBack();
            Log::error('JWT Error pada akses form password: ' . $e->getMessage(), [
                'token' => $token,
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine()
            ]);
            return view('error', ['message' => 'Terjadi kesalahan pada token.']);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Kesalahan umum saat akses form password: ' . $e->getMessage(), [
                'token' => $token,
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'stack_trace' => $e->getTraceAsString()
            ]);
            return view('error', ['message' => 'Terjadi kesalahan sistem. Silakan coba lagi.']);
        }
    }

    public function __construct(HashController $hashController)
    {
        $this->hashController = $hashController;
    }

    public function HashPass(Request $request)
    {
        $passUnreal = 'kluklu';
        $unHashPass = env('SALT_FRONT') . $passUnreal . env('SALT_BACK');

        $HashCustom = new HashController();

        $data = [
            'type' => 'enkripsi',
            'password' => $unHashPass,
            'my_code' => 'secretAPI%',
        ];


        $request = new Request($data);

        $HashCustom = new HashController();
        $rawPass = $HashCustom->hashController($request)->getData();

        $finalPassword = $rawPass->encrypt;

        $data2 = [
            'type' => 'deskripsi',
            'password' => $finalPassword,
            'my_code' => 'secretAPI%',
        ];
        $request2 = new Request($data2);

        $rawPass2 = $HashCustom->hashController($request2)->getData();
        $finalUnreal = $rawPass2->encrypt;

        // dd($finalUnreal);
        // dd('Pasword yang dienkrip : '.$finalPassword.' ; Ini Password tidak enkrip : '. $finalUnreal);
        return view('success')->with('success', 'Berhasil');
    }


    public function postPassword(Request $request)
    {

        $request->validate([
            'password' => 'required|min:8|max:15|regex:/[a-zA-Z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
            'password_confirmation' => 'required|same:password'
        ], [
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password harus terdiri dari minimal 8 karakter.',
            'password.max' => 'Password tidak boleh lebih dari 15 karakter.',
            'password.regex' => 'Password harus mengandung huruf, angka, dan simbol.',
            'password_confirmation.required' => 'Konfirmasi password wajib diisi.',
            'password_confirmation.same' => 'Konfirmasi password harus sama dengan password.'
        ]);


        try {
            DB::beginTransaction();

            $noHp = session('temp_nohp');
            $NIK = session('temp_nik');
            $namaUser = DB::table('N_HRIS_USER')->where('No_HP', $noHp)->first();


            if (empty($noHp) || empty($NIK)) {
                Log::warning('Session invalid', ['nohp' => $noHp, 'nik' => $NIK]);
                DB::rollBack();
                return view('error', ['message' => 'Sesi tidak valid'])->with('error', 'Sesi tidak valid');
            }

            $unHashPass = env('SALT_FRONT') . $request->password . env('SALT_BACK');

            $HashCustom = new HashController();

            $data = [
                'type' => 'enkripsi',
                'password' => $unHashPass,
                'my_code' => 'secretAPI%',
            ];

            $request = new Request($data);

            $HashCustom = new HashController();
            $rawPass = $HashCustom->hashController($request)->getData();
            $finalPassword =  $rawPass->encrypt;

            // Hash::make(env('SALT_FRONT') . $request->password . env('SALT_BACK'));

            $query = N_HRIS_USER::where('NIK', $NIK)
                    ->where('No_HP', $noHp)
                    ->toSql();

            $updatedRows = N_HRIS_USER::where('NIK', $NIK)
                            ->where('No_HP', $noHp)
                            ->update(['Password' => $finalPassword]);


            if ($updatedRows === 0) {
                Log::error('Update gagal', ['nik' => $NIK, 'nohp' => $noHp]);
                DB::rollBack();
                return view('error',  ['message' =>  'Update password gagal, User tidak ditemukan'])->with('error', 'Update password gagal');
            }



            $pesan = [
                "messaging_product" => "whatsapp",
                "to" => $noHp,
                "type" => "template",
                "template" => [
                    "name" => "berhasil_set_slip_gj",
                    "language" => [
                        "code" => "id",
                        "policy" => "deterministic"
                    ],
                    "components" => [
                        [
                            "type" => "body",
                            "parameters" => [
                                [
                                    "type" => "text",
                                    "text" => $namaUser->Nama
                                ],
                                [
                                    "type" => "text",
                                    "text" => "Password"
                                ]
                            ]
                        ]

                    ]
                ]
            ];

            DB::table('N_HRIS_User_Session')->where('No_HP', $noHp)->delete();

            $response = Whatsapp::send_message($pesan);
            Log::channel('whatsapp_error')->warning('Pesan Error', [
                "pesan" => $response
            ]);

            DB::commit();
            Log::info('Password berhasil diupdate');

            session()->forget(['temp_nohp', 'temp_nik']);

            return view('success')->with('success', 'Password berhasil diubah');

        } catch (\Throwable $e) {
            Log::error('Error pada postPassword: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            DB::rollBack();
            return view('error', ['message' => 'Error post password: ' . $e->getMessage()])->with('error', 'Error sistem');
        }
    }

    public function newUrl(){
        $noHp = session('temp_nohp') ?? null;
        $NIK = session('temp_nik') ?? null;

        if ($noHp && $NIK) {
            DB::table('N_HRIS_User_Session')->where('No_HP', $noHp)->delete();
            DB::table('N_HRIS_USER')->where('No_HP', $noHp)->delete();
        }

        return redirect('https://wa.me/6282280954525?text=Halo,%20saya%20butuh%20bantuan');
    }


}
