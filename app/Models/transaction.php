<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class transaction extends Model
{
    use HasFactory;
    protected $table = 'table_transaction';

    protected $fillable = [
        'code',
        'date',
        'account',
        'note',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
