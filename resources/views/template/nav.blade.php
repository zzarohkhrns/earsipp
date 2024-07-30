<style>
    @media (max-width: 550px) {
        .hidden {
            display: none !important;
        }
    }
</style>
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i>
            </a>
        </li>
        <div class="d-flex align-items-center hidden">
            {{ $title }}
        </div>
    </ul>
    <ul class="navbar-nav ml-auto align-self-center mr-0">
        <li class="nav-item align-self-center mr-0">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <!--<li class="nav-item align-self-center mr-0">-->
        <!--    <a class="nav-link card-zero" data-widget="kontak" id="panduan" type="button">PANDUAN</a>-->
        <!--</li>-->

        <li class="nav-item align-self-center mr-0">
            <a style="cursor: pointer;" class="nav-link" onclick="sendWhatsAppMessage()">BANTUAN</a>
            <script>
                function sendWhatsAppMessage() {
                    var phoneNumber = "+62895411180830"; // Ganti dengan nomor telepon penerima
                    var nama = "{{ Auth::user()->nama }}"; // Ambil nilai nama dari database

                    var jabatan = ""; // Nilai default untuk jabatan
                    var akses = "";
                    var wilayah = "";

                    @if (Auth::user()->gocap_id_pc_pengurus)
                        akses = "PC Lazisnu";
                        jabatan =
                            "{{ Auth::user()->PcPengurus->PengurusJabatan->jabatan }}"; // Ambil nilai Pengurus dari database
                    @elseif (Auth::user()->gocap_id_upzis_pengurus)
                        wilayah = "{{ Auth::user()->UpzisPengurus->Upzis->Wilayah->nama }}";
                        akses = "UPZIS-";
                        jabatan =
                            "{{ Auth::user()->UpzisPengurus->PengurusJabatan->jabatan }}"; // Ambil nilai Pengurus dari database
                    @elseif (Auth::user()->gocap_id_jpzis_pengurus)
                        wilayah = "{{ Auth::user()->JpzisPengurus->Jpzis->Wilayah->nama }}";
                        akses = "JPZIS-";
                        jabatan = "{{ Auth::user()->JpzisPengurus->JpzisJabatan->jabatan }}"; // Ambil nilai Pengurus dari database
                    @endif

                    var message = "Assalamualaikum." +
                        "\n\n*Nama*\n" + nama +
                        "\n*Jabatan*\n" + jabatan +
                        "\n*Akses*\n" + akses + wilayah.toUpperCase() +
                        "\n\nMohon bantuan untuk pertanyaan dibawah ini,\n\n\nTerimakasih.";

                    var spaceReplacedMessage = message.replace(/%20/g, " ");

                    var url = "https://wa.me/" + phoneNumber + "?text=" + encodeURIComponent(spaceReplacedMessage);
                    window.open(url);
                }
            </script>



        </li>
        <li>
            <a href="https://siftnu.nucarecilacap.id/dashboard" class="mr-1">
                <img width="70px" src="{{ asset('images/siftnu.png') }}" alt="">
            </a>
            {{-- <a class="btn btn-logout m-0">
        <button class="btn btn-block btn-danger btn-sm">SIFNU  <i class="fa fa-sign-out-alt"></i></button>
      </a> --}}
        </li>
    </ul>
</nav>
