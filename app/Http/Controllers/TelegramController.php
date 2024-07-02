<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TelegramController extends Controller
{
    //
    public function __construct()
    {
        $botToken = env('TELEGRAM_ADMIN_BOT_TOKEN');
        $webhookUrl = 'https://eodqw8n9gm0bckl.m.pipedream.net'; // Замените на ваш реальный URL-адрес вебхука

        $bot = new \TelegramBot\Api\BotApi($botToken);
        $bot->setWebhook($webhookUrl);
    }

    public function main(){
        return view('welcome');
    }
}
