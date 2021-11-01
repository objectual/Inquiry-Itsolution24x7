<!-- Id Field -->
<dt>{!! Form::label('id', 'Id:') !!}</dt>
<dd>{!! $user->id !!}</dd>

<!-- Name Field -->
<dt>{!! Form::label('name', 'Name:') !!}</dt>
<dd>{!! $user->name !!}</dd>

<!-- Email Field -->
<dt>{!! Form::label('email', 'Email:') !!}</dt>
<dd>{!! $user->email !!}</dd>

<!-- Email Field -->
<dt>{!! Form::label('roles', 'Roles:') !!}</dt>
<dd>{!! $user->rolesCsv !!}</dd>

{{--<!-- Password Field -->--}}
{{--<dt>{!! Form::label('password', 'Password:') !!}</dt>--}}
{{--<dd>{!! $user->password !!}</dd>--}}

{{--<!-- Remember Token Field -->--}}
{{--<dt>{!! Form::label('remember_token', 'Remember Token:') !!}</dt>--}}
{{--<dd>{!! $user->remember_token !!}</dd>--}}

<!-- Created At Field -->
<dt>{!! Form::label('created_at', 'Created At:') !!}</dt>
<dd>{!! $user->created_at !!}</dd>

<!-- Updated At Field -->
<dt>{!! Form::label('updated_at', 'Updated At:') !!}</dt>
<dd>{!! $user->updated_at !!}</dd>

