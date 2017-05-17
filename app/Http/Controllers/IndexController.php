<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class IndexController extends Controller
{
    public function index($slug)
    {
        $data = [];
        $storagePath  = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        $slug_files = File::glob($storagePath.$slug.'_*');
        foreach($slug_files as $file){
            $data[] = json_decode(file_get_contents($file));
        }
        return response()->json($data);
    }
    public function show($slug, $id)
    {
        $data = json_decode(Storage::disk('local')->get($slug.'_'.$id.'.json'));
        return response()->json($data);
    }
    public function store(Request $request, $slug){
        Storage::disk('local')->put($slug.'_'.$request->get('id').'.json', $request->getContent());
        return $request->all();
    }
    public function put(Request $request, $slug, $id){
        Storage::disk('local')->put($slug.'_'.$id.'.json', $request->getContent());
        return $request->all();
    }
    public function patch(Request $request, $slug, $id){
        $request->expectsJson();
        $data = json_decode(Storage::disk('local')->get($slug.'_'.$id.'.json'));

        $object = json_decode($request->getContent());
        foreach(get_object_vars($object) as $key => $val){
            $data->$key = $val;
        }
        Storage::disk('local')->put($slug.'_'.$id.'.json', json_encode($data));
        return response()->json($data);
    }
    public function delete($slug, $id){
        $data = json_decode(Storage::disk('local')->get('project_'.$id.'.json'));
        Storage::disk('local')->delete($slug.'_'.$id.'.json');
        return response()->json($data);
    }
}
