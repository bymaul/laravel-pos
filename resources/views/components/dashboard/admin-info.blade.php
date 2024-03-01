@props(['todayRevenue', 'monthRevenue', 'categories', 'products'])

<div class="col-md-6 col-xl-3 mb-4">
    <div class="card border-start-success py-2 shadow">
        <div class="card-body">
            <div class="row align-items-center no-gutters">
                <div class="col me-2">
                    <div
                        class="text-uppercase text-success fw-bold mb-1 text-xs">
                        <span>Pendapatan Hari Ini</span>
                    </div>
                    <div class="text-dark fw-bold h5 mb-0">
                        <span>Rp{{ indonesia_format($todayRevenue) }}</span>
                    </div>
                </div>
                <div class="col-auto"><i
                        class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-xl-3 mb-4">
    <div class="card border-start-primary py-2 shadow">
        <div class="card-body">
            <div class="row align-items-center no-gutters">
                <div class="col me-2">
                    <div
                        class="text-uppercase text-primary fw-bold mb-1 text-xs">
                        <span>Pendapatan Bulan Ini</span>
                    </div>
                    <div class="text-dark fw-bold h5 mb-0">
                        <span>Rp{{ indonesia_format($monthRevenue) }}</span>
                    </div>
                </div>
                <div class="col-auto"><i
                        class="fas fa-calendar fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-xl-3 mb-4">
    <div class="card border-start-info py-2 shadow">
        <div class="card-body">
            <div class="row align-items-center no-gutters">
                <div class="col me-2">
                    <div class="text-uppercase text-info fw-bold mb-1 text-xs">
                        <span>Total Kategori</span>
                    </div>
                    <div class="text-dark fw-bold h5 mb-0">
                        <span>{{ $categories }}</span></div>
                </div>
                <div class="col-auto"><i
                        class="fas fa-tags fa-2x text-gray-300"></i></div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-6 col-xl-3 mb-4">
    <div class="card border-start-warning py-2 shadow">
        <div class="card-body">
            <div class="row align-items-center no-gutters">
                <div class="col me-2">
                    <div
                        class="text-uppercase text-warning fw-bold mb-1 text-xs">
                        <span>Total Produk</span>
                    </div>
                    <div class="text-dark fw-bold h5 mb-0">
                        <span>{{ $products }}</span></div>
                </div>
                <div class="col-auto"><i
                        class="fas fa-box fa-2x text-gray-300"></i>
                </div>
            </div>
        </div>
    </div>
</div>
