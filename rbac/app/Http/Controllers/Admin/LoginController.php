<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Handlers\ValidateCode;
use App\Handlers\M3Result;
use App\Models\Manager;
use App\Models\Role;
use App\Models\Permission;

class LoginController extends Controller
{
    public function showLoginForm(Request $request)
    {
      $return_url = $request->input('return_url', '');
      return view('admin.login.login')->with('return_url', urldecode($return_url));
    }

    public function login(Request $request, Permission $permission)
    {

      $m3_result = new M3Result;
      $username = $request->input('username', '');
      $password = $request->input('password', '');
      $validate_code = $request->input('validate_code', '');


      $validate_code_session = $request->session()->get('validate_code');
      if($validate_code != $validate_code_session){
        $m3_result->status = 1;
        $m3_result->message = '验证码不正确';
        return $m3_result->toJson();
      }


      if($username == '' || $password == '') {
        $m3_result->status = 1;
        $m3_result->message = "帐号或密码不能为空!";
        return $m3_result->toJson();
      }

      $manager = Manager::where('username', $username)->where('password',md5($password))->first();
      if(!$manager) {
        $m3_result->status = 2;
        $m3_result->message = "帐号或密码错误!";
      } else {
        $m3_result->status = 0;
        $m3_result->message = "登录成功!";
        $adminSession = [];
        $adminSession['data'] = $manager->username;
        $adminSession['expire'] = time()+2*3600;
        $request->session()->put('admin', $adminSession);
        $this->getPermission($manager['roleid'], $request, $permission);

      }

      return $m3_result->toJson();
    }

    public function logout(Request $request)
    {
      $request->session()->flush();
      $return_url = $request->input('return_url', '');
      return redirect('admin/login')->with('return_url', urldecode($return_url));
    }

    public function validateCode(Request $request, ValidateCode $validateCode)
    {
      $request->session()->put('validate_code', $validateCode->getCode());
      return $validateCode->doimg();
    }

    public  function getPermission($roleid, $request, $permission)
    {
        $role = new Role;
    	 	$role_id = $role->find($roleid);
        $request->session()->put('rolename', $role_id->rolename);

        if($role_id->per_list == '*'){
          $request->session()->put('privileage', "*");
          $permissions = $permission->get();
          $menu=array();
          $menu2=array();
          foreach($permissions as  $v){
    	 			if($v['pid']==0){
              $data = array('id'=>$v->id,'pername'=>$v->pername);
    	 				$menu[] = $data;
    	 			}
          }

    	 		foreach ($menu as $k => $v) {
    	 			foreach ($permissions as $k2 => $v2) {
    	 				if($v2->pid==$v['id']){
                $data2 = array('id'=>$v2->id, 'pid'=>$v2->pid, 'pername'=>$v2->pername,'cname'=>$v2->cname, 'aname'=>$v2->aname);
    	 					$menu2[] = $data2;
    	 				}
    	 			}
    	 		}
          $request->session()->put('menu', $menu);
          $request->session()->put('menu2', $menu2);

        }else{
          $ids = explode(',', $role_id->per_list);
          $permissions = $permission->whereIn('id', $ids)->get();
          $_permissions=array();
          $menu=array();
          $menu2=array();
          foreach($permissions as  $v){
            $url = '/'.$v->mname.'/'.$v->cname.'/'.$v->aname;
    	 			$_permissions[]=$url;
    	 			if($v['pid']==0){
              $data = array('id'=>$v->id,'pername'=>$v->pername);
    	 				$menu[] = $data;
    	 			}
          }
          $request->session()->put('privileage', $_permissions);
    	 		foreach ($menu as $k => $v) {
    	 			foreach ($permissions as $k2 => $v2) {
    	 				if($v2->pid==$v['id']){
                $data2 = array('id'=>$v2->id, 'pid'=>$v2->pid, 'pername'=>$v2->pername,'cname'=>$v2->cname, 'aname'=>$v2->aname);
    	 					$menu2[] = $data2;
    	 				}
    	 			}
    	 		}
          $request->session()->put('menu2', $menu2);
          $request->session()->put('menu', $menu);
    	 }

     }

}
