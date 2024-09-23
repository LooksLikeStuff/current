@extends('layouts.master')
@section('title') @lang('Контрольные значения стоимости портфеля') @endsection


@section('content')
    <div class="card">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Контрольные значения стоимости портфеля</h4>
            <div class="flex-shrink-0">
            </div>
        </div><!-- end card header -->

        <div class="card-body">
            <div class="table-responsive table-card">
                <table class="table table-bordered align-middle table-nowrap mb-0">
                    <thead>
                    <tr>
                        <th class="text-center">Timestamp</th>
                        <th class="text-center">Сумма</th>
                        <th class="text-center">Стартовая сумма</th>
                        <th class="text-center">Процент</th>
                        <th class="text-center">Дата (mdates)</th>
                    </tr>
                    </thead>
                    <tbody>

                    @forelse(array_reverse($cache, true) as $timestamp => $item)
                        <tr>
                            <td>{{$timestamp}}</td>
                            <td class="text-end">{{currency($item['values'])}}</td>
                            <td class="text-end">{{currency($item['startSum'])}}</td>
                            <td class="text-center">{{$item['percent']}}%</td>
                            <td class="text-center">{{\App\Http\Services\DateService::getDefaultFormat($item['mdates'])}}</td>
                        </tr>
                    @empty

                    @endforelse

                    </tbody>

                </table><!-- end table -->
            </div>
        </div>
    </div> <!-- .card-->





@endsection

