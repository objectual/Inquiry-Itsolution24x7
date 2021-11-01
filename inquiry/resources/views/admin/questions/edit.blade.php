@extends('admin.layouts.app')

@section('title')
    {{ $question->name }} <small>{{ $title }}</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($question, ['route' => ['admin.questions.update', $question->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('admin.questions.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection