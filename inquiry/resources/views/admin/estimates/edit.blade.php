@extends('admin.layouts.app')

@section('title')
    {{ $estimate->name }} <small>{{ $title }}</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($estimate, ['route' => ['admin.estimates.update', $estimate->id], 'method' => 'patch', 'files' => true,'id'=>'submitform']) !!}

                        @include('admin.estimates.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection