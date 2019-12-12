<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Game;
use App\User;
use Auth;

class SelectCardController extends CardController
{
    public function index()
    {
        //dd("in Selct Class Controller");
       $users = User::all('id','name');
       $games = Game::all('id','start_date','end_date');
        
        // $request = ($_REQUEST);
        // $thePot ="Not 20";
        //  if($request['money_pot']=="20")
        //      $thePot = "it is 20";
        return view('cards.select_index',compact('users','games'));
    }
    public function create()
    {
        return redirect()->route('cards.select_index');
    }
}