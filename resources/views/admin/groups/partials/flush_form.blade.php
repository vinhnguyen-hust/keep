{!! Form::open(array('route' => array('admin.groups.flush', $group->slug))) !!}
    <button type="submit" class="btn btn-circle btn-danger"
        data-toggle="tooltip" data-placement="bottom" title="Remove all users from group">
        <i class="fa fa-times"></i>
    </button>
{!! Form::close() !!}