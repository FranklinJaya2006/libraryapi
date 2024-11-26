<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BookLoan;

class Dvd extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $table = 'dvds';
    protected $fillable = [
        'author',
        'title',
        'artist',
        'genre',
        'thn_terbit',
        'status'
    ];

    public function bookLoans()
    {
        return $this->morphMany(BookLoan::class, 'item');
    }
}
