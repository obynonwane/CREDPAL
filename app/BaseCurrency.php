<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseCurrency extends Model
{
    //
    protected $fillable = [
        'user_id',
        'currency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
