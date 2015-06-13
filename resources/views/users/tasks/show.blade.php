@extends('layouts.app')
@section('meta-description', $task->title . ' (' . str_limit($task->content, 250) . ')')
@section('title', $task->title)
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @include('users.tasks.partials._task')
            @unless($task->is_failed)
                <div class="text-center">
                    @include('users.tasks.partials._complete_form')
                </div>
            @endunless
            <div class="task-controls text-center">
                <a href="{{ route('member::dashboard', $user) }}">
                    <button class="btn btn-circle btn-info"
                        data-toggle="tooltip" data-placement="bottom" title="Back to dashboard">
                        <i class="fa fa-arrow-left"></i>
                    </button>
                </a>
                <a href="{{ route('member::tasks.edit', [$user, $task]) }}">
                    <button class="btn btn-circle btn-primary"
                        data-toggle="tooltip" data-placement="bottom" title="Edit task">
                        <i class="fa fa-pencil"></i>
                    </button>
                </a>
                @include('users.tasks.partials._delete_form')
            </div>
        </div>
    </div>
@stop
