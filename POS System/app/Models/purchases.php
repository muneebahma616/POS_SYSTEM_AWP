<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class purchases extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function vender()
    {
        return $this->belongsTo(vender::class);
    }
}
