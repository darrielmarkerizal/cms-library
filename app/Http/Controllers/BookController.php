<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return response()->json($books);
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'quantity' => 'required|integer',
                'category_id' => 'required|exists:categories,id',
                'pdf_file' => 'required|file|mimes:pdf|max:2048',
                'cover_image' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
                'user_id' => 'required|exists:users,id',
            ]);
    
    
            if ($request->hasFile('pdf_file')) {
                $validatedData['path_pdf'] = $request->file('pdf_file')->store('pdfs', 'public');
            }
    
            if ($request->hasFile('cover_image')) {
                $validatedData['path_cover'] = $request->file('cover_image')->store('covers', 'public');
            }
    
            $book = Book::create($validatedData);
    
            return response()->json($book, 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'error' => 'Validation failed',
                'messages' => $e->errors(),
                'cause' => 'One or more fields did not pass validation.'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'An error occurred',
                'message' => 'Something went wrong. Please try again later.',
                'details' => env('APP_DEBUG') ? $e->getMessage() : 'Error details are not available.'
            ], 500);
        }
    }

    public function show(Book $book)
    {
        return response()->json($book);
    }

    public function update(Request $request, Book $book)
    {
        $validatedData = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'category_id' => 'sometimes|required|exists:categories,id',
            'description' => 'sometimes|required|string',
            'quantity' => 'sometimes|required|integer',
            'pdf_file' => 'sometimes|required|string',
            'cover_image' => 'sometimes|required|string',
            'path_cover' => 'sometimes|required|string',
            'path_pdf' => 'sometimes|required|string',
            'user_id' => 'sometimes|required|exists:users,id',
        ]);

        $book->update($validatedData);
        return response()->json($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(null, 204);
    }
}
