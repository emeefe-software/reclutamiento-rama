<?php
namespace App\Library;
use GuzzleHttp\Client;

class Recaptcha{

    public static function validateToken(string $token){
        if(config('app.env') == 'local'){
            return self::validateLocalToken($token);
        }

        return self::validateTokenOnGoogleApi($token);
    }

    private static function validateLocalToken(string $fakeToken){
        return true;
    }

    private static function validateTokenOnGoogleApi(string $token){
        $client = new Client();

        $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret' => config('recaptcha.secret'),
                'response' => $token
            ]
        ]);

        $data = json_decode($response->getBody(), true);
        return isset($data['success']) && $data['success'];
    }

}