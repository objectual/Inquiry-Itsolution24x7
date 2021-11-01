<div class="col-12 wizard-data">
    <h4 style="text-align: center">Request Form</h4>
    <p style="text-align: center">Please enter your email to proceed further</p>
    <form method="POST" action="{{ route('register') }}">
        {{ csrf_field() }}
        <div class="row">
            <div class="form-group col-sm-3">
            </div>
            <div class="form-group col-sm-6">
                {!! Form::email('email', $user->details->last_name?? null, ['class' => 'form-control','placeholder'=>'Email ']) !!}
            </div>
            <div class="form-group col-sm-3">
            </div>

            <div class="form-group col-sm-3">
            </div>
            <div style="text-align: center" class="form-group col-sm-6">
                {!! Form::submit('Proceed', ['class' => 'btn btn-primary']) !!}
                <a href="" class="btn btn-primary">Cancel</a>
            </div>
            <div class="form-group col-sm-3">
            </div>

        </div>
    </form>
</div>
