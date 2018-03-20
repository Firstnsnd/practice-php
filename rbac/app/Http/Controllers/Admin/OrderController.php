<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Handlers\M3Result;

class OrderController extends Controller
{
  public function index()
  {
    return view('admin.order.index');
  }

  public function create()
  {
    return view('admin.order.create');
  }

  public function edit()
  {
    return view('admin.order.edit');
  }
  public function destroy()
  {
    $m3_result = new M3Result;
    $m3_result->status = 0;
    $m3_result->message = '删除成功';

    return $m3_result->toJson();
  }

}
