<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
    <div class="offcanvas-header">
        <h5 id="offcanvasRightLabel">Tambah Opsi Tambahan</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group mb-3">
                    <label for="group">Nama Group Opsi Tambahan</label>
                    <input type="text" class="form-control form-control-sm" id="nama_group" name="nama_group">
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-hover table-sm" id="tableOpsiTambahan">
                    <thead>
                        <tr>
                            <th>Nama Opsi Tambahan</th>
                            <th class="text-end">Harga</th>
                            <th>#</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">
                                <a href="#" onclick="tambahRowOpsi(this);" class="text-primary">Tambah Opsi Lain</a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex flex-wrap gap-2 mb-3"">
                    <label>Apakah Produk Memiliki Bahan Baku ? </label>
                    <div class="">
                        <input type="checkbox" id="punya_bahan_baku" switch="bool" />
                        <label for="punya_bahan_baku" data-on-label="Ya" data-off-label="Tidak"></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="position: absolute;bottom: 20px;right: 30px;">
            <div class="col-md-12">
                <div class="text-end">
                    <button class="btn btn-secondary btn-sm" id="closeCanvas" data-bs-dismiss="offcanvas">Batal</button>
                    <button onclick="simpanAddOpt(this)" class="btn btn-primary btn-sm">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</div>