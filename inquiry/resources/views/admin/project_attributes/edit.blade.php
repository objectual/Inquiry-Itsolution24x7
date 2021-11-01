@extends('admin.layouts.app')

@section('title')
    {{ $projectAttribute->name }} <small>{{ $title }}</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($projectAttribute, ['route' => ['admin.project-attributes.update', $projectAttribute->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('admin.project_attributes.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection