<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DrawResult;
use App\Game;
use App\Card;
use App\MyClasses\CardUtilities;
use App\Winner;

//use App\MyClasses\CardUtilities;

//use CheckCards;

//use App\MyClasses\CardUtilities;
//use App\ShadowCard;
//use App\MyClasses\CardUtilites;

class DrawResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
     
    public function index()
    {
        //dd(date("M jS, Y", strtotime('2019-12-15')));
        $drawresults = DrawResult::all();
        return view('drawresults.index', compact('drawresults'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $games = Game::all('id','start_date','end_date');
        return view('drawresults.create',compact('games'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_id'       => 'required',
            'draw_number'   => 'required',
            'first_number'  => 'required|integer|between:1,47|different:second_number|different:third_number|different:fourth_number|different:fifth_number',
            'second_number' => 'required|integer|between:1,47|different:third_number|different:fourth_number|different:fifth_number',
            'third_number'  => 'required|integer|between:1,47|different:fourth_number|different:fifth_number',
            'fourth_number' => 'required|integer|between:1,47|different:fifth_number',
            'fifth_number'  => 'required|integer|between:1,47',
            'mega_number'   => 'required|integer|between:1,27',
            'prize_amount'  => 'integer',
            'draw_date'     => 'required|date',
        ]);
        
        //dd(date("M jS, Y", strtotime($request['draw_date']))); works
        //dd(date("F jS, Y", strtotime('11-12-10')));
       // dd(date('F d, Y', $request['draw_date']));
        //dd($request['pathInfo']);
       // dd($_SERVER['REQUEST_URI']);
        DrawResult::create($request->all());

        $currentGameDrawResults = DrawResult::get()->where('game_id',$request['game_id']);
        $currentGameCards = Card::get()->where('game_id',$request['game_id']);
        
        CardUtilities::checkAllCurrentGameCardsAgainstAllCurrentGameDrawnNumbers($currentGameCards,$currentGameDrawResults);
        
        //Are there winners for this game? If so, close Game
        
        $currentGameWinners = Winner::where('game_id',$request['game_id'])->first();

        if(!empty($currentGameWinners))
            Game::find($request['game_id'])->update(['end_date' => $request['draw_date']]);
        
        //Call View for DrawResult
        return redirect()->route('drawresults.index')
                           ->with('success','Draw Results created successfully.');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DrawResult $drawresult)
    {
        return view('drawresults.show',compact('drawresult'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(DrawResult $drawresult)
    {
        $games = Game::all('id','start_date','end_date');
        return view('drawresults.edit',compact('drawresult','games'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DrawResult $drawresult)
    {
        $request->validate([
            'game_id'       => 'required',
            'draw_number'   => 'required',
            'first_number'  => 'required|integer|between:1,47|different:second_number|different:third_number|different:fourth_number|different:fifth_number',
            'second_number' => 'required|integer|between:1,47|different:third_number|different:fourth_number|different:fifth_number',
            'third_number'  => 'required|integer|between:1,47|different:fourth_number|different:fifth_number',
            'fourth_number' => 'required|integer|between:1,47|different:fifth_number',
            'fifth_number'  => 'required|integer|between:1,47',
            'mega_number'   => 'required|integer|between:1,27',
            'prize_amount'  => 'integer',
            'draw_date'     => 'required|date',
        ]);
   
        $drawresult->update($request->all());
        
        $gameID=$drawresult->game_id;
        //$currentGameDrawResults= DrawResult::findOrFail('game_id',$drawresult->game_id);
        $currentGameDrawResults = DrawResult::get()->where('game_id',$gameID);
        $currentGameCards = Card::get()->where('game_id',$gameID);

        if($currentGameDrawResults->count()==0) 
            CardUtilities::resetAllCurrentGameShadowCards($currentGameCards); 
        else     
        {
          // dd($currentGameCards->toJson(JSON_PRETTY_PRINT));
            CardUtilities::resetAllCurrentGameShadowCards($currentGameCards);
            CardUtilities::checkAllCurrentGameCardsAgainstAllCurrentGameDrawnNumbers($currentGameCards,$currentGameDrawResults);
        }

        return redirect()->route('drawresults.index')
                         ->with('success','Draw Result updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(DrawResult $drawresult)
    {   
        //NEED TO CLEAR Winners 12-12-19 - Reset Game Close attribute to False
        $drawresult->delete();

        $gameID=$drawresult->game_id;
        //$currentGameDrawResults= DrawResult::findOrFail('game_id',$drawresult->game_id);
        $currentGameDrawResults = DrawResult::get()->where('game_id',$gameID);
        $currentGameCards = Card::get()->where('game_id',$gameID);

        if($currentGameDrawResults->count()==0) 
            CardUtilities::resetAllCurrentGameShadowCards($currentGameCards); 
        else     
        {
          // dd($currentGameCards->toJson(JSON_PRETTY_PRINT));
            CardUtilities::resetAllCurrentGameShadowCards($currentGameCards);
            CardUtilities::checkAllCurrentGameCardsAgainstAllCurrentGameDrawnNumbers($currentGameCards,$currentGameDrawResults);
        }
       //$currentGameCards = Card::get()->where('game_id',$drawresult->game_id);
       //dd($currentGameDrawResults);
        return redirect()->route('drawresults.index')
                        ->with('success','Draw Result deleted successfully');
    }

    public function checkOffGameCards($drawNumbers, $currentGameCards)
    {
    //    if (!$currentGameCards->isEmpty())
    //    {
            $cardUtilities = new CardUtilities;
            $cardUtilities->checkOffAllCardsForCurrentGame($drawNumbers,$currentGameCards);
            // foreach ($groupedcards as $card) 
            // {
            //     $hitCount = 0 ; 
            //     $theCard = new CardUtilities;
            //     $theCard->checkOffCardForCurrentGame($drawNumbers,$card);
            // }          
    //    }
    //    else
    //    {
    //        print("No Cards");
    //    }
           
    }
}
