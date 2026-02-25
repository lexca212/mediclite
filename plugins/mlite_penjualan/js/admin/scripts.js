jQuery().ready(function () {
    var var_tbl_mlite_penjualan = $('#tbl_mlite_penjualan').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'dom': 'Bfrtip',
        'searching': false,
        'select': true,
        'colReorder': true,
        "bInfo" : false,
        "ajax": {
            "url": "{?=url([ADMIN,'mlite_penjualan','data'])?}",
            "dataType": "json",
            "type": "POST",
            "data": function (data) {

                // Read values
                var search_field_mlite_penjualan = $('#search_field_mlite_penjualan').val();
                var search_text_mlite_penjualan = $('#search_text_mlite_penjualan').val();
                
                data.search_field_mlite_penjualan = search_field_mlite_penjualan;
                data.search_text_mlite_penjualan = search_text_mlite_penjualan;
                
            }
        },
        "columns": [
{ 'data': 'id' },
{ 'data': 'nama_pembeli' },
{ 'data': 'alamat_pembeli' },
{ 'data': 'nomor_telepon' },
{ 'data': 'email' },
{ 'data': 'tanggal' },
{ 'data': 'jam' },
{ 'data': 'id_user' },
{ 'data': 'keterangan' }

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
{ 'targets': 8}

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

    $("form[name='form_mlite_penjualan']").validate({
        rules: {
id: 'required',
nama_pembeli: 'required',
alamat_pembeli: 'required',
nomor_telepon: 'required',
email: 'required',
tanggal: 'required',
jam: 'required',
id_user: 'required',
keterangan: 'required'

        },
        messages: {
id:'id tidak boleh kosong!',
nama_pembeli:'nama_pembeli tidak boleh kosong!',
alamat_pembeli:'alamat_pembeli tidak boleh kosong!',
nomor_telepon:'nomor_telepon tidak boleh kosong!',
email:'email tidak boleh kosong!',
tanggal:'tanggal tidak boleh kosong!',
jam:'jam tidak boleh kosong!',
id_user:'id_user tidak boleh kosong!',
keterangan:'keterangan tidak boleh kosong!'

        },
        submitHandler: function (form) {
 var id= $('#id').val();
var nama_pembeli= $('#nama_pembeli').val();
var alamat_pembeli= $('#alamat_pembeli').val();
var nomor_telepon= $('#nomor_telepon').val();
var email= $('#email').val();
var tanggal= $('#tanggal').val();
var jam= $('#jam').val();
var id_user= $('#id_user').val();
var keterangan= $('#keterangan').val();

 var typeact = $('#typeact').val();

 var formData = new FormData(form); // tambahan
 formData.append('typeact', typeact); // tambahan

            $.ajax({
                url: "{?=url([ADMIN,'mlite_penjualan','aksi'])?}",
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
    $('#search_text_mlite_penjualan').keyup(function () {
        var_tbl_mlite_penjualan.draw();
    });
    // ==============================================================
    // CLICK TANDA X DI INPUT SEARCH
    // ==============================================================
    $("#searchclear_mlite_penjualan").click(function () {
        $("#search_text_mlite_penjualan").val("");
        var_tbl_mlite_penjualan.draw();
    });

    // ===========================================
    // Ketika tombol Edit di tekan
    // ===========================================

    $("#edit_data_mlite_penjualan").click(function () {
        var rowData = var_tbl_mlite_penjualan.rows({ selected: true }).data()[0];
        if (rowData != null) {

            var id = rowData['id'];
var nama_pembeli = rowData['nama_pembeli'];
var alamat_pembeli = rowData['alamat_pembeli'];
var nomor_telepon = rowData['nomor_telepon'];
var email = rowData['email'];
var tanggal = rowData['tanggal'];
var jam = rowData['jam'];
var id_user = rowData['id_user'];
var keterangan = rowData['keterangan'];



            $("#typeact").val("edit");
  
            $('#id').val(id);
$('#nama_pembeli').val(nama_pembeli);
$('#alamat_pembeli').val(alamat_pembeli);
$('#nomor_telepon').val(nomor_telepon);
$('#email').val(email);
$('#tanggal').val(tanggal);
$('#jam').val(jam);
$('#id_user').val(id_user);
$('#keterangan').val(keterangan);

            //$("#id").prop('disabled', true); // GA BISA DIEDIT KALI DISABLE
            $('#modal-title').text("Edit Data mlite penjualan");
            $("#modal_mlite_penjualan").modal();
        }
        else {
            alert("Silakan pilih data yang akan di edit.");
        }

    });

    // ==============================================================
    // TOMBOL  DELETE DI CLICK
    // ==============================================================
    jQuery("#hapus_data_mlite_penjualan").click(function () {
        var rowData = var_tbl_mlite_penjualan.rows({ selected: true }).data()[0];


        if (rowData) {
var id = rowData['id'];
            var a = confirm("Anda yakin akan menghapus data dengan id=" + id);
            if (a) {

                $.ajax({
                    url: "{?=url([ADMIN,'mlite_penjualan','aksi'])?}",
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
    jQuery("#tambah_data_mlite_penjualan").click(function () {

        $('#id').val('');
$('#nama_pembeli').val('');
$('#alamat_pembeli').val('');
$('#nomor_telepon').val('');
$('#email').val('');
$('#tanggal').val('');
$('#jam').val('');
$('#id_user').val('');
$('#keterangan').val('');


        $("#typeact").val("add");
        $("#id").prop('disabled', false);
        
        $('#modal-title').text("Tambah Data mlite penjualan");
        $("#modal_mlite_penjualan").modal();
    });

    // ===========================================
    // Ketika tombol lihat data di tekan
    // ===========================================
    $("#lihat_data_mlite_penjualan").click(function () {

        var search_field_mlite_penjualan = $('#search_field_mlite_penjualan').val();
        var search_text_mlite_penjualan = $('#search_text_mlite_penjualan').val();

        $.ajax({
            url: "{?=url([ADMIN,'mlite_penjualan','aksi'])?}",
            method: "POST",
            data: {
                typeact: 'lihat', 
                search_field_mlite_penjualan: search_field_mlite_penjualan, 
                search_text_mlite_penjualan: search_text_mlite_penjualan
            },
            dataType: 'json',
            success: function (res) {
                var eTable = "<div class='table-responsive'><table id='tbl_lihat_mlite_penjualan' class='table display dataTable' style='width:100%'><thead><th>Id</th><th>Nama Pembeli</th><th>Alamat Pembeli</th><th>Nomor Telepon</th><th>Email</th><th>Tanggal</th><th>Jam</th><th>Id User</th><th>Keterangan</th></thead>";
                for (var i = 0; i < res.length; i++) {
                    eTable += "<tr>";
                    eTable += '<td>' + res[i]['id'] + '</td>';
eTable += '<td>' + res[i]['nama_pembeli'] + '</td>';
eTable += '<td>' + res[i]['alamat_pembeli'] + '</td>';
eTable += '<td>' + res[i]['nomor_telepon'] + '</td>';
eTable += '<td>' + res[i]['email'] + '</td>';
eTable += '<td>' + res[i]['tanggal'] + '</td>';
eTable += '<td>' + res[i]['jam'] + '</td>';
eTable += '<td>' + res[i]['id_user'] + '</td>';
eTable += '<td>' + res[i]['keterangan'] + '</td>';
                    eTable += "</tr>";
                }
                eTable += "</tbody></table></div>";
                $('#forTable_mlite_penjualan').html(eTable);
            }
        });

        $('#modal-title').text("Lihat Data");
        $("#modal_lihat_mlite_penjualan").modal();
    });

    // ==============================================================
    // TOMBOL DETAIL mlite_penjualan DI CLICK
    // ==============================================================
    jQuery("#lihat_detail_mlite_penjualan").click(function (event) {

        var rowData = var_tbl_mlite_penjualan.rows({ selected: true }).data()[0];

        if (rowData) {
var id = rowData['id'];
            var baseURL = mlite.url + '/' + mlite.admin;
            event.preventDefault();
            var loadURL =  baseURL + '/mlite_penjualan/detail/' + id + '?t=' + mlite.token;
        
            var modal = $('#modal_detail_mlite_penjualan');
            var modalContent = $('#modal_detail_mlite_penjualan .modal-content');
        
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
        doc.text("Tabel Data Mlite Penjualan", 20, 95, null, null, null);
        const totalPagesExp = "{total_pages_count_string}";        
        doc.autoTable({
            html: '#tbl_lihat_mlite_penjualan',
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
        // doc.save('table_data_mlite_penjualan.pdf')
        window.open(doc.output('bloburl'), '_blank',"toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes");  
              
    })

    // ===========================================
    // Ketika tombol export xlsx di tekan
    // ===========================================
    $("#export_xlsx").click(function () {
        let tbl1 = document.getElementById("tbl_lihat_mlite_penjualan");
        let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
        let a = XLSX.utils.sheet_to_json(worksheet_tmp1, { header: 1 });
        let worksheet1 = XLSX.utils.json_to_sheet(a, { skipHeader: true });
        const new_workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(new_workbook, worksheet1, "Data mlite_penjualan");
        XLSX.writeFile(new_workbook, 'tmp_file.xls');
    })
});