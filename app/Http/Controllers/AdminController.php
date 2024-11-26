<?php
namespace App\Http\Controllers;

use App\Models\Pengguna;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Menampilkan daftar librarian untuk View atau API
    public function showLibrarians(Request $request)
    {
        $librarians = Pengguna::where('role', 'librarian')->get();

        // Jika permintaan berbentuk JSON (untuk API)
        if ($request->wantsJson()) {
            if ($librarians->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada librarian yang terdaftar'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => $librarians
            ], 200);
        }

        // Jika permintaan untuk View
        return view('admin', compact('librarians'));
    }

    // Menghapus librarian
    public function deleteLibrarian(Request $request, $id)
    {
        $librarian = Pengguna::find($id);

        if (!$librarian) {
            // Respons JSON untuk API
            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Librarian tidak ditemukan'
                ], 404);
            }

            // Redirect untuk View
            return redirect()->route('admin')->with('error', 'Librarian tidak ditemukan.');
        }

        $librarian->delete();

        // Respons JSON untuk API
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Librarian berhasil dihapus'
            ], 200);
        }

        // Redirect untuk View
        return redirect()->route('admin')->with('success', 'Librarian berhasil dihapus.');
    }

    public function approveRequest($id)
    {
        $request = BookLoan::findOrFail($id);
        $request->update(['approved_at' => now()]);

        return redirect()->back()->with('success', 'Request berhasil disetujui.');
    }
}