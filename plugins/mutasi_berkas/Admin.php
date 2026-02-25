<?php
namespace Plugins\Mutasi_berkas;

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
        $search_field_mutasi_berkas= $_POST['search_field_mutasi_berkas'];
        $search_text_mutasi_berkas = $_POST['search_text_mutasi_berkas'];

        $searchQuery = " ";
        if($search_text_mutasi_berkas != ''){
            $searchQuery .= " and (".$search_field_mutasi_berkas." like '%".$search_text_mutasi_berkas."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from mutasi_berkas");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from mutasi_berkas WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from mutasi_berkas WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'no_rawat'=>$row['no_rawat'],
'status'=>$row['status'],
'dikirim'=>$row['dikirim'],
'diterima'=>$row['diterima'],
'kembali'=>$row['kembali'],
'tidakada'=>$row['tidakada'],
'ranap'=>$row['ranap']

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
$status = $_POST['status'];
$dikirim = $_POST['dikirim'];
$diterima = $_POST['diterima'];
$kembali = $_POST['kembali'];
$tidakada = $_POST['tidakada'];
$ranap = $_POST['ranap'];

            
            $mutasi_berkas_add = $this->db()->pdo()->prepare('INSERT INTO mutasi_berkas VALUES (?, ?, ?, ?, ?, ?, ?)');
            $mutasi_berkas_add->execute([$no_rawat, $status, $dikirim, $diterima, $kembali, $tidakada, $ranap]);

        }
        if ($act=="edit") {

        $no_rawat = $_POST['no_rawat'];
$status = $_POST['status'];
$dikirim = $_POST['dikirim'];
$diterima = $_POST['diterima'];
$kembali = $_POST['kembali'];
$tidakada = $_POST['tidakada'];
$ranap = $_POST['ranap'];


        // BUANG FIELD PERTAMA

            $mutasi_berkas_edit = $this->db()->pdo()->prepare("UPDATE mutasi_berkas SET no_rawat=?, status=?, dikirim=?, diterima=?, kembali=?, tidakada=?, ranap=? WHERE no_rawat=?");
            $mutasi_berkas_edit->execute([$no_rawat, $status, $dikirim, $diterima, $kembali, $tidakada, $ranap,$no_rawat]);
        
        }

        if ($act=="del") {
            $no_rawat= $_POST['no_rawat'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM mutasi_berkas WHERE no_rawat='$no_rawat'");
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

            $search_field_mutasi_berkas= $_POST['search_field_mutasi_berkas'];
            $search_text_mutasi_berkas = $_POST['search_text_mutasi_berkas'];

            $searchQuery = " ";
            if($search_text_mutasi_berkas != ''){
                $searchQuery .= " and (".$search_field_mutasi_berkas." like '%".$search_text_mutasi_berkas."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from mutasi_berkas WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'no_rawat'=>$row['no_rawat'],
'status'=>$row['status'],
'dikirim'=>$row['dikirim'],
'diterima'=>$row['diterima'],
'kembali'=>$row['kembali'],
'tidakada'=>$row['tidakada'],
'ranap'=>$row['ranap']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($no_rawat)
    {
        $detail = $this->db('mutasi_berkas')->where('no_rawat', $no_rawat)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/mutasi_berkas/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/mutasi_berkas/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'mutasi_berkas', 'css']));
        $this->core->addJS(url([ADMIN, 'mutasi_berkas', 'javascript']), 'footer');
    }

}
