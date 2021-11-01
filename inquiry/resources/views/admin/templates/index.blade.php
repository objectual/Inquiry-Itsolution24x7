@extends('admin.layouts.app')

@section('title')
    {{ $title }}
    <a href="{{url('admin/send')}}">
        <button class="btn btn-default buttons-create">Send</button>
    </a>
@endsection

@section('content')
    <div class="content">
        <div class="clearfix"></div>

        @include('flash::message')

        <div class="clearfix"></div>
        <div class="box box-primary">
            <div class="box-body">
                @include('admin.templates.table')
            </div>
        </div>
        <div class="text-center">

        </div>
    </div>
@endsection

