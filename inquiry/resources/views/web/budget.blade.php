<div class="col-10 wizard-data">
    <h4>Budget</h4>
    <p>Step 6 of 7</p>
    @include('adminlte-templates::common.errors')
    <form method="POST" action="{{ url('BudgetStore') }}">
        @csrf
        <div class="col-sm-12">
            <p><b>How would you like to pay?</b></p>
            <div class="row">
                <div id="onetime" class="col-sm-3 budget-list">
                    <i class="fa fa-briefcase fa-4x icon5"></i><br>
                    <p>Pay by the hour <br> Popular on ongoing projects</p>
                </div>

                <div id="ongoing" class="col-sm-3 budget-list">
                    <i class="fa fa-file-text fa-4x icon5"></i>
                    <p>Pay a fixed price <br> Popular on one-time projects</p>
                </div>

                <div id="notsure" class="col-sm-3 budget-list">

                    <i class="fa fa-question fa-4x icon5"></i>
                    <p>I am not sure</p>
                </div>
            </div>
        </div>


        <div class="col-sm-12 onetimecontent" style="display:none ;">
            <br>
            <p><b>What level of experience should your freelancer have?</b></p>

            <div class="row">
                <div id="entry" class="col-sm-3 detail-list">
                    <i class="fa fa-usd fa-4x icon1"></i>
                    <p><b>Entry</b></p>
                </div>

                <div id="intermediate" class="col-sm-3 detail-list">
                    <i class="fa fa-usd fa-4x icon2"></i>
                    <i class="fa fa-usd fa-4x"></i>
                    <p><b>Intermediate</b></p>
                </div>
                <div id="expert" class="col-sm-3 detail-list">
                    <i class="fa fa-usd fa-4x icon3"></i>
                    <i class="fa fa-usd fa-4x"></i>
                    <i class="fa fa-usd fa-4x"></i>
                    <p><b>Expert</b></p>
                </div>

            </div>
        </div>

        <div class="col-sm-12 ongoingcontent" style="display:none ;">

            <p><b>Do you have a specific budget?</b></p>
            <div class="row">
                <div id="fixedbudget" class="col-sm-3">
                    {!! Form::number('amount', null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <br>
        </div>


        <div class="col-sm-12">
            <p><b>How long do you expect this project to last?</b></p>
            <div class="row">
                <div id="specification" class="col-sm-3 detail-list">
                    <i class="fa fa-list-alt fa-4x icon"></i>
                    <p>More than 6 months</p>
                </div>

                <div id="designs" class="col-sm-3 detail-list">
                    <i class="fa fa-file-image-o fa-4x icon"></i>
                    <p>3 to 6 months</p>
                </div>

                <div id="concept" class="col-sm-3 detail-list">
                    <i class="fa fa-lightbulb-o fa-4x icon"></i>
                    <p>1 to 3 months</p>
                </div>

                <div id="urgent" class="col-sm-3 detail-list">
                    <i class="fa fa-lightbulb-o fa-4x icon"></i>
                    <p>Less than 1 month</p>
                </div>

            </div>
        </div>

        <div class="col-sm-12">
            <p><b>Do you have time requirement for this project?</b></p>
            <div class="row">
                <div id="morethan" class="col-sm-3 detail-list">
                    <i class="fa fa-list-alt fa-4x icon"></i>
                    <p>More than 30 hrs/week</p>
                </div>

                <div id="lessthan" class="col-sm-3 detail-list">
                    <i class="fa fa-file-image-o fa-4x icon"></i>
                    <p>Less than 30 hrs/week</p>
                </div>

                <div id="dont" class="col-sm-3 detail-list">
                    <i class="fa fa-lightbulb-o fa-4x icon"></i>
                    <p>I don't know yet</p>
                </div>


            </div>
        </div>

        {!! Form::hidden('project_id', $project_id, null, ['class' => 'form-control']) !!}
        {!! Form::hidden('experience', isset($content->experience) ? $content->experience: null, ['class' => 'form-control' ,'id'=> 'experience']) !!}
        {!! Form::hidden('type', isset($budget->type) ?$budget->type : null, ['class' => 'form-control', 'id'=> 'type']) !!}
        {!! Form::hidden('time', isset($content->time) ?$content->time : null, ['class' => 'form-control', 'id'=> 'time']) !!}

        {!! Form::hidden('stage', isset($content->stage) ? $content->stage: null   , ['class' => 'form-control', 'id'=> 'stage']) !!}
        <div style="float: right; margin-right: 80px;">
            <button onclick="goBack()" id="back" name="back" type="button" value="Back" class="button iq-mt-15">Back
            </button>
            <button id="next" name="submit" type="submit" value="Next" class="button iq-mt-15">Next</button>
        </div>
    </form>
</div>

<script>    $(document).ready(function () {
        var val;

        var type = $("#type").val();
        var experience = $("#experience").val();
        var time = $("#time").val();
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
        if (experience == 1) {
            $("#entry").addClass("detail-active");
        }
        if (experience == 2) {
            $("#intermediate").addClass("detail-active");
        }
        if (experience == 3) {
            $("#expert").addClass("detail-active");
        }

        if (stage == 1) {
            $("#specification").addClass("detail-active");
        }
        if (stage == 2) {
            $("#designs").addClass("detail-active");
        }
        if (stage == 3) {
            $("#concept").addClass("detail-active");
        }

        if (stage == 4) {
            $("#urgent").addClass("detail-active");
        }
        if (time == 1) {
            $("#morethan").addClass("detail-active");
        }
        if (time == 2) {
            $("#lessthan").addClass("detail-active");
        }
        if (time == 3) {
            $("#dont").addClass("detail-active");
        }
    });
</script>
