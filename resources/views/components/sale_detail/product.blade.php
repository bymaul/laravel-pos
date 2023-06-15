@props(['products'])

<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="productModalLabel">Pilih Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive table mt-2" role="grid" aria-describedby="dataTable_info">
                    <table class="table my-0" id="productDataTable">
                        <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th width="5%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $key => $item)
                                <tr>
                                    <td width="5%">{{ $key + 1 }}</td>
                                    <td><span class="badge bg-success">{{ $item->code }}</span></td>
                                    <td>{{ $item->name }}</td>
                                    <td>Rp{{ indonesia_format($item->price) }}</td>
                                    <td width="5%">
                                        <a class="btn btn-sm btn-primary btn-icon-split"
                                            onclick="chooseProduct('{{ $item->id }}', '{{ $item->code }}')">
                                            <span class="icon text-white-50"><i class="fas fa-check"></i></span>
                                            <span class="text">Pilih</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
