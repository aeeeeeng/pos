<script>
        $("#discountOffCanvas").on("shown.bs.offcanvas", function () {
            const backdrop = $(".offcanvas-backdrop");
            const parent = backdrop.parent();
            const cloned = backdrop.clone();
            backdrop.remove();
            parent.append(cloned);

            loadPromoManual();
            var tmpPromo = [];
        }).on("hide.bs.offcanvas", function () {
            $(".offcanvas-backdrop").remove();
            // loadData();
        });

        function loadPromoManual()
        {
            $.ajax({
                url: `{{url('app/transaksi-jual/get-promo-manual')}}`,
                method: `get`,
                dataType: 'json',
                contentType: 'application/json',
                beforeSend: function(){
                    $(".loading-summary").fadeIn();
                }
            }).done(response => {
                const {data} = response;
                const htmlRow = data.map(item => `<tr class="bg-success text-white ">
                                    <td>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="discountManual${item.id}" onclick="setPromoManual(this, '${item.id}')">
                                            <label class="form-check-label" for="discountManual${item.id}">
                                                ${item.nama_promo}
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-danger text-end">
                                        ${item.diskon_unit == 'rp' ? formatMoney(item.diskon_val) : `${item.diskon_val}%`}
                                    </td>
                                </tr>`).join(' ');
                $("#tableDiscountManual tbody").html(htmlRow);
                promoManual.map(item => {
                    $(`#discountManual${item.id}`).prop('checked', true);
                });
                $(".loading-summary").fadeOut();
            }).fail(error => {
                $(".loading-summary").fadeOut();
                const respJson = $.parseJSON(error.responseText);
                showErrorAlert(respJson.message);
            })
        }

        function setPromoManual(that, id)
        {
            if($(that).is(':checked') == true) {
                $.ajax({
                    url: `{{url('app/transaksi-jual/get-promo-manual')}}`,
                    method: `get`,
                    dataType: 'json',
                    contentType: 'application/json',
                    data: {id}
                }).done(response => {
                    const {data} = response;
                    const item = data[0];
                    promoManual.push(item);
                    showSuccessAlert(`Menerapkan ${item.nama_promo}`);
                }).fail(error => {
                    const respJson = $.parseJSON(error.responseText);
                    showErrorAlert(respJson.message);
                    $(that).attr('checked', false);
                    const newPromo = promoManual.filter(item => (item.id && item.id != id));
                    promoManual = newPromo;
                });
            } else {
                const newPromo = promoManual.filter(item => (item.id && item.id != id));
                promoManual = newPromo;
                showSuccessAlert('Membatalkan promo');
            }
        }
    </script>
