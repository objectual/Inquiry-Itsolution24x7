@extends('admin.layouts.app')

@section('title')
    {{ $title }}
@endsection

@section('content')
    <div class="content">
        @include('adminlte-templates::common.errors')
        <div class="box box-primary">

            <div class="box-body">
                <div class="row">
                    {!! Form::open(['route' => 'admin.projects.store', 'files' => true, 'id'=>'submitform']) !!}

                    @include('admin.projects.fields')

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
