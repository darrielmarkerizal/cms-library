<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Book;

class CheckBookOwnerOrAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        Log::info('Authenticated user:', ['user' => $user]);

        // Pastikan route mengirimkan ID buku dan ambil buku dari database
        $bookId = $request->route('book_id'); // Sesuaikan dengan nama parameter route Anda

        if (!$user) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'User is not authenticated',
                'reason' => 'No user is logged in'
            ], 403);
        }

        $book = Book::find($bookId); // Temukan buku berdasarkan ID dari database

        if (!$book) {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'Book not found',
            ], 404);
        }

        if ($user->role === 'admin' || $user->id === $book->user_id) {
            return $next($request);
        }

        return response()->json([
            'error' => 'Unauthorized',
            'message' => 'User does not have the required permissions',
            'reason' => $user->role !== 'admin' ? 'User is not an admin' : 'User does not own the book',
            'user' => $user,
            'book' => $book
        ], 403);
    }
}