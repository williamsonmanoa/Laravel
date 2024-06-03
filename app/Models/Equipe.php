<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    protected $guarded = ['id'];
    use CrudTrait;
    use HasFactory;

    public function coureurs()
    {
        return $this->hasMany(Coureur::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
