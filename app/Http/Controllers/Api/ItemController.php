<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Item;
use Auth;

use App\Exports\Counter\MenuReportExport;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    public function all_item_select(){
        $items = Item::orderBy('id','DESC')
                ->where('is_active','1');

                 //for pagination
                $take = 25;
                $page = intval(request('page',0));
                $start = $page * $take; // 0 = 0, 1 = 15, 2= 30....

                $posts=$items->with('unit')->skip($start)->take($take)->get();

         return response()->json($posts);

    }

    public function get_selected_item(Request $request){
        $item_value = Item::orderBy('id','DESC')->where('id',$request['id'])->with('unit')->get();
       return response()->json($item_value);
    }

    // public function fileExport(Request $request) 
    // {
    //   $filename = 'menuReport.xlsx';
    //   return Excel::download(new MenuReportExport($request->search, $request->category_id), $filename);
    // }


//get items according to item_type_id
    public function items_from_category(Request $request){
        // dd('here it');
        $items = Item::orderBy('id','DESC')
                ->where('is_active','1')
                ->where('item_type_id',$request['item_type_id'])
                ->with('unit')
                ->get();
         return response()->json($items);

    }

    //get items according to category_id
     public function get_menu_from_category(Request $request){
        $items = Item::orderBy('id','DESC')
        ->where('category_id',$request['category_id'])
        ->where('is_active','1')
        ->with('unit')
        ->get();
        return response()->json($items);
    }

}