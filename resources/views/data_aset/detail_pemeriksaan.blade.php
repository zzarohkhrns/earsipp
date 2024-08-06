@extends('main')

@section('detail_barang', 'active menu-open')
@section('barang', 'menu-open')

@section('css')
@endsection

@section('content')
    <style>
        .breadcrumb {
            background-color: transparent;
        }

        .nav-tabs .nav-item.show .nav-link,
        .nav-tabs .nav-link.active {
            color: #28a745;
            font-weight: bold;
        }

        .nav-tabs .nav-link {
            color: #6c757d;
        }

        .status-buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .card-detail-barang .card {
            margin-bottom: 20px;
        }

        .flex-container {
            display: flex;
            gap: 20px;
        }

        .flex-container .card {
            flex: 1;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 1rem;
        }

        .dropdown {
            position: relative;
            display: inline-flex;
            align-items: center;
        }

        .dropdown-button {
            width: 200px;
            /* Set a fixed width for the button */
            padding: 10px;
            cursor: pointer;
            border-radius: 10px;
            background-color: #6c757d;
            color: white;
            border: none;
            display: flex;
            align-items: center;
            justify-content: space-between;
            /* Ensure space between text and icon */
        }

        .dropdown-button .icon {
            margin-left: 10px;
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 200px;
            /* Set a fixed width for the dropdown menu */
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            /* Ensure dropdown is on top of other elements */
            border-radius: 10px;
            max-height: 200px;
            /* Optional: Limit the height of the dropdown menu */
            overflow-y: auto;
            /* Add scroll if content exceeds max height */
        }

        .dropdown-menu button {
            color: black;
            padding: 12px;
            text-decoration: none;
            display: block;
            width: 100%;
            text-align: left;
            border: none;
            background: none;
            cursor: pointer;
        }

        .dropdown-menu button:hover {
            background-color: #ddd;
        }

        .show {
            display: block;
        }
    </style>

    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 pl-4">
                        <li class="breadcrumb-item active">
                            <a href="/{{ $role }}/dashboard">Dashboard</a> / <a
                                href="/{{ $role }}/arsip/aset/data">Data Aset</a> / <a>Detail Pemeriksaan</a>
                        </li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">{{ Carbon\Carbon::parse(now())->isoFormat('dddd, D MMMM Y') }}
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card ijo-kiri">
                        <div class="card-body">
                            <div class="row card-detail-barang">
                                <div class="col-12">
                                    <div class="row card-kontrol-barang">
                                        <div class="col-12">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="pemeriksaan-tab" data-toggle="tab"
                                                        href="#pemeriksaan" role="tab" aria-controls="pemeriksaan"
                                                        aria-selected="true">1. Pemeriksaan</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="status-spv-kc-tab" data-toggle="tab"
                                                        href="#status-spv-kc" role="tab" aria-controls="status-spv-kc"
                                                        aria-selected="false">2. Status SPV & KC</a>
                                                </li>
                                            </ul>

                                            <div class="tab-content" id="myTabContent">
                                                <div class="tab-pane fade show active" id="pemeriksaan" role="tabpanel"
                                                    aria-labelledby="pemeriksaan-tab">
                                                    <div class="col-12 mt-3 mb-3">
                                                        <div class="status-buttons">
                                                            <button class="btn btn-success"
                                                                style="border-radius: 10px">Selesai Input
                                                                Pemeriksaan</button>
                                                            <button class="btn btn-warning"
                                                                style="border-radius: 10px">Diteruskan Ke SPV, SPV Belum
                                                                Mengetahui</button>
                                                        </div>
                                                    </div>
                                                    <div class="flex-container">
                                                        <div class="card">

                                                            {{-- detail Pemeriksaan --}}
                                                            <table id="example3"
                                                                style="width: 100%; border-collapse: collapse;">

                                                                {{-- line 1 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Pemeriksa</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%">
                                                                        <div class="dropdown">
                                                                            <button id="dropdownButton"
                                                                                class="dropdown-button"
                                                                                onclick="toggleDropdown()">
                                                                                <span id="buttonText">Belum Selesai
                                                                                    Diinput</span>
                                                                                <i class="fas fa-chevron-down icon"></i>
                                                                            </button>
                                                                            <div id="myDropdown" class="dropdown-menu">
                                                                                <button
                                                                                    onclick="handleSelection('Selesai Diinput')">Selesai
                                                                                    Diinput</button>
                                                                                <button
                                                                                    onclick="handleSelection('Belum Selesai Diinput')">Belum
                                                                                    Selesai Diinput</button>
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h5 class="text-success"><b>Halin Fajar Waskitho</b>
                                                                        </h5>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                                {{-- line 2 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Jabatan</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6>Staff Logistik dan Perlengkapan</h6>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                                {{-- line 3 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Tgl Pemeriksaan</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6>ini tanggal</h6>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>

                                                                {{-- line 4 --}}
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Status</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%"></th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <h6 class="text-success">ini status</h6>
                                                                    </td>
                                                                    <td></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                        <div class="card">
                                                            <table id="example3"
                                                                style="width: 100%; border-collapse: collapse;">
                                                                <tr>
                                                                    <th style="width: 75%">
                                                                        <h6><b>Hasil Pemeriksaan Aset</b></h6>
                                                                    </th>
                                                                    <th style="width: 25%">
                                                                        <div class="btn-group btn-block mb-2 mb-xl-0 card-tambah-kontrol"
                                                                            style="width: 100%;">
                                                                            <div class="btn-group mb-2 mb-xl-0 btn-block">
                                                                                <a href="/{{ $role }}/print-data"
                                                                                    style="border-radius:10px;"
                                                                                    class="btn btn-success">
                                                                                    <i class="fas fa-file-alt"></i> Export
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td style="width: 75%">
                                                                        <h5 class="text-success"><b>30 aset diperiksa</b>
                                                                        </h5>
                                                                    </td>
                                                                    <td style="width: 25%"></td>
                                                                </tr>
                                                            </table>
                                                            <table id="example3"
                                                                style="width: 100%; border-collapse: collapse;">
                                                                <tr>
                                                                    <th style="width: 50%">
                                                                        <h6><b>Berdasarkan Kondisi</b></h6>
                                                                    </th>
                                                                    <th style="width: 50%">
                                                                        <h6><b>Berdasarkan Status</b></h6>
                                                                    </th>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div class="card" style="width: 97%">
                                                                            
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="card" style="width: 97%">

                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="status-spv-kc" role="tabpanel"
                                                    aria-labelledby="status-spv-kc-tab">
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <!-- Content for Status SPV & KC -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- script --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    {{-- script berpindah tab --}}
    <script>
        $(document).ready(function() {
            $('#myTab a').on('click', function(e) {
                e.preventDefault();
                $('#myTab a').css('color', '#6c757d');
                $('#myTab a').css('font-weight', 'normal');
                $(this).css('color', '#28a745');
                $(this).css('font-weight', 'bold');
                $(this).tab('show');
            });
        });
    </script>

    {{-- script untuk dropdown --}}
    <script>
        var status = 'Belum Selesai Diinput';

        function toggleDropdown() {
            var dropdown = document.getElementById("myDropdown");
            dropdown.classList.toggle("show");
        }

        function handleSelection(selection) {
            status = selection;
            document.getElementById("buttonText").textContent = status;
            document.getElementById("myDropdown").classList.remove("show");
        }

        window.onclick = function(event) {
            if (!event.target.matches('#dropdownButton') && !event.target.closest('.dropdown-menu')) {
                var dropdowns = document.getElementsByClassName("dropdown-menu");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
@endsection
