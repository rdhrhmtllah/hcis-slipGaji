<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class N_HRIS_USER extends Model implements JWTSubject
{
    use HasFactory;

    protected $table = 'N_HRIS_USER';
    protected $primaryKey = 'NIK'; // Tambahkan ini jika NIK adalah primary key
    public $incrementing = false; // Jika NIK bukan auto-increment
    protected $keyType = 'string'; // Jika NIK berupa string

    protected $fillable = [
        'NIK',
        'No_HP',
        'Nama',
        'Password',
    ];

    protected $hidden = [
        'Password',
    ];

    public $timestamps = false;

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->NIK; // Kembalikan NIK sebagai identifier
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [
            // Anda bisa tambahkan claim khusus di sini
            'user_type' => 'hris_user',
            'nohp' => $this->No_HP
        ];
    }
}
