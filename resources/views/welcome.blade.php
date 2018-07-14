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
                        <form id="form-create-link" method="post" class="create-link-form" action="{{ route('link.create') }}">
                            {!! csrf_field() !!}
                            <div class="form-group">
                                <label for="link">Link</label>
                                <input type="text" id="link" name="link" placeholder="Write your link" required="required" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="lifetime">Lifetime</label>
                                <input type="datetime-local" min="{{ Carbon\Carbon::now()->format('Y-m-d\TH:i') }}" name="lifetime" id="lifetime" class="form-control">
                            </div>
                            <div class="custom-control custom-checkbox form-group">
                                <input checked type="checkbox" name="active" class="custom-control-input" id="active">
                                <label class="custom-control-label" for="active">Active</label>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                Create link
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6">
                        <div data-provider="{{ route('link.created') }}" id="links-container" class="links-container">

                            {{--<div class="link-item mb-3">--}}
                                {{--<p class="text-dark mb-0 small">--}}
                                    {{--<a href="#" class="text-dark">--}}
                                        {{--http://loca.ly/RT45q--}}
                                    {{--</a>--}}
                                {{--</p>--}}
                                {{--<p class="text-muted small mb-1">--}}
                                    {{--<a href="#" class="text-muted">--}}
                                        {{--https://habr.com/company/badoo/blog/358582/--}}
                                    {{--</a>--}}
                                {{--</p>--}}
                                {{--<p class="text-secondary small mb-2">--}}
                                    {{--Активна | Дата смерти: 2323.32323.232--}}
                                {{--</p>--}}

                                {{--<div class="actions d-flex">--}}
                                    {{--<button data-toggle="tooltip" data-placement="top" title="Удалить" class="d-block btn btn-sm btn-link">--}}
                                        {{--<i class="fas fa-trash text-danger fa-sm"></i>--}}
                                    {{--</button>--}}
                                    {{--<button data-toggle="tooltip" data-placement="top" title="Редактировать" class="d-block btn btn-sm btn-link">--}}
                                        {{--<i class="fas fa-edit text-muted fa-sm"></i>--}}
                                    {{--</button>--}}
                                    {{--<button data-toggle="tooltip" data-placement="top" title="Статистика" class="d-block btn btn-sm btn-link">--}}
                                        {{--<i class="fas fa-grin-stars text-muted fa-sm"></i>--}}
                                    {{--</button>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection