<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HashController extends Controller
{
    public function hashController(Request $request)
    {
        $type = $request->input('type');
        if ($request->input('my_code') !== "secretAPI%") { //dienv
            return response()->json([
                'pesan' => 'something went wrong 1'
            ]);
        }
        if (!$request->input("password")) {
            return response()->json([
                'pesan' => 'Password tidak boleh kosong'
            ]);
        }
        $password = $request->input("password");
        // dd($type);
        if ($type == "enkripsi") {
            $encrypted = $this->encryptForVB($password, env('PASS_HASHCUSTOM'));
        } else if ($type == "deskripsi") {
            // dd("oke");
            $encrypted = $this->decryptFromVB($password, env('PASS_HASHCUSTOM')); //di env
        } else {
            return response()->json([
                'pesan' => 'something went wrong'
            ]);
        }



        return response()->json([
            'encrypt' => $encrypted
        ]);
    }

    public function encryptForVB($plainText, $key)
    {
        $md5 = md5($key, true);
        $key24 = $md5 . substr($md5, 0, 8);

        $cipher = "DES-EDE3";
        $options = OPENSSL_RAW_DATA | OPENSSL_NO_PADDING;


        $blockSize = 8;
        $padLength = $blockSize - (strlen($plainText) % $blockSize);
        $paddedText = $plainText . str_repeat(chr($padLength), $padLength);

        $encrypted = openssl_encrypt($paddedText, $cipher, $key24, $options);
        return base64_encode($encrypted);
    }

    public function decryptFromVB($base64Encrypted, $key)
    {
        $md5 = md5($key, true); // hasil 16 byte
        $key24 = $md5 . substr($md5, 0, 8); // jadi 24 byte

        $cipher = "DES-EDE3";
        $options = OPENSSL_RAW_DATA | OPENSSL_NO_PADDING;

        $encrypted = base64_decode($base64Encrypted);

        $decrypted = openssl_decrypt($encrypted, $cipher, $key24, $options);

        // Hapus padding PKCS5/PKCS7 manual
        $padLength = ord(substr($decrypted, -1));
        return substr($decrypted, 0, -$padLength);
    }
}
