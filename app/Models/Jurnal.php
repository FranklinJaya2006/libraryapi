<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BookLoan;

class Jurnal extends Model
{
    use HasFactory;

    /**
     * fillable
     *
     * @var array
     */
    protected $table = 'journals';
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
