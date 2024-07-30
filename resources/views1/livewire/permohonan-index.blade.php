<!-- Main content -->
<section class="content ">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">

                <div class="card">
                    <!-- /.card-header -->
                    <div class="card-body">

                        {{-- pencarian dengan tombol --}}
                        <form wire:submit.prevent="searching">


                            <div class="form-group">
                                <div class="form-row">
                                    <div class="col col-md-2 col-sm-12">
                                        <select class="form-control">
                                            <option>Kategori Penerima Manfaat</option>
                                        </select>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <select class="form-control">
                                            <option>Bentuk Program</option>
                                        </select>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <select class="form-control">
                                            <option>Sub-Program</option>
                                        </select>
                                    </div>
                                    <div class="col col-md-1 col-sm-12">
                                        <select class="form-control">
                                            <option>Status</option>
                                        </select>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <select class="form-control">
                                            <option>Bulan</option>
                                        </select>
                                    </div>
                                    <div class="col col-md-2 col-sm-12">
                                        <select class="form-control">
                                            <option>Tahun</option>
                                        </select>
                                    </div>



                                    <div class="col">
                                        <button class="btn btn-primary btn-block" type="submit">Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <table id="example" class="table table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="width: 10px;">No</th>
                                    <th>Wilayah</th>
                                    <th>Kategori</th>
                                    <th>Title</th>
                                    <th>Dibuat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Contoh</td>
                                    <td>1</td>
                                    <td>1</td>
                                    <td>1</td>
                                </tr>

                            </tbody>

                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</section>
<!-- /.content -->
