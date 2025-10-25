<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Http\Request;


class ChatController extends Controller
{
    //
    public function index()
    {

        return view('chat.index');
    }


    public function feed(Request $request)
    {
        $user = $request->user();


        // Вернём последние 50 с пользователями
        $messages = Message::with('user:id,name')
            ->latest()->take(50)->get()->reverse()->values();

        // Нормализуем JSON для фронта
        return response()->json($messages->map(fn ($m) => [
            'id'      => $m->id,
            'text'    => $m->message ?? $m->messages, // на случай, если у тебя колонка `messages`
            'user'    => ['id' => $m->user->id, 'name' => $m->user->name],
            'sent_at' => $m->created_at->toISOString(),
        ]));
    }
    public function send(Request $request)
    {
        $data = $request->validate(['message' => 'required|string|max:2000']);
        $user = $request->user();

        $msg = Message::create([
            'user_id' => $user->id,
            'message' => $data['message'], // если у тебя колонка `messages` — поменяй ключ
        ]);

        // Шлём ВСЕМ, включая отправителя, чтобы он тоже увидел без перезагрузки
        broadcast(new MessageSent(
            message: $msg->message ?? $msg->messages,
            user: ['id' => $user->id, 'name' => $user->name]
        ));

        // Для AJAX-ответа вернём то же, что прилетит по сокету (на случай, если Echo не подключился)
        return response()->json([
            'id'      => $msg->id,
            'text'    => $msg->message ?? $msg->messages,
            'user'    => ['id' => $user->id, 'name' => $user->name],
            'sent_at' => $msg->created_at->toISOString(),
        ]);
    }
}
