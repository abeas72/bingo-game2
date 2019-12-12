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


    <div class="card mx-auto" style="width: 21rem; " align="center" >
        <div class="card-header">
            Add New Game Card
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('cards.store') }}" autocomplete="off">
                @csrf
                <div class="form-group">

                <table>
                    <tr>
                        <td>
                            <div class="form-group">
                                <!--<label for="user_id">User ID:</label>
                                <input type="text" class="form-control" name="user_id" value="{{ old('user_id') }}"/>-->
                                
                                <select class="form-control" name="user_id">
                                <option  value="" >Select User</option>                                                              
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id}}" {{old('user_id')==$user->id ? 'selected' : ''}}>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td>
                            <div class="form-group" >
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
                        </td>
                    </tr>
                </table>

                <table class="table table-bordered  table-dark smx-auto" >
                    <tr>
                        <td>
                            <div class="form-group" align="center">
                                <label for="number1"> 1<sup>st</sup></label>
                                <!--<input type="text" class="form-control" placeholder="First #" onFocus="this.placeholder = ''" onBlur="this.placeholder = 'First#'" name="number1" value="{{ old('number1') }}"/>-->
                                <input type="text" class="form-control" name="number1" value="{{ old('number1') }}"/>
                            </div>
                        </td>
                        <td>
                            <div class="form-group" align="center">
                                <label for="number2">2<sup>nd</sup></label>
                                <input type="text" class="form-control" name="number2" value="{{ old('number2') }}"/>
                            </div>
                        </td>
                        <td>
                            <div class="form-group" align="center">
                                <label for="number3">3<sup>rd</sup></label>
                                <input type="text" class="form-control" name="number3" value="{{ old('number3') }}"/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="form-group" align="center">
                                <label for="number4">4<sup>th</sup></label>
                                <input type="text" class="form-control" name="number4" value="{{ old('number4') }}"/>
                            </div>
                        </td>
                        <td>
                            <div class="form-group" align="center">
                                <label for="number5">5<sup>th</sup></label>
                                <input type="text" class="form-control" name="number5" value="{{ old('number5') }}"/>
                            </div>
                        </td>
                        <td>
                            <div class="form-group" align="center">
                                <label for="number6">6<sup>th</sup></label>
                                <input type="text" class="form-control" name="number6" value="{{ old('number6') }}"/>
                            </div>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td>
                            <div class="form-group">
                                <label for="active">Active:</label>
                                <input type="text" class="form-control" name="active" value="{{ old('active') }}"/>
                            </div>
                        </td>
                        <td>
                            <div class="form-group">
                                <label for="winner">Winner:</label>
                                <input type="text" class="form-control" name="winner" value="{{ old('winner') }}"/>
                            </div>
                        </td>
                    </tr>
                </table>
                <button type="submit" class="btn btn-primary">Create Game Card</button>
            </form>
        </div>
    </div>
@endsection