<div class="forms">
    @foreach($actives as $active)
        <form id="form-destroy-{{$active->id}}" action="{{route('actives.destroy', $active)}}" method="post">
            @csrf
            @method('DELETE')
        </form>
    @endforeach
</div>

<div class="card card-height-100">
    <div class="card-header align-items-center d-flex">
        <h4 class="card-title mb-0 flex-grow-1">Ваши активы @isset($date) на {{$date}} @endisset</h4>
    </div><!-- end card header -->

    <div class="card-body">
        <div class="table-responsive">
            <table class="table actives__table table-bordered table-nowrap align-middle">

                @isset($date)
                    <thead>
                    <tr class="align-middle">
                        <th>Актив</th>
                        <th>Дата</th>
                        <th>Акций</th>
                        <th>Комиссия / Налог</th>
                        <th>Цена за шт.</th>
                        <th>Общая сумма</th>
                        <th class="text-center">Цена за шт. за <br>{{$date}}</th>
                        <th class="text-center">Общая сумма за <br>{{$date}} </th>
                        <th class="text-center">%</th>
                        <th>% годовых</th>
                        <th>Прибыль</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @php
                        $fullPrice = 0;
                        $fullProfit = 0;
                        $commission = 0;
                        $fullPriceNow = 0;
                    @endphp

                    @foreach($actives as $active)
                        <tr class="align-middle">
                            <td>{{ $active->ticker->name }} <div class="subname">{{ $active->ticker->company->name }}</div></td>
                            <td class="text-nowrap">{{ $active->date->toDateString() }}</td>
                            <td class="text-center">{{ format_number_to_ui($active->quantity) }}</td>
                            <td class="text-end">{{ currency($active->commission) }}</td>
                            <td class="text-end">{{ currency($active->price) }}</td>
                            <td class="text-end">{{ currency($active->startPrice()) }}</td>
                            <td class="text-end">{{ currency($active->ticker->closestPrice($date)->close ?? 0) }}</td>
                            <td class="text-end">{{ currency($active->closestPrice($date)) }}</td>
                            <td class="text-center"> {{format_number_to_ui($active->currentPercent($date), 2)}}%</td>
                            <td class="text-center"> {{ format_number_to_ui($active->yearPercent($date), 2) }}% </td>
                            <td class="text-end fw-semibold {{ $active->isProfitPositive($date) ? 'text-success': 'text-danger' }}">
                                {{ currency($active->profit($date)) }}
                            </td>
                            <td class="text-center">
                                <a class="link link-danger destroy" data-form-id="form-destroy-{{$active->id}}" data-bs-toggle="modal" data-bs-target="#destroyActiveModal">
                                    <img src="{{Vite::asset('resources/images/icons/destroy.svg')}}" alt="destroy">
                                </a>
                            </td>
                        </tr>

                        @php
                            $commission += $active->commission;
                            $fullPrice += $active->startPrice();
                            $fullProfit += $active->profit($date);
                            $fullPriceNow += $active->closestPrice($date);
                        @endphp
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Итого:</th>
                        <th></th>

                        <th class="text-center">{{$user->activesQuantity()}}</th>
                        <th class="text-end">{{ currency($commission) }}</th>
                        <th></th>

                        <th class="text-end fw-bold {{ $fullPrice > 0 ? 'text-success' : 'text-danger' }}">
                            {{  currency($fullPrice) }}
                        </th>

                        <th></th>


                        <th class="text-end fw-ibold {{ $fullPriceNow > 0 ? 'text-success' : 'text-danger' }}">
                            {{currency($fullPriceNow)}}</th>

                        <th></th>

                        <th class="text-end fw-bold {{ $fullProfit > 0 ? 'text-success' : 'text-danger' }}">
                            {{ currency($fullProfit) }}
                        </th>
                        <th></th>
                    </tr>
                    </tfoot>
                @else
                    <thead>
                    <tr class="align-middle">
                        <th>Актив</th>
                        <th>Дата</th>
                        <th>Акций</th>
                        <th>Комиссия / Налог</th>
                        <th>Цена за шт.</th>
                        <th>Общая сумма</th>
                        <th>Цена за шт. сейчас</th>
                        <th>Общая сумма сейчас</th>
                        <th class="text-center">%</th>
                        <th>% годовых</th>
                        <th>Прибыль</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>

                    @php
                        $fullPrice = 0;
                        $fullProfit = 0;
                        $commission = 0;
                        $fullPriceNow = 0;
                    @endphp

                    @foreach($actives as $active)
                        <tr class="align-middle">
                            <td>{{ $active->ticker->name }} <div class="subname">{{ $active->ticker->company->name }}</div></td>
                            <td class="text-nowrap">{{ $active->date->toDateString() }}</td>
                            <td class="text-center">{{ format_number_to_ui($active->quantity) }}</td>
                            <td class="text-end">{{ currency($active->commission) }}</td>
                            <td class="text-end">{{ currency($active->price) }}</td>
                            <td class="text-end">{{ currency($active->startPrice()) }}</td>
                            <td class="text-end">{{ currency($active->ticker->closestPrice()->close ?? 0) }}</td>
                            <td class="text-end">{{ currency($active->closestPrice()) }}</td>
                            <td class="text-center"> {{format_number_to_ui($active->currentPercent(), 2)}}%</td>
                            <td class="text-center"> {{ format_number_to_ui($active->yearPercent(), 2) }}% </td>
                            <td class="text-end fw-semibold {{ $active->isProfitPositive() ? 'text-success': 'text-danger' }}">
                                {{ currency($active->profit()) }}
                            </td>
                            <td class="text-center">
                                <a class="link link-danger destroy" data-form-id="form-destroy-{{$active->id}}" data-bs-toggle="modal" data-bs-target="#destroyActiveModal">
                                    <img src="{{Vite::asset('resources/images/icons/destroy.svg')}}" alt="destroy">
                                </a>
                            </td>
                        </tr>

                        @php
                            $commission += $active->commission;
                            $fullPrice += $active->startPrice();
                            $fullProfit += $active->profit();
                            $fullPriceNow += $active->closestPrice();
                        @endphp
                    @endforeach

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>Итого:</th>
                        <th></th>

                        <th class="text-center">{{format_number_to_ui($user->activesQuantity())}}</th>
                        <th class="text-end">{{ currency($commission) }}</th>
                        <th></th>

                        <th class="text-end fw-bold {{ $fullPrice > 0 ? 'text-success' : 'text-danger' }}">
                            {{  currency($fullPrice) }}
                        </th>

                        <th></th>


                        <th class="text-end fw-ibold {{ $fullPriceNow > 0 ? 'text-success' : 'text-danger' }}">
                            {{currency($fullPriceNow)}}</th>

                        <th></th>

                        <th class="text-end fw-bold {{ $fullProfit > 0 ? 'text-success' : 'text-danger' }}">
                            {{ currency($fullProfit) }}
                        </th>
                        <th></th>
                    </tr>
                    </tfoot>
                @endisset

            </table>
        </div>
    </div>
</div>



