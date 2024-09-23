@vite(['resources/custom-js/balance/main.js'])
<!-- Modal -->
<div class="modal fade" id="balanceModal" tabindex="-1" aria-labelledby="balanceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="balanceModalLabel">Пополнение баланса</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="balanceForm" action="{{ route('balance.up') }}" method="post">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="tickers" class="form-label">Сумма пополнения (в рублях):</label>
                        <input class="form-control" type="text" id="sum" name="sum">
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                <button type="submit" form="balanceForm" class="btn btn-primary">Пополнить</button>
            </div>
        </div>
    </div>
</div>
