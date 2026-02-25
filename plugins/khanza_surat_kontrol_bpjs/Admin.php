<?php
namespace Plugins\khanza_surat_kontrol_bpjs;

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
        $search_field_bridging_surat_kontrol_bpjs= $_POST['search_field_bridging_surat_kontrol_bpjs'];
        $search_text_bridging_surat_kontrol_bpjs = $_POST['search_text_bridging_surat_kontrol_bpjs'];

        $searchQuery = " ";
        if($search_text_bridging_surat_kontrol_bpjs != ''){
            $searchQuery .= " and (".$search_field_bridging_surat_kontrol_bpjs." like '%".$search_text_bridging_surat_kontrol_bpjs."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from bridging_surat_kontrol_bpjs");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from bridging_surat_kontrol_bpjs WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from bridging_surat_kontrol_bpjs WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'no_sep'=>$row['no_sep'],
'tgl_surat'=>$row['tgl_surat'],
'no_surat'=>$row['no_surat'],
'tgl_rencana'=>$row['tgl_rencana'],
'kd_dokter_bpjs'=>$row['kd_dokter_bpjs'],
'nm_dokter_bpjs'=>$row['nm_dokter_bpjs'],
'kd_poli_bpjs'=>$row['kd_poli_bpjs'],
'nm_poli_bpjs'=>$row['nm_poli_bpjs']

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

        $no_sep = $_POST['no_sep'];
$tgl_surat = $_POST['tgl_surat'];
$no_surat = $_POST['no_surat'];
$tgl_rencana = $_POST['tgl_rencana'];
$kd_dokter_bpjs = $_POST['kd_dokter_bpjs'];
$nm_dokter_bpjs = $_POST['nm_dokter_bpjs'];
$kd_poli_bpjs = $_POST['kd_poli_bpjs'];
$nm_poli_bpjs = $_POST['nm_poli_bpjs'];

            
            $bridging_surat_kontrol_bpjs_add = $this->db()->pdo()->prepare('INSERT INTO bridging_surat_kontrol_bpjs VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
            $bridging_surat_kontrol_bpjs_add->execute([$no_sep, $tgl_surat, $no_surat, $tgl_rencana, $kd_dokter_bpjs, $nm_dokter_bpjs, $kd_poli_bpjs, $nm_poli_bpjs]);

        }
        if ($act=="edit") {

        $no_sep = $_POST['no_sep'];
$tgl_surat = $_POST['tgl_surat'];
$no_surat = $_POST['no_surat'];
$tgl_rencana = $_POST['tgl_rencana'];
$kd_dokter_bpjs = $_POST['kd_dokter_bpjs'];
$nm_dokter_bpjs = $_POST['nm_dokter_bpjs'];
$kd_poli_bpjs = $_POST['kd_poli_bpjs'];
$nm_poli_bpjs = $_POST['nm_poli_bpjs'];


        // BUANG FIELD PERTAMA

            $bridging_surat_kontrol_bpjs_edit = $this->db()->pdo()->prepare("UPDATE bridging_surat_kontrol_bpjs SET no_sep=?, tgl_surat=?, no_surat=?, tgl_rencana=?, kd_dokter_bpjs=?, nm_dokter_bpjs=?, kd_poli_bpjs=?, nm_poli_bpjs=? WHERE no_sep=?");
            $bridging_surat_kontrol_bpjs_edit->execute([$no_sep, $tgl_surat, $no_surat, $tgl_rencana, $kd_dokter_bpjs, $nm_dokter_bpjs, $kd_poli_bpjs, $nm_poli_bpjs,$no_sep]);
        
        }

        if ($act=="del") {
            $no_sep= $_POST['no_sep'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM bridging_surat_kontrol_bpjs WHERE no_sep='$no_sep'");
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

            $search_field_bridging_surat_kontrol_bpjs= $_POST['search_field_bridging_surat_kontrol_bpjs'];
            $search_text_bridging_surat_kontrol_bpjs = $_POST['search_text_bridging_surat_kontrol_bpjs'];

            $searchQuery = " ";
            if($search_text_bridging_surat_kontrol_bpjs != ''){
                $searchQuery .= " and (".$search_field_bridging_surat_kontrol_bpjs." like '%".$search_text_bridging_surat_kontrol_bpjs."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from bridging_surat_kontrol_bpjs WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'no_sep'=>$row['no_sep'],
'tgl_surat'=>$row['tgl_surat'],
'no_surat'=>$row['no_surat'],
'tgl_rencana'=>$row['tgl_rencana'],
'kd_dokter_bpjs'=>$row['kd_dokter_bpjs'],
'nm_dokter_bpjs'=>$row['nm_dokter_bpjs'],
'kd_poli_bpjs'=>$row['kd_poli_bpjs'],
'nm_poli_bpjs'=>$row['nm_poli_bpjs']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($no_sep)
    {
        $detail = $this->db('bridging_surat_kontrol_bpjs')->where('no_sep', $no_sep)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/khanza_surat_kontrol_bpjs/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/khanza_surat_kontrol_bpjs/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'khanza_surat_kontrol_bpjs', 'css']));
        $this->core->addJS(url([ADMIN, 'khanza_surat_kontrol_bpjs', 'javascript']), 'footer');
    }

}
