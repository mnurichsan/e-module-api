<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_material';

    protected $guarded = [];

    public function module(){
        return $this->belongsTo(LearningModule::class,'id_module','id_module');
    }

    public function practice(){
        return $this->hasMany(Practice::class,'id_material','id_material');
    }

    public function progress(){
        return $this->hasOne(LearningProgress::class,'id_material','id_material');
    }

}
