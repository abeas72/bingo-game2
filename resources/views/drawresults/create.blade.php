@extends('layouts.main')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br />
    @endif
    @php
        
        //setlocale(LC_MONETARY,"en_US");
       print("$".number_format("10660"));
    @endphp
    
    <form method="post" action="{{ route('drawresults.store') }}" autocomplete="off" novalidate>
        @csrf
        <div class="form-group w-25" >
                <!--<label for="user_id">Game ID:</label>
                <input type="text" class="form-control" name="game_id" value="{{ old('game_id') }}"/>-->
            <select class="form-control" name="game_id">
                <option value="">Select Game</option> -->
                    @foreach ($games as $game)
                        <!--<option value="{{ $game->id }}">{{$game->start_date}}</option>-->
                        <option value="{{ $game->id }}" {{old('game_id')==$game->id ? 'selected' : ''}}>{{$game->start_date}}</option>
                    @endforeach
            </select>
        </div>
        <div class="form-group w-25" >
            <label for="draw_number">Draw #</label>
            <input type="text" class="form-control" name="draw_number" value="{{ old('draw_number') }}"/>
        </div>
        <div class="form-group w-25" >
            <label for="first_number">First #</label>
            <input type="text" class="form-control" name="first_number" value="{{ old('first_number') }}"/>
        </div>
        <div class="form-group w-25" >
            <label for="second_number">Second #</label>
            <input type="text" class="form-control" name="second_number" value="{{ old('second_number') }}"/>
        </div>
        <div class="form-group w-25" >
            <label for="third_number">Third #</label>
            <input type="text" class="form-control" name="third_number" value="{{ old('third_number') }}"/>
        </div>
        <div class="form-group w-25" >
            <label for="fourth_number">Fourth #</label>
            <input type="text" class="form-control" name="fourth_number" value="{{ old('fourth_number') }}"/>
        </div>
        <div class="form-group w-25" >
            <label for="fifth_number">Fifth #</label>
            <input type="text" class="form-control" name="fifth_number" value="{{ old('fifth_number') }}"/>
        </div>
        <div class="form-group w-25" >
            <label for="mega_number">Mega #</label>
            <input type="text" class="form-control" name="mega_number" value="{{ old('mega_number') }}"/>
        </div>
        <div class="form-group w-25" >
            <label for="prize_amount">California Lotto Prize Amount</label>
            <input type="text" class="form-control" name="prize_amount" value="{{ old('prize_amount') }}"/>
        </div>
        <div class="form-group w-25" >
            <label for="draw_date">Draw Date:</label>
            <input type="date" class="form-control" name="draw_date"  value="{{ old('draw_date') }}"/>
        </div>
        <button type="submit" class="btn btn-primary">Submit Draw Results</button>
    </form>
@endsection