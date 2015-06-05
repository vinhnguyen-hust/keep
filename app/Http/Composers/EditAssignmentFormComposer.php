<?php namespace Keep\Http\Composers;

use App;
use Illuminate\Contracts\View\View;

class EditAssignmentFormComposer {

    /**
     * Composer assignment form view.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $userRepo = App::make('Keep\Repositories\User\UserRepositoryInterface');
        $view->with('users', $userRepo->getAll()->lists('name', 'id'));

        $groupRepo = App::make('Keep\Repositories\UserGroup\UserGroupRepositoryInterface');
        $view->with('groups', $groupRepo->getAll()->lists('name', 'id'));
    }

}