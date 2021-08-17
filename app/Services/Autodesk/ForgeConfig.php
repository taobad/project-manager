<?php

namespace App\Services\Autodesk;

class ForgeConfig{
    private static $forge_id = null;
    private static $forge_secret = null;
    public static $prepend_bucketkey = true;

    public static function getForgeID(){
        return config('autodesk.forge_id');
    }

    public static function getForgeSecret(){
        return config('autodesk.forge_secret');
    }

    // Required scopes for your application on server-side
    public static function getScopeInternal(){
        return ['bucket:create', 'bucket:read', 'data:read', 'data:create', 'data:write'];
    }

    // Required scope of the token sent to the client
    public static function getScopePublic(){
        // Will update the scope to viewables:read when #13 of autodesk/forge-client is fixed
        return ['data:read'];
    }

}