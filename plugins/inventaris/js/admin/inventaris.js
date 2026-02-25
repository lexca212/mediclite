
// $("#ruang_asal").change(function(){

//     var id_ruang = $(this).val();

//     $("#no_inventaris").html('<option>Loading...</option>');

//     if(id_ruang == ""){
//         $("#no_inventaris").html('<option value="">-- Pilih Barang --</option>');
//         return;
//     }

//     $.post("{?=url([ADMIN,'inventaris','getinventarisbyruang'])?}", 
// { id_ruang: id_ruang }, 
// function(response){

//     console.log(response); // DEBUG

//     var data = response;

//     var html = '<option value="">-- Pilih Barang --</option>';

//     $.each(data, function(i, item){
//         html += '<option value="'+item.no_inventaris+'">'+item.nama_barang+' ('+item.no_inventaris+')</option>';
//     });

//     $("#no_inventaris").html(html);

// });
// });
//
$('.dataTables').DataTable({
  "order": [[ 1, "desc" ]],
  "pagingType": "full",
  "language": {
    "paginate": {
      "first": "&laquo;",
      "last": "&raquo;",
      "previous": "‹",
      "next":     "›"
    },
    "search": "",
    "searchPlaceholder": "Search..."
  },
  "lengthChange": false,
  "scrollX": true,
  dom: "<<'data-table-title'><'datatable-search'f>><'row'<'col-sm-12'tr>><<'pmd-datatable-pagination' l i p>>"
});
var t = $(".dataTables").DataTable().rows().count();
$(".data-table-title").html('<h3 style="display:inline;float:left;margin-top:0;" class="hidden-xs">Total: ' + t + '</h3>');

$('.displayData').DataTable();

$(function () {
    $('.tanggaljam').datetimepicker({
      format: 'YYYY-MM-DD HH:mm:ss',
      locale: 'id'
    });
});

$(function () {
    $('.tanggal').datetimepicker({
      format: 'YYYY-MM-DD',
      locale: 'id'
    });
});


// $(document).on('change', '#ruang_asal', function(){

//     var baseURL = mlite.url + '/' + mlite.admin;
//     var url     = baseURL + '/inventaris/getinventarisbyruang?t=' + mlite.token;
//     var id_ruang = $('#ruang_asal').val();

//     if(id_ruang != "") {

//         $.ajax({
//             url: url,
//             method: "POST",
//             data: { id_ruang: id_ruang },
//             success: function(response)
//             {
//                 var data = JSON.parse(response);

//                 var html = '<option value="">-- Pilih Barang --</option>';

//                 $.each(data, function(i, item){
//                     html += '<option value="'+item.no_inventaris+'">'+item.nama_barang+' ('+item.no_inventaris+')</option>';
//                 });

//                 $('#no_inventaris').html(html);
//             }
//         });

//     } else {
//         $('#no_inventaris').html('<option value="">-- Pilih Barang --</option>');
//     }

// });


// $(document).on('change', '#ruang_asal', function(){

//     var baseURL = mlite.url + '/' + mlite.admin;
//     var url     = baseURL + '/inventaris/getinventarisbyruang?t=' + mlite.token;
//     var id_ruang = $('#ruang_asal').val();

//     if(id_ruang != "") {

//         $.ajax({
//             url: url,
//             method: "POST",
//             data: { id_ruang: id_ruang },
//             dataType: "json", // ← penting
//             success: function(data)
//             {
//                 console.log(data); // debug

//                 var html = '<option value="">-- Pilih Barang --</option>';

//                 $.each(data, function(i, item){
//                     html += '<option value="'+item.no_inventaris+'">'+item.nama_barang+' ('+item.no_inventaris+')</option>';
//                 });

//                 $('#no_inventaris').html(html);
//             },
//             error: function(xhr){
//                 console.log(xhr.responseText);
//             }
//         });

//     } else {
//         $('#no_inventaris').html('<option value="">-- Pilih Barang --</option>');
//     }

// });
$(document).on('change', '#ruang_asal', function(){

    var baseURL = mlite.url + '/' + mlite.admin;
    var url     = baseURL + '/inventaris/inventarisbyruang?t=' + mlite.token;
    var id_ruang = $('#ruang_asal').val();

    if(id_ruang != "") {

        $.ajax({
            url: url,
            method: "POST",
            data: { id_ruang: id_ruang },
            success: function(response)
            {
                $('#no_inventaris').html(response);
            },
            error: function(xhr){
                console.log(xhr.responseText);
            }
        });

    } else {
        $('#no_inventaris').html('<option value="">-- Pilih Barang --</option>');
    }

});

