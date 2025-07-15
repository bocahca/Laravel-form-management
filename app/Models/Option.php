<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory;
    protected $fillable = [
        'question_id',
        'option_text',
        'option_value'
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function options()
    {
        return $this->belongsToMany(Option::class, 'answer_options');
    }
}
