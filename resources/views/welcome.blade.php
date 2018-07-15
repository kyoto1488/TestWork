@extends('layouts.base')
@section('title', 'Test work')
@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                @if (session()->has('success'))
                    <div class="row">
                        <div class="col">
                            <div class="alert alert-primary alert-dismissible fade show" role="alert">
                                <strong>{{ session()->get('success') }}</strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="create-link-form">
                            <div data-component="form-create-link"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div data-component="created-links-list" class="links-container"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection