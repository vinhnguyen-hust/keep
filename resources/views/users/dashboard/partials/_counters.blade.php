<div class="row stats">
    <div class="col-md-12">
        <div class="page-header">
            <h5>Tasks According to Status <small>sorted by finishing date</small></h5>
        </div>
    </div>
    <div class="col-md-3">
        <a href="{{ route('user.tasks', ['users' => $user, 'type' => 'all']) }}">
            <div class="stat-container">
                <div class="large">{{ $counter->totalTasks() }}</div>
                <div class="small">in total</div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('user.tasks', ['users' => $user, 'type' => 'completed']) }}">
            <div class="stat-container">
                <div class="large">{{ $counter->countCompletedTasks() }}</div>
                <div class="small">completed</div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('user.tasks', ['users' => $user, 'type' => 'failed']) }}">
            <div class="stat-container">
                <div class="large">{{ $counter->countFailedTasks() }}</div>
                <div class="small">failed</div>
            </div>
        </a>
    </div>
    <div class="col-md-3">
        <a href="{{ route('user.tasks', ['users' => $user, 'type' => 'processing']) }}">
            <div class="stat-container">
                <div class="large">{{ $counter->countDueTasks() }}</div>
                <div class="small">processing</div>
            </div>
        </a>
    </div>
</div>