<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quote;

class QuoteController extends Controller{

    public function index(Request $request)
    {
        $quotes=Quote::all();
        return response()->json([$quotes],200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'content' => 'required|string',
            'author' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
        ]);
        
        $quote = Quote::create($validated);
        
        return response()->json([
            "message" => "quote est bien cree . $quote->content"
        ], 201);
    }

    public function show(Quote $quote)
    {
        $quote->view_count++;
        $quote->save();
        return response()->json($quote, 200);
    }

  
    public function update(Request $request, Quote $quote)
    {
        $validated = $request->validate([
            'content' => 'sometimes|required|string',
            'author' => 'nullable|string|max:255',
            'source' => 'nullable|string|max:255',
        ]);
        
        $quote->update($validated);
        
        return response()->json([
            "message" => "Quote updated successfully",
            "quote" => $quote
        ], 200);
    }

  
    public function destroy(Quote $quote)
    {
        $quote->delete();
        
        return response()->json([
            "message" => "Quote deleted successfully"
        ], 200);
    }

    public function random(Request $request, $count)
    {
    
    
        $quotes = Quote::inRandomOrder()->limit($count)->get();
        foreach($quotes as $quote){
            $quote->view_count++;
            $quote->save();
        }
        return response()->json($quotes, 200);
    }

    
    public function GetQuoteWithLength(Request $request, $length){

    $quotes=Quote::all();
            foreach($quotes as $quote){
                if(str_word_count($quote->content) == $length){
                    $matchedQuotes[] = $quote; 
                }
            }
            if(empty($matchedQuotes)){
                return response()->json([
                    "message" => "There is no Quote with This Length"
                ], 200);
            }

        return response()->json([$matchedQuotes],200);

    }
    public function GetPopularQuote()
    {
        $quote = Quote::orderBy('view_count', 'desc')->first();
        
        if (!$quote) {
            return response()->json([
                "message" => "No quotes found"
            ], 404);
        }
        
        return response()->json([
            "quote_most_popular" => $quote
        ], 200);
    }
}
