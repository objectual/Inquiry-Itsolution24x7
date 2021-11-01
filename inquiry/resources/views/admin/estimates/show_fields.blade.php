<!-- Customer Id Field -->
<dt>{!! Form::label('customer_id', 'Customer:') !!}</dt>
<dd>{!! $estimate->customer->name!!}</dd>

<!-- Currency Id Field -->
<dt>{!! Form::label('currency_id', 'Currency Id:') !!}</dt>
<dd>{!! ($estimate->currency_id == 0) ? 'PKR' : 'Dollar' !!}</dd>

<!-- Date Field -->
<dt>{!! Form::label('date', 'Date:') !!}</dt>
<dd>{!! date('d-m-Y', strtotime($estimate->date))!!}</dd>

<!-- Expiry Field -->
<dt>{!! Form::label('expiry', 'Expiry:') !!}</dt>
<dd>{!! date('d-m-Y', strtotime($estimate->expiry) )!!}</dd>

<!-- Subheading Field -->
<dt>{!! Form::label('subheading', 'Subheading:') !!}</dt>
<dd>{!! $estimate->subheading !!}</dd>

<!-- Footer Field -->
<dt>{!! Form::label('footer', 'Footer:') !!}</dt>
<dd>{!! $estimate->footer !!}</dd>

<!-- Memo Field -->
<dt>{!! Form::label('memo', 'Memo:') !!}</dt>
<dd>{!! $estimate->memo !!}</dd>

