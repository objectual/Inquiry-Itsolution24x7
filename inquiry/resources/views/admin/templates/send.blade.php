@extends('admin.layouts.app')

@section('content')
    <div class="content">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row" style="padding-left: 20px">
                    <dl class="dl-horizontal">
                        {!! Form::open(['url' => 'admin/forward', 'files' => true]) !!}
                        <div class="form-group col-sm-12">
                            {!! Form::label('sender_id', 'Sender Email:') !!}
                            {!! Form::select('sender_id', $sender ,null, ['class' => 'form-control select2', 'placeholder'=>'Enter Mailer']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('Template', 'Template:') !!}
                            {!! Form::select('subject', $template,null, ['class' => 'form-control select2', 'placeholder'=>'Enter subject']) !!}
                        </div>

                        <div class="form-group col-sm-12">
                            {!! Form::label('receiver', 'Receiver:') !!}
                            {!! Form::textarea('receiver', null, ['class' => 'form-control', 'placeholder'=>'Enter Receivers Email']) !!}
                        </div>

                        <!-- Submit Field -->
                        <div class="form-group col-sm-12">
                            {!! Form::submit('Send', ['class' => 'btn btn-primary']) !!}
                        </div>
                        {!! Form::close() !!}
                    </dl>

                </div>
            </div>
        </div>
    </div>
@endsection