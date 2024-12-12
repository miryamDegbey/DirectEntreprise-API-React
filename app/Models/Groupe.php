<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Groupe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
        'image',
        'actuality',
    
    ];public function creator() 
    {
        return $this->belongsTo(User::class, 'user_id')->select('id', 'name'); // permet de créer la mi=ultiplicité
    }


}
