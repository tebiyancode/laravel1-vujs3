<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralSetting extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'font_id',
        'font_size',
        'logo',
        'email',
        'facebook',
        'youtube'
    ];
    public $timestamps = false;
}
