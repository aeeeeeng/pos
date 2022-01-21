@extends('layouts.master')

@section('title')
    Buat Produk
@endsection

@push('css')
    <style>
        .priority-input {
            padding: 20px; background-color: rgb(81 86 190 / 6%)!important; border-radius: 15px;
        }
        .jenis-box {
            text-align: center;
            border-radius: 10px;
            padding: 20px;
            transition: 0.3s;
            cursor: pointer;
        }

        .jenis-box i {
            margin-top: 10px;
            font-size: 25px;
            color: #5156be;
        }

        .jenis-box h5 {
            color: #495057;
        }

        .jenis-box span {
            display: block;
        }

        .jenis-box:hover {
            background-color: #5156be;
            color: #fff;
        }

        .jenis-box:hover i, .jenis-box:hover h5, .jenis-box:hover span {
            color: #fff !important;
        }

        .jenis-box.active {
            background-color: #5156be;
            color: #fff;
        }

        .jenis-box.active i, .jenis-box.active h5, .jenis-box.active span {
            color: #fff !important;
        }

    </style>
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item">Daftar Produk</li>
    <li class="breadcrumb-item active">Buat Produk</li>
@endsection

@section('content')
<div class="row">

</div>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex flex-wrap gap-3 align-items-center float-end">
                    <button onclick="" class="btn btn-secondary btn-sm btn-flat">Kembali</button>
                    <button onclick="" class="btn btn-primary btn-sm btn-flat">Simpan</button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 priority-input">
                        <div class="form-group mb-3">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" class="form-control form-control-sm" id="nama_produk" name="nama_produk">
                        </div>    
                        <div class="form-group mb-3">
                            <label>Kategori</label>
                            <select class="form-control form-control-sm" name="id_kategori" id="id_kategori">
                                <option value="">Pilih Kategori</option>
                            </select>
                        </div>    
                        <div class="form-group mb-3">
                            <label>Harga</label>
                            <input type="text" class="form-control form-control-sm" id="harga_jual" name="harga_jual">
                        </div>    
                        <div class="form-group mb-3">
                            <label>SKU</label>
                            <input type="text" class="form-control form-control-sm" id="sku_produk" name="sku_produk">
                        </div>    
                        <div class="form-group mb-3">
                            <label>Barcode</label>
                            <input type="text" class="form-control form-control-sm" id="barcode_produk" name="barcode_produk">
                        </div>    
                        <div class="form-group mb-3">
                            <label>Satuan Stok</label>
                            <input type="text" class="form-control form-control-sm" id="satuan_stok" name="satuan_stok">
                        </div>    
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group mb-3">
                                    <label for="gambar"
                                        class="form-label">Foto Produk</label>
                                    <input class="form-control form-control-sm mb-2" type="file"
                                        id="gambar" name="gambar"
                                        placeholder="Masukkan Foto Produk" accept="image/*" onchange="readURL(this);" >    
                                </div>
                            </div>
                            <div class="col-md-4">
                                <img src="{{asset('img/empty.jpg')}}" style="height:100px; width:auto;" id="blah">                            
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="padding: 20px;">
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Opsi Tambahan</h5>    
                            </div>
                            <div class="col-md-6">
                                <input type="checkbox" id="additional" switch="bool" />
                                <label for="additional" data-on-label="Ya" data-off-label="Tidak"></label>
                            </div>
                        </div>
                        <div class="row" id="formAddOpt" style="display: none;">
                            <div class="col-md-12">
                                <p>And bisa memilih lebih dari satu opsi tambahan</p>
                                <button class="btn btn-warning btn-sm" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop">Tambah Opsi Tambahan</button>
                                @includeIf('produk.form-opsi-tambahan')
                                <hr>
                                <div id="listAddOpt"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">

                        <div class="accordion" id="accordionDetailProduk">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    Pengaturan Lanjutan (Opsional)
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionDetailProduk" style="">
                                    <div class="accordion-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="d-flex flex-wrap gap-2 mb-3"">
                                                    <label>Apakah Produk ini Dijual ? </label>
                                                    <div class="">
                                                        <input type="checkbox" id="dijual" switch="bool" checked />
                                                        <label for="dijual" data-on-label="Ya" data-off-label="Tidak" style="min-width: 65px;"></label>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-wrap gap-2 mb-3"">
                                                    <label>Kelola Stok ? </label>
                                                    <div class="">
                                                        <input type="checkbox" id="kelola_stok" switch="bool" checked />
                                                        <label for="kelola_stok" data-on-label="Ya" data-off-label="Tidak" style="min-width: 65px;"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                        
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="">Deskripsi Produk</label>
                                                    <textarea name="deskripsi" id="deskripsi" class="form-control form-control-sm" cols="10" rows="10"></textarea>
                                                </div>
                                                <div class="form-group mb-3">
                                                    <label for="">Pajak</label>
                                                    <select name="pajak" id="pajak" class="form-control form-control-sm">
                                                        <option value="1">Mengikuti Pajak Outlet</option>
                                                        <option value="0">Tidak Ada Pajak</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <h5>Jenis Produk</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="jenis-box active" data-nama="tunggal" onclick="setTipe('tunggal');">
                                                    <h5>Tunggal</h5>
                                                    <span class="text-muted">Produk yang tidak memiliki bahan baku</span>
                                                    <i class="fas fa-box"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="jenis-box" data-nama="komposit" onclick="setTipe('komposit');">
                                                    <h5>Komposit</h5>
                                                    <span class="text-muted">Produk yang memiliki bahan baku</span>
                                                    <i class="fas fa-hamburger"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

    let kategori = JSON.parse(`{!! $kategori !!}`);

    let opsiTambahan = {
        group: '',
        punya_bahan_baku: '0',
        detail: [{
            nama: '',
            harga: ''
        }]
    };

    $(document).ready(function(){
        renderTableOpsiTambahan();
        loadAddOpt();
        console.log(kategori);
    });

    $("#id_kategori").select2({
        placeholder: {
            id: '', 
            text: 'Pilih Kategori'
        },
        templateSelection: function (data) {
            if (data.id === '') { 
                return 'Pilih Kategori';
            }
            return data.text;
        },
        allowClear: true,
        data: kategori
    });

    // $("#id_kategori").select2({
    //     tags: true,
    //     createSearchChoice: function(term, data) {
    //         if ($(data).filter(function() {
    //             return this.text.localeCompare(term) === 0;
    //         }).length === 0) {
    //             return {
    //                 id: term,
    //                 text: term
    //             };
    //         }
    //     },
    //     ajax: {
    //         url: `{{url('kategori/data?type=select2')}}`,
    //         dataType: "json",
    //         data: function(term, page) {
    //             return {
    //                 q: term
    //             };
    //         },
    //         results: function(data, page) {
    //             return {
    //                 results: data
    //             };
    //         }
    //     }
    // });

    function setTipe(tipe)
    {
        $(".jenis-box").removeClass('active');
        $(`.jenis-box[data-nama=${tipe}]`).addClass('active');
        if(tipe == 'komposit') {
            $("#kelola_stok").prop("checked", false).prop('disabled', true);
        } else {
            $("#kelola_stok").prop("checked", true).prop('disabled', false);
        }
    }

    function loadAddOpt()
    {
        $.ajax({
            url: `{{url('produk/list-data-add-opt')}}`,
            dataType: 'json'
        }).done(response => {
            if(response.data.length == 0) {
                $("listAddOpt").html(`<h6>Belum ada data opsi tambahan</h6>`);
                return;
            }
            const list = response.data.map(item => {
                return `<div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="formCheck_${item.id_add_opt}">
                            <label class="form-check-label" for="formCheck_${item.id_add_opt}">
                                ${item.nama_add_opt}
                            </label>
                            <span class="text-muted" style="display: block;">
                                ${item.detail.map(detail => detail.nama_add_opt_detail).join(', ')}
                            </span>
                        </div>`;
            }).join(' ');
            $("#listAddOpt").html(list);
        });
    }

    // FORM OPSI TAMBAHAN

    $("#additional").on('change', function(){
        const value = $(this).is(":checked");
        if(value) {
            $("#formAddOpt").show("fast");
        } else {
            $("#formAddOpt").hide("fast");
        }
    });

    $(document).on('keyup', '.numbersOnly', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
             this.value = this.value.replace(/[^0-9\.]/g, '');
        }
    });

    function cleanArrAddOpt()
    {
        
    }

    function simpanAddOpt(that)
    {
        event.preventDefault();
        opsiTambahan.group = $("#nama_group").val();
        opsiTambahan.punya_bahan_baku = $("#punya_bahan_baku").is(":checked");
        const searchInvalidDetail = opsiTambahan.detail.filter(item => item.harga == '' || item.nama == '');
        if(searchInvalidDetail.length > 0) {
            showErrorAlert('Lengkapi isian nama opsi tambahan dan harga yang masih kosong');
            return;
        }
        if(opsiTambahan.group == '' || opsiTambahan.group == null) {
            showErrorAlert('Nama group tidak boleh kosong');
            return;
        }
        $.ajax({
            url: `{{url('produk/simpan-add-opt')}}`,
            method: 'post',
            dataType: 'json',
            contentType: "application/json",
            data: JSON.stringify({opsiTambahan}),
            beforeSend: () => {
                blockLoading();
            }
        }).done(response => {
            unBlockLoading();
            showSuccessAlert(response.message);
            opsiTambahan = {
                group: '',
                punya_bahan_baku: '0',
                detail: [{
                    nama: '',
                    harga: ''
                }]
            };
            $("#nama_group").val('');
            $("#punya_bahan_baku").prop('checked', false);
            renderTableOpsiTambahan();
            loadAddOpt();
            $("#closeCanvas").trigger('click');
        }).fail(error => {
            const respJson = $.parseJSON(error.responseText);
            showErrorAlert(respJson.message);
            unBlockLoading();
        });
    }

    function tambahRowOpsi(that)
    {
        event.preventDefault();
        const newRow = {nama: '', harga: ''};
        opsiTambahan.detail.push(newRow);
        renderTableOpsiTambahan();
    }

    function renderTableOpsiTambahan()
    {
        const row = opsiTambahan.detail.map((item, i) => {
            return `<tr>
                        <td>
                            <input type="text" class="form-control form-control-sm" value="${item.nama}" onkeyup="changeNamaAdd(this, '${i}')">
                        </td>
                        <td>
                            <input type="text" class="form-control form-control-sm text-end numbersOnly" value="${item.harga}" onkeyup="changeHargaAdd(this, '${i}')">
                        </td>
                        <td>
                            ${opsiTambahan.detail.length == 1 ? '' : `<button onclick="removeAddOpt('${i}')" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>`}                            
                        </td>
                    </tr>`;
        }).join();
        $("#tableOpsiTambahan tbody").html(row);
    }

    function changeNamaAdd(that, index)
    {
        opsiTambahan.detail[index].nama = $(that).val();
    }

    function changeHargaAdd(that, index)
    {
        if($(that).val() < 0) {
            showErrorAlert('Harga Beli tidak boleh kurang dari 0');
            $(that).val(0);
        }
        opsiTambahan.detail[index].harga = $(that).val();
    }

    function removeAddOpt(index)
    {
        event.preventDefault();
        const newData = opsiTambahan.detail.filter((item, i) => i != index);
        opsiTambahan.detail = newData;
        renderTableOpsiTambahan();
    }

    // END FORM OPSI TAMBAHAN

     function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width('auto')
                    .height('100px');
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush