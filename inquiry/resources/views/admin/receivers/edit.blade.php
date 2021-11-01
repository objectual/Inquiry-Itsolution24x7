@extends('admin.layouts.app')

@section('title')
    {{ $receiver->name }} <small>{{ $title }}</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($receiver, ['route' => ['admin.receivers.update', $receiver->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('admin.receivers.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection