<!-- Modal -->
<div class="modal fade" id="sellActiveModal" tabindex="-1" aria-labelledby="sellActiveModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="sellActiveModalLabel">Продать актив</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="sellActiveForm" action="{{ route('actives.sell') }}" method="post">
                    @csrf
                    <input type="hidden" name="ticker_id">

                    <div class="form-group mb-3">
                        <label for="tickers" class="form-label">Тикер:</label>
                        <input class="form-control ticker_id" type="text"  id="sell_ticker_id" placeholder="Начните вводить название тикера или компании..." autocomplete="off"/>
                    </div>
                    <div class="form-group mb-3">
                        <label id="available_quantity" for="quantity" class="form-label">Количество:</label>
                        <input class="form-control" type="text" id="sell_quantity" name="quantity" autocomplete="off"/>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" form="sellActiveForm" class="btn btn-primary">Продать</button>
            </div>
        </div>
    </div>
</div>
