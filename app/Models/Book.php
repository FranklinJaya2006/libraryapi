<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BookLoan;

class Book extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $table = 'books';
    protected $fillable = [
        'author',
        'title',
        'description',
        'thn_terbit',
        'jml_halaman',
        'status'
    ];

    public function bookLoans()
    {
        return $this->morphMany(BookLoan::class, 'item');
    }
}
