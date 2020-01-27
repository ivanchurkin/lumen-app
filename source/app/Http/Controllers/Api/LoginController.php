<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password', 'secret');

        $http = new Client();

        $response = $http->post('http://webserver.test/oauth/token', [
            'form_params' => [
                'grant_type' => 'password',
                'client_id' => '1',
                'client_secret' => $credentials['secret'],
                'username' => $credentials['email'],
                'password' => $credentials['password'],
                'scope' => '',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }
}
