@section('title', 'Penjualan')

<x-app-layout>
    <div class="container-fluid">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show"
                role="alert">
                <strong>{{ session('success') }}</strong>
                {{--
                // uncomment this if you want to print the note
                    <hr>
                <a onclick="printNote('{{ route('sale.print') }}', 'Nota')" class="btn btn-success text-white">Cetak
                    Nota</a> --}}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
            </div>
        @endif

        <h3 class="text-dark mb-4">Penjualan</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row text-sm-start text-center">
                    <div class="col-sm-5 col-12 mb-md-0 mb-3">
                        <p class="text-primary fw-bold m-0 mt-2">Daftar
                            Penjualan</p>
                    </div>
                    <div class="col-sm-7 col-12 mb-md-0 mb-2">
                        <div class="d-sm-flex justify-content-sm-end">
                            <a href="{{ route('transaction.index') }}"
                                class="btn btn-primary btn-icon-split"><span
                                    class="icon text-white-50"><i
                                        class="fas fa-plus"></i></span>
                                <span class="text">Tambah</span></a>
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
                                <th width="15%">Tanggal</th>
                                <th>Total Item</th>
                                <th>Total Harga</th>
                                <th width="20%">Kasir</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-sale.detail />

    @includeIf('components.toast')
    @includeIf('components.modal')

    @push('scripts')
        <script>
            let table, detailTable;

            $(function() {
                table = $('#dataTable').DataTable({
                    serverSide: true,
                    responsive: true,
                    autoWidth: false,
                    ajax: {
                        url: "{{ route('sale.data') }}",
                    },
                    columns: [{
                        data: 'DT_RowIndex',
                        searchable: false
                    }, {
                        data: 'date'
                    }, {
                        data: 'total_items'
                    }, {
                        data: 'total_price'
                    }, {
                        data: 'cashier'
                    }, {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        sortable: false
                    }]
                });

                detailTable = $('#detailDataTable').DataTable({
                    bSort: false,
                    dom: 'Brt',
                    columns: [{
                            data: 'DT_RowIndex',
                            searchable: false,
                            sortable: false
                        },
                        {
                            data: 'code'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'price'
                        },
                        {
                            data: 'quantity'
                        },
                        {
                            data: 'subtotal'
                        },
                    ]
                })
            });

            function showDetail(url) {
                $('#detailModal').modal('show');

                detailTable.ajax.url(url);
                detailTable.ajax.reload();
            }

            function deleteData(url) {
                $('#confirmModal').modal('show');
                $('#confirmModal .modal-body').text(
                    'Apakah Anda yakin ingin menghapus data ini?');

                $('#confirmDelete').click(function() {
                    $.post(url, {
                            '_method': 'delete',
                            '_token': '{{ csrf_token() }}'
                        })
                        .done((response) => {
                            $('#confirmModal').modal('hide');
                            table.ajax.reload();

                            $('#toast').addClass('text-bg-success')
                                .removeClass('text-bg-danger');
                            $('#toast').toast('show');
                            $('#toast .toast-body').text(
                                'Berhasil menghapus data!');
                        })
                        .fail((error) => {
                            $('#toast').addClass('text-bg-danger')
                                .removeClass('text-bg-success');
                            $('#toast').toast('show');
                            $('#toast .toast-body').text(
                                'Tidak dapat menghapus data!');
                            return;
                        })
                })
            }

            function printNote(url, title) {
                popupCenter(url, title, 625, 500);
            }

            function popupCenter(url, title, w, h) {
                const dualScreenLeft = window.screenLeft !== undefined ? window
                    .screenLeft : window.screenX;
                const dualScreenTop = window.screenTop !== undefined ? window
                    .screenTop : window.screenY;

                const width = window.innerWidth ? window.innerWidth : document
                    .documentElement.clientWidth ? document
                    .documentElement.clientWidth : screen.width;
                const height = window.innerHeight ? window.innerHeight : document
                    .documentElement.clientHeight ? document
                    .documentElement.clientHeight : screen.height;

                const systemZoom = width / window.screen.availWidth;
                const left = (width - w) / 2 / systemZoom + dualScreenLeft
                const top = (height - h) / 2 / systemZoom + dualScreenTop
                const newWindow = window.open(url, title,
                    `
                    scrollbars=yes,
                    width  = ${w / systemZoom},
                    height = ${h / systemZoom},
                    top    = ${top},
                    left   = ${left}
                    `
                );

                if (window.focus) newWindow.focus();
            }
        </script>
    @endpush
</x-app-layout>
