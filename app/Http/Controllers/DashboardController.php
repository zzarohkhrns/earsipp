<?php

namespace App\Http\Controllers;

use App\Models\ArsipDigital;
use App\Models\Aset;
use App\Models\Berita;
use App\Models\Disposisi;
use App\Models\Kegiatan;
use App\Models\Memo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function __construct()
    {
        view()->composer('*', function ($view) {

            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                $role = 'pc';
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                $role = 'upzis';
            } elseif (Auth::user()->gocap_id_ranting_pengurus != NULL) {
                $role = 'ranting';
            }
            $view->with('role', $role);
        });
    }

    public function index()
    {

        // pc
        if (Auth::user()->gocap_id_pc_pengurus) {
            $id = 'pc';
            $title = "DASHBOARD E-ARSIP";

            if (
                Auth::user()->PcPengurus->PengurusJabatan->jabatan == 'Direktur Eksekutif' ||
                Auth::user()->PcPengurus->PengurusJabatan->jabatan == 'Ketua Pengurus Harian'
            ) {

                $jumlah_memo = Memo::count();
            } else {
                $j1 = Memo::where('id_pengguna', Auth::user()->id_pengguna)->count();
                $j2 = Disposisi::where('id_memo', '!=', null)->where('id_pc', Auth::user()->PcPengurus->id_pc)->count();
                $jumlah_memo = $j1 + $j2;
            }

            $jumlah_kegiatan = Kegiatan::where('id_upzis', null)->count();
            $jumlah_berita = Berita::count();
            $jumlah_surat_masuk = ArsipDigital::where('jenis_arsip', 'Surat Masuk')->count();
            $jumlah_surat_keluar = ArsipDigital::where('jenis_arsip', 'Surat Keluar')->count();
            $jumlah_dokumen = ArsipDigital::where('jenis_arsip', 'Dokumen')->count();
            $jumlah_aset = Aset::count();
        }

        // upzis
        if (Auth::user()->gocap_id_upzis_pengurus) {
            $id = 'upzis';
            $title = "DASHBOARD E-ARSIP";
            $jumlah_berita = '';
            $jumlah_memo = '';
            $jumlah_kegiatan = Kegiatan::where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)->count();
            $jumlah_aset = Aset::count();


            $m1 = ArsipDigital::where('jenis_arsip', 'Surat Masuk')->where('id_pengguna', Auth::user()->id_pengguna)->count();
            $m2 = ArsipDigital::join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('jenis_arsip', 'Surat Masuk')
                ->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)->count();
            $m3 = Disposisi::where('id_pengurus_internal', Auth::user()->gocap_id_upzis_pengurus)->count();
            $jumlah_surat_masuk = $m1 + $m2 + $m3;

            $k1 = ArsipDigital::where('jenis_arsip', 'Surat Keluar')->where('id_pengguna', Auth::user()->id_pengguna)->count();
            $k2 = ArsipDigital::join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('jenis_arsip', 'Surat Keluar')
                ->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)->count();
            $k3 = Disposisi::where('id_pengurus_internal', Auth::user()->gocap_id_upzis_pengurus)->count();
            $jumlah_surat_keluar = $k1 + $k2 + $k3;


            $d1 = ArsipDigital::where('jenis_arsip', 'Dokumen Digital')->where('id_pengguna', Auth::user()->id_pengguna)->count();
            $d2 = ArsipDigital::join('disposisi', 'arsip_digital.arsip_digital_id', '=', 'disposisi.arsip_digital_id')
                ->where('jenis_arsip', 'Dokumen Digital')
                ->where('id_upzis', Auth::user()->UpzisPengurus->id_upzis)->count();
            $d3 = Disposisi::where('id_pengurus_internal', Auth::user()->gocap_id_upzis_pengurus)->count();
            $jumlah_dokumen = $d1 + $d2 + $d3;
        }

        if (Auth::user()->gocap_id_ranting_pengurus) {
            $id = 'ranting';
            $title = "DASHBOARD E-ARSIP";
            $jumlah_berita = '';
            $jumlah_memo = '';
            $jumlah_kegiatan = '';

            $jumlah_surat_masuk = '';
            $jumlah_surat_keluar = '';
            $jumlah_dokumen = '';
        }


        return view(
            'dashboard',
            compact('title', 'jumlah_aset',  'jumlah_memo', 'jumlah_berita', 'jumlah_kegiatan', 'jumlah_surat_masuk', 'jumlah_surat_keluar', 'jumlah_dokumen')
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
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
