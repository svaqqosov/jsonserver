<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index()
    {
        $data = json_decode(Storage::disk('local')->get('project_'.$id.'.json'));
        return response()->json($data);
    }
    public function show($id)
    {
        $data = json_decode(Storage::disk('local')->get('project_'.$id.'.json'));
        return response()->json($data);
    }
    public function store(Request $request){
        Storage::disk('local')->put('project_'.$request->get('id').'.json', $request->getContent());
        return $request->all();
    }
    public function put(Request $request, $id){
        Storage::disk('local')->put('project_'.$id.'.json', $request->getContent());
        return $request->all();
    }
    public function patch(Request $request, $id){
        $request->expectsJson();
        $data = json_decode(Storage::disk('local')->get('project_'.$id.'.json'));

        $object = json_decode($request->getContent());
        foreach(get_object_vars($object) as $key => $val){
            $data->$key = $val;
        }
        Storage::disk('local')->put('project_'.$id.'.json', json_encode($data));
        return response()->json($data);
    }
    public function delete($id){
        $data = json_decode(Storage::disk('local')->get('project_'.$id.'.json'));
        Storage::disk('local')->delete('project_'.$id.'.json');
        return response()->json($data);
    }
}
