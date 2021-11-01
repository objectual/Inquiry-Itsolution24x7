@extends('admin.layouts.app')

@section('title')
    {{ $description->name }} <small>{{ $title }}</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($description, ['route' => ['admin.descriptions.update', $description->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('admin.descriptions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection