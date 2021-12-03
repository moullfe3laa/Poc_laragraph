<?php

namespace App\Http\Controllers;


use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;

class ApiController extends BaseController
{
    function index(Request $request)
    {

        $action = $request->route('action');
        $accessToken = $this->getAccessToken();
        $this->getUsers($accessToken);


        //$accessToken = $this->getAccessToken();
        //$users = $this->getUsers($accessToken);
        //$this->getEvents($accessToken,'9fb350f8-f70c-4c4b-b98c-b857a77adb0b');
        //$this->getEmails($accessToken, '9fb350f8-f70c-4c4b-b98c-b857a77adb0b');
    }

    public function getAccessToken()
    {
        $guzzle = new \GuzzleHttp\Client();
        $url = 'https://login.microsoftonline.com/' . config('msgraph.tenantId') . '/oauth2/token?api-version=1.0';
        $token = json_decode($guzzle->post($url, [
            'form_params' => [
                'client_id' => config('msgraph.clientId'),
                'client_secret' => config('msgraph.clientSecret'),
                'resource' => 'https://graph.microsoft.com/',
                'grant_type' => 'client_credentials',
            ],
        ])->getBody()->getContents());
        $accessToken = $token->access_token;
        return $accessToken;
    }
    public function getUsers()
    {
        $accessToken = $this->getAccessToken();
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        $users = $graph->createRequest("GET", "/users")
            ->setReturnType(Model\User::class)
            ->execute();
        dd($users);
            // return view('show', ["users"=>$users]);
    }

    function getEmails()
    {
        $accessToken = $this->getAccessToken();
        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        $mails = $graph->createRequest("GET", '/users/' . config('msgraph.userId') . '/mailFolders(\'Inbox\')/messages?$select=sender,subject,body')
            ->setReturnType(Model\Message::class)
            ->execute();
           // dd($mails);
            return view('layout', ["emails"=>$mails]);
    }
}
