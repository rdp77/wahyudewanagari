@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Customer'))
@section('backToContent')
<div class="section-header-back">
    <a href="{{ route('users.index') }}" class="btn btn-icon">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>
@endsection
@section('titleContent', __('Customer'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Customer') }}</div>
<div class="breadcrumb-item active">{{ __('Recycle Bin') }}</div>
@endsection

@section('content')
@include('pages.backend.components.filterSearch')
@include('layouts.backend.components.notification')
<div class="card">
    <div class="card-header">
        <div class="card-header-action">
            <button onclick="delAll()" class="btn btn-icon icon-left btn-danger">
                <i class="far fa-trash-alt"></i>{{ __('Hapus Semua') }}
            </button>
        </div>
    </div>
    <div class="card-body">
        <table class="table-striped table" id="table" width="100%">
            <thead>
                <tr>
                    <th>
                        {{ __('NO') }}
                    </th>
                    <th>{{ __('Nama') }}</th>
                    <th>{{ __('Kategori') }}</th>
                    <th>{{ __('Telepon') }}</th>
                    <th>{{ __('Email') }}</th>
                    <th>{{ __('Alamat') }}</th>
                    <th>{{ __('Dibuat') }}</th>
                    <th>{{ __('Keterangan') }}</th>
                    <th>{{ __('Aksi') }}</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('script')
<script>
    var index = '{{ route('customer.recycle') }}';
</script>
<script src="{{ asset('assets/pages/data/customer/index.js') }}"></script>
@endsection