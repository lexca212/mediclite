$('#bor').on('click', '#submit_periode_rawat_jalan', function(event){
  var baseURL = mlite.url + '/' + mlite.admin;
  event.preventDefault();
  var url    = baseURL + '/data_analys/jisplay?t=' + mlite.token;
  var tgl_awal  = $('input:text[name=tgl_awal]').val();
  var tgl_akhir  = $('input:text[name=tgl_akhir]').val();
  // var poli = $('select[name=poli]').val();
  // var status_periksa = 'Ralan';

  // if(periode_rawat_jalan == '') {
  //   alert('Tanggal awal masih kosong!')
  // }
  // if(periode_rawat_jalan_akhir == '') {
  //   alert('Tanggal akhir masih kosong!')
  // }

  $.post(url, {tgl_awal: tgl_awal, tgl_akhir: tgl_akhir} ,function(data) {
  // tampilkan data
    // $("#form").show();
    $("#display").html(data).show();
    // $("#form_rincian").hide();
    // $("#form_soap").hide();
    // $("#form_sep").hide();
    // $("#notif").hide();
    // $("#rincian").hide();
    // $("#sep").hide();
    // $("#soap").hide();
    //$('.tanggal
    //').datetimepicker('remove');
  });
});
$('#los').on('click', '#submit_periode_rawat_jalan', function(event){
  var baseURL = mlite.url + '/' + mlite.admin;
  event.preventDefault();
  var url    = baseURL + '/data_analys/jisplayLos?t=' + mlite.token;
  var tgl_awal  = $('input:text[name=tgl_awal]').val();
  var tgl_akhir  = $('input:text[name=tgl_akhir]').val();
  // var poli = $('select[name=poli]').val();
  // var status_periksa = 'Ralan';

  // if(periode_rawat_jalan == '') {
  //   alert('Tanggal awal masih kosong!')
  // }
  // if(periode_rawat_jalan_akhir == '') {
  //   alert('Tanggal akhir masih kosong!')
  // }

  $.post(url, {tgl_awal: tgl_awal, tgl_akhir: tgl_akhir} ,function(data) {
  // tampilkan data
    // $("#form").show();
    $("#displaylos").html(data).show();
    // $("#form_rincian").hide();
    // $("#form_soap").hide();
    // $("#form_sep").hide();
    // $("#notif").hide();
    // $("#rincian").hide();
    // $("#sep").hide();
    // $("#soap").hide();
    //$('.tanggal').datetimepicker('remove');
  });
});