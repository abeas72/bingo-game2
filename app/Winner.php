<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Winner extends Model
{
    Use SoftDeletes;
    protected $fillable = [
        'id', 'user_id'  ,'card_id', 'game_id',
    ];

    public function game()
    {
        return $this->belongsTo('App\Game');
    }
    public function card()
    {
        return $this->belongsTo('App\Card');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
