<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'image',
        'user_id',
        'job_id',
        'companie_id',
        'categorie_id',
    ];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function job(){
        return $this->belongsTo(Job::class);
    }

    public function companie(){
        return $this->belongsTo(Company::class);
    }

    public function categorie(){
        return $this->belongsTo(Category::class);
    }
}
