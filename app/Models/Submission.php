<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_id',
        'user_id',
        'status',
        'review_note',
        'approved_by',
        'approved_at',
    ];
    protected $casts = [
        'approved_at' => 'datetime',
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
