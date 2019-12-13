<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\MyClasses\CardUtilities;
use phpDocumentor\Reflection\Types\Integer;

class GameController extends Controller
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
        //dd($_SERVER['REQUEST_URI']);
        // if($_SERVER['REQUEST_URI']!= "/games")
        //     dd("not");
        // else
        //     dd("is");
        $games = Game::all();
        //$games->drawresults->where('game_id',5);
       // dd($games[0]->drawresults->count());
        return view('games.index',compact('games'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('games.create');
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
            'start_date' => 'required|date',
            'active' => 'required|integer',
            'money_pot' => 'required|integer',
        ]);
   
        Game::create($request->all());
        return redirect()->route('games.index')
                         ->with('success','Game created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        return view('games.show',compact('game'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Game $game)
    {
        return view('games.edit',compact('game'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        $request->validate([
            'start_date' => 'required|date',
            'active' => 'required|integer',
            'money_pot' => 'required|integer',
            'closed' => 'required',
        ]);
   
        $game->update($request->all());
        return redirect()->route('games.index')
                         ->with('success','Game updated successfully.');
    }        
    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        $game->delete();
  
        return redirect()->route('games.index')
                        ->with('success','Game deleted successfully');
    }
    public function addCardsPlayers()
    {
        $gameFile = 'LaloBingo.csv';                     
        CardUtilities::createUsersAndGameCardsFromFile($gameFile);
    }
}
