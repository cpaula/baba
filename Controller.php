<?php

namespace App\Http\Controllers;

//use Dingo\Api\Src\Routing\Helpers;
use Dingo\Api\Routing\Helpers;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Permission;
use App\Role;
use App\User;

//use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
//use App\Http\Requests;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, Helpers;

     public function index()
    {
        return User::all();
        //return "hello";
    }

    public function attachUserRole($userId, $role)
    {
        $user = User::find($userId);

        $roleId = Role::where('name', $role)->first();

        $user->roles()->attach($roleId);

        return $user;
    }

    public function getUserRole($userId)
    {
        return User::find($userId)->roles;
    }

    public function attachPermission(Request $request)
    {
        $parameters = $request->only('permission', 'role');

        $permissionParam = $parameters['permission'];
        $roleParam = $parameters['role'];

        $role = Role::where('name', $roleParam)->first();

        $permission = Permission::where('name', $permissionParam)->first(); 

        $role->attachPermission($permission);

        return $this->response->created();
    }

    public function getPermssions($roleParam)
    {
        $role = Role::where('name', $roleParam)->first;

        return $this->response->array($role->perms);
    }
    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }

    /**
     * Convert an authentication exception into an unauthenticated response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        return redirect()->guest(route('login'));
    }
   
}
