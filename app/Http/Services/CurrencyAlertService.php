<?php

namespace App\Http\Services;

use App\Threshold;
use App\BaseCurrency;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use App\Mail\CurrencyThresholdAlert;
use Exception;
use Illuminate\Support\Facades\Mail;

class CurrencyAlertService
{
    //
    public $client;
    public $httpClient;

    public function __construct()
    {
        $this->client = new Client();
    }
    public function checkThreshholdAndalert()
    {
        try {
            //Get all threshhold
            $threshhold = Threshold::all();

            //loop through threshhold
            foreach ($threshhold as $item) {

                //call fixerIo API to check currency rate as against alert threshold
                $threshold_rate = $this->callFixerIO($item->currency);

                // if current current rate is equal to alert threshold, send mail to notify user
                if ($threshold_rate >= $item->alert_threshhold) {

                    Mail::to($item->user->email)->send(new CurrencyThresholdAlert($item->user, $threshold_rate, $item->currency));
                }
            }
        } catch (Exception $e) {
            Log::error($e);
        }
    }

    public function callFixerIO($currency)
    {
        // FixerIo API Key
        $access_key = env('FIXER_ACCESS', 'default_value');

        //Make Request to FixerIo aPi
        $response = $this->client->post('http://data.fixer.io/api/latest', [
            'query' => [
                'access_key' => $access_key,
            ],
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);

        //Decode Response
        $responseFormated = json_decode($response->getBody()->getContents(), TRUE);

        //Extract the threshold currency set by the user 
        $getCurrencyRate = $responseFormated['rates'][$currency];

        //return currency rate
        return $getCurrencyRate;
    }
}
