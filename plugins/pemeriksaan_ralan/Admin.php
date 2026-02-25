<?php
namespace Plugins\pemeriksaan_ralan;

use Systems\AdminModule;

class Admin extends AdminModule
{

    public function navigation()
    {
        return [
            'Kelola'   => 'manage',
        ];
    }

    public function getManage(){
        $this->_addHeaderFiles();
        return $this->draw('manage.html');
    }

    public function postData(){
        $draw = $_POST['draw'];
        $row1 = $_POST['start'];
        $rowperpage = $_POST['length']; // Rows display per page
        $columnIndex = $_POST['order'][0]['column']; // Column index
        $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
        $searchValue = $_POST['search']['value']; // Search value

        ## Custom Field value
        $search_field_pemeriksaan_ralan= $_POST['search_field_pemeriksaan_ralan'];
        $search_text_pemeriksaan_ralan = $_POST['search_text_pemeriksaan_ralan'];

        $searchQuery = " ";
        if($search_text_pemeriksaan_ralan != ''){
            $searchQuery .= " and (".$search_field_pemeriksaan_ralan." like '%".$search_text_pemeriksaan_ralan."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from pemeriksaan_ralan");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from pemeriksaan_ralan WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from pemeriksaan_ralan WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'no_rawat'=>$row['no_rawat'],
'tgl_perawatan'=>$row['tgl_perawatan'],
'jam_rawat'=>$row['jam_rawat'],
'suhu_tubuh'=>$row['suhu_tubuh'],
'tensi'=>$row['tensi'],
'nadi'=>$row['nadi'],
'respirasi'=>$row['respirasi'],
'tinggi'=>$row['tinggi'],
'berat'=>$row['berat'],
'spo2'=>$row['spo2'],
'gcs'=>$row['gcs'],
'kesadaran'=>$row['kesadaran'],
'keluhan'=>$row['keluhan'],
'pemeriksaan'=>$row['pemeriksaan'],
'alergi'=>$row['alergi'],
'lingkar_perut'=>$row['lingkar_perut'],
'rtl'=>$row['rtl'],
'penilaian'=>$row['penilaian'],
'instruksi'=>$row['instruksi'],
'evaluasi'=>$row['evaluasi'],
'nip'=>$row['nip']

            );
        }

        ## Response
        $response = array(
            "draw" => intval($draw), 
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        echo json_encode($response);
        exit();
    }

    public function postAksi()
    {
        if(isset($_POST['typeact'])){ 
            $act = $_POST['typeact']; 
        }else{ 
            $act = ''; 
        }

        if ($act=='add') {

        $no_rawat = $_POST['no_rawat'];
$tgl_perawatan = $_POST['tgl_perawatan'];
$jam_rawat = $_POST['jam_rawat'];
$suhu_tubuh = $_POST['suhu_tubuh'];
$tensi = $_POST['tensi'];
$nadi = $_POST['nadi'];
$respirasi = $_POST['respirasi'];
$tinggi = $_POST['tinggi'];
$berat = $_POST['berat'];
$spo2 = $_POST['spo2'];
$gcs = $_POST['gcs'];
$kesadaran = $_POST['kesadaran'];
$keluhan = $_POST['keluhan'];
$pemeriksaan = $_POST['pemeriksaan'];
$alergi = $_POST['alergi'];
$lingkar_perut = $_POST['lingkar_perut'];
$rtl = $_POST['rtl'];
$penilaian = $_POST['penilaian'];
$instruksi = $_POST['instruksi'];
$evaluasi = $_POST['evaluasi'];
$nip = $_POST['nip'];

            
            $pemeriksaan_ralan_add = $this->db()->pdo()->prepare('INSERT INTO pemeriksaan_ralan VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $pemeriksaan_ralan_add->execute([$no_rawat, $tgl_perawatan, $jam_rawat, $suhu_tubuh, $tensi, $nadi, $respirasi, $tinggi, $berat, $spo2, $gcs, $kesadaran, $keluhan, $pemeriksaan, $alergi, $lingkar_perut, $rtl, $penilaian, $instruksi, $evaluasi, $nip]);

        }
        if ($act=="edit") {

        $no_rawat = $_POST['no_rawat'];
$tgl_perawatan = $_POST['tgl_perawatan'];
$jam_rawat = $_POST['jam_rawat'];
$suhu_tubuh = $_POST['suhu_tubuh'];
$tensi = $_POST['tensi'];
$nadi = $_POST['nadi'];
$respirasi = $_POST['respirasi'];
$tinggi = $_POST['tinggi'];
$berat = $_POST['berat'];
$spo2 = $_POST['spo2'];
$gcs = $_POST['gcs'];
$kesadaran = $_POST['kesadaran'];
$keluhan = $_POST['keluhan'];
$pemeriksaan = $_POST['pemeriksaan'];
$alergi = $_POST['alergi'];
$lingkar_perut = $_POST['lingkar_perut'];
$rtl = $_POST['rtl'];
$penilaian = $_POST['penilaian'];
$instruksi = $_POST['instruksi'];
$evaluasi = $_POST['evaluasi'];
$nip = $_POST['nip'];


        // BUANG FIELD PERTAMA

            $pemeriksaan_ralan_edit = $this->db()->pdo()->prepare("UPDATE pemeriksaan_ralan SET no_rawat=?, tgl_perawatan=?, jam_rawat=?, suhu_tubuh=?, tensi=?, nadi=?, respirasi=?, tinggi=?, berat=?, spo2=?, gcs=?, kesadaran=?, keluhan=?, pemeriksaan=?, alergi=?, lingkar_perut=?, rtl=?, penilaian=?, instruksi=?, evaluasi=?, nip=? WHERE no_rawat=?");
            $pemeriksaan_ralan_edit->execute([$no_rawat, $tgl_perawatan, $jam_rawat, $suhu_tubuh, $tensi, $nadi, $respirasi, $tinggi, $berat, $spo2, $gcs, $kesadaran, $keluhan, $pemeriksaan, $alergi, $lingkar_perut, $rtl, $penilaian, $instruksi, $evaluasi, $nip,$no_rawat]);
        
        }

        if ($act=="del") {
            $no_rawat= $_POST['no_rawat'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM pemeriksaan_ralan WHERE no_rawat='$no_rawat'");
            $result = $check_db->execute();
            $error = $check_db->errorInfo();
            if (!empty($result)){
              $data = array(
                'status' => 'success', 
                'msg' => $no_rkm_medis
              );
            } else {
              $data = array(
                'status' => 'error', 
                'msg' => $error['2']
              );
            }
            echo json_encode($data);                    
        }

        if ($act=="lihat") {

            $search_field_pemeriksaan_ralan= $_POST['search_field_pemeriksaan_ralan'];
            $search_text_pemeriksaan_ralan = $_POST['search_text_pemeriksaan_ralan'];

            $searchQuery = " ";
            if($search_text_pemeriksaan_ralan != ''){
                $searchQuery .= " and (".$search_field_pemeriksaan_ralan." like '%".$search_text_pemeriksaan_ralan."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from pemeriksaan_ralan WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'no_rawat'=>$row['no_rawat'],
'tgl_perawatan'=>$row['tgl_perawatan'],
'jam_rawat'=>$row['jam_rawat'],
'suhu_tubuh'=>$row['suhu_tubuh'],
'tensi'=>$row['tensi'],
'nadi'=>$row['nadi'],
'respirasi'=>$row['respirasi'],
'tinggi'=>$row['tinggi'],
'berat'=>$row['berat'],
'spo2'=>$row['spo2'],
'gcs'=>$row['gcs'],
'kesadaran'=>$row['kesadaran'],
'keluhan'=>$row['keluhan'],
'pemeriksaan'=>$row['pemeriksaan'],
'alergi'=>$row['alergi'],
'lingkar_perut'=>$row['lingkar_perut'],
'rtl'=>$row['rtl'],
'penilaian'=>$row['penilaian'],
'instruksi'=>$row['instruksi'],
'evaluasi'=>$row['evaluasi'],
'nip'=>$row['nip']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($no_rawat)
    {
        $detail = $this->db('pemeriksaan_ralan')->where('no_rawat', $no_rawat)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/pemeriksaan_ralan/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/pemeriksaan_ralan/js/admin/scripts.js', ['settings' => $settings]);
        exit();
    }

    private function _addHeaderFiles()
    {
        $this->core->addCSS(url('assets/css/datatables.min.css'));
        $this->core->addJS(url('assets/jscripts/jqueryvalidation.js'));
        $this->core->addJS(url('assets/jscripts/xlsx.js'));
        $this->core->addJS(url('assets/jscripts/jspdf.min.js'));
        $this->core->addJS(url('assets/jscripts/jspdf.plugin.autotable.min.js'));
        $this->core->addJS(url('assets/jscripts/datatables.min.js'));

        $this->core->addCSS(url([ADMIN, 'pemeriksaan_ralan', 'css']));
        $this->core->addJS(url([ADMIN, 'pemeriksaan_ralan', 'javascript']), 'footer');
    }

}
