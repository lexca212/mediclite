<?php
namespace Plugins\Jurnal_;

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
        $search_field_detailjurnal= $_POST['search_field_detailjurnal'];
        $search_text_detailjurnal = $_POST['search_text_detailjurnal'];

        $searchQuery = " ";
        if($search_text_detailjurnal != ''){
            $searchQuery .= " and (".$search_field_detailjurnal." like '%".$search_text_detailjurnal."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from detailjurnal");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from detailjurnal WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from detailjurnal WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'no_jurnal'=>$row['no_jurnal'],
'kd_rek'=>$row['kd_rek'],
'debet'=>$row['debet'],
'kredit'=>$row['kredit']

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

        $no_jurnal = $_POST['no_jurnal'];
$kd_rek = $_POST['kd_rek'];
$debet = $_POST['debet'];
$kredit = $_POST['kredit'];

            
            $detailjurnal_add = $this->db()->pdo()->prepare('INSERT INTO detailjurnal VALUES (?, ?, ?, ?)');
            $detailjurnal_add->execute([$no_jurnal, $kd_rek, $debet, $kredit]);

        }
        if ($act=="edit") {

        $no_jurnal = $_POST['no_jurnal'];
$kd_rek = $_POST['kd_rek'];
$debet = $_POST['debet'];
$kredit = $_POST['kredit'];


        // BUANG FIELD PERTAMA

            $detailjurnal_edit = $this->db()->pdo()->prepare("UPDATE detailjurnal SET no_jurnal=?, kd_rek=?, debet=?, kredit=? WHERE no_jurnal=?");
            $detailjurnal_edit->execute([$no_jurnal, $kd_rek, $debet, $kredit,$no_jurnal]);
        
        }

        if ($act=="del") {
            $no_jurnal= $_POST['no_jurnal'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM detailjurnal WHERE no_jurnal='$no_jurnal'");
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

            $search_field_detailjurnal= $_POST['search_field_detailjurnal'];
            $search_text_detailjurnal = $_POST['search_text_detailjurnal'];

            $searchQuery = " ";
            if($search_text_detailjurnal != ''){
                $searchQuery .= " and (".$search_field_detailjurnal." like '%".$search_text_detailjurnal."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from detailjurnal WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'no_jurnal'=>$row['no_jurnal'],
'kd_rek'=>$row['kd_rek'],
'debet'=>$row['debet'],
'kredit'=>$row['kredit']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($no_jurnal)
    {
        $detail = $this->db('detailjurnal')->where('no_jurnal', $no_jurnal)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/jurnal_/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/jurnal_/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'jurnal_', 'css']));
        $this->core->addJS(url([ADMIN, 'jurnal_', 'javascript']), 'footer');
    }

}
