@if (session('invalid.name'))
    <div class="alert alert-warning">{{ session('invalid.name') }}</div>
@endif
{!! Form::open(['method' => 'PATCH', 'route' => ['user.account.change.name', $user]]) !!}
    <div class="form-group">
        <label for="" class="control-label"></label>
        {!! Form::label('old_name', 'Current name', ['class' => 'control-label']) !!}
        {!! Form::text('old_name', null, ['class' => 'form-control']) !!}
        {!! error_text($errors, 'old_name') !!}
    </div>
    <div class="form-group">
        {!! Form::label('new_name', 'New name', ['class' => 'control-label']) !!}
        {!! Form::text('new_name', null, ['class' => 'form-control']) !!}
        {!! error_text($errors, 'new_name') !!}
    </div>
    <div class="form-group form-submit">
        <button type="submit" class="btn btn-primary">Change your name</button>
    </div>
{!! Form::close() !!}
