<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionsRequest;
use App\Transformers\PermissionsTransformer;
use App\Transformers\RolesTransformer;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends ApiController
{
    public function index()
    {
        $roles=Role::all();
        $data =fractal($roles,new RolesTransformer());

        return $this->successResponse($data,'Roles found with success');
    }

    public function store(PermissionsRequest $request)
    {
        $permission = Permission::create([
            'name'=>$request->input('name')
        ]);

        $data = fractal($permission, new PermissionsTransformer());

        return $this->successResponse($data,'Permission added with success',201);
    }

    public function show(Permission $permission)
    {
        $data = fractal($permission,new PermissionsTransformer());
        return $this->successResponse($data,'Permission found with success');
    }

    public function update(PermissionsRequest $request, Permission $permission)
    {
        $permission->update([
            'name'=>$request->input('name')
        ]);
        $data = fractal($permission,new PermissionsTransformer());

        return $this->successResponse($data,'Permission updated with success');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();
        return $this->successResponse(null,'Permission deleted with success',204);
    }
}
