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
    <form method="post" action="{{ route('games.update', $game->id) }}" autocomplete="off" novalidate>
        @csrf
        @method('PUT')
        <div class="form-group w-25" >
            <label for="start_date">Start Date:</label>
            <input type="date" class="form-control" name="start_date" value="{{ old('start_date' , $game->start_date) }}"/>
        </div>
        <div class="form-group w-25">
            <label for="end_date w-25">End Date:</label>
            <input type="date" class="form-control" name="end_date" value="{{ old('end_date' , $game->end_date) }}"/>
        </div>
        <div class="form-group w-25">
            <label for="active">Active:</label>
            <input type="text" class="form-control" name="active" value="{{ old('active', $game->active) }}"/>
        </div>
        <div class="form-group w-25">
            <label for="money_pot">Money Pot:</label>
            <input type="text" class="form-control" name="money_pot" value="{{ old('money_pot' , $game->money_pot) }}"/>
        </div>
        <div class="form-group w-25">
            <label for="closed">Closed:</label>
            <input type="text" class="form-control" name="closed" value="{{ old('closed' , $game->closed) }}"/>
        </div>
        <button type="submit" class="btn btn-primary">Update Game</button>
    </form>
@endsection
