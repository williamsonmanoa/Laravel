<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etape extends Model
{
    protected $guarded = ['id'];
    use CrudTrait;
    use HasFactory;

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
