jQuery().ready(function () {
    var var_tbl_bridging_sep = $('#tbl_bridging_sep').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'dom': 'Bfrtip',
        'searching': false,
        'select': true,
        'colReorder': true,
        "bInfo" : false,
        "ajax": {
            "url": "{?=url([ADMIN,'data_sep','data'])?}",
            "dataType": "json",
            "type": "POST",
            "data": function (data) {

                // Read values
                var search_field_bridging_sep = $('#search_field_bridging_sep').val();
                var search_text_bridging_sep = $('#search_text_bridging_sep').val();
                
                data.search_field_bridging_sep = search_field_bridging_sep;
                data.search_text_bridging_sep = search_text_bridging_sep;
                
            }
        },
        "columns": [
{ 'data': 'no_sep' },
{ 'data': 'no_rawat' },
{ 'data': 'tglsep' },
{ 'data': 'tglrujukan' },
{ 'data': 'no_rujukan' },
{ 'data': 'kdppkrujukan' },
{ 'data': 'nmppkrujukan' },
{ 'data': 'kdppkpelayanan' },
{ 'data': 'nmppkpelayanan' },
{ 'data': 'jnspelayanan' },
{ 'data': 'catatan' },
{ 'data': 'diagawal' },
{ 'data': 'nmdiagnosaawal' },
{ 'data': 'kdpolitujuan' },
{ 'data': 'nmpolitujuan' },
{ 'data': 'klsrawat' },
{ 'data': 'klsnaik' },
{ 'data': 'pembiayaan' },
{ 'data': 'pjnaikkelas' },
{ 'data': 'lakalantas' },
{ 'data': 'user' },
{ 'data': 'nomr' },
{ 'data': 'nama_pasien' },
{ 'data': 'tanggal_lahir' },
{ 'data': 'peserta' },
{ 'data': 'jkel' },
{ 'data': 'no_kartu' },
{ 'data': 'tglpulang' },
{ 'data': 'asal_rujukan' },
{ 'data': 'eksekutif' },
{ 'data': 'cob' },
{ 'data': 'notelep' },
{ 'data': 'katarak' },
{ 'data': 'tglkkl' },
{ 'data': 'keterangankkl' },
{ 'data': 'suplesi' },
{ 'data': 'no_sep_suplesi' },
{ 'data': 'kdprop' },
{ 'data': 'nmprop' },
{ 'data': 'kdkab' },
{ 'data': 'nmkab' },
{ 'data': 'kdkec' },
{ 'data': 'nmkec' },
{ 'data': 'noskdp' },
{ 'data': 'kddpjp' },
{ 'data': 'nmdpdjp' },
{ 'data': 'tujuankunjungan' },
{ 'data': 'flagprosedur' },
{ 'data': 'penunjang' },
{ 'data': 'asesmenpelayanan' },
{ 'data': 'kddpjplayanan' },
{ 'data': 'nmdpjplayanan' }

        ],
        "columnDefs": [
{ 'targets': 0},
{ 'targets': 1},
{ 'targets': 2},
{ 'targets': 3},
{ 'targets': 4},
{ 'targets': 5},
{ 'targets': 6},
{ 'targets': 7},
{ 'targets': 8},
{ 'targets': 9},
{ 'targets': 10},
{ 'targets': 11},
{ 'targets': 12},
{ 'targets': 13},
{ 'targets': 14},
{ 'targets': 15},
{ 'targets': 16},
{ 'targets': 17},
{ 'targets': 18},
{ 'targets': 19},
{ 'targets': 20},
{ 'targets': 21},
{ 'targets': 22},
{ 'targets': 23},
{ 'targets': 24},
{ 'targets': 25},
{ 'targets': 26},
{ 'targets': 27},
{ 'targets': 28},
{ 'targets': 29},
{ 'targets': 30},
{ 'targets': 31},
{ 'targets': 32},
{ 'targets': 33},
{ 'targets': 34},
{ 'targets': 35},
{ 'targets': 36},
{ 'targets': 37},
{ 'targets': 38},
{ 'targets': 39},
{ 'targets': 40},
{ 'targets': 41},
{ 'targets': 42},
{ 'targets': 43},
{ 'targets': 44},
{ 'targets': 45},
{ 'targets': 46},
{ 'targets': 47},
{ 'targets': 48},
{ 'targets': 49},
{ 'targets': 50},
{ 'targets': 51}

        ],
        buttons: [],
        "scrollCollapse": true,
        // "scrollY": '48vh', 
        "pageLength":'25', 
        "lengthChange": true,
        "scrollX": true,
        dom: "<'row'<'col-sm-12'tr>><<'pmd-datatable-pagination' l i p>>"
    });

    // ==============================================================
    // FORM VALIDASI
    // ==============================================================

    $("form[name='form_bridging_sep']").validate({
        rules: {
no_sep: 'required',
no_rawat: 'required',
tglsep: 'required',
tglrujukan: 'required',
no_rujukan: 'required',
kdppkrujukan: 'required',
nmppkrujukan: 'required',
kdppkpelayanan: 'required',
nmppkpelayanan: 'required',
jnspelayanan: 'required',
catatan: 'required',
diagawal: 'required',
nmdiagnosaawal: 'required',
kdpolitujuan: 'required',
nmpolitujuan: 'required',
klsrawat: 'required',
klsnaik: 'required',
pembiayaan: 'required',
pjnaikkelas: 'required',
lakalantas: 'required',
user: 'required',
nomr: 'required',
nama_pasien: 'required',
tanggal_lahir: 'required',
peserta: 'required',
jkel: 'required',
no_kartu: 'required',
tglpulang: 'required',
asal_rujukan: 'required',
eksekutif: 'required',
cob: 'required',
notelep: 'required',
katarak: 'required',
tglkkl: 'required',
keterangankkl: 'required',
suplesi: 'required',
no_sep_suplesi: 'required',
kdprop: 'required',
nmprop: 'required',
kdkab: 'required',
nmkab: 'required',
kdkec: 'required',
nmkec: 'required',
noskdp: 'required',
kddpjp: 'required',
nmdpdjp: 'required',
tujuankunjungan: 'required',
flagprosedur: 'required',
penunjang: 'required',
asesmenpelayanan: 'required',
kddpjplayanan: 'required',
nmdpjplayanan: 'required'

        },
        messages: {
no_sep:'no_sep tidak boleh kosong!',
no_rawat:'no_rawat tidak boleh kosong!',
tglsep:'tglsep tidak boleh kosong!',
tglrujukan:'tglrujukan tidak boleh kosong!',
no_rujukan:'no_rujukan tidak boleh kosong!',
kdppkrujukan:'kdppkrujukan tidak boleh kosong!',
nmppkrujukan:'nmppkrujukan tidak boleh kosong!',
kdppkpelayanan:'kdppkpelayanan tidak boleh kosong!',
nmppkpelayanan:'nmppkpelayanan tidak boleh kosong!',
jnspelayanan:'jnspelayanan tidak boleh kosong!',
catatan:'catatan tidak boleh kosong!',
diagawal:'diagawal tidak boleh kosong!',
nmdiagnosaawal:'nmdiagnosaawal tidak boleh kosong!',
kdpolitujuan:'kdpolitujuan tidak boleh kosong!',
nmpolitujuan:'nmpolitujuan tidak boleh kosong!',
klsrawat:'klsrawat tidak boleh kosong!',
klsnaik:'klsnaik tidak boleh kosong!',
pembiayaan:'pembiayaan tidak boleh kosong!',
pjnaikkelas:'pjnaikkelas tidak boleh kosong!',
lakalantas:'lakalantas tidak boleh kosong!',
user:'user tidak boleh kosong!',
nomr:'nomr tidak boleh kosong!',
nama_pasien:'nama_pasien tidak boleh kosong!',
tanggal_lahir:'tanggal_lahir tidak boleh kosong!',
peserta:'peserta tidak boleh kosong!',
jkel:'jkel tidak boleh kosong!',
no_kartu:'no_kartu tidak boleh kosong!',
tglpulang:'tglpulang tidak boleh kosong!',
asal_rujukan:'asal_rujukan tidak boleh kosong!',
eksekutif:'eksekutif tidak boleh kosong!',
cob:'cob tidak boleh kosong!',
notelep:'notelep tidak boleh kosong!',
katarak:'katarak tidak boleh kosong!',
tglkkl:'tglkkl tidak boleh kosong!',
keterangankkl:'keterangankkl tidak boleh kosong!',
suplesi:'suplesi tidak boleh kosong!',
no_sep_suplesi:'no_sep_suplesi tidak boleh kosong!',
kdprop:'kdprop tidak boleh kosong!',
nmprop:'nmprop tidak boleh kosong!',
kdkab:'kdkab tidak boleh kosong!',
nmkab:'nmkab tidak boleh kosong!',
kdkec:'kdkec tidak boleh kosong!',
nmkec:'nmkec tidak boleh kosong!',
noskdp:'noskdp tidak boleh kosong!',
kddpjp:'kddpjp tidak boleh kosong!',
nmdpdjp:'nmdpdjp tidak boleh kosong!',
tujuankunjungan:'tujuankunjungan tidak boleh kosong!',
flagprosedur:'flagprosedur tidak boleh kosong!',
penunjang:'penunjang tidak boleh kosong!',
asesmenpelayanan:'asesmenpelayanan tidak boleh kosong!',
kddpjplayanan:'kddpjplayanan tidak boleh kosong!',
nmdpjplayanan:'nmdpjplayanan tidak boleh kosong!'

        },
        submitHandler: function (form) {
 var no_sep= $('#no_sep').val();
var no_rawat= $('#no_rawat').val();
var tglsep= $('#tglsep').val();
var tglrujukan= $('#tglrujukan').val();
var no_rujukan= $('#no_rujukan').val();
var kdppkrujukan= $('#kdppkrujukan').val();
var nmppkrujukan= $('#nmppkrujukan').val();
var kdppkpelayanan= $('#kdppkpelayanan').val();
var nmppkpelayanan= $('#nmppkpelayanan').val();
var jnspelayanan= $('#jnspelayanan').val();
var catatan= $('#catatan').val();
var diagawal= $('#diagawal').val();
var nmdiagnosaawal= $('#nmdiagnosaawal').val();
var kdpolitujuan= $('#kdpolitujuan').val();
var nmpolitujuan= $('#nmpolitujuan').val();
var klsrawat= $('#klsrawat').val();
var klsnaik= $('#klsnaik').val();
var pembiayaan= $('#pembiayaan').val();
var pjnaikkelas= $('#pjnaikkelas').val();
var lakalantas= $('#lakalantas').val();
var user= $('#user').val();
var nomr= $('#nomr').val();
var nama_pasien= $('#nama_pasien').val();
var tanggal_lahir= $('#tanggal_lahir').val();
var peserta= $('#peserta').val();
var jkel= $('#jkel').val();
var no_kartu= $('#no_kartu').val();
var tglpulang= $('#tglpulang').val();
var asal_rujukan= $('#asal_rujukan').val();
var eksekutif= $('#eksekutif').val();
var cob= $('#cob').val();
var notelep= $('#notelep').val();
var katarak= $('#katarak').val();
var tglkkl= $('#tglkkl').val();
var keterangankkl= $('#keterangankkl').val();
var suplesi= $('#suplesi').val();
var no_sep_suplesi= $('#no_sep_suplesi').val();
var kdprop= $('#kdprop').val();
var nmprop= $('#nmprop').val();
var kdkab= $('#kdkab').val();
var nmkab= $('#nmkab').val();
var kdkec= $('#kdkec').val();
var nmkec= $('#nmkec').val();
var noskdp= $('#noskdp').val();
var kddpjp= $('#kddpjp').val();
var nmdpdjp= $('#nmdpdjp').val();
var tujuankunjungan= $('#tujuankunjungan').val();
var flagprosedur= $('#flagprosedur').val();
var penunjang= $('#penunjang').val();
var asesmenpelayanan= $('#asesmenpelayanan').val();
var kddpjplayanan= $('#kddpjplayanan').val();
var nmdpjplayanan= $('#nmdpjplayanan').val();

 var typeact = $('#typeact').val();

 var formData = new FormData(form); // tambahan
 formData.append('typeact', typeact); // tambahan

            $.ajax({
                url: "{?=url([ADMIN,'data_sep','aksi'])?}",
                method: "POST",
                contentType: false, // tambahan
                processData: false, // tambahan
                data: formData,
                success: function (data) {
                    if (typeact == "add") {
                        alert("Data Berhasil Ditambah");
                    }
                    else if (typeact == "edit") {
                        alert("Data Berhasil Diubah");
                    }
                    $("#modal_cs").hide();
                    location.reload(true);
                }
            })
        }
    });

    // ==============================================================
    // KETIKA MENGETIK DI INPUT SEARCH
    // ==============================================================
    $('#search_text_bridging_sep').keyup(function () {
        var_tbl_bridging_sep.draw();
    });
    // ==============================================================
    // CLICK TANDA X DI INPUT SEARCH
    // ==============================================================
    $("#searchclear_bridging_sep").click(function () {
        $("#search_text_bridging_sep").val("");
        var_tbl_bridging_sep.draw();
    });

    // ===========================================
    // Ketika tombol Edit di tekan
    // ===========================================

    $("#edit_data_bridging_sep").click(function () {
        var rowData = var_tbl_bridging_sep.rows({ selected: true }).data()[0];
        if (rowData != null) {

            var no_sep = rowData['no_sep'];
var no_rawat = rowData['no_rawat'];
var tglsep = rowData['tglsep'];
var tglrujukan = rowData['tglrujukan'];
var no_rujukan = rowData['no_rujukan'];
var kdppkrujukan = rowData['kdppkrujukan'];
var nmppkrujukan = rowData['nmppkrujukan'];
var kdppkpelayanan = rowData['kdppkpelayanan'];
var nmppkpelayanan = rowData['nmppkpelayanan'];
var jnspelayanan = rowData['jnspelayanan'];
var catatan = rowData['catatan'];
var diagawal = rowData['diagawal'];
var nmdiagnosaawal = rowData['nmdiagnosaawal'];
var kdpolitujuan = rowData['kdpolitujuan'];
var nmpolitujuan = rowData['nmpolitujuan'];
var klsrawat = rowData['klsrawat'];
var klsnaik = rowData['klsnaik'];
var pembiayaan = rowData['pembiayaan'];
var pjnaikkelas = rowData['pjnaikkelas'];
var lakalantas = rowData['lakalantas'];
var user = rowData['user'];
var nomr = rowData['nomr'];
var nama_pasien = rowData['nama_pasien'];
var tanggal_lahir = rowData['tanggal_lahir'];
var peserta = rowData['peserta'];
var jkel = rowData['jkel'];
var no_kartu = rowData['no_kartu'];
var tglpulang = rowData['tglpulang'];
var asal_rujukan = rowData['asal_rujukan'];
var eksekutif = rowData['eksekutif'];
var cob = rowData['cob'];
var notelep = rowData['notelep'];
var katarak = rowData['katarak'];
var tglkkl = rowData['tglkkl'];
var keterangankkl = rowData['keterangankkl'];
var suplesi = rowData['suplesi'];
var no_sep_suplesi = rowData['no_sep_suplesi'];
var kdprop = rowData['kdprop'];
var nmprop = rowData['nmprop'];
var kdkab = rowData['kdkab'];
var nmkab = rowData['nmkab'];
var kdkec = rowData['kdkec'];
var nmkec = rowData['nmkec'];
var noskdp = rowData['noskdp'];
var kddpjp = rowData['kddpjp'];
var nmdpdjp = rowData['nmdpdjp'];
var tujuankunjungan = rowData['tujuankunjungan'];
var flagprosedur = rowData['flagprosedur'];
var penunjang = rowData['penunjang'];
var asesmenpelayanan = rowData['asesmenpelayanan'];
var kddpjplayanan = rowData['kddpjplayanan'];
var nmdpjplayanan = rowData['nmdpjplayanan'];



            $("#typeact").val("edit");
  
            $('#no_sep').val(no_sep);
$('#no_rawat').val(no_rawat);
$('#tglsep').val(tglsep);
$('#tglrujukan').val(tglrujukan);
$('#no_rujukan').val(no_rujukan);
$('#kdppkrujukan').val(kdppkrujukan);
$('#nmppkrujukan').val(nmppkrujukan);
$('#kdppkpelayanan').val(kdppkpelayanan);
$('#nmppkpelayanan').val(nmppkpelayanan);
$('#jnspelayanan').val(jnspelayanan);
$('#catatan').val(catatan);
$('#diagawal').val(diagawal);
$('#nmdiagnosaawal').val(nmdiagnosaawal);
$('#kdpolitujuan').val(kdpolitujuan);
$('#nmpolitujuan').val(nmpolitujuan);
$('#klsrawat').val(klsrawat);
$('#klsnaik').val(klsnaik);
$('#pembiayaan').val(pembiayaan);
$('#pjnaikkelas').val(pjnaikkelas);
$('#lakalantas').val(lakalantas);
$('#user').val(user);
$('#nomr').val(nomr);
$('#nama_pasien').val(nama_pasien);
$('#tanggal_lahir').val(tanggal_lahir);
$('#peserta').val(peserta);
$('#jkel').val(jkel);
$('#no_kartu').val(no_kartu);
$('#tglpulang').val(tglpulang);
$('#asal_rujukan').val(asal_rujukan);
$('#eksekutif').val(eksekutif);
$('#cob').val(cob);
$('#notelep').val(notelep);
$('#katarak').val(katarak);
$('#tglkkl').val(tglkkl);
$('#keterangankkl').val(keterangankkl);
$('#suplesi').val(suplesi);
$('#no_sep_suplesi').val(no_sep_suplesi);
$('#kdprop').val(kdprop);
$('#nmprop').val(nmprop);
$('#kdkab').val(kdkab);
$('#nmkab').val(nmkab);
$('#kdkec').val(kdkec);
$('#nmkec').val(nmkec);
$('#noskdp').val(noskdp);
$('#kddpjp').val(kddpjp);
$('#nmdpdjp').val(nmdpdjp);
$('#tujuankunjungan').val(tujuankunjungan);
$('#flagprosedur').val(flagprosedur);
$('#penunjang').val(penunjang);
$('#asesmenpelayanan').val(asesmenpelayanan);
$('#kddpjplayanan').val(kddpjplayanan);
$('#nmdpjplayanan').val(nmdpjplayanan);

            //$("#no_sep").prop('disabled', true); // GA BISA DIEDIT KALI DISABLE
            $('#modal-title').text("Edit Data Data SEP");
            $("#modal_bridging_sep").modal();
        }
        else {
            alert("Silakan pilih data yang akan di edit.");
        }

    });

    // ==============================================================
    // TOMBOL  DELETE DI CLICK
    // ==============================================================
    jQuery("#hapus_data_bridging_sep").click(function () {
        var rowData = var_tbl_bridging_sep.rows({ selected: true }).data()[0];


        if (rowData) {
var no_sep = rowData['no_sep'];
            var a = confirm("Anda yakin akan menghapus data dengan no_sep=" + no_sep);
            if (a) {

                $.ajax({
                    url: "{?=url([ADMIN,'data_sep','aksi'])?}",
                    method: "POST",
                    data: {
                        no_sep: no_sep,
                        typeact: 'del'
                    },
                    success: function (data) {
                        data = JSON.parse(data);
                        if(data.status === 'success') {
                            alert(data.msg);
                        } else {
                            alert(data.msg);
                        }
                        location.reload(true);
                    }
                })
            }
        }
        else {
            alert("Pilih satu baris untuk dihapus");
        }
    });

    // ==============================================================
    // TOMBOL TAMBAH DATA DI CLICK
    // ==============================================================
    jQuery("#tambah_data_bridging_sep").click(function () {

        $('#no_sep').val('');
$('#no_rawat').val('');
$('#tglsep').val('');
$('#tglrujukan').val('');
$('#no_rujukan').val('');
$('#kdppkrujukan').val('');
$('#nmppkrujukan').val('');
$('#kdppkpelayanan').val('');
$('#nmppkpelayanan').val('');
$('#jnspelayanan').val('');
$('#catatan').val('');
$('#diagawal').val('');
$('#nmdiagnosaawal').val('');
$('#kdpolitujuan').val('');
$('#nmpolitujuan').val('');
$('#klsrawat').val('');
$('#klsnaik').val('');
$('#pembiayaan').val('');
$('#pjnaikkelas').val('');
$('#lakalantas').val('');
$('#user').val('');
$('#nomr').val('');
$('#nama_pasien').val('');
$('#tanggal_lahir').val('');
$('#peserta').val('');
$('#jkel').val('');
$('#no_kartu').val('');
$('#tglpulang').val('');
$('#asal_rujukan').val('');
$('#eksekutif').val('');
$('#cob').val('');
$('#notelep').val('');
$('#katarak').val('');
$('#tglkkl').val('');
$('#keterangankkl').val('');
$('#suplesi').val('');
$('#no_sep_suplesi').val('');
$('#kdprop').val('');
$('#nmprop').val('');
$('#kdkab').val('');
$('#nmkab').val('');
$('#kdkec').val('');
$('#nmkec').val('');
$('#noskdp').val('');
$('#kddpjp').val('');
$('#nmdpdjp').val('');
$('#tujuankunjungan').val('');
$('#flagprosedur').val('');
$('#penunjang').val('');
$('#asesmenpelayanan').val('');
$('#kddpjplayanan').val('');
$('#nmdpjplayanan').val('');


        $("#typeact").val("add");
        $("#no_sep").prop('disabled', false);
        
        $('#modal-title').text("Tambah Data Data SEP");
        $("#modal_bridging_sep").modal();
    });

    // ===========================================
    // Ketika tombol lihat data di tekan
    // ===========================================
    $("#lihat_data_bridging_sep").click(function () {

        var search_field_bridging_sep = $('#search_field_bridging_sep').val();
        var search_text_bridging_sep = $('#search_text_bridging_sep').val();

        $.ajax({
            url: "{?=url([ADMIN,'data_sep','aksi'])?}",
            method: "POST",
            data: {
                typeact: 'lihat', 
                search_field_bridging_sep: search_field_bridging_sep, 
                search_text_bridging_sep: search_text_bridging_sep
            },
            dataType: 'json',
            success: function (res) {
                var eTable = "<div class='table-responsive'><table id='tbl_lihat_bridging_sep' class='table display dataTable' style='width:100%'><thead><th>No Sep</th><th>No Rawat</th><th>Tglsep</th><th>Tglrujukan</th><th>No Rujukan</th><th>Kdppkrujukan</th><th>Nmppkrujukan</th><th>Kdppkpelayanan</th><th>Nmppkpelayanan</th><th>Jnspelayanan</th><th>Catatan</th><th>Diagawal</th><th>Nmdiagnosaawal</th><th>Kdpolitujuan</th><th>Nmpolitujuan</th><th>Klsrawat</th><th>Klsnaik</th><th>Pembiayaan</th><th>Pjnaikkelas</th><th>Lakalantas</th><th>User</th><th>Nomr</th><th>Nama Pasien</th><th>Tanggal Lahir</th><th>Peserta</th><th>Jkel</th><th>No Kartu</th><th>Tglpulang</th><th>Asal Rujukan</th><th>Eksekutif</th><th>Cob</th><th>Notelep</th><th>Katarak</th><th>Tglkkl</th><th>Keterangankkl</th><th>Suplesi</th><th>No Sep Suplesi</th><th>Kdprop</th><th>Nmprop</th><th>Kdkab</th><th>Nmkab</th><th>Kdkec</th><th>Nmkec</th><th>Noskdp</th><th>Kddpjp</th><th>Nmdpdjp</th><th>Tujuankunjungan</th><th>Flagprosedur</th><th>Penunjang</th><th>Asesmenpelayanan</th><th>Kddpjplayanan</th><th>Nmdpjplayanan</th></thead>";
                for (var i = 0; i < res.length; i++) {
                    eTable += "<tr>";
                    eTable += '<td>' + res[i]['no_sep'] + '</td>';
eTable += '<td>' + res[i]['no_rawat'] + '</td>';
eTable += '<td>' + res[i]['tglsep'] + '</td>';
eTable += '<td>' + res[i]['tglrujukan'] + '</td>';
eTable += '<td>' + res[i]['no_rujukan'] + '</td>';
eTable += '<td>' + res[i]['kdppkrujukan'] + '</td>';
eTable += '<td>' + res[i]['nmppkrujukan'] + '</td>';
eTable += '<td>' + res[i]['kdppkpelayanan'] + '</td>';
eTable += '<td>' + res[i]['nmppkpelayanan'] + '</td>';
eTable += '<td>' + res[i]['jnspelayanan'] + '</td>';
eTable += '<td>' + res[i]['catatan'] + '</td>';
eTable += '<td>' + res[i]['diagawal'] + '</td>';
eTable += '<td>' + res[i]['nmdiagnosaawal'] + '</td>';
eTable += '<td>' + res[i]['kdpolitujuan'] + '</td>';
eTable += '<td>' + res[i]['nmpolitujuan'] + '</td>';
eTable += '<td>' + res[i]['klsrawat'] + '</td>';
eTable += '<td>' + res[i]['klsnaik'] + '</td>';
eTable += '<td>' + res[i]['pembiayaan'] + '</td>';
eTable += '<td>' + res[i]['pjnaikkelas'] + '</td>';
eTable += '<td>' + res[i]['lakalantas'] + '</td>';
eTable += '<td>' + res[i]['user'] + '</td>';
eTable += '<td>' + res[i]['nomr'] + '</td>';
eTable += '<td>' + res[i]['nama_pasien'] + '</td>';
eTable += '<td>' + res[i]['tanggal_lahir'] + '</td>';
eTable += '<td>' + res[i]['peserta'] + '</td>';
eTable += '<td>' + res[i]['jkel'] + '</td>';
eTable += '<td>' + res[i]['no_kartu'] + '</td>';
eTable += '<td>' + res[i]['tglpulang'] + '</td>';
eTable += '<td>' + res[i]['asal_rujukan'] + '</td>';
eTable += '<td>' + res[i]['eksekutif'] + '</td>';
eTable += '<td>' + res[i]['cob'] + '</td>';
eTable += '<td>' + res[i]['notelep'] + '</td>';
eTable += '<td>' + res[i]['katarak'] + '</td>';
eTable += '<td>' + res[i]['tglkkl'] + '</td>';
eTable += '<td>' + res[i]['keterangankkl'] + '</td>';
eTable += '<td>' + res[i]['suplesi'] + '</td>';
eTable += '<td>' + res[i]['no_sep_suplesi'] + '</td>';
eTable += '<td>' + res[i]['kdprop'] + '</td>';
eTable += '<td>' + res[i]['nmprop'] + '</td>';
eTable += '<td>' + res[i]['kdkab'] + '</td>';
eTable += '<td>' + res[i]['nmkab'] + '</td>';
eTable += '<td>' + res[i]['kdkec'] + '</td>';
eTable += '<td>' + res[i]['nmkec'] + '</td>';
eTable += '<td>' + res[i]['noskdp'] + '</td>';
eTable += '<td>' + res[i]['kddpjp'] + '</td>';
eTable += '<td>' + res[i]['nmdpdjp'] + '</td>';
eTable += '<td>' + res[i]['tujuankunjungan'] + '</td>';
eTable += '<td>' + res[i]['flagprosedur'] + '</td>';
eTable += '<td>' + res[i]['penunjang'] + '</td>';
eTable += '<td>' + res[i]['asesmenpelayanan'] + '</td>';
eTable += '<td>' + res[i]['kddpjplayanan'] + '</td>';
eTable += '<td>' + res[i]['nmdpjplayanan'] + '</td>';
                    eTable += "</tr>";
                }
                eTable += "</tbody></table></div>";
                $('#forTable_bridging_sep').html(eTable);
            }
        });

        $('#modal-title').text("Lihat Data");
        $("#modal_lihat_bridging_sep").modal();
    });

    // ==============================================================
    // TOMBOL DETAIL bridging_sep DI CLICK
    // ==============================================================
    jQuery("#lihat_detail_bridging_sep").click(function (event) {

        var rowData = var_tbl_bridging_sep.rows({ selected: true }).data()[0];

        if (rowData) {
var no_sep = rowData['no_sep'];
            var baseURL = mlite.url + '/' + mlite.admin;
            event.preventDefault();
            var loadURL =  baseURL + '/data_sep/detail/' + no_sep + '?t=' + mlite.token;
        
            var modal = $('#modal_detail_bridging_sep');
            var modalContent = $('#modal_detail_bridging_sep .modal-content');
        
            modal.off('show.bs.modal');
            modal.on('show.bs.modal', function () {
                modalContent.load(loadURL);
            }).modal();
            return false;
        
        }
        else {
            alert("Pilih satu baris untuk detail");
        }
    });
        
    // ===========================================
    // Ketika tombol export pdf di tekan
    // ===========================================
    $("#export_pdf").click(function () {

        var doc = new jsPDF('p', 'pt', 'A4'); /* pilih 'l' atau 'p' */
        var img = "{?=base64_encode(file_get_contents(url($settings['logo'])))?}";
        doc.addImage(img, 'JPEG', 20, 10, 50, 50);
        doc.setFontSize(20);
        doc.text("{$settings.nama_instansi}", 80, 35, null, null, null);
        doc.setFontSize(10);
        doc.text("{$settings.alamat} - {$settings.kota} - {$settings.propinsi}", 80, 46, null, null, null);
        doc.text("Telepon: {$settings.nomor_telepon} - Email: {$settings.email}", 80, 56, null, null, null);
        doc.line(20,70,572,70,null); /* doc.line(20,70,820,70,null); --> Jika landscape */
        doc.line(20,72,572,72,null); /* doc.line(20,72,820,72,null); --> Jika landscape */
        doc.setFontSize(14);
        doc.text("Tabel Data Bridging Sep", 20, 95, null, null, null);
        const totalPagesExp = "{total_pages_count_string}";        
        doc.autoTable({
            html: '#tbl_lihat_bridging_sep',
            startY: 105,
            margin: {
                left: 20, 
                right: 20
            }, 
            styles: {
                fontSize: 10,
                cellPadding: 5
            }, 
            didDrawPage: data => {
                let footerStr = "Page " + doc.internal.getNumberOfPages();
                if (typeof doc.putTotalPages === 'function') {
                footerStr = footerStr + " of " + totalPagesExp;
                }
                doc.setFontSize(10);
                doc.text(footerStr, data.settings.margin.left, doc.internal.pageSize.height - 10);
           }
        });
        if (typeof doc.putTotalPages === 'function') {
            doc.putTotalPages(totalPagesExp);
        }
        // doc.save('table_data_bridging_sep.pdf')
        window.open(doc.output('bloburl'), '_blank',"toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes");  
              
    })

    // ===========================================
    // Ketika tombol export xlsx di tekan
    // ===========================================
    $("#export_xlsx").click(function () {
        let tbl1 = document.getElementById("tbl_lihat_bridging_sep");
        let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
        let a = XLSX.utils.sheet_to_json(worksheet_tmp1, { header: 1 });
        let worksheet1 = XLSX.utils.json_to_sheet(a, { skipHeader: true });
        const new_workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(new_workbook, worksheet1, "Data bridging_sep");
        XLSX.writeFile(new_workbook, 'tmp_file.xls');
    })
});