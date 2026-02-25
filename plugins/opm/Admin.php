<?php
namespace Plugins\opm;

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
        $search_field_opname= $_POST['search_field_opname'];
        $search_text_opname = $_POST['search_text_opname'];

        $searchQuery = " ";
        if($search_text_opname != ''){
            $searchQuery .= " and (".$search_field_opname." like '%".$search_text_opname."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from opname");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from opname WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from opname WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'kode_brng'=>$row['kode_brng'],
'h_beli'=>$row['h_beli'],
'tanggal'=>$row['tanggal'],
'stok'=>$row['stok'],
'real'=>$row['real'],
'selisih'=>$row['selisih'],
'nomihilang'=>$row['nomihilang'],
'lebih'=>$row['lebih'],
'nomilebih'=>$row['nomilebih'],
'keterangan'=>$row['keterangan'],
'kd_bangsal'=>$row['kd_bangsal'],
'no_batch'=>$row['no_batch'],
'no_faktur'=>$row['no_faktur']

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

        $kode_brng = $_POST['kode_brng'];
$h_beli = $_POST['h_beli'];
$tanggal = $_POST['tanggal'];
$stok = $_POST['stok'];
$real = $_POST['real'];
$selisih = $_POST['selisih'];
$nomihilang = $_POST['nomihilang'];
$lebih = $_POST['lebih'];
$nomilebih = $_POST['nomilebih'];
$keterangan = $_POST['keterangan'];
$kd_bangsal = $_POST['kd_bangsal'];
$no_batch = $_POST['no_batch'];
$no_faktur = $_POST['no_faktur'];

            
            $opname_add = $this->db()->pdo()->prepare('INSERT INTO opname VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $opname_add->execute([$kode_brng, $h_beli, $tanggal, $stok, $real, $selisih, $nomihilang, $lebih, $nomilebih, $keterangan, $kd_bangsal, $no_batch, $no_faktur]);

        }
        if ($act=="edit") {

        $kode_brng = $_POST['kode_brng'];
$h_beli = $_POST['h_beli'];
$tanggal = $_POST['tanggal'];
$stok = $_POST['stok'];
$real = $_POST['real'];
$selisih = $_POST['selisih'];
$nomihilang = $_POST['nomihilang'];
$lebih = $_POST['lebih'];
$nomilebih = $_POST['nomilebih'];
$keterangan = $_POST['keterangan'];
$kd_bangsal = $_POST['kd_bangsal'];
$no_batch = $_POST['no_batch'];
$no_faktur = $_POST['no_faktur'];


        // BUANG FIELD PERTAMA

            $opname_edit = $this->db()->pdo()->prepare("UPDATE opname SET kode_brng=?, h_beli=?, tanggal=?, stok=?, real=?, selisih=?, nomihilang=?, lebih=?, nomilebih=?, keterangan=?, kd_bangsal=?, no_batch=?, no_faktur=? WHERE kode_brng=?");
            $opname_edit->execute([$kode_brng, $h_beli, $tanggal, $stok, $real, $selisih, $nomihilang, $lebih, $nomilebih, $keterangan, $kd_bangsal, $no_batch, $no_faktur,$kode_brng]);
        
        }

        if ($act=="del") {
            $kode_brng= $_POST['kode_brng'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM opname WHERE kode_brng='$kode_brng'");
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

            $search_field_opname= $_POST['search_field_opname'];
            $search_text_opname = $_POST['search_text_opname'];

            $searchQuery = " ";
            if($search_text_opname != ''){
                $searchQuery .= " and (".$search_field_opname." like '%".$search_text_opname."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from opname WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'kode_brng'=>$row['kode_brng'],
'h_beli'=>$row['h_beli'],
'tanggal'=>$row['tanggal'],
'stok'=>$row['stok'],
'real'=>$row['real'],
'selisih'=>$row['selisih'],
'nomihilang'=>$row['nomihilang'],
'lebih'=>$row['lebih'],
'nomilebih'=>$row['nomilebih'],
'keterangan'=>$row['keterangan'],
'kd_bangsal'=>$row['kd_bangsal'],
'no_batch'=>$row['no_batch'],
'no_faktur'=>$row['no_faktur']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($kode_brng)
    {
        $detail = $this->db('opname')->where('kode_brng', $kode_brng)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/opm/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/opm/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'opm', 'css']));
        $this->core->addJS(url([ADMIN, 'opm', 'javascript']), 'footer');
    }

}
