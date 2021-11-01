<div class="col-10 wizard-data">
    <h4>Expertise</h4>
    <p>Step 5 of 7</p>
    <form method="POST" action="{{ url('ExpertiseStore') }}">
        @csrf
        <div class="row">
            <div class="col-sm-12">
                <p><b>What skills and expertise are most important to you?</b></p>
            </div>
            <div class="form-group col-sm-12">
                {!! Form::select('expertise[]', $expertise, null, ['class' => 'form-control select2', 'multiple'=>'multiple']) !!}
            </div>
            {!! Form::hidden('project_id', $project_id, null, ['class' => 'form-control cl' ]) !!}
        </div>
        <div style="float: right; margin-right: 80px;">
            <button onclick="goBack()" id="back" name="back" type="button" value="Back" class="button iq-mt-15">Back
            </button>
            <button id="next" name="submit" type="submit" value="Next" class="button iq-mt-15">Next</button>
        </div>
    </form>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>