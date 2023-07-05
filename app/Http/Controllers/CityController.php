<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class CityController extends ApiController
{
    /**
     * @throws GuzzleException
     */
    public function getCounties()
    {
        $client = new Client(['base_uri'=>'https://roloca.coldfuse.io']);
        try{
           $response = $client->get('/judete');
           $data = json_decode($response->getBody()->getContents());
           return $this->successResponse($data,'Counties found with success');
        }catch (\Exception $e){
            \Log::error('Eroare judete '.$e->getMessage());
            return $this->errorResponse($e->getCode(),$e->getMessage());
        }
    }

    public function getCities($city){
        $client = new Client(['base_uri'=>'https://roloca.coldfuse.io']);
        try{
            $response = $client->get('/orase/'.$city);
            $data = json_decode($response->getBody()->getContents());
            return $this->successResponse($data,'Cities found with success');
        }catch (\Exception $e){
            \Log::error('Eroare judete '.$e->getMessage());
            return $this->errorResponse($e->getCode(),$e->getMessage());
        }
    }
}
