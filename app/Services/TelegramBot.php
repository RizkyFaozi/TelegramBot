<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class TelegramBot
{
    protected $token;
    protected $api_endpoint;
    protected $headers;

    //construct Method
    public function __construct()
    {
        $this->token        = env('TELEGRAM_BOT_TOKEN');
        $this->api_endpoint = env('TELEGRAM_API_ENDPOINT');
        $this->setHeaders(); 
    }

    protected function setHeaders()
    {
        $this->headers = [
            "Content-Type" => "application/json",
            "Accept" => "application/json",
        ];
    }

    public function sendMessage($text = '',$chat_id,$reply_to_message_id)
    {
        //Default result array
        $result = ['success'=>false,'body'=>[]];

        //Parameter API Tele
        $params = [
            'chat_id'           => $chat_id,
            'reply_to_message'  => $reply_to_message_id,
            'text'              => $text,
        ];

        //Get Url 
        $url = "{$this->api_endpoint}/{$this->token}/sendMessage";

        //Request send ()
        try{

            $response = Http::withHeaders($this->headers)->post($url,$params);
            $result = ['success'=>$response->ok(),'body'=>$response->json()];

        } catch (\Throwable $th){

            $result['error'] = $th->getMessage();

        }

        // Send Result
        log::info('TelebgramBot->sendMessage->result',['result'=>$result]);
        return $result;
    }

    public function sendPhoto($chat_id,$image)
    {
        //Default result array
        $result = ['success'=>false,'body'=>[]];

        //Parameter API Tele
        $params = [
            'chat_id'           => $chat_id,
            'photo'           => $image,
        ];

        //Get Url For Send Image
        $url = "{$this->api_endpoint}/{$this->token}/sendPhoto";
        //Request send ()
        try{

            $response = Http::withHeaders($this->headers)->post($url,$params);
            $result = ['success'=>$response->ok(),'body'=>$response->json()];

        } catch (\Throwable $th){

            $result['error'] = $th->getMessage();

        }
        
        // Send Result
        log::info('TelebgramBot->sendPhoto->result',['result'=>$result]);
        return $result;
    }
}