<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil id_pc dari database 'gocap'
        $id_pc = DB::connection('gocap')->table('pc')->where('id_wilayah', '33.01')->first()->id_pc;
        $id_upzis = DB::connection('gocap')->table('upzis')->where('id_wilayah', '33.01.20')->first()->id_upzis;
        $id_pc_pengurus = DB::connection('gocap')->table('pc_pengurus')->where('no_sk_lazisnu', '3301')->first()->id_pc_pengurus;
        $id_upzis_pengurus = DB::connection('gocap')->table('upzis_pengurus')->where('no_sk_mwcnu', '3301')->first()->id_upzis_pengurus;

        // Masukkan data ke dalam tabel aset
        DB::table('aset')->insert([
            [
                'aset_id' => Str::uuid()->toString(),
                'kode_aset' => 'ELEK-001',
                'nama_aset' => 'Laptop Dell XPS 13',
                'tgl_perolehan' => '2023-01-10',
                'harga_perolehan' => 15000000,
                'id_pc' => $id_pc, // Menggunakan nilai id_pc yang diambil dari database gocap
                'id_upzis' => $id_upzis,
                'satuan' => 'Unit',
                'id_kategori' => DB::table('kategori')->where('kategori', 'Elektronik')->first()->id_kategori,
                'spesifikasi' => 'Intel Core i7, 16GB RAM, 512GB SSD',
                'lokasi_penyimpanan' => 'Gudang 1',
                'id_pc_pengurus' => $id_pc_pengurus,
                'id_upzis_pengurus' => $id_upzis_pengurus,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'aset_id' => Str::uuid()->toString(),
                'kode_aset' => 'FURN-002',
                'nama_aset' => 'Meja Kerja Kayu Jati',
                'tgl_perolehan' => '2024-06-15',
                'harga_perolehan' => 3000000,
                'id_pc' => $id_pc, // Menggunakan nilai id_pc yang diambil dari database gocap
                'id_upzis' => Str::uuid()->toString(),
                'satuan' => 'Unit',
                'id_kategori' => DB::table('kategori')->where('kategori', 'Furniture')->first()->id_kategori,
                'spesifikasi' => 'Kayu Jati Solid, Ukuran 120x60 cm',
                'lokasi_penyimpanan' => 'Kantor Utama',
                'id_pc_pengurus' => Str::uuid()->toString(),
                'id_upzis_pengurus' => Str::uuid()->toString(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Tambahkan data aset lain di sini
        ]);
    }
}
