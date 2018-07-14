@extends('layouts.base')
@section('title', 'Edit my link')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 col-lg-5 col-xl-4 mx-auto">
                <form method="post" class="create-link-form" action="{{ route('link.edit.save', $link_id) }}">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label for="link">Link</label>
                        <input type="text" disabled="disabled" value="{{ $original }}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="lifetime">Lifetime</label>
                        <input type="datetime-local" name="lifetime" min="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" id="lifetime" value="{{ $lifetime }}" class="form-control">
                    </div>
                    <div class="custom-control custom-checkbox form-group">
                        <input {{ intval($active) === 1 ? 'checked' : '' }} type="checkbox" name="active" class="custom-control-input" id="active">
                        <label class="custom-control-label" for="active">Active</label>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-light">
                        Cancel
                    </a>
                </form>
            </div>
        </div>
    </div>
@endsection