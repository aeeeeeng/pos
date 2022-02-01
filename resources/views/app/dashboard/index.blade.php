@extends('app.layouts.master')

@section('title')
    Dashboard
@endsection

@push('css')
    <style>
    </style>
@endpush

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-success btn-sm btn-flat"><i class="fa fa-plus-circle"></i> Tambah</button>
                </div>
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
</script>
@endpush
