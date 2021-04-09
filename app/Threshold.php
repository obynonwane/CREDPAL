<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Threshold extends Model
{
    //
    protected $fillable = [
        'user_id',
        'currency',
        'alert_threshhold',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
