<?php  namespace Keep\Repositories\User; 

use Auth;
use Keep\User;

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
        return User::with('tasks', 'roles')->paginate($limit);
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
        return User::findBySlug($slug);
    }

    public function findBySlugWithTasks($slug)
    {
        return User::with(['tasks' => function($query) {
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
            'name' => $credentials['name'],
            'email' => $credentials['email'],
            'password' => $credentials['password'],
            'activation_code' => str_random(60)
        ]);
    }

    public function update($slug, array $credentials)
    {
        $user = $this->findBySlug($slug);

        $user->update($credentials);

        return $user;
    }

    public function restore($slug)
    {
        $user = $this->findTrashedUserBySlug($slug);

        return $user->restore() && $user->tasks()->restore();
    }

    public function delete($slug)
    {
        return $this->findBySlug($slug)->delete();
    }

    public function forceDelete($slug)
    {
        $user = $this->findTrashedUserBySlug($slug);

        $user->tasks()->forceDelete();

        $user->forceDelete();
    }

    public function getTrashedUsers()
    {
        return User::onlyTrashed()->latest('deleted_at')->paginate(25);
    }

    public function findTrashedUserBySlug($slug)
    {
        return User::onlyTrashed()->whereSlug($slug)->firstOrFail();
    }

    public function getPaginatedAssociatedTasks($user, $limit)
    {
        return $user->tasks()->latest('created_at')->paginate($limit);
    }

}