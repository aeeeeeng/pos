<div class="offcanvas offcanvas-end" tabindex="-1" id="summary"
    aria-labelledby="summaryLabel"
    style="visibility: hidden;border-top-left-radius: 15px;border-bottom-left-radius: 15px; width:600px;"
    aria-hidden="true">
    <div class="offcanvas-header">
        <h5 id="summaryLabel" class="card-title mb-0 flex-grow-1">Ringkasan Penjualan</h5>
        <div class="flex-shrink-0">
            <ul class="nav justify-content-end nav-pills card-header-pills me-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#listProduct" role="tab" aria-selected="true">
                        <span class="d-block d-sm-none"> <i class="fas fa-shopping-cart"></i> </span>
                        <span class="d-none d-sm-block"> <i class="fas fa-shopping-cart"></i> Keranjang</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#opsional" role="tab" aria-selected="false">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block"><i class="far fa-user"></i> Member</span>
                    </a>
                </li>
            </ul>
        </div>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close" id="closeSummary"></button>
    </div>
    <div class="offcanvas-body" style="overflow-y: unset;">
        <div class="loading-summary">
            <center>
                <div class="spinner-grow text-primary mt-5" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </center>
        </div>
        <div style="overflow-y: auto;position: absolute;top: 60px;bottom: 210px;left: 0;width: 100%;/* background: #fff; */padding: 0 10px;">
            <div class="tab-content">
                <div class="tab-pane active" id="listProduct" role="tabpanel">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="productSummary"></div>
                        </div>
                    </div>
                    <div id="promoAuto" style="padding:1rem 0;"></div>
                </div>
                <div class="tab-pane" id="opsional" role="tabpanel">
                        <div class="row justify-content-md-center" data-bs-toggle="offcanvas"data-bs-target="#discountOffCanvas"aria-controls="discountOffCanvas" style="box-shadow: 0 8px 12px 0 rgb(0 0 0 / 20%);padding: 10px;margin: 3rem 30px;border-radius: 15px;color: #fff;background: linear-gradient(90deg, rgb(90 182 126), rgb(160 232 189));cursor:pointer;">
                            <div class="col-md-8 w-100">
                                <div class="d-flex flex-wrap gap-3 justify-content-center align-items-center">
                                    <div>
                                        <i class="fas fa-percent" style="font-size: 20px;border: 2px solid #fff;padding: 10px;border-radius: 50%;"></i>
                                    </div>
                                    <h5 class="mt-2 text-white">Cek Promosi !!</h5>
                                </div>
                                <div class="" style="position: absolute;right: 0;top: -15%;">
                                    <i class="fas fa-angle-right" style="font-size: 40px; padding: 10px;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-md-center" style="box-shadow: 0 8px 12px 0 rgb(0 0 0 / 20%);padding: 10px;margin: 3rem 30px;border-radius: 15px;">
                            <div class="col-md-8 w-100">
                                <div class="form-group mb-3">
                                    <label>Member</label>
                                    <select name="member" id="member" class="form-control" placeholder="Cari member" >
                                        <option value="">Cari Member</option>
                                    </select>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Diskon</label>
                                    <div class="d-flex flex-wrap gap-1 align-items-center justify-content-start">
                                        <input type="text" class="form-control numbersOnly text-end" id="diskon_value" placeholder="Masukkan nilai diskon" style="width:50%;" onchange="renderDiskon()" onkeyup="renderDiskon()">
                                        <select name="diskon_tipe" id="diskon_tipe" class="form-select" style="width:80px;" onchange="renderDiskon()">
                                            <option value="rp">Rp.</option>
                                            <option value="%">%</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label>Custom Ammount</label>
                                    <input type="text" class="form-control numbersOnly text-end" placeholder="Custom Ammount" id="customAmmount" name="customAmmount" onkeyup="renderCustomAmmount();" onchange="renderCustomAmmount();">
                                </div>
                                <div class="form-group mb-3">
                                    <label>Catatan</label>
                                    <textarea name="catatan" id="catatan" class="form-control" cols="30" rows="10" placeholder="Isian Catatan" onkeyup="renderCatatan()" onchange="renderCatatan()"></textarea>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        <div class="grand-total-bottom">
            <div class="row">
                    <div class="col-9">
                        <div class="d-flex flex-wrap gap-4 align-items-center justify-content-between">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>Member</td>
                                            <td>: <span id="nama_member"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Harga</td>
                                            <td>: <span id="grandTotal"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Diskon</td>
                                            <td>: <span id="diskkon_value_text"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Custom Amount</td>
                                            <td>: <span id="customAmmount_text"></span></td>
                                        </tr>
                                        <tr>
                                            <td>Promosi</td>
                                            <td>: <span id="promoTotal">0</span></td>
                                        </tr>
                                        <tr>
                                            <td>Catatan</td>
                                            <td>: <span id="catatan_text"></span></td>
                                        </tr>
                                    </tbody>
                                </table>
                        </div>
                    </div>
                    <div class="col-3">
                            <div style="background: linear-gradient(133deg, rgb(81 86 191), rgb(154 157 233));text-align: center;color: #fff;padding: 10px;border-radius: 15px;float: right !important;" class="h-100 align-middle">
                                <h5 style="vertical-align: middle;margin: 35% 0;" id="finalTotal" class="text-white align-middle">-</h5>
                            </div>
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-6">
                        <button type="button" class="btn btn-warning btn-lg w-100 btn-rounded mb-2">Simpan</button>
                    </div>
                    <div class="col-6">
                        <button type="button" class="btn btn-primary btn-lg w-100 btn-rounded" data-bs-toggle="offcanvas"data-bs-target="#payment"aria-controls="payment">Bayar</button>
                    </div>
                </div>
        </div>
    </div>
</div>
