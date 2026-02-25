<?php
namespace Plugins\mlite_penjualan_biling;

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
        $search_field_mlite_penjualan_billing= $_POST['search_field_mlite_penjualan_billing'];
        $search_text_mlite_penjualan_billing = $_POST['search_text_mlite_penjualan_billing'];

        $searchQuery = " ";
        if($search_text_mlite_penjualan_billing != ''){
            $searchQuery .= " and (".$search_field_mlite_penjualan_billing." like '%".$search_text_mlite_penjualan_billing."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from mlite_penjualan_billing");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from mlite_penjualan_billing WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from mlite_penjualan_billing WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'id'=>$row['id'],
'id_penjualan'=>$row['id_penjualan'],
'jumlah_total'=>$row['jumlah_total'],
'potongan'=>$row['potongan'],
'jumlah_harus_bayar'=>$row['jumlah_harus_bayar'],
'jumlah_bayar'=>$row['jumlah_bayar'],
'tanggal'=>$row['tanggal'],
'jam'=>$row['jam'],
'id_user'=>$row['id_user']

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

        $id = $_POST['id'];
$id_penjualan = $_POST['id_penjualan'];
$jumlah_total = $_POST['jumlah_total'];
$potongan = $_POST['potongan'];
$jumlah_harus_bayar = $_POST['jumlah_harus_bayar'];
$jumlah_bayar = $_POST['jumlah_bayar'];
$tanggal = $_POST['tanggal'];
$jam = $_POST['jam'];
$id_user = $_POST['id_user'];

            
            $mlite_penjualan_billing_add = $this->db()->pdo()->prepare('INSERT INTO mlite_penjualan_billing VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $mlite_penjualan_billing_add->execute([$id, $id_penjualan, $jumlah_total, $potongan, $jumlah_harus_bayar, $jumlah_bayar, $tanggal, $jam, $id_user]);

        }
        if ($act=="edit") {

        $id = $_POST['id'];
$id_penjualan = $_POST['id_penjualan'];
$jumlah_total = $_POST['jumlah_total'];
$potongan = $_POST['potongan'];
$jumlah_harus_bayar = $_POST['jumlah_harus_bayar'];
$jumlah_bayar = $_POST['jumlah_bayar'];
$tanggal = $_POST['tanggal'];
$jam = $_POST['jam'];
$id_user = $_POST['id_user'];


        // BUANG FIELD PERTAMA

            $mlite_penjualan_billing_edit = $this->db()->pdo()->prepare("UPDATE mlite_penjualan_billing SET id=?, id_penjualan=?, jumlah_total=?, potongan=?, jumlah_harus_bayar=?, jumlah_bayar=?, tanggal=?, jam=?, id_user=? WHERE id=?");
            $mlite_penjualan_billing_edit->execute([$id, $id_penjualan, $jumlah_total, $potongan, $jumlah_harus_bayar, $jumlah_bayar, $tanggal, $jam, $id_user,$id]);
        
        }

        if ($act=="del") {
            $id= $_POST['id'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM mlite_penjualan_billing WHERE id='$id'");
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

            $search_field_mlite_penjualan_billing= $_POST['search_field_mlite_penjualan_billing'];
            $search_text_mlite_penjualan_billing = $_POST['search_text_mlite_penjualan_billing'];

            $searchQuery = " ";
            if($search_text_mlite_penjualan_billing != ''){
                $searchQuery .= " and (".$search_field_mlite_penjualan_billing." like '%".$search_text_mlite_penjualan_billing."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from mlite_penjualan_billing WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'id'=>$row['id'],
'id_penjualan'=>$row['id_penjualan'],
'jumlah_total'=>$row['jumlah_total'],
'potongan'=>$row['potongan'],
'jumlah_harus_bayar'=>$row['jumlah_harus_bayar'],
'jumlah_bayar'=>$row['jumlah_bayar'],
'tanggal'=>$row['tanggal'],
'jam'=>$row['jam'],
'id_user'=>$row['id_user']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($id)
    {
        $detail = $this->db('mlite_penjualan_billing')->where('id', $id)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/mlite_penjualan_biling/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/mlite_penjualan_biling/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'mlite_penjualan_biling', 'css']));
        $this->core->addJS(url([ADMIN, 'mlite_penjualan_biling', 'javascript']), 'footer');
    }

}
