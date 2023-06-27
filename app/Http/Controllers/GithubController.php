<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GithubController extends Controller
{
    //
    public function index()
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->request('GET', ' https://api.github.com/repositories');

        $response = json_decode($response->getBody()->getContents());

        return $response;
    }
}
