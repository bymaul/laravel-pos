<div class="modal fade" id="categoryModal" tabindex="-1"
    aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="" method="POST">
            @csrf
            @method('POST')
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="categoryModalLabel"></h1>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating">
                        <input type="text" class="form-control"
                            name="categoryName" id="categoryName"
                            placeholder="Nama Kategori"
                            aria-describedby="categoryHelp" required>
                        <label for="categoryName">Nama Kategori</label>
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
