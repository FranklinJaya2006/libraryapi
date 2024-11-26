<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Cd;
use App\Models\Jurnal;
use App\Models\Newspaper;
use App\Models\Dvd;
use Illuminate\View\View;

class Library extends Controller
{
    public function filter(Request $request)
    {
        $kategori = $request->input('kategori');
        $sortOrder = $request->input('sortOrder', 'asc'); // Default sorting

        $items = [];
        $fields = [];
        $message = "Pilih kategori untuk memfilter data";

        // Filter data berdasarkan kategori dan sesuaikan atributnya
        switch ($kategori) {
            case 'book':
                $items = Book::orderBy('title', $sortOrder)->get();
                $fields = ['title', 'description', 'author', 'thn_terbit', 'jml_halaman'];
                $message = "Menampilkan Buku";
                break;
            case 'jurnal':
                $items = Jurnal::orderBy('title', $sortOrder)->get();
                $fields = ['title', 'description', 'author', 'thn_terbit', 'jml_halaman'];
                $message = "Menampilkan Jurnal";
                break;
            case 'cd':
                $items = Cd::orderBy('title', $sortOrder)->get();
                $fields = ['author', 'title', 'artist', 'genre', 'thn_terbit'];
                $message = "Menampilkan CD";
                break;
            case 'newspaper':
                $items = Newspaper::orderBy('title', $sortOrder)->get();
                $fields = ['title', 'publisher', 'category', 'thn_terbit'];
                $message = "Menampilkan Surat Kabar";
                break;
            case 'dvd':
                $items = Dvd::orderBy('title', $sortOrder)->get();
                $fields = ['author', 'title', 'artist', 'genre', 'thn_terbit'];
                $message = "Menampilkan Dvd";
                break;
        }

        return view('librarian', compact('items', 'message', 'kategori', 'sortOrder', 'fields'));
    }

    public function createItem(Request $request)
    {
        $kategori = $request->input('kategori');

        switch ($kategori) {
            case 'book':
                return redirect()->route('createbook');
            case 'jurnal':
                return redirect()->route('createjurnal');
            case 'cd':
                return redirect()->route('createcd');
            case 'newspaper':
                return redirect()->route('createnewspaper');
            case 'dvd':
                return redirect()->route('createdvd');
            default:
                return redirect()->back()->with('error', 'Pilih kategori yang valid!');
        }
    }

    public function storeBook(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'author' => 'required|string|max:255',
            'thn_terbit' => 'required|integer',
            'jml_halaman' => 'required|integer',
        ]);

        \App\Models\Book::create($request->all());

        return redirect()->route('librarian')->with('success', 'Buku berhasil ditambahkan!');
    }


    public function storeJurnal(Request $request)
    {
        \App\Models\Jurnal::create($request->all());
        return redirect()->route('librarian')->with('success', 'Jurnal berhasil ditambahkan!');
    }

    public function storeCd(Request $request)
    {
        \App\Models\Cd::create($request->all());
        return redirect()->route('librarian')->with('success', 'CD berhasil ditambahkan!');
    }

    public function storeNewspaper(Request $request)
    {
        \App\Models\Newspaper::create($request->all());
        return redirect()->route('librarian')->with('success', 'Surat Kabar berhasil ditambahkan!');
    }

    public function storeDvd(Request $request)
    {
        \App\Models\Dvd::create($request->all());
        return redirect()->route('librarian')->with('success', 'DVD berhasil ditambahkan!');
    }

    public function editBook($id)
    {
        $book = Book::findOrFail($id);
        return view('editbook', compact('book'));
    }

    // Method untuk melakukan update book
    public function updateBook(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'thn_terbit' => 'required|integer',
            'jml_halaman' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        // Update data book
        $book = Book::findOrFail($id);
        $book->update($validatedData);

        // Redirect kembali ke halaman librarian dengan pesan sukses
        return redirect()->route('librarian')->with('success', 'Buku berhasil diperbarui!');
    }

    // Method untuk menampilkan form edit jurnal
    public function editJurnal($id)
    {
        $jurnal = Jurnal::findOrFail($id);
        return view('editjurnal', compact('jurnal'));
    }

    // Method untuk melakukan update jurnal
    public function updateJurnal(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'thn_terbit' => 'required|integer',
            'jml_halaman' => 'required|integer',
            'description' => 'nullable|string',
        ]);

        // Update data jurnal
        $jurnal = Jurnal::findOrFail($id);
        $jurnal->update($validatedData);

        // Redirect kembali ke halaman librarian dengan pesan sukses
        return redirect()->route('librarian')->with('success', 'Jurnal berhasil diperbarui!');
    }

    // Method untuk menampilkan form edit cd
    public function editCd($id)
    {
        $cd = Cd::findOrFail($id);
        return view('editcd', compact('cd'));
    }

    // Method untuk melakukan update cd
    public function updateCd(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'artist' => 'required|string',
            'genre' => 'required|string',
            'thn_terbit' => 'required|integer',
        ]);

        // Update data cd
        $cd = Cd::findOrFail($id);
        $cd->update($validatedData);

        // Redirect kembali ke halaman librarian dengan pesan sukses
        return redirect()->route('librarian')->with('success', 'CD berhasil diperbarui!');
    }

    // Method untuk menampilkan form edit newspaper
    public function editNewspaper($id)
    {
        $newspaper = Newspaper::findOrFail($id);
        return view('editnewspaper', compact('newspaper'));
    }

    // Method untuk melakukan update newspaper
    public function updateNewspaper(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string',
            'publisher' => 'required|string',
            'category' => 'required|string',
            'thn_terbit' => 'required|integer',
        ]);

        // Update data newspaper
        $newspaper = Newspaper::findOrFail($id);
        $newspaper->update($validatedData);

        // Redirect kembali ke halaman librarian dengan pesan sukses
        return redirect()->route('librarian')->with('success', 'Surat Kabar berhasil diperbarui!');
    }

    // Method untuk menampilkan form edit dvd
    public function editDvd($id)
    {
        $dvd = Dvd::findOrFail($id);
        return view('editdvd', compact('dvd'));
    }

    // Method untuk melakukan update dvd
    public function updateDvd(Request $request, $id)
    {
        // Validasi input
        $validatedData = $request->validate([
            'title' => 'required|string',
            'author' => 'required|string',
            'artist' => 'required|string',
            'genre' => 'required|string',
            'thn_terbit' => 'required|integer',
        ]);

        // Update data dvd
        $dvd = Dvd::findOrFail($id);
        $dvd->update($validatedData);

        // Redirect kembali ke halaman librarian dengan pesan sukses
        return redirect()->route('librarian')->with('success', 'DVD berhasil diperbarui!');
    }

    public function deleteBook($id)
    {
        $book = Book::find($id);
        if ($book) {
            $book->delete();
            return redirect()->route('librarian')->with('success', 'Buku berhasil dihapus.');
        }
        return redirect()->route('librarian')->with('error', 'Buku tidak ditemukan.');
    }

    public function deleteJurnal($id)
    {
        $jurnal = Jurnal::find($id);
        if ($jurnal) {
            $jurnal->delete();
            return redirect()->route('librarian')->with('success', 'Jurnal berhasil dihapus.');
        }
        return redirect()->route('librarian')->with('error', 'Jurnal tidak ditemukan.');
    }

    public function deleteCd($id)
    {
        $cd = Cd::find($id);
        if ($cd) {
            $cd->delete();
            return redirect()->route('librarian')->with('success', 'CD berhasil dihapus.');
        }
        return redirect()->route('librarian')->with('error', 'CD tidak ditemukan.');
    }

    public function deleteNewspaper($id)
    {
        $newspaper = Newspaper::find($id);
        if ($newspaper) {
            $newspaper->delete();
            return redirect()->route('librarian')->with('success', 'Surat Kabar berhasil dihapus.');
        }
        return redirect()->route('librarian')->with('error', 'Surat Kabar tidak ditemukan.');
    }

    public function deleteDvd($id)
    {
        $dvd = Dvd::find($id);
        if ($dvd) {
            $dvd->delete();
            return redirect()->route('librarian')->with('success', 'DVD berhasil dihapus.');
        }
        return redirect()->route('librarian')->with('error', 'DVD tidak ditemukan.');
    }

    public function approveItem($id)
    {
        // Temukan item yang masih pending
        $item = Item::find($id);
        
        if ($item && $item->status === 'pending') {
            $item->status = 'approved'; // Update status menjadi approved
            $item->save();
            
            return redirect()->route('librarian')->with('success', 'Item berhasil disetujui.');
        }

        return redirect()->route('librarian')->with('error', 'Item tidak ditemukan atau sudah disetujui.');
    }

    public function rejectItem($id)
    {
        // Temukan item yang masih pending
        $item = Item::find($id);
        
        if ($item && $item->status === 'pending') {
            $item->status = 'rejected'; // Update status menjadi rejected
            $item->save();
            
            return redirect()->route('librarian')->with('error', 'Item telah ditolak.');
        }

        return redirect()->route('librarian')->with('error', 'Item tidak ditemukan atau sudah disetujui.');
    }

}
