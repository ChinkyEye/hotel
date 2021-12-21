<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use Auth;

class CategoryController extends Controller
{
    public function index(Request $request){
      $posts = Category::orderBy('id','DESC');
      if(empty($request->search))
        {            
          $posts = $posts;
        }
      else{
            $search = $request->search;
            $posts = $posts->where('name', 'LIKE',"%{$search}%");
        }
        $posts = $posts->paginate(15);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'categories' => $posts
       ];
       return response()->json($response);
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
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
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
        $categorySelect = Category::orderBy('id','DESC')
                                    ->where('type_id','2')
                                    ->where('is_active','1')
                                    ->where('created_by',Auth::user()->id)
                                    ->select('id','name')->get();
        return response()->json([
            'categorySelect'=>$categorySelect
        ],200);
    }

    public function all_categorybuyer_select(){
        $categorySelect = Category::orderBy('id','DESC')->where('type_id','1')->where('is_active','1')->where('created_by', Auth::user()->id)->select('id','name')->get();
        return response()->json([
            'buyercategorySelect'=>$categorySelect
        ],200);
    }

    public function all_categorybuyer(){
        $categorySelectAll = Category::orderBy('id','DESC')->where('type_id','1')->where('created_by', Auth::user()->id)->select('id','name')->get();
        return response()->json([
            'buyercategorySelectAll'=>$categorySelectAll
        ],200);
    }

    public function all_categoryseller(){
        $categorySelectAll = Category::orderBy('id','DESC')->where('type_id','2')->select('id','name')->get();
        return response()->json([
            'sellercategorySelectAll'=>$categorySelectAll
        ],200);
    }

    public function buyerList(Request $request){
        // dd('hello buyer');
      $posts = Category::orderBy('id','DESC')->where('type_id',1);
      if(empty($request->search))
        {            
          $posts = $posts;
        }
      else{
            $search = $request->search;
            $posts = $posts->where('name', 'LIKE',"%{$search}%");
        }
        $posts = $posts->paginate(15);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'buyingcategories' => $posts
       ];
       return response()->json($response);
    }

    public function sellingList(Request $request){
        // dd('hello');
      $posts = Category::orderBy('id','DESC')->where('type_id',2);
      if(empty($request->search))
        {            
          $posts = $posts;
        }
      else{
            $search = $request->search;
            $posts = $posts->where('name', 'LIKE',"%{$search}%");
        }
        $posts = $posts->paginate(15);
        $response = [
           'pagination' => [
               'total' => $posts->total(),
               'per_page' => $posts->perPage(),
               'current_page' => $posts->currentPage(),
               'last_page' => $posts->lastPage(),
               'from' => $posts->firstItem(),
               'to' => $posts->lastItem()
           ],
           'sellingcategories' => $posts
       ];
       return response()->json($response);
    }
}