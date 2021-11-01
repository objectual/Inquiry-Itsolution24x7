@extends('admin.layouts.app')

@section('title')
    {{ $project->name }} <small>{{ $title }}</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($project, ['route' => ['admin.projects.update', $project->id], 'method' => 'patch', 'files' => true,'id'=>'submitform']) !!}

                        @include('admin.projects.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection