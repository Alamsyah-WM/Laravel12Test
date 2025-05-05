<?php

namespace App\Http\Controllers\Api;

use App\Models\master;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterResource;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;

class MasterController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index'])
        ];
    }

    public function index() {
        $master = master::get();
        if($master->count() > 0) {
            return MasterResource::collection($master);
        } else {
            return response()->json(['message' => 'No record available'], 200);
        }

    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'code' => 'required|integer',
            'label' => 'required|string|max:255',
            'itemgroup' => 'required|string',
            'itemunit' => 'required|string',
            'active' => 'required|boolean',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be fill',
                'error' => $validator->messages(),
            ],422);
        }

        $master = $request->user()->master()->create([
            'code' => $request->code,
            'label' => $request->label,
            'itemgroup' => $request->itemgroup,
            'itemunit' => $request->itemunit,   
            'active' => $request->active,        
        ]);

        return response()->json([
            'message' => 'Add item success',
            'data' => new MasterResource($master)
        ],200);
    }

    public function show(master $master_item) {
        return new MasterResource($master_item);
    }

    public function update(Request $request, master $master_item) {
        $validator = Validator::make($request->all(),[
            'code' => 'required|integer',
            'label' => 'required|string|max:255',
            'itemgroup' => 'required|string',
            'itemunit' => 'required|string',
            'active' => 'required|boolean',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be fill',
                'error' => $validator->messages(),
            ],422);
        }

        $master_item -> update([
            'code' => $request->code,
            'label' => $request->label,
            'itemgroup' => $request->itemgroup,
            'itemunit' => $request->itemunit,   
            'active' => $request->active,            
        ]);

        return response()->json([
            'message' => 'Update item success',
            'data' => new MasterResource($master_item)
        ],200);
    }

    public function destroy(master $master_item) {
        $master_item -> delete();
        return response()->json([
            'message' => 'Master deleted successfully',
        ],200);
    }
}
