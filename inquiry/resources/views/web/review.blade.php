<div class="col-10 wizard-data">
    <h4>Review</h4>
    <p>Step 7 of 7</p>
    <form method="POST" action="{{ url('ReviewStore') }}">
        @csrf
        <div class="row custom-border-box">
            <div class="form-group col-sm-12">
                <h4>Project Information</h4>
            </div>
            <div class="form-group col-sm-6">
                {!! Form::label('Name', 'Project Name:') !!}
                <p>{{$project->name}}</p>
            </div>

            <div class="form-group col-sm-6">
                {!! Form::label('Name', 'Project Category:') !!}
                <p>{{$project->category->name}}</p>
            </div>

        </div>

        <div class="row custom-border-box">
            <div class="form-group col-sm-12">
                <h4>Project Description</h4>
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('Name', 'Description:') !!}
                <p>{{isset($project->description->details) ? $project->description->details:''}}</p>
            </div>

        </div>

        <div class="row custom-border-box">
            <div class="form-group col-sm-12">
                <h4>Project Detail</h4>
            </div>
            <div class="form-group col-sm-6">
                {!! Form::label('Type', 'Type:') !!}
                @if(isset($project->project_type->type))
                    <p>@if($project->project_type->type == 1)
                            One Time
                        @elseif($project->project_type->type == 2)
                            One Going
                        @else
                            Not Sure
                        @endif</p>
            </div>
            @endif
            @if($project->project_type->type == 1)
                <div class="form-group col-sm-6">
                    {!! Form::label('Type', 'Which of the following best describe your project?') !!}
                    <p>{{$describe}}</p>
                </div>

            @elseif($project->project_type->type == 2)
                <div class="form-group col-sm-6">
                    {!! Form::label('Type', 'Which of the following best describe your project?') !!}<br>
                    @foreach($describe as $work)
                        {{$work}},
                    @endforeach
                </div>
            @else
                <div class="form-group col-sm-6">
                    {!! Form::label('Type', 'Which of the following best describe your project?') !!}<br>
                    Not Sure
                </div>
            @endif


            @if($api != null)
                <div class="form-group col-sm-6">
                    {!! Form::label('Type', 'Do you need any api integration?') !!}<br>
                    @foreach($api as $apis)
                        {{$apis}},
                    @endforeach
                </div>
            @endif

            @if($stage != null)
                <div class="form-group col-sm-6">
                    {!! Form::label('Type', 'What stage is the project in?') !!}<br>
                    @if(count($stage) > 0)
                        @foreach($stage as $stages)
                            {{$stages}},
                        @endforeach
                    @else
                        <p>Designing</p>
                    @endif
                </div>
            @endif
        </div>

        @if($project->questions->count() > 0 )
            <div class="row custom-border-box">
                <div class="form-group col-sm-12">
                    <h4>Questions</h4>
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('Name', 'Questions:') !!}
                    @foreach($project->questions as $question)
                        <p>{{$question->question}}</p>
                    @endforeach
                </div>

            </div>
        @endif()

        @if($project->expertise->count() > 0 )
            <div class="row custom-border-box">
                <div class="form-group col-sm-12">
                    <h4>Expertise</h4>
                </div>
                <div class="form-group col-sm-12">
                    {!! Form::label('Name', 'Expertise:') !!}
                    @foreach($project->expertise as $expertise)
                        {{$expertise->name->name}},
                    @endforeach
                </div>

            </div>
        @endif()

        <div class="row custom-border-box">
            <div class="form-group col-sm-12">
                <h4>Budget</h4>
            </div>
            <div class="form-group col-sm-6">
                {!! Form::label('Name', 'How would you like to pay?') !!}
                @if(isset($project->budget->type))
                    <p>@if($project->budget->type == 1)
                            Hourly
                        @elseif($project->budget->type == 2)
                            Fixed
                        @else
                            Not Sure
                        @endif()
                    </p>
            </div>
            @if($project->budget->type == 1)
                <div class="form-group col-sm-6">
                    {!! Form::label('Name', 'What level of experience developer you need?') !!}
                    @if($budget->experience == 1)
                        <p>Entry (Less than $20.00/hr)</p>
                    @elseif($budget->experience == 2)
                        <p>Intermediate ($20.00 - $40.00/hr)</p>
                    @else
                        <p>Expert (More than $40.00/hr)</p>
                    @endif
                </div>
            @endif

            @if($project->budget->type == 2)
                <div class="form-group col-sm-6">
                    {!! Form::label('Name', 'Amount') !!}
                    <p>{{$budget->amount}}</p>
                </div>
            @endif

            <div class="form-group col-sm-6">
                {!! Form::label('Name', 'How long do you expect this project to last?') !!}
                @if($budget->stage == 1)
                    <p>More than 6 months</p>
                @elseif($budget->stage == 2)
                    <p>3 to 6 months</p>
                @elseif($budget->stage == 3)
                    <p>1 to 3 months</p>
                @else
                    <p>Less than 1 month</p>
                @endif
            </div>

            <div class="form-group col-sm-6">
                {!! Form::label('Name', 'Do you have time requirement for this project?') !!}
                @if($budget->time == 1)
                    <p>More than 30 hrs/week</p>
                @elseif($budget->time == 2)
                    <p>Less than 30 hrs/week</p>
                @else
                    <p>I don't know yet</p>
                @endif
            </div>
            @endif
        </div>

        {!! Form::hidden('project_id', $project_id, null, ['class' => 'form-control']) !!}
        {!! Form::hidden('experience', null, ['class' => 'form-control' ,'id'=> 'experience']) !!}
        {!! Form::hidden('type', null, ['class' => 'form-control', 'id'=> 'type']) !!}
        {!! Form::hidden('time', 0, ['class' => 'form-control', 'id'=> 'time']) !!}

        {!! Form::hidden('stage', 0  , ['class' => 'form-control', 'id'=> 'stage']) !!}
        <div style="float: right; margin-right: 80px;">
            <button onclick="goBack()" id="back" name="back" type="button" value="Back" class="button iq-mt-15">Back
            </button>
            <button id="next" name="submit" type="submit" value="Next" class="button iq-mt-15">Submit</button>
        </div>
    </form>
</div>
