<div>

    <div class="form-group row intro-klasifikasi-out">
        <label class="col-sm-4 col-form-label ">Klasifikasi
            Surat</label>
        <div class="col-sm-8">
            <select wire:model="klasifikasi_surat" class="form-control @error('klasifikasi_surat') is-invalid @enderror"
                name="klasifikasi_surat" data-placeholder="Masukan Klasifikasi Surat">


                <option value="" disabled selected hidden> Masukan
                    Klasifikasi Surat
                </option>

                <option value="Biasa">Biasa ( A.I )</option>
                <option value="Khusus">Khusus ( A.II )</option>


            </select>

            @error('klasifikasi_surat')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>

    {{-- style="appearance:none;
    -webkit-appearance:none;
    -moz-appearance:none;
   " --}}

    <div class="form-group row intro-jenis-surat-out">
        <label class="col-sm-4 col-form-label">Jenis
            Surat</label>
        <div class="col-sm-8">
            <select wire:model="jenis_surat" class="form-control @error('jenis_surat') is-invalid @enderror"
                name="jenis_surat" data-placeholder="Masukan Jenis Surat" value="{{ old('jenis_surat') }}">
                <option selected hidden value="">Masukan Jenis Surat</option>
                @foreach ($jenis_surat_table as $js)
                    <option value="{{ $js->kode }}"> {{ $js->jenis }} {{ '(' . $js->kode . ')' }}</option>
                @endforeach
            </select>
            @error('jenis_surat')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>


    @php
        
        $d = date('d');
        $m = date('m');
        $th = date('Y');
        
        $month = date('m');
        
        if ($month == '01') {
            $bulan = 'I';
        } elseif ($month == '02') {
            $bulan = 'II';
        } elseif ($month == '03') {
            $bulan = 'III';
        } elseif ($month == '04') {
            $bulan = 'IV';
        } elseif ($month == '05') {
            $bulan = 'V';
        } elseif ($month == '06') {
            $bulan = 'VI';
        } elseif ($month == '07') {
            $bulan = 'VII';
        } elseif ($month == '08') {
            $bulan = 'VIII';
        } elseif ($month == '09') {
            $bulan = 'IX';
        } elseif ($month == '10') {
            $bulan = 'X';
        } elseif ($month == '11') {
            $bulan = 'XI';
        } elseif ($month == '12') {
            $bulan = 'XII';
        }
        
        if (strlen($nomor_urut) == 1) {
            $nomor = '000' . $nomor_urut;
        } elseif (strlen($nomor_urut) == 2) {
            $nomor = '00' . $nomor_urut;
        } elseif (strlen($nomor_urut) == 3) {
            $nomor = '0' . $nomor_urut;
        } elseif (strlen($nomor_urut) == 4) {
            $nomor = $nomor_urut;
        } else {
            $nomor = $nomor_urut;
        }
        
        if ($sifa == 'Biasa') {
            $si = 'A.I';
        } elseif ($sifa == 'Khusus') {
            $si = 'A.II';
        } else {
            $si = '';
        }
        
    @endphp


    <div class="form-group row intro-nomor-out">
        <label class="col-sm-4 col-form-label">Nomor Surat</label>
        <div class="col-sm-8">
            <input type="text" autocomplete="off" class="form-control @error('nomor_surat') is-invalid @enderror"
                name="nomor_surat" placeholder="Masukan Nomor Surat"
                @if ($si != null && $jenis_surat_isi) value="{{ $nomor . '/' . 'PC.11.34.10' . '/' . $si . '/' . $jenis_surat_isi . '/' . $bulan . '/' . $th }}" @endif
                readonly>
            @error('nomor_surat')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror

        </div>
    </div>

    <input type="hidden" name="no_urut" value="{{ $nomor_urut }}">


</div>
