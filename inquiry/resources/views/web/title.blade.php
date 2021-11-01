<div class="col-10 wizard-data">
    <h4>Title</h4>
    <p>Step 1 of 7</p>
    <form method="POST" action="{{ url('ProjectStore') }}">
        @csrf
        <div class="row">
            <div class="form-group col-sm-6">
                {!! Form::label('name', 'Enter the name of your project:*') !!}
                {!! Form::text('name', isset($exist->name) ? $exist->name :  null, ['class' => 'form-control', 'required']) !!}
                {!! Form::hidden('email', $email, null, ['class' => 'form-control']) !!}
            </div>
            <div class="form-group col-sm-6">

                {!! Form::label('category_id', 'Project Category:*') !!}
                <select class="form-control" name="category_id">
                    @foreach ($category as $item)
                        @if(isset($exist->category_id))
                            <option value="{{$item->id}}" {{ ( $item->id == $exist->category_id) ? 'selected' : '' }}> {{ $item->name }} </option>
                        @else
                            <option value="{{$item->id}}"> {{ $item->name }} </option>
                        @endif()
                    @endforeach
                </select>
                {{--{!! Form::select('category_id',$category, null,['class' => 'form-control select2']) !!}--}}
            </div>
            <div class="col-sm-12">
                <p><b>Here are some good examples:</b></p>
                <ol>
                    <li>Developer needed for creating a responsive Wordpress Theme.</li>
                    <li>CAD designer to create a 3D model of a residential building.</li>
                    <li>Need a design for a new company logo.</li>
                </ol>
            </div>
        </div>
        <div style="float: right; margin-right: 80px;">
            {{--<button id="back" name="back" type="button" value="Back" class="button iq-mt-15">Back</button>--}}
            {{--{!! Form::submit('Next', ['class' => 'button iq-mt-15']) !!}--}}
            <button id="next" name="submit" type="submit" value="Next" class="button iq-mt-15">Next</button>
        </div>
    </form>
</div>
