@extends('layouts.master')

@section('title')
    Daftar Pengeluaran
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Daftar Pengeluaran</li>
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <button onclick="addForm('{{ route('pengeluaran.store') }}')" class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
            </div>
            <div class="card-body table-responsive">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="example-search-input" class="form-label">Cari</label>
                            <input class="form-control form-control-sm" type="text" placeholder="Cari berdasarkan Kode / Dekskripsi / Nominal" id="cari" onkeyup="table.draw();" onchange="table.draw();">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="example-search-input" class="form-label">Periode</label>
                            <input class="form-control form-control-sm" type="text" id="periode" onchange="table.draw();" placeholder="klik untuk mengganti periode">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="example-search-input" class="form-label">Outlet</label>
                            <select name="id_outlet" id="filter_id_outlet" class="form-control form-control-sm" onchange="table.draw()">
                                <option value="">Semua Outlet</option>
                                <option value="0">Tidak Punya Outlet</option>
                                @foreach ($outlet as $item)
                                    <option value="{{$item->id}}" {{$item->id == session()->get('outlet') ? 'selected' : ''}}>{{$item->text}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-sm table-stiped table-bordered">
                            <thead>
                                <th class="text-center" width="5%">No</th>
                                <th>Kode</th>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th class="text-end">Nominal</th>
                                <th><i class="fa fa-cog"></i></th>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@includeIf('pengeluaran.form')
@endsection

@push('scripts')
<script>
    let table, periodeStart, periodeEnd;

    $(function () {
        table = $('.table').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            autoWidth: false,
            searching: false,
            ajax: {
                url: '{{ route('pengeluaran.data') }}',
                data: function(d){
                    d.dateStart = periodeStart,
                    d.dateEnd = periodeEnd,
                    d.id_outlet = $("#filter_id_outlet").val(),
                    d.search = $("#cari").val()
                },
            },
            columns: [
                {data: 'DT_RowIndex', searchable: false, sortable: false, className: "text-center"},
                {data: 'kode_pengeluaran'},
                {data: 'tanggal_pengeluaran'},
                {data: 'deskripsi'},
                {data: 'nominal', className: "text-end"},
                {data: 'aksi', searchable: false, sortable: false, className: "text-center"},
            ]
        });

        $('#modal-form').on('submit', function (e) {
            if (! e.preventDefault()) {
                const that = $(this).find('.save');
                removeErrorInput($(this));
                buttonLoading(that);
                $.post($('#modal-form form').attr('action'), $('#modal-form form').serialize())
                    .done((response) => {
                        showSuccessAlert(response.message);
                        $('#modal-form').modal('hide');
                        table.ajax.reload();
                        buttonUnloading(that, `<i class="fa fa-save"></i> Simpan`);
                    })
                    .fail((error) => {
                        buttonUnloading(that, `<i class="fa fa-save"></i> Simpan`);
                        const respJson = $.parseJSON(error.responseText);
                        if(error.status == 500 || error.status == 400) {
                            if(typeof(respJson.message) === 'object') {
                                errorInput(respJson, true);
                            } else {
                                showErrorAlert(respJson.message);
                            }
                        } else {
                            showErrorAlert(respJson.message);
                        }
                    });
            }
        });
    });

    $(document).ready(function(){
        var f4 = flatpickr(document.getElementById('periode'), {
            mode: "range",
            dateFormat: "d/m/Y",
            onChange: function(dates) {
                if (dates.length == 2) {
                    periodeStart = formatDateIso(dates[0]);
                    periodeEnd = formatDateIso(dates[1]);
                } else {
                    periodeStart = null;
                    periodeEnd = null;
                }
            }
        });
        var f3 = flatpickr(document.getElementById('tanggal_pengeluaran'), {
            dateFormat: "d/m/Y"
        });
        $("#filter_id_outlet").select2({ width: '100%' });
        $("#id_outlet").select2({ width: '100%', dropdownParent: $('.modal') });
    });

    $(document).on('keyup', '.numbersOnly', function () {
        if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
             this.value = this.value.replace(/[^0-9\.]/g, '');
        }
    });

    function addForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Tambah Pengeluaran');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('post');
    }

    function editForm(url) {
        $('#modal-form').modal('show');
        $('#modal-form .modal-title').text('Edit Pengeluaran');

        $('#modal-form form')[0].reset();
        $('#modal-form form').attr('action', url);
        $('#modal-form [name=_method]').val('put');

        $.get(url)
            .done((response) => {
                $('#modal-form [name=tanggal_pengeluaran]').val(response.TanggalPengeluaranFormat);
                $('#modal-form [name=id_outlet]').val(response.id_outlet).trigger('change');
                $('#modal-form [name=deskripsi]').val(response.deskripsi);
                $('#modal-form [name=nominal]').val(response.nominal);
            })
            .fail((errors) => {
                alert('Tidak dapat menampilkan data');
                return;
            });
    }

    function deleteData(url) {
        if (confirm('Yakin ingin menghapus data terpilih?')) {
            $.post(url, {
                    '_token': $('[name=csrf-token]').attr('content'),
                    '_method': 'delete'
                })
                .done((response) => {
                    table.ajax.reload();
                })
                .fail((errors) => {
                    alert('Tidak dapat menghapus data');
                    return;
                });
        }
    }
</script>
@endpush
