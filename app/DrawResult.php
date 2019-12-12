<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DrawResult extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'game_id','draw_number','first_number','second_number','third_number','fourth_number','fifth_number','mega_number','prize_amount','rollover','draw_date',
    ];


    public function game()
    {
        return $this->belongsTo('App\Game');
    }


    public function formatPrizeAmount()
    {
        return "$".number_format($this->prize_amount);
    }
}
