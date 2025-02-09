<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLetterAccess
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Tambahkan logic tambahan untuk permission jika diperlukan
        // Contoh: if (!auth()->user()->can('manage-letters')) { ... }

        return $next($request);
    }
} 