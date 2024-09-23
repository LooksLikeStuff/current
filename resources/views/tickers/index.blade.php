@extends('layouts.master')
@section('title') @lang('Курсы на ' . $date) @endsection

@section('content')
    @include('tickers.components.content')
@endsection

