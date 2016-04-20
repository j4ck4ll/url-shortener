@extends('master')

@section('container')
	<h1>Here is your shortened URL: </h1>
	{{ Html::link($shortened, "url.dev/$shortened") }}
@endsection