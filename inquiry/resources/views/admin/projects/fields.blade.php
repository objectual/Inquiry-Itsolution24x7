<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'Customer:') !!}
    {!! Form::select('user_id', $user,null, ['class' => 'form-control select2', 'placeholder'=>'Customer']) !!}
</div>

<!-- Category Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('category_id', 'Category:') !!}
    {!! Form::select('category_id', $category,null, ['class' => 'form-control select2', 'placeholder'=>'Category']) !!}
</div>

<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'placeholder'=>'Enter name']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary','id'=> 'btnSubmit']) !!}
    {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue','id'=> 'btnSubmit']) !!}
    <a href="{!! route('admin.projects.index') !!}" class="btn btn-default">Cancel</a>
</div>