@extends('layouts.main')

@section('content')
    <style>
        .uper {
            margin-top: 40px;
        }
    </style>
    <div class="card uper">
        <div class="card-header">
            Edit Game Card
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br />
            @endif

            <form method="post" action="{{ route('cards.update', $card->id) }}" autocomplete="off">
                @csrf
                @method('PUT')
                <div class="form-group w-25">
                    <label for="user_id">User ID:</label>
                    <!--<input type="text" class="form-control" name="user_id" value="{{ old('user_id' , $card->user_id) }}"/>-->
                    <select class="form-control" name="user_id">
                        <option value="" ></option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id}}" {{ ((isset($card->user_id) && $card->user_id == $user->id)? "selected":"") }}>{{$user->name}}</option>
                        @endforeach
                    </select>
                </div>                 
                <div class="form-group w-25">
                    <label for="user_id">Game ID:</label>
                    <!--<input type="text" class="form-control" name="game_id" value="{{ old('game_id' , $card->game_id) }}"/>-->
                    <select class="form-control" name="game_id">
                        <option value="" ></option> 
                        @foreach ($games as $game)
                            <option value="{{ $game->id}}" {{ ((isset($card->game_id) && $card->game_id == $game->id)? "selected":"") }}>{{$game->start_date}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group w-25">
                    <label for="number1">Number 1:</label>
                    <input type="text" class="form-control" name="number1" value="{{ old('number1' , $card->number1) }}"/>
                </div>
                <div class="form-group w-25">
                    <label for="number2">Number 2:</label>
                    <input type="text" class="form-control" name="number2" value="{{ old('number2' , $card->number2) }}"/>
                </div>                 
                <div class="form-group w-25">
                    <label for="number3">Number 3:</label>
                    <input type="text" class="form-control" name="number3" value="{{ old('number3' , $card->number3) }}"/>
                </div>
                <div class="form-group w-25">
                    <label for="number4">Number 4:</label>
                    <input type="text" class="form-control" name="number4" value="{{ old('number4' , $card->number4) }}"/>
                </div>                 
                <div class="form-group w-25">
                    <label for="number5">Number 5:</label>
                    <input type="text" class="form-control" name="number5" value="{{ old('number5' , $card->number5) }}"/>
                </div>
                <div class="form-group w-25">
                    <label for="number6">Number 6:</label>
                    <input type="text" class="form-control" name="number6" value="{{ old('number6' , $card->number6) }}"/>
                </div>                 
                <div class="form-group w-25">
                    <label for="active">Active:</label>
                    <input type="text" class="form-control" name="active" value="{{ old('active' , $card->active) }}"/>
                </div>
                <div class="form-group w-25">
                    <label for="winner">Winner:</label>
                    <input type="text" class="form-control" name="winner" value="{{ old('winner', $card->winner) }}"/>
                </div>   
                <div class="form-group w-25">
                    <label for="hit_count">Hit Count:</label>
                    <input type="text" class="form-control" name="hit_count" value="{{ old('hit_count', $card->hit_count) }}"/>
                </div>              
                    <button type="submit" class="btn btn-primary">Edit Game Card</button>
            </form>
        </div>
    </div>
@endsection