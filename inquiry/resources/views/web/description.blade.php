<div class="col-10 wizard-data">
    <h4>Description</h4>
    <p>Step 3 of 7</p>
    @include('adminlte-templates::common.errors')
    <form method="POST" action="{{ url('DescriptionStore') }}" enctype="multipart/form-data">
        @csrf
        <div class="col-sm-12">
            <b>Description:*</b>
            <ol>
                {{--<li>What the deliverable is.</li>--}}
                {{--<li>Type of development you're looking for.</li>--}}
                {{--<li>Anything unique about the project or team</li>--}}
                <li>Give us details here.</li>
                <li>Tell us the type of development you're looking for.</li>
                <li>Do mention references of work if there are any</li>
            </ol>
        </div>
        <div class="row">
            <div class="form-group col-sm-12">
                {!! Form::textarea('details', isset($description->details) ?  $description->details: null, ['class' => 'form-control','required','placeholder' =>'Give us Details']) !!}
                {!! Form::hidden('project_id',$project_id , null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-sm-12">
                {!! Form::label('attachment', 'Additional Project Files:') !!}
                {!! Form::file('attachment[]', ['class' => 'form-control', 'multiple' =>'multiple']) !!}
            </div>
            @if($description != null)
                @if(count($description->media) > 0 )
                    @foreach($description->media as $row)
                        <div class="form-group col-sm-1">
                            <img style="margin-left: 5px;" src="{{url('storage/app/'.$row->attachment)}} " width="80"
                                 height="70">
                        </div>
                    @endforeach
                @endif
            @endif
        </div>
        <div style="float: right; margin-right: 80px;">
            <button onclick="goBack()" id="back" name="back" type="button" value="Back" class="button iq-mt-15">Back
            </button>
            <button id="next" name="submit" type="submit" value="Next" class="button iq-mt-15">Next</button>
        </div>
    </form>
</div>
