<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Game extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'card_id','start_date','end_date','active','money_pot',
    ];
         
    public function cards()
    {
        return $this->hasMany('App\Card');
    }

    public function drawresults()
    {
        return $this->hasMany('App\DrawResult');
    }

    public function winners()
    {
        return $this->hasMany('App\Winner');
    }

    public function formatPrizeAmount()
    {
        return "$".number_format($this->money_pot);
    }

    public function playersForThisGame()
    {
        return $this->cards->count();
    }

}
