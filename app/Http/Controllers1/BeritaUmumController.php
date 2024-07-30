<?php

namespace App\Http\Controllers;

use App\Models\Pc;
use App\Models\Notif;
use App\Models\Upzis;
use App\Models\Berita;
use App\Models\Ranting;
use App\Models\Pengguna;
use App\Models\FileBerita;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\KategoriBerita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class BeritaUmumController extends Controller
{
    public function __construct()
    {
        view()->composer('*', function ($view) {

            $earsip = config('app.database_earsip');
            $siftnu = config('app.database_siftnu');
            $gocap = config('app.database_gocap');

            if (Auth::user()->gocap_id_pc_pengurus != NULL) {
                $ketua_upzis = Upzis::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis', '=', $gocap . '.upzis.id_upzis')
                    ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.upzis_pengurus.id_pengurus_jabatan')
                    ->get();

                // dd(Auth::user()->PcPengurus->Pc->id_pc);
                $id = Auth::user()->gocap_id_pc_pengurus;
                $role = 'pc';
                $nama = 'PC';
                $upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')
                    ->get();
                $ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                    ->get();
                $kategori = DB::table('kategori_aset')->where('id_pengguna', Auth::user()->id_pengguna)->get();
                $tahun_perolehan = DB::table('aset')->select('tahun_perolehan')->groupBy('tahun_perolehan')->get();
                $pengurus =  Pengguna::join($gocap . '.pc_pengurus', $gocap . '.pc_pengurus.id_pc_pengurus', '=', $siftnu . '.pengguna.gocap_id_pc_pengurus')
                    ->where($gocap . '.pc_pengurus.id_pc', Auth::user()->PcPengurus->id_pc)->where('id_pengguna', '!=', Auth::user()->id_pengguna)
                    ->get();
                $wilayah = Auth::user()->PcPengurus->Pc->Wilayah->nama;
            } elseif (Auth::user()->gocap_id_upzis_pengurus != NULL) {
                $ketua_upzis = Upzis::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis', '=', $gocap . '.upzis.id_upzis')
                    ->join($gocap . '.pengurus_jabatan', $gocap . '.pengurus_jabatan.id_pengurus_jabatan', '=', $gocap . '.upzis_pengurus.id_pengurus_jabatan')
                    ->get();
                $id = Auth::user()->gocap_id_upzis_pengurus;
                $role = 'upzis';
                $nama = 'UPZIS';
                $upzis =  Upzis::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.upzis.id_wilayah')->where('id_upzis', '!=', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                    ->get();
                $ranting =  Ranting::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.ranting.id_wilayah')
                    ->join($gocap . '.upzis', $gocap . '.upzis.id_upzis', '=', $gocap . '.ranting.id_upzis')->where($gocap . '.upzis.id_upzis', Auth::user()->UpzisPengurus->Upzis->id_upzis)
                    ->get();
                $kategori = DB::table('kategori_aset')->where('id_pengguna', Auth::user()->id_pengguna)->get();
                $tahun_perolehan = DB::table('aset')->select('tahun_perolehan')->groupBy('tahun_perolehan')->get();
                $pengurus =  Pengguna::join($gocap . '.upzis_pengurus', $gocap . '.upzis_pengurus.id_upzis_pengurus', '=', $siftnu . '.pengguna.gocap_id_upzis_pengurus')
                    ->where($gocap . '.upzis_pengurus.id_upzis', Auth::user()->UpzisPengurus->id_upzis)->where('id_pengguna', '!=', Auth::user()->id_pengguna)
                    ->get();
                $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            } elseif (Auth::user()->gocap_id_ranting_pengurus != NULL) {
                $id = Auth::user()->gocap_id_ranting_pengurus;
                $role = 'ranting';
                $ranting = '';
                $nama = 'RANTING';
                $upzis = '';
                $kategori = DB::table('kategori_aset')->where('id_pengguna', Auth::user()->id_pengguna)->get();
                $pengurus = '';
                $tahun_perolehan = DB::table('aset')->select('tahun_perolehan')->groupBy('tahun_perolehan')->get();
                $wilayah = Auth::user()->RantingPengurus->Ranting->Wilayah->nama;
            }

            $akses = ['Semua Pengurus Internal', 'Semua UPZIS MWCNU', 'Semua Ranting NU'];

            $pc =  Pc::join($siftnu . '.wilayah', $siftnu . '.wilayah.id_wilayah', '=', $gocap . '.pc.id_wilayah')
                ->get();

            $view->with('role', $role)
                ->with('kategori', $kategori)
                ->with('tahun_perolehan', $tahun_perolehan)
                ->with('id', $id)
                ->with('nama', $nama)
                ->with('upzis', $upzis)
                ->with('pc', $pc)
                ->with('akses', $akses)
                ->with('ranting', $ranting)
                ->with('wilayah', $wilayah)
                ->with('ketua_upzis', $ketua_upzis)
                ->with('pengurus', $pengurus);
        });
    }

    public function berita()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'BERITA UMUM';
        $page = "Berita Umum";
        $tahuns = '';
        $bulans = '';
        $kategoris = '';

        $tahun_berita = Berita::select(DB::raw('YEAR(tanggal_terbit) as year'))->groupBy('year')->orderBy('year', 'DESC')->get();

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $berita = DB::table('berita')->where('id_daerah', Auth::user()->PcPengurus->id_pc)->orderby('created_at', 'desc')->get();
            $kategori_berita = DB::table('kategori_berita')->where('id_daerah', Auth::user()->PcPengurus->id_pc)->orderby('created_at', 'desc')->get();

            $berita = DB::table('berita')->where('id_daerah', Auth::user()->PcPengurus->id_pc)->orderby('created_at', 'desc')->get();
        } elseif (Auth::user()->gocap_id_upzis_pengurus) {
            $kategori_berita = DB::table('kategori_berita')->where('id_daerah', Auth::user()->UpzisPengurus->id_upzis)->orderby('created_at', 'desc')->get();
            $berita = DB::table('berita')->where('id_daerah', Auth::user()->UpzisPengurus->id_upzis)->orderby('created_at', 'desc')->get();
        }

        return view('berita.berita', compact('tahun_berita', 'page', 'title', 'berita', 'kategori_berita', 'tahuns', 'bulans', 'kategoris'));
    }

    public function tambah_berita()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'BERITA UMUM';
        $page = "Tambah Berita Umum";

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $berita = DB::table('berita')->where('id_daerah', Auth::user()->PcPengurus->id_pc)->orderby('created_at', 'desc')->get();
            $kategori_berita = DB::table('kategori_berita')->where('id_daerah', Auth::user()->PcPengurus->id_pc)->orderby('created_at', 'desc')->get();

            $berita = DB::table('berita')->where('id_daerah', Auth::user()->PcPengurus->id_pc)->orderby('created_at', 'desc')->get();
        } elseif (Auth::user()->gocap_id_upzis_pengurus) {
            $kategori_berita = DB::table('kategori_berita')->where('id_daerah', Auth::user()->UpzisPengurus->id_upzis)->orderby('created_at', 'desc')->get();
            $berita = DB::table('berita')->where('id_daerah', Auth::user()->UpzisPengurus->id_upzis)->orderby('created_at', 'desc')->get();
        }

        return view('berita.tambah_berita', compact('page', 'title', 'kategori_berita', 'berita'));
    }

    public function kategori_berita()
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $title = 'BERITA UMUM';
        $page = "Kategori Berita";
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $daerah = Auth::user()->PcPengurus->id_pc;
            $kategori_berita = DB::table('kategori_berita')->where('id_daerah', Auth::user()->PcPengurus->id_pc)->orderby('created_at', 'desc')->get();
        } elseif (Auth::user()->gocap_id_upzis_pengurus) {
            $kategori_berita = DB::table('kategori_berita')->where('id_daerah', Auth::user()->UpzisPengurus->id_upzis)->orderby('created_at', 'desc')->get();
            $daerah = Auth::user()->UpzisPengurus->id_upzis;
        }
        return view('berita.kategori_berita', compact('page', 'title', 'kategori_berita'));
    }

    public function aksi_tambah_kategori_berita(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            KategoriBerita::create([
                'id_kategori_berita' => uniqid(),
                'id_pengguna' => Auth::user()->id_pengguna,
                'nama_kategori' => $request->nama_kategori,
                'id_daerah' => Auth::user()->PcPengurus->id_pc,
            ]);
        } elseif (Auth::user()->gocap_id_upzis_pengurus) {
            KategoriBerita::create([
                'id_kategori_berita' => uniqid(),
                'id_pengguna' => Auth::user()->id_pengguna,
                'nama_kategori' => $request->nama_kategori,
                'id_daerah' => Auth::user()->UpzisPengurus->id_upzis,
            ]);
        }



        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Kategori Berita ' . $cek . ' Berhasil Ditambahkan');

        return back();
    }

    public function  aksi_hapus_kategori_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        KategoriBerita::where('id_kategori_berita', $id)->delete();


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Kategori Berita ' . $cek . ' Berhasil Dihapus');
        return back();
    }

    public function aksi_edit_kategori_berita(Request $request, $id)
    {

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        DB::table('kategori_berita')->where('id_kategori_berita', $id)->update([
            'nama_kategori' => $request->nama_kategori,
        ]);





        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Kategori Berita ' . $cek . ' Berhasil Diubah');

        return back();
    }

    function sendGCM($message, $title, $foto)
    {


        $url = 'https://fcm.googleapis.com/fcm/send';
        if ($foto) {

            $fields = array(
                'to' => "/topics/news",
                'notification' => array(
                    "image" => $foto,
                    "body" => $message,
                    'title' => $title
                )
            );
        } else {
            $fields = array(
                'to' => "/topics/news",
                'notification' => array(
                    "body" => $message,
                    'title' => $title
                )
            );
        }
        $fields = json_encode($fields);

        $headers = array(
            'Authorization: key=' . "AAAA24JcgU8:APA91bGwA9b6QzB3-_LFrwGNa45rJ0vuYGMFnT0wV9HK9OF0bts39KAx0Kikl2JL5V7fVXkvksQU4Bs1AKWiSwRklFL-UqR-KCMjTulytpp0yW0XM9tUqI7eYn30e5xVj5c07iK_KyTQ",
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

        $result = curl_exec($ch);
        echo $result;
        curl_close($ch);
    }

    public function aksi_tambah_berita(Request $request)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if ($request->file('foto_background_berita')) {
            if (
                preg_match('/\.(php\d?|phtml|phar|php56|php7)(\.|\z)/', $request->file('foto_background_berita')->getClientOriginalName())
            ) {
                alert()->error('File Upload Tidak Sesuai');
                return back();
            }
        }

        if ($request->file('foto_dokumentasi_berita')) {
            if (
                preg_match('/\.(php\d?|phtml|phar|php56|php7)(\.|\z)/', $request->file('foto_dokumentasi_berita')->getClientOriginalName())
            ) {
                alert()->error('File Upload Tidak Sesuai');
                return back();
            }
        }

        $request->validate([
            'tanggal_terbit' => 'required',
            'kategori_berita' => 'required',
            'judul_berita' => 'required',
            'narasi_berita' => 'required',
            'judul_file_bg' =>  'required',
            'foto_background_berita' => 'required|max:10000|mimes:jpg,jpeg,png',
        ], [
            'tanggal_terbit.required' => 'Tanggal Terbit harus diisi',
            'kategori_berita.required' => 'Kategori Berita harus diisi',
            'judul_berita.required' => 'Judul Berita harus diisi',
            'judul_file_bg' => 'Judul File Berita harus diisi',
            'foto_background_berita' => 'Foto Background Berita harus diisi',
        ]);

        $id_notif = Str::uuid()->toString();
        $id_berita_umum = uniqid();

        if (Auth::user()->gocap_id_pc_pengurus != null) {

            if ($request->foto_background_berita != null) {
                $file = $request->file('foto_background_berita');
                $ext_logo = $file->extension();
                $filename_bg = $file->storeAs('/foto_background_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'foto_background_berita']);
                FileBerita::create([
                    'id_file_berita' => uniqid(),
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'id_berita_umum' => $id_berita_umum,
                    'judul_file' => $request->judul_file_bg,
                    'foto_background_berita' => $filename_bg,
                ]);



                Berita::create([
                    'id_berita_umum' => $id_berita_umum,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'kategori_berita' => $request->kategori_berita,
                    'hastag_berita' => implode(' , ', $request->hastag_berita),
                    'judul_berita' => $request->judul_berita,
                    'narasi_berita' => $request->narasi_berita,
                    'tanggal_terbit' => $request->tanggal_terbit,
                    'foto_background_berita' => $filename_bg,
                    'id_daerah' => Auth::user()->PcPengurus->id_pc,
                    'id_notif' => $id_notif,
                ]);

                if (strlen($request->judul_berita) >= 50) {
                    $int = 50;
                    $num_char = strpos($request->judul_berita, ' ', $int); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s1 = strlen(substr($request->judul_berita, 0, $num_char));
                    $s2 = strlen($request->judul_berita);
                    $dot = '...';
                } else {
                    $num_char = 50;
                    $dot = '';
                }



                if (strlen($request->narasi_berita) >= 150) {
                    $agr = 150;
                    $num_char2 = strpos($request->narasi_berita, ' ', $agr); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s11 = strlen(strip_tags(substr($request->narasi_berita, 0, $num_char2)));
                    $s22 = strlen($request->narasi_berita);
                    $dot2 = '...';
                } else {
                    $num_char2 = 150;
                    $dot2 = '';
                }



                Notif::create([
                    'id' => $id_notif,
                    'judul' => substr($request->judul_berita, 0, $num_char) . $dot,
                    'deskripsi' => strip_tags(substr($request->narasi_berita, 0, $num_char2)) . $dot2,
                    'foto' => 'https://e-arsip.nucarecilacap.id/foto_background_berita/' . $filename_bg,
                    'untuk' => 'semua',
                    'tentang' => 'berita',
                ]);
            } else {


                Berita::create([
                    'id_berita_umum' => $id_berita_umum,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'kategori_berita' => $request->kategori_berita,
                    'hastag_berita' => implode(' , ', $request->hastag_berita),
                    'judul_berita' => $request->judul_berita,
                    'narasi_berita' => $request->narasi_berita,
                    'tanggal_terbit' => $request->tanggal_terbit,
                    'id_daerah' => Auth::user()->PcPengurus->id_pc,
                    'id_notif' => $id_notif,
                ]);

                if (strlen($request->judul_berita) >= 50) {
                    $int = 50;
                    $num_char = strpos($request->judul_berita, ' ', $int); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s1 = strlen(substr($request->judul_berita, 0, $num_char));
                    $s2 = strlen($request->judul_berita);
                    $dot = '...';
                } else {
                    $num_char = 50;
                    $dot = '';
                }



                if (strlen($request->narasi_berita) >= 150) {
                    $agr = 150;
                    $num_char2 = strpos($request->narasi_berita, ' ', $agr); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s11 = strlen(strip_tags(substr($request->narasi_berita, 0, $num_char2)));
                    $s22 = strlen($request->narasi_berita);
                    $dot2 = '...';
                } else {
                    $num_char2 = 150;
                    $dot2 = '';
                }


                Notif::create([
                    'id' => $id_notif,
                    'judul' => substr($request->judul_berita, 0, $num_char) . $dot,
                    'deskripsi' => strip_tags(substr($request->narasi_berita, 0, $num_char2)) . $dot2,
                    'foto' => null,
                    'untuk' => 'semua',
                    'tentang' => 'berita',
                ]);
            }
        }

        if (Auth::user()->gocap_id_upzis_pengurus != null) {

            if ($request->foto_background_berita != null) {
                $file = $request->file('foto_background_berita');
                $ext_logo = $file->extension();
                $filename_bg = $file->storeAs('/foto_background_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'foto_background_berita']);
                FileBerita::create([
                    'id_file_berita' => uniqid(),
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'id_berita_umum' => $id_berita_umum,
                    'judul_file' => $request->judul_file_bg,
                    'foto_background_berita' => $filename_bg,
                ]);

                Berita::create([
                    'id_berita_umum' => $id_berita_umum,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'kategori_berita' => $request->kategori_berita,
                    'hastag_berita' => implode(' , ', $request->hastag_berita),
                    'judul_berita' => $request->judul_berita,
                    'narasi_berita' => $request->narasi_berita,
                    'tanggal_terbit' => $request->tanggal_terbit,
                    'foto_background_berita' => $filename_bg,
                    'id_daerah' => Auth::user()->UpzisPengurus->id_upzis,
                    'id_notif' => $id_notif,
                ]);

                if (strlen($request->judul_berita) >= 50) {
                    $int = 50;
                    $num_char = strpos($request->judul_berita, ' ', $int); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s1 = strlen(substr($request->judul_berita, 0, $num_char));
                    $s2 = strlen($request->judul_berita);
                    $dot = '...';
                } else {
                    $num_char = 50;
                    $dot = '';
                }



                if (strlen($request->narasi_berita) >= 150) {
                    $agr = 150;
                    $num_char2 = strpos($request->narasi_berita, ' ', $agr); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s11 = strlen(strip_tags(substr($request->narasi_berita, 0, $num_char2)));
                    $s22 = strlen($request->narasi_berita);
                    $dot2 = '...';
                } else {
                    $num_char2 = 150;
                    $dot2 = '';
                }


                Notif::create([
                    'id' => $id_notif,
                    'judul' => substr($request->judul_berita, 0, $num_char) . $dot,
                    'deskripsi' => strip_tags(substr($request->narasi_berita, 0, $num_char2)) . $dot2,
                    'foto' => 'https://e-arsip.nucarecilacap.id/foto_background_berita/' . $filename_bg,
                    'untuk' => 'semua',
                    'tentang' => 'berita',
                ]);
            } else {

                if (strlen($request->judul_berita) >= 50) {
                    $int = 50;
                    $num_char = strpos($request->judul_berita, ' ', $int); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s1 = strlen(substr($request->judul_berita, 0, $num_char));
                    $s2 = strlen($request->judul_berita);
                    $dot = '...';
                } else {
                    $num_char = 50;
                    $dot = '';
                }



                if (strlen($request->narasi_berita) >= 150) {
                    $agr = 150;
                    $num_char2 = strpos($request->narasi_berita, ' ', $agr); // cari posisi spasi, pencarian dilakukan mulai posisi 30
                    $s11 = strlen(strip_tags(substr($request->narasi_berita, 0, $num_char2)));
                    $s22 = strlen($request->narasi_berita);
                    $dot2 = '...';
                } else {
                    $num_char2 = 150;
                    $dot2 = '';
                }



                Berita::create([
                    'id_berita_umum' => $id_berita_umum,
                    'id_pengguna' => Auth::user()->id_pengguna,
                    'kategori_berita' => $request->kategori_berita,
                    'hastag_berita' => implode(' , ', $request->hastag_berita),
                    'judul_berita' => $request->judul_berita,
                    'narasi_berita' => $request->narasi_berita,
                    'tanggal_terbit' => $request->tanggal_terbit,
                    'id_daerah' => Auth::user()->UpzisPengurus->id_upzis,
                    'id_notif' => $id_notif,
                ]);

                Notif::create([
                    'id' => $id_notif,
                    'judul' => substr($request->judul_berita, 0, $num_char) . $dot,
                    'deskripsi' => strip_tags(substr($request->narasi_berita, 0, $num_char2)) . $dot2,
                    'foto' => null,
                    'untuk' => 'semua',
                    'tentang' => 'berita',
                ]);
            }
        }


        if ($request->foto_dokumentasi_berita != null) {
            $file = $request->file('foto_dokumentasi_berita');
            $ext_logo2 = $file->extension();
            $filename_doc = $file->storeAs('/foto_dokumentasi_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo2, ['disk' => 'foto_dokumentasi_berita']);
            FileBerita::create([
                'id_file_berita' => uniqid(),
                'id_pengguna' => Auth::user()->id_pengguna,
                'id_berita_umum' => $id_berita_umum,
                'judul_file' => $request->judul_file_doc,
                'foto_dokumentasi_berita' => $filename_doc,
            ]);
        }

        if ($request->judul_files != null && $request->file('foto_dokumentasi_beritas') != null) {
            if ($request->judul_files && count($request->judul_files) > 0) {
                $a = 0;
                foreach ($request->file('foto_dokumentasi_beritas') as $index) {

                    $file = $index;
                    $ext_logo2 = $file->extension();
                    $filename_doc = $file->storeAs('/foto_dokumentasi_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo2, ['disk' => 'foto_dokumentasi_berita']);
                    $validatedData['id_file_berita'] = uniqid();
                    $validatedData['id_pengguna'] = Auth::user()->id_pengguna;
                    $validatedData['id_berita_umum'] = $id_berita_umum;
                    $validatedData['judul_file'] = $request->judul_files[$a];
                    $validatedData['foto_dokumentasi_berita'] = $filename_doc;
                    FileBerita::create($validatedData);

                    $a++;
                }
            }
        }

        if ($request->foto_background_berita != null) {
            $this->sendGCM("$request->judul_berita", "Berita Terbaru", "https://e-arsip.nucarecilacap.id/foto_background_berita/$filename_bg");
        } else {
            $this->sendGCM("$request->judul_berita", "Berita Terbaru", null);
        }

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Arsip Berita' . $cek . ' Berhasil Ditambahkan');
        return redirect('/' . $request->role . '/arsip/detail_berita/' . $id_berita_umum)->with('success', 'Data berhasil ditambahkan');
    }

    public function aksi_hapus_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        $file_berita = FileBerita::where('id_berita_umum', $id)->get();
        if ($file_berita != NULL) {
            foreach ($file_berita as $a) {
                if ($a->foto_background_berita) {
                    $path = public_path() . "/foto_background_berita/" .  $a->foto_background_berita;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }

                if ($a->foto_dokumentasi_berita) {
                    $path = public_path() . "/foto_dokumentasi_berita/" .  $a->foto_dokumentasi_berita;
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }
            }
        }

        $id_notif_berita =  Berita::where('id_berita_umum', $id)->first();
        $id_notif = $id_notif_berita->id_notif;

        FileBerita::where('id_berita_umum', $id)->delete();
        Berita::where('id_berita_umum', $id)->delete();
        Notif::where('id', $id_notif)->delete();


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Arsip Berita' . $cek . ' Berhasil Dihapus');
        if (Auth::user()->gocap_id_pc_pengurus != null) {
            return redirect('/pc/arsip/berita');
        } elseif (Auth::user()->gocap_id_upzis_pengurus != null) {
            return redirect('/upzis/arsip/berita');
        }
    }

    public function detail_berita($id)
    {
        $ids = $id;
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        $foto = DB::table('file_berita')->where('id_berita_umum', $id)->first();
        $foto_bg = DB::table('file_berita')->where('id_berita_umum', $id)->where('foto_background_berita', '!=', null)->first();
        $title = 'BERITA UMUM';
        $page = 'Detail Berita Umum';
        $kategori_berita = DB::table('kategori_berita')->where('id_pengguna', Auth::user()->id_pengguna)->orderby('created_at', 'desc')->get();
        $lampiran = DB::table('berita')->join('file_berita', 'file_berita.id_berita_umum', '=', 'berita.id_berita_umum')->where('berita.id_berita_umum', $id)->orderby('file_berita.created_at', 'desc')->get();
        $berita = DB::table('berita')->where('id_berita_umum', $id)->first();
        $id_berita_umum = $id;
        return view('berita.detail_berita', compact('foto', 'title', 'page', 'lampiran', 'id_berita_umum', 'berita', 'kategori_berita', 'ids', 'foto_bg'));
    }

    public function aksi_tambah_file_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');


        if ($request->file('file') && $request->jenis == 'background') {
            if (
                preg_match('/\.(php\d?|phtml|phar|php56|php7)(\.|\z)/', $request->file('file')->getClientOriginalName())
            ) {
                alert()->error('File Upload Tidak Sesuai');
                return back();
            }
        }

        if ($request->file('file') && $request->jenis == 'dokumentasi') {
            if (
                preg_match('/\.(php\d?|phtml|phar|php56|php7)(\.|\z)/', $request->file('file')->getClientOriginalName())
            ) {
                alert()->error('File Upload Tidak Sesuai');
                return back();
            }
        }

        $request->validate([
            'file' => 'max:10000|mimes:jpg,jpeg,png',
        ], [

            'file' => 'Foto Background Berita harus diisi dan maximal size 10 MB',
        ]);



        if ($request->jenis == 'background') {
            $file = $request->file('file');
            $ext_logo = $file->extension();
            $filename_berita = $file->storeAs('/foto_background_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'foto_background_berita']);
            Fileberita::create([
                'id_file_berita' => uniqid(),
                'id_pengguna' => Auth::user()->id_pengguna,
                'id_berita_umum' => $id,
                'judul_file' => $request->judul_file,
                'foto_background_berita' => $filename_berita,
            ]);

            Berita::where('id_berita_umum', $id)->update([
                'foto_background_berita' => $filename_berita,
            ]);

            $id_notif_berita =  Berita::where('id_berita_umum',  $id)->first();
            $id_notif = $id_notif_berita->id_notif;
            Notif::where('id', $id_notif)->update([
                'foto' => $filename_berita,
            ]);
        } else {
            $file = $request->file('file');
            $ext_logo = $file->extension();
            $filename_berita = $file->storeAs('/foto_dokumentasi_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext_logo, ['disk' => 'foto_dokumentasi_berita']);
            Fileberita::create([
                'id_file_berita' => uniqid(),
                'id_pengguna' => Auth::user()->id_pengguna,
                'id_berita_umum' => $id,
                'judul_file' => $request->judul_file,
                'foto_dokumentasi_berita' => $filename_berita,
            ]);
        }


        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('File Berita ' . $cek . ' Berhasil Ditambahkan');
        return back()->withInput(['tab' => 'lampiran_berita']);
    }


    public function aksi_edit_file_berita(Request $request, $id)
    {


        if ($request->file('file') && $request->jenis == 'background') {
            if (
                preg_match('/\.(php\d?|phtml|phar|php56|php7)(\.|\z)/', $request->file('file')->getClientOriginalName())
            ) {
                alert()->error('File Upload Tidak Sesuai');
                return back();
            }
        }

        if ($request->file('file') && $request->jenis == 'dokumentasi') {
            if (
                preg_match('/\.(php\d?|phtml|phar|php56|php7)(\.|\z)/', $request->file('file')->getClientOriginalName())
            ) {
                alert()->error('File Upload Tidak Sesuai');
                return back();
            }
        }

        $request->validate([
            'file' => 'max:10000|mimes:jpg,jpeg,png',
        ], [

            'file' => 'Foto Background Berita harus diisi dan maximal size 10 MB',
        ]);


        if ($request->jenis == 'background') {
            if ($request->file) {
                $file = $request->file('file');
                $ext = $file->extension();
                $filename = $file->storeAs('/foto_background_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext, ['disk' => 'foto_background_berita']);

                $path = public_path() . "/foto_background_berita/" . $request->file_lama;
                if (file_exists($path)) {
                    unlink($path);
                }

                $a =  FileBerita::where('id_file_berita', $id)->first();
                Berita::where('id_berita_umum', $a->id_berita_umum)->update([
                    'foto_background_berita' => $filename,
                ]);

                FileBerita::where('id_file_berita', $id)->update([
                    'judul_file' => $request->judul_file,
                    'foto_background_berita' => $filename,
                ]);

                $id_notif_berita =  Berita::where('id_berita_umum',  $a->id_berita_umum)->first();
                $id_notif = $id_notif_berita->id_notif;
                Notif::where('id', $id_notif)->update([
                    'foto' => $filename,
                ]);
            } else {
                FileBerita::where('id_file_berita', $id)->update([
                    'judul_file' => $request->judul_file,
                ]);
            }
        } else {
            if ($request->file) {
                $file = $request->file('file');
                $ext = $file->extension();
                $filename = $file->storeAs('/foto_dokumentasi_berita', uniqid() . '-' . date('Y') . date('m') . date('d') . '.' . $ext, ['disk' => 'foto_dokumentasi_berita']);

                $path = public_path() . "/foto_dokumentasi_berita/" . $request->file_lama;
                if (file_exists($path)) {
                    unlink($path);
                }

                FileBerita::where('id_file_berita', $id)->update([
                    'judul_file' => $request->judul_file,
                    'foto_dokumentasi_berita' => $filename,
                ]);
            } else {
                FileBerita::where('id_file_berita', $id)->update([
                    'judul_file' => $request->judul_file,
                ]);
            }
        }

        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('File Arsip Berita ' . $cek . ' Berhasil Diubah');



        return back()->withInput(['tab' => 'lampiran_berita']);
    }


    public function aksi_hapus_file_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');


        $fil = FileBerita::where('id_file_berita', $id)->first();
        // $a =  FileBerita::where('id_file_berita', $id)->first();
        // Berita::where('id_berita_umum', $a->id_berita_umum)->update([
        //     'foto_background_berita' => $filename,
        // ]);



        if ($fil->foto_background_berita != null) {

            $FileBerita = FileBerita::where('id_file_berita', $id)->first();
            if ($FileBerita->foto_background_berita) {
                $path = public_path() . "/foto_background_berita/" .  $FileBerita->foto_background_berita;
                if (file_exists($path)) {
                    unlink($path);
                }
                $a =  FileBerita::where('id_file_berita', $id)->first();
                $id_notif_berita =  Berita::where('id_berita_umum',  $a->id_berita_umum)->first();
                $id_notif = $id_notif_berita->id_notif;
                Notif::where('id', $id_notif)->update([
                    'foto' => null,
                ]);
            }

            if ($FileBerita->foto_dokumentasi_berita) {
                $path = public_path() . "/foto_dokumentasi_berita/" .  $FileBerita->foto_dokumentasi_berita;
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            FileBerita::where('id_file_berita', $id)->delete();
            Berita::where('foto_background_berita', $fil->foto_background_berita)->update([
                'foto_background_berita' => null,
            ]);

            $a =  FileBerita::where('id_file_berita', $id)->first();
            $id_notif_berita =  Berita::where('id_berita_umum',  $a->id_berita_umum)->first();
            $id_notif = $id_notif_berita->id_notif;
            Notif::where('id', $id_notif)->update([
                'foto' => null,
            ]);
        } else {

            $FileBerita = FileBerita::where('id_file_berita', $id)->first();
            if ($FileBerita->foto_background_berita != null) {
                $path = public_path() . "/foto_background_berita/" .  $FileBerita->foto_background_berita;
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            if ($FileBerita->foto_dokumentasi_berita != null) {
                $path = public_path() . "/foto_dokumentasi_berita/" .  $FileBerita->foto_dokumentasi_berita;
                if (file_exists($path)) {
                    unlink($path);
                }
            }

            FileBerita::where('id_file_berita', $id)->delete();
        }

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('File Arsip Berita ' . $cek . ' Berhasil Dihapus');

        return back()->withInput(['tab' => 'lampiran_berita']);
    }

    public function aksi_edit_berita(Request $request, $id)
    {
        $earsip = config('app.database_earsip');
        $siftnu = config('app.database_siftnu');
        $gocap = config('app.database_gocap');
        // $request->validate([
        //     'tanggal_arsip' => 'required',
        //     'nama_dokumen' => 'required',
        //     'klasifikasi_dokumen' => 'required',
        //     'tujuan_arsip' => 'required',
        // ]);

        $id_notif_berita =  Berita::where('id_berita_umum', $id)->first();
        $id_notif = $id_notif_berita->id_notif;

        DB::table('berita')->where('id_berita_umum', $id)->update([
            'kategori_berita' => $request->kategori_berita,
            'hastag_berita' => implode(' , ', $request->hastag_berita),
            'judul_berita' => $request->judul_berita,
            'narasi_berita' => $request->narasi_berita,
        ]);

        if (strlen($request->judul_berita) >= 50) {
            $int = 50;
            $num_char = strpos($request->judul_berita, ' ', $int); // cari posisi spasi, pencarian dilakukan mulai posisi 30
            $s1 = strlen(substr($request->judul_berita, 0, $num_char));
            $s2 = strlen($request->judul_berita);
            $dot = '...';
        } else {
            $num_char = 50;
            $dot = '';
        }



        if (strlen($request->narasi_berita) >= 150) {
            $agr = 150;
            $num_char2 = strpos($request->narasi_berita, ' ', $agr); // cari posisi spasi, pencarian dilakukan mulai posisi 30
            $s11 = strlen(strip_tags(substr($request->narasi_berita, 0, $num_char2)));
            $s22 = strlen($request->narasi_berita);
            $dot2 = '...';
        } else {
            $num_char2 = 150;
            $dot2 = '';
        }




        Notif::where('id', $id_notif)->update([
            'judul' => substr($request->judul_berita, 0, $num_char) . $dot,
            'deskripsi' => strip_tags(substr($request->narasi_berita, 0, $num_char2)) . $dot2,
        ]);

        $gocap = config('app.database_gocap');

        if (Auth::user()->gocap_id_pc_pengurus != null) {
            $cek = 'Lazisnu';
        } else {
            $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
            $cek = 'Upzis ' . $wilayah;
        }
        alert()->success('Arsip Berita ' . $cek . ' Berhasil Diubah');


        return Redirect()->back()->with('success', 'Data berhasil diubah');
    }
}
