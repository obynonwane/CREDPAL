<?php

namespace App\Http\Controllers;

use Exception;
use App\Threshold;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Exceptions\ThresholdException;
use App\Http\Requests\setThresholdRequest;


class ThresholdController extends Controller
{
    //

    //@desc     User can set threshold of aa currency and recive alert at some hits threshhold
    //@route    POST api/threshold
    //@access   Private
    public function setThreshold(setThresholdRequest $request)
    {
        try {
            //get the Loggedin Users
            $user = Auth::user();

            //Check if the user exist in Db
            $user_exist = Threshold::where('user_id', $user->id)->first();

            //If user alreaady exist in table update record
            if ($user_exist) {
                $user_exist->update([
                    'currency' => $request->currency,
                    'alert_threshhold' => $request->alert_threshhold

                ]);
            } else {
                //if user is not in table create new record
                $currency =   Threshold::create([
                    'user_id' => $user->id,
                    'currency' => $request->currency,
                    'alert_threshhold' => $request->alert_threshhold
                ]);
            }

            //return response on successful updaate
            return response()->json([
                "status" => true,
                "messaage" => "Currency Threshold set successfully"
            ]);
        } catch (Exception $e) {

            //throw an exception on error
            Log::error($e);
            throw new ThresholdException();
        }
    }
}
