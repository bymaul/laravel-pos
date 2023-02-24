@section('title', 'Kategori')

<x-app-layout>
    <div class="container-fluid">
        <h3 class="text-dark mb-4">Kategori</h3>
        <div class="card shadow">
            <div class="card-header py-3">
                <div class="row text-center text-sm-start">
                    <div class="col-sm-5 col-12 mb-3 mb-md-0">
                        <p class="text-primary m-0 fw-bold mt-2">Daftar
                            Kategori</p>
                    </div>
                    <div class="col-sm-7 col-12 mb-2 mb-md-0">
                        <div class="d-sm-flex justify-content-sm-end">
                            <a onclick="addForm('{{ route('category.store') }}')"
                                class="btn btn-primary btn-icon-split"><span class="icon text-white-50"><i
                                        class="fas fa-plus"></i></span>
                                <span class="text">Tambah</span></a>
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
                                <th>Nama</th>
                                <th width="10%">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @includeIf('category.form')

    @push('scripts')
        <script>
            let table;

            $(function() {
                table = $('#dataTable').DataTable({
                    responsive: true,
                    serverSide: true,
                    autoWidth: false,
                    ajax: {
                        url: "{{ route('category.data') }}",
                    },
                    columns: [{
                        data: 'DT_RowIndex',
                        searchable: false
                    }, {
                        data: 'name'
                    }, {
                        data: 'action',
                        orderable: false,
                        searchable: false,
                        sortable: false
                    }]
                });

                $('#categoryModal').on('submit', function(e) {
                    if (!e.preventDefault()) {
                        $.ajax({
                            url: $('#categoryModal form').attr('action'),
                            type: 'post',
                            data: $('#categoryModal form').serialize(),
                            success: function(data) {
                                $('#categoryModal').modal('hide');
                                table.ajax.reload();
                            },
                            error: function() {
                                alert('Tidak dapat menyimpan data!');
                                return;
                            }
                        });
                    }
                })
            });

            function addForm(url) {
                $('#categoryModal').modal('show');
                $('#categoryModalLabel').text('Tambah Kategori');

                $('#categoryModal Form')[0].reset();
                $('#categoryModal Form').attr('action', url);
                $('#categoryModal [name=_method]').val('post');
                $('#categoryModal [name=categoryName]').focus();
            }

            function editForm(url) {
                $('#categoryModal').modal('show');
                $('#categoryModalLabel').text('Perbarui Kategori');

                $('#categoryModal Form')[0].reset();
                $('#categoryModal Form').attr('action', url);
                $('#categoryModal [name=_method]').val('put');
                $('#categoryModal [name=categoryName]').focus();

                $.get(url)
                    .done((response) => {
                        $('#categoryModal [name=categoryName]').val(response.name);
                    })
                    .fail((error) => {
                        alert('Tidak dapat menampilkan data!');
                        return;
                    });
            }

            function deleteData(url) {
                if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                    $.post(url, {
                            '_method': 'delete',
                            '_token': '{{ csrf_token() }}'
                        })
                        .done((response) => {
                            table.ajax.reload();
                        })
                        .fail((error) => {
                            alert('Tidak dapat menghapus data!');
                            return;
                        })
                }
            }
        </script>
    @endpush
</x-app-layout>
