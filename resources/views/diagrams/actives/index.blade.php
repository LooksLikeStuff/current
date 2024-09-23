<div class="col-xl-12">
    <div class="card">
        <div class="card-header border-0 align-items-center d-flex flex-md-row flex-column gap-3">
            <h4 class="line__diagram-title card-title mb-0 flex-grow-1"></h4>
            <div class="text-md-center text-start">
{{--                <button type="button" class="btn btn-soft-primary btn-sm  diagrams__switch-item diagrams__switch-active btn-soft-primaryz" data-period="week">--}}
{{--                    За неделю--}}
{{--                </button>--}}
                <button type="button" class="btn  btn-soft-primary btn-sm diagrams__switch-item diagrams__switch-active" data-period="month" data-period-amount="1">
                    1M
                </button>
                <button type="button" class="btn btn-soft-secondary btn-sm diagrams__switch-item" data-period="month" data-period-amount="3">
                    3M
                </button>
                <button type="button" class="btn btn-soft-secondary btn-sm diagrams__switch-item" data-period="month" data-period-amount="6">
                    6M
                </button>
                <button type="button" class="btn btn-soft-secondary btn-sm diagrams__switch-item" data-period="day" data-period-amount="{{ \App\Http\Services\DateService::startOfYear()->diffInDays(\App\Http\Services\DateService::now()) }}">
                    YTD
                </button>
                <button type="button" class="btn btn-soft-secondary btn-sm diagrams__switch-item" data-period="year" data-period-amount="1">
                    1Y
                </button>
                <button type="button" class="btn btn-soft-secondary btn-sm diagrams__switch-item" data-period="all" data-period-amount="1">
                    ALL
                </button>
            </div>
            <div class="line__diagram_switch">
                <button type="button" class="btn btn-soft-primary btn-line__diagram-switch">
                    Показать в %
                </button>
            </div>
        </div><!-- end card header -->

        <div class="card-body p-0 pb-2" style="height: 465px">
            <div class="w-100">
                <div class="diagrams__item" id="main__line"></div>
                <div class="preloading d-flex h-100 w-100 align-items-center justify-content-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

            </div>
        </div><!-- end card body -->
    </div><!-- end card -->
</div>

<div class="col-xl-6">
    <div class="card card-height-100">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Соотношение по тикерам</h4>

        </div><!-- end card header -->

        <div class="card-body w-100" style="height: 300px">
            <div class="diagrams__item diagrams__item-pie" id="pie__tickers"></div>
            <div class="preloading d-flex align-items-center h-100 w-100 justify-content-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

{{--            <div class="table-responsive mt-3">--}}
{{--                <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-0">--}}
{{--                    <tbody class="border-0">--}}
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-primary me-2"></i>Desktop Users</h4>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>78.56k</p>--}}
{{--                        </td>--}}
{{--                        <td class="text-end">--}}
{{--                            <p class="text-success fw-medium fs-12 mb-0"><i class="ri-arrow-up-s-fill fs-5 align-middle"></i>2.08% </p>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-secondary me-2"></i>Mobile Users</h4>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>105.02k</p>--}}
{{--                        </td>--}}
{{--                        <td class="text-end">--}}
{{--                            <p class="text-danger fw-medium fs-12 mb-0"><i class="ri-arrow-down-s-fill fs-5 align-middle"></i>10.52%--}}
{{--                            </p>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-warning me-2"></i>Tablet Users</h4>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>42.89k</p>--}}
{{--                        </td>--}}
{{--                        <td class="text-end">--}}
{{--                            <p class="text-danger fw-medium fs-12 mb-0"><i class="ri-arrow-down-s-fill fs-5 align-middle"></i>7.36%--}}
{{--                            </p>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
        </div>
    </div> <!-- .card-->
</div> <!-- .col-->

<div class="col-xl-6">
    <div class="card card-height-100">
        <div class="card-header align-items-center d-flex">
            <h4 class="card-title mb-0 flex-grow-1">Соотношение активов по секторам</h4>
        </div><!-- end card header -->

        <div class="card-body w-100" style="height: 300px">
            <div class="diagrams__item diagrams__item-pie" id="pie__categories"  data-colors='["--vz-primary", "--vz-secondary", "--vz-warning"]' dir="ltr"></div>
            <div class="preloading d-flex align-items-center h-100 w-100 justify-content-center">
                <div class="spinner-border text-primary" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

{{--            <div class="table-responsive mt-3">--}}
{{--                <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-0">--}}
{{--                    <tbody class="border-0">--}}
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-primary me-2"></i>Desktop Users</h4>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>78.56k</p>--}}
{{--                        </td>--}}
{{--                        <td class="text-end">--}}
{{--                            <p class="text-success fw-medium fs-12 mb-0"><i class="ri-arrow-up-s-fill fs-5 align-middle"></i>2.08% </p>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-secondary me-2"></i>Mobile Users</h4>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>105.02k</p>--}}
{{--                        </td>--}}
{{--                        <td class="text-end">--}}
{{--                            <p class="text-danger fw-medium fs-12 mb-0"><i class="ri-arrow-down-s-fill fs-5 align-middle"></i>10.52%--}}
{{--                            </p>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td>--}}
{{--                            <h4 class="text-truncate fs-14 fs-medium mb-0"><i class="ri-stop-fill align-middle fs-18 text-warning me-2"></i>Tablet Users</h4>--}}
{{--                        </td>--}}
{{--                        <td>--}}
{{--                            <p class="text-muted mb-0"><i data-feather="users" class="me-2 icon-sm"></i>42.89k</p>--}}
{{--                        </td>--}}
{{--                        <td class="text-end">--}}
{{--                            <p class="text-danger fw-medium fs-12 mb-0"><i class="ri-arrow-down-s-fill fs-5 align-middle"></i>7.36%--}}
{{--                            </p>--}}
{{--                        </td>--}}
{{--                    </tr>--}}
{{--                    </tbody>--}}
{{--                </table>--}}
{{--            </div>--}}
        </div>
    </div> <!-- .card-->
</div> <!-- .col-->
