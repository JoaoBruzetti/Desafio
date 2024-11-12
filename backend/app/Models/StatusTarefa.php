<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusTarefa extends Model
{
    use HasFactory;

    protected $table = 'statustarefas';

    protected $fillable = [
        'nm',
        'nm_cor',
    ];
}
