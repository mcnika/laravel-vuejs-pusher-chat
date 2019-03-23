@extends('layouts.chat')

@section('content')
<div id="app">
     <main-component :user="{{ auth()->user() }}" logout-route="{{ route('logout') }}"></main-component>        
</div>
@endsection
