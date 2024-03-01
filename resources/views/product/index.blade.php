@section('title', 'Produk')

<x-app-layout>

    @push('css')
        <style>
            .table-responsive::-webkit-scrollbar {
                display: none !important;
            }

            .table-responsive {
                scrollbar-width: none !important;
                -ms-overflow-style: none !important;
            }
        </style>
    @endpush

    <div class="container-fluid">
        <h3 class="text-dark mb-4">Produk</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row text-sm-start text-center">
                    <div class="col-sm-5 col-12 mb-md-0 mb-3">
                        <p class="text-primary fw-bold m-0 mt-2">Daftar Produk
                        </p>
                    </div>
                    <div class="col-sm-7 col-12 mb-md-0 mb-2">
                        <div class="d-sm-flex justify-content-sm-end">
                            <button
                                onclick="addForm('{{ route('product.store') }}')"
                                class="btn btn-primary btn-icon-split">
                                <span class="icon text-white-50">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="text">Tambah</span>
                            </button>
                            <button
                                onclick="deleteSelected('{{ route('product.delete-selected') }}')"
                                class="btn btn-danger btn-icon-split ms-2">
                                <span class="icon text-white-50">
                                    <i class="fas fa-trash"></i>
                                </span>
                                <span class="text">Hapus</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table" role="grid"
                    aria-describedby="dataTable_info">
                    <form action="" method="POST" class="selectedForm">
                        @csrf
                        <table class="my-0 table" id="dataTable">
                            <thead>
                                <tr>
                                    <th width="3%">
                                        <input type="checkbox" name="selectAll"
                                            id="selectAll">
                                    </th>
                                    <th width="5%">No.</th>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Kategori</th>
                                    <th>Harga</th>
                                    <th width="10%"></th>
                                </tr>
                            </thead>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <x-product.form :categories='$categories' />

    @includeIf('components.toast')
    @includeIf('components.modal')

    @push('scripts')
        <script>
            let table;

            $(function() {
                table = $('#dataTable').DataTable({
                    serverSide: true,
                    responsive: true,
                    autoWidth: false,
                    ajax: {
                        url: "{{ route('product.data') }}",
                    },
                    columns: [{
                            data: 'selectAll',
                            searchable: false,
                            orderable: false
                        },
                        {
                            data: 'DT_RowIndex',
                            searchable: false
                        },
                        {
                            data: 'code'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'category'
                        },
                        {
                            data: 'price'
                        },
                        {
                            data: 'action',
                            searchable: false,
                            orderable: false,
                        }
                    ],
                    order: [
                        [1, 'asc']
                    ]
                });

                $('#productModal').on('submit', function(e) {
                    if (!e.preventDefault()) {
                        $.post($('#productModal form').attr('action'),
                                $('#productModal form').serialize())
                            .done((response) => {
                                $('#productModal').modal('hide');
                                table.ajax.reload();

                                $('#toast').addClass(
                                        'text-bg-success')
                                    .removeClass('text-bg-danger');
                                $('#toast').toast('show');
                                $('#toast .toast-body').text(
                                    'Data berhasil disimpan!');
                            })
                            .fail((error) => {
                                $('#toast').addClass(
                                        'text-bg-danger')
                                    .removeClass('text-bg-success');
                                $('#toast').toast('show');
                                $('#toast .toast-body').text(
                                    'Tidak dapat menyimpan data!'
                                    );
                                return;
                            })
                    }
                });

                $('#selectAll').click(function() {
                    $('input[type=checkbox]').prop('checked', this
                        .checked);
                });

            });

            function addForm(url) {
                $('#productModal').modal('show');
                $('#productModalLabel').text('Tambah Produk');

                $('#productModal Form')[0].reset();
                $('#productModal Form').attr('action', url);
                $('#productModal [name=_method]').val('post');
                $('#productModal [name=productName]').focus();
            }

            function editForm(url) {
                $('#productModal').modal('show');
                $('#productModalLabel').text('Perbarui Produk');

                $('#productModal Form')[0].reset();
                $('#productModal Form').attr('action', url);
                $('#productModal [name=_method]').val('put');

                $.get(url)
                    .done((response) => {
                        $('#productModal [name=productName]').val(response.name);
                        $('#productModal [name=productCategoryId]').val(response
                            .category_id);
                        $('#productModal [name=productPrice]').val(response.price);
                    })
                    .fail((error) => {
                        $('#toast').addClass('text-bg-danger')
                            .removeClass('text-bg-success');
                        $('#toast').toast('show');
                        $('#toast .toast-body').text('Tidak dapat menyimpan data!');
                        return;
                    });
            }

            function deleteData(url) {
                $('#confirmModal').modal('show');
                $('#confirmModal .modal-body').text(
                    'Apakah Anda yakin ingin menghapus data ini?');

                $('#confirmDelete').click(function() {
                    $.post(url, {
                            '_method': 'delete',
                            '_token': $('[name=csrf-token]').attr('content')
                        })
                        .done((response) => {
                            $('#confirmModal').modal('hide');
                            table.ajax.reload();

                            $('#toast').addClass('text-bg-success')
                                .removeClass('text-bg-danger');
                            $('#toast').toast('show');
                            $('#toast .toast-body').text(
                                'Data berhasil dihapus!');
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

            function deleteSelected(url) {
                if ($('input:checked').length >= 1) {
                    $('#confirmModal').modal('show');
                    $('#confirmModal .modal-body').text(
                        'Apakah Anda yakin ingin menghapus data terpilih?');

                    $('#confirmDelete').click(function() {
                        $.post(url, $('.selectedForm').serialize())
                            .done((response) => {
                                $('input:checked').prop('checked', false);
                                $('#confirmModal').modal('hide');
                                table.ajax.reload();

                                $('#toast').addClass('text-bg-success')
                                    .removeClass('text-bg-danger');
                                $('#toast').toast('show');
                                $('#toast .toast-body').text(
                                    'Data berhasil dihapus!');
                            })
                            .fail((errors) => {
                                $('#toast').addClass('text-bg-danger')
                                    .removeClass('text-bg-success');
                                $('#toast').toast('show');
                                $('#toast .toast-body').text(
                                    'Tidak dapat menghapus data!');
                                return;
                            })
                    });
                } else {
                    $('#toast').addClass('text-bg-danger')
                        .removeClass('text-bg-success');
                    $('#toast').toast('show');
                    $('#toast .toast-body').text('Pilih data yang akan dihapus!');
                    return;
                }
            }
        </script>
    @endpush
</x-app-layout>
