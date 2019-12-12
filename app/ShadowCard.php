<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShadowCard extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'card_id','first_number','second_number','third_number','fourth_number','fifth_number','mega_number',
    ];

    public function card()
    {
        return $this->belongsTo('App\Card');
    }
}
