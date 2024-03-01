@props(['startDate', 'endDate'])

<div class="modal fade" id="periodModal" tabindex="-1"
    aria-labelledby="periodModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <form action="" method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="periodModalLabel">Periode
                        Laporan</h1>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="startDate">Tanggal Awal</label>
                        <input type="date" class="form-control"
                            id="startDate" value="{{ $startDate }}">
                    </div>
                    <div class="mb-3">
                        <label for="endDate">Tanggal Akhir</label>
                        <input type="date" class="form-control"
                            id="endDate" value="{{ $endDate }}">

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                        data-bs-dismiss="modal">Batal</button>
                    <button type="submit"
                        class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
