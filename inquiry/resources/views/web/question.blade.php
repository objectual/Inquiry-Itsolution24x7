<div class="col-10 wizard-data">
    <h4>Questions</h4>
    <p>Step 4 of 7</p>
    <div class="col-sm-12">
        <p><b>Additional Question</b></p>
    </div>
    @include('adminlte-templates::common.errors')
    <form method="POST" action="{{ url('QuestionStore') }}">
        @csrf
        <div class="row">
            <div class="form-group col-sm-12">
                <button name="question" type="button" value="Question" class="button iq-mt-15 clone_trigger">
                    Add a Question
                </button>
            </div>
        </div>
        <div class="question">
            <div class="row">
                <div class="form-group col-sm-8">
                    {!! Form::text('question[]', null, ['class' => 'form-control cl' ,'placeholder' =>'Question' ]) !!}
                    {!! Form::hidden('project_id', $project_id, null, ['class' => 'form-control cl' ,'placeholder' =>'Question' ]) !!}
                </div>
                <div class="form-group col-sm-2">
                    <a href="#" class="remove_trigger fa fa-times"></a>
                </div>
            </div>
        </div>
        <div class="placer"></div>
        <div class="row">

            <div class="form-group col-sm-12">
                {{ Form::checkbox('profile', '1', false) }} Yes, require a profile
            </div>

        </div>
        <div style="float: right; margin-right: 80px;">
            <button onclick="goBack()" id="back" name="back" type="button" value="Back" class="button iq-mt-15">Back
            </button>
            <button id="next" name="submit" type="submit" value="Next" class="button iq-mt-15">Next</button>
        </div>
    </form>
</div>
