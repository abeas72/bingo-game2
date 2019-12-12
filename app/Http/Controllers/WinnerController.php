<?php

namespace App\Http\Controllers;

use App\Card;
use App\Game;
use App\MyClasses\CardUtilities;
use App\ShadowCard;
use App\User;
use App\Winner;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;

class WinnerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        CardUtilities::createUsersAndGameCardsFromFile('LaloBingo.csv');
        // $playersNameAndNumbersArray = file(storage_path('LaloBingo.csv'));

        // $activeGame = Game::get()->where('active',1);
        // foreach ($playersNameAndNumbersArray as $playerNameAndNumbersArray) {
        //     $splitPlayerNameAndNumbersArray = explode(",",$playerNameAndNumbersArray);
        //     $createdEmailSubAddress = str_replace(' ','_', preg_replace( '/[^a-z0-9 ]/i', '', $splitPlayerNameAndNumbersArray[0]))."@bingo.com";
        //     $user = User::firstOrCreate(['name' => $splitPlayerNameAndNumbersArray[0]],
        //                                 ['email'    => $createdEmailSubAddress."@bingo.com", 
        //                                  'password' => $i."password",
        //                                 ]);
        //     $gameCard = Card::create(['user_id'=>$user->id,
        //                               'game_id'=>$activeGame[0]->id,
        //                               'number1'=>$splitPlayerNameAndNumbersArray[1],
        //                               'number2'=>$splitPlayerNameAndNumbersArray[2],
        //                               'number3'=>$splitPlayerNameAndNumbersArray[3],
        //                               'number4'=>$splitPlayerNameAndNumbersArray[4],
        //                               'number5'=>$splitPlayerNameAndNumbersArray[5],
        //                               'number6'=>str_replace(array("\n", "\r"), '',$splitPlayerNameAndNumbersArray[6]),
        //                               'active'=>TRUE,
        //                               'winner'=>FALSE,
        //                             ]);
        //     $shadowcard = new ShadowCard;
        //     $shadowcard->card_id = $gameCard->id;
        //     $gameCard->shadowcard()->save($shadowcard);
        // }

        //return view('winners.index',compact('path'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Winner  $winner
     * @return \Illuminate\Http\Response
     */
    public function show(Winner $winner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Winner  $winner
     * @return \Illuminate\Http\Response
     */
    public function edit(Winner $winner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Winner  $winner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Winner $winner)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Winner  $winner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Winner $winner)
    {
        //
    }
}
