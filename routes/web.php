<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DataAsetController;
use App\Http\Controllers\DetailPemeriksaanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermohonanController;
use App\Http\Controllers\PenerimaController;
use App\Http\Controllers\AsetController;
use App\Http\Controllers\NotulenController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ArsipDigitalController;
use App\Http\Controllers\FilterAsetController;
use App\Http\Controllers\FilterDokumenController;
use App\Http\Controllers\FilterMemoController;
use App\Http\Controllers\BeritaUmumController;
use App\Http\Controllers\DokumenDigitalController;
use App\Http\Controllers\FilterBeritaController;
use App\Http\Controllers\FilterDataAsetController;
use App\Http\Controllers\FilterKegiatanController;
use App\Http\Controllers\FilterSuratMasukController;
use App\Http\Controllers\FilterSuratKeluarController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PrintDisposisiSuratMasukController;
use App\Models\PenerimaSurat;

// landing page
Route::get('/lazisnu', function () {
    return view('landing.index');
});

Route::get('/generate-wordpress-berita/{id}', [BeritaUmumController::class, 'generate_wp_posts'])->name('wp.posts');
// Route::get('/getContent', [BeritaUmumController::class, 'getContent'])->name('getContent');

// login
Route::middleware('guest')->group(function () {
    // Route::get('/', function () {
    //     return redirect()->away('https://siftnu.nucarecilacap.id/login');
    // })->name('login');
    Route::get('/', function () {
        return view('login.login');
    })->name('login');
    Route::post('/login_ver', [LoginController::class, 'verifikasi'])->name('login.action');
});
Route::get('/home', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {

    // PC
    Route::prefix('pc')->name('pc.')->middleware('pc')->group(function () {

        //DASHBOARD
        Route::get('/dashboard', [DashboardController::class, 'index']);

        //ASET DIGITAL
        // Route::get('/aset_umum', [AsetController::class, 'aset_umum']);
        // Route::get('/aset_wakaf', [AsetController::class, 'aset_wakaf']);
        // Route::get('/tambah_aset/{link}', [AsetController::class, 'tambah_aset'])->name('tambah_aset');
        // Route::post('/aksi_tambah_aset/{link}', [AsetController::class, 'aksi_tambah_aset'])->name('aksi_tambah_aset');
        // Route::post('/aksi_hapus_aset/{id}', [AsetController::class, 'aksi_hapus_aset'])->name('aksi_hapus_aset');
        // Route::get('/detail_aset/{link}/{id}', [AsetController::class, 'detail_aset'])->name('detail_aset');
        // Route::put('/aksi_edit_aset/{id}', [AsetController::class, 'aksi_edit_aset'])->name('aksi_edit_aset');

        //KATEGORI ASET
        Route::get('/kategori_aset', [AsetController::class, 'kategori_aset'])->name('kategori_aset');
        Route::post('/aksi_tambah_kategori_aset', [AsetController::class, 'aksi_tambah_kategori_aset'])->name('aksi_tambah_kategori_aset');
        Route::put('/aksi_edit_kategori_aset/{id}', [AsetController::class, 'aksi_edit_kategori_aset'])->name('aksi_edit_kategori_aset');
        Route::post('/aksi_hapus_kategori_aset/{id}', [AsetController::class, 'aksi_hapus_kategori_aset'])->name('aksi_hapus_kategori_aset');

        //CRUD FILE ASET
        Route::post('/aksi_tambah_file_aset/{id}', [AsetController::class, 'aksi_tambah_file_aset'])->name('aksi_tambah_file_aset');
        Route::post('/aksi_hapus_file_aset/{id}', [AsetController::class, 'aksi_hapus_file_aset'])->name('aksi_hapus_file_aset');
        Route::post('/aksi_edit_file_aset/{id}', [AsetController::class, 'aksi_edit_file_aset'])->name('aksi_edit_file_aset');

        //FILTER DAN PRINT ASET
        Route::post('/filter/aset', [FilterAsetController::class, 'filter_aset'])->name('filter_aset');
        Route::post('/cetak_pdf_aset/{link}', [FilterAsetController::class, 'cetak_pdf_aset'])->name('cetak_pdf_aset');

        //DOKUMEN DIGITAL
        Route::get('/arsip/dokumen_digital_pc2/{id}', [DokumenDigitalController::class, 'dokumen_digital_pc2'])->name('dokumen_digital_pc2');
        Route::get('/arsip/dokumen_digital_pc/{id}', [DokumenDigitalController::class, 'dokumen_digital_pc'])->name('dokumen_digital_pc');
        Route::get('/arsip/tambah_dokumen_digital/{hal}', [DokumenDigitalController::class, 'tambah_dokumen_digital'])->name('tambah_dokumen_digital');
        Route::post('/arsip/hapus_dokumen_digital/{id}', [DokumenDigitalController::class, 'hapus_dokumen_digital'])->name('hapus_dokumen_digital');
        Route::post('/filter/dokumen/{part}/{hal}', [FilterDokumenController::class, 'filter_dokumen'])->name('filter_dokumen');
        Route::get('/arsip/detail_dokumen_digital/{id}/{hal}', [DokumenDigitalController::class, 'detail_dokumen_digital'])->name('detail_dokumen_digital');
        Route::put('/arsip/aksi_edit_dokumen_digital/{id}', [DokumenDigitalController::class, 'aksi_edit_dokumen_digital'])->name('aksi_edit_dokumen_digital');
        Route::post('/arsip/aksi_tambah_dokumen_digital', [DokumenDigitalController::class, 'aksi_tambah_dokumen_digital'])->name('aksi_tambah_dokumen_digital');

        //dokumen klasifikasi jenis
        Route::get('/klasifikasi_dokumen/jenis_klasifikasi_dokumen/{hal}', [DokumenDigitalController::class, 'jenis_klasifikasi_dokumen'])->name('jenis_klasifikasi_dokumen');
        Route::post('/aksi_tambah_jenis_klasifikasi_dokumen/', [DokumenDigitalController::class, 'aksi_tambah_jenis_klasifikasi_dokumen'])->name('aksi_tambah_jenis_klasifikasi_dokumen');
        Route::put('/aksi_edit_jenis_klasifikasi_dokumen/{id}', [DokumenDigitalController::class, 'aksi_edit_jenis_klasifikasi_dokumen'])->name('aksi_edit_jenis_klasifikasi_dokumen');
        Route::post('/aksi_hapus_jenis_klasifikasi_dokumen/{id}', [DokumenDigitalController::class, 'aksi_hapus_jenis_klasifikasi_dokumen'])->name('aksi_hapus_jenis_klasifikasi_dokumen');


        //FILE LAMPIRAN ARSIP
        Route::post('/arsip/aksi_edit_lampiran/{id}', [ArsipDigitalController::class, 'aksi_edit_lampiran'])->name('aksi_edit_lampiran');
        Route::post('/arsip/aksi_tambah_lampiran', [ArsipDigitalController::class, 'aksi_tambah_lampiran'])->name('aksi_tambah_lampiran');
        Route::post('/arsip/aksi_hapus_lampiran/{id}', [ArsipDigitalController::class, 'aksi_hapus_lampiran'])->name('aksi_hapus_lampiran');


        //SURAT MASUK
        Route::post('/filter/surat_masuk/{part}/{hal}', [FilterSuratMasukController::class, 'filter_surat_masuk'])->name('filter_surat_masuk');
        Route::get('/arsip/surat_masuk_pc2/{id}', [ArsipDigitalController::class, 'surat_masuk_pc2'])->name('surat_masuk_pc2');
        Route::get('/arsip/surat_masuk_pc/{id}', [ArsipDigitalController::class, 'surat_masuk_pc'])->name('surat_masuk_pc');
        Route::get('/arsip/surat_masuk_upzis/{id}', [ArsipDigitalController::class, 'surat_masuk_upzis'])->name('surat_masuk_upzis');
        Route::get('/arsip/surat_masuk_ranting/{id}', [ArsipDigitalController::class, 'surat_masuk_ranting']);
        Route::get('/arsip/tambah_surat_masuk/{hal}', [ArsipDigitalController::class, 'tambah_surat_masuk'])->name('tambah_surat_masuk');
        Route::post('/aksi_tambah_surat_masuk', [ArsipDigitalController::class, 'aksi_tambah_surat_masuk'])->name('aksi_tambah_surat_masuk');
        Route::get('/arsip/detail_surat_masuk/{id}/{hal}', [ArsipDigitalController::class, 'detail_surat_masuk'])->name('detail_surat_masuk');
        Route::put('/arsip/proses_edit_surat_masuk/{id}', [ArsipDigitalController::class, 'proses_edit_surat_masuk'])->name('proses_edit_surat_masuk');
        Route::put('/arsip/proses_edit_disposisi/{id}', [ArsipDigitalController::class, 'proses_edit_disposisi'])->name('proses_edit_disposisi');
        Route::put('/arsip/proses_edit_sppd/{id}', [ArsipDigitalController::class, 'proses_edit_sppd'])->name('proses_edit_sppd');
        Route::post('/arsip/hapus_surat_masuk/{id}', [ArsipDigitalController::class, 'hapus_surat_masuk'])->name('hapus_surat_masuk');
        Route::get('/arsip/print_disposisi_surat_masuk/{id}', [ArsipDigitalController::class, 'print_disposisi_arsip_surat_masuk'])->name('disposisi_surat_masuk');



        //SURAT KELUAR
        Route::post('/filter/surat_keluar/{part}/{hal}', [FilterSuratKeluarController::class, 'filter_surat_keluar'])->name('filter_surat_keluar');
        Route::get('/arsip/surat_keluar_pc2/{id}', [ArsipDigitalController::class, 'surat_keluar_pc2'])->name('surat_keluar_pc2');
        Route::get('/arsip/surat_keluar_pc/{id}', [ArsipDigitalController::class, 'surat_keluar_pc'])->name('surat_keluar_pc');

        Route::get('/arsip/tambah_surat_keluar/{hal}', [ArsipDigitalController::class, 'tambah_surat_keluar'])->name('tambah_surat_keluar');
        Route::get('/arsip/tambah_surat_keluar/baru/{hal}', [ArsipDigitalController::class, 'tambah_surat_keluar_baru'])->name('tambah_surat_keluar_baru');
        Route::get('/arsip/surat_keluar_pc/{id}', [ArsipDigitalController::class, 'surat_keluar_pc'])->name('surat_keluar_pc');
        Route::get('/arsip/surat_keluar_upzis/{id}', [ArsipDigitalController::class, 'surat_keluar_upzis'])->name('surat_keluar_upzis');
        Route::get('/arsip/surat_keluar_ranting/{id}', [ArsipDigitalController::class, 'surat_keluar_ranting'])->name('surat_keluar_ranting');
        Route::post('/aksi_tambah_surat_keluar', [ArsipDigitalController::class, 'aksi_tambah_surat_keluar'])->name('aksi_tambah_surat_keluar');
        Route::post('/aksi_tambah_surat_keluar_baru', [ArsipDigitalController::class, 'aksi_tambah_surat_keluar_baru'])->name('aksi_tambah_surat_keluar_baru');
        Route::get('/arsip/detail_surat_keluar/{id}/{hal}', [ArsipDigitalController::class, 'detail_surat_keluar'])->name('detail_surat_keluar');
        Route::put('/arsip/proses_edit_surat_keluar/{id}', [ArsipDigitalController::class, 'proses_edit_surat_keluar'])->name('proses_edit_surat_keluar');
        Route::post('/arsip/hapus_surat_keluar/{id}', [ArsipDigitalController::class, 'hapus_surat_keluar'])->name('hapus_surat_keluar');
        Route::get('/arsip/print_disposisi_surat_keluar/{id}', [ArsipDigitalController::class, 'print_disposisi_arsip_surat_keluar'])->name('disposisi_surat_masuk');

        Route::get('/arsip/jenis_arsip', [ArsipDigitalController::class, 'jenis_arsip'])->name('jenis_arsip');
        Route::post('/aksi_tambah_jenis_surat', [ArsipDigitalController::class, 'aksi_tambah_jenis_surat'])->name('aksi_tambah_jenis_surat');
        Route::get('/aksi_hapus_jenis_surat/{id}', [ArsipDigitalController::class, 'aksi_hapus_jenis_surat'])->name('aksi_hapus_jenis_surat');
        Route::put('/aksi_edit_jenis_arsip/{id}', [ArsipDigitalController::class, 'aksi_edit_jenis_arsip'])->name('aksi_edit_jenis_arsip');

        //Preview dan Print Disposisi
        Route::post('/arsip/preview_disposisi', [ArsipDigitalController::class, 'preview_disposisi'])->name('preview_disposisi');
        Route::get('/arsip/print_disposisi/{id}', [ArsipDigitalController::class, 'print_disposisi'])->name('print_disposisi');
        Route::get('/arsip/print_surat/{id}', [ArsipDigitalController::class, 'print_surat'])->name('print_surat');
        Route::get('/arsip/print_surat_upzis/{id}', [ArsipDigitalController::class, 'print_surat_upzis'])->name('print_surat_upzis');


        //Berita
        // sini

        Route::get('/arsip/berita', [BeritaUmumController::class, 'berita'])->name('berita');
        Route::get('/arsip/kategori_berita', [BeritaUmumController::class, 'kategori_berita'])->name('kategori_berita');
        Route::get('/arsip/tambah_berita', [BeritaUmumController::class, 'tambah_berita'])->name('tambah_berita');
        Route::post('/aksi_tambah_kategori_berita', [BeritaUmumController::class, 'aksi_tambah_kategori_berita'])->name('aksi_tambah_kategori_berita');
        Route::put('/aksi_edit_kategori_berita/{id}', [BeritaUmumController::class, 'aksi_edit_kategori_berita'])->name('aksi_edit_kategori_berita');
        Route::post('/aksi_hapus_kategori_berita/{id}', [BeritaUmumController::class, 'aksi_hapus_kategori_berita'])->name('aksi_hapus_kategori_berita');
        Route::post('/aksi_tambah_berita', [BeritaUmumController::class, 'aksi_tambah_berita'])->name('aksi_tambah_berita');
        Route::post('/aksi_hapus_berita/{id}', [BeritaUmumController::class, 'aksi_hapus_berita'])->name('aksi_hapus_berita');
        Route::get('/arsip/detail_berita/{id}', [BeritaUmumController::class, 'detail_berita'])->name('detail_berita');
        Route::put('/arsip/aksi_edit_berita/{id}', [BeritaUmumController::class, 'aksi_edit_berita'])->name('aksi_edit_berita');
        Route::post('/filter/berita', [FilterBeritaController::class, 'filter_berita'])->name('filter_berita');

        //FILE BERITA
        Route::post('/arsip/aksi_edit_file_berita/{id}', [BeritaUmumController::class, 'aksi_edit_file_berita'])->name('aksi_edit_file_berita');
        Route::post('/arsip/aksi_tambah_file_berita/{id}', [BeritaUmumController::class, 'aksi_tambah_file_berita'])->name('aksi_tambah_file_berita');
        Route::post('/arsip/aksi_hapus_file_berita/{id}', [BeritaUmumController::class, 'aksi_hapus_file_berita'])->name('aksi_hapus_file_berita');

        //MEMO
        Route::post('/kirim_notifikasi_memo', [MemoController::class, 'kirim_notifikasi_memo'])->name('kirim_notifikasi_memo');
        Route::get('/arsip/memo', [MemoController::class, 'memo'])->name('memo');
        Route::get('/arsip/tambah_memo', [MemoController::class, 'tambah_memo'])->name('tambah_memo');
        Route::post('/aksi_tambah_memo', [MemoController::class, 'aksi_tambah_memo'])->name('aksi_tambah_memo');
        Route::post('/aksi_hapus_memo/{id}', [MemoController::class, 'aksi_hapus_memo'])->name('aksi_hapus_memo');
        Route::get('/detail_memo/{id}', [MemoController::class, 'detail_memo'])->name('detail_memo');
        Route::put('/arsip/aksi_edit_memo/{id}', [MemoController::class, 'aksi_edit_memo'])->name('aksi_edit_memo');
        Route::post('/filter/memo', [FilterMemoController::class, 'filter_memo'])->name('filter_memo');
        Route::get('/arsip/memo/{id}', [MemoController::class, 'print_memo'])->name('print_memo');

        //FILE MEMO
        Route::post('/arsip/aksi_edit_file_memo/{id}', [MemoController::class, 'aksi_edit_file_memo'])->name('aksi_edit_file_memo');
        Route::post('/arsip/aksi_tambah_file_memo/{id}', [MemoController::class, 'aksi_tambah_file_memo'])->name('aksi_tambah_file_memo');
        Route::post('/arsip/aksi_hapus_file_memo/{id}', [MemoController::class, 'aksi_hapus_file_memo'])->name('aksi_hapus_file_memo');

        //Penerima Surat
        Route::post('/aksi_hapus_penerima_surat/{id}', [ArsipDigitalController::class, 'aksi_hapus_penerima_surat'])->name('aksi_hapus_penerima_surat');
        Route::post('/aksi_tambah_penerima_surat', [ArsipDigitalController::class, 'aksi_tambah_penerima_surat'])->name('aksi_tambah_penerima_surat');

        //Kegiatan
        Route::post('/aksi_tambah_kegiatan/', [KegiatanController::class, 'aksi_tambah_kegiatan'])->name('aksi_tambah_kegiatan');
        Route::post('/aksi_hapus_kegiatan/{id}', [KegiatanController::class, 'aksi_hapus_kegiatan'])->name('aksi_hapus_kegiatan');
        Route::get('/arsip/detail_kegiatan/{id}/{hal}', [KegiatanController::class, 'detail_kegiatan'])->name('detail_kegiatan');
        Route::post('/aksi_edit_kegiatan/{id}', [KegiatanController::class, 'aksi_edit_kegiatan'])->name('aksi_edit_kegiatan');

        Route::post('/aksi_tambah_file_kegiatan/', [KegiatanController::class, 'aksi_tambah_file_kegiatan'])->name('aksi_tambah_file_kegiatan');
        Route::post('/aksi_edit_file_kegiatan/{id}', [KegiatanController::class, 'aksi_edit_file_kegiatan'])->name('aksi_edit_file_kegiatan');
        Route::post('/aksi_hapus_file_kegiatan/{id}', [KegiatanController::class, 'aksi_hapus_file_kegiatan'])->name('aksi_hapus_file_kegiatan');

        Route::get('/arsip/kegiatan_pc/{hal}', [KegiatanController::class, 'kegiatan_pc'])->name('kegiatan_pc');
        Route::get('/kegiatan/jenis_kegiatan/{hal}', [KegiatanController::class, 'jenis_kegiatan'])->name('jenis_kegiatan');
        Route::post('/aksi_tambah_jenis_kegiatan', [KegiatanController::class, 'aksi_tambah_jenis_kegiatan'])->name('aksi_tambah_jenis_kegiatan');
        Route::put('/aksi_edit_jenis_kegiatan/{id}', [KegiatanController::class, 'aksi_edit_jenis_kegiatan'])->name('aksi_edit_jenis_kegiatan');
        Route::post('/aksi_hapus_jenis_kegiatan/{id}', [KegiatanController::class, 'aksi_hapus_jenis_kegiatan'])->name('aksi_hapus_jenis_kegiatan');
        Route::post('/filter/kegiatan/{hal}', [FilterKegiatanController::class, 'filter_kegiatan'])->name('filter_kegiatan');

        //notulen kegiatan
        Route::get('/arsip/notulen_kegiatan/{id}/{hal}', [NotulenController::class, 'notulen_kegiatan'])->name('notulen_kegiatan');
        Route::get('/print_notulen/{id}', [NotulenController::class, 'print_notulen'])->name('print_notulen');
        Route::post('/aksi_tambah_notulen/{id_kegiatan}', [NotulenController::class, 'aksi_tambah_notulen'])->name('aksi_tambah_notulen');
        Route::post('/aksi_hapus_notulen/{id}', [NotulenController::class, 'aksi_hapus_notulen'])->name('aksi_hapus_notulen');
        Route::post('/aksi_ubah_kehadiran/{id_kegiatan}', [NotulenController::class, 'aksi_ubah_kehadiran'])->name('aksi_ubah_kehadiran');
        Route::post('/aksi_edit_notulen/{id_kegiatan}/{notulen_id}', [NotulenController::class, 'aksi_edit_notulen'])->name('aksi_edit_notulen');

        //data aset
        Route::get('/arsip/aset/data', [DataAsetController::class, 'data'])->name('data_aset');
        //::get('/arsip/aset/filterAset', [FilterDataAsetController::class, 'filter_data_aset'])->name('filter_aset');
        Route::post('/aset/data/tambah', [DataAsetController::class, 'store_data'])->name('aset.store');
        Route::get('/aset/data/{id}', [DataAsetController::class, 'getDataAset']);
        //Route::post('/check-date', [DataAsetController::class, 'checkDate_Pemeriksaan'])->name('check-date');
        Route::post('/aset/data/update/{id}', [DataAsetController::class, 'update_data'])->name('aset.update');
        Route::post('/aset/data/delete/{id}', [DataAsetController::class, 'delete_data'])->name('aset.delete');

        Route::get('/arsip/aset/detail/{id}', [DataAsetController::class, 'detail_aset'])->name('detail_aset');
        route::post('/arsip/aset/tambah_kontrol', [DataAsetController::class, 'store_kontrol'])->name('kontrol.store');
        Route::get('/print-keluar', [DataAsetController::class, 'printKeluar'])->name('printKeluar');
        Route::get('/aset/next-kode-aset', [DataAsetController::class, 'getNextKodeAset'])->name('aset.nextKodeAset');
        Route::post('/kategori/store', [DataAsetController::class, 'store_kategori'])->name('kategori.store');
        Route::post('/filter/aset', [DataAsetController::class, 'FilterAset'])->name('filter_aset');
        Route::get('/print-aset', [DataAsetController::class, 'export_aset'])->name('export-aset');
        Route::get('/print-detail-pemeriksaan-aset/{id}', [DataAsetController::class, 'exportDetailPemeriksaanByAset'])->name('export-detail-aset');

        Route::post('/pemeriksaan/store', [DataAsetController::class, 'store_pemeriksaan'])->name('pemeriksaan.store');
        Route::get('/arsip/aset/detail_pemeriksaan/{id}/{tgl}', [DataAsetController::class, 'detail_pemeriksaan'])->name('detail_pemeriksaan');
        Route::post('/detail_pemeriksaan/store/{id}', [DataAsetController::class, 'store_detail_pemeriksaan'])->name('detail_pemeriksaan.store');
        Route::post('/spv/update/{id}', [DataAsetController::class, 'update_respon_spv'])->name('respon_spv.update');
        Route::post('/kc/update/{id}', [DataAsetController::class, 'update_respon_kc'])->name('respon_kc.update');
        Route::post('/detail_pemeriksaan/update/', [DataAsetController::class, 'update_detail_pemeriksaan'])->name('detail_pemeriksaan.update');
        Route::delete('/delete-detail-pemeriksaan/{id}', [DataAsetController::class, 'delete_detail_pemeriksaan'])->name('delete_detail_pemeriksaan');
        Route::delete('/delete-pemeriksaan/{id}', [DataAsetController::class, 'delete_pemeriksaan'])->name('delete_pemeriksaan');
        Route::get('/detail-pemeriksaan/{id}', [DetailPemeriksaanController::class, 'getDetailPemeriksaan']);
        Route::post('/update-status-pemeriksaan', [DataAsetController::class, 'updateStatusPemeriksaan'])->name('updateStatusPemeriksaan');
        Route::get('/print-detail/{id}/{tgl}', [DataAsetController::class, 'exportPdfDetailPemeriksaan'])->name('exportPdfDetailPemeriksaan');
        Route::get('/print-data-pemeriksaan', [DataAsetController::class, 'export_pemeriksaan'])->name('exportPdfPemeriksaan');
        Route::get('/print-detail-keluar-masuk', [DataAsetController::class, 'export_detail_keluar_masuk_aset'])->name('exportPdfDetailKeluarMasuk');
        Route::get('/print-data-keluar-masuk', [DataAsetController::class, 'export_keluar_masuk_aset'])->name('exportPdfKeluarMasuk');


        Route::post('/arsip/keluar_masuk_aset/store', [DataAsetController::class, 'keluar_masuk_aset_store'])->name('keluar_masuk_aset.store');
        Route::get('/arsip/detail_keluar_masuk_aset/{id}', [DataAsetController::class, 'detail_keluar_masuk_aset'])->name('detail_keluar_masuk_aset');

        Route::post('/arsip/detail_keluar_masuk_aset/store/{id}', [DataAsetController::class, 'detail_keluar_masuk_aset_store'])->name('detail_keluar_masuk_aset.store');
        Route::put('/arsip/update_keluar_masuk_aset/{id}', [DataAsetController::class, 'keluar_masuk_aset_update'])->name('keluar_masuk_aset.update');
    });

    // upzis
    Route::prefix('upzis')->name('upzis.')->middleware('upzis')->group(function () {

        //dashboard
        Route::get('/dashboard', [DashboardController::class, 'index']);
        //aset
        Route::get('/aset_umum', [AsetController::class, 'aset_umum']);
        Route::get('/aset_wakaf', [AsetController::class, 'aset_wakaf']);
        //tambah aset
        Route::get('/tambah_aset/{link}', [AsetController::class, 'tambah_aset'])->name('tambah_aset');
        //kategori aset
        Route::get('/kategori_aset', [AsetController::class, 'kategori_aset'])->name('kategori_aset');
        //crud aset
        Route::post('/aksi_tambah_aset/{link}', [AsetController::class, 'aksi_tambah_aset'])->name('aksi_tambah_aset');
        Route::get('/aksi_hapus_aset/{id}', [AsetController::class, 'aksi_hapus_aset'])->name('aksi_hapus_aset');
        Route::get('/detail_aset/{link}/{id}', [AsetController::class, 'detail_aset'])->name('detail_aset');
        Route::put('/aksi_edit_aset/{id}', [AsetController::class, 'aksi_edit_aset'])->name('aksi_edit_aset');
        //crud kategori aset
        Route::post('/aksi_tambah_kategori_aset', [AsetController::class, 'aksi_tambah_kategori_aset'])->name('aksi_tambah_kategori_aset');
        Route::put('/aksi_edit_kategori_aset/{id}', [AsetController::class, 'aksi_edit_kategori_aset'])->name('aksi_edit_kategori_aset');
        Route::post('/aksi_hapus_kategori_aset/{id}', [AsetController::class, 'aksi_hapus_kategori_aset'])->name('aksi_hapus_kategori_aset');
        //crud file aset
        Route::post('/aksi_tambah_file_aset/{id}', [AsetController::class, 'aksi_tambah_file_aset'])->name('aksi_tambah_file_aset');
        Route::post('/aksi_hapus_file_aset/{id}', [AsetController::class, 'aksi_hapus_file_aset'])->name('aksi_hapus_file_aset');
        Route::post('/aksi_edit_file_aset/{id}', [AsetController::class, 'aksi_edit_file_aset'])->name('aksi_edit_file_aset');
        //Filter aset
        Route::post('/filter/aset', [FilterAsetController::class, 'filter_aset'])->name('filter_aset');
        Route::post('/cetak_pdf_aset/{link}', [FilterAsetController::class, 'cetak_pdf_aset'])->name('cetak_pdf_aset');

        //SURAT MASUK
        Route::post('/filter/surat_masuk/{part}/{hal}', [FilterSuratMasukController::class, 'filter_surat_masuk'])->name('filter_surat_masuk');
        Route::get('/arsip/surat_masuk_upzis2/{id}', [ArsipDigitalController::class, 'surat_masuk_upzis2'])->name('surat_masuk_upzis2');
        Route::get('/arsip/surat_masuk_upzis/{id}', [ArsipDigitalController::class, 'surat_masuk_upzis'])->name('surat_masuk_upzis');
        // Route::get('/arsip/surat_masuk_upzis/{id}', [ArsipDigitalController::class, 'surat_masuk_upzis'])->name('surat_masuk_upzis');
        Route::get('/arsip/surat_masuk_ranting/{id}', [ArsipDigitalController::class, 'surat_masuk_ranting']);
        Route::get('/arsip/tambah_surat_masuk/{hal}', [ArsipDigitalController::class, 'tambah_surat_masuk'])->name('tambah_surat_masuk');
        Route::post('/aksi_tambah_surat_masuk', [ArsipDigitalController::class, 'aksi_tambah_surat_masuk'])->name('aksi_tambah_surat_masuk');
        Route::get('/arsip/surat_masuk_pc/{id}', [ArsipDigitalController::class, 'surat_masuk_pc'])->name('surat_masuk_pc');
        Route::get('/arsip/detail_surat_masuk/{id}/{hal}', [ArsipDigitalController::class, 'detail_surat_masuk'])->name('detail_surat_masuk');
        Route::put('/arsip/proses_edit_surat_masuk/{id}', [ArsipDigitalController::class, 'proses_edit_surat_masuk'])->name('proses_edit_surat_masuk');
        Route::put('/arsip/proses_edit_disposisi/{id}', [ArsipDigitalController::class, 'proses_edit_disposisi'])->name('proses_edit_disposisi');
        Route::put('/arsip/proses_edit_sppd/{id}', [ArsipDigitalController::class, 'proses_edit_sppd'])->name('proses_edit_sppd');
        Route::post('/arsip/hapus_surat_masuk/{id}', [ArsipDigitalController::class, 'hapus_surat_masuk'])->name('hapus_surat_masuk');


        //FILE LAMPIRAN ARSIP
        Route::post('/arsip/aksi_edit_lampiran/{id}', [ArsipDigitalController::class, 'aksi_edit_lampiran'])->name('aksi_edit_lampiran');
        Route::post('/arsip/aksi_tambah_lampiran', [ArsipDigitalController::class, 'aksi_tambah_lampiran'])->name('aksi_tambah_lampiran');
        Route::post('/arsip/aksi_hapus_lampiran/{id}', [ArsipDigitalController::class, 'aksi_hapus_lampiran'])->name('aksi_hapus_lampiran');

        //Penerima SUrat
        Route::post('/aksi_tambah_penerima_surat', [ArsipDigitalController::class, 'aksi_tambah_penerima_surat'])->name('aksi_tambah_penerima_surat');
        Route::post('/aksi_hapus_penerima_surat/{id}', [ArsipDigitalController::class, 'aksi_hapus_penerima_surat'])->name('aksi_hapus_penerima_surat');

        //SURAT KELUAR
        Route::post('/filter/surat_keluar/{part}/{hal}', [FilterSuratKeluarController::class, 'filter_surat_keluar'])->name('filter_surat_keluar');
        Route::get('/arsip/surat_keluar_upzis2/{id}', [ArsipDigitalController::class, 'surat_keluar_upzis2'])->name('surat_keluar_upzis2');
        Route::get('/arsip/surat_keluar_upzis/{id}', [ArsipDigitalController::class, 'surat_keluar_upzis'])->name('surat_keluar_upzis');

        Route::get('/arsip/tambah_surat_keluar/{hal}', [ArsipDigitalController::class, 'tambah_surat_keluar'])->name('tambah_surat_keluar');
        Route::get('/arsip/tambah_surat_keluar/baru/{hal}', [ArsipDigitalController::class, 'tambah_surat_keluar_baru'])->name('tambah_surat_keluar_baru');
        Route::get('/arsip/surat_keluar_pc/{id}', [ArsipDigitalController::class, 'surat_keluar_pc'])->name('surat_keluar_pc');
        Route::get('/arsip/surat_keluar_upzis/{id}', [ArsipDigitalController::class, 'surat_keluar_upzis'])->name('surat_keluar_upzis');
        Route::get('/arsip/surat_keluar_ranting/{id}', [ArsipDigitalController::class, 'surat_keluar_ranting'])->name('surat_keluar_ranting');
        Route::post('/aksi_tambah_surat_keluar', [ArsipDigitalController::class, 'aksi_tambah_surat_keluar'])->name('aksi_tambah_surat_keluar');
        Route::post('/aksi_tambah_surat_keluar_baru', [ArsipDigitalController::class, 'aksi_tambah_surat_keluar_baru'])->name('aksi_tambah_surat_keluar_baru');
        Route::get('/arsip/detail_surat_keluar/{id}/{hal}', [ArsipDigitalController::class, 'detail_surat_keluar'])->name('detail_surat_keluar');
        Route::put('/arsip/proses_edit_surat_keluar/{id}', [ArsipDigitalController::class, 'proses_edit_surat_keluar'])->name('proses_edit_surat_keluar');
        Route::post('/arsip/hapus_surat_keluar/{id}', [ArsipDigitalController::class, 'hapus_surat_keluar'])->name('hapus_surat_keluar');

        Route::get('/arsip/jenis_arsip', [ArsipDigitalController::class, 'jenis_arsip'])->name('jenis_arsip');
        Route::post('/aksi_tambah_jenis_surat', [ArsipDigitalController::class, 'aksi_tambah_jenis_surat'])->name('aksi_tambah_jenis_surat');
        Route::get('/aksi_hapus_jenis_surat/{id}', [ArsipDigitalController::class, 'aksi_hapus_jenis_surat'])->name('aksi_hapus_jenis_surat');
        Route::put('/aksi_edit_jenis_arsip/{id}', [ArsipDigitalController::class, 'aksi_edit_jenis_arsip'])->name('aksi_edit_jenis_arsip');


        //Preview dan Print Disposisi
        Route::post('/arsip/preview_disposisi', [ArsipDigitalController::class, 'preview_disposisi'])->name('preview_disposisi');
        Route::get('/arsip/print_disposisi/{id}', [ArsipDigitalController::class, 'print_disposisi'])->name('print_disposisi');
        Route::get('/arsip/print_surat/{id}', [ArsipDigitalController::class, 'print_surat'])->name('print_surat');
        Route::get('/arsip/print_surat_upzis/{id}', [ArsipDigitalController::class, 'print_surat_upzis'])->name('print_surat_upzis');


        //Berita
        Route::get('/arsip/berita', [BeritaUmumController::class, 'berita'])->name('berita');
        Route::get('/arsip/kategori_berita', [BeritaUmumController::class, 'kategori_berita'])->name('kategori_berita');
        Route::get('/arsip/tambah_berita', [BeritaUmumController::class, 'tambah_berita'])->name('tambah_berita');
        Route::post('/aksi_tambah_kategori_berita', [BeritaUmumController::class, 'aksi_tambah_kategori_berita'])->name('aksi_tambah_kategori_berita');
        Route::put('/aksi_edit_kategori_berita/{id}', [BeritaUmumController::class, 'aksi_edit_kategori_berita'])->name('aksi_edit_kategori_berita');
        Route::get('/aksi_hapus_kategori_berita/{id}', [BeritaUmumController::class, 'aksi_hapus_kategori_berita'])->name('aksi_hapus_kategori_berita');
        Route::post('/aksi_tambah_berita', [BeritaUmumController::class, 'aksi_tambah_berita'])->name('aksi_tambah_berita');
        Route::get('/aksi_hapus_berita/{id}', [BeritaUmumController::class, 'aksi_hapus_berita'])->name('aksi_hapus_berita');
        Route::get('/arsip/detail_berita/{id}', [BeritaUmumController::class, 'detail_berita'])->name('detail_berita');
        Route::put('/arsip/aksi_edit_berita/{id}', [BeritaUmumController::class, 'aksi_edit_berita'])->name('aksi_edit_berita');
        Route::post('/filter/berita', [FilterBeritaController::class, 'filter_berita'])->name('filter_berita');

        //FILE BERITA
        Route::post('/arsip/aksi_edit_file_berita/{id}', [BeritaUmumController::class, 'aksi_edit_file_berita'])->name('aksi_edit_file_berita');
        Route::post('/arsip/aksi_tambah_file_berita/{id}', [BeritaUmumController::class, 'aksi_tambah_file_berita'])->name('aksi_tambah_file_berita');
        Route::post('/arsip/aksi_hapus_file_berita/{id}', [BeritaUmumController::class, 'aksi_hapus_file_berita'])->name('aksi_hapus_file_berita');



        //DOKUMEN DIGITAL
        Route::get('/arsip/dokumen_digital_upzis2/{id}', [DokumenDigitalController::class, 'dokumen_digital_upzis2'])->name('dokumen_digital_upzis2');
        Route::get('/arsip/dokumen_digital_upzis/{id}', [DokumenDigitalController::class, 'dokumen_digital_upzis'])->name('dokumen_digital_upzis');
        Route::get('/arsip/tambah_dokumen_digital/{hal}', [DokumenDigitalController::class, 'tambah_dokumen_digital'])->name('tambah_dokumen_digital');
        Route::post('/arsip/hapus_dokumen_digital/{id}', [DokumenDigitalController::class, 'hapus_dokumen_digital'])->name('hapus_dokumen_digital');
        Route::post('/filter/dokumen/{part}/{hal}', [FilterDokumenController::class, 'filter_dokumen'])->name('filter_dokumen');
        Route::get('/arsip/detail_dokumen_digital/{id}/{hal}', [DokumenDigitalController::class, 'detail_dokumen_digital'])->name('detail_dokumen_digital');
        Route::put('/arsip/aksi_edit_dokumen_digital/{id}', [DokumenDigitalController::class, 'aksi_edit_dokumen_digital'])->name('aksi_edit_dokumen_digital');
        Route::post('/arsip/aksi_tambah_dokumen_digital', [DokumenDigitalController::class, 'aksi_tambah_dokumen_digital'])->name('aksi_tambah_dokumen_digital');

        //MEMO
        Route::get('/arsip/memo', [MemoController::class, 'memo'])->name('memo');
        Route::get('/arsip/tambah_memo', [MemoController::class, 'tambah_memo'])->name('tambah_memo');
        Route::post('/aksi_tambah_memo', [MemoController::class, 'aksi_tambah_memo'])->name('aksi_tambah_memo');
        Route::post('/aksi_hapus_memo/{id}', [MemoController::class, 'aksi_hapus_memo'])->name('aksi_hapus_memo');
        Route::get('/detail_memo/{id}', [MemoController::class, 'detail_memo'])->name('detail_memo');
        Route::put('/arsip/aksi_edit_memo/{id}', [MemoController::class, 'aksi_edit_memo'])->name('aksi_edit_memo');
        Route::post('/filter/memo', [FilterMemoController::class, 'filter_memo'])->name('filter_memo');
        Route::get('/arsip/memo/{id}', [MemoController::class, 'print_memo'])->name('print_memo');

        //FILE MEMO
        Route::post('/arsip/aksi_edit_file_memo/{id}', [MemoController::class, 'aksi_edit_file_memo'])->name('aksi_edit_file_memo');
        Route::post('/arsip/aksi_tambah_file_memo/{id}', [MemoController::class, 'aksi_tambah_file_memo'])->name('aksi_tambah_file_memo');
        Route::post('/arsip/aksi_hapus_file_memo/{id}', [MemoController::class, 'aksi_hapus_file_memo'])->name('aksi_hapus_file_memo');

        //Kegiatan
        Route::post('/aksi_tambah_kegiatan/', [KegiatanController::class, 'aksi_tambah_kegiatan'])->name('aksi_tambah_kegiatan');
        Route::post('/aksi_hapus_kegiatan/{id}', [KegiatanController::class, 'aksi_hapus_kegiatan'])->name('aksi_hapus_kegiatan');
        Route::get('/arsip/detail_kegiatan_upzis/{id}/', [KegiatanController::class, 'detail_kegiatan_upzis'])->name('detail_kegiatan_upzis');
        Route::post('/aksi_edit_kegiatan/{id}', [KegiatanController::class, 'aksi_edit_kegiatan'])->name('aksi_edit_kegiatan');

        Route::post('/aksi_tambah_file_kegiatan/', [KegiatanController::class, 'aksi_tambah_file_kegiatan'])->name('aksi_tambah_file_kegiatan');
        Route::post('/aksi_edit_file_kegiatan/{id}', [KegiatanController::class, 'aksi_edit_file_kegiatan'])->name('aksi_edit_file_kegiatan');
        Route::post('/aksi_hapus_file_kegiatan/{id}', [KegiatanController::class, 'aksi_hapus_file_kegiatan'])->name('aksi_hapus_file_kegiatan');

        Route::get('/arsip/kegiatan_upzis/', [KegiatanController::class, 'kegiatan_upzis'])->name('kegiatan_upzis');
        Route::get('/kegiatan/jenis_kegiatan_upzis/', [KegiatanController::class, 'jenis_kegiatan_upzis'])->name('jenis_kegiatan_upzis');
        Route::post('/aksi_tambah_jenis_kegiatan/', [KegiatanController::class, 'aksi_tambah_jenis_kegiatan'])->name('aksi_tambah_jenis_kegiatan');
        Route::put('/aksi_edit_jenis_kegiatan/{id}', [KegiatanController::class, 'aksi_edit_jenis_kegiatan'])->name('aksi_edit_jenis_kegiatan');
        Route::post('/aksi_hapus_jenis_kegiatan/{id}', [KegiatanController::class, 'aksi_hapus_jenis_kegiatan'])->name('aksi_hapus_jenis_kegiatan');

        Route::post('/filter/kegiatan_upzis', [FilterKegiatanController::class, 'filter_kegiatan_upzis'])->name('filter_kegiatan_upzis');

        //notulen kegiatan
        Route::get('/arsip/notulen_kegiatan/{id}/', [NotulenController::class, 'notulen_kegiatan_upzis'])->name('notulen_kegiatan_upzis');
        Route::get('/print_notulen/{id}', [NotulenController::class, 'print_notulen'])->name('print_notulen');
        Route::post('/aksi_tambah_notulen/{id_kegiatan}', [NotulenController::class, 'aksi_tambah_notulen'])->name('aksi_tambah_notulen');
        Route::post('/aksi_hapus_notulen/{id}', [NotulenController::class, 'aksi_hapus_notulen'])->name('aksi_hapus_notulen');
        Route::post('/aksi_ubah_kehadiran/{id_kegiatan}', [NotulenController::class, 'aksi_ubah_kehadiran'])->name('aksi_ubah_kehadiran');
        Route::post('/aksi_edit_notulen/{id_kegiatan}/{notulen_id}', [NotulenController::class, 'aksi_edit_notulen'])->name('aksi_edit_notulen');
    });


    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
