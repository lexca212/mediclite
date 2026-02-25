jQuery().ready(function () {
    var var_tbl_pasien_bayi = $('#tbl_pasien_bayi').DataTable({
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'dom': 'Bfrtip',
        'searching': false,
        'select': true,
        'colReorder': true,
        "bInfo" : false,
        "ajax": {
            "url": "{?=url([ADMIN,'kelahiran_bayo','data'])?}",
            "dataType": "json",
            "type": "POST",
            "data": function (data) {

                // Read values
                var search_field_pasien_bayi = $('#search_field_pasien_bayi').val();
                var search_text_pasien_bayi = $('#search_text_pasien_bayi').val();
                
                data.search_field_pasien_bayi = search_field_pasien_bayi;
                data.search_text_pasien_bayi = search_text_pasien_bayi;
                
            }
        },
        "columns": [
{ 'data': 'no_rkm_medis' },
{ 'data': 'umur_ibu' },
{ 'data': 'nama_ayah' },
{ 'data': 'umur_ayah' },
{ 'data': 'berat_badan' },
{ 'data': 'panjang_badan' },
{ 'data': 'lingkar_kepala' },
{ 'data': 'proses_lahir' },
{ 'data': 'anakke' },
{ 'data': 'jam_lahir' },
{ 'data': 'keterangan' },
{ 'data': 'diagnosa' },
{ 'data': 'penyulit_kehamilan' },
{ 'data': 'ketuban' },
{ 'data': 'lingkar_perut' },
{ 'data': 'lingkar_dada' },
{ 'data': 'penolong' },
{ 'data': 'no_skl' },
{ 'data': 'g' },
{ 'data': 'p' },
{ 'data': 'a' },
{ 'data': 'f1' },
{ 'data': 'u1' },
{ 'data': 't1' },
{ 'data': 'r1' },
{ 'data': 'w1' },
{ 'data': 'n1' },
{ 'data': 'f5' },
{ 'data': 'u5' },
{ 'data': 't5' },
{ 'data': 'r5' },
{ 'data': 'w5' },
{ 'data': 'n5' },
{ 'data': 'f10' },
{ 'data': 'u10' },
{ 'data': 't10' },
{ 'data': 'r10' },
{ 'data': 'w10' },
{ 'data': 'n10' },
{ 'data': 'resusitas' },
{ 'data': 'obat_diberikan' },
{ 'data': 'mikasi' },
{ 'data': 'mikonium' }

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
{ 'targets': 22},
{ 'targets': 23},
{ 'targets': 24},
{ 'targets': 25},
{ 'targets': 26},
{ 'targets': 27},
{ 'targets': 28},
{ 'targets': 29},
{ 'targets': 30},
{ 'targets': 31},
{ 'targets': 32},
{ 'targets': 33},
{ 'targets': 34},
{ 'targets': 35},
{ 'targets': 36},
{ 'targets': 37},
{ 'targets': 38},
{ 'targets': 39},
{ 'targets': 40},
{ 'targets': 41},
{ 'targets': 42}

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

    $("form[name='form_pasien_bayi']").validate({
        rules: {
no_rkm_medis: 'required',
umur_ibu: 'required',
nama_ayah: 'required',
umur_ayah: 'required',
berat_badan: 'required',
panjang_badan: 'required',
lingkar_kepala: 'required',
proses_lahir: 'required',
anakke: 'required',
jam_lahir: 'required',
keterangan: 'required',
diagnosa: 'required',
penyulit_kehamilan: 'required',
ketuban: 'required',
lingkar_perut: 'required',
lingkar_dada: 'required',
penolong: 'required',
no_skl: 'required',
g: 'required',
p: 'required',
a: 'required',
f1: 'required',
u1: 'required',
t1: 'required',
r1: 'required',
w1: 'required',
n1: 'required',
f5: 'required',
u5: 'required',
t5: 'required',
r5: 'required',
w5: 'required',
n5: 'required',
f10: 'required',
u10: 'required',
t10: 'required',
r10: 'required',
w10: 'required',
n10: 'required',
resusitas: 'required',
obat_diberikan: 'required',
mikasi: 'required',
mikonium: 'required'

        },
        messages: {
no_rkm_medis:'no_rkm_medis tidak boleh kosong!',
umur_ibu:'umur_ibu tidak boleh kosong!',
nama_ayah:'nama_ayah tidak boleh kosong!',
umur_ayah:'umur_ayah tidak boleh kosong!',
berat_badan:'berat_badan tidak boleh kosong!',
panjang_badan:'panjang_badan tidak boleh kosong!',
lingkar_kepala:'lingkar_kepala tidak boleh kosong!',
proses_lahir:'proses_lahir tidak boleh kosong!',
anakke:'anakke tidak boleh kosong!',
jam_lahir:'jam_lahir tidak boleh kosong!',
keterangan:'keterangan tidak boleh kosong!',
diagnosa:'diagnosa tidak boleh kosong!',
penyulit_kehamilan:'penyulit_kehamilan tidak boleh kosong!',
ketuban:'ketuban tidak boleh kosong!',
lingkar_perut:'lingkar_perut tidak boleh kosong!',
lingkar_dada:'lingkar_dada tidak boleh kosong!',
penolong:'penolong tidak boleh kosong!',
no_skl:'no_skl tidak boleh kosong!',
g:'g tidak boleh kosong!',
p:'p tidak boleh kosong!',
a:'a tidak boleh kosong!',
f1:'f1 tidak boleh kosong!',
u1:'u1 tidak boleh kosong!',
t1:'t1 tidak boleh kosong!',
r1:'r1 tidak boleh kosong!',
w1:'w1 tidak boleh kosong!',
n1:'n1 tidak boleh kosong!',
f5:'f5 tidak boleh kosong!',
u5:'u5 tidak boleh kosong!',
t5:'t5 tidak boleh kosong!',
r5:'r5 tidak boleh kosong!',
w5:'w5 tidak boleh kosong!',
n5:'n5 tidak boleh kosong!',
f10:'f10 tidak boleh kosong!',
u10:'u10 tidak boleh kosong!',
t10:'t10 tidak boleh kosong!',
r10:'r10 tidak boleh kosong!',
w10:'w10 tidak boleh kosong!',
n10:'n10 tidak boleh kosong!',
resusitas:'resusitas tidak boleh kosong!',
obat_diberikan:'obat_diberikan tidak boleh kosong!',
mikasi:'mikasi tidak boleh kosong!',
mikonium:'mikonium tidak boleh kosong!'

        },
        submitHandler: function (form) {
 var no_rkm_medis= $('#no_rkm_medis').val();
var umur_ibu= $('#umur_ibu').val();
var nama_ayah= $('#nama_ayah').val();
var umur_ayah= $('#umur_ayah').val();
var berat_badan= $('#berat_badan').val();
var panjang_badan= $('#panjang_badan').val();
var lingkar_kepala= $('#lingkar_kepala').val();
var proses_lahir= $('#proses_lahir').val();
var anakke= $('#anakke').val();
var jam_lahir= $('#jam_lahir').val();
var keterangan= $('#keterangan').val();
var diagnosa= $('#diagnosa').val();
var penyulit_kehamilan= $('#penyulit_kehamilan').val();
var ketuban= $('#ketuban').val();
var lingkar_perut= $('#lingkar_perut').val();
var lingkar_dada= $('#lingkar_dada').val();
var penolong= $('#penolong').val();
var no_skl= $('#no_skl').val();
var g= $('#g').val();
var p= $('#p').val();
var a= $('#a').val();
var f1= $('#f1').val();
var u1= $('#u1').val();
var t1= $('#t1').val();
var r1= $('#r1').val();
var w1= $('#w1').val();
var n1= $('#n1').val();
var f5= $('#f5').val();
var u5= $('#u5').val();
var t5= $('#t5').val();
var r5= $('#r5').val();
var w5= $('#w5').val();
var n5= $('#n5').val();
var f10= $('#f10').val();
var u10= $('#u10').val();
var t10= $('#t10').val();
var r10= $('#r10').val();
var w10= $('#w10').val();
var n10= $('#n10').val();
var resusitas= $('#resusitas').val();
var obat_diberikan= $('#obat_diberikan').val();
var mikasi= $('#mikasi').val();
var mikonium= $('#mikonium').val();

 var typeact = $('#typeact').val();

 var formData = new FormData(form); // tambahan
 formData.append('typeact', typeact); // tambahan

            $.ajax({
                url: "{?=url([ADMIN,'kelahiran_bayo','aksi'])?}",
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
    $('#search_text_pasien_bayi').keyup(function () {
        var_tbl_pasien_bayi.draw();
    });
    // ==============================================================
    // CLICK TANDA X DI INPUT SEARCH
    // ==============================================================
    $("#searchclear_pasien_bayi").click(function () {
        $("#search_text_pasien_bayi").val("");
        var_tbl_pasien_bayi.draw();
    });

    // ===========================================
    // Ketika tombol Edit di tekan
    // ===========================================

    $("#edit_data_pasien_bayi").click(function () {
        var rowData = var_tbl_pasien_bayi.rows({ selected: true }).data()[0];
        if (rowData != null) {

            var no_rkm_medis = rowData['no_rkm_medis'];
var umur_ibu = rowData['umur_ibu'];
var nama_ayah = rowData['nama_ayah'];
var umur_ayah = rowData['umur_ayah'];
var berat_badan = rowData['berat_badan'];
var panjang_badan = rowData['panjang_badan'];
var lingkar_kepala = rowData['lingkar_kepala'];
var proses_lahir = rowData['proses_lahir'];
var anakke = rowData['anakke'];
var jam_lahir = rowData['jam_lahir'];
var keterangan = rowData['keterangan'];
var diagnosa = rowData['diagnosa'];
var penyulit_kehamilan = rowData['penyulit_kehamilan'];
var ketuban = rowData['ketuban'];
var lingkar_perut = rowData['lingkar_perut'];
var lingkar_dada = rowData['lingkar_dada'];
var penolong = rowData['penolong'];
var no_skl = rowData['no_skl'];
var g = rowData['g'];
var p = rowData['p'];
var a = rowData['a'];
var f1 = rowData['f1'];
var u1 = rowData['u1'];
var t1 = rowData['t1'];
var r1 = rowData['r1'];
var w1 = rowData['w1'];
var n1 = rowData['n1'];
var f5 = rowData['f5'];
var u5 = rowData['u5'];
var t5 = rowData['t5'];
var r5 = rowData['r5'];
var w5 = rowData['w5'];
var n5 = rowData['n5'];
var f10 = rowData['f10'];
var u10 = rowData['u10'];
var t10 = rowData['t10'];
var r10 = rowData['r10'];
var w10 = rowData['w10'];
var n10 = rowData['n10'];
var resusitas = rowData['resusitas'];
var obat_diberikan = rowData['obat_diberikan'];
var mikasi = rowData['mikasi'];
var mikonium = rowData['mikonium'];



            $("#typeact").val("edit");
  
            $('#no_rkm_medis').val(no_rkm_medis);
$('#umur_ibu').val(umur_ibu);
$('#nama_ayah').val(nama_ayah);
$('#umur_ayah').val(umur_ayah);
$('#berat_badan').val(berat_badan);
$('#panjang_badan').val(panjang_badan);
$('#lingkar_kepala').val(lingkar_kepala);
$('#proses_lahir').val(proses_lahir);
$('#anakke').val(anakke);
$('#jam_lahir').val(jam_lahir);
$('#keterangan').val(keterangan);
$('#diagnosa').val(diagnosa);
$('#penyulit_kehamilan').val(penyulit_kehamilan);
$('#ketuban').val(ketuban);
$('#lingkar_perut').val(lingkar_perut);
$('#lingkar_dada').val(lingkar_dada);
$('#penolong').val(penolong);
$('#no_skl').val(no_skl);
$('#g').val(g);
$('#p').val(p);
$('#a').val(a);
$('#f1').val(f1);
$('#u1').val(u1);
$('#t1').val(t1);
$('#r1').val(r1);
$('#w1').val(w1);
$('#n1').val(n1);
$('#f5').val(f5);
$('#u5').val(u5);
$('#t5').val(t5);
$('#r5').val(r5);
$('#w5').val(w5);
$('#n5').val(n5);
$('#f10').val(f10);
$('#u10').val(u10);
$('#t10').val(t10);
$('#r10').val(r10);
$('#w10').val(w10);
$('#n10').val(n10);
$('#resusitas').val(resusitas);
$('#obat_diberikan').val(obat_diberikan);
$('#mikasi').val(mikasi);
$('#mikonium').val(mikonium);

            //$("#no_rkm_medis").prop('disabled', true); // GA BISA DIEDIT KALI DISABLE
            $('#modal-title').text("Edit Data kelahiran bayo");
            $("#modal_pasien_bayi").modal();
        }
        else {
            alert("Silakan pilih data yang akan di edit.");
        }

    });

    // ==============================================================
    // TOMBOL  DELETE DI CLICK
    // ==============================================================
    jQuery("#hapus_data_pasien_bayi").click(function () {
        var rowData = var_tbl_pasien_bayi.rows({ selected: true }).data()[0];


        if (rowData) {
var no_rkm_medis = rowData['no_rkm_medis'];
            var a = confirm("Anda yakin akan menghapus data dengan no_rkm_medis=" + no_rkm_medis);
            if (a) {

                $.ajax({
                    url: "{?=url([ADMIN,'kelahiran_bayo','aksi'])?}",
                    method: "POST",
                    data: {
                        no_rkm_medis: no_rkm_medis,
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
    jQuery("#tambah_data_pasien_bayi").click(function () {

        $('#no_rkm_medis').val('');
$('#umur_ibu').val('');
$('#nama_ayah').val('');
$('#umur_ayah').val('');
$('#berat_badan').val('');
$('#panjang_badan').val('');
$('#lingkar_kepala').val('');
$('#proses_lahir').val('');
$('#anakke').val('');
$('#jam_lahir').val('');
$('#keterangan').val('');
$('#diagnosa').val('');
$('#penyulit_kehamilan').val('');
$('#ketuban').val('');
$('#lingkar_perut').val('');
$('#lingkar_dada').val('');
$('#penolong').val('');
$('#no_skl').val('');
$('#g').val('');
$('#p').val('');
$('#a').val('');
$('#f1').val('');
$('#u1').val('');
$('#t1').val('');
$('#r1').val('');
$('#w1').val('');
$('#n1').val('');
$('#f5').val('');
$('#u5').val('');
$('#t5').val('');
$('#r5').val('');
$('#w5').val('');
$('#n5').val('');
$('#f10').val('');
$('#u10').val('');
$('#t10').val('');
$('#r10').val('');
$('#w10').val('');
$('#n10').val('');
$('#resusitas').val('');
$('#obat_diberikan').val('');
$('#mikasi').val('');
$('#mikonium').val('');


        $("#typeact").val("add");
        $("#no_rkm_medis").prop('disabled', false);
        
        $('#modal-title').text("Tambah Data kelahiran bayo");
        $("#modal_pasien_bayi").modal();
    });

    // ===========================================
    // Ketika tombol lihat data di tekan
    // ===========================================
    $("#lihat_data_pasien_bayi").click(function () {

        var search_field_pasien_bayi = $('#search_field_pasien_bayi').val();
        var search_text_pasien_bayi = $('#search_text_pasien_bayi').val();

        $.ajax({
            url: "{?=url([ADMIN,'kelahiran_bayo','aksi'])?}",
            method: "POST",
            data: {
                typeact: 'lihat', 
                search_field_pasien_bayi: search_field_pasien_bayi, 
                search_text_pasien_bayi: search_text_pasien_bayi
            },
            dataType: 'json',
            success: function (res) {
                var eTable = "<div class='table-responsive'><table id='tbl_lihat_pasien_bayi' class='table display dataTable' style='width:100%'><thead><th>No Rkm Medis</th><th>Umur Ibu</th><th>Nama Ayah</th><th>Umur Ayah</th><th>Berat Badan</th><th>Panjang Badan</th><th>Lingkar Kepala</th><th>Proses Lahir</th><th>Anakke</th><th>Jam Lahir</th><th>Keterangan</th><th>Diagnosa</th><th>Penyulit Kehamilan</th><th>Ketuban</th><th>Lingkar Perut</th><th>Lingkar Dada</th><th>Penolong</th><th>No Skl</th><th>G</th><th>P</th><th>A</th><th>F1</th><th>U1</th><th>T1</th><th>R1</th><th>W1</th><th>N1</th><th>F5</th><th>U5</th><th>T5</th><th>R5</th><th>W5</th><th>N5</th><th>F10</th><th>U10</th><th>T10</th><th>R10</th><th>W10</th><th>N10</th><th>Resusitas</th><th>Obat Diberikan</th><th>Mikasi</th><th>Mikonium</th></thead>";
                for (var i = 0; i < res.length; i++) {
                    eTable += "<tr>";
                    eTable += '<td>' + res[i]['no_rkm_medis'] + '</td>';
eTable += '<td>' + res[i]['umur_ibu'] + '</td>';
eTable += '<td>' + res[i]['nama_ayah'] + '</td>';
eTable += '<td>' + res[i]['umur_ayah'] + '</td>';
eTable += '<td>' + res[i]['berat_badan'] + '</td>';
eTable += '<td>' + res[i]['panjang_badan'] + '</td>';
eTable += '<td>' + res[i]['lingkar_kepala'] + '</td>';
eTable += '<td>' + res[i]['proses_lahir'] + '</td>';
eTable += '<td>' + res[i]['anakke'] + '</td>';
eTable += '<td>' + res[i]['jam_lahir'] + '</td>';
eTable += '<td>' + res[i]['keterangan'] + '</td>';
eTable += '<td>' + res[i]['diagnosa'] + '</td>';
eTable += '<td>' + res[i]['penyulit_kehamilan'] + '</td>';
eTable += '<td>' + res[i]['ketuban'] + '</td>';
eTable += '<td>' + res[i]['lingkar_perut'] + '</td>';
eTable += '<td>' + res[i]['lingkar_dada'] + '</td>';
eTable += '<td>' + res[i]['penolong'] + '</td>';
eTable += '<td>' + res[i]['no_skl'] + '</td>';
eTable += '<td>' + res[i]['g'] + '</td>';
eTable += '<td>' + res[i]['p'] + '</td>';
eTable += '<td>' + res[i]['a'] + '</td>';
eTable += '<td>' + res[i]['f1'] + '</td>';
eTable += '<td>' + res[i]['u1'] + '</td>';
eTable += '<td>' + res[i]['t1'] + '</td>';
eTable += '<td>' + res[i]['r1'] + '</td>';
eTable += '<td>' + res[i]['w1'] + '</td>';
eTable += '<td>' + res[i]['n1'] + '</td>';
eTable += '<td>' + res[i]['f5'] + '</td>';
eTable += '<td>' + res[i]['u5'] + '</td>';
eTable += '<td>' + res[i]['t5'] + '</td>';
eTable += '<td>' + res[i]['r5'] + '</td>';
eTable += '<td>' + res[i]['w5'] + '</td>';
eTable += '<td>' + res[i]['n5'] + '</td>';
eTable += '<td>' + res[i]['f10'] + '</td>';
eTable += '<td>' + res[i]['u10'] + '</td>';
eTable += '<td>' + res[i]['t10'] + '</td>';
eTable += '<td>' + res[i]['r10'] + '</td>';
eTable += '<td>' + res[i]['w10'] + '</td>';
eTable += '<td>' + res[i]['n10'] + '</td>';
eTable += '<td>' + res[i]['resusitas'] + '</td>';
eTable += '<td>' + res[i]['obat_diberikan'] + '</td>';
eTable += '<td>' + res[i]['mikasi'] + '</td>';
eTable += '<td>' + res[i]['mikonium'] + '</td>';
                    eTable += "</tr>";
                }
                eTable += "</tbody></table></div>";
                $('#forTable_pasien_bayi').html(eTable);
            }
        });

        $('#modal-title').text("Lihat Data");
        $("#modal_lihat_pasien_bayi").modal();
    });

    // ==============================================================
    // TOMBOL DETAIL pasien_bayi DI CLICK
    // ==============================================================
    jQuery("#lihat_detail_pasien_bayi").click(function (event) {

        var rowData = var_tbl_pasien_bayi.rows({ selected: true }).data()[0];

        if (rowData) {
var no_rkm_medis = rowData['no_rkm_medis'];
            var baseURL = mlite.url + '/' + mlite.admin;
            event.preventDefault();
            var loadURL =  baseURL + '/kelahiran_bayo/detail/' + no_rkm_medis + '?t=' + mlite.token;
        
            var modal = $('#modal_detail_pasien_bayi');
            var modalContent = $('#modal_detail_pasien_bayi .modal-content');
        
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
        doc.text("Tabel Data Pasien Bayi", 20, 95, null, null, null);
        const totalPagesExp = "{total_pages_count_string}";        
        doc.autoTable({
            html: '#tbl_lihat_pasien_bayi',
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
        // doc.save('table_data_pasien_bayi.pdf')
        window.open(doc.output('bloburl'), '_blank',"toolbar=no,status=no,menubar=no,scrollbars=no,resizable=no,modal=yes");  
              
    })

    // ===========================================
    // Ketika tombol export xlsx di tekan
    // ===========================================
    $("#export_xlsx").click(function () {
        let tbl1 = document.getElementById("tbl_lihat_pasien_bayi");
        let worksheet_tmp1 = XLSX.utils.table_to_sheet(tbl1);
        let a = XLSX.utils.sheet_to_json(worksheet_tmp1, { header: 1 });
        let worksheet1 = XLSX.utils.json_to_sheet(a, { skipHeader: true });
        const new_workbook = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(new_workbook, worksheet1, "Data pasien_bayi");
        XLSX.writeFile(new_workbook, 'tmp_file.xls');
    })
});