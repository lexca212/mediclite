jQuery().ready(function () {
    var var_tbl_detailjurnal = $('#tbl_detailjurnal').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'dom': 'Bfrtip',
        'searching': false,
        'select': true,
        'colReorder': true,
        "bInfo" : false,
        "ajax": {
            "url": "{?=url([ADMIN,'jurnal_','data'])?}",
            "dataType": "json",
            "type": "POST",
            "data": function (data) {

                // Read values
                var search_field_detailjurnal = $('#search_field_detailjurnal').val();
                var search_text_detailjurnal = $('#search_text_detailjurnal').val();
                
                data.search_field_detailjurnal = search_field_detailjurnal;
                data.search_text_detailjurnal = search_text_detailjurnal;
                
            }
        },
        "columns": [
{ 'data': 'no_jurnal' },
{ 'data': 'kd_rek' },
{ 'data': 'debet' },
{ 'data': 'kredit' }

        ],
        "columnDefs": [
{ 'targets': 0},
{ 'targets': 1},
{ 'targets': 2},
{ 'targets': 3}

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

    $("form[name='form_detailjurnal']").validate({
        rules: {
no_jurnal: 'required',
kd_rek: 'required',
debet: 'required',
kredit: 'required'

        },
        messages: {
no_jurnal:'no_jurnal tidak boleh kosong!',
kd_rek:'kd_rek tidak boleh kosong!',
debet:'debet tidak boleh kosong!',
kredit:'kredit tidak boleh kosong!'

        },
        submitHandler: function (form) {
 var no_jurnal= $('#no_jurnal').val();
var kd_rek= $('#kd_rek').val();
var debet= $('#debet').val();
var kredit= $('#kredit').val();

 var typeact = $('#typeact').val();

 var formData = new FormData(form); // tambahan
 formData.append('typeact', typeact); // tambahan

            $.ajax({
                url: "{?=url([ADMIN,'jurnal_','aksi'])?}",
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
    $('#search_text_detailjurnal').keyup(function () {
        var_tbl_detailjurnal.draw();
    });
    // ==============================================================
    // CLICK TANDA X DI INPUT SEARCH
    // ==============================================================
    $("#searchclear_detailjurnal").click(function () {
        $("#search_text_detailjurnal").val("");
        var_tbl_detailjurnal.draw();
    });

    // ===========================================
    // Ketika tombol Edit di tekan
    // ===========================================

    $("#edit_data_detailjurnal").click(function () {
        var rowData = var_tbl_detailjurnal.rows({ selected: true }).data()[0];
        if (rowData != null) {

            var no_jurnal = rowData['no_jurnal'];
var kd_rek = rowData['kd_rek'];
var debet = rowData['debet'];
var kredit = rowData['kredit'];



            $("#typeact").val("edit");
  
            $('#no_jurnal').val(no_jurnal);
$('#kd_rek').val(kd_rek);
$('#debet').val(debet);
$('#kredit').val(kredit);

            //$("#no_jurnal").prop('disabled', true); // GA BISA DIEDIT KALI DISABLE
            $('#modal-title').text("Edit Data Jurnal ");
            $("#modal_detailjurnal").modal();
        }
        else {
            alert("Silakan pilih data yang akan di edit.");
        }

    });

    // ==============================================================
    // TOMBOL  DELETE DI CLICK
    // ==============================================================
    jQuery("#hapus_data_detailjurnal").click(function () {
        var rowData = var_tbl_detailjurnal.rows({ selected: true }).data()[0];


        if (rowData) {
var no_jurnal = rowData['no_jurnal'];
            var a = confirm("Anda yakin akan menghapus data dengan no_jurnal=" + no_jurnal);
            if (a) {

                $.ajax({
                    url: "{?=url([ADMIN,'jurnal_','aksi'])?}",
                    method: "POST",
                    data: {
                        no_jurnal: no_jurnal,
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
    jQuery("#tambah_data_detailjurnal").click(function () {

        $('#no_jurnal').val('');
$('#kd_rek').val('');
$('#debet').val('');
$('#kredit').val('');


        $("#typeact").val("add");
        $("#no_jurnal").prop('disabled', false);
        
        $('#modal-title').text("Tambah Data Jurnal ");
        $("#modal_detailjurnal").modal();
    });

    // ===========================================
    // Ketika tombol lihat data di tekan
    // ===========================================
    $("#lihat_data_detailjurnal").click(function () {

        var search_field_detailjurnal = $('#search_field_detailjurnal').val();
        var search_text_detailjurnal = $('#search_text_detailjurnal').val();

        $.ajax({
            url: "{?=url([ADMIN,'jurnal_','aksi'])?}",
            method: "POST",
            data: {
                typeact: 'lihat', 
                search_field_detailjurnal: search_field_detailjurnal, 
                search_text_detailjurnal: search_text_detailjurnal
            },
            dataType: 'json',
            success: function (res) {
                var eTable = "<div class='table-responsive'><table id='tbl_lihat_detailjurnal' class='table display dataTable' style='width:100%'><thead><th>No Jurnal</th><th>Kd Rek</th><th>Debet</th><th>Kredit</th></thead>";
                for (var i = 0; i < res.length; i++) {
                    eTable += "<tr>";
                    eTable += '<td>' + res[i]['no_jurnal'] + '</td>';
eTable += '<td>' + res[i]['kd_rek'] + '</td>';
eTable += '<td>' + res[i]['debet'] + '</td>';
eTable += '<td>' + res[i]['kredit'] + '</td>';
                    eTable += "</tr>";
                }
                eTable += "</tbody></table></div>";
                $('#forTable_detailjurnal').html(eTable);
            }
        });

        $('#modal-title').text("Lihat Data");
        $("#modal_lihat_detailjurnal").modal();
    });

    // ==============================================================
    // TOMBOL DETAIL detailjurnal DI CLICK
    // ==============================================================
    jQuery("#lihat_detail_detailjurnal").click(function (event) {

        var rowData = var_tbl_detailjurnal.rows({ selected: true }).data()[0];

        if (rowData) {
var no_jurnal = rowData['no_jurnal'];
            var baseURL = mlite.url + '/' + mlite.admin;
            event.preventDefault();
            var loadURL =  baseURL + '/jurnal_/detail/' + no_jurnal + '?t=' + mlite.token;
        
            var modal = $('#modal_detail_detailjurnal');
            var modalContent = $('#modal_detail_detailjurnal .modal-content');
        
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
        doc.text("Tabel Data Detailjurnal", 20, 95, null, null, null);
        const totalPagesExp = "{total_pages_count_string}";        
        doc.autoTable({
            html: '#tbl_lihat_detailjurnal',
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
        // doc.save('table_data_detailjurnal.pdf')
        window.open(doc.output('bloburl'), '_blank',"toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes");  
              
    })

    // ===========================================
    // Ketika tombol export xlsx di tekan
    // ===========================================
    $("#export_xlsx").click(function () {
        let tbl1 = document.getElementById("tbl_lihat_detailjurnal");
        let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
        let a = XLSX.utils.sheet_to_json(worksheet_tmp1, { header: 1 });
        let worksheet1 = XLSX.utils.json_to_sheet(a, { skipHeader: true });
        const new_workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(new_workbook, worksheet1, "Data detailjurnal");
        XLSX.writeFile(new_workbook, 'tmp_file.xls');
    })
});