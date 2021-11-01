@extends('admin.layouts.app')

@section('title')
    {{ $template->name }} <small>{{ $title }}</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($template, ['route' => ['admin.templates.update', $template->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('admin.templates.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection