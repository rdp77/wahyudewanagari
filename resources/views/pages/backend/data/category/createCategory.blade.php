@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Tambah Kategori'))
@section('backToContent')
@include('pages.backend.components.backToContent',['url'=>route('category.index')])
@endsection
@section('titleContent', __('Tambah Kategori'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Kategori') }}</div>
<div class="breadcrumb-item active">{{ __('Tambah Kategori') }}</div>
@endsection

@section('content')
<div class="card">
    <form id="stored">
        <div class="card-body">
            <div class="form-group">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                </div>
                <input id="name" type="text" class="form-control" name="name" autofocus>
            </div>
            <div class="card-footer text-right">
                <button class="btn btn-primary mr-1" type="button" onclick="save()">{{ __('Tambah') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    var url = '{{ route('category.store') }}';
    var index = '{{ route('category.index') }}';
</script>
<script src="{{ asset('assets/pages/stored.js') }}"></script>
@endsection