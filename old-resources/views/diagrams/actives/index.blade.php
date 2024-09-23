<section class="diagrams">
    <div class="diagrams__wrapper">
        <div class="diagrams__content row">
            <div class="col-12">
                <div class="diagrams__switch">
                    <a href="#" class="diagrams__switch-item diagrams__switch-active" data-period="all">За все время</a>
                    <a href="#" class="diagrams__switch-item" data-period="week">За неделю</a>
                    <a href="#" class="diagrams__switch-item" data-period="month">За месяц</a>
                    <a href="#" class="diagrams__switch-item" data-period="year">За год</a>
                </div>
                <div class="diagram__item mb-3 w-100" style="flex: 0 0 100%;">
                    <div id="main__line" class="w-100" style="height: 500px"></div>
                </div>
            </div>

            {{--            pie__tickers--}}
            <div class="col-6">
                <div class="diagram__item">
                    <div id="pie__tickers" style="width: 600px; height:400px;"></div>
                </div>
            </div>

            {{--            pie__categories--}}
            <div class="col-6">
                <div class="diagram__item">
                    <div id="pie__categories" style="width: 600px; height:400px;"></div>
                </div>
            </div>



        </div>
    </div>
</section>
