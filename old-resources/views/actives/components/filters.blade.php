<section class="filters">
    <div class="filters__wrapper">
        <div class="filters__content">
            <div class="filters__toggle">
                <div class="filters__toggle-text">
                    Фильтры
                </div>
                <div class="filters__toggle-icon">
                    <img src="{{Vite::asset('resources/images/icons/filter.svg')}}" alt="filter">
                </div>
            </div>

            <div class="filters__body d-none">
                <form id="filters__form" action="{{route('actives.index')}}" method="get">
                    <input type="date" class="form-control filters__item" name="date" id="date" placeholder="Введите дату">
                </form>
            </div>

        </div>
    </div>
</section>
