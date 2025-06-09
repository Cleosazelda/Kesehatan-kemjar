<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureHeaders
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Mencegah browser menebak tipe konten selain dari yang dideklarasikan
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // Mencegah halaman Anda ditampilkan dalam <iframe> di situs lain (Clickjacking)
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        
        // Mengaktifkan filter XSS bawaan browser
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        
        // Mengontrol informasi apa yang dikirim saat pengguna mengklik link ke situs lain
        $response->headers->set('Referrer-Policy', 'no-referrer-when-downgrade');

        // Menghapus informasi detail tentang server/teknologi yang Anda gunakan
        $response->headers->remove('X-Powered-By');

        // (Opsional, lebih lanjut) Kebijakan Keamanan Konten. Ini perlu konfigurasi hati-hati.
        // $response->headers->set('Content-Security-Policy', "default-src 'self'");

        return $response;
    }
}