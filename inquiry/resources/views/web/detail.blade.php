<div class="col-10 wizard-data">
    <h4>Details</h4>
    <p>Step 2 of 7</p>
    @include('adminlte-templates::common.errors')
    <form method="POST" action="{{ url('DetailStore') }}" enctype="multipart/form-data">
        @csrf
        <div class="col-sm-12">
            <p><b>What type of projects do you have?</b></p>
            <div class="row">
                <div id="onetime" class="col-sm-3 detail-list">
                    <i class="fa fa-briefcase fa-4x icon"></i>
                    <p>One-Time Project</p>
                </div>

                <div id="ongoing" class="col-sm-3 detail-list">
                    <i class="fa fa-file-text fa-4x icon"></i>
                    <p>Ongoing Project</p>
                </div>

                <div id="notsure" class="col-sm-3 detail-list">
                    <i class="fa fa-question fa-4x icon"></i>
                    <p>I am not sure</p>
                </div>
            </div>
        </div>

        <div class="col-sm-12 onetimecontent" style="display: none">
            <p><b>Which of the following best describe your project?</b></p>
            <ul>
                <li> {{ Form::radio('describe', '1', isset($content->describe) && ($content->describe == 1) ? true: false) }}
                    Fix a bug
                </li>
                <li> {{ Form::radio('describe', '2', isset($content->describe) && ($content->describe == 2) ? true: false) }}
                    Install/Integrate
                    Software
                </li>
                <li> {{ Form::radio('describe', '3', isset($content->describe) && ($content->describe == 3) ? true: false) }}
                    Develop website from
                    scratch
                </li>
                <li> {{ Form::radio('describe', '4', isset($content->describe) && ($content->describe == 4) ? true: false) }}
                    Create a landing
                    page
                </li>
                <li> {{ Form::radio('describe', '5', isset($content->describe) && ($content->describe == 5) ? true: false) ,['id'=>'other'] }}
                    Other
                </li>

                <li class="othertext"> {!! Form::text('othertext', isset($content->othertext) ? $content->othertext: null , ['class' => 'form-control'])!!}</br>
                </li>
            </ul>
        </div>

        <div class="col-sm-12 ongoingcontent" style="display:none ;">
            <p><b>Which type of work you want from us?</b></p>
            <ul>
                <li> {{ Form::checkbox('designer', '1', isset($content->designer) && ($content->designer != null)  ? true : false ) }}
                    Designing
                </li>
                <li> {{ Form::checkbox('developer', '2', isset($content->developer) && ($content->developer != null)  ? true : false ) }}
                    Developing
                </li>
                <li> {{ Form::checkbox('project_manager', '3', isset($content->project_manager) && ($content->project_manager != null)  ? true : false ) }}
                    Project Management
                </li>
                <li> {{ Form::checkbox('analyst', '4', isset($content->analyst) && ($content->analyst != null)  ? true : false ) }}
                    Business
                    Analysation
                </li>
                <li> {{ Form::checkbox('qa', '5', isset($content->qa) && ($content->qa != null)  ? true : false ) }}
                    QA
                </li>
                <li> {{ Form::checkbox('other', '6', isset($content->other) && ($content->other != null)  ? true : false ) }}
                    Other
                </li>
            </ul>
        </div>
        <div class="col-sm-12">
            <p><b>Do you need to integrate with any APIs?</b></p>

            <div class="row">
                <div id="payment" class="col-sm-3 detail-list">
                    <i class="fa fa-credit-card fa-4x icon"></i>
                    <p>Payment Processor</br> Paypal, Stripe, etc</p>
                </div>

                <div id="cloud" class="col-sm-3 detail-list">
                    <i class="fa fa-cloud fa-4x icon"></i>
                    <p>Cloud Storage</br>Dropbox, Box, etc</p>
                </div>
                <div id="social" class="col-sm-3 detail-list">
                    <i class="fa fa-facebook fa-4x icon"></i>
                    <p>Social Media</br> Facebook, Twitter, etc</p>
                </div>

                <div id="otherapi" class="col-sm-3 detail-list">
                    <i class="fa fa-plug fa-4x icon"></i>
                    <p>Other</br> Other APIs</p>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <p><b>What stage is the project in?</b></p>
            <div class="row">
                <div id="specification" class="col-sm-3 detail-list">
                    <i class="fa fa-list-alt fa-4x icon"></i>
                    <p>I have specifications</p>
                </div>

                <div id="designs" class="col-sm-3 detail-list">
                    <i class="fa fa-file-image-o fa-4x icon"></i>
                    <p>I have designs</p>
                </div>

                <div id="concept" class="col-sm-3 detail-list">
                    <i class="fa fa-lightbulb-o fa-4x icon"></i>
                    <p>I just have a concept</p>
                </div>

            </div>
        </div>

        <div class="col-sm-12 specification-content" style="display:none;   ">
            <div class="row">
                <div class="form-group col-sm-11">
                    {!! Form::label('specification', 'Specification*:') !!}
                    {!! Form::textarea('specification', isset($content->specification) ? $content->specification :null, ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-sm-11">
                    {!! Form::label('attachment', 'Specification Document (Optional):') !!}
                    {!! Form::file('attachment', ['class' => 'form-control']) !!}
                </div>

                <div class="form-group col-sm-6">
                    @if($attachment != null && $attachment->instance_type == 'specification-stage')
                        <img src="{{url('storage/app/'.$attachment->attachment)}} " width="80" height="80">
                    @endif
                </div>
            </div>
        </div>

        <div class="col-sm-12 design-content" style="display:none;   ">
            <div class="row">

                <div class="form-group col-sm-11">
                    {!! Form::label('design', 'Design*:') !!}
                    {!! Form::file('design', ['class' => 'form-control']) !!}
                </div>

                <div class="form-group col-sm-6">
                    @if($attachment != null && $attachment->instance_type == 'design-stage')
                        <img src="{{url('storage/app/'.$attachment->attachment)}} " width="80" height="80">
                    @endif
                </div>

            </div>
        </div>
        <div class="col-sm-12 concept-content" style="display:none; ">
            <div class="row">
                <p></p>
                <div class="form-group col-sm-11">
                    {!! Form::label('concept', 'Concept*:') !!}
                    {!! Form::textarea('concept', isset($content->concept) ? $content->concept :null, ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        {!! Form::hidden('project_id', $project_id, null, ['class' => 'form-control']) !!}
        {!! Form::hidden('type', isset($type->type) ? $type->type  : null, ['class' => 'form-control', 'id'=> 'type']) !!}
        {!! Form::hidden('paypal', isset($content->paypal) ? $content->paypal: null, ['class' => 'form-control', 'id'=> 'paypal']) !!}
        {!! Form::hidden('cloud', isset($content->cloud) ? $content->cloud: null, ['class' => 'form-control', 'id'=> 'cloudapi']) !!}
        {!! Form::hidden('social', isset($content->social) ? $content->social: null, ['class' => 'form-control', 'id'=> 'socialapi']) !!}
        {!! Form::hidden('otherapi', isset($content->otherapi) ? $content->otherapi: null, ['class' => 'form-control', 'id'=> 'otherapii']) !!}
        {!! Form::hidden('stage', isset($content->stage) ? $content->stage: null  , ['class' => 'form-control', 'id'=> 'stage']) !!}
        <div style="float: right; margin-right: 80px;">
            <button onclick="goBack()" id="back" name="back" type="button" value="Back" class="button iq-mt-15">Back
            </button>
            <button id="next" name="submit" type="submit" value="Next" class="button iq-mt-15">Next</button>
        </div>
    </form>
</div>

<script>

    $(document).ready(function () {
        var val;

        var type = $("#type").val();
        var paypal = $("#paypal").val();
        var cloud = $("#cloudapi").val();
        var social = $("#socialapi").val();
        var otherapi = $("#otherapii").val();
        var stage = $("#stage").val();
        if (type == 1) {
            $("#onetime").addClass("detail-active");
            $(".onetimecontent").show();
        }
        if (type == 2) {
            $("#ongoing").addClass("detail-active");
            $(".ongoingcontent").show();
        }
        if (type == 2) {
            $("#notsure").addClass("detail-active");
        }
        if (paypal == 1) {
            $("#payment").addClass("detail-active");
        }
        if (cloud == 1) {
            $("#cloud").addClass("detail-active");
        }
        if (social == 1) {
            $("#social").addClass("detail-active");
        }
        if (otherapi == 1) {
            $("#otherapi").addClass("detail-active");
        }
        if (stage == 1) {
            $("#specification").addClass("detail-active");
            $(".specification-content").show();
        }
        if (stage == 2) {
            $("#designs").addClass("detail-active");
            $(".design-content").show();
        }
        if (stage == 3) {
            $("#concept").addClass("detail-active");
            $(".concept-content").show();
        }
    });
</script>