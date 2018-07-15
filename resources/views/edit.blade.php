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
                        <label>Lifetime</label>
                        <div class="form-row">
                            <div class="col-7">
                                <input type="date" name="date" min="{{ Carbon\Carbon::now()->toDateString() }}" value="{{ $date }}" class="form-control">
                            </div>
                            <div class="col-5">
                                <input type="time" name="time" value="{{ $time }}" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="custom-control custom-checkbox form-group">
                        <input {{ $active ? 'checked' : '' }} type="checkbox" name="active" class="custom-control-input" id="active">
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