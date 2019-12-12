@extends('layouts.main')

@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div><br />
    @endif
    <div class="pull-right">
        <a class="btn btn-success btn-sm" href="{{ route('games.create') }}">New Bingo Lotto Game</a>
    </div>

    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col">Start Date</th>
                <th scope="col">End Date</th>
                <th scope="col">Active</th>
                <th scope="col">Money Pot</th>
                <th scope="col">Player Count</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($games as $game)
            <tr>
            <td>{{date("M jS, Y", strtotime($game->start_date))}}</td>
                <td> {{ $game->end_date ? date("M jS, Y", strtotime($game->end_date)):"Still Going" }} </td>
                <td> 
                    
                    {{$game->active ? 'YES':'NO'}} 
                </td>
                <td> {{$game->formatPrizeAmount()}}</td>
                <td> {{$game->playersForThisGame()}}</td>
                <td>
                    <form  action="{{ route('games.destroy',$game->id) }}" method="POST">
                        <a class="btn btn-outline-success btn-sm" href="{{ route('games.edit',$game->id) }}" role="button" > &nbsp&nbspEdit&nbsp&nbsp</a>
                        <!--<a class="btn btn-outline-primary btn-sm" href="{{ route('games.show',$game->id) }}" role="button">Show</a>-->
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection

