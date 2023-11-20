<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class BotTelegramController extends Controller
{
    public function inbound(Request $request)
    {

        //Setting in Env
        // TELEGRAM_BOT_TOKEN="bot6899260953:AAGncVBPw3gjrCjhUgZQIaLZ94QNb_j50g4"
        // TELEGRAM_WEBHOOK_URL='<url>/api/Faozitele_bot/webhooks'
        // TELEGRAM_API_ENDPOINT=https://api.telegram.org
        // REGISTER_POINT=https://api.telegram.org/bot6899260953:AAGncVBPw3gjrCjhUgZQIaLZ94QNb_j50g4/setWebhook?url=<url>/api/telegram/webhooks/inbound

        log::info($request->all());

        // get telegram chat_id and reply
        if($request->message != null){
        $chat_id            = $request->message['from']['id'];
        $username            = $request->message['from']['first_name'];
        $reply_to_message   = $request->message['message_id'];
        $texts   = $request->message['text'];

        //Insert PgAdmin
        DB::connection('pgsql')->table('public.HistoryChat')->insert([
            'username' => $username,
            'chat_id' => $reply_to_message,
            'texts' => $texts,
        ]);

        //get omdbapi API
        $omdbapi = Http::get('http://omdbapi.com', [
            'apiKey' => "3a4ed73b",
            's' => $request->message['text']
        ]);

    // Kondisi Response
    if($omdbapi['Response'] == "True"){

        //Get Image
        $images = $omdbapi['Search'][0]['Poster'];

        //Get Log Info
        log::info("chat_id: {$chat_id}");
        log::info("reply_to_message: {$reply_to_message}");
        
        //first message
        if(!cache()->has("chat_id_{$chat_id}")){

            $text = "Hallo And Welcome To Bot Telegram :)";
            $text.= "what movie are you looking for?";

            cache()->put("chat_id_{$chat_id}",true,now()->addMinute(1));

        //Contiditon After First Message
        } else {
            
            $text = "These are the results we found.";
            $text.= $omdbapi['Search'][0]['Title'];

        }
        //Send Photo
        $result = app('telegram_bot')->sendPhoto($chat_id,$images);

        // Response False
    } else {

        $result = "";
        $text = "Movie Not Found!!!";

    }

        //Send Message 
        $results = app('telegram_bot')->sendMessage($text,$chat_id,$reply_to_message);
        
        // Loop Data
        $data = [$results, $result];

        return response()->json($data,200);
    }

    }
}

