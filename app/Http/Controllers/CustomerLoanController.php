<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateLoanInput;
use Illuminate\Http\Request;

class CustomerLoanController extends Controller
{

    //@desc     This calculates loan repayment for user
    //@route    POST api/loan
    //@access   Public
    public function calculateloan(ValidateLoanInput $request)
    {
        $all_monthly_payments_made = [];
        //1. calculate interest 
        $interest = ($request->amount / 100) * $request->interest;

        //2. calculate total amount payable plus interest
        $total_amount = $request->amount + $interest;

        //3. spread total amount  across tenure
        $monthly_payment = $total_amount / $request->tenure;

        //4. Loop through tenure period to assign amount payable for each month
        for ($x = 1; $x <= $request->tenure; $x++) {

            //5. Declare array to hold details for each month
            $monthly_payment_made = [];

            //6. Declare key to identify each month of payement representing payment made
            $key = 'Month' . ' ' . $x;

            //7. Push payment date to array
            $monthly_payment_made['payment_date'] = $request->repayment_day . 'th' . ' ' . 'day of the month';

            //8. push amount to array 
            $monthly_payment_made['amount'] = round($monthly_payment, 2);

            //9. push each tenure payment to array holding all payment made in each month
            $all_monthly_payments_made[$key] = $monthly_payment_made;
        }

        //return response
        return response()->json([
            "Total" => $total_amount,
            "Payments" => $all_monthly_payments_made
        ]);
    }
}
