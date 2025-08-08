<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class userLevelsModel extends Model
{
    use HasFactory;

    protected $table = "user_levels";

    public $timestamps = false;
}
