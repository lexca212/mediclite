<?php
namespace Plugins\masuk_nicu;

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
        $search_field_mlite_masuk_nicu= $_POST['search_field_mlite_masuk_nicu'];
        $search_text_mlite_masuk_nicu = $_POST['search_text_mlite_masuk_nicu'];

        $searchQuery = " ";
        if($search_text_mlite_masuk_nicu != ''){
            $searchQuery .= " and (".$search_field_mlite_masuk_nicu." like '%".$search_text_mlite_masuk_nicu."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from mlite_masuk_nicu");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from mlite_masuk_nicu WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from mlite_masuk_nicu WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'no_rawat'=>$row['no_rawat'],
'tanggal'=>$row['tanggal'],
'kd_dokter'=>$row['kd_dokter'],
'diagnosa'=>$row['diagnosa'],
'tanda_vital_a'=>$row['tanda_vital_a'],
'tanda_vital_b'=>$row['tanda_vital_b'],
'tanda_vital_c'=>$row['tanda_vital_c'],
'tanda_vital_d'=>$row['tanda_vital_d'],
'tanda_vital_e'=>$row['tanda_vital_e'],
'keterangan_tanda_vital_a'=>$row['keterangan_tanda_vital_a'],
'keterangan_tanda_vital_b'=>$row['keterangan_tanda_vital_b'],
'keterangan_tanda_vital_c'=>$row['keterangan_tanda_vital_c'],
'keterangan_tanda_vital_d'=>$row['keterangan_tanda_vital_d'],
'keterangan_tanda_vital_e'=>$row['keterangan_tanda_vital_e'],
'pemeriksaan_fisik_a'=>$row['pemeriksaan_fisik_a'],
'pemeriksaan_fisik_b'=>$row['pemeriksaan_fisik_b'],
'pemeriksaan_fisik_c'=>$row['pemeriksaan_fisik_c'],
'pemeriksaan_fisik_d'=>$row['pemeriksaan_fisik_d'],
'pemeriksaan_fisik_e'=>$row['pemeriksaan_fisik_e'],
'pemeriksaan_fisik_f'=>$row['pemeriksaan_fisik_f'],
'pemeriksaan_fisik_g'=>$row['pemeriksaan_fisik_g'],
'pemeriksaan_fisik_h'=>$row['pemeriksaan_fisik_h'],
'keterangan_pemeriksaan_fisik_a'=>$row['keterangan_pemeriksaan_fisik_a'],
'keterangan_pemeriksaan_fisik_b'=>$row['keterangan_pemeriksaan_fisik_b'],
'keterangan_pemeriksaan_fisik_c'=>$row['keterangan_pemeriksaan_fisik_c'],
'keterangan_pemeriksaan_fisik_d'=>$row['keterangan_pemeriksaan_fisik_d'],
'keterangan_pemeriksaan_fisik_e'=>$row['keterangan_pemeriksaan_fisik_e'],
'keterangan_pemeriksaan_fisik_f'=>$row['keterangan_pemeriksaan_fisik_f'],
'keterangan_pemeriksaan_fisik_g'=>$row['keterangan_pemeriksaan_fisik_g'],
'keterangan_pemeriksaan_fisik_h'=>$row['keterangan_pemeriksaan_fisik_h'],
'nilai_lab_a'=>$row['nilai_lab_a'],
'nilai_lab_b'=>$row['nilai_lab_b'],
'nilai_lab_c'=>$row['nilai_lab_c'],
'nilai_lab_d'=>$row['nilai_lab_d'],
'nilai_lab_e'=>$row['nilai_lab_e'],
'nilai_lab_f'=>$row['nilai_lab_f'],
'nilai_lab_g'=>$row['nilai_lab_g'],
'nilai_lab_h'=>$row['nilai_lab_h'],
'nilai_lab_i'=>$row['nilai_lab_i'],
'nilai_lab_j'=>$row['nilai_lab_j'],
'nilai_lab_k'=>$row['nilai_lab_k'],
'keterangan_nilai_lab_a'=>$row['keterangan_nilai_lab_a'],
'keterangan_nilai_lab_b'=>$row['keterangan_nilai_lab_b'],
'keterangan_nilai_lab_c'=>$row['keterangan_nilai_lab_c'],
'keterangan_nilai_lab_d'=>$row['keterangan_nilai_lab_d'],
'keterangan_nilai_lab_e'=>$row['keterangan_nilai_lab_e'],
'keterangan_nilai_lab_f'=>$row['keterangan_nilai_lab_f'],
'keterangan_nilai_lab_g'=>$row['keterangan_nilai_lab_g'],
'keterangan_nilai_lab_h'=>$row['keterangan_nilai_lab_h'],
'keterangan_nilai_lab_i'=>$row['keterangan_nilai_lab_i'],
'keterangan_nilai_lab_j'=>$row['keterangan_nilai_lab_j'],
'keterangan_nilai_lab_k'=>$row['keterangan_nilai_lab_k'],
'kondisi_lain_a'=>$row['kondisi_lain_a'],
'kondisi_lain_b'=>$row['kondisi_lain_b'],
'kondisi_lain_c'=>$row['kondisi_lain_c'],
'kondisi_lain_d'=>$row['kondisi_lain_d'],
'keterangan_kondisi_lain_a'=>$row['keterangan_kondisi_lain_a'],
'keterangan_kondisi_lain_b'=>$row['keterangan_kondisi_lain_b'],
'keterangan_kondisi_lain_c'=>$row['keterangan_kondisi_lain_c'],
'keterangan_kondisi_lain_d'=>$row['keterangan_kondisi_lain_d'],
'kesimpulan_level'=>$row['kesimpulan_level'],
'kesimpulan_transport'=>$row['kesimpulan_transport'],
'kesimpulan_pendamping'=>$row['kesimpulan_pendamping'],
'kesimpulan_alat'=>$row['kesimpulan_alat']

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
$tanggal = $_POST['tanggal'];
$kd_dokter = $_POST['kd_dokter'];
$diagnosa = $_POST['diagnosa'];
$tanda_vital_a = $_POST['tanda_vital_a'];
$tanda_vital_b = $_POST['tanda_vital_b'];
$tanda_vital_c = $_POST['tanda_vital_c'];
$tanda_vital_d = $_POST['tanda_vital_d'];
$tanda_vital_e = $_POST['tanda_vital_e'];
$keterangan_tanda_vital_a = $_POST['keterangan_tanda_vital_a'];
$keterangan_tanda_vital_b = $_POST['keterangan_tanda_vital_b'];
$keterangan_tanda_vital_c = $_POST['keterangan_tanda_vital_c'];
$keterangan_tanda_vital_d = $_POST['keterangan_tanda_vital_d'];
$keterangan_tanda_vital_e = $_POST['keterangan_tanda_vital_e'];
$pemeriksaan_fisik_a = $_POST['pemeriksaan_fisik_a'];
$pemeriksaan_fisik_b = $_POST['pemeriksaan_fisik_b'];
$pemeriksaan_fisik_c = $_POST['pemeriksaan_fisik_c'];
$pemeriksaan_fisik_d = $_POST['pemeriksaan_fisik_d'];
$pemeriksaan_fisik_e = $_POST['pemeriksaan_fisik_e'];
$pemeriksaan_fisik_f = $_POST['pemeriksaan_fisik_f'];
$pemeriksaan_fisik_g = $_POST['pemeriksaan_fisik_g'];
$pemeriksaan_fisik_h = $_POST['pemeriksaan_fisik_h'];
$keterangan_pemeriksaan_fisik_a = $_POST['keterangan_pemeriksaan_fisik_a'];
$keterangan_pemeriksaan_fisik_b = $_POST['keterangan_pemeriksaan_fisik_b'];
$keterangan_pemeriksaan_fisik_c = $_POST['keterangan_pemeriksaan_fisik_c'];
$keterangan_pemeriksaan_fisik_d = $_POST['keterangan_pemeriksaan_fisik_d'];
$keterangan_pemeriksaan_fisik_e = $_POST['keterangan_pemeriksaan_fisik_e'];
$keterangan_pemeriksaan_fisik_f = $_POST['keterangan_pemeriksaan_fisik_f'];
$keterangan_pemeriksaan_fisik_g = $_POST['keterangan_pemeriksaan_fisik_g'];
$keterangan_pemeriksaan_fisik_h = $_POST['keterangan_pemeriksaan_fisik_h'];
$nilai_lab_a = $_POST['nilai_lab_a'];
$nilai_lab_b = $_POST['nilai_lab_b'];
$nilai_lab_c = $_POST['nilai_lab_c'];
$nilai_lab_d = $_POST['nilai_lab_d'];
$nilai_lab_e = $_POST['nilai_lab_e'];
$nilai_lab_f = $_POST['nilai_lab_f'];
$nilai_lab_g = $_POST['nilai_lab_g'];
$nilai_lab_h = $_POST['nilai_lab_h'];
$nilai_lab_i = $_POST['nilai_lab_i'];
$nilai_lab_j = $_POST['nilai_lab_j'];
$nilai_lab_k = $_POST['nilai_lab_k'];
$keterangan_nilai_lab_a = $_POST['keterangan_nilai_lab_a'];
$keterangan_nilai_lab_b = $_POST['keterangan_nilai_lab_b'];
$keterangan_nilai_lab_c = $_POST['keterangan_nilai_lab_c'];
$keterangan_nilai_lab_d = $_POST['keterangan_nilai_lab_d'];
$keterangan_nilai_lab_e = $_POST['keterangan_nilai_lab_e'];
$keterangan_nilai_lab_f = $_POST['keterangan_nilai_lab_f'];
$keterangan_nilai_lab_g = $_POST['keterangan_nilai_lab_g'];
$keterangan_nilai_lab_h = $_POST['keterangan_nilai_lab_h'];
$keterangan_nilai_lab_i = $_POST['keterangan_nilai_lab_i'];
$keterangan_nilai_lab_j = $_POST['keterangan_nilai_lab_j'];
$keterangan_nilai_lab_k = $_POST['keterangan_nilai_lab_k'];
$kondisi_lain_a = $_POST['kondisi_lain_a'];
$kondisi_lain_b = $_POST['kondisi_lain_b'];
$kondisi_lain_c = $_POST['kondisi_lain_c'];
$kondisi_lain_d = $_POST['kondisi_lain_d'];
$keterangan_kondisi_lain_a = $_POST['keterangan_kondisi_lain_a'];
$keterangan_kondisi_lain_b = $_POST['keterangan_kondisi_lain_b'];
$keterangan_kondisi_lain_c = $_POST['keterangan_kondisi_lain_c'];
$keterangan_kondisi_lain_d = $_POST['keterangan_kondisi_lain_d'];
$kesimpulan_level = $_POST['kesimpulan_level'];
$kesimpulan_transport = $_POST['kesimpulan_transport'];
$kesimpulan_pendamping = $_POST['kesimpulan_pendamping'];
$kesimpulan_alat = $_POST['kesimpulan_alat'];

            
            $mlite_masuk_nicu_add = $this->db()->pdo()->prepare('INSERT INTO mlite_masuk_nicu VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $mlite_masuk_nicu_add->execute([$no_rawat, $tanggal, $kd_dokter, $diagnosa, $tanda_vital_a, $tanda_vital_b, $tanda_vital_c, $tanda_vital_d, $tanda_vital_e, $keterangan_tanda_vital_a, $keterangan_tanda_vital_b, $keterangan_tanda_vital_c, $keterangan_tanda_vital_d, $keterangan_tanda_vital_e, $pemeriksaan_fisik_a, $pemeriksaan_fisik_b, $pemeriksaan_fisik_c, $pemeriksaan_fisik_d, $pemeriksaan_fisik_e, $pemeriksaan_fisik_f, $pemeriksaan_fisik_g, $pemeriksaan_fisik_h, $keterangan_pemeriksaan_fisik_a, $keterangan_pemeriksaan_fisik_b, $keterangan_pemeriksaan_fisik_c, $keterangan_pemeriksaan_fisik_d, $keterangan_pemeriksaan_fisik_e, $keterangan_pemeriksaan_fisik_f, $keterangan_pemeriksaan_fisik_g, $keterangan_pemeriksaan_fisik_h, $nilai_lab_a, $nilai_lab_b, $nilai_lab_c, $nilai_lab_d, $nilai_lab_e, $nilai_lab_f, $nilai_lab_g, $nilai_lab_h, $nilai_lab_i, $nilai_lab_j, $nilai_lab_k, $keterangan_nilai_lab_a, $keterangan_nilai_lab_b, $keterangan_nilai_lab_c, $keterangan_nilai_lab_d, $keterangan_nilai_lab_e, $keterangan_nilai_lab_f, $keterangan_nilai_lab_g, $keterangan_nilai_lab_h, $keterangan_nilai_lab_i, $keterangan_nilai_lab_j, $keterangan_nilai_lab_k, $kondisi_lain_a, $kondisi_lain_b, $kondisi_lain_c, $kondisi_lain_d, $keterangan_kondisi_lain_a, $keterangan_kondisi_lain_b, $keterangan_kondisi_lain_c, $keterangan_kondisi_lain_d, $kesimpulan_level, $kesimpulan_transport, $kesimpulan_pendamping, $kesimpulan_alat]);

        }
        if ($act=="edit") {

        $no_rawat = $_POST['no_rawat'];
$tanggal = $_POST['tanggal'];
$kd_dokter = $_POST['kd_dokter'];
$diagnosa = $_POST['diagnosa'];
$tanda_vital_a = $_POST['tanda_vital_a'];
$tanda_vital_b = $_POST['tanda_vital_b'];
$tanda_vital_c = $_POST['tanda_vital_c'];
$tanda_vital_d = $_POST['tanda_vital_d'];
$tanda_vital_e = $_POST['tanda_vital_e'];
$keterangan_tanda_vital_a = $_POST['keterangan_tanda_vital_a'];
$keterangan_tanda_vital_b = $_POST['keterangan_tanda_vital_b'];
$keterangan_tanda_vital_c = $_POST['keterangan_tanda_vital_c'];
$keterangan_tanda_vital_d = $_POST['keterangan_tanda_vital_d'];
$keterangan_tanda_vital_e = $_POST['keterangan_tanda_vital_e'];
$pemeriksaan_fisik_a = $_POST['pemeriksaan_fisik_a'];
$pemeriksaan_fisik_b = $_POST['pemeriksaan_fisik_b'];
$pemeriksaan_fisik_c = $_POST['pemeriksaan_fisik_c'];
$pemeriksaan_fisik_d = $_POST['pemeriksaan_fisik_d'];
$pemeriksaan_fisik_e = $_POST['pemeriksaan_fisik_e'];
$pemeriksaan_fisik_f = $_POST['pemeriksaan_fisik_f'];
$pemeriksaan_fisik_g = $_POST['pemeriksaan_fisik_g'];
$pemeriksaan_fisik_h = $_POST['pemeriksaan_fisik_h'];
$keterangan_pemeriksaan_fisik_a = $_POST['keterangan_pemeriksaan_fisik_a'];
$keterangan_pemeriksaan_fisik_b = $_POST['keterangan_pemeriksaan_fisik_b'];
$keterangan_pemeriksaan_fisik_c = $_POST['keterangan_pemeriksaan_fisik_c'];
$keterangan_pemeriksaan_fisik_d = $_POST['keterangan_pemeriksaan_fisik_d'];
$keterangan_pemeriksaan_fisik_e = $_POST['keterangan_pemeriksaan_fisik_e'];
$keterangan_pemeriksaan_fisik_f = $_POST['keterangan_pemeriksaan_fisik_f'];
$keterangan_pemeriksaan_fisik_g = $_POST['keterangan_pemeriksaan_fisik_g'];
$keterangan_pemeriksaan_fisik_h = $_POST['keterangan_pemeriksaan_fisik_h'];
$nilai_lab_a = $_POST['nilai_lab_a'];
$nilai_lab_b = $_POST['nilai_lab_b'];
$nilai_lab_c = $_POST['nilai_lab_c'];
$nilai_lab_d = $_POST['nilai_lab_d'];
$nilai_lab_e = $_POST['nilai_lab_e'];
$nilai_lab_f = $_POST['nilai_lab_f'];
$nilai_lab_g = $_POST['nilai_lab_g'];
$nilai_lab_h = $_POST['nilai_lab_h'];
$nilai_lab_i = $_POST['nilai_lab_i'];
$nilai_lab_j = $_POST['nilai_lab_j'];
$nilai_lab_k = $_POST['nilai_lab_k'];
$keterangan_nilai_lab_a = $_POST['keterangan_nilai_lab_a'];
$keterangan_nilai_lab_b = $_POST['keterangan_nilai_lab_b'];
$keterangan_nilai_lab_c = $_POST['keterangan_nilai_lab_c'];
$keterangan_nilai_lab_d = $_POST['keterangan_nilai_lab_d'];
$keterangan_nilai_lab_e = $_POST['keterangan_nilai_lab_e'];
$keterangan_nilai_lab_f = $_POST['keterangan_nilai_lab_f'];
$keterangan_nilai_lab_g = $_POST['keterangan_nilai_lab_g'];
$keterangan_nilai_lab_h = $_POST['keterangan_nilai_lab_h'];
$keterangan_nilai_lab_i = $_POST['keterangan_nilai_lab_i'];
$keterangan_nilai_lab_j = $_POST['keterangan_nilai_lab_j'];
$keterangan_nilai_lab_k = $_POST['keterangan_nilai_lab_k'];
$kondisi_lain_a = $_POST['kondisi_lain_a'];
$kondisi_lain_b = $_POST['kondisi_lain_b'];
$kondisi_lain_c = $_POST['kondisi_lain_c'];
$kondisi_lain_d = $_POST['kondisi_lain_d'];
$keterangan_kondisi_lain_a = $_POST['keterangan_kondisi_lain_a'];
$keterangan_kondisi_lain_b = $_POST['keterangan_kondisi_lain_b'];
$keterangan_kondisi_lain_c = $_POST['keterangan_kondisi_lain_c'];
$keterangan_kondisi_lain_d = $_POST['keterangan_kondisi_lain_d'];
$kesimpulan_level = $_POST['kesimpulan_level'];
$kesimpulan_transport = $_POST['kesimpulan_transport'];
$kesimpulan_pendamping = $_POST['kesimpulan_pendamping'];
$kesimpulan_alat = $_POST['kesimpulan_alat'];


        // BUANG FIELD PERTAMA

            $mlite_masuk_nicu_edit = $this->db()->pdo()->prepare("UPDATE mlite_masuk_nicu SET no_rawat=?, tanggal=?, kd_dokter=?, diagnosa=?, tanda_vital_a=?, tanda_vital_b=?, tanda_vital_c=?, tanda_vital_d=?, tanda_vital_e=?, keterangan_tanda_vital_a=?, keterangan_tanda_vital_b=?, keterangan_tanda_vital_c=?, keterangan_tanda_vital_d=?, keterangan_tanda_vital_e=?, pemeriksaan_fisik_a=?, pemeriksaan_fisik_b=?, pemeriksaan_fisik_c=?, pemeriksaan_fisik_d=?, pemeriksaan_fisik_e=?, pemeriksaan_fisik_f=?, pemeriksaan_fisik_g=?, pemeriksaan_fisik_h=?, keterangan_pemeriksaan_fisik_a=?, keterangan_pemeriksaan_fisik_b=?, keterangan_pemeriksaan_fisik_c=?, keterangan_pemeriksaan_fisik_d=?, keterangan_pemeriksaan_fisik_e=?, keterangan_pemeriksaan_fisik_f=?, keterangan_pemeriksaan_fisik_g=?, keterangan_pemeriksaan_fisik_h=?, nilai_lab_a=?, nilai_lab_b=?, nilai_lab_c=?, nilai_lab_d=?, nilai_lab_e=?, nilai_lab_f=?, nilai_lab_g=?, nilai_lab_h=?, nilai_lab_i=?, nilai_lab_j=?, nilai_lab_k=?, keterangan_nilai_lab_a=?, keterangan_nilai_lab_b=?, keterangan_nilai_lab_c=?, keterangan_nilai_lab_d=?, keterangan_nilai_lab_e=?, keterangan_nilai_lab_f=?, keterangan_nilai_lab_g=?, keterangan_nilai_lab_h=?, keterangan_nilai_lab_i=?, keterangan_nilai_lab_j=?, keterangan_nilai_lab_k=?, kondisi_lain_a=?, kondisi_lain_b=?, kondisi_lain_c=?, kondisi_lain_d=?, keterangan_kondisi_lain_a=?, keterangan_kondisi_lain_b=?, keterangan_kondisi_lain_c=?, keterangan_kondisi_lain_d=?, kesimpulan_level=?, kesimpulan_transport=?, kesimpulan_pendamping=?, kesimpulan_alat=? WHERE no_rawat=?");
            $mlite_masuk_nicu_edit->execute([$no_rawat, $tanggal, $kd_dokter, $diagnosa, $tanda_vital_a, $tanda_vital_b, $tanda_vital_c, $tanda_vital_d, $tanda_vital_e, $keterangan_tanda_vital_a, $keterangan_tanda_vital_b, $keterangan_tanda_vital_c, $keterangan_tanda_vital_d, $keterangan_tanda_vital_e, $pemeriksaan_fisik_a, $pemeriksaan_fisik_b, $pemeriksaan_fisik_c, $pemeriksaan_fisik_d, $pemeriksaan_fisik_e, $pemeriksaan_fisik_f, $pemeriksaan_fisik_g, $pemeriksaan_fisik_h, $keterangan_pemeriksaan_fisik_a, $keterangan_pemeriksaan_fisik_b, $keterangan_pemeriksaan_fisik_c, $keterangan_pemeriksaan_fisik_d, $keterangan_pemeriksaan_fisik_e, $keterangan_pemeriksaan_fisik_f, $keterangan_pemeriksaan_fisik_g, $keterangan_pemeriksaan_fisik_h, $nilai_lab_a, $nilai_lab_b, $nilai_lab_c, $nilai_lab_d, $nilai_lab_e, $nilai_lab_f, $nilai_lab_g, $nilai_lab_h, $nilai_lab_i, $nilai_lab_j, $nilai_lab_k, $keterangan_nilai_lab_a, $keterangan_nilai_lab_b, $keterangan_nilai_lab_c, $keterangan_nilai_lab_d, $keterangan_nilai_lab_e, $keterangan_nilai_lab_f, $keterangan_nilai_lab_g, $keterangan_nilai_lab_h, $keterangan_nilai_lab_i, $keterangan_nilai_lab_j, $keterangan_nilai_lab_k, $kondisi_lain_a, $kondisi_lain_b, $kondisi_lain_c, $kondisi_lain_d, $keterangan_kondisi_lain_a, $keterangan_kondisi_lain_b, $keterangan_kondisi_lain_c, $keterangan_kondisi_lain_d, $kesimpulan_level, $kesimpulan_transport, $kesimpulan_pendamping, $kesimpulan_alat,$no_rawat]);
        
        }

        if ($act=="del") {
            $no_rawat= $_POST['no_rawat'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM mlite_masuk_nicu WHERE no_rawat='$no_rawat'");
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

            $search_field_mlite_masuk_nicu= $_POST['search_field_mlite_masuk_nicu'];
            $search_text_mlite_masuk_nicu = $_POST['search_text_mlite_masuk_nicu'];

            $searchQuery = " ";
            if($search_text_mlite_masuk_nicu != ''){
                $searchQuery .= " and (".$search_field_mlite_masuk_nicu." like '%".$search_text_mlite_masuk_nicu."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from mlite_masuk_nicu WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'no_rawat'=>$row['no_rawat'],
'tanggal'=>$row['tanggal'],
'kd_dokter'=>$row['kd_dokter'],
'diagnosa'=>$row['diagnosa'],
'tanda_vital_a'=>$row['tanda_vital_a'],
'tanda_vital_b'=>$row['tanda_vital_b'],
'tanda_vital_c'=>$row['tanda_vital_c'],
'tanda_vital_d'=>$row['tanda_vital_d'],
'tanda_vital_e'=>$row['tanda_vital_e'],
'keterangan_tanda_vital_a'=>$row['keterangan_tanda_vital_a'],
'keterangan_tanda_vital_b'=>$row['keterangan_tanda_vital_b'],
'keterangan_tanda_vital_c'=>$row['keterangan_tanda_vital_c'],
'keterangan_tanda_vital_d'=>$row['keterangan_tanda_vital_d'],
'keterangan_tanda_vital_e'=>$row['keterangan_tanda_vital_e'],
'pemeriksaan_fisik_a'=>$row['pemeriksaan_fisik_a'],
'pemeriksaan_fisik_b'=>$row['pemeriksaan_fisik_b'],
'pemeriksaan_fisik_c'=>$row['pemeriksaan_fisik_c'],
'pemeriksaan_fisik_d'=>$row['pemeriksaan_fisik_d'],
'pemeriksaan_fisik_e'=>$row['pemeriksaan_fisik_e'],
'pemeriksaan_fisik_f'=>$row['pemeriksaan_fisik_f'],
'pemeriksaan_fisik_g'=>$row['pemeriksaan_fisik_g'],
'pemeriksaan_fisik_h'=>$row['pemeriksaan_fisik_h'],
'keterangan_pemeriksaan_fisik_a'=>$row['keterangan_pemeriksaan_fisik_a'],
'keterangan_pemeriksaan_fisik_b'=>$row['keterangan_pemeriksaan_fisik_b'],
'keterangan_pemeriksaan_fisik_c'=>$row['keterangan_pemeriksaan_fisik_c'],
'keterangan_pemeriksaan_fisik_d'=>$row['keterangan_pemeriksaan_fisik_d'],
'keterangan_pemeriksaan_fisik_e'=>$row['keterangan_pemeriksaan_fisik_e'],
'keterangan_pemeriksaan_fisik_f'=>$row['keterangan_pemeriksaan_fisik_f'],
'keterangan_pemeriksaan_fisik_g'=>$row['keterangan_pemeriksaan_fisik_g'],
'keterangan_pemeriksaan_fisik_h'=>$row['keterangan_pemeriksaan_fisik_h'],
'nilai_lab_a'=>$row['nilai_lab_a'],
'nilai_lab_b'=>$row['nilai_lab_b'],
'nilai_lab_c'=>$row['nilai_lab_c'],
'nilai_lab_d'=>$row['nilai_lab_d'],
'nilai_lab_e'=>$row['nilai_lab_e'],
'nilai_lab_f'=>$row['nilai_lab_f'],
'nilai_lab_g'=>$row['nilai_lab_g'],
'nilai_lab_h'=>$row['nilai_lab_h'],
'nilai_lab_i'=>$row['nilai_lab_i'],
'nilai_lab_j'=>$row['nilai_lab_j'],
'nilai_lab_k'=>$row['nilai_lab_k'],
'keterangan_nilai_lab_a'=>$row['keterangan_nilai_lab_a'],
'keterangan_nilai_lab_b'=>$row['keterangan_nilai_lab_b'],
'keterangan_nilai_lab_c'=>$row['keterangan_nilai_lab_c'],
'keterangan_nilai_lab_d'=>$row['keterangan_nilai_lab_d'],
'keterangan_nilai_lab_e'=>$row['keterangan_nilai_lab_e'],
'keterangan_nilai_lab_f'=>$row['keterangan_nilai_lab_f'],
'keterangan_nilai_lab_g'=>$row['keterangan_nilai_lab_g'],
'keterangan_nilai_lab_h'=>$row['keterangan_nilai_lab_h'],
'keterangan_nilai_lab_i'=>$row['keterangan_nilai_lab_i'],
'keterangan_nilai_lab_j'=>$row['keterangan_nilai_lab_j'],
'keterangan_nilai_lab_k'=>$row['keterangan_nilai_lab_k'],
'kondisi_lain_a'=>$row['kondisi_lain_a'],
'kondisi_lain_b'=>$row['kondisi_lain_b'],
'kondisi_lain_c'=>$row['kondisi_lain_c'],
'kondisi_lain_d'=>$row['kondisi_lain_d'],
'keterangan_kondisi_lain_a'=>$row['keterangan_kondisi_lain_a'],
'keterangan_kondisi_lain_b'=>$row['keterangan_kondisi_lain_b'],
'keterangan_kondisi_lain_c'=>$row['keterangan_kondisi_lain_c'],
'keterangan_kondisi_lain_d'=>$row['keterangan_kondisi_lain_d'],
'kesimpulan_level'=>$row['kesimpulan_level'],
'kesimpulan_transport'=>$row['kesimpulan_transport'],
'kesimpulan_pendamping'=>$row['kesimpulan_pendamping'],
'kesimpulan_alat'=>$row['kesimpulan_alat']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($no_rawat)
    {
        $detail = $this->db('mlite_masuk_nicu')->where('no_rawat', $no_rawat)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/masuk_nicu/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/masuk_nicu/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'masuk_nicu', 'css']));
        $this->core->addJS(url([ADMIN, 'masuk_nicu', 'javascript']), 'footer');
    }

}
