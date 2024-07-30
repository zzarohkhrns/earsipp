<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Berita;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function __construct()
    {
        view()->composer('*', function ($view) {

            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                $role = 'lazisnu';
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                $role = 'upzis';
            }
            $view->with('role', $role);
        });
    }

    public function kategori()
    {

        $title = "KATEGORI PENERIMA MANFAAT";
        $page = "Kategori";

        return view(
            'kategori.kategori',
            compact('title', 'page')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\Response
     */
    public function show(Berita $berita)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\Response
     */
    public function edit(Berita $berita)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Berita $berita)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Berita  $berita
     * @return \Illuminate\Http\Response
     */
    public function destroy(Berita $berita)
    {
        //
    }
}
