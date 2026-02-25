jQuery().ready(function () {
    var var_tbl_penjualan = $('#tbl_penjualan').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'dom': 'Bfrtip',
        'searching': false,
        'select': true,
        'colReorder': true,
        "bInfo" : false,
        "ajax": {
            "url": "{?=url([ADMIN,'penjualan_bebas','data'])?}",
            "dataType": "json",
            "type": "POST",
            "data": function (data) {

                // Read values
                var search_field_penjualan = $('#search_field_penjualan').val();
                var search_text_penjualan = $('#search_text_penjualan').val();
                
                data.search_field_penjualan = search_field_penjualan;
                data.search_text_penjualan = search_text_penjualan;
                
            }
        },
        "columns": [
{ 'data': 'nota_jual' },
{ 'data': 'tgl_jual' },
{ 'data': 'nip' },
{ 'data': 'no_rkm_medis' },
{ 'data': 'nm_pasien' },
{ 'data': 'keterangan' },
{ 'data': 'jns_jual' },
{ 'data': 'ongkir' },
{ 'data': 'ppn' },
{ 'data': 'status' },
{ 'data': 'kd_bangsal' },
{ 'data': 'kd_rek' },
{ 'data': 'nama_bayar' }

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
{ 'targets': 12}

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

    $("form[name='form_penjualan']").validate({
        rules: {
nota_jual: 'required',
tgl_jual: 'required',
nip: 'required',
no_rkm_medis: 'required',
nm_pasien: 'required',
keterangan: 'required',
jns_jual: 'required',
ongkir: 'required',
ppn: 'required',
status: 'required',
kd_bangsal: 'required',
kd_rek: 'required',
nama_bayar: 'required'

        },
        messages: {
nota_jual:'nota_jual tidak boleh kosong!',
tgl_jual:'tgl_jual tidak boleh kosong!',
nip:'nip tidak boleh kosong!',
no_rkm_medis:'no_rkm_medis tidak boleh kosong!',
nm_pasien:'nm_pasien tidak boleh kosong!',
keterangan:'keterangan tidak boleh kosong!',
jns_jual:'jns_jual tidak boleh kosong!',
ongkir:'ongkir tidak boleh kosong!',
ppn:'ppn tidak boleh kosong!',
status:'status tidak boleh kosong!',
kd_bangsal:'kd_bangsal tidak boleh kosong!',
kd_rek:'kd_rek tidak boleh kosong!',
nama_bayar:'nama_bayar tidak boleh kosong!'

        },
        submitHandler: function (form) {
 var nota_jual= $('#nota_jual').val();
var tgl_jual= $('#tgl_jual').val();
var nip= $('#nip').val();
var no_rkm_medis= $('#no_rkm_medis').val();
var nm_pasien= $('#nm_pasien').val();
var keterangan= $('#keterangan').val();
var jns_jual= $('#jns_jual').val();
var ongkir= $('#ongkir').val();
var ppn= $('#ppn').val();
var status= $('#status').val();
var kd_bangsal= $('#kd_bangsal').val();
var kd_rek= $('#kd_rek').val();
var nama_bayar= $('#nama_bayar').val();

 var typeact = $('#typeact').val();

 var formData = new FormData(form); // tambahan
 formData.append('typeact', typeact); // tambahan

            $.ajax({
                url: "{?=url([ADMIN,'penjualan_bebas','aksi'])?}",
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
    $('#search_text_penjualan').keyup(function () {
        var_tbl_penjualan.draw();
    });
    // ==============================================================
    // CLICK TANDA X DI INPUT SEARCH
    // ==============================================================
    $("#searchclear_penjualan").click(function () {
        $("#search_text_penjualan").val("");
        var_tbl_penjualan.draw();
    });

    // ===========================================
    // Ketika tombol Edit di tekan
    // ===========================================

    $("#edit_data_penjualan").click(function () {
        var rowData = var_tbl_penjualan.rows({ selected: true }).data()[0];
        if (rowData != null) {

            var nota_jual = rowData['nota_jual'];
var tgl_jual = rowData['tgl_jual'];
var nip = rowData['nip'];
var no_rkm_medis = rowData['no_rkm_medis'];
var nm_pasien = rowData['nm_pasien'];
var keterangan = rowData['keterangan'];
var jns_jual = rowData['jns_jual'];
var ongkir = rowData['ongkir'];
var ppn = rowData['ppn'];
var status = rowData['status'];
var kd_bangsal = rowData['kd_bangsal'];
var kd_rek = rowData['kd_rek'];
var nama_bayar = rowData['nama_bayar'];



            $("#typeact").val("edit");
  
            $('#nota_jual').val(nota_jual);
$('#tgl_jual').val(tgl_jual);
$('#nip').val(nip);
$('#no_rkm_medis').val(no_rkm_medis);
$('#nm_pasien').val(nm_pasien);
$('#keterangan').val(keterangan);
$('#jns_jual').val(jns_jual);
$('#ongkir').val(ongkir);
$('#ppn').val(ppn);
$('#status').val(status);
$('#kd_bangsal').val(kd_bangsal);
$('#kd_rek').val(kd_rek);
$('#nama_bayar').val(nama_bayar);

            //$("#nota_jual").prop('disabled', true); // GA BISA DIEDIT KALI DISABLE
            $('#modal-title').text("Edit Data Penjualan bebas");
            $("#modal_penjualan").modal();
        }
        else {
            alert("Silakan pilih data yang akan di edit.");
        }

    });

    // ==============================================================
    // TOMBOL  DELETE DI CLICK
    // ==============================================================
    jQuery("#hapus_data_penjualan").click(function () {
        var rowData = var_tbl_penjualan.rows({ selected: true }).data()[0];


        if (rowData) {
var nota_jual = rowData['nota_jual'];
            var a = confirm("Anda yakin akan menghapus data dengan nota_jual=" + nota_jual);
            if (a) {

                $.ajax({
                    url: "{?=url([ADMIN,'penjualan_bebas','aksi'])?}",
                    method: "POST",
                    data: {
                        nota_jual: nota_jual,
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
    jQuery("#tambah_data_penjualan").click(function () {

        $('#nota_jual').val('');
$('#tgl_jual').val('');
$('#nip').val('');
$('#no_rkm_medis').val('');
$('#nm_pasien').val('');
$('#keterangan').val('');
$('#jns_jual').val('');
$('#ongkir').val('');
$('#ppn').val('');
$('#status').val('');
$('#kd_bangsal').val('');
$('#kd_rek').val('');
$('#nama_bayar').val('');


        $("#typeact").val("add");
        $("#nota_jual").prop('disabled', false);
        
        $('#modal-title').text("Tambah Data Penjualan bebas");
        $("#modal_penjualan").modal();
    });

    // ===========================================
    // Ketika tombol lihat data di tekan
    // ===========================================
    $("#lihat_data_penjualan").click(function () {

        var search_field_penjualan = $('#search_field_penjualan').val();
        var search_text_penjualan = $('#search_text_penjualan').val();

        $.ajax({
            url: "{?=url([ADMIN,'penjualan_bebas','aksi'])?}",
            method: "POST",
            data: {
                typeact: 'lihat', 
                search_field_penjualan: search_field_penjualan, 
                search_text_penjualan: search_text_penjualan
            },
            dataType: 'json',
            success: function (res) {
                var eTable = "<div class='table-responsive'><table id='tbl_lihat_penjualan' class='table display dataTable' style='width:100%'><thead><th>Nota Jual</th><th>Tgl Jual</th><th>Nip</th><th>No Rkm Medis</th><th>Nm Pasien</th><th>Keterangan</th><th>Jns Jual</th><th>Ongkir</th><th>Ppn</th><th>Status</th><th>Kd Bangsal</th><th>Kd Rek</th><th>Nama Bayar</th></thead>";
                for (var i = 0; i < res.length; i++) {
                    eTable += "<tr>";
                    eTable += '<td>' + res[i]['nota_jual'] + '</td>';
eTable += '<td>' + res[i]['tgl_jual'] + '</td>';
eTable += '<td>' + res[i]['nip'] + '</td>';
eTable += '<td>' + res[i]['no_rkm_medis'] + '</td>';
eTable += '<td>' + res[i]['nm_pasien'] + '</td>';
eTable += '<td>' + res[i]['keterangan'] + '</td>';
eTable += '<td>' + res[i]['jns_jual'] + '</td>';
eTable += '<td>' + res[i]['ongkir'] + '</td>';
eTable += '<td>' + res[i]['ppn'] + '</td>';
eTable += '<td>' + res[i]['status'] + '</td>';
eTable += '<td>' + res[i]['kd_bangsal'] + '</td>';
eTable += '<td>' + res[i]['kd_rek'] + '</td>';
eTable += '<td>' + res[i]['nama_bayar'] + '</td>';
                    eTable += "</tr>";
                }
                eTable += "</tbody></table></div>";
                $('#forTable_penjualan').html(eTable);
            }
        });

        $('#modal-title').text("Lihat Data");
        $("#modal_lihat_penjualan").modal();
    });

    // ==============================================================
    // TOMBOL DETAIL penjualan DI CLICK
    // ==============================================================
    jQuery("#lihat_detail_penjualan").click(function (event) {

        var rowData = var_tbl_penjualan.rows({ selected: true }).data()[0];

        if (rowData) {
var nota_jual = rowData['nota_jual'];
            var baseURL = mlite.url + '/' + mlite.admin;
            event.preventDefault();
            var loadURL =  baseURL + '/penjualan_bebas/detail/' + nota_jual + '?t=' + mlite.token;
        
            var modal = $('#modal_detail_penjualan');
            var modalContent = $('#modal_detail_penjualan .modal-content');
        
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
        doc.text("Tabel Data Penjualan", 20, 95, null, null, null);
        const totalPagesExp = "{total_pages_count_string}";        
        doc.autoTable({
            html: '#tbl_lihat_penjualan',
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
        // doc.save('table_data_penjualan.pdf')
        window.open(doc.output('bloburl'), '_blank',"toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes");  
              
    })

    // ===========================================
    // Ketika tombol export xlsx di tekan
    // ===========================================
    $("#export_xlsx").click(function () {
        let tbl1 = document.getElementById("tbl_lihat_penjualan");
        let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
        let a = XLSX.utils.sheet_to_json(worksheet_tmp1, { header: 1 });
        let worksheet1 = XLSX.utils.json_to_sheet(a, { skipHeader: true });
        const new_workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(new_workbook, worksheet1, "Data penjualan");
        XLSX.writeFile(new_workbook, 'tmp_file.xls');
    })
});