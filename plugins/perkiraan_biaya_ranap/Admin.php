<?php
namespace Plugins\perkiraan_biaya_ranap;

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
        $search_field_perkiraan_biaya_ranap= $_POST['search_field_perkiraan_biaya_ranap'];
        $search_text_perkiraan_biaya_ranap = $_POST['search_text_perkiraan_biaya_ranap'];

        $searchQuery = " ";
        if($search_text_perkiraan_biaya_ranap != ''){
            $searchQuery .= " and (".$search_field_perkiraan_biaya_ranap." like '%".$search_text_perkiraan_biaya_ranap."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from perkiraan_biaya_ranap");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from perkiraan_biaya_ranap WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from perkiraan_biaya_ranap WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'no_rawat'=>$row['no_rawat'],
'kd_penyakit'=>$row['kd_penyakit'],
'tarif'=>$row['tarif']

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
$kd_penyakit = $_POST['kd_penyakit'];
$tarif = $_POST['tarif'];

            
            $perkiraan_biaya_ranap_add = $this->db()->pdo()->prepare('INSERT INTO perkiraan_biaya_ranap VALUES (?, ?, ?)');
            $perkiraan_biaya_ranap_add->execute([$no_rawat, $kd_penyakit, $tarif]);

        }
        if ($act=="edit") {

        $no_rawat = $_POST['no_rawat'];
$kd_penyakit = $_POST['kd_penyakit'];
$tarif = $_POST['tarif'];


        // BUANG FIELD PERTAMA

            $perkiraan_biaya_ranap_edit = $this->db()->pdo()->prepare("UPDATE perkiraan_biaya_ranap SET no_rawat=?, kd_penyakit=?, tarif=? WHERE no_rawat=?");
            $perkiraan_biaya_ranap_edit->execute([$no_rawat, $kd_penyakit, $tarif,$no_rawat]);
        
        }

        if ($act=="del") {
            $no_rawat= $_POST['no_rawat'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM perkiraan_biaya_ranap WHERE no_rawat='$no_rawat'");
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

            $search_field_perkiraan_biaya_ranap= $_POST['search_field_perkiraan_biaya_ranap'];
            $search_text_perkiraan_biaya_ranap = $_POST['search_text_perkiraan_biaya_ranap'];

            $searchQuery = " ";
            if($search_text_perkiraan_biaya_ranap != ''){
                $searchQuery .= " and (".$search_field_perkiraan_biaya_ranap." like '%".$search_text_perkiraan_biaya_ranap."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from perkiraan_biaya_ranap WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'no_rawat'=>$row['no_rawat'],
'kd_penyakit'=>$row['kd_penyakit'],
'tarif'=>$row['tarif']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($no_rawat)
    {
        $detail = $this->db('perkiraan_biaya_ranap')->where('no_rawat', $no_rawat)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/perkiraan_biaya_ranap/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/perkiraan_biaya_ranap/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'perkiraan_biaya_ranap', 'css']));
        $this->core->addJS(url([ADMIN, 'perkiraan_biaya_ranap', 'javascript']), 'footer');
    }

}
