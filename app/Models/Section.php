<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'form_id',
        'position'
    ];
    public function form()
    {
        return $this->belongsTo(Form::class);
    }
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
