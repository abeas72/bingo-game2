<?php

namespace App\MyClasses;

use App\Card;
use App\Game;
use App\ShadowCard;
use App\User;
use App\Winner;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CardUtilities{
    private static $hitCount;

    function __construct($hitCount) {
        self::$hitCount = 0;
    }


    
    public static function extractOnlyCurrentGameDrawnNumbersToACollectionFromCollection($oneCurrentGameDrawnNumbersCollection)
    {
        //dd($oneCurrentGameDrawnNumbersCollection);
        //dd($oneCurrentGameDrawnNumbersCollection->mega_number);
        $collectionOfDrawnNumbersOnly = collect([]);
        $collectionOfDrawnNumbersOnly->push($oneCurrentGameDrawnNumbersCollection->first_number); 
        $collectionOfDrawnNumbersOnly->push($oneCurrentGameDrawnNumbersCollection->second_number);
        $collectionOfDrawnNumbersOnly->push($oneCurrentGameDrawnNumbersCollection->third_number);
        $collectionOfDrawnNumbersOnly->push($oneCurrentGameDrawnNumbersCollection->fourth_number);
        $collectionOfDrawnNumbersOnly->push($oneCurrentGameDrawnNumbersCollection->fifth_number);
        $collectionOfDrawnNumbersOnly->push($oneCurrentGameDrawnNumbersCollection->mega_number);

        return $collectionOfDrawnNumbersOnly;
    }
    
    public static function checkOneCurrentGameCardAgainstOneCurrentGameDrawnNumbers ($oneCurrentGameCardCollection,$oneCurrentGameDrawnNumbersCollection)
    {
        $gameDrawnNumbersCollection = self::extractOnlyCurrentGameDrawnNumbersToACollectionFromCollection($oneCurrentGameDrawnNumbersCollection);
        $hitCount=0;
        if(!$oneCurrentGameCardCollection->shadowcard->first_number)//first number in shadow card is 0
        {   
            if($gameDrawnNumbersCollection->contains($oneCurrentGameCardCollection->number1)){
                $oneCurrentGameCardCollection->shadowcard->first_number = TRUE;
                $hitCount++;
            }
            else
                $oneCurrentGameCardCollection->shadowcard->first_number = FALSE;        
        }
        else//first number is in shadow card is 1
            $hitCount++;
        
        if(!$oneCurrentGameCardCollection->shadowcard->second_number)
        {   
            if($gameDrawnNumbersCollection->contains($oneCurrentGameCardCollection->number2)){
                $oneCurrentGameCardCollection->shadowcard->second_number = TRUE;
                $hitCount++;           
            }
            else
                $oneCurrentGameCardCollection->shadowcard->second_number = FALSE;    
        }
        else
            $hitCount++;
        
        if(!$oneCurrentGameCardCollection->shadowcard->third_number)
        {   
            if($gameDrawnNumbersCollection->contains($oneCurrentGameCardCollection->number3)){
                $oneCurrentGameCardCollection->shadowcard->third_number = TRUE;
                $hitCount++;           
            }
            else
                $oneCurrentGameCardCollection->shadowcard->third_number = FALSE;    
        }
        else
            $hitCount++;


        if(!$oneCurrentGameCardCollection->shadowcard->fourth_number)
        {   
            if($gameDrawnNumbersCollection->contains($oneCurrentGameCardCollection->number4)){
                $oneCurrentGameCardCollection->shadowcard->fourth_number = TRUE;
                $hitCount++;           
            }
            else
                $oneCurrentGameCardCollection->shadowcard->fourth_number = FALSE;    
        }
        else
            $hitCount++;

        if(!$oneCurrentGameCardCollection->shadowcard->fifth_number)
        {   
            if($gameDrawnNumbersCollection->contains($oneCurrentGameCardCollection->number5)){
                $oneCurrentGameCardCollection->shadowcard->fifth_number = TRUE;
                $hitCount++;           
            }
            else
                $oneCurrentGameCardCollection->shadowcard->fifth_number = FALSE;    
        }
        else
            $hitCount++;

        if(!$oneCurrentGameCardCollection->shadowcard->mega_number)
        {   
            if($gameDrawnNumbersCollection->contains($oneCurrentGameCardCollection->number6)){
                $oneCurrentGameCardCollection->shadowcard->mega_number = TRUE;
                $hitCount++;           
            }
            else
                $oneCurrentGameCardCollection->shadowcard->mega_number = FALSE;    
        }
        else
            $hitCount++;

        $oneCurrentGameCardCollection->hit_count = $hitCount;  //11-24-19 do this if wnat to keep track of hit count
        $oneCurrentGameCardCollection->update();
        $oneCurrentGameCardCollection->shadowcard->update();    

        if(self::isWinner($oneCurrentGameCardCollection))
        {

           $winner = Winner::firstOrCreate(
                ['card_id' => $oneCurrentGameCardCollection->id],
                ['user_id' => $oneCurrentGameCardCollection->user->id, 'game_id' =>  $oneCurrentGameCardCollection->game_id]
            );

            //Close current game because there is winner or winners
            //$oneCurrentGameCardCollection->game->closed
             $currentGame = Game::find($oneCurrentGameCardCollection->game->id);

             $currentGame->closed = TRUE;

             $currentGame->save();
        }
    }


    public static function checkAllCurrentGameCardsAgainstOneCurrentGameDrawnNumbers($allCurrentGameCardCollection,$oneCurrentGameDrawnNumbersCollection)
    {
        foreach ($allCurrentGameCardCollection as $oneCurrentGameCardCollection) {
            self::checkOneCurrentGameCardAgainstOneCurrentGameDrawnNumbers($oneCurrentGameCardCollection,$oneCurrentGameDrawnNumbersCollection);
        }
    }
    
    public static function checkOneCurrentGameCardAgainstAllCurrentGameDrawnNumbers($oneCurrentGameCardCollection,$allCurrentGameDrawnNumbersCollection)
    {
        foreach ($allCurrentGameDrawnNumbersCollection as $oneCurrentGameDrawnNumbersCollection)
        {
            self::checkOneCurrentGameCardAgainstOneCurrentGameDrawnNumbers($oneCurrentGameCardCollection, $oneCurrentGameDrawnNumbersCollection);
        }
    }


    public static function checkAllCurrentGameCardsAgainstAllCurrentGameDrawnNumbers($allCurrentGameCardCollection,$allCurrentGameDrawnNumbersCollection)
    {
        foreach ($allCurrentGameDrawnNumbersCollection as $oneCurrentGameDrawnNumbersCollection)
        {
            self::checkAllCurrentGameCardsAgainstOneCurrentGameDrawnNumbers($allCurrentGameCardCollection, $oneCurrentGameDrawnNumbersCollection);
        }

        //dd($allCurrentGameCardCollection);


        // foreach ($currentCardsOfCurrentGameCollection as $card) {
        //      $cardFromCollectionToAssociativeArray = $card->toArray();
        //      $cardFromAssociativeArrayToIndexedArray = array_values($cardFromCollectionToAssociativeArray);
        //      for ($i=3; $i < 9 ; $i++) 
        //      { 
                 
        //      }
             
        //      //print_r ($cardFromAssociativeArrayToIndexedArray);
        //      //print ("<br>");
        //      //dd($test['number1']);
        //      //print($card[3]."<br>");
        //  }
        
    }

    public static function isWinner($currentGameCard)
    {
        $hitCount = 0;

        if($currentGameCard->shadowcard->first_number)
            $hitCount++;
        if($currentGameCard->shadowcard->second_number)
            $hitCount++;
        if($currentGameCard->shadowcard->third_number)
            $hitCount++;
        if($currentGameCard->shadowcard->fourth_number)
            $hitCount++;
        if($currentGameCard->shadowcard->fifth_number)
            $hitCount++;
        if($currentGameCard->shadowcard->mega_number)
            $hitCount++;   
        
        if($hitCount==6)
            return TRUE;
        else 
            return  FALSE;      
    }

    public static function resetAllCurrentGameShadowCards($shadowCards)
    {
        foreach ($shadowCards as $shadowCard) {
            self::resetGameShadowCard($shadowCard);
        }

    }
    public static function resetGameShadowCard($gameCard)
    {
        $gameCard->shadowcard->first_number = FALSE;
        $gameCard->shadowcard->second_number= FALSE;
        $gameCard->shadowcard->third_number = FALSE;
        $gameCard->shadowcard->fourth_number= FALSE;
        $gameCard->shadowcard->fifth_number = FALSE;
        $gameCard->shadowcard->mega_number  = FALSE;
        $gameCard->shadowcard->update(); 
    }

    public static function createUsersAndGameCardsFromFile($gameFile)
    {
        $playersNameAndNumbersArray = file(storage_path($gameFile));
        //dd($playersNameAndNumbersArray);
        //$activeGame = Game::get()->where('active',1);
        try {
            $activeGame = Game::firstOrFail()->where('active', TRUE)->get();
            //dd($activeGame);
            foreach ($playersNameAndNumbersArray as $playerNameAndNumbersArray) 
            {
                //dd($playerNameAndNumbersArray);
                $splitPlayerNameAndNumbersArray = explode(",",$playerNameAndNumbersArray);
                //dd($splitPlayerNameAndNumbersArray);
                $createdEmailSubAddress = str_replace(' ','_', preg_replace( '/[^a-z0-9 ]/i', '', $splitPlayerNameAndNumbersArray[0]))."@bingo.com";
                $user = User::firstOrCreate(['name' => $splitPlayerNameAndNumbersArray[0]],
                                            ['email'    => $createdEmailSubAddress, 
                                             'password' => $createdEmailSubAddress,
                                            ]);
                //dd($user);
                $gameCard = Card::create(['user_id'=>$user->id,
                                          'game_id'=>$activeGame[0]->id,
                                          'number1'=>$splitPlayerNameAndNumbersArray[1],
                                          'number2'=>$splitPlayerNameAndNumbersArray[2],
                                          'number3'=>$splitPlayerNameAndNumbersArray[3],
                                          'number4'=>$splitPlayerNameAndNumbersArray[4],
                                          'number5'=>$splitPlayerNameAndNumbersArray[5],
                                          'number6'=>str_replace(array("\n", "\r"), '',$splitPlayerNameAndNumbersArray[6]),
                                          'active'=>TRUE,
                                          'winner'=>FALSE,
                                        ]);
                $shadowcard = new ShadowCard;
                $shadowcard->card_id = $gameCard->id;
                $gameCard->shadowcard()->save($shadowcard);
            }            
          } catch (ModelNotFoundException $ex) {
            
            dd("No Active Game Found");
          }

          
        //$activeGame = Game::firstOrFail()->where('active', TRUE)->get();
       

        
    }

    public function getHitCount()
    {
        return $this->hitCount;
    }
    public function setHitCount($hitCount)
    {
        $this->hitCount = $hitCount;
    }
    public function incrementHitCount()
    {
        $this->hitCount++;
    }

}