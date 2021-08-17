<?php

namespace App\Services\Autodesk;

use App\Services\Autodesk\AuthClientTwoLegged;

class AccessToken{
    protected $accessToken = null;

    public function __construct(){
        set_time_limit(0);
    }    

    public function getAccessToken(){
        $twoLeggedAuth = new AuthClientTwoLegged();
        try{
            if(is_null($this->accessToken)){
                $this->accessToken = $twoLeggedAuth->getTokenPublic();
            }

            print_r( json_encode($this->accessToken));
        }catch (Exception $e) {
            echo 'Exception when calling twoLeggedAuth->getTokenPublic: ', $e->getMessage(), PHP_EOL;
        }
    }
}