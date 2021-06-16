<?php

namespace App\Services\Autodesk;

use Autodesk\Auth\Configuration;
use App\Services\Autodesk\ForgeConfig;
use Autodesk\Auth\OAuth2\TwoLeggedAuth;

class AuthClientTwoLegged{
    private $twoLeggedAuthInternal = null;
    private $twoLeggedAuthPublic   = null;
    
    public function __construct(){
        set_time_limit(0);
        Configuration::getDefaultConfiguration()
            ->setClientId(ForgeConfig::getForgeID())
            ->setClientSecret(ForgeConfig::getForgeSecret());
    }    

    public function getTokenPublic(){     
        if(is_null(session('AccessTokenPublic')) || session('ExpiresTime') < time() ){
            $this->twoLeggedAuthPublic = new TwoLeggedAuth();
            $this->twoLeggedAuthPublic->setScopes(ForgeConfig::getScopePublic());
            $this->twoLeggedAuthPublic->fetchToken();

            session(['AccessTokenPublic' => $this->twoLeggedAuthPublic->getAccessToken()]);
            session(['ExpiresInPublic' => $this->twoLeggedAuthPublic->getExpiresIn()]);
            session(['ExpiresTime' => time() + session('ExpiresInPublic')]);
        }

        return array(
            'access_token'  => session('AccessTokenPublic'),
            'expires_in'    => session('ExpiresInPublic'),
        );
    }

    public function getTokenInternal(){
        $this->twoLeggedAuthInternal = new TwoLeggedAuth();
        $this->twoLeggedAuthInternal->setScopes(ForgeConfig::getScopeInternal());

        if(is_null(session('AccessTokenInternal')) || session('ExpiresTime') < time() ){
            $this->twoLeggedAuthInternal->fetchToken();
            session(['AccessTokenInternal' => $this->twoLeggedAuthInternal->getAccessToken()]);
            session(['ExpiresInInternal' => $this->twoLeggedAuthInternal->getExpiresIn()]);
            session(['ExpiresTime' => time() + session('ExpiresInInternal')]);
        }

        $this->twoLeggedAuthInternal->setAccessToken(session('AccessTokenInternal'));
        return $this->twoLeggedAuthInternal;  
    }
}