<?php

namespace App\Http\Controllers\Api;

use App\Models\master;
use Illuminate\Http\Request;
use App\Models\detailtransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Routing\Controllers\Middleware;
use App\Http\Resources\DetailTransactionResource;
use Illuminate\Routing\Controllers\HasMiddleware;

class DetailTransactionController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index'])
        ];
    }

    public function index($transactionId) {
        $detailtransaction = detailtransaction::get();
        if($detailtransaction->count() > 0) {
            return DetailTransactionResource::where('table_transaction_id', $transactionId)->get();
        } else {
            return response()->json(['message' => 'No record available'], 200);
        }

    }

    public function store(Request $request, $transactionId) {
        $validator = Validator::make($request->all(),[
            'master_id' => 'required|integer|exists:master_items,id',
            'quantity' => 'required|integer',
            'itemunit' => 'required|string',
            'note' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be fill',
                'error' => $validator->messages(),
            ],422);
        }

        $masterItem = master::findOrFail($request->master_id);

        $detailtransaction = $request->user()->detailtransaction()->create([
            'table_transaction_id' => $transactionId,
            'master_id' => $masterItem->id,
            'item' => $masterItem->label,
            'quantity' => $request->quantity,
            'itemunit' => $request->itemunit,
            'note' => $request->note,     
        ]);

        return response()->json([
            'message' => 'Add detail success',
            'data' => new DetailTransactionResource($detailtransaction)
        ],200);
    }

    public function show(detailtransaction $detail_transaction) {
        return new DetailTransactionResource($detail_transaction);
    }

    public function update(Request $request, detailtransaction $detail_transaction) {
        $validator = Validator::make($request->all(),[
            'quantity' => 'required|integer',
            'itemunit' => 'required|string',
            'note' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be fill',
                'error' => $validator->messages(),
            ],422);
        }
        
        $detail_transaction -> update([
            'quantity' => $request->quantity,
            'itemunit' => $request->itemunit,
            'note' => $request->note,          
        ]);

        return response()->json([
            'message' => 'Update Transaction success',
            'data' => new DetailTransactionResource($detail_transaction)
        ],200);
    }

    public function destroy(detailtransaction $detail_transaction) {
        $detail_transaction -> delete();
        return response()->json([
            'message' => 'Detail deleted successfully',
        ],200);
    }
}
