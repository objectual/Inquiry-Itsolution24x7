<!-- Id Field -->
<dt>{!! Form::label('id', 'Id:') !!}</dt>
<dd>{!! $invoice->id !!}</dd>

<!-- Number Field -->
<dt>{!! Form::label('number', 'Number:') !!}</dt>
<dd>{!! $invoice->number !!}</dd>

<!-- Order Id Field -->
<dt>{!! Form::label('order_id', 'Order Id:') !!}</dt>
<dd>{!! $invoice->order_id !!}</dd>

<!-- From Field -->
<dt>{!! Form::label('from', 'From:') !!}</dt>
<dd>{!! $invoice->from !!}</dd>

<!-- To Field -->
<dt>{!! Form::label('to', 'To:') !!}</dt>
<dd>{!! $invoice->to !!}</dd>

<!-- Status Field -->
<dt>{!! Form::label('status', 'Status:') !!}</dt>
<dd>{!! $invoice->status !!}</dd>

<!-- Amount Field -->
<dt>{!! Form::label('amount', 'Amount:') !!}</dt>
<dd>{!! $invoice->amount !!}</dd>

<!-- Description Field -->
<dt>{!! Form::label('description', 'Description:') !!}</dt>
<dd>{!! $invoice->description !!}</dd>
