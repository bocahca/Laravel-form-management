<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'is_active',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function sections()
    {
        return $this->hasMany(Section::class)->ordered();;
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
