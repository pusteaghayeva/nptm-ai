<?php

namespace App\Http\Controllers;


use App\Models\Conversation;
use App\Models\Message;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
class ChatController extends Controller

{
    public function index()
    {
        $conversations = Auth::user()->conversations()->latest()->get();
        $conversation = null;
        $messages = [];

        return view('chat.index', compact('conversations', 'conversation', 'messages'));
    }

    public function show(Conversation $conversation)
    {
        if ($conversation->user_id !== Auth::id()) {
            abort(403);
        }

        $conversations = Auth::user()->conversations()->latest()->get();
        $messages = $conversation->messages()->orderBy('created_at')->get();

        return view('chat.index', compact('conversations', 'conversation', 'messages'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'conversation_id' => 'nullable|exists:conversations,id',
        ]);

        $userMessage = $request->message;

        // Söhbət yarat və ya mövcudunu tap
        if ($request->conversation_id) {
            $conversation = Conversation::findOrFail($request->conversation_id);
            if ($conversation->user_id !== Auth::id()) {
                abort(403);
            }
        } else {
            $conversation = Conversation::create([
                'user_id' => Auth::id(),
                'title' => mb_substr($userMessage, 0, 50),
            ]);
        }

        // İstifadəçi mesajını saxla
        Message::create([
            'conversation_id' => $conversation->id,
            'role' => 'user',
            'content' => $userMessage,
        ]);

        // AI cavabı al
        $model = $request->input('model', 'groq');
        $aiResponse = $this->getAiResponse($userMessage, $model);

        // AI cavabını saxla
        Message::create([
            'conversation_id' => $conversation->id,
            'role' => 'assistant',
            'content' => $aiResponse,
        ]);

        return response()->json([
            'success' => true,
            'conversation_id' => $conversation->id,
            'response' => $aiResponse,
        ]);
    }

    public function destroy(Conversation $conversation)
    {
        if ($conversation->user_id !== Auth::id()) {
            abort(403);
        }

        $conversation->delete();
        return redirect()->route('chat.index');
    }

private function getAiResponse(string $userMessage, string $model = 'groq'): string
{
    $faqs = Faq::where('is_active', true)->get();
    $userMessageLower = mb_strtolower($userMessage);

    foreach ($faqs as $faq) {
        $questionLower = mb_strtolower($faq->question);
        $keywords = explode(' ', $questionLower);
        $matchCount = 0;
        foreach ($keywords as $keyword) {
            if (mb_strlen($keyword) > 3 && str_contains($userMessageLower, $keyword)) {
                $matchCount++;
            }
        }
        if ($matchCount >= 2) {
            return $faq->answer;
        }
    }

    if ($model === 'openai') {
        return $this->callOpenAI($userMessage);
    }

    if ($model === 'gemini') {
    return $this->callGemini($userMessage);
}

if ($model === 'deepseek') {
    return $this->callDeepSeek($userMessage);
}

    return $this->callGroq($userMessage);
}

private function callGroq(string $userMessage): string
{
    try {
        $apiKey = config('services.groq.key');
        $data = json_encode([
            'model' => 'llama-3.3-70b-versatile',
            'messages' => [
                ['role' => 'system', 'content' => 'Sən Naxçıvan Poçt və Telekommunikasiya Mərkəzinin (NPTM) AI köməkçisisən. Azərbaycan dilində cavab ver.'],
                ['role' => 'user', 'content' => $userMessage]
            ],
            'max_tokens' => 500
        ]);

        $ch = curl_init('https://api.groq.com/openai/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $response = json_decode($result, true);
            return $response['choices'][0]['message']['content'];
        }
        return 'Xəta: ' . $httpCode . ' - ' . $result;
    } catch (\Exception $e) {
        return 'Xəta: ' . $e->getMessage();
    }
}

private function callOpenAI(string $userMessage): string
{
    try {
        $apiKey = config('services.openai.key');
        $data = json_encode([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'Sən Naxçıvan Poçt və Telekommunikasiya Mərkəzinin (NPTM) AI köməkçisisən. Azərbaycan dilində cavab ver.'],
                ['role' => 'user', 'content' => $userMessage]
            ],
            'max_tokens' => 500
        ]);

        $ch = curl_init('https://api.openai.com/v1/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $response = json_decode($result, true);
            return $response['choices'][0]['message']['content'];
        }
        return 'Xəta: ' . $httpCode . ' - ' . $result;
    } catch (\Exception $e) {
        return 'Xəta: ' . $e->getMessage();
    }
}

private function callGemini(string $userMessage): string
{
    try {
        $apiKey = config('services.gemini.key');
        $data = json_encode([
            'contents' => [
                [
                    'parts' => [
                        ['text' => 'Sən Naxçıvan Poçt və Telekommunikasiya Mərkəzinin (NPTM) AI köməkçisisən. Azərbaycan dilində cavab ver. İstifadəçi sualı: ' . $userMessage]
                    ]
                ]
            ],
            'generationConfig' => [
                'maxOutputTokens' => 500
            ]
        ]);

        $ch = curl_init('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $response = json_decode($result, true);
            return $response['candidates'][0]['content']['parts'][0]['text'];
        }
        return 'Xəta: ' . $httpCode . ' - ' . $result;
    } catch (\Exception $e) {
        return 'Xəta: ' . $e->getMessage();
    }
}
private function callDeepSeek(string $userMessage): string
{
    try {
        $apiKey = config('services.deepseek.key');
        $data = json_encode([
            'model' => 'deepseek-chat',
            'messages' => [
                ['role' => 'system', 'content' => 'Sən Naxçıvan Poçt və Telekommunikasiya Mərkəzinin (NPTM) AI köməkçisisən. Azərbaycan dilində cavab ver.'],
                ['role' => 'user', 'content' => $userMessage]
            ],
            'max_tokens' => 500
        ]);

        $ch = curl_init('https://api.deepseek.com/chat/completions');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $apiKey,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200) {
            $response = json_decode($result, true);
            return $response['choices'][0]['message']['content'];
        }
        return 'Xəta: ' . $httpCode . ' - ' . $result;
    } catch (\Exception $e) {
        return 'Xəta: ' . $e->getMessage();
    }
}


}