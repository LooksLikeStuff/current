@extends('layouts.master')
@section('title') @lang('Сводная таблица') @endsection


@section('content')
    @include('tickers.components.pivot.table')
@endsection

