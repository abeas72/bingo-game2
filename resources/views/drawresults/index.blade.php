@extends('layouts.main')

@section('content')
    @if(session()->get('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div><br />
    @endif
    <div class="pull-right">
        <a class="btn btn-success btn-sm" href="{{ route('drawresults.create') }}">Enter Draw Results</a>
    </div>

    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col">Game ID</th>
                <th scope="col">Draw #</th>
                <th scope="col">First</th>
                <th scope="col">Second</th>
                <th scope="col">Third</th>
                <th scope="col">Fourth</th>
                <th scope="col">Fifth</th>
                <th scope="col">Mega</th>
                <th scope="col">Prize Amount</th>
                <th scope="col">Rollover</th>
                <th scope="col">Draw Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($drawresults as $drawresult)
            <tr>
                <td> {{$drawresult->game_id}}</td>
                <td> {{$drawresult->draw_number}} </td>
                <td> {{$drawresult->first_number}} </td>
                <td> {{$drawresult->second_number}} </td>
                <td> {{$drawresult->third_number}} </td>
                <td> {{$drawresult->fourth_number}}</td>
                <td> {{$drawresult->fifth_number}}</td>
                <td> {{$drawresult->mega_number}}</td>
                <td> {{ $drawresult->formatPrizeAmount() }}</td>      
                <td> {{$drawresult->rollover}}</td>          
                <td> {{$drawresult->draw_date}}</td>
                <td>
                    <form action="{{ route('drawresults.destroy',$drawresult->id) }}"  method="POST">
                        <a class="btn btn-outline-success btn-sm" href="{{ route('drawresults.edit',$drawresult->id) }}" role="button" > &nbsp&nbspEdit&nbsp&nbsp</a>
                        <!--<a class="btn btn-outline-primary btn-sm" href="{{ route('drawresults.show',$drawresult->id) }}" role="button">Show</a>-->
                        @csrf
                        @method('DELETE')
                        <button  class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection



