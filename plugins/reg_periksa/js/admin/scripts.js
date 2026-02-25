jQuery().ready(function () {
    var var_tbl_reg_periksa = $('#tbl_reg_periksa').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'dom': 'Bfrtip',
        'searching': false,
        'select': true,
        'colReorder': true,
        "bInfo" : false,
        "ajax": {
            "url": "{?=url([ADMIN,'reg_periksa','data'])?}",
            "dataType": "json",
            "type": "POST",
            "data": function (data) {

                // Read values
                var search_field_reg_periksa = $('#search_field_reg_periksa').val();
                var search_text_reg_periksa = $('#search_text_reg_periksa').val();
                
                data.search_field_reg_periksa = search_field_reg_periksa;
                data.search_text_reg_periksa = search_text_reg_periksa;
                
            }
        },
        "columns": [
{ 'data': 'no_reg' },
{ 'data': 'no_rawat' },
{ 'data': 'tgl_registrasi' },
{ 'data': 'jam_reg' },
{ 'data': 'kd_dokter' },
{ 'data': 'no_rkm_medis' },
{ 'data': 'kd_poli' },
{ 'data': 'p_jawab' },
{ 'data': 'almt_pj' },
{ 'data': 'hubunganpj' },
{ 'data': 'biaya_reg' },
{ 'data': 'stts' },
{ 'data': 'stts_daftar' },
{ 'data': 'status_lanjut' },
{ 'data': 'kd_pj' },
{ 'data': 'umurdaftar' },
{ 'data': 'sttsumur' },
{ 'data': 'status_bayar' },
{ 'data': 'status_poli' }

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
{ 'targets': 18}

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

    $("form[name='form_reg_periksa']").validate({
        rules: {
no_reg: 'required',
no_rawat: 'required',
tgl_registrasi: 'required',
jam_reg: 'required',
kd_dokter: 'required',
no_rkm_medis: 'required',
kd_poli: 'required',
p_jawab: 'required',
almt_pj: 'required',
hubunganpj: 'required',
biaya_reg: 'required',
stts: 'required',
stts_daftar: 'required',
status_lanjut: 'required',
kd_pj: 'required',
umurdaftar: 'required',
sttsumur: 'required',
status_bayar: 'required',
status_poli: 'required'

        },
        messages: {
no_reg:'no_reg tidak boleh kosong!',
no_rawat:'no_rawat tidak boleh kosong!',
tgl_registrasi:'tgl_registrasi tidak boleh kosong!',
jam_reg:'jam_reg tidak boleh kosong!',
kd_dokter:'kd_dokter tidak boleh kosong!',
no_rkm_medis:'no_rkm_medis tidak boleh kosong!',
kd_poli:'kd_poli tidak boleh kosong!',
p_jawab:'p_jawab tidak boleh kosong!',
almt_pj:'almt_pj tidak boleh kosong!',
hubunganpj:'hubunganpj tidak boleh kosong!',
biaya_reg:'biaya_reg tidak boleh kosong!',
stts:'stts tidak boleh kosong!',
stts_daftar:'stts_daftar tidak boleh kosong!',
status_lanjut:'status_lanjut tidak boleh kosong!',
kd_pj:'kd_pj tidak boleh kosong!',
umurdaftar:'umurdaftar tidak boleh kosong!',
sttsumur:'sttsumur tidak boleh kosong!',
status_bayar:'status_bayar tidak boleh kosong!',
status_poli:'status_poli tidak boleh kosong!'

        },
        submitHandler: function (form) {
 var no_reg= $('#no_reg').val();
var no_rawat= $('#no_rawat').val();
var tgl_registrasi= $('#tgl_registrasi').val();
var jam_reg= $('#jam_reg').val();
var kd_dokter= $('#kd_dokter').val();
var no_rkm_medis= $('#no_rkm_medis').val();
var kd_poli= $('#kd_poli').val();
var p_jawab= $('#p_jawab').val();
var almt_pj= $('#almt_pj').val();
var hubunganpj= $('#hubunganpj').val();
var biaya_reg= $('#biaya_reg').val();
var stts= $('#stts').val();
var stts_daftar= $('#stts_daftar').val();
var status_lanjut= $('#status_lanjut').val();
var kd_pj= $('#kd_pj').val();
var umurdaftar= $('#umurdaftar').val();
var sttsumur= $('#sttsumur').val();
var status_bayar= $('#status_bayar').val();
var status_poli= $('#status_poli').val();

 var typeact = $('#typeact').val();

 var formData = new FormData(form); // tambahan
 formData.append('typeact', typeact); // tambahan

            $.ajax({
                url: "{?=url([ADMIN,'reg_periksa','aksi'])?}",
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
    $('#search_text_reg_periksa').keyup(function () {
        var_tbl_reg_periksa.draw();
    });
    // ==============================================================
    // CLICK TANDA X DI INPUT SEARCH
    // ==============================================================
    $("#searchclear_reg_periksa").click(function () {
        $("#search_text_reg_periksa").val("");
        var_tbl_reg_periksa.draw();
    });

    // ===========================================
    // Ketika tombol Edit di tekan
    // ===========================================

    $("#edit_data_reg_periksa").click(function () {
        var rowData = var_tbl_reg_periksa.rows({ selected: true }).data()[0];
        if (rowData != null) {

            var no_reg = rowData['no_reg'];
var no_rawat = rowData['no_rawat'];
var tgl_registrasi = rowData['tgl_registrasi'];
var jam_reg = rowData['jam_reg'];
var kd_dokter = rowData['kd_dokter'];
var no_rkm_medis = rowData['no_rkm_medis'];
var kd_poli = rowData['kd_poli'];
var p_jawab = rowData['p_jawab'];
var almt_pj = rowData['almt_pj'];
var hubunganpj = rowData['hubunganpj'];
var biaya_reg = rowData['biaya_reg'];
var stts = rowData['stts'];
var stts_daftar = rowData['stts_daftar'];
var status_lanjut = rowData['status_lanjut'];
var kd_pj = rowData['kd_pj'];
var umurdaftar = rowData['umurdaftar'];
var sttsumur = rowData['sttsumur'];
var status_bayar = rowData['status_bayar'];
var status_poli = rowData['status_poli'];



            $("#typeact").val("edit");
  
            $('#no_reg').val(no_reg);
$('#no_rawat').val(no_rawat);
$('#tgl_registrasi').val(tgl_registrasi);
$('#jam_reg').val(jam_reg);
$('#kd_dokter').val(kd_dokter);
$('#no_rkm_medis').val(no_rkm_medis);
$('#kd_poli').val(kd_poli);
$('#p_jawab').val(p_jawab);
$('#almt_pj').val(almt_pj);
$('#hubunganpj').val(hubunganpj);
$('#biaya_reg').val(biaya_reg);
$('#stts').val(stts);
$('#stts_daftar').val(stts_daftar);
$('#status_lanjut').val(status_lanjut);
$('#kd_pj').val(kd_pj);
$('#umurdaftar').val(umurdaftar);
$('#sttsumur').val(sttsumur);
$('#status_bayar').val(status_bayar);
$('#status_poli').val(status_poli);

            //$("#no_reg").prop('disabled', true); // GA BISA DIEDIT KALI DISABLE
            $('#modal-title').text("Edit Data Reg periksa");
            $("#modal_reg_periksa").modal();
        }
        else {
            alert("Silakan pilih data yang akan di edit.");
        }

    });

    // ==============================================================
    // TOMBOL  DELETE DI CLICK
    // ==============================================================
    jQuery("#hapus_data_reg_periksa").click(function () {
        var rowData = var_tbl_reg_periksa.rows({ selected: true }).data()[0];


        if (rowData) {
            var no_rawat = rowData['no_rawat'];
            var a = confirm("Anda yakin akan menghapus data dengan no_rawat=" + no_rawat);
            if (a) {

                $.ajax({
                    url: "{?=url([ADMIN,'reg_periksa','aksi'])?}",
                    method: "POST",
                    data: {
                        no_rawat: no_rawat,
                        typeact: 'del'
                    },
                    success: function (data) {
                        data = JSON.parse(data);
                        if (data.status === 'success') {
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
    jQuery("#tambah_data_reg_periksa").click(function () {

        $('#no_reg').val('');
$('#no_rawat').val('');
$('#tgl_registrasi').val('');
$('#jam_reg').val('');
$('#kd_dokter').val('');
$('#no_rkm_medis').val('');
$('#kd_poli').val('');
$('#p_jawab').val('');
$('#almt_pj').val('');
$('#hubunganpj').val('');
$('#biaya_reg').val('');
$('#stts').val('');
$('#stts_daftar').val('');
$('#status_lanjut').val('');
$('#kd_pj').val('');
$('#umurdaftar').val('');
$('#sttsumur').val('');
$('#status_bayar').val('');
$('#status_poli').val('');


        $("#typeact").val("add");
        $("#no_reg").prop('disabled', false);
        
        $('#modal-title').text("Tambah Data Reg periksa");
        $("#modal_reg_periksa").modal();
    });

    // ===========================================
    // Ketika tombol lihat data di tekan
    // ===========================================
    $("#lihat_data_reg_periksa").click(function () {

        var search_field_reg_periksa = $('#search_field_reg_periksa').val();
        var search_text_reg_periksa = $('#search_text_reg_periksa').val();

        $.ajax({
            url: "{?=url([ADMIN,'reg_periksa','aksi'])?}",
            method: "POST",
            data: {
                typeact: 'lihat', 
                search_field_reg_periksa: search_field_reg_periksa, 
                search_text_reg_periksa: search_text_reg_periksa
            },
            dataType: 'json',
            success: function (res) {
                var eTable = "<div class='table-responsive'><table id='tbl_lihat_reg_periksa' class='table display dataTable' style='width:100%'><thead><th>No Reg</th><th>No Rawat</th><th>Tgl Registrasi</th><th>Jam Reg</th><th>Kd Dokter</th><th>No Rkm Medis</th><th>Kd Poli</th><th>P Jawab</th><th>Almt Pj</th><th>Hubunganpj</th><th>Biaya Reg</th><th>Stts</th><th>Stts Daftar</th><th>Status Lanjut</th><th>Kd Pj</th><th>Umurdaftar</th><th>Sttsumur</th><th>Status Bayar</th><th>Status Poli</th></thead>";
                for (var i = 0; i < res.length; i++) {
                    eTable += "<tr>";
                    eTable += '<td>' + res[i]['no_reg'] + '</td>';
eTable += '<td>' + res[i]['no_rawat'] + '</td>';
eTable += '<td>' + res[i]['tgl_registrasi'] + '</td>';
eTable += '<td>' + res[i]['jam_reg'] + '</td>';
eTable += '<td>' + res[i]['kd_dokter'] + '</td>';
eTable += '<td>' + res[i]['no_rkm_medis'] + '</td>';
eTable += '<td>' + res[i]['kd_poli'] + '</td>';
eTable += '<td>' + res[i]['p_jawab'] + '</td>';
eTable += '<td>' + res[i]['almt_pj'] + '</td>';
eTable += '<td>' + res[i]['hubunganpj'] + '</td>';
eTable += '<td>' + res[i]['biaya_reg'] + '</td>';
eTable += '<td>' + res[i]['stts'] + '</td>';
eTable += '<td>' + res[i]['stts_daftar'] + '</td>';
eTable += '<td>' + res[i]['status_lanjut'] + '</td>';
eTable += '<td>' + res[i]['kd_pj'] + '</td>';
eTable += '<td>' + res[i]['umurdaftar'] + '</td>';
eTable += '<td>' + res[i]['sttsumur'] + '</td>';
eTable += '<td>' + res[i]['status_bayar'] + '</td>';
eTable += '<td>' + res[i]['status_poli'] + '</td>';
                    eTable += "</tr>";
                }
                eTable += "</tbody></table></div>";
                $('#forTable_reg_periksa').html(eTable);
            }
        });

        $('#modal-title').text("Lihat Data");
        $("#modal_lihat_reg_periksa").modal();
    });

    // ==============================================================
    // TOMBOL DETAIL reg_periksa DI CLICK
    // ==============================================================
    jQuery("#lihat_detail_reg_periksa").click(function (event) {

        var rowData = var_tbl_reg_periksa.rows({ selected: true }).data()[0];

        if (rowData) {
var no_reg = rowData['no_reg'];
            var baseURL = mlite.url + '/' + mlite.admin;
            event.preventDefault();
            var loadURL =  baseURL + '/reg_periksa/detail/' + no_reg + '?t=' + mlite.token;
        
            var modal = $('#modal_detail_reg_periksa');
            var modalContent = $('#modal_detail_reg_periksa .modal-content');
        
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
        doc.text("Tabel Data Reg Periksa", 20, 95, null, null, null);
        const totalPagesExp = "{total_pages_count_string}";        
        doc.autoTable({
            html: '#tbl_lihat_reg_periksa',
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
        // doc.save('table_data_reg_periksa.pdf')
        window.open(doc.output('bloburl'), '_blank',"toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes");  
              
    })

    // ===========================================
    // Ketika tombol export xlsx di tekan
    // ===========================================
    $("#export_xlsx").click(function () {
        let tbl1 = document.getElementById("tbl_lihat_reg_periksa");
        let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
        let a = XLSX.utils.sheet_to_json(worksheet_tmp1, { header: 1 });
        let worksheet1 = XLSX.utils.json_to_sheet(a, { skipHeader: true });
        const new_workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(new_workbook, worksheet1, "Data reg_periksa");
        XLSX.writeFile(new_workbook, 'tmp_file.xls');
    })
});