<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BookLoan;

class Newspaper extends Model
{
    use HasFactory;
    
     /**
     * fillable
     *
     * @var array
     */

    protected $table = 'newspapers';
    protected $fillable = [
        'author',
        'title',
        'publisher',
        'category',
        'thn_terbit',
        'status'
    ];

    public function bookLoans()
    {
        return $this->morphMany(BookLoan::class, 'item');
    }
}
