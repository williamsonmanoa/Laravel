<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = ['id'];

    use CrudTrait;
    use HasFactory;

    public function etapes()
    {
        return $this->hasMany(Etape::class);
    }
}
