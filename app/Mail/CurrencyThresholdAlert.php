<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CurrencyThresholdAlert extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $rate;
    public $currency;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $rate, $currency)
    {
        $this->user = $user;
        $this->rate = $rate;
        $this->currency = $currency;


        Log::info($this->user);
        Log::info($this->rate);
        Log::info($this->currency);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->subject('Credpal - Threshold Alert')->view('email.alertuser', [
            $this->user,
            $this->rate,
        ]);
    }
}
