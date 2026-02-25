jQuery().ready(function () {
    var var_tbl_opname = $('#tbl_opname').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'dom': 'Bfrtip',
        'searching': false,
        'select': true,
        'colReorder': true,
        "bInfo" : false,
        "ajax": {
            "url": "{?=url([ADMIN,'opm','data'])?}",
            "dataType": "json",
            "type": "POST",
            "data": function (data) {

                // Read values
                var search_field_opname = $('#search_field_opname').val();
                var search_text_opname = $('#search_text_opname').val();
                
                data.search_field_opname = search_field_opname;
                data.search_text_opname = search_text_opname;
                
            }
        },
        "columns": [
{ 'data': 'kode_brng' },
{ 'data': 'h_beli' },
{ 'data': 'tanggal' },
{ 'data': 'stok' },
{ 'data': 'real' },
{ 'data': 'selisih' },
{ 'data': 'nomihilang' },
{ 'data': 'lebih' },
{ 'data': 'nomilebih' },
{ 'data': 'keterangan' },
{ 'data': 'kd_bangsal' },
{ 'data': 'no_batch' },
{ 'data': 'no_faktur' }

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

    $("form[name='form_opname']").validate({
        rules: {
kode_brng: 'required',
h_beli: 'required',
tanggal: 'required',
stok: 'required',
real: 'required',
selisih: 'required',
nomihilang: 'required',
lebih: 'required',
nomilebih: 'required',
keterangan: 'required',
kd_bangsal: 'required',
no_batch: 'required',
no_faktur: 'required'

        },
        messages: {
kode_brng:'kode_brng tidak boleh kosong!',
h_beli:'h_beli tidak boleh kosong!',
tanggal:'tanggal tidak boleh kosong!',
stok:'stok tidak boleh kosong!',
real:'real tidak boleh kosong!',
selisih:'selisih tidak boleh kosong!',
nomihilang:'nomihilang tidak boleh kosong!',
lebih:'lebih tidak boleh kosong!',
nomilebih:'nomilebih tidak boleh kosong!',
keterangan:'keterangan tidak boleh kosong!',
kd_bangsal:'kd_bangsal tidak boleh kosong!',
no_batch:'no_batch tidak boleh kosong!',
no_faktur:'no_faktur tidak boleh kosong!'

        },
        submitHandler: function (form) {
 var kode_brng= $('#kode_brng').val();
var h_beli= $('#h_beli').val();
var tanggal= $('#tanggal').val();
var stok= $('#stok').val();
var real= $('#real').val();
var selisih= $('#selisih').val();
var nomihilang= $('#nomihilang').val();
var lebih= $('#lebih').val();
var nomilebih= $('#nomilebih').val();
var keterangan= $('#keterangan').val();
var kd_bangsal= $('#kd_bangsal').val();
var no_batch= $('#no_batch').val();
var no_faktur= $('#no_faktur').val();

 var typeact = $('#typeact').val();

 var formData = new FormData(form); // tambahan
 formData.append('typeact', typeact); // tambahan

            $.ajax({
                url: "{?=url([ADMIN,'opm','aksi'])?}",
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
    $('#search_text_opname').keyup(function () {
        var_tbl_opname.draw();
    });
    // ==============================================================
    // CLICK TANDA X DI INPUT SEARCH
    // ==============================================================
    $("#searchclear_opname").click(function () {
        $("#search_text_opname").val("");
        var_tbl_opname.draw();
    });

    // ===========================================
    // Ketika tombol Edit di tekan
    // ===========================================

    $("#edit_data_opname").click(function () {
        var rowData = var_tbl_opname.rows({ selected: true }).data()[0];
        if (rowData != null) {

            var kode_brng = rowData['kode_brng'];
var h_beli = rowData['h_beli'];
var tanggal = rowData['tanggal'];
var stok = rowData['stok'];
var real = rowData['real'];
var selisih = rowData['selisih'];
var nomihilang = rowData['nomihilang'];
var lebih = rowData['lebih'];
var nomilebih = rowData['nomilebih'];
var keterangan = rowData['keterangan'];
var kd_bangsal = rowData['kd_bangsal'];
var no_batch = rowData['no_batch'];
var no_faktur = rowData['no_faktur'];



            $("#typeact").val("edit");
  
            $('#kode_brng').val(kode_brng);
$('#h_beli').val(h_beli);
$('#tanggal').val(tanggal);
$('#stok').val(stok);
$('#real').val(real);
$('#selisih').val(selisih);
$('#nomihilang').val(nomihilang);
$('#lebih').val(lebih);
$('#nomilebih').val(nomilebih);
$('#keterangan').val(keterangan);
$('#kd_bangsal').val(kd_bangsal);
$('#no_batch').val(no_batch);
$('#no_faktur').val(no_faktur);

            //$("#kode_brng").prop('disabled', true); // GA BISA DIEDIT KALI DISABLE
            $('#modal-title').text("Edit Data opm");
            $("#modal_opname").modal();
        }
        else {
            alert("Silakan pilih data yang akan di edit.");
        }

    });

    // ==============================================================
    // TOMBOL  DELETE DI CLICK
    // ==============================================================
    jQuery("#hapus_data_opname").click(function () {
        var rowData = var_tbl_opname.rows({ selected: true }).data()[0];


        if (rowData) {
var kode_brng = rowData['kode_brng'];
            var a = confirm("Anda yakin akan menghapus data dengan kode_brng=" + kode_brng);
            if (a) {

                $.ajax({
                    url: "{?=url([ADMIN,'opm','aksi'])?}",
                    method: "POST",
                    data: {
                        kode_brng: kode_brng,
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
    jQuery("#tambah_data_opname").click(function () {

        $('#kode_brng').val('');
$('#h_beli').val('');
$('#tanggal').val('');
$('#stok').val('');
$('#real').val('');
$('#selisih').val('');
$('#nomihilang').val('');
$('#lebih').val('');
$('#nomilebih').val('');
$('#keterangan').val('');
$('#kd_bangsal').val('');
$('#no_batch').val('');
$('#no_faktur').val('');


        $("#typeact").val("add");
        $("#kode_brng").prop('disabled', false);
        
        $('#modal-title').text("Tambah Data opm");
        $("#modal_opname").modal();
    });

    // ===========================================
    // Ketika tombol lihat data di tekan
    // ===========================================
    $("#lihat_data_opname").click(function () {

        var search_field_opname = $('#search_field_opname').val();
        var search_text_opname = $('#search_text_opname').val();

        $.ajax({
            url: "{?=url([ADMIN,'opm','aksi'])?}",
            method: "POST",
            data: {
                typeact: 'lihat', 
                search_field_opname: search_field_opname, 
                search_text_opname: search_text_opname
            },
            dataType: 'json',
            success: function (res) {
                var eTable = "<div class='table-responsive'><table id='tbl_lihat_opname' class='table display dataTable' style='width:100%'><thead><th>Kode Brng</th><th>H Beli</th><th>Tanggal</th><th>Stok</th><th>Real</th><th>Selisih</th><th>Nomihilang</th><th>Lebih</th><th>Nomilebih</th><th>Keterangan</th><th>Kd Bangsal</th><th>No Batch</th><th>No Faktur</th></thead>";
                for (var i = 0; i < res.length; i++) {
                    eTable += "<tr>";
                    eTable += '<td>' + res[i]['kode_brng'] + '</td>';
eTable += '<td>' + res[i]['h_beli'] + '</td>';
eTable += '<td>' + res[i]['tanggal'] + '</td>';
eTable += '<td>' + res[i]['stok'] + '</td>';
eTable += '<td>' + res[i]['real'] + '</td>';
eTable += '<td>' + res[i]['selisih'] + '</td>';
eTable += '<td>' + res[i]['nomihilang'] + '</td>';
eTable += '<td>' + res[i]['lebih'] + '</td>';
eTable += '<td>' + res[i]['nomilebih'] + '</td>';
eTable += '<td>' + res[i]['keterangan'] + '</td>';
eTable += '<td>' + res[i]['kd_bangsal'] + '</td>';
eTable += '<td>' + res[i]['no_batch'] + '</td>';
eTable += '<td>' + res[i]['no_faktur'] + '</td>';
                    eTable += "</tr>";
                }
                eTable += "</tbody></table></div>";
                $('#forTable_opname').html(eTable);
            }
        });

        $('#modal-title').text("Lihat Data");
        $("#modal_lihat_opname").modal();
    });

    // ==============================================================
    // TOMBOL DETAIL opname DI CLICK
    // ==============================================================
    jQuery("#lihat_detail_opname").click(function (event) {

        var rowData = var_tbl_opname.rows({ selected: true }).data()[0];

        if (rowData) {
var kode_brng = rowData['kode_brng'];
            var baseURL = mlite.url + '/' + mlite.admin;
            event.preventDefault();
            var loadURL =  baseURL + '/opm/detail/' + kode_brng + '?t=' + mlite.token;
        
            var modal = $('#modal_detail_opname');
            var modalContent = $('#modal_detail_opname .modal-content');
        
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
        doc.text("Tabel Data Opname", 20, 95, null, null, null);
        const totalPagesExp = "{total_pages_count_string}";        
        doc.autoTable({
            html: '#tbl_lihat_opname',
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
        // doc.save('table_data_opname.pdf')
        window.open(doc.output('bloburl'), '_blank',"toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes");  
              
    })

    // ===========================================
    // Ketika tombol export xlsx di tekan
    // ===========================================
    $("#export_xlsx").click(function () {
        let tbl1 = document.getElementById("tbl_lihat_opname");
        let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
        let a = XLSX.utils.sheet_to_json(worksheet_tmp1, { header: 1 });
        let worksheet1 = XLSX.utils.json_to_sheet(a, { skipHeader: true });
        const new_workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(new_workbook, worksheet1, "Data opname");
        XLSX.writeFile(new_workbook, 'tmp_file.xls');
    })
});