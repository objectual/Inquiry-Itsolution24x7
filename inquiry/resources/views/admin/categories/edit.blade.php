@extends('admin.layouts.app')

@section('title')
    {{ $category->name }} <small>{{ $title }}</small>
@endsection

@section('content')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($category, ['route' => ['admin.categories.update', $category->id], 'method' => 'patch', 'files' => true]) !!}

                        @include('admin.categories.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection