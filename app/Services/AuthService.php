<?php

namespace App\Services;

use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ResponseInterface;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;

class AuthService
{
    public function authenticate( string $email, string $password ) : array
    {
        $response = $this->issueTokenRequest([
            'username'      => $email,
            'password'      => $password,
            'grant_type'    => 'password',
            'client_id'     => env( 'PASSPORT_CLIENT_ID' ),
            'client_secret' => env( 'PASSPORT_CLIENT_SECRET' ),
            'scope'         => '*',
        ]);
 
        return $response['body'];
    }

    public function refreshToken( string $refresh_token ) : object
    {
        $response = $this->issueTokenRequest([
            'refresh_token' => $refresh_token,
            'grant_type'    => 'refresh_token',
            'client_id'     => env( 'PASSPORT_CLIENT_ID' ),
            'client_secret' => env( 'PASSPORT_CLIENT_SECRET' ),
        ]);

        return (object) [
            'status' => $response['status'],
            'tokens' => $response['body']
        ] ;
    }

    private function issueTokenRequest( array $payload ) : array
    {
        $request = Request::create(config('app.url').'/oauth/token', 'POST', $payload);
        $psrRequest = (new PsrHttpFactory)->createRequest($request);
        $response = app(AccessTokenController::class)->issueToken(
            $psrRequest,
            app(ResponseInterface::class)
        );

        return [
            'status' => $response->getStatusCode(),
            'body' => json_decode($response->getContent(), true) ?? [],
        ];
    }
}
