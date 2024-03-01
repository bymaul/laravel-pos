@section('title', 'Transaksi')

<x-app-layout>

    @push('css')
        <style>
            #dataTable tbody tr:last-child {
                display: none;
            }
        </style>
    @endpush

    <div class="container-fluid">
        <h3 class="text-dark mb-4">Transaksi</h3>

        <div class="row g-3">
            <div class="col-12 col-lg-8 col-xl-9">
                <div class="card shadow">
                    <div class="card-header py-3">
                        <div class="row text-sm-start text-center">
                            <div class="col-sm-5 col-12 mb-md-0 mb-3">
                                <p class="text-primary fw-bold m-0 mt-2">Daftar
                                    Produk</p>
                            </div>
                            <div class="col-sm-7 col-12 mb-md-0 mb-2">
                                <div class="d-sm-flex justify-content-sm-end">
                                    <form class="productForm">
                                        @csrf
                                        <input type="hidden" name="saleId"
                                            id="saleId"
                                            value="{{ $sale_id }}">
                                        <input type="hidden" name="productId"
                                            id="productId">
                                        <input type="hidden" name="productCode"
                                            id="productCode">
                                        <a onclick="showProduct()"
                                            class="btn btn-primary btn-icon-split"><span
                                                class="icon text-white-50"><i
                                                    class="fas fa-plus"></i></span>
                                            <span
                                                class="text">Tambah</span></a>
                                    </form>
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
                                        <th width="10%">Code</th>
                                        <th>Nama</th>
                                        <th width="20%">Harga</th>
                                        <th width="15%">Jumlah</th>
                                        <th width="20%">Subtotal</th>
                                        <th width="10%"></th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 col-xl-3">
                <div class="card mb-3 shadow">
                    <div class="card-header py-3">
                        <div class="text-sm-start text-center">
                            <p class="text-primary fw-bold m-0">Detail Transaksi
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('transaction.save') }}"
                            class="saleForm" method="post">
                            @csrf
                            <input type="hidden" name="id"
                                value="{{ $sale_id }}">
                            <input type="hidden" name="total_items"
                                id="total_items">
                            <input type="hidden" name="total_price"
                                id="total_price">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control"
                                    id="inputTotal" placeholder="Total"
                                    readonly>
                                <label for="inputTotal">Total</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control"
                                    id="inputPay" placeholder="Bayar" readonly>
                                <label for="inputPay">Bayar</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number" class="form-control"
                                    id="inputReceive" placeholder="Diterima"
                                    name="received" value="0">
                                <label for="inputReceive">Diterima</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control"
                                    id="inputChange" placeholder="Kembali"
                                    name="change" readonly>
                                <label for="inputChange">Kembali</label>
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="submit"
                                    class="btn btn-success btn-icon-split">
                                    <span class="icon text-white-50"><i
                                            class="fas fa-save"></i></span>
                                    <span class="text text-white">Simpan</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-sale_detail.product :products='$products' />
    @includeIf('components.toast')

    @push('scripts')
        <script>
            let productTable, table;

            productTable = $('#productDataTable').DataTable({
                columns: [{
                    searchable: false
                }, {
                    searchable: true,
                    orderable: true
                }, {
                    searchable: true,
                    orderable: true
                }, {
                    searchable: true,
                    orderable: true
                }, {
                    orderable: false,
                    searchable: false
                }]
            })

            table = $('#dataTable').DataTable({
                serverSide: true,
                responsive: true,
                autoWidth: false,
                ajax: {
                    url: '{{ route('transaction.data', $sale_id) }}',
                },
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
                    {
                        data: 'action',
                        searchable: false,
                        sortable: false
                    },
                ],
                dom: 'Brt',
                bSort: false,
                paginate: false
            }).on('draw.dt', function() {
                loadForm($('#inputReceive').val());
                setTimeout(() => {
                    $('#inputReceive').trigger('input');
                }, 300);
            });

            $('#inputReceive').on('input', function() {
                if ($(this).val() == "") {
                    $(this).val(0).select();
                }

                loadForm($(this).val());
            }).focus(function() {
                $(this).select();
            });

            $(document).on('input', '.quantity', function() {
                let id = $(this).data('id');
                let quantity = parseInt($(this).val());

                if (quantity < 1) {
                    $(this).val(1);

                    $('#toast').addClass('text-bg-danger')
                        .removeClass('text-bg-success');
                    $('#toast').toast('show');
                    $('#toast .toast-body').text(
                        'Jumlah tidak boleh kurang dari 1!');
                    return;
                } else if (quantity > 10000) {
                    $(this).val(10000);

                    $('#toast').addClass('text-bg-danger')
                        .removeClass('text-bg-success');
                    $('#toast').toast('show');
                    $('#toast .toast-body').text(
                        'Jumlah tidak boleh lebih dari 10000!');
                    return;
                }

                $(this).on('change', function() {
                    $.post(`{{ url('/transaction') }}/${id}`, {
                        '_token': $('[name=csrf-token]').attr(
                            'content'),
                        '_method': 'put',
                        'quantity': quantity
                    }).done(response => {
                        table.ajax.reload(() => loadForm($(
                            '#inputReceive').val()));
                    }).fail(errors => {
                        $('#toast').addClass('text-bg-danger')
                            .removeClass('text-bg-success');
                        $('#toast').toast('show');
                        $('#toast .toast-body').text(
                            'Tidak dapat menambahkan kuantitas!'
                            );
                        return;
                    });
                });
            });

            function showProduct() {
                $('#productModal').modal('show');
            }

            function hideProduct() {
                $('#productModal').modal('hide');
            }

            function chooseProduct(id, code) {
                $('#productId').val(id);
                $('#productCode').val(code);
                hideProduct();
                addProduct();
            }

            function addProduct() {
                $.post('{{ route('transaction.store') }}', $('.productForm')
                    .serialize())
                    .done(response => {
                        table.ajax.reload(() => loadForm($('#inputReceive').val()));

                        $('#toast').addClass('text-bg-success')
                            .removeClass('text-bg-danger');
                        $('#toast').toast('show');
                        $('#toast .toast-body').text(
                        'Berhasil menambahkan produk!');
                    })
                    .fail(errors => {
                        $('#toast').addClass('text-bg-danger')
                            .removeClass('text-bg-success');
                        $('#toast').toast('show');
                        $('#toast .toast-body').text(
                            'Tidak dapat menambahkan produk!');
                        return;
                    });
            }

            function deleteData(url) {
                $.post(url, {
                        '_token': $('[name=csrf-token]').attr('content'),
                        '_method': 'delete'
                    })
                    .done((response) => {
                        $('#confirmModal').modal('hide');

                        table.ajax.reload(() => loadForm($('#inputReceive').val()));
                    })
                    .fail((errors) => {
                        $('#toast').addClass('text-bg-danger')
                            .removeClass('text-bg-success');
                        $('#toast').toast('show');
                        $('#toast .toast-body').text('Tidak dapat menghapus data!');
                        return;
                    });
            }

            function loadForm(received = 0) {
                $('#total_items').val($('.total_items').text());
                $('#total_price').val($('.total').text());

                $.get(
                        `{{ url('/transaction/loadform') }}/${$('.total').text()}/${received}`)
                    .done(response => {
                        $('#inputTotal').val('Rp' + response.total);
                        $('#inputPay').val('Rp' + response.pay);
                        $('#inputChange').val('Rp' + response.change);
                    })
                    .fail(errors => {
                        $('#toast').addClass('text-bg-danger')
                            .removeClass('text-bg-success');
                        $('#toast').toast('show');
                        $('#toast .toast-body').text(
                            'Tidak dapat menampilkan detail transaksi!');
                        return;
                    })
            }

            $('.saleForm').on('submit', function(e) {
                if (Number($('#inputReceive').val()) < Number($('#total_price')
                        .val())) {
                    $('#toast').addClass('text-bg-danger')
                        .removeClass('text-bg-success');
                    $('#toast').toast('show');
                    $('#toast .toast-body').text(
                        'Tidak dapat menyimpan data transaksi!');

                    e.preventDefault();
                }
            })
        </script>
    @endpush
</x-app-layout>
