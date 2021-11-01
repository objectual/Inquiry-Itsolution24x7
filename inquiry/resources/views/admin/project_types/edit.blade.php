@extends('admin.layouts.app')

@section('title')
    {{ $projectType->name }} <small>{{ $title }}</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($projectType, ['route' => ['admin.project-types.update', $projectType->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('admin.project_types.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection