<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comboModel extends Model
{
    use HasFactory;

    protected $table = "combo";

    public $timestamps = false;
}
