<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\HeadlineBerita;
use App\Models\Layanan;
use App\Models\OtherBerita;
use App\Models\Pengumuman;
use App\Models\TravelRecommendation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class BeritaController extends Controller
{
    public function index()
    {
        $allBerita = $this->getAllBerita();
        return view('berita.listberita', ['allBerita' => $allBerita]);
    }

    public function home()
    {
        $allBerita = DB::table('headline_berita')
            ->select('id', 'title', 'image', 'date', DB::raw("'headline' as type"))
            ->unionAll(
                DB::table('other_berita')
                    ->select('id', 'title', 'image', 'date', DB::raw("'other' as type"))
            )
            ->orderByDesc('date')
            ->get();

        foreach ($allBerita as $berita) {
            $berita->formatted_date = \Carbon\Carbon::parse($berita->date)->translatedFormat('d F Y');
        }

        $headlineBerita = $allBerita->take(2);
        $otherBerita = $allBerita->slice(2);
        $pengumuman = Pengumuman::all();
        $travelRecommendations = TravelRecommendation::all();
        $layanans = Layanan::all();
        $galleries = Gallery::all();
        $events = Event::all();

        foreach ($headlineBerita as $item) {
            $item->formatted_date = Carbon::parse($item->date)->translatedFormat('d F Y');
        }

        foreach ($otherBerita as $item) {
            $item->formatted_date = Carbon::parse($item->date)->translatedFormat('d F Y');
        }

        foreach ($pengumuman as $item) {
            $item->formatted_date = Carbon::parse($item->tanggal)->translatedFormat('d F Y');
        }

        return view('home', compact('headlineBerita', 'otherBerita', 'pengumuman', 'travelRecommendations', 'layanans', 'galleries', 'events'));
    }

    public function show($id)
    {
        $berita = $this->findBeritaById($id);

        if (!$berita) {
            return redirect()->route('content.list_content')->with('error', 'Berita tidak ditemukan.');
        }

        $otherBerita = OtherBerita::latest()->take(5)->get();
        foreach ($otherBerita as $item) {
            $item->formatted_date = Carbon::parse($item->date)->translatedFormat('d F Y');
        }

        return view('content.detail_content', compact('berita', 'otherBerita'));
    }

    public function store(Request $request)
    {
        $this->validateRequest($request);

        try {
            $imagePath = $request->file('image')->store('images', 'public');
            $data = $request->only(['title', 'subtitle', 'content', 'author', 'date']);
            $data['image'] = $imagePath;

            if ($request->type == 'kota') {
                HeadlineBerita::create($data);
            } else {
                OtherBerita::create($data);
            }

            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diupload!');
        } catch (\Exception $e) {
            return redirect()->route('admin.berita.index')->with('error', 'Terjadi kesalahan saat mengupload berita: ' . $e->getMessage());
        }
    }

    public function adminIndex()
    {
        $allBerita = $this->getAllBerita();
        return view('admin.berita.index', compact('allBerita'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function edit($id)
    {
        $berita = $this->findBeritaById($id);

        if (!$berita) {
            return redirect()->route('admin.berita.index')->with('error', 'Berita tidak ditemukan.');
        }

        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, $id)
    {
        $this->validateRequest($request, false);

        try {
            $berita = $this->findBeritaById($id);

            if (!$berita) {
                return redirect()->route('admin.berita.index')->with('error', 'Berita tidak ditemukan.');
            }

            $data = $request->only(['title', 'subtitle', 'content', 'author', 'date']);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('images', 'public');
                $data['image'] = $imagePath;
            }

            $berita->update($data);

            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->route('admin.berita.index')->with('error', 'Terjadi kesalahan saat memperbarui berita: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $berita = $this->findBeritaById($id);

            if (!$berita) {
                return redirect()->route('admin.berita.index')->with('error', 'Berita tidak ditemukan.');
            }

            $berita->delete();

            return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('admin.berita.index')->with('error', 'Terjadi kesalahan saat menghapus berita: ' . $e->getMessage());
        }
    }

    private function validateRequest(Request $request, $isCreate = true)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'required|string|max:255',
            'date' => 'required|date',
            'type' => 'required|string|in:kota,lainnya',
        ];

        if ($isCreate) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        } else {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $request->validate($rules);
    }

    private function findBeritaById($id)
    {
        return HeadlineBerita::find($id) ?? OtherBerita::find($id);
    }

    private function getAllBerita()
    {
        $headlineBerita = HeadlineBerita::all();
        $otherBerita = OtherBerita::all();
        return $headlineBerita->merge($otherBerita);
    }
}