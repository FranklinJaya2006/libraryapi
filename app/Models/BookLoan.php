<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Pengguna;
use App\Models\Book;
use App\Models\Cd;
use App\Models\Newspaper;
use App\Models\DVD;
use App\Models\Jurnal;


class BookLoan extends Model
{
    use HasFactory;

    protected $fillable = ['librarian_id', 'item_id', 'borrowed_at', 'returned_at'];

    protected $table = 'items';

    public function librarian()
    {
        return $this->belongsTo(Pengguna::class, 'librarian_id', 'id');
    }

    public function item()
    {
        return $this->morphTo();
    }
}
