@extends('layouts.app')

@section('content')
@include('inc.sidebar')


<div class="container" id="paddingtop">
	<div class="card">
		<h3 class="card-header">...</h3>
					{!! Form::open(['action' => 'ListsController@store', 'method' => 'POST']) !!}
                        {!! Form::text('board_id', $boardid['id'], ['readonly' => true, 'hidden' => true]) !!}
                    <ul class="list-group">

                        <li class="list-group-item">
                            {!! Form::label('list','To do') !!}
                            {!! Form::text('todo', '1', ['readonly' => true, 'hidden' => true]) !!}

                            <select name="selecttodo">
                                <option value="">--Select--</option>
                            @foreach($lists as $list)

                                <option value="{{$list['id']}}">{{$list['name']}}</list>
                                
                            @endforeach
                            </select>

                        </li>

                        <li class="list-group-item">
                            {!! Form::label('list','For Review') !!}
                            {!! Form::text('forreview', '2', ['readonly' => true, 'hidden' => true]) !!}

                            <select name="selectforreview">
                                <option value="">--Select--</option>
                            @foreach($lists as $list)

                                <option value="{{$list['id']}}">{{$list['name']}}</list>
                                
                            @endforeach
                            </select>
                        </li>

                        <li class="list-group-item">
                            {!! Form::label('list','Done') !!}
                            {!! Form::text('done', '3', ['readonly' => true, 'hidden' => true]) !!}

                            <select name="selectdone">
                                <option value="">--Select--</option>
                            @foreach($lists as $list)

                                <option value="{{$list['id']}}">{{$list['name']}}</list>
                                
                            @endforeach
                            </select>
                        </li>

                        <li class="list-group-item">
                            {!! Form::label('list','Paid') !!}
                            {!! Form::text('paid', '4', ['readonly' => true, 'hidden' => true]) !!}

                            <select name="selectpaid">
                                <option value="">--Select--</option>
                            @foreach($lists as $list)

                                <option value="{{$list['id']}}">{{$list['name']}}</list>
                                
                            @endforeach
                            </select>
                        </li>
                    </ul>

                        {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
                        {!! Form::close() !!}
	</div>
</div>

@endsection