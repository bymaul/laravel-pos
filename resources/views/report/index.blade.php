@section('title', 'Laporan')

<x-app-layout>

    @push('css')
        <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
    @endpush

    <div class="container-fluid">
        <h3 class="text-dark mb-4">Laporan</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row text-center text-sm-start">
                    <div class="col-sm-5 col-12 mb-3 mb-md-0">
                        <p class="text-primary m-0 fw-bold mt-2">Periode {{ indonesia_date($startDate, false) }} s/d
                            {{ indonesia_date($endDate, false) }}</p>
                    </div>
                    <div class="col-sm-7 col-12 mb-2 mb-md-0">
                        <div class="d-sm-flex justify-content-sm-end">
                            <button onclick="updatePeriod()" class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-calendar"></i>
                                </span>
                                <span class="text">Ubah Periode</span>
                            </button>
                            <a onclick="exportPdf()" class="btn btn-danger btn-icon-split ms-2">
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
                <div class="table-responsive table" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0" id="dataTable">
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
    @includeIf('report.form')

    @push('scripts')
        <script src="https://unpkg.com/gijgo@1.9.14/js/gijgo.min.js" type="text/javascript"></script>
        <script>
            let table;

            $(function() {
                table = $('#dataTable').DataTable({
                    autoWidth: false,
                    ajax: {
                        url: "{{ route('report.data', ['startDate' => $startDate, 'endDate' => $endDate]) }}",
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

                $('#startDate').datepicker({
                    value: '{{ $startDate }}',
                    format: 'yyyy-mm-dd',
                    uiLibrary: 'bootstrap5'
                })

                $('#endDate').datepicker({
                    value: '{{ $endDate }}',
                    format: 'yyyy-mm-dd',
                    uiLibrary: 'bootstrap5'
                })
            });

            $('#periodModal').on('submit', function(e) {
                if (!e.preventDefault()) {
                    let startDate = $('#startDate').val();
                    let endDate = $('#endDate').val();
                    let url = "{{ route('report.data', ['startDate' => 'start', 'endDate' => 'end']) }}";
                    url = url.replace('start', startDate);
                    url = url.replace('end', endDate);

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
                let url = "{{ route('report.export', ['startDate' => 'start', 'endDate' => 'end']) }}";
                url = url.replace('start', startDate);
                url = url.replace('end', endDate);

                window.open(url, '_blank');

            }
        </script>
    @endpush
</x-app-layout>
