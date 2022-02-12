<div class="offcanvas offcanvas-end" tabindex="-1" id="discountOffCanvas"
    aria-labelledby="discountOffCanvasLabel"
    style="visibility: hidden;border-top-left-radius: 15px;border-bottom-left-radius: 15px; width:600px;"
    aria-hidden="true">
    <div class="offcanvas-header">
        <h5 id="discountOffCanvasLabel" class="card-title mb-0 flex-grow-1">Diskon Tersedia</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close" id="closeDiscountOffCanvas"></button>
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
            <div class="row">
                <div class="col-md-12">
                    <table class="table w-100" id="tableDiscountManual">
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="grand-total-bottom">
            <div class="row mt-2">
                <div class="col-12">
                    <button type="button" class="btn btn-secondary btn-lg w-100 btn-rounded mb-2"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#summary"
                        aria-controls="summary" onclick="openSummary()"
                    >Kembali</button>
                </div>
            </div>
        </div>
    </div>
</div>
