

<!-- Tagsinput JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

<!-- jQuery -->
<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="https://code.iconify.design/iconify-icon/1.0.0-beta.3/iconify-icon.min.js"></script>
<!-- Select2 -->
<link rel="stylesheet" href="{{ asset('assets/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
<script src="{{ asset('assets/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2(),
            $("#ini").select2({
                maximumSelectionLength: 2
            })
    });
</script>

<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });

    $(function() {
        $("#example1").DataTable({
            "responsive": true,

            "autoWidth": false,
            "bJQueryUI": true,

            "bDestroy": true,
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0, 1]
            }],
            "aLengthMenu": [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            "iDisplayLength": 5,

            "language": {
                "emptyTable": "Tidak ada data yang ditujukan kepada anda"
            }


        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });

        $("#example3").DataTable({
            "responsive": true,

            "autoWidth": false,
            "bJQueryUI": true,

            "bDestroy": true,
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0, 1]
            }],
            "aLengthMenu": [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            "iDisplayLength": 5,
            "language": {
                "emptyTable": "Tidak ada data yang ditujukan kepada anda"
            }
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#example4").DataTable({
            "responsive": true,

            "autoWidth": false,
            "bJQueryUI": true,

            "bDestroy": true,
            "aoColumnDefs": [{
                'bSortable': false,
                'aTargets': [0, 1]
            }],
            "aLengthMenu": [
                [5, 10, 25, 50, 100, -1],
                [5, 10, 25, 50, 100, "All"]
            ],
            "iDisplayLength": 5,
            "language": {
                "emptyTable": "Tidak ada data yang ditujukan kepada anda"
            }
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    });
</script>

{{-- datatables --}}
<script>
    $(function() {
        $('#example').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "language": {
                "emptyTable": "Tidak ada data yang ditujukan kepada anda"
            }
            "responsive": true,
        });
    });
</script>

{{-- auto hide alert --}}
<script>
    $(document).ready(function() {
        window.livewire.on('alert_remove', () => {
            $(".alert-success").delay(5000).slideUp(200, function() {
                $(this).alert('close');
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        window.livewire.on('alert_remove', () => {
            $(".alert-danger").delay(5000).slideUp(200, function() {
                $(this).alert('close');
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        window.livewire.on('alert_remove', () => {
            setTimeout(function() {
                $(".badge-success").fadeOut('slow');
            }, 5000); // 3 se   
        });
    });
</script>
