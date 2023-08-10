<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Practice extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $primaryKey = 'id_quiz';

    public function getAnswerChoicesAttribute()
    {
        return json_decode($this->attributes['answer_choices']);
    }

    public function studentAnswer(){
        return $this->belongsTo(StudentAnswer::class,'id_quiz','id_quiz');
    }

}
