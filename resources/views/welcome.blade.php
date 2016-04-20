@extends('master')
@section('container')
            <h1>URL Shortener</h1>
            {{ Form::open(array('url' => '/')) }}
                {{ Form::label('url', 'Your Long URL') }}
                {{ Form::text('url') }}
                {{ Form::submit('Shorten') }}
            {{ Form::close() }}

           {{ $errors->first('url', '<p class="error">:message</p>') }}
@endsection