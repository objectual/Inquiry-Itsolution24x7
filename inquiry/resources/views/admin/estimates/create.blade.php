@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')

        <div class="row">
            {!! Form::open(['route' => 'admin.estimates.store', 'files' => true,'id'=>'submitform']) !!}

            @include('admin.estimates.fields')

            {!! Form::close() !!}
        </div>

    </div>
@endsection
