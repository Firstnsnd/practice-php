<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Handlers\M3Result;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Manager;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Role $role,Permission $permission)
    {
        $roles = $role->get();
        foreach($roles as $role){
          if($role->per_list == '*'){
            continue;
          }
          $ids = explode(',', $role->per_list);
            $permissions = $permission->whereIn('id', $ids)->select('pername')->get();
            $role['pername_list'] = $permissions;
        }
        return view('admin.role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Permission $permission)
    {
        $permissions = $permission->get();
        $permissions = $this->resort($permissions);
        return view('admin.role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Role $role, M3Result $m3_result)
    {
      $rolename = $request->input('rolename', '');
      $per_list = $request->input('per_list', '');
      if(!empty($per_list)){
          $per_list = implode(',', $per_list);
      }else{
        $per_list = '';
      }
      $role->rolename = $rolename;
      $role->per_list = $per_list;
      $role->save();
      $m3_result->status = 0;
      $m3_result->message = '添加成功';

      return $m3_result->toJson();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Permission $permission, Role $role)
    {
        $permissions = $permission->get();
        $permissions = $this->resort($permissions);
        $role_id = $role->find($id);
        return view('admin.role.edit', compact('permissions', 'role_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role, M3Result $m3_result)
    {
      $id = $request->input('id', '');
      $role_id = $role->find($id);
      $rolename = $request->input('rolename', '');
      $per_list = $request->input('per_list', '');
      if(!empty($per_list)){
          $per_list = implode(',', $per_list);
      }else{
        $per_list = '';
      }


      $role_id->rolename = $rolename;
      $role_id->per_list = $per_list;
      $role_id->save();
      $m3_result->status = 0;
      $m3_result->message = '修改成功';

      return $m3_result->toJson();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Role $role)
    {

      $role->where('id', '=', $id)->delete();
      $m3_result = new M3Result;
      $m3_result->status = 0;
      $m3_result->message = '删除成功';

      return $m3_result->toJson();
    }

    private function resort($data,$parentid=0,$level=0)
    {
      static $ret=array();
      foreach ($data as $k => $v) {
        if($v['pid']==$parentid){
          $v['level']=$level;
          $ret[]=$v;
          $this->resort($data,$v['id'],$level+1);
        }
      }
      return $ret;
    }
}
