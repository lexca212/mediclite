<?php
namespace Plugins\plafon;

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
        $search_field_plafon= $_POST['search_field_plafon'];
        $search_text_plafon = $_POST['search_text_plafon'];

        $searchQuery = " ";
        if($search_text_plafon != ''){
            $searchQuery .= " and (".$search_field_plafon." like '%".$search_text_plafon."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from plafon");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from plafon WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from plafon WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'no_sep'=>$row['no_sep'],
'code_cbg'=>$row['code_cbg'],
'deskripsi'=>$row['deskripsi'],
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

        $no_sep = $_POST['no_sep'];
$code_cbg = $_POST['code_cbg'];
$deskripsi = $_POST['deskripsi'];
$tarif = $_POST['tarif'];

            
            $plafon_add = $this->db()->pdo()->prepare('INSERT INTO plafon VALUES (?, ?, ?, ?)');
            $plafon_add->execute([$no_sep, $code_cbg, $deskripsi, $tarif]);

        }
        if ($act=="edit") {

        $no_sep = $_POST['no_sep'];
$code_cbg = $_POST['code_cbg'];
$deskripsi = $_POST['deskripsi'];
$tarif = $_POST['tarif'];


        // BUANG FIELD PERTAMA

            $plafon_edit = $this->db()->pdo()->prepare("UPDATE plafon SET no_sep=?, code_cbg=?, deskripsi=?, tarif=? WHERE no_sep=?");
            $plafon_edit->execute([$no_sep, $code_cbg, $deskripsi, $tarif,$no_sep]);
        
        }

        if ($act=="del") {
            $no_sep= $_POST['no_sep'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM plafon WHERE no_sep='$no_sep'");
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

            $search_field_plafon= $_POST['search_field_plafon'];
            $search_text_plafon = $_POST['search_text_plafon'];

            $searchQuery = " ";
            if($search_text_plafon != ''){
                $searchQuery .= " and (".$search_field_plafon." like '%".$search_text_plafon."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from plafon WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'no_sep'=>$row['no_sep'],
'code_cbg'=>$row['code_cbg'],
'deskripsi'=>$row['deskripsi'],
'tarif'=>$row['tarif']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($no_sep)
    {
        $detail = $this->db('plafon')->where('no_sep', $no_sep)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/plafon/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/plafon/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'plafon', 'css']));
        $this->core->addJS(url([ADMIN, 'plafon', 'javascript']), 'footer');
    }

}
