<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatAIRequest;
use App\Models\ChatAI;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use OpenAI\Laravel\Facades\OpenAI;

class ChatAIController extends Controller
{
    public function view()
    {
        return view('chat.index');
    }

    public function ai(Request $request)
    {
        $result = OpenAI::completions()->create([
            'model' => 'text-davinci-003',
            'prompt' => $request->message,
            'max_tokens' => 1500,
            'temperature' => 0
        ]);

        ChatAI::create([
            'question'  => $request->message,
            'answer'    => $result['choices'][0]['text'],
        ]);

        return response()->json([
            'status'    => true,
            'message'   => $result['choices'][0]['text'],
        ]);
    }

    public function actionMigrate()
    {
        Artisan::call('migrate');
        echo "Thành Công!";
    }
}
