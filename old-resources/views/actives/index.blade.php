@extends('layouts.main')
@section('title', 'Мой портфель')

@section('scripts')
    @vite(['resources/js/tickers/main.js', 'resources/js/actives/main.js', 'resources/js/diagrams/actives/main.js'])
@endsection

@section('content')
    @include('actives.create')
    @include('actives.destroy')

    <div class="wrapper pt-3 bg-opacity-25">
        <div class="layout-width py-3">

            @include('actives.components.filters')
            <section class="actives">
{{--                <div class="actives__wrapper">--}}
{{--                    <div class="actives__header">--}}

{{--                    </div>--}}

                    <div class="actives__content">
                        @include('actives.components.content')
                    </div>

                    <div class="actives__header">

                    </div>
{{--                </div>--}}
            </section>
            @include('diagrams.actives.index')

        </div>
    </div>

@endsection
