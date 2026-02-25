jQuery().ready(function () {
    var var_tbl_mlite_penjualan_detail = $('#tbl_mlite_penjualan_detail').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'dom': 'Bfrtip',
        'searching': false,
        'select': true,
        'colReorder': true,
        "bInfo" : false,
        "ajax": {
            "url": "{?=url([ADMIN,'mlite_penjualan_detail','data'])?}",
            "dataType": "json",
            "type": "POST",
            "data": function (data) {

                // Read values
                var search_field_mlite_penjualan_detail = $('#search_field_mlite_penjualan_detail').val();
                var search_text_mlite_penjualan_detail = $('#search_text_mlite_penjualan_detail').val();
                
                data.search_field_mlite_penjualan_detail = search_field_mlite_penjualan_detail;
                data.search_text_mlite_penjualan_detail = search_text_mlite_penjualan_detail;
                
            }
        },
        "columns": [
{ 'data': 'id' },
{ 'data': 'id_penjualan' },
{ 'data': 'id_barang' },
{ 'data': 'nama_barang' },
{ 'data': 'harga' },
{ 'data': 'jumlah' },
{ 'data': 'harga_total' },
{ 'data': 'tanggal' },
{ 'data': 'jam' },
{ 'data': 'id_user' }

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
{ 'targets': 9}

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

    $("form[name='form_mlite_penjualan_detail']").validate({
        rules: {
id: 'required',
id_penjualan: 'required',
id_barang: 'required',
nama_barang: 'required',
harga: 'required',
jumlah: 'required',
harga_total: 'required',
tanggal: 'required',
jam: 'required',
id_user: 'required'

        },
        messages: {
id:'id tidak boleh kosong!',
id_penjualan:'id_penjualan tidak boleh kosong!',
id_barang:'id_barang tidak boleh kosong!',
nama_barang:'nama_barang tidak boleh kosong!',
harga:'harga tidak boleh kosong!',
jumlah:'jumlah tidak boleh kosong!',
harga_total:'harga_total tidak boleh kosong!',
tanggal:'tanggal tidak boleh kosong!',
jam:'jam tidak boleh kosong!',
id_user:'id_user tidak boleh kosong!'

        },
        submitHandler: function (form) {
 var id= $('#id').val();
var id_penjualan= $('#id_penjualan').val();
var id_barang= $('#id_barang').val();
var nama_barang= $('#nama_barang').val();
var harga= $('#harga').val();
var jumlah= $('#jumlah').val();
var harga_total= $('#harga_total').val();
var tanggal= $('#tanggal').val();
var jam= $('#jam').val();
var id_user= $('#id_user').val();

 var typeact = $('#typeact').val();

 var formData = new FormData(form); // tambahan
 formData.append('typeact', typeact); // tambahan

            $.ajax({
                url: "{?=url([ADMIN,'mlite_penjualan_detail','aksi'])?}",
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
    $('#search_text_mlite_penjualan_detail').keyup(function () {
        var_tbl_mlite_penjualan_detail.draw();
    });
    // ==============================================================
    // CLICK TANDA X DI INPUT SEARCH
    // ==============================================================
    $("#searchclear_mlite_penjualan_detail").click(function () {
        $("#search_text_mlite_penjualan_detail").val("");
        var_tbl_mlite_penjualan_detail.draw();
    });

    // ===========================================
    // Ketika tombol Edit di tekan
    // ===========================================

    $("#edit_data_mlite_penjualan_detail").click(function () {
        var rowData = var_tbl_mlite_penjualan_detail.rows({ selected: true }).data()[0];
        if (rowData != null) {

            var id = rowData['id'];
var id_penjualan = rowData['id_penjualan'];
var id_barang = rowData['id_barang'];
var nama_barang = rowData['nama_barang'];
var harga = rowData['harga'];
var jumlah = rowData['jumlah'];
var harga_total = rowData['harga_total'];
var tanggal = rowData['tanggal'];
var jam = rowData['jam'];
var id_user = rowData['id_user'];



            $("#typeact").val("edit");
  
            $('#id').val(id);
$('#id_penjualan').val(id_penjualan);
$('#id_barang').val(id_barang);
$('#nama_barang').val(nama_barang);
$('#harga').val(harga);
$('#jumlah').val(jumlah);
$('#harga_total').val(harga_total);
$('#tanggal').val(tanggal);
$('#jam').val(jam);
$('#id_user').val(id_user);

            //$("#id").prop('disabled', true); // GA BISA DIEDIT KALI DISABLE
            $('#modal-title').text("Edit Data mlite_penjualan_detail");
            $("#modal_mlite_penjualan_detail").modal();
        }
        else {
            alert("Silakan pilih data yang akan di edit.");
        }

    });

    // ==============================================================
    // TOMBOL  DELETE DI CLICK
    // ==============================================================
    jQuery("#hapus_data_mlite_penjualan_detail").click(function () {
        var rowData = var_tbl_mlite_penjualan_detail.rows({ selected: true }).data()[0];


        if (rowData) {
var id = rowData['id'];
            var a = confirm("Anda yakin akan menghapus data dengan id=" + id);
            if (a) {

                $.ajax({
                    url: "{?=url([ADMIN,'mlite_penjualan_detail','aksi'])?}",
                    method: "POST",
                    data: {
                        id: id,
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
    jQuery("#tambah_data_mlite_penjualan_detail").click(function () {

        $('#id').val('');
$('#id_penjualan').val('');
$('#id_barang').val('');
$('#nama_barang').val('');
$('#harga').val('');
$('#jumlah').val('');
$('#harga_total').val('');
$('#tanggal').val('');
$('#jam').val('');
$('#id_user').val('');


        $("#typeact").val("add");
        $("#id").prop('disabled', false);
        
        $('#modal-title').text("Tambah Data mlite_penjualan_detail");
        $("#modal_mlite_penjualan_detail").modal();
    });

    // ===========================================
    // Ketika tombol lihat data di tekan
    // ===========================================
    $("#lihat_data_mlite_penjualan_detail").click(function () {

        var search_field_mlite_penjualan_detail = $('#search_field_mlite_penjualan_detail').val();
        var search_text_mlite_penjualan_detail = $('#search_text_mlite_penjualan_detail').val();

        $.ajax({
            url: "{?=url([ADMIN,'mlite_penjualan_detail','aksi'])?}",
            method: "POST",
            data: {
                typeact: 'lihat', 
                search_field_mlite_penjualan_detail: search_field_mlite_penjualan_detail, 
                search_text_mlite_penjualan_detail: search_text_mlite_penjualan_detail
            },
            dataType: 'json',
            success: function (res) {
                var eTable = "<div class='table-responsive'><table id='tbl_lihat_mlite_penjualan_detail' class='table display dataTable' style='width:100%'><thead><th>Id</th><th>Id Penjualan</th><th>Id Barang</th><th>Nama Barang</th><th>Harga</th><th>Jumlah</th><th>Harga Total</th><th>Tanggal</th><th>Jam</th><th>Id User</th></thead>";
                for (var i = 0; i < res.length; i++) {
                    eTable += "<tr>";
                    eTable += '<td>' + res[i]['id'] + '</td>';
eTable += '<td>' + res[i]['id_penjualan'] + '</td>';
eTable += '<td>' + res[i]['id_barang'] + '</td>';
eTable += '<td>' + res[i]['nama_barang'] + '</td>';
eTable += '<td>' + res[i]['harga'] + '</td>';
eTable += '<td>' + res[i]['jumlah'] + '</td>';
eTable += '<td>' + res[i]['harga_total'] + '</td>';
eTable += '<td>' + res[i]['tanggal'] + '</td>';
eTable += '<td>' + res[i]['jam'] + '</td>';
eTable += '<td>' + res[i]['id_user'] + '</td>';
                    eTable += "</tr>";
                }
                eTable += "</tbody></table></div>";
                $('#forTable_mlite_penjualan_detail').html(eTable);
            }
        });

        $('#modal-title').text("Lihat Data");
        $("#modal_lihat_mlite_penjualan_detail").modal();
    });

    // ==============================================================
    // TOMBOL DETAIL mlite_penjualan_detail DI CLICK
    // ==============================================================
    jQuery("#lihat_detail_mlite_penjualan_detail").click(function (event) {

        var rowData = var_tbl_mlite_penjualan_detail.rows({ selected: true }).data()[0];

        if (rowData) {
var id = rowData['id'];
            var baseURL = mlite.url + '/' + mlite.admin;
            event.preventDefault();
            var loadURL =  baseURL + '/mlite_penjualan_detail/detail/' + id + '?t=' + mlite.token;
        
            var modal = $('#modal_detail_mlite_penjualan_detail');
            var modalContent = $('#modal_detail_mlite_penjualan_detail .modal-content');
        
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
        doc.text("Tabel Data Mlite Penjualan Detail", 20, 95, null, null, null);
        const totalPagesExp = "{total_pages_count_string}";        
        doc.autoTable({
            html: '#tbl_lihat_mlite_penjualan_detail',
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
        // doc.save('table_data_mlite_penjualan_detail.pdf')
        window.open(doc.output('bloburl'), '_blank',"toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes");  
              
    })

    // ===========================================
    // Ketika tombol export xlsx di tekan
    // ===========================================
    $("#export_xlsx").click(function () {
        let tbl1 = document.getElementById("tbl_lihat_mlite_penjualan_detail");
        let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
        let a = XLSX.utils.sheet_to_json(worksheet_tmp1, { header: 1 });
        let worksheet1 = XLSX.utils.json_to_sheet(a, { skipHeader: true });
        const new_workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(new_workbook, worksheet1, "Data mlite_penjualan_detail");
        XLSX.writeFile(new_workbook, 'tmp_file.xls');
    })
});