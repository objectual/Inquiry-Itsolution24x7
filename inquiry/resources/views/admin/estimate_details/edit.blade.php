@extends('admin.layouts.app')

@section('title')
    {{ $estimateDetail->name }} <small>{{ $title }}</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($estimateDetail, ['route' => ['admin.estimate-details.update', $estimateDetail->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('admin.estimate_details.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection