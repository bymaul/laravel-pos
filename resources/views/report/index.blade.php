@section('title', 'Laporan')

<x-app-layout>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Laporan</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row text-sm-start text-center">
                    <div class="col-sm-5 col-12 mb-md-0 mb-3">
                        <p class="text-primary fw-bold m-0 mt-2">
                            Pendapatan
                        </p>
                    </div>
                    <div class="col-sm-7 col-12 mb-md-0 mb-2">
                        <div class="d-sm-flex justify-content-sm-end">
                            <a onclick="updatePeriod()"
                                class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                <span class="text">Ubah Periode</span>
                            </a>
                            <a onclick="exportPdf()"
                                class="btn btn-danger btn-icon-split ms-2">
                                <span class="icon text-white-50">
                                    <i class="fas fa-file-pdf"></i>
                                </span>
                                <span class="text">Export PDF</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table" role="grid"
                    aria-describedby="dataTable_info">
                    <table class="my-0 table" id="dataTable">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th>Tanggal</th>
                                <th>Penjualan</th>
                                <th>Pendapatan</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-report.form :startDate="$startDate" :endDate="$endDate" />

    @push('scripts')
        <script>
            let table;

            $(function() {
                table = $('#dataTable').DataTable({
                    serverSide: true,
                    responsive: true,
                    autoWidth: false,
                    ajax: {
                        url: "{{ route('report.data', [$startDate, $endDate]) }}",
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                        },
                        {
                            data: 'date'
                        },
                        {
                            data: 'total_sales'
                        },
                        {
                            data: 'revenue'
                        }
                    ],
                    dom: 'Brt',
                    bSort: false,
                    bPaginate: false,
                });
            });

            $('#periodModal').on('submit', function(e) {
                if (!e.preventDefault()) {
                    let startDate = $('#startDate').val();
                    let endDate = $('#endDate').val();
                    let url =
                        "{{ route('report.data', ['startDate', 'endDate']) }}";
                    url = url.replace('startDate', startDate).replace('endDate',
                        endDate);

                    if (startDate && endDate) {
                        table.ajax.url(url).load();
                        $('#periodModal').modal('hide');
                    }
                }
            });


            function updatePeriod() {
                $('#periodModal').modal('show');
            }

            function exportPdf() {
                let startDate = $('#startDate').val();
                let endDate = $('#endDate').val();
                let url = "{{ route('report.export', ['startDate', 'endDate']) }}";
                url = url.replace('startDate', startDate).replace('endDate', endDate);

                window.open(url, '_blank');

            }
        </script>
    @endpush
</x-app-layout>
