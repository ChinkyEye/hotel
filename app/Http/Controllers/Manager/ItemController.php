<?php

namespace App\Http\Controllers\Manager;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use Auth;
use Image;
use App\Exports\Manager\MenuReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function index(Request $request){
      $posts = Item::orderBy('id','DESC')->where('created_by',Auth::user()->id)->with('category','unit');
        if(empty($request->search))
          {            
            $posts = $posts;
          }
        else{
              $search = $request->search;
              $posts = $posts->where('name', 'LIKE',"%{$search}%");
          }
        if(empty($request->category_id))
        {
          $posts = $posts;
        }
        else{
          $category_id = $request->category_id;
          $posts = $posts->where('category_id','LIKE',"%{$category_id}%");
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
           'items' => $posts
       ];
       return response()->json($response);
    }

    public function store(Request $request)
    {   
        $this->validate($request, [
            'name' => 'required',
            'price' => 'required',
            'unit_id' => 'required',
            'category_id' => 'required',
            // 'quantity' => 'required',
            'item_type_id' => 'required',
        ]);
        if($request->item_type_id !=2){
            $stock = $request->stock;
        }else{
            $stock = 0;
        }

        return Item::create([
           'name' => $request['name'],
           'slug' => str_replace(' ', '-', strtolower($request['name'])).'-'.rand(1000,9999),
           'price' => $request['price'],
           'unit_id' => $request['unit_id'],
           'category_id' => $request['category_id'],
           'quantity' => '1',
           'item_type_id' => $request['item_type_id'],
           'stock' => $stock,
           'qty_rem' => $stock,
           'is_active' => '1',
           'date' => date("Y-m-d"),
           'date_np' => $this->helper->date_np_con(),
           'time' => date("H:i:s"),
           'created_by' => Auth::user()->id,
        ]);
    }

    public function edit($id){
        $items = Item::findOrFail($id);
        return response()->json([
            'items'=>$items
        ],200);
    }

    public function update(Request $request, $id)
    {   
        $this->validate($request, [
            'name' => 'required',
        ]);
        $items = Item::findOrFail($id);
        $items->update($request->all());
    }

     public function destroy($id){
        $items = Item::findOrFail($id);
        $items->delete();
        return ['message'=>'ok'];
    }

    public function status($id, $avi){
        $items = Item::findOrFail($id);
        $items->is_active = !$avi;
        $items->save();
    }

    public function all_item_select(){
        $items = Item::orderBy('id','DESC')->where('is_active','1')->select('id','name')->get();
        return response()->json([
            'itemSelect'=>$items
        ],200);
    }

    public function all_item_select_ready(){
        $items = Item::orderBy('id','DESC')->where('is_active','1')->where('item_type_id','1')->select('id','name')->get();
        return response()->json([
            'itemSelectReady'=>$items
        ],200);
    }

    public function fileExport(Request $request) 
    {
      $filename = 'menuReport.xlsx';
      return Excel::download(new MenuReportExport($request->search, $request->category_id), $filename);
    }

    public function viewImage(Request $request, $id){
      $posts = Item::orderBy('id','DESC')->where('id',$id)->get();
      // dd($id);
      $response = [
        'productimages' => $posts,
        'name' => Item::where('id',$id)->value('name'),
        'productimage' => Item::where('id',$id)->value('image_enc'),
      ];
      return response()->json($response);
    }

    public function addImage(Request $request){
        // dd('hello');
        // dd($request->photo);
      $id = $request->id;
      $this->validate($request, [
        'photo' => 'required|mimes:jpg,jpeg|max:5024',
      ]);
      $itemimage = Item::findOrFail($id);
      $file = $request->file('photo');
      $destinationPath = 'image/item'; // upload path
      $name_enc = date('YmdHis') . "." . $file->getClientOriginalExtension();
      $name = $file->getClientOriginalName();
      $file->move($destinationPath, $name_enc);

      $itemimage->update([
        'image_enc' => $name_enc,
        'updated_by' => Auth::user()->id,
      ]);
      return ['message' => 'Item Image Created'];
    }

    public function destroyimage($id){
      $item = Item::findOrFail($id);
      if (file_exists('image/item/'.$item->image_enc)) {
        unlink('image/item/'.$item->image_enc);
      }
      $image =  null;
      $image_enc = null;
      $item->update([
        'image_enc' => $image_enc,
      ]);
      return ['message'=>'ok'];
    }

    
}