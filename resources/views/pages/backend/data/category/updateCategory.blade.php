@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Kategori'))
@section('backToContent')
@include('pages.backend.components.backToContent',['url'=>route('category.index')])
@endsection
@section('titleContent', __('Edit Kategori'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Kategori') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Kategori') }}</div>
@endsection

@section('content')
<div class="card">
    <form id="stored">
        <div class="card-body">
            <div class="form-group">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                </div>
                <input id="name" type="text" class="form-control" name="name" value="{{ $category->name }}" required
                    autofocus>
            </div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-primary mr-1" onclick="update()" type="button">{{ __('pages.edit') }}</button>
        </div>
    </form>
</div>
@endsection
@section('script')
<script>
    var url = '{{ route('category.update',$category->id) }}';
    var index = '{{ route('category.index') }}';
</script>
<script src="{{ asset('assets/pages/stored.js') }}"></script>
@endsection