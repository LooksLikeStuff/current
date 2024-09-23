<!-- Modal -->
<div class="modal fade" id="createActiveModal" tabindex="-1" aria-labelledby="createActiveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="createActiveModalLabel">Добавить акцию</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createActiveForm" action="{{ route('actives.store') }}" method="post">
                    @csrf
                    <input type="hidden" name="ticker_id">

                    <div class="form-group mb-3">
                        <label for="tickers" class="form-label">Тикер:</label>
                        <input class="form-control" type="text" id="ticker_id" placeholder="Начните вводить название тикера или компании...">
                    </div>
                    <div class="form-group mb-3">
                        <label for="date" class="form-label">Дата покупки:</label>
                        <input class="form-control" type="date" id="date" name="date">
                    </div>
                    <div class="form-group mb-3">
                        <label for="quantity" class="form-label">Количество:</label>
                        <input class="form-control" type="text" id="quantity" name="quantity">
                    </div>
                    <div class="form-group mb-3">
                        <label for="price" class="form-label">Цена (за 1 шт.):</label>
                        <input class="form-control" type="text" id="price" name="price">
                    </div>
                    <div class="form-group mb-3">
                        <label for="commission" class="form-label">Комиссия:</label>
                        <input class="form-control" type="text" id="commission" name="commission" value="0">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" form="createActiveForm" class="btn btn-primary">Добавить</button>
            </div>
        </div>
    </div>
</div>
