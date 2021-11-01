<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder'=>'Enter email']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {{--    {!! Form::label('type', 'Type:') !!}--}}
    {!! Form::hidden('type', 2, ['class' => 'form-control', 'placeholder'=>'Enter type']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    @if(!isset($receiver))
        {!! Form::submit(__('Save And Add Translations'), ['class' => 'btn btn-primary', 'name'=>'translation']) !!}
    @endif
    {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
    <a href="{!! route('admin.receivers.index') !!}" class="btn btn-default">Cancel</a>
</div>