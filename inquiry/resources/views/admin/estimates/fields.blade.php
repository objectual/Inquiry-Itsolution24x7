<style>
    .center {
        text-align: center;
    }
</style>
<div class="col-sm-12">
    <div class="box box-primary">
        <div class="box-body">
            <!-- Customer Id Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('customer_id', 'Customer:') !!}
                {!! Form::select('customer_id', $customer, null, ['class' => 'form-control select2', 'placeholder'=>'Enter Customer']) !!}
            </div>

            <!-- Currency Id Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('currency_id', 'Currency:') !!}
                {!! Form::select('currency_id',\App\Models\Estimate::$CURRENY ,null, ['class' => 'form-control select2', 'placeholder'=>'Enter Currency']) !!}
            </div>

            <!-- Date Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('date', 'Date:') !!}
                {!! Form::date('date', null, ['class' => 'form-control', 'placeholder'=>'Enter date']) !!}
            </div>

            <!-- Expiry Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('expiry', 'Expiry:') !!}
                {!! Form::date('expiry', null, ['class' => 'form-control', 'placeholder'=>'Enter expiry']) !!}
            </div>

            <!-- Subheading Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('subheading', 'Subheading:') !!}
                {!! Form::text('subheading', null, ['class' => 'form-control', 'placeholder'=>'Enter subheading']) !!}
            </div>

            <!-- Footer Field -->
            <div class="form-group col-sm-6">
                {!! Form::label('footer', 'Footer:') !!}
                {!! Form::text('footer', null, ['class' => 'form-control', 'placeholder'=>'Enter footer']) !!}
            </div>

            <!-- Memo Field -->
            <div class="form-group col-sm-12">
                {!! Form::label('memo', 'Memo:') !!}
                {!! Form::textarea('memo', null, ['class' => 'form-control', 'placeholder'=>'Enter memo']) !!}
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12">

    <div class="box box-primary">
        <div class="box-body">

            <div class="clearfix"></div>
            <div class="col-sm-2 center"><b>Project Name</b></div>
            <div class="col-sm-2 center"><b>Description</b></div>
            <div class="col-sm-2 center"><b>Quantity</b></div>
            <div class="col-sm-2 center"><b>Price</b></div>
            <div class="col-sm-2 center"><b>Tax</b></div>
            <div class="col-sm-2 center"><b>Amount</b></div>

            <div id="bank" class="">

            </div>


            <div id="cards" class="bank">
                <div class="form-group col-sm-12">
                    <div style="float:right;" class="remove_trigger"><i
                                class="fa fa-times"></i></div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group col-sm-2">
                    {!! Form::select('project_id[]',$projects, null, ['class' => 'toollist form-control', 'placeholder'=>'Projects']) !!}
                </div>

                <div class="form-group col-sm-2">
                    {!! Form::text('description[]', null, ['class' => 'form-control', 'placeholder'=>'Description']) !!}
                </div>

                <div class="form-group col-sm-2">
                    {!! Form::text('quantity[]', null, ['class' => 'form-control', 'placeholder'=>'Quantity']) !!}
                </div>

                <div class="form-group col-sm-2">
                    {!! Form::text('price[]', null, ['class' => 'form-control', 'placeholder'=>'Price']) !!}
                </div>

                <div class="form-group col-sm-2">
                    {!! Form::text('tax[]', null, ['class' => 'form-control', 'placeholder'=>'Tax']) !!}
                </div>

                <div class="form-group col-sm-2">
                    <p class="center amount">100 Pkr</p>
                </div>
                <div class="clearfix"></div>
            </div>

            <div id="clonebank" class="col-sm-2" style="cursor: pointer;">
                <p style=" padding: 10px; border: 1px solid #000; margin-bottom: 10px" class="fa fa-plus"> Add a
                    Line</p>
            </div>
        </div>

    </div>

    <div class="form-group col-sm-12">
        {!! Form::submit('Save', ['class' => 'btn btn-primary' ,'id'=>'btnSubmit']) !!}
        @if(!isset($estimate))
            {!! Form::submit(__('Save And Add Translations'), ['class' => 'btn btn-primary', 'name'=>'translation','id'=>'btnTest']) !!}
        @endif
        {!! Form::submit(__('Save And Add More'), ['class' => 'btn btn-primary', 'name'=>'continue']) !!}
        <a href="{!! route('admin.estimates.index') !!}" class="btn btn-default">Cancel</a>
    </div>
</div>


<!-- Submit Field -->
<script>
    $(document).ready(function () {

        $('#clonebank').on('click', function () {
            $('#cards').clone().appendTo('#bank');
        });
    });
    $("div").on("click", ".remove_trigger", function () {

        if ($(".bank").length != 1) {
            $(this).closest('.bank').remove();
            event.preventDefault();
        } else {
            event.preventDefault();
        }
    });


</script>