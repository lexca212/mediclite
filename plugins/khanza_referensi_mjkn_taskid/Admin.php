<?php
namespace Plugins\khanza_referensi_mjkn_taskid;

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
        $search_field_referensi_mobilejkn_bpjs_taskid= $_POST['search_field_referensi_mobilejkn_bpjs_taskid'];
        $search_text_referensi_mobilejkn_bpjs_taskid = $_POST['search_text_referensi_mobilejkn_bpjs_taskid'];

        $searchQuery = " ";
        if($search_text_referensi_mobilejkn_bpjs_taskid != ''){
            $searchQuery .= " and (".$search_field_referensi_mobilejkn_bpjs_taskid." like '%".$search_text_referensi_mobilejkn_bpjs_taskid."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from referensi_mobilejkn_bpjs_taskid");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from referensi_mobilejkn_bpjs_taskid WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from referensi_mobilejkn_bpjs_taskid WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'no_rawat'=>$row['no_rawat'],
'taskid'=>$row['taskid'],
'waktu'=>$row['waktu']

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
$taskid = $_POST['taskid'];
$waktu = $_POST['waktu'];

            
            $referensi_mobilejkn_bpjs_taskid_add = $this->db()->pdo()->prepare('INSERT INTO referensi_mobilejkn_bpjs_taskid VALUES (?, ?, ?)');
            $referensi_mobilejkn_bpjs_taskid_add->execute([$no_rawat, $taskid, $waktu]);

        }
        if ($act=="edit") {

        $no_rawat = $_POST['no_rawat'];
$taskid = $_POST['taskid'];
$waktu = $_POST['waktu'];


        // BUANG FIELD PERTAMA

            $referensi_mobilejkn_bpjs_taskid_edit = $this->db()->pdo()->prepare("UPDATE referensi_mobilejkn_bpjs_taskid SET no_rawat=?, taskid=?, waktu=? WHERE no_rawat=?");
            $referensi_mobilejkn_bpjs_taskid_edit->execute([$no_rawat, $taskid, $waktu,$no_rawat]);
        
        }

        if ($act=="del") {
            $no_rawat= $_POST['no_rawat'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM referensi_mobilejkn_bpjs_taskid WHERE no_rawat='$no_rawat'");
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

            $search_field_referensi_mobilejkn_bpjs_taskid= $_POST['search_field_referensi_mobilejkn_bpjs_taskid'];
            $search_text_referensi_mobilejkn_bpjs_taskid = $_POST['search_text_referensi_mobilejkn_bpjs_taskid'];

            $searchQuery = " ";
            if($search_text_referensi_mobilejkn_bpjs_taskid != ''){
                $searchQuery .= " and (".$search_field_referensi_mobilejkn_bpjs_taskid." like '%".$search_text_referensi_mobilejkn_bpjs_taskid."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from referensi_mobilejkn_bpjs_taskid WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'no_rawat'=>$row['no_rawat'],
'taskid'=>$row['taskid'],
'waktu'=>$row['waktu']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($no_rawat)
    {
        $detail = $this->db('referensi_mobilejkn_bpjs_taskid')->where('no_rawat', $no_rawat)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/khanza_referensi_mjkn_taskid/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/khanza_referensi_mjkn_taskid/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'khanza_referensi_mjkn_taskid', 'css']));
        $this->core->addJS(url([ADMIN, 'khanza_referensi_mjkn_taskid', 'javascript']), 'footer');
    }

}
