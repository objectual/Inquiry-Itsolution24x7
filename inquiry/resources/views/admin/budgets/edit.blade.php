@extends('admin.layouts.app')

@section('title')
    {{ $budget->name }} <small>{{ $title }}</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($budget, ['route' => ['admin.budgets.update', $budget->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('admin.budgets.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection