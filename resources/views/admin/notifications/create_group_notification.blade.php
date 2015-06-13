@extends('layouts.admin')
@section('title', 'Create Group Notification')
@section('notifiable-objects')
    <div class="form-group">
        <div class="form-group">
            {!! Form::label('group_list', 'Choose Groups', ['class' => 'control-label']) !!}
            {!! Form::select('group_list[]', $groups, null, ['id' => 'group_list', 'class' => 'form-control', 'multiple']) !!}
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-primary form-wrapper">
                <div class="panel-heading"><strong>Create Group Notification</strong></div>
                <div class="panel-body">
                    @include('layouts.partials._form_errors')
                    {!! Form::model($notification = new \Keep\Entities\Notification, ['route' => ['admin::notifications.group.store']]) !!}
                        @include('admin.notifications.partials._main_form', ['notificationButton' => 'Create Notification'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop