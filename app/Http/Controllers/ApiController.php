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
        foreach ($users as $user) {

            echo $user->getGivenName() . '  -  ' . $user->getId() . '<br>';
        }
    }

    function getEmails()
    {
        $accessToken = $this->getAccessToken();
        $graph = new Graph();
        $graph->setAccessToken($accessToken);

        $mails = $graph->createRequest("GET", '/users/' . config('msgraph.userId') . '/mailFolders(\'Inbox\')/messages?$select=sender,subject,body&$top=50')
            ->setReturnType(Model\Message::class)
            ->execute();
        //dd($mails);
        return view('layout', ["emails" => $mails]);
    }
    function getCategorie()
    {
        $accessToken = $this->getAccessToken();
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        $categories = $graph->createRequest("GET", '/users/' . config('msgraph.userId') . '/outlook/masterCategories/')
            ->execute();
           // dd($categories);
        return view('categories', ["categories" => $categories->getBody()]);
    }
    function updateEmail()
    {
        $accessToken = $this->getAccessToken();
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        $mails = $graph->createRequest("PATCH", '/users/' . config('msgraph.userId') . '/messages/AAMkADg1MmE2NmFmLTNhMDgtNDZkZS1iZjA4LTQ0NWU1ZTU4NzkyNQBGAAAAAADbsLGKKMzxRJSVo4YtMci9BwB5T26qf8tiRrkxQjxs2P7UAAAAAAEJAAB5T26qf8tiRrkxQjxs2P7UAANWxmFuAAA=')
            ->attachBody(array("Subject" => "New Subject"))
            ->execute();
        dd($mails);
    }
    function getEmailCategorie()
    {
        $accessToken = $this->getAccessToken();
        $a = 'CQAAABYAAAB5T26qf8tiRrkxQjxs2P7UAANsyaim';
        $graph = new Graph();
        $graph->setAccessToken($accessToken);
        //$mails = $graph->createRequest("GET", '/users/' . config('msgraph.userId') . '/mailFolders(\'Inbox\')/messages?$filter=startswith(changeKey,'.'CQAAABYAAAB5T26qf8tiRr'.')')
        //$mails = $graph->createRequest("GET", '/users/' . config('msgraph.userId') . '/mailFolders(\'Inbox\')/messages?$select=sender,subject,body&$filter=categories/any(a:a eq \'Support\'')
        $mails = $graph->createRequest("GET", '/users/' . config('msgraph.userId') . '/mailFolders/AAMkADg1MmE2NmFmLTNhMDgtNDZkZS1iZjA4LTQ0NWU1ZTU4NzkyNQAuAAAAAADbsLGKKMzxRJSVo4YtMci9AQB5T26qf8tiRrkxQjxs2P7UAAAAAAEMAAA=/messages?$select=categories,sender&$top=30&$filter=categories/any(a:a eq \'Support\')')
            ->setReturnType(Model\Message::class)
            ->execute();
        dd($mails);
    }
}
