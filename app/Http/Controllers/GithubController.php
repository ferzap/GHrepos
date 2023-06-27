<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GithubController extends Controller
{
    //
    public function index()
    {
        $github_token = env('GITHUB_TOKEN');
        $ch = curl_init();
        $headers = array(
            'Accept: application/vnd.github+json',
            "Authorization: Bearer $github_token" ,
            "X-GitHub-Api-Version: 2022-11-28",
            "User-Agent: ferzap"
        );

        // print_r($ch);die;
        curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/user/repos');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST , "GET");
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);

        curl_close($ch);

        $results = json_decode($response);

        $arrRepo = [];
        foreach ($results as $key => $value) {
            $repo = array(
                'id' => $value->id,
                "name" => $value->name,
                "fullName" => $value->full_name,
                "link" => $value->html_url
            );
            $arrRepo[] = $repo;
        }

        return response()->json([
            "data" => $arrRepo
        ]);
    }
}
