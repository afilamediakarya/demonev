<?php

namespace App\Http\Middleware;

use App\Models\Jadwal;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class cekJadwal extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string|null $guard
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guard)
    {
        foreach ($guard AS $g) {
            $check = explode('|', $g);
            if (count($check) == 2) {
                if (Jadwal::where('tahapan', $check[0])
                    ->where('sub_tahapan', $check[1])
                    ->whereDate('jadwal_mulai', '<=', now())
                    ->whereDate('jadwal_selesai', '>=', now())
                    ->where('tahun', session('tahun_penganggaran', ''))
                    ->first()) {
                    return $next($request);
                }
            }
        }
        return redirect()->route('dashboard');
    }
}
