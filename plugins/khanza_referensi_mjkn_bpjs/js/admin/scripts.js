jQuery().ready(function () {
    var var_tbl_referensi_mobilejkn_bpjs = $('#tbl_referensi_mobilejkn_bpjs').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'dom': 'Bfrtip',
        'searching': false,
        'select': true,
        'colReorder': true,
        "bInfo" : false,
        "ajax": {
            "url": "{?=url([ADMIN,'khanza_referensi_mjkn_bpjs','data'])?}",
            "dataType": "json",
            "type": "POST",
            "data": function (data) {

                // Read values
                var search_field_referensi_mobilejkn_bpjs = $('#search_field_referensi_mobilejkn_bpjs').val();
                var search_text_referensi_mobilejkn_bpjs = $('#search_text_referensi_mobilejkn_bpjs').val();
                
                data.search_field_referensi_mobilejkn_bpjs = search_field_referensi_mobilejkn_bpjs;
                data.search_text_referensi_mobilejkn_bpjs = search_text_referensi_mobilejkn_bpjs;
                
            }
        },
        "columns": [
{ 'data': 'nobooking' },
{ 'data': 'no_rawat' },
{ 'data': 'nomorkartu' },
{ 'data': 'nik' },
{ 'data': 'nohp' },
{ 'data': 'kodepoli' },
{ 'data': 'pasienbaru' },
{ 'data': 'norm' },
{ 'data': 'tanggalperiksa' },
{ 'data': 'kodedokter' },
{ 'data': 'jampraktek' },
{ 'data': 'jeniskunjungan' },
{ 'data': 'nomorreferensi' },
{ 'data': 'nomorantrean' },
{ 'data': 'angkaantrean' },
{ 'data': 'estimasidilayani' },
{ 'data': 'sisakuotajkn' },
{ 'data': 'kuotajkn' },
{ 'data': 'sisakuotanonjkn' },
{ 'data': 'kuotanonjkn' },
{ 'data': 'status' },
{ 'data': 'validasi' },
{ 'data': 'statuskirim' }

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
{ 'targets': 22}

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

    $("form[name='form_referensi_mobilejkn_bpjs']").validate({
        rules: {
nobooking: 'required',
no_rawat: 'required',
nomorkartu: 'required',
nik: 'required',
nohp: 'required',
kodepoli: 'required',
pasienbaru: 'required',
norm: 'required',
tanggalperiksa: 'required',
kodedokter: 'required',
jampraktek: 'required',
jeniskunjungan: 'required',
nomorreferensi: 'required',
nomorantrean: 'required',
angkaantrean: 'required',
estimasidilayani: 'required',
sisakuotajkn: 'required',
kuotajkn: 'required',
sisakuotanonjkn: 'required',
kuotanonjkn: 'required',
status: 'required',
validasi: 'required',
statuskirim: 'required'

        },
        messages: {
nobooking:'nobooking tidak boleh kosong!',
no_rawat:'no_rawat tidak boleh kosong!',
nomorkartu:'nomorkartu tidak boleh kosong!',
nik:'nik tidak boleh kosong!',
nohp:'nohp tidak boleh kosong!',
kodepoli:'kodepoli tidak boleh kosong!',
pasienbaru:'pasienbaru tidak boleh kosong!',
norm:'norm tidak boleh kosong!',
tanggalperiksa:'tanggalperiksa tidak boleh kosong!',
kodedokter:'kodedokter tidak boleh kosong!',
jampraktek:'jampraktek tidak boleh kosong!',
jeniskunjungan:'jeniskunjungan tidak boleh kosong!',
nomorreferensi:'nomorreferensi tidak boleh kosong!',
nomorantrean:'nomorantrean tidak boleh kosong!',
angkaantrean:'angkaantrean tidak boleh kosong!',
estimasidilayani:'estimasidilayani tidak boleh kosong!',
sisakuotajkn:'sisakuotajkn tidak boleh kosong!',
kuotajkn:'kuotajkn tidak boleh kosong!',
sisakuotanonjkn:'sisakuotanonjkn tidak boleh kosong!',
kuotanonjkn:'kuotanonjkn tidak boleh kosong!',
status:'status tidak boleh kosong!',
validasi:'validasi tidak boleh kosong!',
statuskirim:'statuskirim tidak boleh kosong!'

        },
        submitHandler: function (form) {
 var nobooking= $('#nobooking').val();
var no_rawat= $('#no_rawat').val();
var nomorkartu= $('#nomorkartu').val();
var nik= $('#nik').val();
var nohp= $('#nohp').val();
var kodepoli= $('#kodepoli').val();
var pasienbaru= $('#pasienbaru').val();
var norm= $('#norm').val();
var tanggalperiksa= $('#tanggalperiksa').val();
var kodedokter= $('#kodedokter').val();
var jampraktek= $('#jampraktek').val();
var jeniskunjungan= $('#jeniskunjungan').val();
var nomorreferensi= $('#nomorreferensi').val();
var nomorantrean= $('#nomorantrean').val();
var angkaantrean= $('#angkaantrean').val();
var estimasidilayani= $('#estimasidilayani').val();
var sisakuotajkn= $('#sisakuotajkn').val();
var kuotajkn= $('#kuotajkn').val();
var sisakuotanonjkn= $('#sisakuotanonjkn').val();
var kuotanonjkn= $('#kuotanonjkn').val();
var status= $('#status').val();
var validasi= $('#validasi').val();
var statuskirim= $('#statuskirim').val();

 var typeact = $('#typeact').val();

 var formData = new FormData(form); // tambahan
 formData.append('typeact', typeact); // tambahan

            $.ajax({
                url: "{?=url([ADMIN,'khanza_referensi_mjkn_bpjs','aksi'])?}",
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
    $('#search_text_referensi_mobilejkn_bpjs').keyup(function () {
        var_tbl_referensi_mobilejkn_bpjs.draw();
    });
    // ==============================================================
    // CLICK TANDA X DI INPUT SEARCH
    // ==============================================================
    $("#searchclear_referensi_mobilejkn_bpjs").click(function () {
        $("#search_text_referensi_mobilejkn_bpjs").val("");
        var_tbl_referensi_mobilejkn_bpjs.draw();
    });

    // ===========================================
    // Ketika tombol Edit di tekan
    // ===========================================

    $("#edit_data_referensi_mobilejkn_bpjs").click(function () {
        var rowData = var_tbl_referensi_mobilejkn_bpjs.rows({ selected: true }).data()[0];
        if (rowData != null) {

            var nobooking = rowData['nobooking'];
var no_rawat = rowData['no_rawat'];
var nomorkartu = rowData['nomorkartu'];
var nik = rowData['nik'];
var nohp = rowData['nohp'];
var kodepoli = rowData['kodepoli'];
var pasienbaru = rowData['pasienbaru'];
var norm = rowData['norm'];
var tanggalperiksa = rowData['tanggalperiksa'];
var kodedokter = rowData['kodedokter'];
var jampraktek = rowData['jampraktek'];
var jeniskunjungan = rowData['jeniskunjungan'];
var nomorreferensi = rowData['nomorreferensi'];
var nomorantrean = rowData['nomorantrean'];
var angkaantrean = rowData['angkaantrean'];
var estimasidilayani = rowData['estimasidilayani'];
var sisakuotajkn = rowData['sisakuotajkn'];
var kuotajkn = rowData['kuotajkn'];
var sisakuotanonjkn = rowData['sisakuotanonjkn'];
var kuotanonjkn = rowData['kuotanonjkn'];
var status = rowData['status'];
var validasi = rowData['validasi'];
var statuskirim = rowData['statuskirim'];



            $("#typeact").val("edit");
  
            $('#nobooking').val(nobooking);
$('#no_rawat').val(no_rawat);
$('#nomorkartu').val(nomorkartu);
$('#nik').val(nik);
$('#nohp').val(nohp);
$('#kodepoli').val(kodepoli);
$('#pasienbaru').val(pasienbaru);
$('#norm').val(norm);
$('#tanggalperiksa').val(tanggalperiksa);
$('#kodedokter').val(kodedokter);
$('#jampraktek').val(jampraktek);
$('#jeniskunjungan').val(jeniskunjungan);
$('#nomorreferensi').val(nomorreferensi);
$('#nomorantrean').val(nomorantrean);
$('#angkaantrean').val(angkaantrean);
$('#estimasidilayani').val(estimasidilayani);
$('#sisakuotajkn').val(sisakuotajkn);
$('#kuotajkn').val(kuotajkn);
$('#sisakuotanonjkn').val(sisakuotanonjkn);
$('#kuotanonjkn').val(kuotanonjkn);
$('#status').val(status);
$('#validasi').val(validasi);
$('#statuskirim').val(statuskirim);

            //$("#nobooking").prop('disabled', true); // GA BISA DIEDIT KALI DISABLE
            $('#modal-title').text("Edit Data khanza referensi mjkn bpjs");
            $("#modal_referensi_mobilejkn_bpjs").modal();
        }
        else {
            alert("Silakan pilih data yang akan di edit.");
        }

    });

    // ==============================================================
    // TOMBOL  DELETE DI CLICK
    // ==============================================================
    jQuery("#hapus_data_referensi_mobilejkn_bpjs").click(function () {
        var rowData = var_tbl_referensi_mobilejkn_bpjs.rows({ selected: true }).data()[0];


        if (rowData) {
var nobooking = rowData['nobooking'];
            var a = confirm("Anda yakin akan menghapus data dengan nobooking=" + nobooking);
            if (a) {

                $.ajax({
                    url: "{?=url([ADMIN,'khanza_referensi_mjkn_bpjs','aksi'])?}",
                    method: "POST",
                    data: {
                        nobooking: nobooking,
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
    jQuery("#tambah_data_referensi_mobilejkn_bpjs").click(function () {

        $('#nobooking').val('');
$('#no_rawat').val('');
$('#nomorkartu').val('');
$('#nik').val('');
$('#nohp').val('');
$('#kodepoli').val('');
$('#pasienbaru').val('');
$('#norm').val('');
$('#tanggalperiksa').val('');
$('#kodedokter').val('');
$('#jampraktek').val('');
$('#jeniskunjungan').val('');
$('#nomorreferensi').val('');
$('#nomorantrean').val('');
$('#angkaantrean').val('');
$('#estimasidilayani').val('');
$('#sisakuotajkn').val('');
$('#kuotajkn').val('');
$('#sisakuotanonjkn').val('');
$('#kuotanonjkn').val('');
$('#status').val('');
$('#validasi').val('');
$('#statuskirim').val('');


        $("#typeact").val("add");
        $("#nobooking").prop('disabled', false);
        
        $('#modal-title').text("Tambah Data khanza referensi mjkn bpjs");
        $("#modal_referensi_mobilejkn_bpjs").modal();
    });

    // ===========================================
    // Ketika tombol lihat data di tekan
    // ===========================================
    $("#lihat_data_referensi_mobilejkn_bpjs").click(function () {

        var search_field_referensi_mobilejkn_bpjs = $('#search_field_referensi_mobilejkn_bpjs').val();
        var search_text_referensi_mobilejkn_bpjs = $('#search_text_referensi_mobilejkn_bpjs').val();

        $.ajax({
            url: "{?=url([ADMIN,'khanza_referensi_mjkn_bpjs','aksi'])?}",
            method: "POST",
            data: {
                typeact: 'lihat', 
                search_field_referensi_mobilejkn_bpjs: search_field_referensi_mobilejkn_bpjs, 
                search_text_referensi_mobilejkn_bpjs: search_text_referensi_mobilejkn_bpjs
            },
            dataType: 'json',
            success: function (res) {
                var eTable = "<div class='table-responsive'><table id='tbl_lihat_referensi_mobilejkn_bpjs' class='table display dataTable' style='width:100%'><thead><th>Nobooking</th><th>No Rawat</th><th>Nomorkartu</th><th>Nik</th><th>Nohp</th><th>Kodepoli</th><th>Pasienbaru</th><th>Norm</th><th>Tanggalperiksa</th><th>Kodedokter</th><th>Jampraktek</th><th>Jeniskunjungan</th><th>Nomorreferensi</th><th>Nomorantrean</th><th>Angkaantrean</th><th>Estimasidilayani</th><th>Sisakuotajkn</th><th>Kuotajkn</th><th>Sisakuotanonjkn</th><th>Kuotanonjkn</th><th>Status</th><th>Validasi</th><th>Statuskirim</th></thead>";
                for (var i = 0; i < res.length; i++) {
                    eTable += "<tr>";
                    eTable += '<td>' + res[i]['nobooking'] + '</td>';
eTable += '<td>' + res[i]['no_rawat'] + '</td>';
eTable += '<td>' + res[i]['nomorkartu'] + '</td>';
eTable += '<td>' + res[i]['nik'] + '</td>';
eTable += '<td>' + res[i]['nohp'] + '</td>';
eTable += '<td>' + res[i]['kodepoli'] + '</td>';
eTable += '<td>' + res[i]['pasienbaru'] + '</td>';
eTable += '<td>' + res[i]['norm'] + '</td>';
eTable += '<td>' + res[i]['tanggalperiksa'] + '</td>';
eTable += '<td>' + res[i]['kodedokter'] + '</td>';
eTable += '<td>' + res[i]['jampraktek'] + '</td>';
eTable += '<td>' + res[i]['jeniskunjungan'] + '</td>';
eTable += '<td>' + res[i]['nomorreferensi'] + '</td>';
eTable += '<td>' + res[i]['nomorantrean'] + '</td>';
eTable += '<td>' + res[i]['angkaantrean'] + '</td>';
eTable += '<td>' + res[i]['estimasidilayani'] + '</td>';
eTable += '<td>' + res[i]['sisakuotajkn'] + '</td>';
eTable += '<td>' + res[i]['kuotajkn'] + '</td>';
eTable += '<td>' + res[i]['sisakuotanonjkn'] + '</td>';
eTable += '<td>' + res[i]['kuotanonjkn'] + '</td>';
eTable += '<td>' + res[i]['status'] + '</td>';
eTable += '<td>' + res[i]['validasi'] + '</td>';
eTable += '<td>' + res[i]['statuskirim'] + '</td>';
                    eTable += "</tr>";
                }
                eTable += "</tbody></table></div>";
                $('#forTable_referensi_mobilejkn_bpjs').html(eTable);
            }
        });

        $('#modal-title').text("Lihat Data");
        $("#modal_lihat_referensi_mobilejkn_bpjs").modal();
    });

    // ==============================================================
    // TOMBOL DETAIL referensi_mobilejkn_bpjs DI CLICK
    // ==============================================================
    jQuery("#lihat_detail_referensi_mobilejkn_bpjs").click(function (event) {

        var rowData = var_tbl_referensi_mobilejkn_bpjs.rows({ selected: true }).data()[0];

        if (rowData) {
var nobooking = rowData['nobooking'];
            var baseURL = mlite.url + '/' + mlite.admin;
            event.preventDefault();
            var loadURL =  baseURL + '/khanza_referensi_mjkn_bpjs/detail/' + nobooking + '?t=' + mlite.token;
        
            var modal = $('#modal_detail_referensi_mobilejkn_bpjs');
            var modalContent = $('#modal_detail_referensi_mobilejkn_bpjs .modal-content');
        
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
        doc.text("Tabel Data Referensi Mobilejkn Bpjs", 20, 95, null, null, null);
        const totalPagesExp = "{total_pages_count_string}";        
        doc.autoTable({
            html: '#tbl_lihat_referensi_mobilejkn_bpjs',
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
        // doc.save('table_data_referensi_mobilejkn_bpjs.pdf')
        window.open(doc.output('bloburl'), '_blank',"toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes");  
              
    })

    // ===========================================
    // Ketika tombol export xlsx di tekan
    // ===========================================
    $("#export_xlsx").click(function () {
        let tbl1 = document.getElementById("tbl_lihat_referensi_mobilejkn_bpjs");
        let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
        let a = XLSX.utils.sheet_to_json(worksheet_tmp1, { header: 1 });
        let worksheet1 = XLSX.utils.json_to_sheet(a, { skipHeader: true });
        const new_workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(new_workbook, worksheet1, "Data referensi_mobilejkn_bpjs");
        XLSX.writeFile(new_workbook, 'tmp_file.xls');
    })
});