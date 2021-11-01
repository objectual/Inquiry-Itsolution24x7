<!-- Order Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_id', 'Order:') !!}
    {!! Form::select('order_id', $order,null, ['class' => 'form-control select2']) !!}
</div>

<!-- Number Field -->
<div class="form-group col-sm-6">
    {!! Form::label('number', 'Number:') !!}
    {!! Form::text('number', null, ['class' => 'form-control', 'placeholder'=>'Enter number']) !!}
</div>

<!-- From Field -->
<div class="form-group col-sm-6">
    {!! Form::label('from', 'From:') !!}
    {!! Form::date('from', null, ['class' => 'form-control', 'placeholder'=>'Enter from']) !!}
</div>

<!-- To Field -->
<div class="form-group col-sm-6">
    {!! Form::label('to', 'To:') !!}
    {!! Form::date('to', null, ['class' => 'form-control', 'placeholder'=>'Enter to']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::select('status',\App\Models\Invoice::$STATUS, null, ['class' => 'form-control select2']) !!}
</div>

<!-- Amount Field -->
<div class="form-group col-sm-6">
    {!! Form::label('amount', 'Amount:') !!}
    {!! Form::text('amount', null, ['class' => 'form-control', 'placeholder'=>'Enter amount']) !!}
</div>

<!-- Description Field -->
<div class="form-group col-sm-12">
    {!! Form::label('description', 'Description:') !!}
    {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder'=>'Enter description']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary','id'=> 'btnSubmit']) !!}

    {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue','id'=> 'btnSubmit']) !!}
    <a href="{!! route('admin.invoices.index') !!}" class="btn btn-default">Cancel</a>
</div>