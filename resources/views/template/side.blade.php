<style>
    @media (max-width: 50px) {
        .hidden {
            display: none !important;
        }
    }
</style>
<aside class="main-sidebar sidebar-light-success elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('images/ear.png') }}" alt="GOCAP Logo" class="brand-image " style="opacity: .8">
        <span class="brand-text font-weight-bold">E - ARSIP </span>
    </a>


    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex justify-content-center"> --}}
        {{-- <div class="text-center">


            <h5 class="btn-hilang mt-4">
                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    <p>PC LAZISNU CILACAP</p>
                @else
                    @php
                        $wilayah = Auth::user()->UpzisPengurus->Upzis->Wilayah->nama;
                        $log = 'UPZIS ' . strtoupper($wilayah);
                    @endphp
                    {{ $log }}
                @endif

            </h5>
            <span class="btn-hilang">{{ Auth::user()->nama }}</span><br>

            <span class="m-0 btn btn-success btn-sm btn-hilang" style="border-radius: 10px">
                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    {{ Auth::user()->PcPengurus->PengurusJabatan->jabatan }}
                @elseif (Auth::user()->gocap_id_upzis_pengurus != null)
                    {{ Auth::user()->UpzisPengurus->PengurusJabatan->jabatan }}
                @endif
            </span>

            <br>
            <a class="btn btn-white btn-sm btn-hilang"><i class="fas fa-cog"></i>
                <p> Pengaturan</p>
            </a>

            <a href="/logout" class="btn btn-white btn-sm btn-hilang"><i class="fa fa-sign-out-alt"></i>
                <p> Keluar</p>
            </a>
        </div> --}}

        <div class="text-center">
            @if (Auth::user()->gocap_id_pc_pengurus != '')
                <h5 class="btn-hilang mt-4">PC <p>LAZISNU CILACAP</p>
                </h5>
            @endif
            @if (Auth::user()->gocap_id_upzis_pengurus != '')
                <h5 class="btn-hilang mt-4">UPZIS <p>{{ strtoupper(Auth::user()->UpzisPengurus->Upzis->Wilayah->nama) }}
                    </p>
                </h5>
            @endif
            <span class="btn-hilang">{{ Auth::user()->nama }}</span><br>
            <span class="m-0 badge badge-success badge-sm badge-hilang" style="border-radius: 10px">
                {{-- {{ $Auth::user()->gocap_id_pc_pengurus==""?Auth::user()->UpzisPengurus->Pengurusjabatan->jabatan:Auth::user()->PcPengurus->Pengurusjabatan->jabatan }} --}}
                @if (Auth::user()->gocap_id_pc_pengurus != '')
                    <marquee behavior="" scrolldelay="300" direction="" class="pt-1">
                        {{ Auth::user()->PcPengurus->PengurusJabatan->jabatan }}
                    </marquee>
                @endif
                @if (Auth::user()->gocap_id_upzis_pengurus != '')
                    {{ Auth::user()->UpzisPengurus->PengurusJabatan->jabatan }}
                @endif
            </span><br>
            <a class="btn btn-white btn-sm btn-hilang"><i class="fas fa-cog"></i>
                <p> Pengaturan</p>
            </a>
            {{-- <a class="btn btn-white btn-sm btn-hilang" href="https://siftnu.nucarecilacap.id/"><i
                    class="fa fa-sign-out-alt"></i>
                <p> Keluar</p> --}}
            <a href="/logout" class="btn btn-white btn-sm btn-hilang"><i class="fa fa-sign-out-alt"></i>
                <p> Keluar</p>
            </a>
        </div>
        {{-- </div> --}}
        <hr>
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

                <li class="nav-item  @yield('dashboard') card-first">
                    <a href="/{{ $role }}/dashboard" class="nav-link  @yield('dashboard')">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>

                <li class="nav-header mt-1">E-Arsip </li>

                @if (Auth::user()->gocap_id_pc_pengurus != null)
                    <li class="nav-item card-second">
                        <a onclick="$('#cover-spin').show(0)" href="/{{ $role }}/arsip/memo"
                            class="nav-link @yield('memo')"><i class="nav-icon fas fa-th-list"
                                style="font-size:17px;"></i>
                            <p>Memo Internal</p>
                        </a>
                    </li>

                    <li class="nav-item card-third">
                        <a onclick="$('#cover-spin').show(0)" href="/{{ $role }}/arsip/berita"
                            class="nav-link @yield('berita')"><i class="nav-icon fas fa-newspaper"
                                style="font-size:17px;"></i>
                            <p>Berita Umum</p>
                        </a>
                    </li>

                    <li class="nav-item @yield('barang') card-seven">

                        <a href="#" class="nav-link @yield('barang_link')">
                            <i class="nav-icon fas fa-box" style="font-size:17px;"></i>
                            <p>Data Aset<i class="right fas fa-angle-left"></i></p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a onclick="$('#cover-spin').show(0)" href="/{{ $role }}/arsip/aset/data"
                                    class="nav-link @yield('data_barang')">
                                    <i class="nav-icon fas fa-archive"></i>
                                    <p>Data Aset</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a onclick="$('#cover-spin').show(0)" href="/{{ $role }}/arsip/aset/permohonan"
                                    class="nav-link @yield('permohonan_barang')">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>Permohonan</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a onclick="$('#cover-spin').show(0)" href="/{{ $role }}/arsip/aset/penyaluran"
                                    class="nav-link @yield('penyaluran_barang')">
                                    <i class="nav-icon fas fa-request"></i>
                                    <p>Penyaluran</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item @yield('kegiatan_mo') card-four">

                        <a href="#" class="nav-link  @yield('kegiatan_ac')">
                            <i class="nav-icon fas fa-chart-line" style="font-size:17px;"></i>
                            <p>Kegiatan & Notulen<i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            <li class="nav-item">

                            </li>


                            <li class="nav-item">
                                <a onclick="$('#cover-spin').show(0)" href="/{{ $role }}/arsip/kegiatan_pc/pc"
                                    class="nav-link @yield('pc_kegiatan')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        LAZISNU
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a onclick="$('#cover-spin').show(0)"
                                    href="/{{ $role }}/arsip/kegiatan_pc/upzis"
                                    class="nav-link @yield('upzis_kegiatan')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        UPZIS
                                    </p>
                                </a>
                            </li>


                        </ul>
                    </li>
                    <li class="nav-item  @yield('arsip_mo') card-five">
                        <a href="#" class="nav-link @yield('arsip_ac')" style="font-size:17px;"><i
                                class="nav-icon fa-regular fas fa-envelope"></i>
                            <p>
                                Arsip Surat
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>


                        <ul class="nav nav-treeview">
                            <li class="nav-item @yield('arsip_masuk_mo')">

                                <a href="#" class="nav-link  @yield('arsip_masuk_ac')" style="font-size:17px;">&nbsp;
                                    <i class="fas fa-download"></i>
                                    <p>
                                        &nbsp; Surat Masuk
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>

                                <ul class="nav nav-treeview">
                                    <li class="nav-item">

                                    </li>


                                    <li class="nav-item">
                                        <a onclick="$('#cover-spin').show(0)"
                                            href="/{{ $role }}/arsip/surat_masuk_pc/pc"
                                            class="nav-link @yield('pc_masuk')">
                                            <i class="nav-icon fas fa-genderless"></i>
                                            <p>
                                                KPD. LAZISNU
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a onclick="$('#cover-spin').show(0)"
                                            href="/{{ $role }}/arsip/surat_masuk_pc/upzis"
                                            class="nav-link @yield('upzis_masuk')">
                                            <i class="nav-icon fas fa-genderless"></i>
                                            <p>
                                                KPD. UPZIS
                                            </p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item @yield('arsip_keluar_mo')">

                                <a class="nav-link @yield('arsip_keluar_ac')" style="font-size:17px;">&nbsp;
                                    <i class="fas fa-upload"></i>
                                    <p>
                                        &nbsp; Surat Keluar
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>


                                <ul class="nav nav-treeview">



                                    <li class="nav-item">
                                        <a onclick="$('#cover-spin').show(0)"
                                            href="/{{ $role }}/arsip/surat_keluar_pc/pc"
                                            class="nav-link @yield('pc_keluar')">
                                            <i class="nav-icon fas fa-genderless"></i>
                                            <p>
                                                OLEH. LAZISNU
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a onclick="$('#cover-spin').show(0)"
                                            href="/{{ $role }}/arsip/surat_keluar_pc/upzis"
                                            class="nav-link @yield('upzis_keluar')">
                                            <i class="nav-icon fas fa-genderless"></i>
                                            <p>
                                                OLEH. UPZIS
                                            </p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item @yield('dokumen_mo') card-six">

                        <a href="#" class="nav-link  @yield('dokumen_ac')" style="font-size:17px;">
                            <i class="nav-icon fa-regular fas fa-folder"></i>
                            <p>
                                Arsip Dokumen
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">
                            {{-- <li class="nav-item">
                                <a href="/{{ $role }}/arsip/tambah_dokumen_digital/"
                                    class="nav-link @yield('tambah_dokumen')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        Tambah Surat
                                    </p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="/{{ $role }}/arsip/dokumen_digital_pc/pc"
                                    class="nav-link @yield('pc_dokumen')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        PC
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/{{ $role }}/arsip/dokumen_digital_pc/upzis"
                                    class="nav-link @yield('upzis_dokumen')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        UPZIS
                                    </p>
                                </a>
                            </li> --}}
                            <li class="nav-item">
                                <a onclick="$('#cover-spin').show(0)"
                                    href="/{{ $role }}/arsip/dokumen_digital_pc/pc"
                                    class="nav-link @yield('pc_dokumen')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        OLEH. LAZISNU
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a onclick="$('#cover-spin').show(0)"
                                    href="/{{ $role }}/arsip/dokumen_digital_pc/upzis"
                                    class="nav-link @yield('upzis_dokumen')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        OLEH. UPZIS
                                    </p>
                                </a>
                            </li>



                        </ul>
                    </li>
                @elseif (Auth::user()->gocap_id_upzis_pengurus != null)
                    {{-- <li class="nav-item @yield('kegiatan_mo')">

                        <a href="#" class="nav-link  @yield('kegiatan_ac')" style="font-size:17px;">&nbsp;
                            <i class="fas fa-chart-line" style="font-size:17px;"></i>
                            <p>
                                &nbsp; Kegiatan & Notulen
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a> --}}

                    <li class="nav-item  @yield('kegiatan_mo') card-four">
                        <a onclick="$('#cover-spin').show(0)" href="/{{ $role }}/arsip/kegiatan_upzis/"
                            class="nav-link @yield('kegiatan_ac')">
                            <i class="nav-icon fas fa-chart-line" style="font-size:17px;"></i>
                            <p>Kegiatan & Notulen
                            </p>
                        </a>
                    </li>


                    {{-- <ul class="nav nav-treeview">
                            <li class="nav-item">

                            </li>


                            <li class="nav-item">
                                <a href="/{{ $role }}/arsip/kegiatan_upzis/pc"
                                    class="nav-link @yield('pc_kegiatan')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        LAZISNU
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="/{{ $role }}/arsip/kegiatan_upzis/upzis"
                                    class="nav-link @yield('upzis_kegiatan')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        UPZIS
                                    </p>
                                </a>
                            </li>


                        </ul>
                    </li>  --}}
                    <li class="nav-item  @yield('arsip_mo') card-five">
                        <a href="#" class="nav-link @yield('arsip_ac')" style="font-size:17px;">&nbsp;<i
                                class="fa-regular fas fa-envelope"></i>
                            <p>
                                &nbsp; Arsip Surat
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>


                        <ul class="nav nav-treeview">
                            <li class="nav-item @yield('arsip_masuk_mo')">

                                <a href="#" class="nav-link  @yield('arsip_masuk_ac')" style="font-size:17px;">&nbsp;
                                    <i class=" nav-icon fas fa-download"></i>
                                    <p>
                                        Surat Masuk
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>

                                <ul class="nav nav-treeview">
                                    <li class="nav-item">

                                    </li>


                                    <li class="nav-item">
                                        <a onclick="$('#cover-spin').show(0)"
                                            href="/{{ $role }}/arsip/surat_masuk_upzis/pc"
                                            class="nav-link @yield('pc_masuk')">
                                            <i class="nav-icon fas fa-genderless"></i>
                                            <p>
                                                KPD. LAZISNU
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a onclick="$('#cover-spin').show(0)"
                                            href="/{{ $role }}/arsip/surat_masuk_upzis/upzis"
                                            class="nav-link @yield('upzis_masuk')">
                                            <i class="nav-icon fas fa-genderless"></i>
                                            <p>
                                                KPD. UPZIS
                                            </p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        </ul>

                        <ul class="nav nav-treeview">
                            <li class="nav-item @yield('arsip_keluar_mo')">

                                <a class="nav-link @yield('arsip_keluar_ac')" style="font-size:17px;">&nbsp;
                                    <i class="fas fa-upload"></i>
                                    <p>
                                        &nbsp; Surat Keluar
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>


                                <ul class="nav nav-treeview">



                                    <li class="nav-item">
                                        <a onclick="$('#cover-spin').show(0)"
                                            href="/{{ $role }}/arsip/surat_keluar_upzis/pc"
                                            class="nav-link @yield('pc_keluar')">
                                            <i class="nav-icon fas fa-genderless"></i>
                                            <p>
                                                OLEH. LAZISNU
                                            </p>
                                        </a>
                                    </li>

                                    <li class="nav-item">
                                        <a onclick="$('#cover-spin').show(0)"
                                            href="/{{ $role }}/arsip/surat_keluar_upzis/upzis"
                                            class="nav-link @yield('upzis_keluar')">
                                            <i class="nav-icon fas fa-genderless"></i>
                                            <p>
                                                OLEH. UPZIS
                                            </p>
                                        </a>
                                    </li>


                                </ul>
                            </li>
                        </ul>

                    </li>
                    <li class="nav-item @yield('dokumen_mo') card-six">

                        <a href="#" class="nav-link  @yield('dokumen_ac')" style="font-size:17px;">
                            <i class="fa-regular fas fa-folder"></i>
                            <p>
                                &nbsp;Arsip Dokumen
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>

                        <ul class="nav nav-treeview">


                            {{-- <li class="nav-item">
                                <a href="/{{ $role }}/arsip/dokumen_digital_upzis/pc"
                                    class="nav-link @yield('pc_dokumen')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        OLEH PC
                                    </p>
                                </a>
                            </li> --}}


                            <li class="nav-item">
                                <a onclick="$('#cover-spin').show(0)"
                                    href="/{{ $role }}/arsip/dokumen_digital_upzis/pc"
                                    class="nav-link @yield('pc_dokumen')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        OLEH. LAZISNU
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a onclick="$('#cover-spin').show(0)"
                                    href="/{{ $role }}/arsip/dokumen_digital_upzis/upzis"
                                    class="nav-link @yield('upzis_dokumen')">
                                    <i class="nav-icon fas fa-genderless"></i>
                                    <p>
                                        OLEH. UPZIS
                                    </p>
                                </a>
                            </li>


                        </ul>
                    </li>
                @endif

                {{-- <li class="nav-header mt-1">Data Master </li>
                <li class="nav-item  @yield('aset_mo')">
                    <a href="#" class="nav-link @yield('aset_ac')"><i class="nav-icon fas fa-archive"></i>
                        Data Aset
                        <p>
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a onclick="$('#cover-spin').show(0)" href="/{{ $role }}/aset_wakaf"
                                class="nav-link @yield('wakaf')">
                                <i class="nav-icon fas fa-genderless"></i>
                                <p>
                                    Dari Penerima Wakaf
                                </p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a onclick="$('#cover-spin').show(0)" href="/{{ $role }}/aset_umum"
                                class="nav-link @yield('umum')">
                                <i class="nav-icon fas fa-genderless"></i>
                                <p>
                                    Dari Pentasyarufan
                                </p>
                            </a>
                        </li>
                    </ul>


                </li> --}}
            </ul>

        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->

    <script>
        var yeso = document.getElementById("panduan");
        yeso.onclick = function() {
            // introJs().setOptions({
            //     steps: [{
            //         element: document.querySelector('.card-first'),
            //         title: 'Dashboard',
            //         intro: 'Untuk Menampilkan Statistik Data Pada Sistem Pengelolaan E-Arsip'
            //     }]
            // }).start();
        }
    </script>

</aside>
