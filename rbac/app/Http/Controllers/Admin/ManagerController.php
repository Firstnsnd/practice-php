<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Handlers\M3Result;
use App\Models\Role;
use App\Models\Manager;


class ManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Manager $manager)
    {
        $managers = Manager::all();
        return view('admin.manager.index', compact('managers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Role $role)
    {
        $roles = $role->get();
        return view('admin.manager.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Manager $manager, M3Result $m3_result)
    {
      $username = $request->input('username', '');
      $password = $request->input('password', '');
      $roleid = $request->input('roleid', '');

      // 可以先做后台数据验证

      $manager->username = $username;
      $manager->password = md5($password);
      $manager->roleid = $roleid;
      $manager->save();

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
    public function edit($id, Role $role, Manager $manager)
    {
      $roles = $role->get();
      $manager_id = $manager->find($id);
      return view('admin.manager.edit', compact('roles', 'manager_id'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manager $manager,  M3Result $m3_result)
    {
      $id = $request->input('id', '');
      $manager = Manager::find($id);
      $username = $request->input('username', '');
      $oldpassword = $request->input('oldpassword', '');
      $password = $request->input('password', '');
      $repassword = $request->input('repassword', '');
      $roleid = $request->input('roleid', '');

      // 判断原密码是否正确
      $manager_id = $manager->find($id);
      if($manager_id['password'] != md5($oldpassword)){
        $m3_result->status = 1;
        $m3_result->message = '原密码不正确';
        return $m3_result->toJson();
      }

      // 判断两次输入的密码是否一致

      $manager->username = $username;
      $manager->password = md5($password);
      $manager->roleid = $roleid;
      $manager->save();

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
    public function destroy($id, Manager $manager, M3Result $m3_result)
    {
        $manager->where('id', '=', $id)->delete();
        $m3_result->status = 0;
        $m3_result->message = '删除成功';
        return $m3_result->toJson();

    }
}
