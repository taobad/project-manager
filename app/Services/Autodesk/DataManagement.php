<?php

namespace App\Services\Autodesk;

use App\Services\Autodesk\ForgeConfig;
use Autodesk\Forge\Client\Api\BucketsApi;
use Autodesk\Forge\Client\Api\ObjectsApi;
use Autodesk\Forge\Client\Model\PostBucketsPayload;

class DataManagement{
    protected $twoLeggedAuth = null;

    public function __construct(){
        set_time_limit(0);
    }

    public function createOneBucket(){
        $this->twoLeggedAuth = new AuthClientTwoLegged();
        $accessToken = $this->twoLeggedAuth->getTokenInternal();

        // get the request body
        $body = json_decode(file_get_contents('php://input', 'r'), true);

        $bucketKey = ForgeConfig::$prepend_bucketkey?(strtolower(ForgeConfig::getForgeID()).'_'.$body['bucketKey']):$body['bucketKey'];
        // $policeKey = $body['policyKey'];
        $policeKey = "transient";
        
        $apiInstance = new BucketsApi($accessToken);
        $post_bucket = new PostBucketsPayload();
        $post_bucket->setBucketKey($bucketKey);
        $post_bucket->setPolicyKey($policeKey);

        try { 
            $result = $apiInstance->createBucket($post_bucket);
            print_r($result);
        } catch (Exception $e) {
            echo 'Exception when calling BucketsApi->createBucket: ', $e->getMessage(), PHP_EOL;
        }
    }


      /////////////////////////////////////////////////////////////////////////
    public function getBucketsAndObjects(){
        $this->twoLeggedAuth = new AuthClientTwoLegged();
        $accessToken = $this->twoLeggedAuth->getTokenInternal();

         $id = $_GET['id'];
         try{
             if ($id === '#') {// root
                 $apiInstance = new BucketsApi($accessToken);
                 $result = $apiInstance->getBuckets();
                 $resultArray = json_decode($result, true);
                 $buckets = $resultArray['items'];
                 $bucketsLength = count($buckets);
                 $bucketlist = array();
                 for($i=0; $i< $bucketsLength; $i++){
                     $cbkey = $buckets[$i]['bucketKey'];
                     $exploded = explode('_', $cbkey);
                     $cbtext = ForgeConfig::$prepend_bucketkey&&strpos($cbkey, strtolower(ForgeConfig::getForgeID())) === 0? end($exploded):$cbkey;
                     $bucketInfo = array('id'=>$cbkey,
                                         'text'=> $cbtext,
                                         'type'=>'bucket',
                                         'children'=>true
                     );
                     array_push($bucketlist, $bucketInfo);
                 }
                 print_r(json_encode($bucketlist));
             }
             else{
                 $apiInstance = new ObjectsApi($accessToken);
                 $bucket_key = $id;
                 $result = $apiInstance->getObjects($bucket_key);
                 $resultArray = json_decode($result, true);
                 $objects = $resultArray['items'];

                 $objectsLength = count($objects);
                 $objectlist = array();
                 for($i=0; $i< $objectsLength; $i++){
                     $objectInfo = array('id'=>base64_encode($objects[$i]['objectId']),
                                         'text'=>$objects[$i]['objectKey'],
                                         'type'=>'object',
                                         'children'=>false
                     );
                     array_push($objectlist, $objectInfo);
                 }
                 print_r(json_encode($objectlist));
             }
         }catch(Exception $e){
             echo 'Exception when calling ObjectsApi->getObjects: ', $e->getMessage(), PHP_EOL;
         }

      }


      public function uploadFile(){
        $this->twoLeggedAuth = new AuthClientTwoLegged();
          $accessToken = $this->twoLeggedAuth->getTokenInternal();
          // $body = file_get_contents('php://input', 'r');
          // var_dump($body);

          $body = $_POST;
          $file = $_FILES;
          // $_SESSION['file'] = $file;
          // var_dump($_SESSION['file']);die;
          // var_dump($_FILES);die;
          // die;

          $apiInstance = new ObjectsApi($accessToken);
          $bucket_key  = $body['bucketKey'];
          $fileToUpload    = $file['fileToUpload'];
          $filePath = $fileToUpload['tmp_name'];
          $content_length = filesize($filePath);
          $file_content = file_get_contents($filePath);

          // $fileRead = fread($filePath, $content_length);

          try {
            $result = $apiInstance->uploadObject($bucket_key, $fileToUpload['name'], $content_length, $file_content);
            print_r($result);
          } catch (Exception $e) {
            echo 'Exception when calling ObjectsApi->uploadObject: ', $e->getMessage(), PHP_EOL;
          }
      }
}
