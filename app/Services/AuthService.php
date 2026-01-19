<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class AuthService
{
    public function authenticate( string $email, string $password ) : array
    {
        $response = Http::asForm()->post( env( 'APP_URL' ) . '/oauth/token', [
            'username'      => $email,
            'password'      => $password,
            'grant_type'    => 'password',
            'client_id'     => env( 'PASSPORT_CLIENT_ID' ),
            'client_secret' => env( 'PASSPORT_CLIENT_SECRET' ),
            'scope'         => '*',
        ] );
 
        return $response->json();
    }
}