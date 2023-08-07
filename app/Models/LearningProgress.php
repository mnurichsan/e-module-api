<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningProgress extends Model
{
    protected $primaryKey = 'id_progress';
    use HasFactory;

    protected $guarded = [];

    public function user(){
        return $this->belongsTo(User::class,'id_user','id_user');
    }

    public function material(){
        return $this->belongsTo(LearningMaterial::class,'id_material','id_material');
    }
}
