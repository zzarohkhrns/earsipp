<?php

namespace App\Http\Livewire;

use App\Models\Kategori;
use App\Models\PenerimaManfaat;
use App\Models\Pengguna;
use Faker\Core\Uuid;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class PenerimaIndex extends Component
{
    // save
    // tab detail diri
    public $nama;
    public $nik;
    public $tempat_lahir;
    public $tanggal_lahir;
    public $alamat;
    public $nohp;
    public $rt;
    public $rw;
    public $jenis_kelamin;
    // tab mustahik
    public $jenis;
    public $id_kategori_penerima_manfaat;
    public $nomor_registrasi_entitas;
    public $nomor_perijinan_entitas;
    public $nama_lembaga_entitas;
    public $nama_pimpinan_entitas;
    public $alamat_lembaga_entitas;

    // edit 
    // pengguna (siftnu)
    public $id_pengguna_edit;
    public $nama_edit;
    public $nik_edit;
    public $tempat_lahir_edit;
    public $tanggal_lahir_edit;
    public $alamat_edit;
    public $nohp_edit;
    public $rt_edit;
    public $rw_edit;
    public $jenis_kelamin_edit;
    // penerima manfaat (etasyaruf)
    public $id_penerima_manfaat_edit;
    public $id_kategori_penerima_manfaat_edit;
    public $jenis_edit;
    public $nomor_registrasi_entitas_edit;
    public $nomor_perijinan_entitas_edit;
    public $nama_lembaga_entitas_edit;
    public $nama_pimpinan_entitas_edit;
    public $alamat_lembaga_entitas_edit;


    // delete
    public $id_pengguna_delete = '';


    // table
    public $page_number = 5;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {

        $data = DB::table('siftnu.pengguna')->join('etasyaruf.penerima_manfaat', 'etasyaruf.penerima_manfaat.id_penerima_manfaat', 'siftnu.pengguna.etasyaruf_id_penerima_manfaat')
            ->select('etasyaruf.penerima_manfaat.*', 'siftnu.pengguna.id_pengguna', 'siftnu.pengguna.nama', 'siftnu.pengguna.nohp', 'siftnu.pengguna.alamat')->paginate($this->page_number);

        $kategori = Kategori::get();
        $kategori_edit = Kategori::get();

        // // select nama pc
        // $pc_pengurus = DB::table('gocap.pc_pengurus')->where('id_pc_pengurus', Auth::user()->id_pengguna)->first();
        // $pc = DB::table('gocap.pc')->where('id_pc', $pc_pengurus->id_pc)->first();
        // $nama_pc = $pc->nama_pc;

        return view('livewire.penerima-index', compact('data', 'kategori', 'kategori_edit'));
    }
    public function create()
    {
        // validasi jika jenis = entitas
        if ($this->jenis == 'Entitas' or $this->jenis == null) {
            // validasi
            $validatedData = $this->validate([
                // tab detail diri
                'nama' => 'required',
                'nik' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'alamat' => 'required',
                'nohp' => 'required',
                'rt' => 'required',
                'rw' => 'required',
                'jenis_kelamin' => 'required',
                // 'foto' => 'required',

                // tab mustahik
                'jenis' => 'required',
                'id_kategori_penerima_manfaat' => 'required',
                'nomor_registrasi_entitas' => 'required',
                'nomor_perijinan_entitas' => 'required',
                'nama_lembaga_entitas' => 'required',
                'nama_pimpinan_entitas' => 'required',
                'alamat_lembaga_entitas' => 'required',

            ], [
                // tab detail diri
                'nama.required' => 'Nama harus diisi',
                'nik.required' => 'NIK harus diisi',
                'tempat_lahir.required' => 'Tempat lahir harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'nohp.required' => 'No HP harus diisi',
                'rt.required' => 'RT harus diisi',
                'rw.required' => 'RW harus diisi',
                'jenis_kelamin.required' => 'Jenis kelamin harus diisi',
                // 'foto.required' => 'Foto harus diisi',

                // tab mustahik
                'jenis.required' => 'Jenis penerima manfaat harus diisi',
                'id_kategori_penerima_manfaat.required' => 'Kategori penerima manfaat harus diisi',
                'nomor_registrasi_entitas.required' => 'Nomor registrasi harus diisi',
                'nomor_perijinan_entitas.required' => 'Nomor perijinan harus diisi',
                'nama_lembaga_entitas.required' => 'Nama lembaga harus diisi',
                'nama_pimpinan_entitas.required' => 'Nama pimpinan harus diisi',
                'alamat_lembaga_entitas.required' => 'Alamat harus diisi',

            ]);
        }

        // validasi jika jenis = perorangan
        if ($this->jenis == 'Perorangan' or $this->jenis == null) {
            // validasi
            $validatedData = $this->validate([
                // tab detail diri
                'nama' => 'required',
                'nik' => 'required',
                'tempat_lahir' => 'required',
                'tanggal_lahir' => 'required',
                'alamat' => 'required',
                'nohp' => 'required',
                'rt' => 'required',
                'rw' => 'required',
                'jenis_kelamin' => 'required',
                // 'foto' => 'required',

                // tab mustahik
                'jenis' => 'required',
                'id_kategori_penerima_manfaat' => 'required',


            ], [
                // tab detail diri
                'nama.required' => 'Nama harus diisi',
                'nik.required' => 'NIK harus diisi',
                'tempat_lahir.required' => 'Tempat lahir harus diisi',
                'tanggal_lahir.required' => 'Tanggal lahir harus diisi',
                'alamat.required' => 'Alamat harus diisi',
                'nohp.required' => 'No HP harus diisi',
                'rt.required' => 'RT harus diisi',
                'rw.required' => 'RW harus diisi',
                'jenis_kelamin.required' => 'Jenis kelamin harus diisi',
                // 'foto.required' => 'Foto harus diisi',

                // tab mustahik
                'jenis.required' => 'Jenis penerima manfaat harus diisi',
                'id_kategori_penerima_manfaat.required' => 'Kategori penerima manfaat harus diisi',


            ]);
        }

        $id_penerima_manfaat = Str::uuid();
        // create ke tabel pengguna (database siftnu)
        Pengguna::create([
            'id_pengguna' => Str::uuid(),
            'etasyaruf_id_penerima_manfaat' => $id_penerima_manfaat,
            'id_wilayah' => '33.01',
            'nama' => $this->nama,
            'nik' => $this->nik,
            'tempat_lahir' => $this->tempat_lahir,
            'tanggal_lahir' => $this->tanggal_lahir,
            'alamat' => $this->alamat,
            'nohp' => $this->nohp,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'jenis_kelamin' => $this->jenis_kelamin,
            'status' => '1',
            // 'foto' => $this->foto,
        ]);

        if ($this->jenis == 'Entitas') {
            // create ke tabel penerima_manfaat (database etasyaruf)
            PenerimaManfaat::create([
                'id_penerima_manfaat' => $id_penerima_manfaat,
                'id_kategori_penerima_manfaat' => $this->id_kategori_penerima_manfaat,
                'jenis' => $this->jenis,
                'nomor_registrasi_entitas' => $this->nomor_registrasi_entitas,
                'nomor_perijinan_entitas' => $this->nomor_perijinan_entitas,
                'nama_lembaga_entitas' => $this->nama_lembaga_entitas,
                'nama_pimpinan_entitas' => $this->nama_pimpinan_entitas,
                'alamat_lembaga_entitas' => $this->alamat_lembaga_entitas,
            ]);
        }

        if ($this->jenis == 'Perorangan') {
            // create ke tabel penerima_manfaat (database etasyaruf)
            PenerimaManfaat::create([
                'id_penerima_manfaat' => $id_penerima_manfaat,
                'id_kategori_penerima_manfaat' => $this->id_kategori_penerima_manfaat,
                'jenis' => $this->jenis,
            ]);
        }

        session()->flash('message_simpan', 'Data berhasil ditambahkan');
        $this->resetInput();
        $this->emit('alert_remove');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function resetInput()
    {
        $this->nama = null;
        $this->nik = null;
        $this->tempat_lahir = null;
        $this->tanggal_lahir = null;
        $this->alamat = null;
        $this->nohp = null;
        $this->rt = null;
        $this->rw = null;
        $this->jenis_kelamin = null;
    }

    public function modal_edit($id_pengguna)
    {
        // select pengguna (siftnu)
        $pengguna = Pengguna::where('id_pengguna', $id_pengguna)->first();
        $this->id_pengguna_edit = $pengguna->id_pengguna;
        $this->nama_edit = $pengguna->nama;
        $this->nik_edit = $pengguna->nik;
        $this->tempat_lahir_edit = $pengguna->tempat_lahir;
        $this->tanggal_lahir_edit = $pengguna->tanggal_lahir;
        $this->alamat_edit = $pengguna->alamat;
        $this->nohp_edit = $pengguna->nohp;
        $this->rt_edit = $pengguna->rt;
        $this->rw_edit = $pengguna->rw;
        $this->jenis_kelamin_edit = $pengguna->jenis_kelamin;

        // select penerima manfaat (etasyaruf)
        $penerima_manfaat = PenerimaManfaat::where('id_penerima_manfaat', $pengguna->etasyaruf_id_penerima_manfaat)->first();
        $this->id_penerima_manfaat_edit = $penerima_manfaat->id_penerima_manfaat;
        $this->id_kategori_penerima_manfaat_edit = $penerima_manfaat->id_kategori_penerima_manfaat;
        $this->jenis_edit = $penerima_manfaat->jenis;
        $this->nomor_registrasi_entitas_edit = $penerima_manfaat->nomor_registrasi_entitas;
        $this->nomor_perijinan_entitas_edit = $penerima_manfaat->nomor_perijinan_entitas;
        $this->nama_lembaga_entitas_edit = $penerima_manfaat->nama_lembaga_entitas;
        $this->nama_pimpinan_entitas_edit = $penerima_manfaat->nama_pimpinan_entitas;
        $this->alamat_lembaga_entitas_edit = $penerima_manfaat->alamat_lembaga_entitas;
    }

    public function modal_delete($id_pengguna)
    {
        $this->id_pengguna_delete = $id_pengguna;
    }

    public function edit()
    {
        // validasi jika jenis = entitas
        if ($this->jenis == 'Entitas' or $this->jenis == null) {
            // validasi
            $validatedData = $this->validate([
                // tab detail diri
                'nama_edit' => 'required',
                'nik_edit' => 'required',
                'tempat_lahir_edit' => 'required',
                'tanggal_lahir_edit' => 'required',
                'alamat_edit' => 'required',
                'nohp_edit' => 'required',
                'rt_edit' => 'required',
                'rw_edit' => 'required',
                'jenis_kelamin_edit' => 'required',
                // 'foto_edit' => 'required',

                // tab mustahik
                'jenis_edit' => 'required',
                'id_kategori_penerima_manfaat_edit' => 'required',
                'nomor_registrasi_entitas_edit' => 'required',
                'nomor_perijinan_entitas_edit' => 'required',
                'nama_lembaga_entitas_edit' => 'required',
                'nama_pimpinan_entitas_edit' => 'required',
                'alamat_lembaga_entitas_edit' => 'required',

            ], [
                // tab detail diri
                'nama_edit.required' => 'Nama harus diisi',
                'nik_edit.required' => 'NIK harus diisi',
                'tempat_lahir_edit.required' => 'Tempat lahir harus diisi',
                'tanggal_lahir_edit.required' => 'Tanggal lahir harus diisi',
                'alamat_edit.required' => 'Alamat harus diisi',
                'nohp_edit.required' => 'No HP harus diisi',
                'rt_edit.required' => 'RT harus diisi',
                'rw_edit.required' => 'RW harus diisi',
                'jenis_kelamin_edit.required' => 'Jenis kelamin harus diisi',
                // 'foto_edit.required' => 'Foto harus diisi',

                // tab mustahik
                'jenis_edit.required' => 'Jenis penerima manfaat harus diisi',
                'id_kategori_penerima_manfaat_edit.required' => 'Kategori penerima manfaat harus diisi',
                'nomor_registrasi_entitas_edit.required' => 'Nomor registrasi harus diisi',
                'nomor_perijinan_entitas_edit.required' => 'Nomor perijinan harus diisi',
                'nama_lembaga_entitas_edit.required' => 'Nama lembaga harus diisi',
                'nama_pimpinan_entitas_edit.required' => 'Nama pimpinan harus diisi',
                'alamat_lembaga_entitas_edit.required' => 'Alamat harus diisi',

            ]);
        }

        // validasi jika jenis = perorangan
        if ($this->jenis == 'Perorangan' or $this->jenis == null) {
            // validasi
            $validatedData = $this->validate([
                // tab detail diri
                'nama_edit' => 'required',
                'nik_edit' => 'required',
                'tempat_lahir_edit' => 'required',
                'tanggal_lahir_edit' => 'required',
                'alamat_edit' => 'required',
                'nohp_edit' => 'required',
                'rt_edit' => 'required',
                'rw_edit' => 'required',
                'jenis_kelamin_edit' => 'required',
                // 'foto_edit' => 'required',

                // tab mustahik
                'jenis_edit' => 'required',
                'id_kategori_penerima_manfaat_edit' => 'required',


            ], [
                // tab detail diri
                'nama_edit.required' => 'Nama harus diisi',
                'nik_edit.required' => 'NIK harus diisi',
                'tempat_lahir_edit.required' => 'Tempat lahir harus diisi',
                'tanggal_lahir_edit.required' => 'Tanggal lahir harus diisi',
                'alamat_edit.required' => 'Alamat harus diisi',
                'nohp_edit.required' => 'No HP harus diisi',
                'rt_edit.required' => 'RT harus diisi',
                'rw_edit.required' => 'RW harus diisi',
                'jenis_kelamin_edit.required' => 'Jenis kelamin harus diisi',
                // 'foto_edit.required' => 'Foto harus diisi',

                // tab mustahik
                'jenis_edit.required' => 'Jenis penerima manfaat harus diisi',
                'id_kategori_penerima_manfaat_edit.required' => 'Kategori penerima manfaat harus diisi',


            ]);
        }

        Pengguna::where('id_pengguna', $this->id_pengguna_edit)->update([
            'nama' => $this->nama_edit,
            'nik' => $this->nik_edit,
            'tempat_lahir' => $this->tempat_lahir_edit,
            'tanggal_lahir' => $this->tanggal_lahir_edit,
            'alamat' => $this->alamat_edit,
            'nohp' => $this->nohp_edit,
            'rt' => $this->rt_edit,
            'rw' => $this->rw_edit,
            'jenis_kelamin' => $this->jenis_kelamin_edit,
        ]);
        session()->flash('message_update', 'Data berhasil diperbarui');
        $this->emit('alert_remove');

        $this->resetInput();
    }

    public function delete()

    {
        // dd($this->id_pengguna_delete);
        Pengguna::where('id_pengguna', $this->id_pengguna_delete)->delete();
        session()->flash('message_hapus', 'Data berhasil dihapus');
        $this->emit('alert_remove');

        $this->resetInput();
    }
}
