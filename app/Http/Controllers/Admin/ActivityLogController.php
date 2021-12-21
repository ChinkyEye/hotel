<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Response;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index()
    {
        // dd('jj');
        // activity()->log('Look mum, I logged something');
        $posts = Activity::orderBy('id','DESC');
        // dd($posts);
        if(empty($request->search))
        {            
            $posts = $posts;
        }
        else{
            $search = $request->search;
            $posts = $posts->where('name', 'LIKE',"%{$search}%");
        }
        $posts = $posts->paginate(5);
        $response = [
            'pagination' => [
              'total' => $posts->total(),
              'per_page' => $posts->perPage(),
              'current_page' => $posts->currentPage(),
              'last_page' => $posts->lastPage(),
              'from' => $posts->firstItem(),
              'to' => $posts->lastItem()
          ],
          'activitylogs' => $posts
        ];
        return response()->json($response);
    }
}
