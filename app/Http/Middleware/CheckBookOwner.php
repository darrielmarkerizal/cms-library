<?php
// app/Http/Middleware/CheckBookOwner.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckBookOwner
{
    public function handle(Request $request, Closure $next)
    {
        $book = $request->route('book');

        if (Auth::user()->role === 'admin' || $book->user_id == Auth::id()) {
            return $next($request);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}