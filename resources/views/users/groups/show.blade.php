@extends('layouts.app')
@section('title', 'Group - ' . $group->name)
@section('content')
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="text-center" style="margin-bottom: 15px">
                <button class="btn btn-lg btn-info" type="button">
                    {{ plural('Member', counting($members)) }}
                </button>
                <button class="btn btn-lg btn-info" type="button">
                    {{ plural('Assignment', counting($assignments)) }}
                </button>
            </div>
            <div class="col-md-4">
                @foreach($members as $user)
                    <div class="well">
                        <div class="media">
                            <div class="media-left">
                                @include('users.partials._avatar')
                            </div>
                            <div class="media-body">
                                <h5 class="media-heading">{{ $user->name  }}</h5>
                                <p>{{ $user->email }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-md-8">
                @foreach($assignments->load('task.priority') as $assignment)
                    <div class="task-wrapper">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <a class="task-title">{{ $assignment->assignment_name }}</a>
                                <h6 class="task-time-ago">{{ humans_time($assignment->created_at) }}</h6>
                            </div>
                            <div class="panel-body">
                                <div class="well">
                                    <h4 class="text-center">{{ $assignment->task->title }}</h4>
                                    {{ $assignment->task->content }}
                                </div>
                            </div>
                            <div class="panel-footer">
                                <span class="label label-primary">{{ remaining_days($assignment->task->finishing_date) }}</span>
                                <span class="label label-info">{{ $assignment->task->priority->name }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop