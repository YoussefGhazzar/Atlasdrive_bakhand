<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatBotController extends Controller
{
    public function chat(Request $request)
    {
        

       $response = Http::post('http://127.0.0.1:9000/chat', [
        'message' => $request->message
]);

return response()->json($response->json());
    }
}
