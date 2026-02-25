jQuery().ready(function () {
    var var_tbl_bridging_surat_kontrol_bpjs = $('#tbl_bridging_surat_kontrol_bpjs').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'dom': 'Bfrtip',
        'searching': false,
        'select': true,
        'colReorder': true,
        "bInfo" : false,
        "ajax": {
            "url": "{?=url([ADMIN,'khanza_surat_kontrol_bpjs','data'])?}",
            "dataType": "json",
            "type": "POST",
            "data": function (data) {

                // Read values
                var search_field_bridging_surat_kontrol_bpjs = $('#search_field_bridging_surat_kontrol_bpjs').val();
                var search_text_bridging_surat_kontrol_bpjs = $('#search_text_bridging_surat_kontrol_bpjs').val();
                
                data.search_field_bridging_surat_kontrol_bpjs = search_field_bridging_surat_kontrol_bpjs;
                data.search_text_bridging_surat_kontrol_bpjs = search_text_bridging_surat_kontrol_bpjs;
                
            }
        },
        "columns": [
{ 'data': 'no_sep' },
{ 'data': 'tgl_surat' },
{ 'data': 'no_surat' },
{ 'data': 'tgl_rencana' },
{ 'data': 'kd_dokter_bpjs' },
{ 'data': 'nm_dokter_bpjs' },
{ 'data': 'kd_poli_bpjs' },
{ 'data': 'nm_poli_bpjs' }

        ],
        "columnDefs": [
{ 'targets': 0},
{ 'targets': 1},
{ 'targets': 2},
{ 'targets': 3},
{ 'targets': 4},
{ 'targets': 5},
{ 'targets': 6},
{ 'targets': 7}

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

    $("form[name='form_bridging_surat_kontrol_bpjs']").validate({
        rules: {
no_sep: 'required',
tgl_surat: 'required',
no_surat: 'required',
tgl_rencana: 'required',
kd_dokter_bpjs: 'required',
nm_dokter_bpjs: 'required',
kd_poli_bpjs: 'required',
nm_poli_bpjs: 'required'

        },
        messages: {
no_sep:'no_sep tidak boleh kosong!',
tgl_surat:'tgl_surat tidak boleh kosong!',
no_surat:'no_surat tidak boleh kosong!',
tgl_rencana:'tgl_rencana tidak boleh kosong!',
kd_dokter_bpjs:'kd_dokter_bpjs tidak boleh kosong!',
nm_dokter_bpjs:'nm_dokter_bpjs tidak boleh kosong!',
kd_poli_bpjs:'kd_poli_bpjs tidak boleh kosong!',
nm_poli_bpjs:'nm_poli_bpjs tidak boleh kosong!'

        },
        submitHandler: function (form) {
 var no_sep= $('#no_sep').val();
var tgl_surat= $('#tgl_surat').val();
var no_surat= $('#no_surat').val();
var tgl_rencana= $('#tgl_rencana').val();
var kd_dokter_bpjs= $('#kd_dokter_bpjs').val();
var nm_dokter_bpjs= $('#nm_dokter_bpjs').val();
var kd_poli_bpjs= $('#kd_poli_bpjs').val();
var nm_poli_bpjs= $('#nm_poli_bpjs').val();

 var typeact = $('#typeact').val();

 var formData = new FormData(form); // tambahan
 formData.append('typeact', typeact); // tambahan

            $.ajax({
                url: "{?=url([ADMIN,'khanza_surat_kontrol_bpjs','aksi'])?}",
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
    $('#search_text_bridging_surat_kontrol_bpjs').keyup(function () {
        var_tbl_bridging_surat_kontrol_bpjs.draw();
    });
    // ==============================================================
    // CLICK TANDA X DI INPUT SEARCH
    // ==============================================================
    $("#searchclear_bridging_surat_kontrol_bpjs").click(function () {
        $("#search_text_bridging_surat_kontrol_bpjs").val("");
        var_tbl_bridging_surat_kontrol_bpjs.draw();
    });

    // ===========================================
    // Ketika tombol Edit di tekan
    // ===========================================

    $("#edit_data_bridging_surat_kontrol_bpjs").click(function () {
        var rowData = var_tbl_bridging_surat_kontrol_bpjs.rows({ selected: true }).data()[0];
        if (rowData != null) {

            var no_sep = rowData['no_sep'];
var tgl_surat = rowData['tgl_surat'];
var no_surat = rowData['no_surat'];
var tgl_rencana = rowData['tgl_rencana'];
var kd_dokter_bpjs = rowData['kd_dokter_bpjs'];
var nm_dokter_bpjs = rowData['nm_dokter_bpjs'];
var kd_poli_bpjs = rowData['kd_poli_bpjs'];
var nm_poli_bpjs = rowData['nm_poli_bpjs'];



            $("#typeact").val("edit");
  
            $('#no_sep').val(no_sep);
$('#tgl_surat').val(tgl_surat);
$('#no_surat').val(no_surat);
$('#tgl_rencana').val(tgl_rencana);
$('#kd_dokter_bpjs').val(kd_dokter_bpjs);
$('#nm_dokter_bpjs').val(nm_dokter_bpjs);
$('#kd_poli_bpjs').val(kd_poli_bpjs);
$('#nm_poli_bpjs').val(nm_poli_bpjs);

            //$("#no_sep").prop('disabled', true); // GA BISA DIEDIT KALI DISABLE
            $('#modal-title').text("Edit Data khanza surat kontrol bpjs");
            $("#modal_bridging_surat_kontrol_bpjs").modal();
        }
        else {
            alert("Silakan pilih data yang akan di edit.");
        }

    });

    // ==============================================================
    // TOMBOL  DELETE DI CLICK
    // ==============================================================
    jQuery("#hapus_data_bridging_surat_kontrol_bpjs").click(function () {
        var rowData = var_tbl_bridging_surat_kontrol_bpjs.rows({ selected: true }).data()[0];


        if (rowData) {
var no_sep = rowData['no_sep'];
            var a = confirm("Anda yakin akan menghapus data dengan no_sep=" + no_sep);
            if (a) {

                $.ajax({
                    url: "{?=url([ADMIN,'khanza_surat_kontrol_bpjs','aksi'])?}",
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
    jQuery("#tambah_data_bridging_surat_kontrol_bpjs").click(function () {

        $('#no_sep').val('');
$('#tgl_surat').val('');
$('#no_surat').val('');
$('#tgl_rencana').val('');
$('#kd_dokter_bpjs').val('');
$('#nm_dokter_bpjs').val('');
$('#kd_poli_bpjs').val('');
$('#nm_poli_bpjs').val('');


        $("#typeact").val("add");
        $("#no_sep").prop('disabled', false);
        
        $('#modal-title').text("Tambah Data khanza surat kontrol bpjs");
        $("#modal_bridging_surat_kontrol_bpjs").modal();
    });

    // ===========================================
    // Ketika tombol lihat data di tekan
    // ===========================================
    $("#lihat_data_bridging_surat_kontrol_bpjs").click(function () {

        var search_field_bridging_surat_kontrol_bpjs = $('#search_field_bridging_surat_kontrol_bpjs').val();
        var search_text_bridging_surat_kontrol_bpjs = $('#search_text_bridging_surat_kontrol_bpjs').val();

        $.ajax({
            url: "{?=url([ADMIN,'khanza_surat_kontrol_bpjs','aksi'])?}",
            method: "POST",
            data: {
                typeact: 'lihat', 
                search_field_bridging_surat_kontrol_bpjs: search_field_bridging_surat_kontrol_bpjs, 
                search_text_bridging_surat_kontrol_bpjs: search_text_bridging_surat_kontrol_bpjs
            },
            dataType: 'json',
            success: function (res) {
                var eTable = "<div class='table-responsive'><table id='tbl_lihat_bridging_surat_kontrol_bpjs' class='table display dataTable' style='width:100%'><thead><th>No Sep</th><th>Tgl Surat</th><th>No Surat</th><th>Tgl Rencana</th><th>Kd Dokter Bpjs</th><th>Nm Dokter Bpjs</th><th>Kd Poli Bpjs</th><th>Nm Poli Bpjs</th></thead>";
                for (var i = 0; i < res.length; i++) {
                    eTable += "<tr>";
                    eTable += '<td>' + res[i]['no_sep'] + '</td>';
eTable += '<td>' + res[i]['tgl_surat'] + '</td>';
eTable += '<td>' + res[i]['no_surat'] + '</td>';
eTable += '<td>' + res[i]['tgl_rencana'] + '</td>';
eTable += '<td>' + res[i]['kd_dokter_bpjs'] + '</td>';
eTable += '<td>' + res[i]['nm_dokter_bpjs'] + '</td>';
eTable += '<td>' + res[i]['kd_poli_bpjs'] + '</td>';
eTable += '<td>' + res[i]['nm_poli_bpjs'] + '</td>';
                    eTable += "</tr>";
                }
                eTable += "</tbody></table></div>";
                $('#forTable_bridging_surat_kontrol_bpjs').html(eTable);
            }
        });

        $('#modal-title').text("Lihat Data");
        $("#modal_lihat_bridging_surat_kontrol_bpjs").modal();
    });

    // ==============================================================
    // TOMBOL DETAIL bridging_surat_kontrol_bpjs DI CLICK
    // ==============================================================
    jQuery("#lihat_detail_bridging_surat_kontrol_bpjs").click(function (event) {

        var rowData = var_tbl_bridging_surat_kontrol_bpjs.rows({ selected: true }).data()[0];

        if (rowData) {
var no_sep = rowData['no_sep'];
            var baseURL = mlite.url + '/' + mlite.admin;
            event.preventDefault();
            var loadURL =  baseURL + '/khanza_surat_kontrol_bpjs/detail/' + no_sep + '?t=' + mlite.token;
        
            var modal = $('#modal_detail_bridging_surat_kontrol_bpjs');
            var modalContent = $('#modal_detail_bridging_surat_kontrol_bpjs .modal-content');
        
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
        doc.text("Tabel Data Bridging Surat Kontrol Bpjs", 20, 95, null, null, null);
        const totalPagesExp = "{total_pages_count_string}";        
        doc.autoTable({
            html: '#tbl_lihat_bridging_surat_kontrol_bpjs',
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
        // doc.save('table_data_bridging_surat_kontrol_bpjs.pdf')
        window.open(doc.output('bloburl'), '_blank',"toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes");  
              
    })

    // ===========================================
    // Ketika tombol export xlsx di tekan
    // ===========================================
    $("#export_xlsx").click(function () {
        let tbl1 = document.getElementById("tbl_lihat_bridging_surat_kontrol_bpjs");
        let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
        let a = XLSX.utils.sheet_to_json(worksheet_tmp1, { header: 1 });
        let worksheet1 = XLSX.utils.json_to_sheet(a, { skipHeader: true });
        const new_workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(new_workbook, worksheet1, "Data bridging_surat_kontrol_bpjs");
        XLSX.writeFile(new_workbook, 'tmp_file.xls');
    })
});