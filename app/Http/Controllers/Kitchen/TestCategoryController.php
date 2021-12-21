<?php

namespace App\Http\Controllers\Kitchen;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Auth;

class TestCategoryController extends Controller
{
  public function index(Request $request)
    {
    if ( $request->input('client') ) {
          return Category::select('id', 'name', 'slug', 'is_active')->get();
        }

        $columns = ['name', 'slug', 'is_active'];

        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = Category::select('id', 'name', 'slug', 'is_active')->orderBy($columns[$column], $dir);

        if ($searchValue) {
            $query->where(function($query) use ($searchValue) {
                $query->where('slug', 'like', '%' . $searchValue . '%')
                ->orWhere('is_active', 'like', '%' . $searchValue . '%');
            });
        }

        $projects = $query->paginate($length);
        return ['data' => $projects, 'draw' => $request->input('draw')];
    }

    public function store(Request $request)
    {  
        $this->validate($request, [
            'name' => 'required',
        ]);

        return Category::create([
           'name' => $request['name'],
           'slug' => str_replace(' ', '-', strtolower($request['name'])).'-'.rand(1000,9999),
           'type_id' => $request['type_id'],
           'is_active' => '1',
           'created_at_np' => $this->helper->date_np_con()." ".date("H:i:s"),
           'created_by' => Auth::user()->id,
        ]);
    }

    public function edit($id){
        $categories = Category::findOrFail($id);
        return response()->json([
            'categories'=>$categories
        ],200);
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);
        $user = Category::findOrFail($id);
        $user->update($request->all());
    }

     public function destroy($id){
        $usertype = Category::findOrFail($id);
        $usertype->delete();
        return ['message'=>'ok'];
    }

    public function status($id, $avi){
        $user = Category::findOrFail($id);
        $user->is_active = !$avi;
        $user->save();
    }

    public function all_category_select(){
        $categorySelect = Category::orderBy('id','DESC')->where('type_id','2')->where('is_active','1')->select('id','name')->get();
        return response()->json([
            'categorySelect'=>$categorySelect
        ],200);
    }

    public function all_categorybuyer_select(){
        $categorySelect = Category::orderBy('id','DESC')->where('type_id','1')->where('is_active','1')->select('id','name')->get();
        return response()->json([
            'buyercategorySelect'=>$categorySelect
        ],200);
    }

    public function all_categorybuyer(){
        $categorySelectAll = Category::orderBy('id','DESC')->where('type_id','1')->select('id','name')->get();
        return response()->json([
            'buyercategorySelectAll'=>$categorySelectAll
        ],200);
    }
}