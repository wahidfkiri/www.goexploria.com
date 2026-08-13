$(document).ready(function() {
    $('#table').DataTable();
    function filterColumn ( i ) {
        $('#table').DataTable().column( i ).search(
            $('#col'+i+'_filter').val()
        ).draw();
    }
    $('input.column_filter').on( 'keyup click', function () {
        filterColumn("0");
    } );
} );    