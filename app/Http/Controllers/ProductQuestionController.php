<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductQuestion;
use Illuminate\Http\Request;

class ProductQuestionController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'question' => 'required|string|min:10'
        ]);

        $question = $product->questions()->create([
            'user_id' => auth()->id(),
            'question' => $request->question
        ]);

        return back()->with('success', 'Pertanyaan Anda telah dikirim. Kami akan segera menjawabnya.');
    }

    public function answer(Request $request, ProductQuestion $question)
    {
        $request->validate([
            'answer' => 'required|string|min:10'
        ]);

        $question->update([
            'answer' => $request->answer,
            'answered_by' => auth()->id(),
            'answered_at' => now()
        ]);

        return back()->with('success', 'Jawaban telah berhasil disimpan.');
    }
}
