<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatBotController extends Controller
{
    /**
     * Handle the chatbot requests and proxy them to the FastAPI Python backend.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $message = $request->input('message');

        try {
            // Forward request to Python FastAPI Chatbot Service
            // Python service is run on port 8001 inside Docker
            $chatbotUrl = env('CHATBOT_SERVICE_URL', 'http://chatbot:8001/chat');

            $response = Http::timeout(30)->post($chatbotUrl, [
                'message' => $message,
            ]);

            if ($response->successful()) {
                return response()->json($response->json());
            }

            Log::error('Chatbot service returned an error status: ' . $response->status(), [
                'body' => $response->body()
            ]);

            return response()->json([
                'response' => 'Sorry, I am having trouble processing that request right now. Please try again later.'
            ], 502);

        } catch (\Exception $e) {
            Log::error('Failed to communicate with chatbot service: ' . $e->getMessage());

            return response()->json([
                'response' => 'The AtlasDrive AI Assistant is currently offline. Please make sure the service is running.'
            ], 503);
        }
    }
}
