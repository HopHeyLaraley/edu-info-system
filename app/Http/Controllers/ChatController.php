<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
// use TelegramBot\Api;

class ChatController extends Controller
{
    //
    private $telegramTeacher;
    private $telegramAdmin;
    private $chatId;

    public function __construct()
    {
        $this->telegramTeacher = env('TELEGRAM_TEACHER_BOT_TOKEN');
        $this->telegramAdmin = env('TELEGRAM_ADMIN_BOT_TOKEN');
        $this->chatId = env('TELEGRAM_CHAT_ID');
    }

    public function sendMessage(Request $request)
    {
        $userId = auth()->user()->id;
        $role = User::find($userId)->role;
        $name = User::find($userId)->name;

        $message = $request->input('message');

        if($role == "admin"){
            $bot = new \TelegramBot\Api\BotApi($this->telegramAdmin);
            $bot->sendMessage($this->chatId, $message);

            $newMessage = new Message();
            $newMessage->sender_name = "(учитель)".$name;
            $newMessage->text = $message;
            $newMessage->save();

        }else if($role == "teacher"){
            $bot = new \TelegramBot\Api\BotApi($this->telegramTeacher);
            $bot->sendMessage($this->chatId, $message);

            $newMessage = new Message();
            $newMessage->sender_name = "Admin";
            $newMessage->text = $message;
            $newMessage->save();
        }else if($role == "user"){
            $bot = new \TelegramBot\Api\BotApi($this->telegramAdmin);
            $bot->sendMessage($this->chatId, $message);

            $newMessage = new Message();
            $newMessage->sender_name = $name;
            $newMessage->text = $message;
            $newMessage->save();

        }

        $messages = Message::oldest()->get();
        return view('chat', compact('messages'));
        // return response()->json(['status' => 'Message sent']);
    }

    public function loadMessages()
    {
        $messages = Message::oldest()->get();
        return view('chat', compact('messages'));
    }

    public function handleWebhook(Request $request)
    {
        $telegramMessage = $request->input('message');
        
        // Извлекаем данные о тексте сообщения, отправителе и другие необходимые данные
        $text = $telegramMessage['text'];
        $senderName = $telegramMessage['from']['username'];
        
        // Сохраняем сообщение в базу данных
        $message = new Message();
        $message->text = $text;
        $message->sender_name = $senderName;
        $message->save();
        // Обработка обновлений и сохранение сообщений
        // Например, сохранение сообщений в базу данных для отображения на странице
        $messages = Message::oldest()->get();
        return view('chat', compact('messages'));
    }
}
