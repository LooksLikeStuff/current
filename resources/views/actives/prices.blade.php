@extends('layouts.master')
@section('title') @lang('Сводная таблица') @endsection


@section('content')
    @include('actives.components.pivot.table')
@endsection

