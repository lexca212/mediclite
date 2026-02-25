jQuery().ready(function () {
    var var_tbl_referensi_mobilejkn_bpjs_taskid = $('#tbl_referensi_mobilejkn_bpjs_taskid').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'dom': 'Bfrtip',
        'searching': false,
        'select': true,
        'colReorder': true,
        "bInfo" : false,
        "ajax": {
            "url": "{?=url([ADMIN,'khanza_referensi_mjkn_taskid','data'])?}",
            "dataType": "json",
            "type": "POST",
            "data": function (data) {

                // Read values
                var search_field_referensi_mobilejkn_bpjs_taskid = $('#search_field_referensi_mobilejkn_bpjs_taskid').val();
                var search_text_referensi_mobilejkn_bpjs_taskid = $('#search_text_referensi_mobilejkn_bpjs_taskid').val();
                
                data.search_field_referensi_mobilejkn_bpjs_taskid = search_field_referensi_mobilejkn_bpjs_taskid;
                data.search_text_referensi_mobilejkn_bpjs_taskid = search_text_referensi_mobilejkn_bpjs_taskid;
                
            }
        },
        "columns": [
{ 'data': 'no_rawat' },
{ 'data': 'taskid' },
{ 'data': 'waktu' }

        ],
        "columnDefs": [
{ 'targets': 0},
{ 'targets': 1},
{ 'targets': 2}

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

    $("form[name='form_referensi_mobilejkn_bpjs_taskid']").validate({
        rules: {
no_rawat: 'required',
taskid: 'required',
waktu: 'required'

        },
        messages: {
no_rawat:'no_rawat tidak boleh kosong!',
taskid:'taskid tidak boleh kosong!',
waktu:'waktu tidak boleh kosong!'

        },
        submitHandler: function (form) {
 var no_rawat= $('#no_rawat').val();
var taskid= $('#taskid').val();
var waktu= $('#waktu').val();

 var typeact = $('#typeact').val();

 var formData = new FormData(form); // tambahan
 formData.append('typeact', typeact); // tambahan

            $.ajax({
                url: "{?=url([ADMIN,'khanza_referensi_mjkn_taskid','aksi'])?}",
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
    $('#search_text_referensi_mobilejkn_bpjs_taskid').keyup(function () {
        var_tbl_referensi_mobilejkn_bpjs_taskid.draw();
    });
    // ==============================================================
    // CLICK TANDA X DI INPUT SEARCH
    // ==============================================================
    $("#searchclear_referensi_mobilejkn_bpjs_taskid").click(function () {
        $("#search_text_referensi_mobilejkn_bpjs_taskid").val("");
        var_tbl_referensi_mobilejkn_bpjs_taskid.draw();
    });

    // ===========================================
    // Ketika tombol Edit di tekan
    // ===========================================

    $("#edit_data_referensi_mobilejkn_bpjs_taskid").click(function () {
        var rowData = var_tbl_referensi_mobilejkn_bpjs_taskid.rows({ selected: true }).data()[0];
        if (rowData != null) {

            var no_rawat = rowData['no_rawat'];
var taskid = rowData['taskid'];
var waktu = rowData['waktu'];



            $("#typeact").val("edit");
  
            $('#no_rawat').val(no_rawat);
$('#taskid').val(taskid);
$('#waktu').val(waktu);

            //$("#no_rawat").prop('disabled', true); // GA BISA DIEDIT KALI DISABLE
            $('#modal-title').text("Edit Data khanza referensi mjkn taskid");
            $("#modal_referensi_mobilejkn_bpjs_taskid").modal();
        }
        else {
            alert("Silakan pilih data yang akan di edit.");
        }

    });

    // ==============================================================
    // TOMBOL  DELETE DI CLICK
    // ==============================================================
    jQuery("#hapus_data_referensi_mobilejkn_bpjs_taskid").click(function () {
        var rowData = var_tbl_referensi_mobilejkn_bpjs_taskid.rows({ selected: true }).data()[0];


        if (rowData) {
var no_rawat = rowData['no_rawat'];
            var a = confirm("Anda yakin akan menghapus data dengan no_rawat=" + no_rawat);
            if (a) {

                $.ajax({
                    url: "{?=url([ADMIN,'khanza_referensi_mjkn_taskid','aksi'])?}",
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
    jQuery("#tambah_data_referensi_mobilejkn_bpjs_taskid").click(function () {

        $('#no_rawat').val('');
$('#taskid').val('');
$('#waktu').val('');


        $("#typeact").val("add");
        $("#no_rawat").prop('disabled', false);
        
        $('#modal-title').text("Tambah Data khanza referensi mjkn taskid");
        $("#modal_referensi_mobilejkn_bpjs_taskid").modal();
    });

    // ===========================================
    // Ketika tombol lihat data di tekan
    // ===========================================
    $("#lihat_data_referensi_mobilejkn_bpjs_taskid").click(function () {

        var search_field_referensi_mobilejkn_bpjs_taskid = $('#search_field_referensi_mobilejkn_bpjs_taskid').val();
        var search_text_referensi_mobilejkn_bpjs_taskid = $('#search_text_referensi_mobilejkn_bpjs_taskid').val();

        $.ajax({
            url: "{?=url([ADMIN,'khanza_referensi_mjkn_taskid','aksi'])?}",
            method: "POST",
            data: {
                typeact: 'lihat', 
                search_field_referensi_mobilejkn_bpjs_taskid: search_field_referensi_mobilejkn_bpjs_taskid, 
                search_text_referensi_mobilejkn_bpjs_taskid: search_text_referensi_mobilejkn_bpjs_taskid
            },
            dataType: 'json',
            success: function (res) {
                var eTable = "<div class='table-responsive'><table id='tbl_lihat_referensi_mobilejkn_bpjs_taskid' class='table display dataTable' style='width:100%'><thead><th>No Rawat</th><th>Taskid</th><th>Waktu</th></thead>";
                for (var i = 0; i < res.length; i++) {
                    eTable += "<tr>";
                    eTable += '<td>' + res[i]['no_rawat'] + '</td>';
eTable += '<td>' + res[i]['taskid'] + '</td>';
eTable += '<td>' + res[i]['waktu'] + '</td>';
                    eTable += "</tr>";
                }
                eTable += "</tbody></table></div>";
                $('#forTable_referensi_mobilejkn_bpjs_taskid').html(eTable);
            }
        });

        $('#modal-title').text("Lihat Data");
        $("#modal_lihat_referensi_mobilejkn_bpjs_taskid").modal();
    });

    // ==============================================================
    // TOMBOL DETAIL referensi_mobilejkn_bpjs_taskid DI CLICK
    // ==============================================================
    jQuery("#lihat_detail_referensi_mobilejkn_bpjs_taskid").click(function (event) {

        var rowData = var_tbl_referensi_mobilejkn_bpjs_taskid.rows({ selected: true }).data()[0];

        if (rowData) {
var no_rawat = rowData['no_rawat'];
            var baseURL = mlite.url + '/' + mlite.admin;
            event.preventDefault();
            var loadURL =  baseURL + '/khanza_referensi_mjkn_taskid/detail/' + no_rawat + '?t=' + mlite.token;
        
            var modal = $('#modal_detail_referensi_mobilejkn_bpjs_taskid');
            var modalContent = $('#modal_detail_referensi_mobilejkn_bpjs_taskid .modal-content');
        
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
        doc.text("Tabel Data Referensi Mobilejkn Bpjs Taskid", 20, 95, null, null, null);
        const totalPagesExp = "{total_pages_count_string}";        
        doc.autoTable({
            html: '#tbl_lihat_referensi_mobilejkn_bpjs_taskid',
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
        // doc.save('table_data_referensi_mobilejkn_bpjs_taskid.pdf')
        window.open(doc.output('bloburl'), '_blank',"toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes");  
              
    })

    // ===========================================
    // Ketika tombol export xlsx di tekan
    // ===========================================
    $("#export_xlsx").click(function () {
        let tbl1 = document.getElementById("tbl_lihat_referensi_mobilejkn_bpjs_taskid");
        let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
        let a = XLSX.utils.sheet_to_json(worksheet_tmp1, { header: 1 });
        let worksheet1 = XLSX.utils.json_to_sheet(a, { skipHeader: true });
        const new_workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(new_workbook, worksheet1, "Data referensi_mobilejkn_bpjs_taskid");
        XLSX.writeFile(new_workbook, 'tmp_file.xls');
    })
});