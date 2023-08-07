<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningModule extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_module';
    protected $guarded = [];

    public function material(){
        return $this->hasMany(LearningMaterial::class,'id_module','id_module');
    }


}
