<?php

namespace App\Http\Controllers;

use Exception;
use App\BaseCurrency;


use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\BaseCurrencyException;
use App\Http\Services\CurrencyAlertService;
use App\Http\Requests\setBaseCurrencyRequest;

class BaseCurrencyController extends Controller
{
    //
    public $client;
    public $httpClient;

    public function __construct()
    {
        $this->client = new Client();
    }

    //@desc     User set base currency
    //@route    POST api/addcurrency
    //@access   Private
    public function setBaseCurreency(setBaseCurrencyRequest $request)
    {
        try {
            //Get logged-in user
            $user = Auth::user();
            //check if user in db - table
            $user_exist = BaseCurrency::where('user_id', $user->id)->first();

            //if user in table update record
            if ($user_exist) {
                $user_exist->update([
                    'currency' => $request->currency,
                ]);
            } else {
                //if user not in table create new record
                $currency =   BaseCurrency::create([
                    'user_id' => $user->id,
                    'currency' => $request->currency,
                ]);
            }

            //return response upon succesfful update
            return response()->json([
                "status" => true,
                "messaage" => "Base currency set succesfully"
            ]);
        } catch (Exception $e) {

            //throw exception if error
            Log::error($e);
            throw new BaseCurrencyException();
        }
    }


    //@desc     Get rates for diffrency for base currency
    //@route    GET api/rates
    //@access   Private
    public function rates()
    {

        //extract base currency
        $base_currency =  Auth::user()->basecurrency->currency;

        //API Key for FixerIO
        $access_key = env('FIXER_ACCESS', 'default_value');

        //make PI call to FixerIO API
        $response = $this->client->post('http://data.fixer.io/api/latest', [
            'query' => [
                'access_key' => $access_key,
                'base' => $base_currency
            ],
            'headers' => [
                'Accept' => 'application/json',
            ]
        ]);

        //Return response for currencies and their rates
        return $response = json_decode($response->getBody()->getContents(), TRUE);
    }


    //@desc     Manually Trigger sending alert to users on currency rate based on their settings
    //@route    POST api/rates
    //@access   Private
    public function checkThreshold()
    {
        $alertService = new CurrencyAlertService();
        $alertService->checkThreshholdAndalert();
    }
}
