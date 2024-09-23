<div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">Курсы тикеров на {{$date}}</h4>
        <div class="flex-shrink-0">
            @include('tickers.components.filters')
        </div>
    </div><!-- end card header -->

    <div class="card-body">
        <div class="table-responsive table-card">
            <table class="table table-bordered align-middle table-nowrap mb-0">
                <thead>
                <tr>
                    <th>Название</th>
                    <th>Цена открытия</th>
                    <th>Самая высокая цена</th>
                    <th>Самая низкая цена</th>
                    <th>Цена закрытия</th>

                </tr>
                </thead>
                <tbody>

                @foreach($tickers as $ticker)
                    <tr class="align-middle">
                        <td>{{ $ticker->name }} <div class="subname">{{ $ticker->company->name }}</div></td>
                        <td class="text-end {{$ticker->price->open > $ticker->price->close ? 'text-success' : 'text-danger'}}">
                            {{ currency($ticker->price->open) }}
                        </td>

                        <td class="text-end">{{ currency($ticker->price->high ?? 0) }}</td>
                        <td class="text-end">{{ currency($ticker->price->low ?? 0) }}</td>

                        <td class="text-end {{$ticker->price->open < $ticker->price->close ? 'text-success' : 'text-danger'}}">
                            {{ currency($ticker->price->close) }}
                        </td>
                    </tr>

                @endforeach

                </tbody>

            </table><!-- end table -->
        </div>
    </div>
</div> <!-- .card-->




