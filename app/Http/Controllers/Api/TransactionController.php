<?php

namespace App\Http\Controllers\Api;

use App\Models\master;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\transaction;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller implements HasMiddleware
{
    public static function middleware()
    {
        return [
            new Middleware('auth:sanctum', except: ['index'])
        ];
    }

    public function index() {
        $transaction = transaction::get();
        if($transaction->count() > 0) {
            return TransactionResource::collection($transaction);
        } else {
            return response()->json(['message' => 'No record available'], 200);
        }

    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(),[
            'code' => 'required|integer',
            'date' => 'required|date_format:Y-m-d',
            'account' => 'required|string',
            'note' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be fill',
                'error' => $validator->messages(),
            ],422);
        }

        $transaction = $request->user()->transaction()->create([
            'code' => $request->code,
            'date' => $request->date,
            'account' => $request->account,
            'note' => $request->note,     
        ]);

        return response()->json([
            'message' => 'Add transaction success',
            'data' => new TransactionResource($transaction)
        ],200);
    }

    public function show(transaction $table_transaction) {
        return new TransactionResource($table_transaction);
    }

    public function update(Request $request, transaction $table_transaction) {
        $validator = Validator::make($request->all(),[
            'code' => 'required|integer',
            'date' => 'required|date_format:Y-m-d',
            'account' => 'required|string',
            'note' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields must be fill',
                'error' => $validator->messages(),
            ],422);
        }
        
        $table_transaction -> update([
            'code' => $request->code,
            'date' => $request->date,
            'account' => $request->account,
            'note' => $request->note,          
        ]);

        return response()->json([
            'message' => 'Update Transaction success',
            'data' => new TransactionResource($table_transaction)
        ],200);
    }

    public function destroy(transaction $table_transaction) {
        $table_transaction -> delete();
        return response()->json([
            'message' => 'Transaction deleted successfully',
        ],200);
    }
}
