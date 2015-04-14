<?php  namespace Keep\Http\Composers; 

use App;
use Illuminate\Contracts\View\View;

class TaskFormComposer {

    /**
     * Composer task form view partial.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        $tags = App::make('Keep\Repositories\Tag\TagRepositoryInterface');
        $priorities = App::make('Keep\Repositories\Priority\PriorityRepositoryInterface');

        $view->with('tags', $tags->lists());
        $view->with('priorities', $priorities->lists());
    }

}