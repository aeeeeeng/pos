<script>
    $("#payment").on("shown.bs.offcanvas", function () {
        const backdrop = $(".offcanvas-backdrop");
        const parent = backdrop.parent();
        const cloned = backdrop.clone();
        backdrop.remove();
        parent.append(cloned);

        payNominal = 0;
        payCardNumber = 0;
        renderFinalTotal();
        renderPayBack();
        checkPayType();
        console.log(payNominal, finalTotal);


    }).on("hide.bs.offcanvas", function () {
        $(".offcanvas-backdrop").remove();
        // loadData();
    });

    function renderFinalTotal()
    {
        $("#finalTotalResult").text(`Rp. ${formatMoney(finalTotal)}`);
    }

    function renderPayBack()
    {
        const result = (payNominal - finalTotal) > 0 ? payNominal - finalTotal : 0;
        $("#payBack").text(`Rp. ${formatMoney(result)}`);
    }

    function changeBayar(that)
    {
        const val = $(that).val();
        payNominal = isNaN(val) ? 0 : val;
        renderPayBack();
    }

    function changeCard(that)
    {
        const val = $(that).val();
        payCardNumber = val;
    }

    function checkPayType()
    {
        const val = $("#payType").val();
        if(val == 'tunai') {
            $("#elPayNominal").fadeIn();
            $("#bayar").val('');
            $("#elPayCard").fadeOut();
            payNominal = 0;
            renderPayBack();
        } else if (val == 'kartu') {
            $("#elPayNominal").fadeOut();
            $("#elPayCard").fadeIn();
            $("#card").val('');
            payNominal = finalTotal;
            renderPayBack();
        }
    }

    function doneTransaction(that)
    {
        const val = $("#payType").val();
        if(val == 'tunai') {
            if((payNominal - finalTotal) < 0) {
                showErrorAlert('Pembayaran tidak valid');
                return;
            }
        } else if (val == 'kartu') {
            if(payCardNumber == 0 || payCardNumber == '' || payCardNumber == null || payCardNumber == undefined) {
                showErrorAlert('Nomor Kartu wajib diisi');
                return;
            }
        }
        storeTransaction();
    }

    function storeTransaction()
    {
        const payType = $("#payType").val();
        const payloads = {cart, member, grandTotal, promo, promoManual, promoTotal, customAmmount, diskon, catatan, finalTotal, payType, payNominal, payCardNumber};
        $.ajax({
            url: `{{url('app/transaksi-jual/store')}}`,
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(payloads),
            beforeSend: function() {
                loadingApp();
            }
        }).done(response => {
            console.log(response);
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
            $("#thumbnail").html('');
        }).always(() => {
            unLoadingApp();
        })
    }
</script>
