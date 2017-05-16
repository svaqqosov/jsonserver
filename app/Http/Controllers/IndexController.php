<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function show($id)
    {
        $data = json_decode(Storage::disk('local')->get('project_'.$id.'.json'));
        return response()->json($data);
    }
    public function store(Request $request){
        Storage::disk('local')->put('project_'.$request->get('id').'.json', json_encode($request->all()));
        return $request->all();
    }
    public function put(Request $request, $id){
        Storage::disk('local')->put('project_'.$id.'.json', json_encode($request->all()));
        return $request->all();
    }
}
