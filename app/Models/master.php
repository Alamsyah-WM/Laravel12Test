<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class master extends Model
{
    use HasFactory;
    protected $table = 'master_items';

    protected $fillable = [
        'code',
        'label',
        'itemgroup',
        'itemunit',
        'active',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
