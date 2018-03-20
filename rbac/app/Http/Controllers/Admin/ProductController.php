<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Handlers\M3Result;

class ProductController extends Controller
{
  public function index()
  {
    return view('admin.product.index');
  }

  public function create()
  {
    return view('admin.product.create');
  }

  public function edit()
  {
    return view('admin.product.edit');
  }

  public function destroy($id)
  {
    $m3_result = new M3Result;
    $m3_result->status = 0;
    $m3_result->message = '删除成功';
    return $m3_result->toJson();
  }

}
