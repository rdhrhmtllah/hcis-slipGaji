<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class Whatsapp
{

    public static function send_message($data)
        {
            // Ambil URL dan API Token dari file .env
            $apiToken = env('API_TOKEN');
            $phoneId = env('Phone_Id');

            // Pastikan API Token dan Phone ID tersedia
            if (empty($apiToken) || empty($phoneId)) {
                throw new \Exception("API Token or Phone Id is not configured properly in .env file.");
            }

            // Kirim permintaan POST ke API WhatsApp
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $apiToken
            ])->post($phoneId, $data);

            // Log response atau error
            if ($response->successful()) {
                return $response->json(); // Kembalikan response yang berhasil
            } else {
                \Log::error('WhatsApp API error: ' . $response->body());
                throw new \Exception('Failed to send message: ' . $response->body());
            }
        }

}
