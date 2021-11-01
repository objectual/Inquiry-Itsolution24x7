@extends('admin.layouts.app')

@section('title')
    {{ $mailer->name }} <small>{{ $title }}</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($mailer, ['route' => ['admin.mailers.update', $mailer->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('admin.mailers.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection