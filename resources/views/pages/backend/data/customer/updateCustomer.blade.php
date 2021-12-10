@extends('layouts.backend.default')
@section('title', __('pages.title').__(' | Edit Customer'))
@section('backToContent')
@include('pages.backend.components.backToContent',['url'=>route('customer.index')])
@endsection
@section('titleContent', __('Edit Customer'))
@section('breadcrumb', __('Data'))
@section('morebreadcrumb')
<div class="breadcrumb-item active">{{ __('Customer') }}</div>
<div class="breadcrumb-item active">{{ __('Edit Customer') }}</div>
@endsection

@section('content')
<div class="card">
    <form id="stored">
        <div class="card-body">
            <div class="form-group">
                <div class="d-block">
                    <label for="name" class="control-label">{{ __('Nama') }}<code>*</code></label>
                </div>
                <input id="name" type="text" class="form-control" name="name" value="{{ $customer->name }}" autofocus>
            </div>
            <div class="form-group">
                <div class="d-block">
                    <label class="control-label">{{ __('Kategori') }}<code>*</code></label>
                </div>
                <select class="select2 ajax" name="category">
                    <option value="">{{ __('Pilih Kategori') }}</option>
                    @foreach ($category as $c)
                    <option value="{{ $c->id }}" @if ($c->id == $customer->category_id) selected @endif>
                        {{ $c->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Telepon') }}<code>*</code></label>
                        </div>
                        <input type="text" class="form-control" name="tlp" value="{{ $customer->tlp }}">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="d-block">
                            <label class="control-label">{{ __('Email') }}<code>*</code></label>
                        </div>
                        <input type="email" class="form-control" name="email" value="{{ $customer->email }}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="d-block">
                    <label class="control-label">{{ __('Alamat') }}<code>*</code></label>
                </div>
                <input type="text" class="form-control" name="address" value="{{ $customer->address }}">
            </div>
            <div class="form-group">
                <label>{{ __('Keterangan') }}<code>*</code></label>
                <textarea type="text" class="form-control validation" name="desc" style="height: 100px;">
                    {{ $customer->desc }}
                </textarea>
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
    var url = '{{ route('customer.update',$customer->id) }}';
    var index = '{{ route('customer.index') }}';
</script>
<script src="{{ asset('assets/pages/stored.js') }}"></script>
@endsection