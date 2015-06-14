<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="list-group">
            <div class="list-group-item active">
                <div class="text-center">
                    @yield('task-type')
                </div>
            </div>
            @foreach($tasks as $task)
                <a href="{{ route('member::tasks.show', [$user, $task]) }}" class="list-group-item">
                    <span class="badge">{{ humans_time($task->created_at) }}</span>
                    {{ $task->title }}
                </a>
            @endforeach
        </div>
        {!! render_pagination($tasks) !!}
    </div>
</div>