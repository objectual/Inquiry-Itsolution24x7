 <div style="font-size: 12px; line-height: 14px; color: #555555; font-family: Arial, 'Helvetica Neue', Helvetica, sans-serif;">
    <p style="font-size: 14px; line-height: 19px; text-align: center; margin: 0;">
        <span style="font-size: 16px;">
            <strong>Project Information</strong>
        </span></p>
</div>
 
<ol>
    <li><strong>Title</strong>
        <ul>
            <li>
                <div><span style="font-size: 12px;">Project Name:</span>
                <span style="font-size: 14px;text-align: center;"> 
                    <strong> {{$project->name}}</strong>
                </span>
                </div>
            </li>
            <li>
                <div><span style="font-size: 12px;">Project Category:</span>
                <span style="font-size: 14px;text-align: center;"> 
                    <strong>{{$project->category->name}}</strong>
                </span></div> 
            </li>
        </ul>
    </li>

    <li><strong>Details</strong>
        <ul>
            <li>
                <div><span style="font-size: 12px;">Type:</span>
                <span style="font-size: 14px;text-align: center;">
                    <strong>
                        @if($project->project_type->type == 1)
                            One Time
                        @elseif($project->project_type->type == 2)
                            One Going
                        @else
                            Not Sure
                        @endif
                    </strong>
                </span>
                </div> 
            </li>
            <li>
                <div>
                    <span style="font-size: 12px;">Do you need any api integration?:</span>
                    <span style="font-size: 14px;text-align: center;">
                        <strong>   
                            @foreach($api as $apis)
                                {{$apis}},
                            @endforeach
                        </strong>
                    </span>
                </div> 
            </li>
            <li>
                <div>
                    <span style="font-size: 12px;">Which of the following best describe your project?:</span>
                    <span style="font-size: 14px;text-align: center;">    
                        <strong>
                            @if($project->project_type->type == 1)
                                {{$describe}}
                            @elseif($project->project_type->type == 2)
                                @foreach($describe as $work)
                                    {{$work}},
                                @endforeach
                            @else
                                Not Sure
                            @endif
                        </strong>
                    </span>
                </div> 
            </li>
            <li>
                <div>
                    <span style="font-size: 12px;">What stage is the project in?:</span>
                    <span style="font-size: 14px;text-align: center;">    
                        <strong>
                            @foreach($stage as $stages)
                                {{$stages}},
                            @endforeach
                        </strong>
                    </span>
                </div> 
            </li>
        </ul>
    </li>

    <li><strong>Description</strong>
        <ul>
            <li>
                <div><span style="font-size: 12px;">Project Description:</span>
                <span style="font-size: 14px;text-align: center;"> <strong>{{$project->description->details}}</strong></span>
                </div> 
            </li>
        </ul>
    </li>

    @if($project->questions->count() > 0 )
        <li><strong>Questions</strong>
            <ul>
                <li>
                    <span style="font-size: 14px;text-align: center;">  @foreach($project->questions as $question)
                        {{$question->question}}
                    @endforeach
                    </span>
                </li>
            </ul>
        </li>
    @endif()

    @if($project->questions->count() > 0 )
        <li><strong>Expertise</strong>
            <ul>
                <li>
                    <span style="font-size: 14px;text-align: center;">  @foreach($project->expertise as $expertise)
                        {{$expertise->name->name}},
                    @endforeach
                    </span>
                </li>
            </ul>
        </li>
    @endif()
    <li><strong>Budget</strong>
        <ul>
            <li>
                <div><span style="font-size: 12px;">How would you like to pay?:</span>
                    <span style="font-size: 14px;text-align: center;">  
                    <strong>
                        @if($project->budget->type == 1)
                            Hourly
                        @elseif($project->budget->type == 2)
                            Fixed
                        @else
                            Not Sure
                        @endif()
                    </strong>
                </span>
                </div> 
            </li>
            <li>
                <div><span style="font-size: 12px;">How long do you expect this project to last? :</span>
                <span style="font-size: 14px;text-align: center;">  
                    <strong>
                        @if($budget->stage == 1)
                            More than 6 months
                        @elseif($budget->stage == 2)
                            3 to 6 months
                        @elseif($budget->stage == 3)
                            1 to 3 months
                        @else
                            Less than 1 month
                        @endif
                    </strong>
                </span></div> 
            </li>
            @if(isset($budget->experience))
                <li>
                    <div><span style="font-size: 12px;">What level of experience developer you need? :</span>
                    <span style="font-size: 14px;text-align: center;">  
                        <strong>
                            @if($budget->experience == 1)
                                Entry (Less than $20.00/hr)
                            @elseif($budget->experience == 2)
                                Intermediate ($20.00 - $40.00/hr)
                            @else
                                Expert (More than $40.00/hr)
                            @endif()
                        </strong>
                    </span></div> 
                </li>
            @endif()
            <li>
                <div><span style="font-size: 12px;">Do you have time requirement for this project? :</span>
                <span style="font-size: 14px;text-align: center;">  
                    <strong>
                        @if($budget->time == 1)
                            More than 30 hrs/week
                        @elseif($budget->stage == 2)
                            Less than 30 hrs/week
                        @else
                            I don't know yet
                        @endif
                    </strong>
                </span>></div> 
            </li>
        </ul>
    </li>
</ol>
  