<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cardsModel extends Model
{
    use HasFactory;

    protected $table = "cards";

    public $timestamps = false;
}
