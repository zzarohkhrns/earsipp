@extends('main')


@section('data_barang', 'active menu-open')
@section('barang', 'menu-open')

@section('css')
@section('content')


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
