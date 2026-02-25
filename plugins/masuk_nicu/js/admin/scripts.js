jQuery().ready(function () {
    var var_tbl_mlite_masuk_nicu = $('#tbl_mlite_masuk_nicu').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'dom': 'Bfrtip',
        'searching': false,
        'select': true,
        'colReorder': true,
        "bInfo" : false,
        "ajax": {
            "url": "{?=url([ADMIN,'masuk_nicu','data'])?}",
            "dataType": "json",
            "type": "POST",
            "data": function (data) {

                // Read values
                var search_field_mlite_masuk_nicu = $('#search_field_mlite_masuk_nicu').val();
                var search_text_mlite_masuk_nicu = $('#search_text_mlite_masuk_nicu').val();
                
                data.search_field_mlite_masuk_nicu = search_field_mlite_masuk_nicu;
                data.search_text_mlite_masuk_nicu = search_text_mlite_masuk_nicu;
                
            }
        },
        "columns": [
{ 'data': 'no_rawat' },
{ 'data': 'tanggal' },
{ 'data': 'kd_dokter' },
{ 'data': 'diagnosa' },
{ 'data': 'tanda_vital_a' },
{ 'data': 'tanda_vital_b' },
{ 'data': 'tanda_vital_c' },
{ 'data': 'tanda_vital_d' },
{ 'data': 'tanda_vital_e' },
{ 'data': 'keterangan_tanda_vital_a' },
{ 'data': 'keterangan_tanda_vital_b' },
{ 'data': 'keterangan_tanda_vital_c' },
{ 'data': 'keterangan_tanda_vital_d' },
{ 'data': 'keterangan_tanda_vital_e' },
{ 'data': 'pemeriksaan_fisik_a' },
{ 'data': 'pemeriksaan_fisik_b' },
{ 'data': 'pemeriksaan_fisik_c' },
{ 'data': 'pemeriksaan_fisik_d' },
{ 'data': 'pemeriksaan_fisik_e' },
{ 'data': 'pemeriksaan_fisik_f' },
{ 'data': 'pemeriksaan_fisik_g' },
{ 'data': 'pemeriksaan_fisik_h' },
{ 'data': 'keterangan_pemeriksaan_fisik_a' },
{ 'data': 'keterangan_pemeriksaan_fisik_b' },
{ 'data': 'keterangan_pemeriksaan_fisik_c' },
{ 'data': 'keterangan_pemeriksaan_fisik_d' },
{ 'data': 'keterangan_pemeriksaan_fisik_e' },
{ 'data': 'keterangan_pemeriksaan_fisik_f' },
{ 'data': 'keterangan_pemeriksaan_fisik_g' },
{ 'data': 'keterangan_pemeriksaan_fisik_h' },
{ 'data': 'nilai_lab_a' },
{ 'data': 'nilai_lab_b' },
{ 'data': 'nilai_lab_c' },
{ 'data': 'nilai_lab_d' },
{ 'data': 'nilai_lab_e' },
{ 'data': 'nilai_lab_f' },
{ 'data': 'nilai_lab_g' },
{ 'data': 'nilai_lab_h' },
{ 'data': 'nilai_lab_i' },
{ 'data': 'nilai_lab_j' },
{ 'data': 'nilai_lab_k' },
{ 'data': 'keterangan_nilai_lab_a' },
{ 'data': 'keterangan_nilai_lab_b' },
{ 'data': 'keterangan_nilai_lab_c' },
{ 'data': 'keterangan_nilai_lab_d' },
{ 'data': 'keterangan_nilai_lab_e' },
{ 'data': 'keterangan_nilai_lab_f' },
{ 'data': 'keterangan_nilai_lab_g' },
{ 'data': 'keterangan_nilai_lab_h' },
{ 'data': 'keterangan_nilai_lab_i' },
{ 'data': 'keterangan_nilai_lab_j' },
{ 'data': 'keterangan_nilai_lab_k' },
{ 'data': 'kondisi_lain_a' },
{ 'data': 'kondisi_lain_b' },
{ 'data': 'kondisi_lain_c' },
{ 'data': 'kondisi_lain_d' },
{ 'data': 'keterangan_kondisi_lain_a' },
{ 'data': 'keterangan_kondisi_lain_b' },
{ 'data': 'keterangan_kondisi_lain_c' },
{ 'data': 'keterangan_kondisi_lain_d' },
{ 'data': 'kesimpulan_level' },
{ 'data': 'kesimpulan_transport' },
{ 'data': 'kesimpulan_pendamping' },
{ 'data': 'kesimpulan_alat' }

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
{ 'targets': 51},
{ 'targets': 52},
{ 'targets': 53},
{ 'targets': 54},
{ 'targets': 55},
{ 'targets': 56},
{ 'targets': 57},
{ 'targets': 58},
{ 'targets': 59},
{ 'targets': 60},
{ 'targets': 61},
{ 'targets': 62},
{ 'targets': 63}

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

    $("form[name='form_mlite_masuk_nicu']").validate({
        rules: {
no_rawat: 'required',
tanggal: 'required',
kd_dokter: 'required',
diagnosa: 'required',
tanda_vital_a: 'required',
tanda_vital_b: 'required',
tanda_vital_c: 'required',
tanda_vital_d: 'required',
tanda_vital_e: 'required',
keterangan_tanda_vital_a: 'required',
keterangan_tanda_vital_b: 'required',
keterangan_tanda_vital_c: 'required',
keterangan_tanda_vital_d: 'required',
keterangan_tanda_vital_e: 'required',
pemeriksaan_fisik_a: 'required',
pemeriksaan_fisik_b: 'required',
pemeriksaan_fisik_c: 'required',
pemeriksaan_fisik_d: 'required',
pemeriksaan_fisik_e: 'required',
pemeriksaan_fisik_f: 'required',
pemeriksaan_fisik_g: 'required',
pemeriksaan_fisik_h: 'required',
keterangan_pemeriksaan_fisik_a: 'required',
keterangan_pemeriksaan_fisik_b: 'required',
keterangan_pemeriksaan_fisik_c: 'required',
keterangan_pemeriksaan_fisik_d: 'required',
keterangan_pemeriksaan_fisik_e: 'required',
keterangan_pemeriksaan_fisik_f: 'required',
keterangan_pemeriksaan_fisik_g: 'required',
keterangan_pemeriksaan_fisik_h: 'required',
nilai_lab_a: 'required',
nilai_lab_b: 'required',
nilai_lab_c: 'required',
nilai_lab_d: 'required',
nilai_lab_e: 'required',
nilai_lab_f: 'required',
nilai_lab_g: 'required',
nilai_lab_h: 'required',
nilai_lab_i: 'required',
nilai_lab_j: 'required',
nilai_lab_k: 'required',
keterangan_nilai_lab_a: 'required',
keterangan_nilai_lab_b: 'required',
keterangan_nilai_lab_c: 'required',
keterangan_nilai_lab_d: 'required',
keterangan_nilai_lab_e: 'required',
keterangan_nilai_lab_f: 'required',
keterangan_nilai_lab_g: 'required',
keterangan_nilai_lab_h: 'required',
keterangan_nilai_lab_i: 'required',
keterangan_nilai_lab_j: 'required',
keterangan_nilai_lab_k: 'required',
kondisi_lain_a: 'required',
kondisi_lain_b: 'required',
kondisi_lain_c: 'required',
kondisi_lain_d: 'required',
keterangan_kondisi_lain_a: 'required',
keterangan_kondisi_lain_b: 'required',
keterangan_kondisi_lain_c: 'required',
keterangan_kondisi_lain_d: 'required',
kesimpulan_level: 'required',
kesimpulan_transport: 'required',
kesimpulan_pendamping: 'required',
kesimpulan_alat: 'required'

        },
        messages: {
no_rawat:'no_rawat tidak boleh kosong!',
tanggal:'tanggal tidak boleh kosong!',
kd_dokter:'kd_dokter tidak boleh kosong!',
diagnosa:'diagnosa tidak boleh kosong!',
tanda_vital_a:'tanda_vital_a tidak boleh kosong!',
tanda_vital_b:'tanda_vital_b tidak boleh kosong!',
tanda_vital_c:'tanda_vital_c tidak boleh kosong!',
tanda_vital_d:'tanda_vital_d tidak boleh kosong!',
tanda_vital_e:'tanda_vital_e tidak boleh kosong!',
keterangan_tanda_vital_a:'keterangan_tanda_vital_a tidak boleh kosong!',
keterangan_tanda_vital_b:'keterangan_tanda_vital_b tidak boleh kosong!',
keterangan_tanda_vital_c:'keterangan_tanda_vital_c tidak boleh kosong!',
keterangan_tanda_vital_d:'keterangan_tanda_vital_d tidak boleh kosong!',
keterangan_tanda_vital_e:'keterangan_tanda_vital_e tidak boleh kosong!',
pemeriksaan_fisik_a:'pemeriksaan_fisik_a tidak boleh kosong!',
pemeriksaan_fisik_b:'pemeriksaan_fisik_b tidak boleh kosong!',
pemeriksaan_fisik_c:'pemeriksaan_fisik_c tidak boleh kosong!',
pemeriksaan_fisik_d:'pemeriksaan_fisik_d tidak boleh kosong!',
pemeriksaan_fisik_e:'pemeriksaan_fisik_e tidak boleh kosong!',
pemeriksaan_fisik_f:'pemeriksaan_fisik_f tidak boleh kosong!',
pemeriksaan_fisik_g:'pemeriksaan_fisik_g tidak boleh kosong!',
pemeriksaan_fisik_h:'pemeriksaan_fisik_h tidak boleh kosong!',
keterangan_pemeriksaan_fisik_a:'keterangan_pemeriksaan_fisik_a tidak boleh kosong!',
keterangan_pemeriksaan_fisik_b:'keterangan_pemeriksaan_fisik_b tidak boleh kosong!',
keterangan_pemeriksaan_fisik_c:'keterangan_pemeriksaan_fisik_c tidak boleh kosong!',
keterangan_pemeriksaan_fisik_d:'keterangan_pemeriksaan_fisik_d tidak boleh kosong!',
keterangan_pemeriksaan_fisik_e:'keterangan_pemeriksaan_fisik_e tidak boleh kosong!',
keterangan_pemeriksaan_fisik_f:'keterangan_pemeriksaan_fisik_f tidak boleh kosong!',
keterangan_pemeriksaan_fisik_g:'keterangan_pemeriksaan_fisik_g tidak boleh kosong!',
keterangan_pemeriksaan_fisik_h:'keterangan_pemeriksaan_fisik_h tidak boleh kosong!',
nilai_lab_a:'nilai_lab_a tidak boleh kosong!',
nilai_lab_b:'nilai_lab_b tidak boleh kosong!',
nilai_lab_c:'nilai_lab_c tidak boleh kosong!',
nilai_lab_d:'nilai_lab_d tidak boleh kosong!',
nilai_lab_e:'nilai_lab_e tidak boleh kosong!',
nilai_lab_f:'nilai_lab_f tidak boleh kosong!',
nilai_lab_g:'nilai_lab_g tidak boleh kosong!',
nilai_lab_h:'nilai_lab_h tidak boleh kosong!',
nilai_lab_i:'nilai_lab_i tidak boleh kosong!',
nilai_lab_j:'nilai_lab_j tidak boleh kosong!',
nilai_lab_k:'nilai_lab_k tidak boleh kosong!',
keterangan_nilai_lab_a:'keterangan_nilai_lab_a tidak boleh kosong!',
keterangan_nilai_lab_b:'keterangan_nilai_lab_b tidak boleh kosong!',
keterangan_nilai_lab_c:'keterangan_nilai_lab_c tidak boleh kosong!',
keterangan_nilai_lab_d:'keterangan_nilai_lab_d tidak boleh kosong!',
keterangan_nilai_lab_e:'keterangan_nilai_lab_e tidak boleh kosong!',
keterangan_nilai_lab_f:'keterangan_nilai_lab_f tidak boleh kosong!',
keterangan_nilai_lab_g:'keterangan_nilai_lab_g tidak boleh kosong!',
keterangan_nilai_lab_h:'keterangan_nilai_lab_h tidak boleh kosong!',
keterangan_nilai_lab_i:'keterangan_nilai_lab_i tidak boleh kosong!',
keterangan_nilai_lab_j:'keterangan_nilai_lab_j tidak boleh kosong!',
keterangan_nilai_lab_k:'keterangan_nilai_lab_k tidak boleh kosong!',
kondisi_lain_a:'kondisi_lain_a tidak boleh kosong!',
kondisi_lain_b:'kondisi_lain_b tidak boleh kosong!',
kondisi_lain_c:'kondisi_lain_c tidak boleh kosong!',
kondisi_lain_d:'kondisi_lain_d tidak boleh kosong!',
keterangan_kondisi_lain_a:'keterangan_kondisi_lain_a tidak boleh kosong!',
keterangan_kondisi_lain_b:'keterangan_kondisi_lain_b tidak boleh kosong!',
keterangan_kondisi_lain_c:'keterangan_kondisi_lain_c tidak boleh kosong!',
keterangan_kondisi_lain_d:'keterangan_kondisi_lain_d tidak boleh kosong!',
kesimpulan_level:'kesimpulan_level tidak boleh kosong!',
kesimpulan_transport:'kesimpulan_transport tidak boleh kosong!',
kesimpulan_pendamping:'kesimpulan_pendamping tidak boleh kosong!',
kesimpulan_alat:'kesimpulan_alat tidak boleh kosong!'

        },
        submitHandler: function (form) {
 var no_rawat= $('#no_rawat').val();
var tanggal= $('#tanggal').val();
var kd_dokter= $('#kd_dokter').val();
var diagnosa= $('#diagnosa').val();
var tanda_vital_a= $('#tanda_vital_a').val();
var tanda_vital_b= $('#tanda_vital_b').val();
var tanda_vital_c= $('#tanda_vital_c').val();
var tanda_vital_d= $('#tanda_vital_d').val();
var tanda_vital_e= $('#tanda_vital_e').val();
var keterangan_tanda_vital_a= $('#keterangan_tanda_vital_a').val();
var keterangan_tanda_vital_b= $('#keterangan_tanda_vital_b').val();
var keterangan_tanda_vital_c= $('#keterangan_tanda_vital_c').val();
var keterangan_tanda_vital_d= $('#keterangan_tanda_vital_d').val();
var keterangan_tanda_vital_e= $('#keterangan_tanda_vital_e').val();
var pemeriksaan_fisik_a= $('#pemeriksaan_fisik_a').val();
var pemeriksaan_fisik_b= $('#pemeriksaan_fisik_b').val();
var pemeriksaan_fisik_c= $('#pemeriksaan_fisik_c').val();
var pemeriksaan_fisik_d= $('#pemeriksaan_fisik_d').val();
var pemeriksaan_fisik_e= $('#pemeriksaan_fisik_e').val();
var pemeriksaan_fisik_f= $('#pemeriksaan_fisik_f').val();
var pemeriksaan_fisik_g= $('#pemeriksaan_fisik_g').val();
var pemeriksaan_fisik_h= $('#pemeriksaan_fisik_h').val();
var keterangan_pemeriksaan_fisik_a= $('#keterangan_pemeriksaan_fisik_a').val();
var keterangan_pemeriksaan_fisik_b= $('#keterangan_pemeriksaan_fisik_b').val();
var keterangan_pemeriksaan_fisik_c= $('#keterangan_pemeriksaan_fisik_c').val();
var keterangan_pemeriksaan_fisik_d= $('#keterangan_pemeriksaan_fisik_d').val();
var keterangan_pemeriksaan_fisik_e= $('#keterangan_pemeriksaan_fisik_e').val();
var keterangan_pemeriksaan_fisik_f= $('#keterangan_pemeriksaan_fisik_f').val();
var keterangan_pemeriksaan_fisik_g= $('#keterangan_pemeriksaan_fisik_g').val();
var keterangan_pemeriksaan_fisik_h= $('#keterangan_pemeriksaan_fisik_h').val();
var nilai_lab_a= $('#nilai_lab_a').val();
var nilai_lab_b= $('#nilai_lab_b').val();
var nilai_lab_c= $('#nilai_lab_c').val();
var nilai_lab_d= $('#nilai_lab_d').val();
var nilai_lab_e= $('#nilai_lab_e').val();
var nilai_lab_f= $('#nilai_lab_f').val();
var nilai_lab_g= $('#nilai_lab_g').val();
var nilai_lab_h= $('#nilai_lab_h').val();
var nilai_lab_i= $('#nilai_lab_i').val();
var nilai_lab_j= $('#nilai_lab_j').val();
var nilai_lab_k= $('#nilai_lab_k').val();
var keterangan_nilai_lab_a= $('#keterangan_nilai_lab_a').val();
var keterangan_nilai_lab_b= $('#keterangan_nilai_lab_b').val();
var keterangan_nilai_lab_c= $('#keterangan_nilai_lab_c').val();
var keterangan_nilai_lab_d= $('#keterangan_nilai_lab_d').val();
var keterangan_nilai_lab_e= $('#keterangan_nilai_lab_e').val();
var keterangan_nilai_lab_f= $('#keterangan_nilai_lab_f').val();
var keterangan_nilai_lab_g= $('#keterangan_nilai_lab_g').val();
var keterangan_nilai_lab_h= $('#keterangan_nilai_lab_h').val();
var keterangan_nilai_lab_i= $('#keterangan_nilai_lab_i').val();
var keterangan_nilai_lab_j= $('#keterangan_nilai_lab_j').val();
var keterangan_nilai_lab_k= $('#keterangan_nilai_lab_k').val();
var kondisi_lain_a= $('#kondisi_lain_a').val();
var kondisi_lain_b= $('#kondisi_lain_b').val();
var kondisi_lain_c= $('#kondisi_lain_c').val();
var kondisi_lain_d= $('#kondisi_lain_d').val();
var keterangan_kondisi_lain_a= $('#keterangan_kondisi_lain_a').val();
var keterangan_kondisi_lain_b= $('#keterangan_kondisi_lain_b').val();
var keterangan_kondisi_lain_c= $('#keterangan_kondisi_lain_c').val();
var keterangan_kondisi_lain_d= $('#keterangan_kondisi_lain_d').val();
var kesimpulan_level= $('#kesimpulan_level').val();
var kesimpulan_transport= $('#kesimpulan_transport').val();
var kesimpulan_pendamping= $('#kesimpulan_pendamping').val();
var kesimpulan_alat= $('#kesimpulan_alat').val();

 var typeact = $('#typeact').val();

 var formData = new FormData(form); // tambahan
 formData.append('typeact', typeact); // tambahan

            $.ajax({
                url: "{?=url([ADMIN,'masuk_nicu','aksi'])?}",
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
    $('#search_text_mlite_masuk_nicu').keyup(function () {
        var_tbl_mlite_masuk_nicu.draw();
    });
    // ==============================================================
    // CLICK TANDA X DI INPUT SEARCH
    // ==============================================================
    $("#searchclear_mlite_masuk_nicu").click(function () {
        $("#search_text_mlite_masuk_nicu").val("");
        var_tbl_mlite_masuk_nicu.draw();
    });

    // ===========================================
    // Ketika tombol Edit di tekan
    // ===========================================

    $("#edit_data_mlite_masuk_nicu").click(function () {
        var rowData = var_tbl_mlite_masuk_nicu.rows({ selected: true }).data()[0];
        if (rowData != null) {

            var no_rawat = rowData['no_rawat'];
var tanggal = rowData['tanggal'];
var kd_dokter = rowData['kd_dokter'];
var diagnosa = rowData['diagnosa'];
var tanda_vital_a = rowData['tanda_vital_a'];
var tanda_vital_b = rowData['tanda_vital_b'];
var tanda_vital_c = rowData['tanda_vital_c'];
var tanda_vital_d = rowData['tanda_vital_d'];
var tanda_vital_e = rowData['tanda_vital_e'];
var keterangan_tanda_vital_a = rowData['keterangan_tanda_vital_a'];
var keterangan_tanda_vital_b = rowData['keterangan_tanda_vital_b'];
var keterangan_tanda_vital_c = rowData['keterangan_tanda_vital_c'];
var keterangan_tanda_vital_d = rowData['keterangan_tanda_vital_d'];
var keterangan_tanda_vital_e = rowData['keterangan_tanda_vital_e'];
var pemeriksaan_fisik_a = rowData['pemeriksaan_fisik_a'];
var pemeriksaan_fisik_b = rowData['pemeriksaan_fisik_b'];
var pemeriksaan_fisik_c = rowData['pemeriksaan_fisik_c'];
var pemeriksaan_fisik_d = rowData['pemeriksaan_fisik_d'];
var pemeriksaan_fisik_e = rowData['pemeriksaan_fisik_e'];
var pemeriksaan_fisik_f = rowData['pemeriksaan_fisik_f'];
var pemeriksaan_fisik_g = rowData['pemeriksaan_fisik_g'];
var pemeriksaan_fisik_h = rowData['pemeriksaan_fisik_h'];
var keterangan_pemeriksaan_fisik_a = rowData['keterangan_pemeriksaan_fisik_a'];
var keterangan_pemeriksaan_fisik_b = rowData['keterangan_pemeriksaan_fisik_b'];
var keterangan_pemeriksaan_fisik_c = rowData['keterangan_pemeriksaan_fisik_c'];
var keterangan_pemeriksaan_fisik_d = rowData['keterangan_pemeriksaan_fisik_d'];
var keterangan_pemeriksaan_fisik_e = rowData['keterangan_pemeriksaan_fisik_e'];
var keterangan_pemeriksaan_fisik_f = rowData['keterangan_pemeriksaan_fisik_f'];
var keterangan_pemeriksaan_fisik_g = rowData['keterangan_pemeriksaan_fisik_g'];
var keterangan_pemeriksaan_fisik_h = rowData['keterangan_pemeriksaan_fisik_h'];
var nilai_lab_a = rowData['nilai_lab_a'];
var nilai_lab_b = rowData['nilai_lab_b'];
var nilai_lab_c = rowData['nilai_lab_c'];
var nilai_lab_d = rowData['nilai_lab_d'];
var nilai_lab_e = rowData['nilai_lab_e'];
var nilai_lab_f = rowData['nilai_lab_f'];
var nilai_lab_g = rowData['nilai_lab_g'];
var nilai_lab_h = rowData['nilai_lab_h'];
var nilai_lab_i = rowData['nilai_lab_i'];
var nilai_lab_j = rowData['nilai_lab_j'];
var nilai_lab_k = rowData['nilai_lab_k'];
var keterangan_nilai_lab_a = rowData['keterangan_nilai_lab_a'];
var keterangan_nilai_lab_b = rowData['keterangan_nilai_lab_b'];
var keterangan_nilai_lab_c = rowData['keterangan_nilai_lab_c'];
var keterangan_nilai_lab_d = rowData['keterangan_nilai_lab_d'];
var keterangan_nilai_lab_e = rowData['keterangan_nilai_lab_e'];
var keterangan_nilai_lab_f = rowData['keterangan_nilai_lab_f'];
var keterangan_nilai_lab_g = rowData['keterangan_nilai_lab_g'];
var keterangan_nilai_lab_h = rowData['keterangan_nilai_lab_h'];
var keterangan_nilai_lab_i = rowData['keterangan_nilai_lab_i'];
var keterangan_nilai_lab_j = rowData['keterangan_nilai_lab_j'];
var keterangan_nilai_lab_k = rowData['keterangan_nilai_lab_k'];
var kondisi_lain_a = rowData['kondisi_lain_a'];
var kondisi_lain_b = rowData['kondisi_lain_b'];
var kondisi_lain_c = rowData['kondisi_lain_c'];
var kondisi_lain_d = rowData['kondisi_lain_d'];
var keterangan_kondisi_lain_a = rowData['keterangan_kondisi_lain_a'];
var keterangan_kondisi_lain_b = rowData['keterangan_kondisi_lain_b'];
var keterangan_kondisi_lain_c = rowData['keterangan_kondisi_lain_c'];
var keterangan_kondisi_lain_d = rowData['keterangan_kondisi_lain_d'];
var kesimpulan_level = rowData['kesimpulan_level'];
var kesimpulan_transport = rowData['kesimpulan_transport'];
var kesimpulan_pendamping = rowData['kesimpulan_pendamping'];
var kesimpulan_alat = rowData['kesimpulan_alat'];



            $("#typeact").val("edit");
  
            $('#no_rawat').val(no_rawat);
$('#tanggal').val(tanggal);
$('#kd_dokter').val(kd_dokter);
$('#diagnosa').val(diagnosa);
$('#tanda_vital_a').val(tanda_vital_a);
$('#tanda_vital_b').val(tanda_vital_b);
$('#tanda_vital_c').val(tanda_vital_c);
$('#tanda_vital_d').val(tanda_vital_d);
$('#tanda_vital_e').val(tanda_vital_e);
$('#keterangan_tanda_vital_a').val(keterangan_tanda_vital_a);
$('#keterangan_tanda_vital_b').val(keterangan_tanda_vital_b);
$('#keterangan_tanda_vital_c').val(keterangan_tanda_vital_c);
$('#keterangan_tanda_vital_d').val(keterangan_tanda_vital_d);
$('#keterangan_tanda_vital_e').val(keterangan_tanda_vital_e);
$('#pemeriksaan_fisik_a').val(pemeriksaan_fisik_a);
$('#pemeriksaan_fisik_b').val(pemeriksaan_fisik_b);
$('#pemeriksaan_fisik_c').val(pemeriksaan_fisik_c);
$('#pemeriksaan_fisik_d').val(pemeriksaan_fisik_d);
$('#pemeriksaan_fisik_e').val(pemeriksaan_fisik_e);
$('#pemeriksaan_fisik_f').val(pemeriksaan_fisik_f);
$('#pemeriksaan_fisik_g').val(pemeriksaan_fisik_g);
$('#pemeriksaan_fisik_h').val(pemeriksaan_fisik_h);
$('#keterangan_pemeriksaan_fisik_a').val(keterangan_pemeriksaan_fisik_a);
$('#keterangan_pemeriksaan_fisik_b').val(keterangan_pemeriksaan_fisik_b);
$('#keterangan_pemeriksaan_fisik_c').val(keterangan_pemeriksaan_fisik_c);
$('#keterangan_pemeriksaan_fisik_d').val(keterangan_pemeriksaan_fisik_d);
$('#keterangan_pemeriksaan_fisik_e').val(keterangan_pemeriksaan_fisik_e);
$('#keterangan_pemeriksaan_fisik_f').val(keterangan_pemeriksaan_fisik_f);
$('#keterangan_pemeriksaan_fisik_g').val(keterangan_pemeriksaan_fisik_g);
$('#keterangan_pemeriksaan_fisik_h').val(keterangan_pemeriksaan_fisik_h);
$('#nilai_lab_a').val(nilai_lab_a);
$('#nilai_lab_b').val(nilai_lab_b);
$('#nilai_lab_c').val(nilai_lab_c);
$('#nilai_lab_d').val(nilai_lab_d);
$('#nilai_lab_e').val(nilai_lab_e);
$('#nilai_lab_f').val(nilai_lab_f);
$('#nilai_lab_g').val(nilai_lab_g);
$('#nilai_lab_h').val(nilai_lab_h);
$('#nilai_lab_i').val(nilai_lab_i);
$('#nilai_lab_j').val(nilai_lab_j);
$('#nilai_lab_k').val(nilai_lab_k);
$('#keterangan_nilai_lab_a').val(keterangan_nilai_lab_a);
$('#keterangan_nilai_lab_b').val(keterangan_nilai_lab_b);
$('#keterangan_nilai_lab_c').val(keterangan_nilai_lab_c);
$('#keterangan_nilai_lab_d').val(keterangan_nilai_lab_d);
$('#keterangan_nilai_lab_e').val(keterangan_nilai_lab_e);
$('#keterangan_nilai_lab_f').val(keterangan_nilai_lab_f);
$('#keterangan_nilai_lab_g').val(keterangan_nilai_lab_g);
$('#keterangan_nilai_lab_h').val(keterangan_nilai_lab_h);
$('#keterangan_nilai_lab_i').val(keterangan_nilai_lab_i);
$('#keterangan_nilai_lab_j').val(keterangan_nilai_lab_j);
$('#keterangan_nilai_lab_k').val(keterangan_nilai_lab_k);
$('#kondisi_lain_a').val(kondisi_lain_a);
$('#kondisi_lain_b').val(kondisi_lain_b);
$('#kondisi_lain_c').val(kondisi_lain_c);
$('#kondisi_lain_d').val(kondisi_lain_d);
$('#keterangan_kondisi_lain_a').val(keterangan_kondisi_lain_a);
$('#keterangan_kondisi_lain_b').val(keterangan_kondisi_lain_b);
$('#keterangan_kondisi_lain_c').val(keterangan_kondisi_lain_c);
$('#keterangan_kondisi_lain_d').val(keterangan_kondisi_lain_d);
$('#kesimpulan_level').val(kesimpulan_level);
$('#kesimpulan_transport').val(kesimpulan_transport);
$('#kesimpulan_pendamping').val(kesimpulan_pendamping);
$('#kesimpulan_alat').val(kesimpulan_alat);

            //$("#no_rawat").prop('disabled', true); // GA BISA DIEDIT KALI DISABLE
            $('#modal-title').text("Edit Data masuk nicu");
            $("#modal_mlite_masuk_nicu").modal();
        }
        else {
            alert("Silakan pilih data yang akan di edit.");
        }

    });

    // ==============================================================
    // TOMBOL  DELETE DI CLICK
    // ==============================================================
    jQuery("#hapus_data_mlite_masuk_nicu").click(function () {
        var rowData = var_tbl_mlite_masuk_nicu.rows({ selected: true }).data()[0];


        if (rowData) {
var no_rawat = rowData['no_rawat'];
            var a = confirm("Anda yakin akan menghapus data dengan no_rawat=" + no_rawat);
            if (a) {

                $.ajax({
                    url: "{?=url([ADMIN,'masuk_nicu','aksi'])?}",
                    method: "POST",
                    data: {
                        no_rawat: no_rawat,
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
    jQuery("#tambah_data_mlite_masuk_nicu").click(function () {

        $('#no_rawat').val('');
$('#tanggal').val('');
$('#kd_dokter').val('');
$('#diagnosa').val('');
$('#tanda_vital_a').val('');
$('#tanda_vital_b').val('');
$('#tanda_vital_c').val('');
$('#tanda_vital_d').val('');
$('#tanda_vital_e').val('');
$('#keterangan_tanda_vital_a').val('');
$('#keterangan_tanda_vital_b').val('');
$('#keterangan_tanda_vital_c').val('');
$('#keterangan_tanda_vital_d').val('');
$('#keterangan_tanda_vital_e').val('');
$('#pemeriksaan_fisik_a').val('');
$('#pemeriksaan_fisik_b').val('');
$('#pemeriksaan_fisik_c').val('');
$('#pemeriksaan_fisik_d').val('');
$('#pemeriksaan_fisik_e').val('');
$('#pemeriksaan_fisik_f').val('');
$('#pemeriksaan_fisik_g').val('');
$('#pemeriksaan_fisik_h').val('');
$('#keterangan_pemeriksaan_fisik_a').val('');
$('#keterangan_pemeriksaan_fisik_b').val('');
$('#keterangan_pemeriksaan_fisik_c').val('');
$('#keterangan_pemeriksaan_fisik_d').val('');
$('#keterangan_pemeriksaan_fisik_e').val('');
$('#keterangan_pemeriksaan_fisik_f').val('');
$('#keterangan_pemeriksaan_fisik_g').val('');
$('#keterangan_pemeriksaan_fisik_h').val('');
$('#nilai_lab_a').val('');
$('#nilai_lab_b').val('');
$('#nilai_lab_c').val('');
$('#nilai_lab_d').val('');
$('#nilai_lab_e').val('');
$('#nilai_lab_f').val('');
$('#nilai_lab_g').val('');
$('#nilai_lab_h').val('');
$('#nilai_lab_i').val('');
$('#nilai_lab_j').val('');
$('#nilai_lab_k').val('');
$('#keterangan_nilai_lab_a').val('');
$('#keterangan_nilai_lab_b').val('');
$('#keterangan_nilai_lab_c').val('');
$('#keterangan_nilai_lab_d').val('');
$('#keterangan_nilai_lab_e').val('');
$('#keterangan_nilai_lab_f').val('');
$('#keterangan_nilai_lab_g').val('');
$('#keterangan_nilai_lab_h').val('');
$('#keterangan_nilai_lab_i').val('');
$('#keterangan_nilai_lab_j').val('');
$('#keterangan_nilai_lab_k').val('');
$('#kondisi_lain_a').val('');
$('#kondisi_lain_b').val('');
$('#kondisi_lain_c').val('');
$('#kondisi_lain_d').val('');
$('#keterangan_kondisi_lain_a').val('');
$('#keterangan_kondisi_lain_b').val('');
$('#keterangan_kondisi_lain_c').val('');
$('#keterangan_kondisi_lain_d').val('');
$('#kesimpulan_level').val('');
$('#kesimpulan_transport').val('');
$('#kesimpulan_pendamping').val('');
$('#kesimpulan_alat').val('');


        $("#typeact").val("add");
        $("#no_rawat").prop('disabled', false);
        
        $('#modal-title').text("Tambah Data masuk nicu");
        $("#modal_mlite_masuk_nicu").modal();
    });

    // ===========================================
    // Ketika tombol lihat data di tekan
    // ===========================================
    $("#lihat_data_mlite_masuk_nicu").click(function () {

        var search_field_mlite_masuk_nicu = $('#search_field_mlite_masuk_nicu').val();
        var search_text_mlite_masuk_nicu = $('#search_text_mlite_masuk_nicu').val();

        $.ajax({
            url: "{?=url([ADMIN,'masuk_nicu','aksi'])?}",
            method: "POST",
            data: {
                typeact: 'lihat', 
                search_field_mlite_masuk_nicu: search_field_mlite_masuk_nicu, 
                search_text_mlite_masuk_nicu: search_text_mlite_masuk_nicu
            },
            dataType: 'json',
            success: function (res) {
                var eTable = "<div class='table-responsive'><table id='tbl_lihat_mlite_masuk_nicu' class='table display dataTable' style='width:100%'><thead><th>No Rawat</th><th>Tanggal</th><th>Kd Dokter</th><th>Diagnosa</th><th>Tanda Vital A</th><th>Tanda Vital B</th><th>Tanda Vital C</th><th>Tanda Vital D</th><th>Tanda Vital E</th><th>Keterangan Tanda Vital A</th><th>Keterangan Tanda Vital B</th><th>Keterangan Tanda Vital C</th><th>Keterangan Tanda Vital D</th><th>Keterangan Tanda Vital E</th><th>Pemeriksaan Fisik A</th><th>Pemeriksaan Fisik B</th><th>Pemeriksaan Fisik C</th><th>Pemeriksaan Fisik D</th><th>Pemeriksaan Fisik E</th><th>Pemeriksaan Fisik F</th><th>Pemeriksaan Fisik G</th><th>Pemeriksaan Fisik H</th><th>Keterangan Pemeriksaan Fisik A</th><th>Keterangan Pemeriksaan Fisik B</th><th>Keterangan Pemeriksaan Fisik C</th><th>Keterangan Pemeriksaan Fisik D</th><th>Keterangan Pemeriksaan Fisik E</th><th>Keterangan Pemeriksaan Fisik F</th><th>Keterangan Pemeriksaan Fisik G</th><th>Keterangan Pemeriksaan Fisik H</th><th>Nilai Lab A</th><th>Nilai Lab B</th><th>Nilai Lab C</th><th>Nilai Lab D</th><th>Nilai Lab E</th><th>Nilai Lab F</th><th>Nilai Lab G</th><th>Nilai Lab H</th><th>Nilai Lab I</th><th>Nilai Lab J</th><th>Nilai Lab K</th><th>Keterangan Nilai Lab A</th><th>Keterangan Nilai Lab B</th><th>Keterangan Nilai Lab C</th><th>Keterangan Nilai Lab D</th><th>Keterangan Nilai Lab E</th><th>Keterangan Nilai Lab F</th><th>Keterangan Nilai Lab G</th><th>Keterangan Nilai Lab H</th><th>Keterangan Nilai Lab I</th><th>Keterangan Nilai Lab J</th><th>Keterangan Nilai Lab K</th><th>Kondisi Lain A</th><th>Kondisi Lain B</th><th>Kondisi Lain C</th><th>Kondisi Lain D</th><th>Keterangan Kondisi Lain A</th><th>Keterangan Kondisi Lain B</th><th>Keterangan Kondisi Lain C</th><th>Keterangan Kondisi Lain D</th><th>Kesimpulan Level</th><th>Kesimpulan Transport</th><th>Kesimpulan Pendamping</th><th>Kesimpulan Alat</th></thead>";
                for (var i = 0; i < res.length; i++) {
                    eTable += "<tr>";
                    eTable += '<td>' + res[i]['no_rawat'] + '</td>';
eTable += '<td>' + res[i]['tanggal'] + '</td>';
eTable += '<td>' + res[i]['kd_dokter'] + '</td>';
eTable += '<td>' + res[i]['diagnosa'] + '</td>';
eTable += '<td>' + res[i]['tanda_vital_a'] + '</td>';
eTable += '<td>' + res[i]['tanda_vital_b'] + '</td>';
eTable += '<td>' + res[i]['tanda_vital_c'] + '</td>';
eTable += '<td>' + res[i]['tanda_vital_d'] + '</td>';
eTable += '<td>' + res[i]['tanda_vital_e'] + '</td>';
eTable += '<td>' + res[i]['keterangan_tanda_vital_a'] + '</td>';
eTable += '<td>' + res[i]['keterangan_tanda_vital_b'] + '</td>';
eTable += '<td>' + res[i]['keterangan_tanda_vital_c'] + '</td>';
eTable += '<td>' + res[i]['keterangan_tanda_vital_d'] + '</td>';
eTable += '<td>' + res[i]['keterangan_tanda_vital_e'] + '</td>';
eTable += '<td>' + res[i]['pemeriksaan_fisik_a'] + '</td>';
eTable += '<td>' + res[i]['pemeriksaan_fisik_b'] + '</td>';
eTable += '<td>' + res[i]['pemeriksaan_fisik_c'] + '</td>';
eTable += '<td>' + res[i]['pemeriksaan_fisik_d'] + '</td>';
eTable += '<td>' + res[i]['pemeriksaan_fisik_e'] + '</td>';
eTable += '<td>' + res[i]['pemeriksaan_fisik_f'] + '</td>';
eTable += '<td>' + res[i]['pemeriksaan_fisik_g'] + '</td>';
eTable += '<td>' + res[i]['pemeriksaan_fisik_h'] + '</td>';
eTable += '<td>' + res[i]['keterangan_pemeriksaan_fisik_a'] + '</td>';
eTable += '<td>' + res[i]['keterangan_pemeriksaan_fisik_b'] + '</td>';
eTable += '<td>' + res[i]['keterangan_pemeriksaan_fisik_c'] + '</td>';
eTable += '<td>' + res[i]['keterangan_pemeriksaan_fisik_d'] + '</td>';
eTable += '<td>' + res[i]['keterangan_pemeriksaan_fisik_e'] + '</td>';
eTable += '<td>' + res[i]['keterangan_pemeriksaan_fisik_f'] + '</td>';
eTable += '<td>' + res[i]['keterangan_pemeriksaan_fisik_g'] + '</td>';
eTable += '<td>' + res[i]['keterangan_pemeriksaan_fisik_h'] + '</td>';
eTable += '<td>' + res[i]['nilai_lab_a'] + '</td>';
eTable += '<td>' + res[i]['nilai_lab_b'] + '</td>';
eTable += '<td>' + res[i]['nilai_lab_c'] + '</td>';
eTable += '<td>' + res[i]['nilai_lab_d'] + '</td>';
eTable += '<td>' + res[i]['nilai_lab_e'] + '</td>';
eTable += '<td>' + res[i]['nilai_lab_f'] + '</td>';
eTable += '<td>' + res[i]['nilai_lab_g'] + '</td>';
eTable += '<td>' + res[i]['nilai_lab_h'] + '</td>';
eTable += '<td>' + res[i]['nilai_lab_i'] + '</td>';
eTable += '<td>' + res[i]['nilai_lab_j'] + '</td>';
eTable += '<td>' + res[i]['nilai_lab_k'] + '</td>';
eTable += '<td>' + res[i]['keterangan_nilai_lab_a'] + '</td>';
eTable += '<td>' + res[i]['keterangan_nilai_lab_b'] + '</td>';
eTable += '<td>' + res[i]['keterangan_nilai_lab_c'] + '</td>';
eTable += '<td>' + res[i]['keterangan_nilai_lab_d'] + '</td>';
eTable += '<td>' + res[i]['keterangan_nilai_lab_e'] + '</td>';
eTable += '<td>' + res[i]['keterangan_nilai_lab_f'] + '</td>';
eTable += '<td>' + res[i]['keterangan_nilai_lab_g'] + '</td>';
eTable += '<td>' + res[i]['keterangan_nilai_lab_h'] + '</td>';
eTable += '<td>' + res[i]['keterangan_nilai_lab_i'] + '</td>';
eTable += '<td>' + res[i]['keterangan_nilai_lab_j'] + '</td>';
eTable += '<td>' + res[i]['keterangan_nilai_lab_k'] + '</td>';
eTable += '<td>' + res[i]['kondisi_lain_a'] + '</td>';
eTable += '<td>' + res[i]['kondisi_lain_b'] + '</td>';
eTable += '<td>' + res[i]['kondisi_lain_c'] + '</td>';
eTable += '<td>' + res[i]['kondisi_lain_d'] + '</td>';
eTable += '<td>' + res[i]['keterangan_kondisi_lain_a'] + '</td>';
eTable += '<td>' + res[i]['keterangan_kondisi_lain_b'] + '</td>';
eTable += '<td>' + res[i]['keterangan_kondisi_lain_c'] + '</td>';
eTable += '<td>' + res[i]['keterangan_kondisi_lain_d'] + '</td>';
eTable += '<td>' + res[i]['kesimpulan_level'] + '</td>';
eTable += '<td>' + res[i]['kesimpulan_transport'] + '</td>';
eTable += '<td>' + res[i]['kesimpulan_pendamping'] + '</td>';
eTable += '<td>' + res[i]['kesimpulan_alat'] + '</td>';
                    eTable += "</tr>";
                }
                eTable += "</tbody></table></div>";
                $('#forTable_mlite_masuk_nicu').html(eTable);
            }
        });

        $('#modal-title').text("Lihat Data");
        $("#modal_lihat_mlite_masuk_nicu").modal();
    });

    // ==============================================================
    // TOMBOL DETAIL mlite_masuk_nicu DI CLICK
    // ==============================================================
    jQuery("#lihat_detail_mlite_masuk_nicu").click(function (event) {

        var rowData = var_tbl_mlite_masuk_nicu.rows({ selected: true }).data()[0];

        if (rowData) {
var no_rawat = rowData['no_rawat'];
            var baseURL = mlite.url + '/' + mlite.admin;
            event.preventDefault();
            var loadURL =  baseURL + '/masuk_nicu/detail/' + no_rawat + '?t=' + mlite.token;
        
            var modal = $('#modal_detail_mlite_masuk_nicu');
            var modalContent = $('#modal_detail_mlite_masuk_nicu .modal-content');
        
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
        doc.text("Tabel Data Mlite Masuk Nicu", 20, 95, null, null, null);
        const totalPagesExp = "{total_pages_count_string}";        
        doc.autoTable({
            html: '#tbl_lihat_mlite_masuk_nicu',
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
        // doc.save('table_data_mlite_masuk_nicu.pdf')
        window.open(doc.output('bloburl'), '_blank',"toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes");  
              
    })

    // ===========================================
    // Ketika tombol export xlsx di tekan
    // ===========================================
    $("#export_xlsx").click(function () {
        let tbl1 = document.getElementById("tbl_lihat_mlite_masuk_nicu");
        let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
        let a = XLSX.utils.sheet_to_json(worksheet_tmp1, { header: 1 });
        let worksheet1 = XLSX.utils.json_to_sheet(a, { skipHeader: true });
        const new_workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(new_workbook, worksheet1, "Data mlite_masuk_nicu");
        XLSX.writeFile(new_workbook, 'tmp_file.xls');
    })
});