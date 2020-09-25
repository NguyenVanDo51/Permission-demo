<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Mockery\Exception;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        return view('pages.dashboard', [
            'users' => User::with('roles')->get()
        ]);
    }

    public function test()
    {
//        Permission::create(['name' => 'posts.*']);
//        Auth::user()->givePermissionTo('posts.*');
        Auth::user()->givePermissionTo('posts.show');

//        Permission::create(['name' => 'posts.show']);
//        Permission::create(['name' => 'posts.edit']);
//        Permission::create(['name' => 'posts.update']);
//        Permission::create(['name' => 'posts.destroy']);

//        Permission::

        return "test";
    }


    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @var RouteCollection $routes
     */
    public function show(User $user)
    {
        $permissions = $user->getPermissionNames();

        foreach ($permissions as $permission) {
            if (Str::contains($permission, '.*')) {
                $permissions->add(Str::replaceFirst('*', 'index', $permission));
                $permissions->add(Str::replaceFirst('*', 'show', $permission));
                $permissions->add(Str::replaceFirst('*', 'edit', $permission));
                $permissions->add(Str::replaceFirst('*', 'update', $permission));
                $permissions->add(Str::replaceFirst('*', 'destroy', $permission));
            }
        }

        $roles = $user->roles()->pluck('name');
        $allRole = Role::all();

        $routes = app('router')->getRoutes();

        $routes = collect($routes->getRoutesByName());

        // Lay ten cua toan bo cac routes
        $routes = $routes->keys();

        // Ten cac route se duoc phan quyen, can them moi khi tao them route
        $models = ['posts', 'roles', 'users', 'comments', 'permissions'];

        $data = [];

        // Mang $model la danh sach cac route can lay (VD: posts.index, posts.show, roles.index, ...)
        foreach ($models as $item) {

            // So sanh cac routes voi tung phan tu cua mang $models de lay het cac route cua tung model
            $data[$item] = $routes->filter(function ($value) use ($item) {

                // Loc routes, chi lay ra nhung route co ten bat dau la cac phan tu trong $models
                return Str::startsWith($value, $item);
            });
        }

        return view('pages.profile',
            compact('user', 'permissions', 'roles', 'allRole', 'data'));
    }

    public function store(Request $request)
    {
        $permissions = $request->all();

        try {
            $user = User::query()->findOrFail(Arr::pull($permissions, "user"));

            unset($permissions['_token'], $permissions['user']);

            $permissions = array_keys($permissions);

            $permissions = array_map(function($permission) {
                return str_replace('_', '.', $permission);
            }, $permissions);

            foreach ( $permissions as $permission) {
                $permission = str_replace('_', '.', $permission);

                // Them permissions neu chua ton tai
                Permission::query()->firstOrCreate(['name' => $permission]);
            }

            $user->syncPermissions($permissions);
        } catch (Exception $exception) {
            logger("Exception when update permission!", [
                "exception: " => $exception->getMessage()
            ] );
        }

        return redirect()->route('users.index');
    }
}
