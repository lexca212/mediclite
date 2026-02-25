// sembunyikan form dan notif
// $("#form_rincian").hide();
// $("#form_soap").hide();
// $("#form_sep").hide();
// $("#histori_pelayanan").hide();
// $("#notif").hide();
// $('#provider').hide();
// $('#aturan_pakai').hide();
// $('#daftar_racikan').hide();

// $("#display").on("click",".riwayat_perawatan", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();
//   var no_rkm_medis = $(this).attr("data-no_rkm_medis");
//   window.open(baseURL + '/pasien/riwayatperawatan/' + no_rkm_medis + '?t=' + mlite.token);
// });

$('#manage').on('click', '#submit_periode_rawat_jalan, #belum_periode_rawat_jalan', function(event){
  event.preventDefault();

  const baseURL = mlite.url + '/' + mlite.admin;
  const url = baseURL + '/kunjungan_ralan/display?t=' + mlite.token;
  const periode_awal  = $('input:text[name=periode_rawat_jalan]').val();
  const periode_akhir = $('input:text[name=periode_rawat_jalan_akhir]').val();
  const poli = $('select[name=poli]').val();

  // Tentukan status_periksa berdasarkan tombol yang diklik
  const status_periksa = $(this).attr('id') === 'submit_periode_rawat_jalan' ? 'Ralan' : 'Ranap';

  if(periode_awal === '') {
    alert('Tanggal awal masih kosong!');
    return;
  }
  if(periode_akhir === '') {
    alert('Tanggal akhir masih kosong!');
    return;
  }

  $.post(url, {
    periode_rawat_jalan: periode_awal,
    periode_rawat_jalan_akhir: periode_akhir,
    poli: poli,
    status_periksa: status_periksa
  }, function(data) {
    $("#display").html(data).show();
    $('.periode_rawat_jalan').datetimepicker('remove');
  });
});


$(document).ready(function() {
  let kunjunganChart = null;

  // Gabungkan kedua event handler
  $('#manage').on('click', '#submit_periode_rawat_jalan, #belum_periode_rawat_jalan', function(event) {
    event.preventDefault();

    const baseURL = mlite.url + '/' + mlite.admin;
    const url = baseURL + '/kunjungan_ralan/chartdata?t=' + mlite.token;
    const periode_awal = $('input:text[name=periode_rawat_jalan]').val();
    const periode_akhir = $('input:text[name=periode_rawat_jalan_akhir]').val();
    const poli = $('select[name=poli]').val();

    // Tentukan status dan warna berdasarkan tombol
    const isRalan = $(this).attr('id') === 'submit_periode_rawat_jalan';
    const status_periksa = isRalan ? 'Ralan' : 'Ranap';
    const warna_chart = isRalan
      ? 'rgba(54, 162, 235, 0.6)'  // Biru
      : 'rgba(255, 99, 132, 0.6)'; // Merah

    if (!periode_awal || !periode_akhir) {
      alert('Tanggal awal dan akhir wajib diisi!');
      return;
    }

    $.post(url, {
      periode_rawat_jalan: periode_awal,
      periode_rawat_jalan_akhir: periode_akhir,
      poli: poli,
      status_periksa: status_periksa
    }, function(data) {
      // Parse JSON jika masih berbentuk string
      if (typeof data === 'string') {
        try { data = JSON.parse(data); } catch(e) {
          console.error("Invalid JSON:", e);
          return;
        }
      }

      const ctx = document.getElementById('kunjunganChart');
      const label_chart = poli
        ? `Kunjungan Mingguan (${poli}) ${status_periksa.toUpperCase()}`
        : `Jumlah Kunjungan per Poli (${status_periksa.toUpperCase()})`;

      const sub_label_chart = `Periode: ${periode_awal} s.d. ${periode_akhir}`;

      if (kunjunganChart) {
        // Update chart lama
        kunjunganChart.data.labels = data.labels;
        kunjunganChart.data.datasets[0].data = data.values;
        kunjunganChart.data.datasets[0].label = 'Jumlah Kunjungan';
        kunjunganChart.options.plugins.title.text = label_chart;
        kunjunganChart.options.plugins.subtitle.text = sub_label_chart;
        kunjunganChart.data.datasets[0].backgroundColor = warna_chart;
        kunjunganChart.update();
      } else {
        // Buat chart baru
        kunjunganChart = new Chart(ctx, {
          type: 'bar',
          data: {
            labels: data.labels,
            datasets: [{
              label: 'Jumlah Kunjungan',
              data: data.values,
              borderWidth: 1,
              backgroundColor: warna_chart
            }]
          },
          options: {
            plugins: {
              title: {
                display: true,
                text: label_chart,
                font: {
                  size: 16,
                  weight: 'bold'  // <- teks title tebal
                }
              },
              subtitle: {
                display: true,
                text: sub_label_chart,
                font: {
                  size: 12,
                  style: 'italic'
                }
              }
            },
            scales: {
              y: { beginAtZero: true }
            }
          }
        });
      }
    })
    .fail(function(err) {
      console.error('Error:', err);
      alert('Gagal mengambil data chart!');
    });
  });
});

// $('#manage').on('click', '#selesai_periode_rawat_jalan', function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();
//   var url    = baseURL + '/apotek_ralan/display?t=' + mlite.token;
//   var periode_rawat_jalan  = $('input:text[name=periode_rawat_jalan]').val();
//   var periode_rawat_jalan_akhir  = $('input:text[name=periode_rawat_jalan_akhir]').val();
//   var status_periksa = 'selesai';

//   if(periode_rawat_jalan == '') {
//     alert('Tanggal awal masih kosong!')
//   }
//   if(periode_rawat_jalan_akhir == '') {
//     alert('Tanggal akhir masih kosong!')
//   }

//   $.post(url, {periode_rawat_jalan: periode_rawat_jalan, periode_rawat_jalan_akhir: periode_rawat_jalan_akhir, status_periksa: status_periksa} ,function(data) {
//   // tampilkan data
//     $("#form").show();
//     $("#display").html(data).show();
//     $("#form_rincian").hide();
//     $("#form_soap").hide();
//     $("#form_sep").hide();
//     $("#notif").hide();
//     $("#rincian").hide();
//     $("#sep").hide();
//     $("#soap").hide();
//     $('.periode_rawat_jalan').datetimepicker('remove');
//   });

// });

// $('#manage').on('click', '#lunas_periode_rawat_jalan', function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();
//   var url    = baseURL + '/apotek_ralan/display?t=' + mlite.token;
//   var periode_rawat_jalan  = $('input:text[name=periode_rawat_jalan]').val();
//   var periode_rawat_jalan_akhir  = $('input:text[name=periode_rawat_jalan_akhir]').val();
//   var status_periksa = 'lunas';

//   if(periode_rawat_jalan == '') {
//     alert('Tanggal awal masih kosong!')
//   }
//   if(periode_rawat_jalan_akhir == '') {
//     alert('Tanggal akhir masih kosong!')
//   }

//   $.post(url, {periode_rawat_jalan: periode_rawat_jalan, periode_rawat_jalan_akhir: periode_rawat_jalan_akhir, status_periksa: status_periksa} ,function(data) {
//   // tampilkan data
//     $("#form").show();
//     $("#display").html(data).show();
//     $("#form_rincian").hide();
//     $("#form_soap").hide();
//     $("#form_sep").hide();
//     $("#notif").hide();
//     $("#rincian").hide();
//     $("#sep").hide();
//     $("#soap").hide();
//     $('.periode_rawat_jalan').datetimepicker('remove');
//   });

// });

// $("#display").on("click", ".soap", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();

//   var no_rawat = $(this).attr("data-no_rawat");
//   var no_rkm_medis = $(this).attr("data-no_rkm_medis");
//   var nm_pasien = $(this).attr("data-nm_pasien");
//   var tgl_registrasi = $(this).attr("data-tgl_registrasi");

//   $('input:text[name=no_rawat]').val(no_rawat);
//   $('input:text[name=no_rkm_medis]').val(no_rkm_medis);
//   $('input:text[name=nm_pasien]').val(nm_pasien);
//   $('input:text[name=tgl_registrasi]').val(tgl_registrasi);
//   $("#display").hide();

//   var url = baseURL + '/apotek_ralan/soap?t=' + mlite.token;
//   $.post(url, {no_rawat : no_rawat,
//   }, function(data) {
//     // tampilkan data
//     $("#form_rincian").hide();
//     $("#form").hide();
//     $("#notif").hide();
//     $("#form_soap").show();
//     $("#soap").html(data).show();
//   });
// });

// // tombol batal diklik
// $("#form_rincian").on("click", "#selesai", function(event){
//   bersih();
//   $("#form_rincian").hide();
//   $("#form_soap").hide();
//   $("#form").show();
//   $("#display").show();
//   $("#rincian").hide();
//   $("#soap").hide();
// });

// // ketika baris data diklik
// $("#display").on("click", ".layanan_obat", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();

//   var no_rawat = $(this).attr("data-no_rawat");
//   var no_rkm_medis = $(this).attr("data-no_rkm_medis");
//   var nm_pasien = $(this).attr("data-nm_pasien");

//   $('input:text[name=no_rawat]').val(no_rawat);
//   $('input:text[name=no_rkm_medis]').val(no_rkm_medis);
//   $('input:text[name=nm_pasien]').val(nm_pasien);
//   $("#display").hide();

//   var url = baseURL + '/apotek_ralan/rincian?t=' + mlite.token;
//   $.post(url, {no_rawat : no_rawat,
//   }, function(data) {
//     // tampilkan data
//     $("#form_rincian").show();
//     $("#form").hide();
//     $("#notif").hide();
//     $("#rincian").html(data).show();
//   });
// });

// // ketika inputbox pencarian diisi
// $('input:text[name=obat]').on('input',function(e){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   var url    = baseURL + '/apotek_ralan/obat?t=' + mlite.token;
//   var obat = $('input:text[name=obat]').val();

//   if(obat!="") {
//       $.post(url, {obat: obat} ,function(data) {
//       // tampilkan data yang sudah di perbaharui
//         $("#obat").html(data).show();
//         $("#layanan").hide();
//       });
//   }

// });
// // end pencarian

// // ketika baris data diklik
// $("#obat").on("click", ".pilih_obat", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();

//   var kode_brng = $(this).attr("data-kode_brng");
//   var nama_brng = $(this).attr("data-nama_brng");
//   var biaya = $(this).attr("data-dasar");
//   var stok = $(this).attr("data-stok");
//   var stokminimal = $(this).attr("data-stokminimal");
//   var kat = $(this).attr("data-kat");

//   if(stok < stokminimal) {
//     alert('Stok obat ' + nama_brng + ' tidak mencukupi.');
//     $('input:hidden[name=kd_jenis_prw]').val();
//     $('input:text[name=nm_perawatan]').val();
//     $('input:text[name=biaya]').val();
//     $('input:hidden[name=kat]').val();
//   } else {
//     $('input:hidden[name=kd_jenis_prw]').val(kode_brng);
//     $('input:text[name=nm_perawatan]').val(nama_brng);
//     $('input:text[name=biaya]').val(biaya);
//     $('input:hidden[name=kat]').val(kat);
//   }

//   $('#obat').hide();
//   $('#aturan_pakai').show();
//   $('#rawat_jl_dr').show();
// });

// // ketika inputbox pencarian diisi
// $('input:text[name=racikan]').on('input',function(e){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   var url    = baseURL + '/apotek_ralan/racikan?t=' + mlite.token;
//   var racikan = $('input:text[name=racikan]').val();

//   if(racikan!="") {
//       $.post(url, {racikan: racikan} ,function(data) {
//       // tampilkan data yang sudah di perbaharui
//         $("#racikan").html(data).show();
//         $("#obat").hide();
//       });
//   }

// });
// // end pencarian

// // ketika baris data diklik
// $("#racikan").on("click", ".pilih_racikan", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();

//   var kd_racik = $(this).attr("data-kd_racik");
//   var nm_racik = $(this).attr("data-nm_racik");
//   var kat = $(this).attr("data-kat");

//   $('input:hidden[name=kd_jenis_prw]').val(kd_racik);
//   $('input:text[name=nm_perawatan]').val(nm_racik);
//   $('input:text[name=biaya]').val('');
//   $('input:hidden[name=kat]').val(kat);

//   $('#racikan').hide();
//   $('#aturan_pakai').show();
//   $('#daftar_racikan').show();

// });

// $('select').selectator('destroy');
// $('.databarang_ajax').selectator({
//   labels: {
//     search: 'Cari obat...'
//   },
//   load: function (search, callback) {
//     if (search.length < this.minSearchLength) return callback();
//     $.ajax({
//       url: '{?=url()?}/{?=ADMIN?}/dokter_ralan/ajax?show=databarang&nama_brng=' + encodeURIComponent(search) + '&t={?=$_SESSION['token']?}',
//       type: 'GET',
//       dataType: 'json',
//       success: function(data) {
//         callback(data.slice(0, 100));
//         console.log(data);
//       },
//       error: function() {
//         callback();
//       }
//     });
//   },
//   delay: 300,
//   minSearchLength: 1,
//   valueField: 'kode_brng',
//   textField: 'nama_brng'
// });

// // ketika tombol simpan diklik
// $("#form_rincian").on("click", "#simpan_rincian", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();

//   var no_rawat        = $('input:text[name=no_rawat]').val();
//   var kd_jenis_prw 	  = $('input:hidden[name=kd_jenis_prw]').val();
//   var provider        = $('select[name=provider]').val();
//   var kode_provider   = $('input:text[name=kode_provider]').val();
//   var tgl_perawatan   = $('input:text[name=tgl_perawatan]').val();
//   var jam_rawat       = $('input:text[name=jam_rawat]').val();
//   var biaya           = $('input:text[name=biaya]').val();
//   var aturan_pakai    = $('input:text[name=aturan_pakai]').val();
//   var kat             = $('input:hidden[name=kat]').val();
//   var jml             = $('input:text[name=jml]').val();
//   var nama_racik      = $('input:text[name=nama_racik]').val();
//   var keterangan      = $('textarea[name=keterangan]').val();
//   var kode_brng       = JSON.stringify($('select[name=kode_brng]').serializeArray());
//   var kandungan       = JSON.stringify($('input:text[name=kandungan]').serializeArray());

//   console.log(kode_brng);

//   var url = baseURL + '/apotek_ralan/savedetail?t=' + mlite.token;
//   $.post(url, {no_rawat : no_rawat,
//   kd_jenis_prw   : kd_jenis_prw,
//   provider       : provider,
//   kode_provider  : kode_provider,
//   tgl_perawatan  : tgl_perawatan,
//   jam_rawat      : jam_rawat,
//   biaya          : biaya,
//   aturan_pakai   : aturan_pakai,
//   kat            : kat,
//   jml            : jml,
//   nama_racik     : nama_racik,
//   keterangan     : keterangan,
//   kode_brng      : kode_brng,
//   kandungan      : kandungan 
//   }, function(data) {
//     // tampilkan data
//     $("#display").hide();
//     var url = baseURL + '/apotek_ralan/rincian?t=' + mlite.token;
//     $.post(url, {no_rawat : no_rawat,
//     }, function(data) {
//       // tampilkan data
//       $("#rincian").html(data).show();
// $('#manage').on('click', '#selesai_periode_rawat_jalan', function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();
//   var url    = baseURL + '/apotek_ralan/display?t=' + mlite.token;
//   var periode_rawat_jalan  = $('input:text[name=periode_rawat_jalan]').val();
//   var periode_rawat_jalan_akhir  = $('input:text[name=periode_rawat_jalan_akhir]').val();
//   var status_periksa = 'selesai';

//   if(periode_rawat_jalan == '') {
//     alert('Tanggal awal masih kosong!')
//   }
//   if(periode_rawat_jalan_akhir == '') {
//     alert('Tanggal akhir masih kosong!')
//   }

//   $.post(url, {periode_rawat_jalan: periode_rawat_jalan, periode_rawat_jalan_akhir: periode_rawat_jalan_akhir, status_periksa: status_periksa} ,function(data) {
//   // tampilkan data
//     $("#form").show();
//     $("#display").html(data).show();
//     $("#form_rincian").hide();
//     $("#form_soap").hide();
//     $("#form_sep").hide();
//     $("#notif").hide();
//     $("#rincian").hide();
//     $("#sep").hide();
//     $("#soap").hide();
//     $('.periode_rawat_jalan').datetimepicker('remove');
//   });

// });

// $('#manage').on('click', '#lunas_periode_rawat_jalan', function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();
//   var url    = baseURL + '/apotek_ralan/display?t=' + mlite.token;
//   var periode_rawat_jalan  = $('input:text[name=periode_rawat_jalan]').val();
//   var periode_rawat_jalan_akhir  = $('input:text[name=periode_rawat_jalan_akhir]').val();
//   var status_periksa = 'lunas';

//   if(periode_rawat_jalan == '') {
//     alert('Tanggal awal masih kosong!')
//   }
//   if(periode_rawat_jalan_akhir == '') {
//     alert('Tanggal akhir masih kosong!')
//   }

//   $.post(url, {periode_rawat_jalan: periode_rawat_jalan, periode_rawat_jalan_akhir: periode_rawat_jalan_akhir, status_periksa: status_periksa} ,function(data) {
//   // tampilkan data
//     $("#form").show();
//     $("#display").html(data).show();
//     $("#form_rincian").hide();
//     $("#form_soap").hide();
//     $("#form_sep").hide();
//     $("#notif").hide();
//     $("#rincian").hide();
//     $("#sep").hide();
//     $("#soap").hide();
//     $('.periode_rawat_jalan').datetimepicker('remove');
//   });

// });

// $("#display").on("click", ".soap", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();

//   var no_rawat = $(this).attr("data-no_rawat");
//   var no_rkm_medis = $(this).attr("data-no_rkm_medis");
//   var nm_pasien = $(this).attr("data-nm_pasien");
//   var tgl_registrasi = $(this).attr("data-tgl_registrasi");

//   $('input:text[name=no_rawat]').val(no_rawat);
//   $('input:text[name=no_rkm_medis]').val(no_rkm_medis);
//   $('input:text[name=nm_pasien]').val(nm_pasien);
//   $('input:text[name=tgl_registrasi]').val(tgl_registrasi);
//   $("#display").hide();

//   var url = baseURL + '/apotek_ralan/soap?t=' + mlite.token;
//   $.post(url, {no_rawat : no_rawat,
//   }, function(data) {
//     // tampilkan data
//     $("#form_rincian").hide();
//     $("#form").hide();
//     $("#notif").hide();
//     $("#form_soap").show();
//     $("#soap").html(data).show();
//   });
// });

// // tombol batal diklik
// $("#form_rincian").on("click", "#selesai", function(event){
//   bersih();
//   $("#form_rincian").hide();
//   $("#form_soap").hide();
//   $("#form").show();
//   $("#display").show();
//   $("#rincian").hide();
//   $("#soap").hide();
// });

// // ketika baris data diklik
// $("#display").on("click", ".layanan_obat", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();

//   var no_rawat = $(this).attr("data-no_rawat");
//   var no_rkm_medis = $(this).attr("data-no_rkm_medis");
//   var nm_pasien = $(this).attr("data-nm_pasien");

//   $('input:text[name=no_rawat]').val(no_rawat);
//   $('input:text[name=no_rkm_medis]').val(no_rkm_medis);
//   $('input:text[name=nm_pasien]').val(nm_pasien);
//   $("#display").hide();

//   var url = baseURL + '/apotek_ralan/rincian?t=' + mlite.token;
//   $.post(url, {no_rawat : no_rawat,
//   }, function(data) {
//     // tampilkan data
//     $("#form_rincian").show();
//     $("#form").hide();
//     $("#notif").hide();
//     $("#rincian").html(data).show();
//   });
// });

// // ketika inputbox pencarian diisi
// $('input:text[name=obat]').on('input',function(e){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   var url    = baseURL + '/apotek_ralan/obat?t=' + mlite.token;
//   var obat = $('input:text[name=obat]').val();

//   if(obat!="") {
//       $.post(url, {obat: obat} ,function(data) {
//       // tampilkan data yang sudah di perbaharui
//         $("#obat").html(data).show();
//         $("#layanan").hide();
//       });
//   }

// });
// // end pencarian

// // ketika baris data diklik
// $("#obat").on("click", ".pilih_obat", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();

//   var kode_brng = $(this).attr("data-kode_brng");
//   var nama_brng = $(this).attr("data-nama_brng");
//   var biaya = $(this).attr("data-dasar");
//   var stok = $(this).attr("data-stok");
//   var stokminimal = $(this).attr("data-stokminimal");
//   var kat = $(this).attr("data-kat");

//   if(stok < stokminimal) {
//     alert('Stok obat ' + nama_brng + ' tidak mencukupi.');
//     $('input:hidden[name=kd_jenis_prw]').val();
//     $('input:text[name=nm_perawatan]').val();
//     $('input:text[name=biaya]').val();
//     $('input:hidden[name=kat]').val();
//   } else {
//     $('input:hidden[name=kd_jenis_prw]').val(kode_brng);
//     $('input:text[name=nm_perawatan]').val(nama_brng);
//     $('input:text[name=biaya]').val(biaya);
//     $('input:hidden[name=kat]').val(kat);
//   }

//   $('#obat').hide();
//   $('#aturan_pakai').show();
//   $('#rawat_jl_dr').show();
// });

// // ketika inputbox pencarian diisi
// $('input:text[name=racikan]').on('input',function(e){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   var url    = baseURL + '/apotek_ralan/racikan?t=' + mlite.token;
//   var racikan = $('input:text[name=racikan]').val();

//   if(racikan!="") {
//       $.post(url, {racikan: racikan} ,function(data) {
//       // tampilkan data yang sudah di perbaharui
//         $("#racikan").html(data).show();
//         $("#obat").hide();
//       });
//   }

// });
// // end pencarian

// // ketika baris data diklik
// $("#racikan").on("click", ".pilih_racikan", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();

//   var kd_racik = $(this).attr("data-kd_racik");
//   var nm_racik = $(this).attr("data-nm_racik");
//   var kat = $(this).attr("data-kat");

//   $('input:hidden[name=kd_jenis_prw]').val(kd_racik);
//   $('input:text[name=nm_perawatan]').val(nm_racik);
//   $('input:text[name=biaya]').val('');
//   $('input:hidden[name=kat]').val(kat);

//   $('#racikan').hide();
//   $('#aturan_pakai').show();
//   $('#daftar_racikan').show();

// });

// $('select').selectator('destroy');
// $('.databarang_ajax').selectator({
//   labels: {
//     search: 'Cari obat...'
//   },
//   load: function (search, callback) {
//     if (search.length < this.minSearchLength) return callback();
//     $.ajax({
//       url: '{?=url()?}/{?=ADMIN?}/dokter_ralan/ajax?show=databarang&nama_brng=' + encodeURIComponent(search) + '&t={?=$_SESSION['token']?}',
//       type: 'GET',
//       dataType: 'json',
//       success: function(data) {
//         callback(data.slice(0, 100));
//         console.log(data);
//       },
//       error: function() {
//         callback();
//       }
//     });
//   },
//   delay: 300,
//   minSearchLength: 1,
//   valueField: 'kode_brng',
//   textField: 'nama_brng'
// });

// // ketika tombol simpan diklik
// $("#form_rincian").on("click", "#simpan_rincian", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();

//   var no_rawat        = $('input:text[name=no_rawat]').val();
//   var kd_jenis_prw 	  = $('input:hidden[name=kd_jenis_prw]').val();
//   var provider        = $('select[name=provider]').val();
//   var kode_provider   = $('input:text[name=kode_provider]').val();
//   var tgl_perawatan   = $('input:text[name=tgl_perawatan]').val();
//   var jam_rawat       = $('input:text[name=jam_rawat]').val();
//   var biaya           = $('input:text[name=biaya]').val();
//   var aturan_pakai    = $('input:text[name=aturan_pakai]').val();
//   var kat             = $('input:hidden[name=kat]').val();
//   var jml             = $('input:text[name=jml]').val();
//   var nama_racik      = $('input:text[name=nama_racik]').val();
//   var keterangan      = $('textarea[name=keterangan]').val();
//   var kode_brng       = JSON.stringify($('select[name=kode_brng]').serializeArray());
//   var kandungan       = JSON.stringify($('input:text[name=kandungan]').serializeArray());

//   console.log(kode_brng);

//   var url = baseURL + '/apotek_ralan/savedetail?t=' + mlite.token;
//   $.post(url, {no_rawat : no_rawat,
//   kd_jenis_prw   : kd_jenis_prw,
//   provider       : provider,
//   kode_provider  : kode_provider,
//   tgl_perawatan  : tgl_perawatan,
//   jam_rawat      : jam_rawat,
//   biaya          : biaya,
//   aturan_pakai   : aturan_pakai,
//   kat            : kat,
//   jml            : jml,
//   nama_racik     : nama_racik,
//   keterangan     : keterangan,
//   kode_brng      : kode_brng,
//   kandungan      : kandungan 
//   }, function(data) {
//     // tampilkan data
//     $("#display").hide();
//     var url = baseURL + '/apotek_ralan/rincian?t=' + mlite.token;
//     $.post(url, {no_rawat : no_rawat,
//     }, function(data) {
//       // tampilkan data
//       $("#rincian").html(data).show();
//     });
//     $('input:hidden[name=kd_jenis_prw]').val("");
//     $('input:text[name=nm_perawatan]').val("");
//     $('input:hidden[name=kat]').val("");
//     $('input:text[name=biaya]').val("");
//     $('input:text[name=nama_provider]').val("");
//     $('input:text[name=nama_provider2]').val("");
//     $('input:text[name=kode_provider]').val("");
//     $('input:text[name=kode_provider2]').val("");
//     $('#notif').html("<div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\" style=\"border-radius:0px;margin-top:-15px;\">"+
//     "Data pasien telah disimpan!"+
//     "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">&times;</button>"+
//     "</div>").show();
//   });
// });

// // ketika tombol hapus ditekan
// $("#rincian").on("click",".hapus_resep_obat", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();
//   var url = baseURL + '/apotek_ralan/hapusresep?t=' + mlite.token;
//   var no_resep = $(this).attr("data-no_resep");
//   var no_rawat = $(this).attr("data-no_rawat");
//   var tgl_peresepan = $(this).attr("data-tgl_peresepan");
//   var jam_peresepan = $(this).attr("data-jam_peresepan");

//   // tampilkan dialog konfirmasi
//   bootbox.confirm("Apakah Anda yakin ingin menghapus data ini?", function(result){
//     // ketika ditekan tombol ok
//     if (result){
//       // mengirimkan perintah penghapusan
//       $.post(url, {
//         no_resep: no_resep,
//         no_rawat: no_rawat,
//         tgl_peresepan: tgl_peresepan,
//         jam_peresepan: jam_peresepan
//       } ,function(data) {
//         var url = baseURL + '/apotek_ralan/rincian?t=' + mlite.token;
//         $.post(url, {no_rawat : no_rawat,
//         }, function(data) {
//           // tampilkan data
//           $("#rincian").html(data).show();
//         });
//         $('#notif').html("<div class=\"alert alert-danger alert-dismissible fade in\" role=\"alert\" style=\"border-radius:0px;margin-top:-15px;\">"+
//         "Data rincian rawat jalan telah dihapus!"+
//         "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">&times;</button>"+
//         "</div>").show();
//       });
//     }
//   });
// });

// // ketika tombol validasi_resep_obat ditekan
// $("#rincian").on("click",".validasi_resep_obat", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();
//   var url = baseURL + '/apotek_ralan/validasiresep?t=' + mlite.token;
//   var no_resep = $(this).attr("data-no_resep");
//   var no_rawat = $(this).attr("data-no_rawat");
//   var tgl_peresepan = $(this).attr("data-tgl_peresepan");
//   var jam_peresepan = $(this).attr("data-jam_peresepan");
//   var jenis_racikan = $(this).attr("data-racikan");
//   var penyerahan = $(this).attr("data-penyerahan");

//   // tampilkan dialog konfirmasi
//   bootbox.confirm("Apakah Anda yakin ingin menvalidasi/menyerahkan data resep ini?", function(result){
//     // ketika ditekan tombol ok
//     if (result){
//       // mengirimkan perintah penghapusan
//       $.post(url, {
//         no_resep: no_resep,
//         no_rawat: no_rawat,
//         tgl_peresepan: tgl_peresepan,
//         jam_peresepan: jam_peresepan,
//         jenis_racikan: jenis_racikan,
//         penyerahan: penyerahan
//       } ,function(data) {
//         console.log(data);
//         var url = baseURL + '/apotek_ralan/rincian?t=' + mlite.token;
//         $.post(url, {no_rawat : no_rawat,
//         }, function(data) {
//           // tampilkan data
//           $("#rincian").html(data).show();
//         });
//         $('#notif').html("<div class=\"alert alert-danger alert-dismissible fade in\" role=\"alert\" style=\"border-radius:0px;margin-top:-15px;\">"+
//         "Data rincian rawat jalan telah disimpan!"+
//         "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">&times;</button>"+
//         "</div>").show();
//       });
//     }
//   });
// });

// // ketika tombol hapus ditekan
// $("#rincian").on("click",".hapus_resep_dokter", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();
//   var url = baseURL + '/apotek_ralan/hapusresep?t=' + mlite.token;
//   var no_resep = $(this).attr("data-no_resep");
//   var no_rawat = $(this).attr("data-no_rawat");
//   var kd_jenis_prw = $(this).attr("data-kd_jenis_prw");

//   // tampilkan dialog konfirmasi
//   bootbox.confirm("Apakah Anda yakin ingin menghapus data ini?", function(result){
//     // ketika ditekan tombol ok
//     if (result){
//       // mengirimkan perintah penghapusan
//       $.post(url, {
//         no_resep: no_resep,
//         no_rawat: no_rawat,
//         kd_jenis_prw: kd_jenis_prw
//       } ,function(data) {
//         var url = baseURL + '/apotek_ralan/rincian?t=' + mlite.token;
//         $.post(url, {no_rawat : no_rawat,
//         }, function(data) {
//           // tampilkan data
//           $("#rincian").html(data).show();
//         });
//         $('#notif').html("<div class=\"alert alert-danger alert-dismissible fade in\" role=\"alert\" style=\"border-radius:0px;margin-top:-15px;\">"+
//         "Data rincian rawat jalan telah dihapus!"+
//         "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">&times;</button>"+
//         "</div>").show();
//       });
//     }
//   });
// });

// function bersih(){
//   $('input:text[name=no_rawat]').val("");
//   $('input:text[name=no_rkm_medis]').val("");
//   $('input:text[name=nm_pasien]').val("");
//   $('input:text[name=tgl_perawatan]').val("{?=date('Y-m-d')?}");
//   $('input:text[name=tgl_registrasi]').val("{?=date('Y-m-d')?}");
//   $('input:text[name=tgl_lahir]').val("");
//   $('input:text[name=jenis_kelamin]').val("");
//   $('input:text[name=alamat]').val("");
//   $('input:text[name=telepon]').val("");
//   $('input:text[name=pekerjaan]').val("");
//   $('input:text[name=layanan]').val("");
//   $('input:text[name=obat]').val("");
//   $('input:text[name=nama_jenis]').val("");
//   $('input:text[name=jumlah_jual]').attr("disabled", true);
//   $('input:text[name=potongan]').attr("disabled", true);
//   $('input:text[name=harga_jual]').val("");
//   $('input:text[name=total]').val("");
//   $('input:text[name=no_reg]').val("");
// }

//     });
//     $('input:hidden[name=kd_jenis_prw]').val("");
//     $('input:text[name=nm_perawatan]').val("");
//     $('input:hidden[name=kat]').val("");
//     $('input:text[name=biaya]').val("");
//     $('input:text[name=nama_provider]').val("");
//     $('input:text[name=nama_provider2]').val("");
//     $('input:text[name=kode_provider]').val("");
//     $('input:text[name=kode_provider2]').val("");
//     $('#notif').html("<div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\" style=\"border-radius:0px;margin-top:-15px;\">"+
//     "Data pasien telah disimpan!"+
//     "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">&times;</button>"+
//     "</div>").show();
//   });
// });

// // ketika tombol hapus ditekan
// $("#rincian").on("click",".hapus_resep_obat", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();
//   var url = baseURL + '/apotek_ralan/hapusresep?t=' + mlite.token;
//   var no_resep = $(this).attr("data-no_resep");
//   var no_rawat = $(this).attr("data-no_rawat");
//   var tgl_peresepan = $(this).attr("data-tgl_peresepan");
//   var jam_peresepan = $(this).attr("data-jam_peresepan");

//   // tampilkan dialog konfirmasi
//   bootbox.confirm("Apakah Anda yakin ingin menghapus data ini?", function(result){
//     // ketika ditekan tombol ok
//     if (result){
//       // mengirimkan perintah penghapusan
//       $.post(url, {
//         no_resep: no_resep,
//         no_rawat: no_rawat,
//         tgl_peresepan: tgl_peresepan,
//         jam_peresepan: jam_peresepan
//       } ,function(data) {
//         var url = baseURL + '/apotek_ralan/rincian?t=' + mlite.token;
//         $.post(url, {no_rawat : no_rawat,
//         }, function(data) {
//           // tampilkan data
//           $("#rincian").html(data).show();
//         });
//         $('#notif').html("<div class=\"alert alert-danger alert-dismissible fade in\" role=\"alert\" style=\"border-radius:0px;margin-top:-15px;\">"+
//         "Data rincian rawat jalan telah dihapus!"+
//         "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">&times;</button>"+
//         "</div>").show();
//       });
//     }
//   });
// });

// // ketika tombol validasi_resep_obat ditekan
// $("#rincian").on("click",".validasi_resep_obat", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();
//   var url = baseURL + '/apotek_ralan/validasiresep?t=' + mlite.token;
//   var no_resep = $(this).attr("data-no_resep");
//   var no_rawat = $(this).attr("data-no_rawat");
//   var tgl_peresepan = $(this).attr("data-tgl_peresepan");
//   var jam_peresepan = $(this).attr("data-jam_peresepan");
//   var jenis_racikan = $(this).attr("data-racikan");
//   var penyerahan = $(this).attr("data-penyerahan");

//   // tampilkan dialog konfirmasi
//   bootbox.confirm("Apakah Anda yakin ingin menvalidasi/menyerahkan data resep ini?", function(result){
//     // ketika ditekan tombol ok
//     if (result){
//       // mengirimkan perintah penghapusan
//       $.post(url, {
//         no_resep: no_resep,
//         no_rawat: no_rawat,
//         tgl_peresepan: tgl_peresepan,
//         jam_peresepan: jam_peresepan,
//         jenis_racikan: jenis_racikan,
//         penyerahan: penyerahan
//       } ,function(data) {
//         console.log(data);
//         var url = baseURL + '/apotek_ralan/rincian?t=' + mlite.token;
//         $.post(url, {no_rawat : no_rawat,
//         }, function(data) {
//           // tampilkan data
//           $("#rincian").html(data).show();
//         });
//         $('#notif').html("<div class=\"alert alert-danger alert-dismissible fade in\" role=\"alert\" style=\"border-radius:0px;margin-top:-15px;\">"+
//         "Data rincian rawat jalan telah disimpan!"+
//         "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">&times;</button>"+
//         "</div>").show();
//       });
//     }
//   });
// });

// // ketika tombol hapus ditekan
// $("#rincian").on("click",".hapus_resep_dokter", function(event){
//   var baseURL = mlite.url + '/' + mlite.admin;
//   event.preventDefault();
//   var url = baseURL + '/apotek_ralan/hapusresep?t=' + mlite.token;
//   var no_resep = $(this).attr("data-no_resep");
//   var no_rawat = $(this).attr("data-no_rawat");
//   var kd_jenis_prw = $(this).attr("data-kd_jenis_prw");

//   // tampilkan dialog konfirmasi
//   bootbox.confirm("Apakah Anda yakin ingin menghapus data ini?", function(result){
//     // ketika ditekan tombol ok
//     if (result){
//       // mengirimkan perintah penghapusan
//       $.post(url, {
//         no_resep: no_resep,
//         no_rawat: no_rawat,
//         kd_jenis_prw: kd_jenis_prw
//       } ,function(data) {
//         var url = baseURL + '/apotek_ralan/rincian?t=' + mlite.token;
//         $.post(url, {no_rawat : no_rawat,
//         }, function(data) {
//           // tampilkan data
//           $("#rincian").html(data).show();
//         });
//         $('#notif').html("<div class=\"alert alert-danger alert-dismissible fade in\" role=\"alert\" style=\"border-radius:0px;margin-top:-15px;\">"+
//         "Data rincian rawat jalan telah dihapus!"+
//         "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">&times;</button>"+
//         "</div>").show();
//       });
//     }
//   });
// });

// function bersih(){
//   $('input:text[name=no_rawat]').val("");
//   $('input:text[name=no_rkm_medis]').val("");
//   $('input:text[name=nm_pasien]').val("");
//   $('input:text[name=tgl_perawatan]').val("{?=date('Y-m-d')?}");
//   $('input:text[name=tgl_registrasi]').val("{?=date('Y-m-d')?}");
//   $('input:text[name=tgl_lahir]').val("");
//   $('input:text[name=jenis_kelamin]').val("");
//   $('input:text[name=alamat]').val("");
//   $('input:text[name=telepon]').val("");
//   $('input:text[name=pekerjaan]').val("");
//   $('input:text[name=layanan]').val("");
//   $('input:text[name=obat]').val("");
//   $('input:text[name=nama_jenis]').val("");
//   $('input:text[name=jumlah_jual]').attr("disabled", true);
//   $('input:text[name=potongan]').attr("disabled", true);
//   $('input:text[name=harga_jual]').val("");
//   $('input:text[name=total]').val("");
//   $('input:text[name=no_reg]').val("");
// }

$(document).click(function (event) {
    $('.dropdown-menu[data-parent]').hide();
});
$(document).on('click', '.table-responsive [data-toggle="dropdown"]', function () {
    if ($('body').hasClass('modal-open')) {
        throw new Error("This solution is not working inside a responsive table inside a modal, you need to find out a way to calculate the modal Z-index and add it to the element")
        return true;
    }

    $buttonGroup = $(this).parent();
    if (!$buttonGroup.attr('data-attachedUl')) {
        var ts = +new Date;
        $ul = $(this).siblings('ul');
        $ul.attr('data-parent', ts);
        $buttonGroup.attr('data-attachedUl', ts);
        $(window).resize(function () {
            $ul.css('display', 'none').data('top');
        });
    } else {
        $ul = $('[data-parent=' + $buttonGroup.attr('data-attachedUl') + ']');
    }
    if (!$buttonGroup.hasClass('open')) {
        $ul.css('display', 'none');
        return;
    }
    dropDownFixPosition($(this).parent(), $ul);
    function dropDownFixPosition(button, dropdown) {
        var dropDownTop = button.offset().top + button.outerHeight();
        dropdown.css('top', dropDownTop-60 + "px");
        dropdown.css('left', button.offset().left+7 + "px");
        dropdown.css('position', "absolute");

        dropdown.css('width', dropdown.width());
        dropdown.css('heigt', dropdown.height());
        dropdown.css('display', 'block');
        dropdown.appendTo('body');
    }
});

// Hanya cegah event klik di elemen form, bukan tombol submit
$(document).on('click', '.dropdown-menu', function(e) {
    e.stopPropagation();
    $(document).click(function (event) {
      $('.dropdown-menu[data-parent]').hide();
  });
});

// Tutup dropdown ketika tombol di dalam dropdown diklik
$(document).on('click', '#submit_periode_rawat_jalan, #belum_periode_rawat_jalan', function(e) {
  e.preventDefault(); // kalau tombol bukan form submit
  var $btn = $(this);

  // 1) Jika Bootstrap dropdown tersedia, coba close via Bootstrap API dulu
  try {
    var $toggle = $btn.closest('.btn-group').find('[data-toggle="dropdown"]');
    if ($toggle.length && typeof $toggle.dropdown === 'function') {
      // toggle akan menutup dropdown jika open
      $toggle.dropdown('toggle');
      return;
    }
  } catch (err) {
    // ignore, lanjut ke fallback manual
  }

  // 2) Fallback manual: cari ul dropdown terdekat
  var $ul = $btn.closest('.dropdown-menu');

  // 2.a Jika ul tidak ditemukan (mungkin sudah appendTo('body')), gunakan data-attachedUl pada parent
  if ($ul.length === 0) {
    var attached = $btn.closest('.btn-group').attr('data-attachedUl');
    if (attached) {
      $ul = $('[data-parent="' + attached + '"]');
    }
  }

  // 3) Sembunyikan dropdown dan hapus kelas open pada button group
  if ($ul && $ul.length) {
    $ul.hide();
  }
  var $group = $btn.closest('.btn-group');
  if ($group.length) {
    $group.removeClass('open'); // jika kamu pakai kelas open untuk menandai dropdown terbuka
  }

  // 4) Opsional: jika dropdown di-append ke body dan kamu mau mengembalikan ke tempat semula,
  //    cari tombol toggle dan append ul kembali ke dalam buttonGroup (opsional/disarankan kalau diperlukan)
  if ($ul && $ul.length && $group.length && $ul.parent().is('body')) {
    // tempatkan kembali (jaga struktur HTML original)
    $ul.appendTo($group);
    $ul.css({position: '', top: '', left: '', display: 'none'});
  }

  // Jika tombol melakukan tindakan lain, jalankan logika setelah menutup
  // contoh: submit form atau load data via ajax
  // doYourAction();
});

// $.post(url, {periode_rawat_jalan: periode_rawat_jalan, periode_rawat_jalan_akhir: periode_rawat_jalan_akhir, poli: poli, status_periksa: status_periksa} ,function(data) {
//     $("#display").html(data).show();
//     $('.periode_rawat_jalan').datetimepicker('remove');

//     // Panggil fungsi chart
//     loadChart(periode_rawat_jalan, periode_rawat_jalan_akhir, poli, status_periksa);
// });


// $.post(url, {periode_rawat_jalan: periode_rawat_jalan, periode_rawat_jalan_akhir: periode_rawat_jalan_akhir, status_periksa: status_periksa} ,function(data) {
//     $("#display").html(data).show();
//     $('.periode_rawat_jalan').datetimepicker('remove');

//     // Panggil fungsi chart
//     loadChart(periode_rawat_jalan, periode_rawat_jalan_akhir, '', status_periksa);
// });


// {if: $mlite.websocket == 'ya'}

//   {if: $mlite.websocket_proxy != ''}
//     var URL_WEBSOCKET = "{$mlite.websocket_proxy}";
//   {else}
//     var URL_WEBSOCKET = "ws://<?php echo $_SERVER['HTTP_HOST'] ?>:3892";
//   {/if}

//   var ws = new WebSocket(URL_WEBSOCKET);
//   var baseURL = mlite.url + '/' + mlite.admin;
  
//   ws.onmessage = function(response){
//     try{
//       output = JSON.parse(response.data);
//       if(output['action'] == 'simpan'){
//         if(output['modul'] == 'rawat_jalan' || output['modul'] == 'igd'){
//           $("#apotek_ralan #display").show().load(baseURL + '/apotek_ralan/display?t=' + mlite.token);
//         }
//       }
//       if(output['action'] == 'permintaan_resep'){
//         if(output['modul'] == 'dokter_ralan'){
//           var audio = new Audio('{?=url()?}/assets/sound/alarm.mp3');
//           audio.play();    
//         }
//       }
//     }catch(e){
//       console.log(e);
//     }
//   }
  
  
//   ws.onclose = function(){
//     // Jika terputus dari websocket server, maka mencoba terhubung kembali.
//     var interval_reconnect_ws = setInterval(function(){
//       if(ws.readyState != 0){
//         if(ws.readyState == 1){ // readyState = 1 (Open) , berarti sudah terhubung dengan websocket. Maka gak perlu interval lagi.
//           clearInterval(interval_reconnect_ws);
//         }else{
//           ws = new WebSocket(URL_WEBSOCKET);	
//         }
//       }
      
//     },5000);
//   }   

// {/if}