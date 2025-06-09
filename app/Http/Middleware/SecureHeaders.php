// app/Http/Middleware/SecureHeaders.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SecureHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Hapus header yang tidak perlu untuk menyembunyikan informasi teknologi
        $response->headers->remove('X-Powered-By');
        $response->headers->remove('server');
        
        // HSTS (Strict-Transport-Security) - memaksa koneksi HTTPS
        // Aktifkan ini jika website Anda sudah sepenuhnya berjalan di HTTPS
        // $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        
        // Mencegah browser menebak tipe MIME dari file
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        
        // Mencegah Clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');
        
        // Mengaktifkan filter XSS bawaan browser
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // Content Security Policy (CSP) yang lebih ketat
        // Kebijakan ini hanya mengizinkan resource (JS, CSS, Font, Gambar) dari domain Anda sendiri.
        // Jika Anda menggunakan resource dari luar (misal: Google Fonts, CDN JQuery), Anda harus menambahkannya di sini.
        $csp = "default-src 'self'; " .
               "script-src 'self' 'unsafe-inline'; " . // 'unsafe-inline' mungkin diperlukan untuk beberapa JS, tapi lebih baik dihindari jika bisa
               "style-src 'self' 'unsafe-inline'; " .  // Sama seperti script-src
               "img-src 'self' data:; " . // 'data:' mengizinkan inline images (base64)
               "font-src 'self'; " .
               "object-src 'none'; " . // Blokir plugin seperti Flash
               "frame-ancestors 'self'; " . // Mencegah website Anda di-embed di situs lain
               "form-action 'self'; " . // Membatasi ke mana form bisa di-submit
               "base-uri 'self';";

        $response->headers->set('Content-Security-Policy', $csp);
        
        return $response;
    }
}