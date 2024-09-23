<div class="card">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">Сводная таблица по вашим активам</h4>
        <div class="flex-shrink-0">
        </div>
    </div><!-- end card header -->

    <div class="card-body">
        <div class="table-responsive table-card">
            <table class="table table-bordered align-middle table-nowrap mb-0">
                    <thead>
                    <tr>
                        <th>Актив</th>
                        <th>Акций</th>
                        <th>Средняя цена покупки</th>
                        <th>Стоимость сейчас</th>
                        <th>доля в портфеле</th>
                        <th class="text-end">Прибыль / Убыток</th>

                    </tr>
                    </thead>
                    <tbody>

                    @php
                        $count = 0;
                        $profit = 0;
                    @endphp

                    @foreach($tickers as $ticker)
                        <tr class="align-middle">
                            <td>{{ $ticker->name }} <div class="subname">{{ $ticker->company->name }}</div></td>
                            <td class="text-center">{{ format_number_to_ui($ticker->actives->sum(fn($active) => $active->quantity)) }}</td>
                            <td class="text-end">{{ currency($ticker->actives->average(fn($active) => $active->price)) }}</td>
                            <td class="text-end">{{ currency($ticker->closestPrice() ? $ticker->closestPrice()->close : 0) }}</td>

                            <td class="text-end fw-semibold {{ $ticker->profit() > 0 ? 'text-success': 'text-danger' }}">
                                {{ currency($ticker->profit()) }}
                            </td>
                        </tr>

                        @php
                            $count += $ticker->actives->sum(fn($active) => $active->quantity);
                            $profit += $ticker->profit();
                        @endphp
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Итого:</th>

                        <th class="text-center">{{format_number_to_ui($count)}}</th>
                        <th class="text-end"></th>
                        <th></th>

                        <th class="text-end fw-bold {{ $profit > 0 ? 'text-success' : 'text-danger' }}">
                            {{currency($profit)}}</th>

                    </tr>
                    </tfoot>

            </table><!-- end table -->
        </div>
    </div>
</div> <!-- .card-->




