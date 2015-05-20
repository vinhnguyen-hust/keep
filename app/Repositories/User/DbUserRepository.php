<?php namespace Keep\Repositories\User;

use Auth;
use Keep\Entities\User;

class DbUserRepository implements UserRepositoryInterface {

    public function all()
    {
        return User::all();
    }

    public function count()
    {
        return User::count();
    }

    public function getPaginatedUsers($limit)
    {
        return User::with('tasks', 'roles', 'groups', 'assignments')->paginate($limit);
    }

    public function getAuthUser()
    {
        return Auth::user();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }

    public function findBySlug($slug)
    {
        return User::whereSlug($slug)->firstOrFail();
    }

    public function findBySlugWithTasks($slug)
    {
        return User::with(['tasks' => function ($query)
        {
            $query->latest('created_at');
        }, 'roles'])->whereSlug($slug)->firstOrFail();
    }

    public function findByCodeAndActiveState($code, $state)
    {
        return User::whereActivationCodeAndActive($code, $state)->firstOrFail();
    }

    public function create(array $credentials)
    {
        return User::create([
            'name'            => $credentials['name'],
            'email'           => $credentials['email'],
            'password'        => $credentials['password'],
            'activation_code' => str_random(60)
        ]);
    }

    public function updateProfile($slug, array $credentials)
    {
        $user = $this->findBySlug($slug);

        $user->profile()->update($credentials);

        return $user;
    }

    public function restore($slug)
    {
        $user = $this->findTrashedUserBySlug($slug);

        // Model events are not fired when applied to a collection
        // We need to perform actions on individual model instance.
        $user->tasks()->withTrashed()->get()->each(function ($task)
        {
            $task->restore();
        });

        $user->profile()->withTrashed()->restore();

        return $user->restore();
    }

    public function delete($slug)
    {
        $user = $this->findBySlug($slug);

        $user->tasks()->get()->each(function ($task)
        {
            $task->delete();
        });

        $user->profile()->delete();

        return $user->delete();
    }

    public function forceDelete($slug)
    {
        $user = $this->findTrashedUserBySlug($slug);

        $user->tasks()->withTrashed()->forceDelete();

        $user->profile()->withTrashed()->forceDelete();

        return $user->forceDelete();
    }

    public function getTrashedUsers($limit)
    {
        return User::onlyTrashed()->latest('deleted_at')->paginate($limit);
    }

    public function findTrashedUserBySlug($slug)
    {
        return User::onlyTrashed()->whereSlug($slug)->firstOrFail();
    }

    public function getPaginatedAssociatedTasks($user, $limit)
    {
        return $user->tasks()->latest('created_at')->paginate($limit);
    }

    public function fetchUsersByIds(array $ids)
    {
        return User::whereIn('id', $ids)->get();
    }

}