@extends('layouts.main')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
    @endif   
    
    <form method="GET" action="{{ route('cards.test_select') }}" autocomplete="off" novalidate>
        @csrf
        <div class="form-group">
           <select class="form-control" name="user_id">
            <option  value="" >Select User</option>      
                @foreach ($users as $user)
                    <option value="{{ $user->id}}" {{old('user_id') == $user->id ? 'selected' : ''}}>{{$user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" >
            <select class="form-control" name="game_id">
            <option value="">Select Game</option> 
                @foreach ($games as $game)
                    
                    <option value="{{ $game->id }}" {{old('game_id')==$game->id ? 'selected' : ''}}>{{date("M jS, Y", strtotime($game->start_date))}} - {{$game->end_date ? date("M jS, Y", strtotime($game->end_date)) : 'Still Going'  }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" >
            <select class="form-control" name="hit_count">
            <option value="">Select Hit Count</option> 
                <option value="0">0</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
            </select>
        </div>

        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>

    @php
        $count = 0;
    @endphp
    @if ($groupedCardsByUserID->isEmpty())
        <div>
             
             {{$errorMessage}}
        </div>
    
    @else
        <table class="table table-bordered">

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
                                    <strong><small>Card ID : {{ $card->id }}  -  Game ID : {{$card->game_id}} - Hit: {{$card->hit_count}} </small></strong>
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

@endSection    