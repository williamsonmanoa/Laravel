<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resultat extends Model
{
    use CrudTrait;
    protected $guarded = ['id'];

    use HasFactory;

    public function etape()
    {
        return $this->belongsTo(Etape::class);
    }

    public function equipe()
    {
        return $this->belongsTo(Equipe::class);
    }

    public function coureur()
    {
        return $this->belongsTo(Coureur::class);
    }
}
