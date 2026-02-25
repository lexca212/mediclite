<?php
namespace Plugins\Reg_periksa;

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
        $search_field_reg_periksa= $_POST['search_field_reg_periksa'];
        $search_text_reg_periksa = $_POST['search_text_reg_periksa'];

        $searchQuery = " ";
        if($search_text_reg_periksa != ''){
            $searchQuery .= " and (".$search_field_reg_periksa." like '%".$search_text_reg_periksa."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from reg_periksa");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from reg_periksa WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from reg_periksa WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'no_reg'=>$row['no_reg'],
'no_rawat'=>$row['no_rawat'],
'tgl_registrasi'=>$row['tgl_registrasi'],
'jam_reg'=>$row['jam_reg'],
'kd_dokter'=>$row['kd_dokter'],
'no_rkm_medis'=>$row['no_rkm_medis'],
'kd_poli'=>$row['kd_poli'],
'p_jawab'=>$row['p_jawab'],
'almt_pj'=>$row['almt_pj'],
'hubunganpj'=>$row['hubunganpj'],
'biaya_reg'=>$row['biaya_reg'],
'stts'=>$row['stts'],
'stts_daftar'=>$row['stts_daftar'],
'status_lanjut'=>$row['status_lanjut'],
'kd_pj'=>$row['kd_pj'],
'umurdaftar'=>$row['umurdaftar'],
'sttsumur'=>$row['sttsumur'],
'status_bayar'=>$row['status_bayar'],
'status_poli'=>$row['status_poli']

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

        $no_reg = $_POST['no_reg'];
$no_rawat = $_POST['no_rawat'];
$tgl_registrasi = $_POST['tgl_registrasi'];
$jam_reg = $_POST['jam_reg'];
$kd_dokter = $_POST['kd_dokter'];
$no_rkm_medis = $_POST['no_rkm_medis'];
$kd_poli = $_POST['kd_poli'];
$p_jawab = $_POST['p_jawab'];
$almt_pj = $_POST['almt_pj'];
$hubunganpj = $_POST['hubunganpj'];
$biaya_reg = $_POST['biaya_reg'];
$stts = $_POST['stts'];
$stts_daftar = $_POST['stts_daftar'];
$status_lanjut = $_POST['status_lanjut'];
$kd_pj = $_POST['kd_pj'];
$umurdaftar = $_POST['umurdaftar'];
$sttsumur = $_POST['sttsumur'];
$status_bayar = $_POST['status_bayar'];
$status_poli = $_POST['status_poli'];

            
            $reg_periksa_add = $this->db()->pdo()->prepare('INSERT INTO reg_periksa VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $reg_periksa_add->execute([$no_reg, $no_rawat, $tgl_registrasi, $jam_reg, $kd_dokter, $no_rkm_medis, $kd_poli, $p_jawab, $almt_pj, $hubunganpj, $biaya_reg, $stts, $stts_daftar, $status_lanjut, $kd_pj, $umurdaftar, $sttsumur, $status_bayar, $status_poli]);

        }
        if ($act=="edit") {

        $no_reg = $_POST['no_reg'];
$no_rawat = $_POST['no_rawat'];
$tgl_registrasi = $_POST['tgl_registrasi'];
$jam_reg = $_POST['jam_reg'];
$kd_dokter = $_POST['kd_dokter'];
$no_rkm_medis = $_POST['no_rkm_medis'];
$kd_poli = $_POST['kd_poli'];
$p_jawab = $_POST['p_jawab'];
$almt_pj = $_POST['almt_pj'];
$hubunganpj = $_POST['hubunganpj'];
$biaya_reg = $_POST['biaya_reg'];
$stts = $_POST['stts'];
$stts_daftar = $_POST['stts_daftar'];
$status_lanjut = $_POST['status_lanjut'];
$kd_pj = $_POST['kd_pj'];
$umurdaftar = $_POST['umurdaftar'];
$sttsumur = $_POST['sttsumur'];
$status_bayar = $_POST['status_bayar'];
$status_poli = $_POST['status_poli'];


        // BUANG FIELD PERTAMA

            $reg_periksa_edit = $this->db()->pdo()->prepare("UPDATE reg_periksa SET no_reg=?, no_rawat=?, tgl_registrasi=?, jam_reg=?, kd_dokter=?, no_rkm_medis=?, kd_poli=?, p_jawab=?, almt_pj=?, hubunganpj=?, biaya_reg=?, stts=?, stts_daftar=?, status_lanjut=?, kd_pj=?, umurdaftar=?, sttsumur=?, status_bayar=?, status_poli=? WHERE no_reg=?");
            $reg_periksa_edit->execute([$no_reg, $no_rawat, $tgl_registrasi, $jam_reg, $kd_dokter, $no_rkm_medis, $kd_poli, $p_jawab, $almt_pj, $hubunganpj, $biaya_reg, $stts, $stts_daftar, $status_lanjut, $kd_pj, $umurdaftar, $sttsumur, $status_bayar, $status_poli,$no_reg]);
        
        }

        if ($act=="del") {
            $no_rawat = $_POST['no_rawat'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM reg_periksa WHERE no_rawat='$no_rawat'");
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

            $search_field_reg_periksa= $_POST['search_field_reg_periksa'];
            $search_text_reg_periksa = $_POST['search_text_reg_periksa'];

            $searchQuery = " ";
            if($search_text_reg_periksa != ''){
                $searchQuery .= " and (".$search_field_reg_periksa." like '%".$search_text_reg_periksa."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from reg_periksa WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'no_reg'=>$row['no_reg'],
'no_rawat'=>$row['no_rawat'],
'tgl_registrasi'=>$row['tgl_registrasi'],
'jam_reg'=>$row['jam_reg'],
'kd_dokter'=>$row['kd_dokter'],
'no_rkm_medis'=>$row['no_rkm_medis'],
'kd_poli'=>$row['kd_poli'],
'p_jawab'=>$row['p_jawab'],
'almt_pj'=>$row['almt_pj'],
'hubunganpj'=>$row['hubunganpj'],
'biaya_reg'=>$row['biaya_reg'],
'stts'=>$row['stts'],
'stts_daftar'=>$row['stts_daftar'],
'status_lanjut'=>$row['status_lanjut'],
'kd_pj'=>$row['kd_pj'],
'umurdaftar'=>$row['umurdaftar'],
'sttsumur'=>$row['sttsumur'],
'status_bayar'=>$row['status_bayar'],
'status_poli'=>$row['status_poli']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($no_reg)
    {
        $detail = $this->db('reg_periksa')->where('no_reg', $no_reg)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/reg_periksa/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/reg_periksa/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'reg_periksa', 'css']));
        $this->core->addJS(url([ADMIN, 'reg_periksa', 'javascript']), 'footer');
    }

}
