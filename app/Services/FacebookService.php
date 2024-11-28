<?php

namespace App\Services;

use Facebook\Facebook;

class FacebookService
{
    protected $facebook;

    protected $graphUrl;

    public function __construct()
    {
        $this->facebook = new Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => 'v21.0', //'v16.0'
        ]);
        $this->graphUrl = 'https://graph.facebook.com/v21.0/';
    }

    public function getProfile($userId) {
        try {
            $response = $this->facebook->get(
                "/{$userId}/?fields=id,name,first_name,last_name",
                env('FACEBOOK_PAGE_ACCESS_TOKEN')
            );//?order=reverse_chronological
            return $response->getDecodedBody() ?? [];
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            return ['error' => 'Graph returned an error: ' . $e->getMessage()];
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            return ['error' => 'Facebook SDK returned an error: ' . $e->getMessage()];
        }
    }


    public function getPageProfile($userId) {
        try {
            $response = $this->facebook->get(
                "/{$userId}",
                env('FACEBOOK_PAGE_ACCESS_TOKEN')
            );//?order=reverse_chronological
            return $response->getDecodedBody() ?? [];
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            return ['error' => 'Graph returned an error: ' . $e->getMessage()];
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            return ['error' => 'Facebook SDK returned an error: ' . $e->getMessage()];
        }
    }

    public function getPostInfo($postId) {
        try {
            $response = $this->facebook->get(
                "/{$postId}",
                env('FACEBOOK_PAGE_ACCESS_TOKEN')
            );//?order=reverse_chronological
            return $response->getDecodedBody() ?? [];
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            return ['error' => 'Graph returned an error: ' . $e->getMessage()];
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            return ['error' => 'Facebook SDK returned an error: ' . $e->getMessage()];
        }
    }

    public function getLiveComments($videoId)
    {
        try {
            $response = $this->facebook->get(
                "/{$videoId}/comments",
                env('FACEBOOK_PAGE_ACCESS_TOKEN')
            );//?order=reverse_chronological
            return $response->getDecodedBody()['data'] ?? [];
        } catch (\Facebook\Exceptions\FacebookResponseException $e) {
            return ['error' => 'Graph returned an error: ' . $e->getMessage()];
        } catch (\Facebook\Exceptions\FacebookSDKException $e) {
            return ['error' => 'Facebook SDK returned an error: ' . $e->getMessage()];
        }
        
        
        // catch (\Exception $e) {
        //     return ['error' => $e->getMessage()];
        // }
    }
}
