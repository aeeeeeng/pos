<div class="offcanvas offcanvas-end" tabindex="-1" id="payment"
    aria-labelledby="PaymentLabel"
    style="visibility: hidden;border-top-left-radius: 15px;border-bottom-left-radius: 15px; width:600px;"
    aria-hidden="true">
    <div class="offcanvas-header">
        <h5 id="PaymentLabel" class="card-title mb-0 flex-grow-1">Pembayaran</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close" id="closePayment"></button>
    </div>
    <div class="offcanvas-body" style="overflow-y: unset;">
        <div style="overflow-y: auto;position: absolute;top: 60px;bottom: 210px;left: 0;width: 100%;/* background: #fff; */padding: 0 10px;">
            <div class="row justify-content-md-center">
                <div class="col-md-12">
                    <div style="background: linear-gradient(133deg, rgb(81 86 191), rgb(154 157 233));vertical-align: middle;text-align: center;justify-content: stretch;color: #fff;padding: 10px;border-radius: 15px;/* float: right !important; */width: 100%;height: 100px !important;margin: 0 auto;" class="h-100 align-middle">
                        <p class="text-white text-center">Total Bayar</p>
                        <h1 style="" id="finalTotalResult" class="text-white align-middle">Rp. 500.000</h1>
                    </div>
                </div>
            </div>
            <div class="row justify-content-md-center" style="box-shadow: 0 8px 12px 0 rgb(0 0 0 / 20%);padding: 10px;margin: 3rem 30px;border-radius: 15px;">
                <div class="col-md-8 w-100">
                    <div class="form-group mb-3">
                        <label>Tipe Pembayaran</label>
                        <select name="payType" id="payType" class="form-select" placeholder="..."  onchange="checkPayType();">
                            <option value="tunai">Tunai</option>
                            <option value="kartu">Kartu</option>
                        </select>
                    </div>

                    <div class="form-group mb-3" id="elPayNominal">
                        <label>Nominal Bayar</label>
                        <input type="number" class="form-control numbersOnly text-end" id="bayar" name="bayar" placeholder="Isi Nominal Pembayaran" onchange="changeBayar(this)" onkeyup="changeBayar(this)" autocomplete="off">
                    </div>

                    <div class="form-group mb-3" id="elPayCard">
                        <label>Nomor Kartu</label>
                        <input type="number" class="form-control numbersOnly text-end" id="card" name="card" placeholder="Isi Nominal Pembayaran" onchange="changeCard(this)" onkeyup="changeCard(this)" autocomplete="off">
                    </div>

                </div>
            </div>
        </div>
        <div class="grand-total-bottom">
            <div class="row justify-content-md-center mt-3 mb-3">
                <div class="col-md-12">
                    <div style="background:linear-gradient(133deg, rgb(255 56 185), rgb(254 195 222));vertical-align: middle;text-align: center;justify-content: stretch;color: #fff;padding: 10px;border-radius: 15px;/* float: right !important; */width: 100%;height: 100px !important;margin: 0 auto;" class="h-100 align-middle">
                        <p class="text-white text-center">Kembalian</p>
                        <h1 style="" id="payBack" class="text-white align-middle">Rp. 500.000</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-primary btn-lg w-100" onclick="doneTransaction(this)">Selesai</button>
                </div>
            </div>
        </div>

    </div>
</div>
