<div class="dropdown card-header-dropdown">
    <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <span class="fw-semibold text-uppercase fs-12">Фильтры: </span><span class="text-muted"><i class="mdi mdi-chevron-down ms-1"></i></span>
    </a>
    <div id="filters" class="dropdown-menu dropdown-menu-end" style="">
        <div class="dropdown-item" style="min-width: 300px;">
            <form id="filters__form" action="{{route('tickers.index')}}" method="get">
                    <div class="input-group input-group-sm mb-3">
                        <span class="input-group-text" id="inputGroup-sizing-sm">Введите дату:</span>
                        <input type="date" class="form-control filters__item" name="date" id="date" placeholder="Введите дату" value="{{ old('date', \App\Http\Services\DateService::getOnlyDateForHtml()) }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-soft-primary btn-sm w-100">Применить</button>
                    </div>
            </form>
        </div>
    </div>
</div>
