<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class detailtransaction extends Model
{
    use HasFactory;
    protected $table = 'detail_transaction';

    protected $fillable = [
        'table_transaction_id',
        'master_id',
        'item',
        'quantity',
        'itemunit',
        'note',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'table_transaction_id');
    }
}
