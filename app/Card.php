<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'id', 'user_id', 'game_id', 'number1','number2','number3','number4','number5','number6','active','winner','hit_count',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
    public function game()
    {
        return $this->belongsTo('App\Game');
    }

    public function shadowcard()
    {
        return $this->hasOne('App\ShadowCard');
    }

    public function winner()
    {
        return $this->hasOne('App\Winner');
    }

    public function scopeGetCards($query)
    {
        //return static::where('user_id',Auth::user()->id)->get();
        //return $query->where('user_id',Auth::user()->id);
        return $query->where('id','>',0);
        //return $query->all();
        
    }    

}
