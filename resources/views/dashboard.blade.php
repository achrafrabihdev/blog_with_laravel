@extends('layouts.app')

@section('content')
    <h1>Dashboard</h1>
    @can('secret.page')
         <a href="{{route('secret')}}">administration</a>
    @endcan
@endsection
