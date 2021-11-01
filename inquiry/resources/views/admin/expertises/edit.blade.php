@extends('admin.layouts.app')

@section('title')
    {{ $expertise->name }} <small>{{ $title }}</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($expertise, ['route' => ['admin.expertises.update', $expertise->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('admin.expertises.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection