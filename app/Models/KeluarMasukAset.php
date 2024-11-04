<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeluarMasukAset extends Model
{
    protected $table = 'keluar_masuk_aset';
    protected $primaryKey = 'id_keluar_masuk_aset';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_keluar_masuk_aset', 'tanggal_pencatatan', 'id_pencatat', 'id_supervisor', 'id_kc', 'status_pencatatan', 'status_spv', 'status_kc', 'catatan_spv', 'catatan_kc', 'tgl_mengetahui_spv', 'tgl_mengetahui_kc', 'masuk_no_transaksi', 'masuk_tgl_masuk', 'masuk_nama_pemasok', 'masuk_no_faktur', 'masuk_keterangan', 'keluar_no_transaksi', 'keluar_tgl_keluar', 'keluar_nama_penerima', 'keluar_no_faktur', 'keluar_keterangan'];

    public function pencatat()
    {
        return $this->belongsTo(PcPengurus::class, 'id_pencatat', 'id_pc_pengurus');
    }
    public function supervisor()
    {
        return $this->belongsTo(PcPengurus::class, 'id_supervisor', 'id_pc_pengurus');
    }
    public function kc()
    {
        return $this->belongsTo(PcPengurus::class, 'id_kc', 'id_pc_pengurus');
    }
    public function detail_keluar_masuk()
    {
        return $this->hasMany(DetailKeluarMasukAset::class, 'id_keluar_masuk_aset', 'id_keluar_masuk_aset');
    }
}
