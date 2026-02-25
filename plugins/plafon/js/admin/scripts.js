jQuery().ready(function () {
    var var_tbl_plafon = $('#tbl_plafon').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'dom': 'Bfrtip',
        'searching': false,
        'select': true,
        'colReorder': true,
        "bInfo" : false,
        "ajax": {
            "url": "{?=url([ADMIN,'plafon','data'])?}",
            "dataType": "json",
            "type": "POST",
            "data": function (data) {

                // Read values
                var search_field_plafon = $('#search_field_plafon').val();
                var search_text_plafon = $('#search_text_plafon').val();
                
                data.search_field_plafon = search_field_plafon;
                data.search_text_plafon = search_text_plafon;
                
            }
        },
        "columns": [
{ 'data': 'no_sep' },
{ 'data': 'code_cbg' },
{ 'data': 'deskripsi' },
{ 'data': 'tarif' }

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

    $("form[name='form_plafon']").validate({
        rules: {
no_sep: 'required',
code_cbg: 'required',
deskripsi: 'required',
tarif: 'required'

        },
        messages: {
no_sep:'no_sep tidak boleh kosong!',
code_cbg:'code_cbg tidak boleh kosong!',
deskripsi:'deskripsi tidak boleh kosong!',
tarif:'tarif tidak boleh kosong!'

        },
        submitHandler: function (form) {
 var no_sep= $('#no_sep').val();
var code_cbg= $('#code_cbg').val();
var deskripsi= $('#deskripsi').val();
var tarif= $('#tarif').val();

 var typeact = $('#typeact').val();

 var formData = new FormData(form); // tambahan
 formData.append('typeact', typeact); // tambahan

            $.ajax({
                url: "{?=url([ADMIN,'plafon','aksi'])?}",
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
    $('#search_text_plafon').keyup(function () {
        var_tbl_plafon.draw();
    });
    // ==============================================================
    // CLICK TANDA X DI INPUT SEARCH
    // ==============================================================
    $("#searchclear_plafon").click(function () {
        $("#search_text_plafon").val("");
        var_tbl_plafon.draw();
    });

    // ===========================================
    // Ketika tombol Edit di tekan
    // ===========================================

    $("#edit_data_plafon").click(function () {
        var rowData = var_tbl_plafon.rows({ selected: true }).data()[0];
        if (rowData != null) {

            var no_sep = rowData['no_sep'];
var code_cbg = rowData['code_cbg'];
var deskripsi = rowData['deskripsi'];
var tarif = rowData['tarif'];



            $("#typeact").val("edit");
  
            $('#no_sep').val(no_sep);
$('#code_cbg').val(code_cbg);
$('#deskripsi').val(deskripsi);
$('#tarif').val(tarif);

            //$("#no_sep").prop('disabled', true); // GA BISA DIEDIT KALI DISABLE
            $('#modal-title').text("Edit Data plafon");
            $("#modal_plafon").modal();
        }
        else {
            alert("Silakan pilih data yang akan di edit.");
        }

    });

    // ==============================================================
    // TOMBOL  DELETE DI CLICK
    // ==============================================================
    jQuery("#hapus_data_plafon").click(function () {
        var rowData = var_tbl_plafon.rows({ selected: true }).data()[0];


        if (rowData) {
var no_sep = rowData['no_sep'];
            var a = confirm("Anda yakin akan menghapus data dengan no_sep=" + no_sep);
            if (a) {

                $.ajax({
                    url: "{?=url([ADMIN,'plafon','aksi'])?}",
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
    jQuery("#tambah_data_plafon").click(function () {

        $('#no_sep').val('');
$('#code_cbg').val('');
$('#deskripsi').val('');
$('#tarif').val('');


        $("#typeact").val("add");
        $("#no_sep").prop('disabled', false);
        
        $('#modal-title').text("Tambah Data plafon");
        $("#modal_plafon").modal();
    });

    // ===========================================
    // Ketika tombol lihat data di tekan
    // ===========================================
    $("#lihat_data_plafon").click(function () {

        var search_field_plafon = $('#search_field_plafon').val();
        var search_text_plafon = $('#search_text_plafon').val();

        $.ajax({
            url: "{?=url([ADMIN,'plafon','aksi'])?}",
            method: "POST",
            data: {
                typeact: 'lihat', 
                search_field_plafon: search_field_plafon, 
                search_text_plafon: search_text_plafon
            },
            dataType: 'json',
            success: function (res) {
                var eTable = "<div class='table-responsive'><table id='tbl_lihat_plafon' class='table display dataTable' style='width:100%'><thead><th>No Sep</th><th>Code Cbg</th><th>Deskripsi</th><th>Tarif</th></thead>";
                for (var i = 0; i < res.length; i++) {
                    eTable += "<tr>";
                    eTable += '<td>' + res[i]['no_sep'] + '</td>';
eTable += '<td>' + res[i]['code_cbg'] + '</td>';
eTable += '<td>' + res[i]['deskripsi'] + '</td>';
eTable += '<td>' + res[i]['tarif'] + '</td>';
                    eTable += "</tr>";
                }
                eTable += "</tbody></table></div>";
                $('#forTable_plafon').html(eTable);
            }
        });

        $('#modal-title').text("Lihat Data");
        $("#modal_lihat_plafon").modal();
    });

    // ==============================================================
    // TOMBOL DETAIL plafon DI CLICK
    // ==============================================================
    jQuery("#lihat_detail_plafon").click(function (event) {

        var rowData = var_tbl_plafon.rows({ selected: true }).data()[0];

        if (rowData) {
var no_sep = rowData['no_sep'];
            var baseURL = mlite.url + '/' + mlite.admin;
            event.preventDefault();
            var loadURL =  baseURL + '/plafon/detail/' + no_sep + '?t=' + mlite.token;
        
            var modal = $('#modal_detail_plafon');
            var modalContent = $('#modal_detail_plafon .modal-content');
        
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
        doc.text("Tabel Data Plafon", 20, 95, null, null, null);
        const totalPagesExp = "{total_pages_count_string}";        
        doc.autoTable({
            html: '#tbl_lihat_plafon',
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
        // doc.save('table_data_plafon.pdf')
        window.open(doc.output('bloburl'), '_blank',"toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes");  
              
    })

    // ===========================================
    // Ketika tombol export xlsx di tekan
    // ===========================================
    $("#export_xlsx").click(function () {
        let tbl1 = document.getElementById("tbl_lihat_plafon");
        let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
        let a = XLSX.utils.sheet_to_json(worksheet_tmp1, { header: 1 });
        let worksheet1 = XLSX.utils.json_to_sheet(a, { skipHeader: true });
        const new_workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(new_workbook, worksheet1, "Data plafon");
        XLSX.writeFile(new_workbook, 'tmp_file.xls');
    })
});