<?php
namespace Plugins\mlite_penjualan;

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
        $search_field_mlite_penjualan= $_POST['search_field_mlite_penjualan'];
        $search_text_mlite_penjualan = $_POST['search_text_mlite_penjualan'];

        $searchQuery = " ";
        if($search_text_mlite_penjualan != ''){
            $searchQuery .= " and (".$search_field_mlite_penjualan." like '%".$search_text_mlite_penjualan."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from mlite_penjualan");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from mlite_penjualan WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from mlite_penjualan WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'id'=>$row['id'],
'nama_pembeli'=>$row['nama_pembeli'],
'alamat_pembeli'=>$row['alamat_pembeli'],
'nomor_telepon'=>$row['nomor_telepon'],
'email'=>$row['email'],
'tanggal'=>$row['tanggal'],
'jam'=>$row['jam'],
'id_user'=>$row['id_user'],
'keterangan'=>$row['keterangan']

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
$nama_pembeli = $_POST['nama_pembeli'];
$alamat_pembeli = $_POST['alamat_pembeli'];
$nomor_telepon = $_POST['nomor_telepon'];
$email = $_POST['email'];
$tanggal = $_POST['tanggal'];
$jam = $_POST['jam'];
$id_user = $_POST['id_user'];
$keterangan = $_POST['keterangan'];

            
            $mlite_penjualan_add = $this->db()->pdo()->prepare('INSERT INTO mlite_penjualan VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $mlite_penjualan_add->execute([$id, $nama_pembeli, $alamat_pembeli, $nomor_telepon, $email, $tanggal, $jam, $id_user, $keterangan]);

        }
        if ($act=="edit") {

        $id = $_POST['id'];
$nama_pembeli = $_POST['nama_pembeli'];
$alamat_pembeli = $_POST['alamat_pembeli'];
$nomor_telepon = $_POST['nomor_telepon'];
$email = $_POST['email'];
$tanggal = $_POST['tanggal'];
$jam = $_POST['jam'];
$id_user = $_POST['id_user'];
$keterangan = $_POST['keterangan'];


        // BUANG FIELD PERTAMA

            $mlite_penjualan_edit = $this->db()->pdo()->prepare("UPDATE mlite_penjualan SET id=?, nama_pembeli=?, alamat_pembeli=?, nomor_telepon=?, email=?, tanggal=?, jam=?, id_user=?, keterangan=? WHERE id=?");
            $mlite_penjualan_edit->execute([$id, $nama_pembeli, $alamat_pembeli, $nomor_telepon, $email, $tanggal, $jam, $id_user, $keterangan,$id]);
        
        }

        if ($act=="del") {
            $id= $_POST['id'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM mlite_penjualan WHERE id='$id'");
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

            $search_field_mlite_penjualan= $_POST['search_field_mlite_penjualan'];
            $search_text_mlite_penjualan = $_POST['search_text_mlite_penjualan'];

            $searchQuery = " ";
            if($search_text_mlite_penjualan != ''){
                $searchQuery .= " and (".$search_field_mlite_penjualan." like '%".$search_text_mlite_penjualan."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from mlite_penjualan WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'id'=>$row['id'],
'nama_pembeli'=>$row['nama_pembeli'],
'alamat_pembeli'=>$row['alamat_pembeli'],
'nomor_telepon'=>$row['nomor_telepon'],
'email'=>$row['email'],
'tanggal'=>$row['tanggal'],
'jam'=>$row['jam'],
'id_user'=>$row['id_user'],
'keterangan'=>$row['keterangan']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($id)
    {
        $detail = $this->db('mlite_penjualan')->where('id', $id)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/mlite_penjualan/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/mlite_penjualan/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'mlite_penjualan', 'css']));
        $this->core->addJS(url([ADMIN, 'mlite_penjualan', 'javascript']), 'footer');
    }

}
