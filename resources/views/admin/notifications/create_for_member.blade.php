@extends('layouts.admin')
@section('title', 'Create Member Notification')
@section('notifiable-objects')
    <div class="form-group">
        <div class="form-group">
            {!! Form::label('user_list', 'Choose Members', ['class' => 'control-label']) !!}
            {!! Form::select('user_list[]', $users, null,
                ['id' => 'user_list',
                'class' => 'form-control multiple-selection',
                'data-description' => 'Type and search for members...',
                'multiple']) !!}
            {!! error_text($errors, 'user_list') !!}
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default form-wrapper">
                <div class="panel-heading">Create new notification for members</div>
                <div class="panel-body">
                    {!! Form::model($notification = new \Keep\Entities\Notification,
                        ['route' => ['admin.notifications.store']]) !!}
                        @include('admin.notifications.partials._main_form',
                            ['notificationButton' => 'Notify'])
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop
