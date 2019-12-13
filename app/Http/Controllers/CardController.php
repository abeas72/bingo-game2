<?php

namespace App\Http\Controllers;
use Auth;
use App\Card;
use App\DrawResult;
use App\Game;
use App\MyClasses\CardUtilities;
use App\User;
use App\ShadowCard;
use App\Winner;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;


class CardController extends Controller
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
        // $clickedUri=$_SERVER['REQUEST_URI'];
        // //dd($clickedUri);
        // if($clickedUri=="/cards/current_cards")
        // {
        //     dd("Current Cards");
        // }
        // elseif ($clickedUri=="/cards/all_cards") 
        // {
        //     dd("All Cards");
        // }
        // elseif ($clickedUri=="/cards/my_cards") 
        // {
        //     dd("My Cardssss");
        // }
        // elseif ($clickedUri=="/cards/select_cards") 
        // {
        //    // return view('cards.create_select');
        //    dd("innnnnnnn Seeleeect");
        // }        
        
        //$activeGame = Game::get()->where('active',1)[0];
        //$activeGame = Game::get()->where('active',1);


        // $activeGame = Game::firstOrFail()->where('active', TRUE)->get();
        
        // if($activeGame->isNotEmpty())
        // {
        //     $activeGame = $activeGame[0];
        //     $groupedCardsByUserID = Card::get()->where('game_id',$activeGame->id)->groupBy('user_id');
        //     $winners = Winner::get()->where('game_id',$activeGame->id);
           
        // }
           
        // else 
        // {
        //     $groupedCardsByUserID = collect([]);
        //     $winners = collect([]);
            
        // }
        // return view('cards.index', compact('groupedCardsByUserID','winners','activeGame'));
 
                
        //$groupedCardsByUserID = Card::get()->where('game_id',$activeGame->id)->groupBy('user_id');
        //dd($groupedCardsByUserID);
        //$winners = Winner::get()->where('game_id',$activeGame->id);

        try {
            $activeGame = Game::firstOrFail()->where('active', TRUE)->get();

            $activeGame = $activeGame[0];
            $groupedCardsByUserID = Card::get()->where('game_id',$activeGame->id)->groupBy('user_id');
            $winners = Winner::get()->where('game_id',$activeGame->id);
            return view('cards.index', compact('groupedCardsByUserID','winners','activeGame'));
        } catch (ModelNotFoundException $ex) {
            //dd($ex);
            $groupedCardsByUserID = collect([]);
            $winners = collect([]);
            return view('cards.index', compact('groupedCardsByUserID','winners','activeGame'));
            //dd("No Active Game Found");
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $users = User::all('id','name');
       $games = Game::all('id','start_date','end_date');
       return view('cards.create',compact('users','games'));
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
            'user_id' => 'required',
            'game_id' => 'required',
            'number1' => 'required|integer|between:1,47|different:number2|different:number3|different:number4|different:number5|different:number6',
            'number2' => 'required|integer|between:1,47|different:number3|different:number4|different:number5|different:number6',
            'number3' => 'required|integer|between:1,47|different:number4|different:number5|different:number6',
            'number4' => 'required|integer|between:1,47|different:number5|different:number6',
            'number5' => 'required|integer|between:1,47|different:number6',
            'number6' => 'required|integer|between:1,47',
            'active'  => 'required',
            'winner'  => 'required',
            'hit_count'  => 'required',
        ]);
        
        // $user = User::find(1);
        // $profile = new UserProfile;
        // $profile->address = "Some address in New York";
        // $user->profile()->save($profile);

        $gameCard = Card::create($request->all());
        $shadowcard = new ShadowCard;
        $shadowcard->card_id = $gameCard->id;
        $gameCard->shadowcard()->save($shadowcard);

        $currentGameDrawResults = DrawResult::get()->where('game_id',$request['game_id']);
        CardUtilities::checkOneCurrentGameCardAgainstAllCurrentGameDrawnNumbers($gameCard,$currentGameDrawResults);
        //if(CardUtilities::isWinner($gameCard))
            //set Winner/s to winner table


        $game = Game::find($request['game_id']);
        $game->money_pot = $game->money_pot + 20;
        $game->save();

        return redirect()->route('cards.index')
                         ->with('success','Game Card created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //dd($card);
        return view('cards.show',compact('card'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        $users = User::all('id','name');
        $games = Game::all('id','start_date','end_date');
        return view('cards.edit',compact('card','users','games'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        $request->validate([
            'user_id' => 'required',
            'game_id' => 'required',
            'number1' => 'required|integer|between:1,47|different:number2|different:number3|different:number4|different:number5|different:number6',
            'number2' => 'required|integer|between:1,47|different:number3|different:number4|different:number5|different:number6',
            'number3' => 'required|integer|between:1,47|different:number4|different:number5|different:number6',
            'number4' => 'required|integer|between:1,47|different:number5|different:number6',
            'number5' => 'required|integer|between:1,47|different:number6',
            'number6' => 'required|integer|between:1,47',
            'active' => 'required',
            'winner' => 'required',
        ]);
   
        $card->update($request->all());
        return redirect()->route('cards.index')
                        ->with('success','Game Card updated successfully.');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy(Card $card)
    {
        $card->delete();
  
        return redirect()->route('cards.index')
                        ->with('success','Game card deleted successfully');
    }

    

    public function getCards($whatCards)
    {
        
        //dd(card);
        //$allMyCards = Card::where('user_id',1)->get();
        //$allMyCards = Card::all()->where('id',2);
        //dd($allMyCards);
        //$allMyCards = Card::where('user_id',Auth::user()->id);
        /*$allMyCards = Card::all();

        foreach ($allMyCards as $flight) {
            if ($flight->user_id==Auth::user()->id)
              echo $flight->num1." ";
        }*/
        //$cardss = DB::table('cards')->get();
        //$cardss = DB::table('cards')->where('user_id', Auth::user()->id);

        $theCards = New Card;
        //$theCards = $theCards->GetCards()->get();
        //dd($theCards);
        //dd(Card::returnAllMyCards()->all()->where('id',1));
        //dd(Auth::user()->id);
        ////////dd($allMyCards);
        if ($whatCards==1)//1 = current player's active cards
        {    /*dd(Card::GetCards()
             ->where('user_id', Auth::user()->id)
             ->where('isActive',1)->get());*/
            $theCards = $theCards->GetCards()
                            ->where('user_id', Auth::user()->id)
                            ->where('active',1)
                            ->get();
            return view('cards.index')->with('theCards',$theCards);
        }
        // return view('cards.index');
        elseif ($whatCards==2) //2 = all current player's cards
        {
            //dd(Card::GetCards()->where('user_id', Auth::user()->id)->get());
            $theCards = $theCards->GetCards()->
                            where('user_id', Auth::user()->id)
                            ->get();
            return view('cards.index')->with('theCards',$theCards);
        }
        elseif ($whatCards==3)//do this if var 3 to get all player's active cards
        {     
            $theCards = $theCards->GetCards()
                            ->where('active',1)
                            ->get();
            return view('cards.index')->with('theCards',$theCards);
            //dd(Card::GetCards()->where('isActive',1)->get());
        }
        else //do this if var 4 to get all player's cards
        {
            $theCards = $theCards->GetCards()->get();
            return view('cards.index')->with('theCards',$theCards);
           // foreach($theCards as $theCard)
           // {
           //     echo $theCard->user['name']."<br>";
           // }
            
        }
    }
    public function testSelect()
    {
        $request = ($_REQUEST);
        //dd($request['hit_count']);
        //$users = User::all('id','name')->grouby('name');
        $users = User::orderBy('name', 'asc')->get();
        $games = Game::all('id','start_date','end_date');
        $errorMessage="Nothing Has Been Selected";
         // $request = ($_REQUEST);   //dd($request);
        if (sizeOf($request)!=0)
        {  
            if(($request['game_id']==null)  && ($request['user_id']==null && ($request['hit_count']==null) ))//get all cards for all games
            {
                $groupedCardsByUserID = Card::all()->groupby('game_id');
                //dd($groupedCardsByUserID);
                //dd($selectedCards);
            }
            elseif(($request['game_id']!=null)  && ($request['user_id']!=null) && ($request['hit_count']==null))//get all cards for selected player and selected game 
            {
                $groupedCardsByUserID = Card::get()->where('user_id',$request['user_id'])->where('game_id','=',$request['game_id'])->groupby('game_id');
               //dd($groupedCardsByUserID);
            }
            elseif(($request['game_id']!=null)  && ($request['user_id']==null) && ($request['hit_count']==null))////get all cards for selected game
            {
                $groupedCardsByUserID = Card::get()->where('game_id',$request['game_id'])->groupby('game_id');
               // dd($groupedCardsByUserID);
            }
            elseif(($request['game_id']==null)  && ($request['user_id']!=null) && ($request['hit_count']==null))//get all cards for selected player from all  games
            {
                $groupedCardsByUserID = Card::get()->where('user_id',$request['user_id'])->groupBy('game_id');
                //dd($groupedCardsByUserID);
            }
            elseif(($request['game_id']!=null) && ($request['user_id']==null) && ($request['hit_count']!=null))
            {
                $groupedCardsByUserID = Card::get()->where('hit_count',$request['hit_count'])->groupBy('game_id');
            }
            elseif(($request['game_id']==null) && ($request['user_id']!=null) && ($request['hit_count']!=null))
            {
                $groupedCardsByUserID = Card::get()->where('user_id',$request['user_id'])->where('hit_count',$request['hit_count'])->groupBy('game_id');
            } 
            elseif(($request['game_id']==null) && ($request['user_id']==null) && ($request['hit_count']!=null))
            {
                $groupedCardsByUserID = collect([]);
            }
            elseif(($request['game_id']!=null) && ($request['user_id']!=null) && ($request['hit_count']!=null))
            {
                $groupedCardsByUserID = Card::get()->where('game_id',$request['game_id'])->where('user_id',$request['user_id'])->where('hit_count',$request['hit_count'])->groupBy('game_id');
                
            }

            // elseif(($request['game_id']==null)  && ($request['hitCount']!=null))
            // {
            //     $groupedCardsByUserID = Card::get()->where('hit_count',$request['hit_count'])->groupby('game_id');
            // }
            // elseif(($request['game_id']!=null)  && ($request['hitCount']!=null))
            // {
            //     $groupedCardsByUserID = Card::get()>where('game_id',$request['game_id'])->where('hit_count',$request['hit_count'])->groupby('game_id');
            // } 
        }
        else        
            //$groupedCardsByUserID = Card::all()->groupby('game_id');//default- get all cards for all games
            $groupedCardsByUserID = collect([]);//Default to Empty Collection- Nothing has been Selected
            //dd("nothing");
            
        
        return view('cards.select_index',compact('groupedCardsByUserID','users','games','errorMessage'));

    }

}
