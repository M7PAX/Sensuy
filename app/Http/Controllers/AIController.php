<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;

class AIController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        $client = OpenAI::client(env('OPENAI_API_KEY'));

        try {
            $response = $client->chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    ['role' => 'user', 'content' => $request->message],
                ],
            ]);

            return response()->json([
                'reply' => $response->choices[0]->message->content,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Could not connect to the AI service.'], 500);
        }
    }
}
