<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $table = 'questions';
    protected $fillable = ['text', 'answer', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function userQuestionStatuses()
    {
        return $this->hasMany(UserQuestionStatus::class);
    }
}
