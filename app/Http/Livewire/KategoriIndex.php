<?php

namespace App\Http\Livewire;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;


class KategoriIndex extends Component
{
    // tambah
    public $kategori;
    public $kode;
    // tabel
    public $page_number = 5;
    public $search = '';
    public $search_tanggal = '';
    public $search_tanggal_awal = '';
    public $search_tanggal_akhir = '';

    // edit
    public $id_edit;
    public $kode_edit;
    public $kategori_edit;


    public $id_delete = '';

    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        if ($this->search_tanggal_awal == '') {
            $data = Kategori::latest()->where('kode', 'like', '%' . $this->search . '%')
                // ->where('tanggal', 'like', '%' . $this->search_tanggal . '%')
                ->paginate($this->page_number);
        }
        // if ($this->search_tanggal_awal != '') {
        //     $data = Kategori::latest()->where('kode', 'like', '%' . $this->search . '%')
        //         // ->where('tanggal', 'like', '%' . $this->search_tanggal . '%')
        //         ->whereBetween('tanggal', array($this->search_tanggal_awal, $this->search_tanggal_akhir))
        //         ->paginate($this->page_number);
        // }
        return view('livewire.kategori-index', [
            'data' => $data
        ]);
    }

    public function create()
    {
        $validatedData = $this->validate([
            'kategori' => 'required',
            'kode' => 'required|unique:kategori_penerima_manfaat',
        ], [
            'kategori.required' => 'Nama Kategori harus diisi',
            'kode.required' => 'Kode Kategori harus diisi',
            'kode.unique' => 'Kode Kategori sudah ada',

        ]);
        Kategori::create([
            'id_kategori_penerima_manfaat' => Str::uuid(),
            'kategori' => $this->kategori,
            'kode' => $this->kode,
        ]);
        session()->flash('message_simpan', 'Data berhasil ditambahkan');
        $this->resetInput();
        $this->emit('alert_remove');
    }
    public function searching()
    {
    }
    public function modal_update($id_kategori_penerima_manfaat, $kategori, $kode)
    {
        $this->id_edit = $id_kategori_penerima_manfaat;
        $this->kategori_edit = $kategori;
        $this->kode_edit = $kode;
    }
    public function update()
    {
        // t
        $validatedData = $this->validate([
            'kategori_edit' => 'required',
            'kode_edit' => 'required',
        ], [
            'kategori_edit.required' => 'Nama Kategori harus diisi',
            'kode_edit.required' => 'Kode Kategori harus diisi',
        ]);
        Kategori::where('id_kategori_penerima_manfaat', $this->id_edit)->update([
            'kode' => $this->kode_edit,
            'kategori' => $this->kategori_edit,
        ]);
        session()->flash('message_update', 'Data berhasil diperbarui');
        $this->emit('alert_remove');

        $this->resetInput();
    }

    public function modal_delete($id_kategori_penerima_manfaat)
    {
        $this->id_delete = $id_kategori_penerima_manfaat;
    }

    public function delete()
    {
        Kategori::where('id_kategori_penerima_manfaat', $this->id_delete)->delete();
        session()->flash('message_hapus', 'Data berhasil dihapus');
        $this->emit('alert_remove');

        $this->resetInput();
    }

    public function resetInput()
    {
        $this->nama = null;
    }
}
