@extends('layouts.main')

@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div><br />
    @endif
    <div class="pull-right">
        <a class="btn btn-success btn-sm" href="{{ route('cards.create') }}">New Card</a>
    </div>


    @php
        $count = 0;
    @endphp
    @if ($groupedCardsByUserID->isEmpty())
        <div>
             There are no Game Cards
        </div>
    
    @else
        <table class="table table-bordered">
            <tr align="center">
                <td colspan="2">
                        
                <span>Winner/s for this game : {{date("M jS, Y", strtotime($activeGame->start_date))}} to {{($activeGame->end_date ? (date("M jS, Y", strtotime($activeGame->end_date))):'Still Going')}}</span><br>
                    @if ($winners->isNotEmpty())
                        <span class="bg-info text-white">
                            @foreach ($winners as $winner)
                                <a class="text-white" href="#CardID{{$winner->card_id}}">{{$winner->user->name}} with Card id: {{$winner->card_id}}</a><br>
                            @endforeach
                        </span>
                    @else
                    <span>***No Winners Yet***</span><br>
                    @endif
                </td>
                <td colspan="2">
                        
                    <span>Looser/s for this game : {{date("M jS, Y", strtotime($activeGame->start_date))}} to {{($activeGame->end_date ? (date("M jS, Y", strtotime($activeGame->end_date))):'Still Going')}}</span><br>
                        @if ($loosersG->isNotEmpty())
                            <span class="bg-info text-white">
                                @foreach ($loosersG as $loosers)
                                    @foreach ($loosers as $looser)
                                    <a class="text-white" href="#CardID{{$looser->id}}">{{$looser->user->name}} with Card id: {{$looser->id}}</a><br>
                                    @endforeach
                                @endforeach
                            </span>
                        @else
                            <span>***No Looser/s Yet***</span><br>
                        @endif
                </td>
            </tr>
            @foreach ($groupedCardsByUserID as $cards)
                @foreach ($cards as $card)
                    
                    @if ($count==0)
                        <tr>
                    @endif
                    @if ($count%4 == 0)
                        <tr>
                    @endif
                
                    <td> 
                        <div class="card" id="CardID{{$card->id}}">
                            <div style="background: {{ $card->active==1?'#9dfc9e':'#fca195' }};">
                                <div class="card-header" align="center" >
                                    <small><strong>{{ $card->user->name }}</strong></small>
                                </div>
                                <div class="card-header" align="center" >
                                    <strong><small>Card ID : {{ $card->id }}  <->  Game ID : {{$card->game_id}}</small></strong>
                                </div>                            
                            </div>
                            <div class="card-body" align="center">
                                <!--<h5 class="card-title" align="center">Bingo Card:  {{$count+1}}</h5>-->
                                <!--<table class="table table-bordered table-dark text-white h5" width="150" border="3" >-->
                                <table class="{{ $card->winner==1 ? 'table-info text-dark':'table-dark text-white' }} h5" width="150" border="1" >
                                    <tbody>
                                        <tr>
                                            @if ($card->shadowcard->first_number)
    
                                                <td width="50" height="50" align="center"><img src="{{ asset('gifs/g'.$card->number1.'.gif') }}"width="28" height="28"></td>
                                            @else
                                                <td width="50" height="50" align="center">{{ $card->number1}}</td>
                                            @endif
                                            @if ($card->shadowcard->second_number)
                                                <td width="50" height="50" align="center"><img src="{{ asset('gifs/g'.$card->number2.'.gif') }}"width="28" height="28"></td>
                                            @else
                                                <td width="50" height="50" align="center">{{ $card->number2}}</td>
                                            @endif
                                            @if ($card->shadowcard->third_number)
                                                <td width="50" height="50" align="center"><img src="{{ asset('gifs/g'.$card->number3.'.gif') }}"width="28" height="28"></td>
                                            @else
                                                <td width="50" height="50" align="center">{{ $card->number3}}</td>
                                            @endif
                                        </tr>
                                        <tr>
                                            @if ($card->shadowcard->fourth_number)
                                                <td width="50" height="50" align="center"><img src="{{ asset('gifs/g'.$card->number4.'.gif') }}"width="28" height="28"></td>
                                            @else
                                                <td width="50" height="50" align="center">{{ $card->number4}}</td>
                                            @endif
                                            @if ($card->shadowcard->fifth_number)
                                                <td width="50" height="50" align="center"><img src="{{ asset('gifs/g'.$card->number5.'.gif') }}"width="28" height="28"></td>
                                            @else
                                                <td width="50" height="50" align="center">{{ $card->number5}}</td>
                                            @endif
                                            @if ($card->shadowcard->mega_number)
                                                <td width="50" height="50" align="center"><img src="{{ asset('gifs/g'.$card->number6.'.gif') }}"width="28" height="28"></td>
                                            @else
                                                <td width="50" height="50" align="center">{{ $card->number6}}</td>
                                            @endif                                      
                                        </tr>
                                    </tbody>
                                </table>
                                <form action="{{ route('cards.destroy',$card->id) }}" method="POST">
                                    <a class="btn btn-outline-success btn-sm" href="{{ route('cards.edit',$card->id) }}" role="button" > &nbsp&nbspEdit&nbsp&nbsp</a>
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('cards.show',$card->id) }}" role="button">Show</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>    
                            </div>
                            <div class="card-footer text-muted" align="center" }}">

                                <!--<p>Active: {{ $card->active ? 'YES':'NO' }} -- Winner: {{ $card->winner ? 'YES' : 'NO' }}</p> -->
                                <p>Active: {{ $card->game->active ? 'YES':'NO' }} -- Winner: {{ $card->winner ? 'YES' : 'NO' }}</p>
                            </div>
                        </div>
                    </td>
                    @php
                        $count++;
                    @endphp
                    @if ($card->count() == $count)
                        </tr>
                    @endif
                @endforeach
            @endforeach 
        </table>
    @endif

@endsection

