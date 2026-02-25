<?php
namespace Plugins\Penjualan_bebas;

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
        $search_field_penjualan= $_POST['search_field_penjualan'];
        $search_text_penjualan = $_POST['search_text_penjualan'];

        $searchQuery = " ";
        if($search_text_penjualan != ''){
            $searchQuery .= " and (".$search_field_penjualan." like '%".$search_text_penjualan."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from penjualan");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from penjualan WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from penjualan WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'nota_jual'=>$row['nota_jual'],
'tgl_jual'=>$row['tgl_jual'],
'nip'=>$row['nip'],
'no_rkm_medis'=>$row['no_rkm_medis'],
'nm_pasien'=>$row['nm_pasien'],
'keterangan'=>$row['keterangan'],
'jns_jual'=>$row['jns_jual'],
'ongkir'=>$row['ongkir'],
'ppn'=>$row['ppn'],
'status'=>$row['status'],
'kd_bangsal'=>$row['kd_bangsal'],
'kd_rek'=>$row['kd_rek'],
'nama_bayar'=>$row['nama_bayar']

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

        $nota_jual = $_POST['nota_jual'];
$tgl_jual = $_POST['tgl_jual'];
$nip = $_POST['nip'];
$no_rkm_medis = $_POST['no_rkm_medis'];
$nm_pasien = $_POST['nm_pasien'];
$keterangan = $_POST['keterangan'];
$jns_jual = $_POST['jns_jual'];
$ongkir = $_POST['ongkir'];
$ppn = $_POST['ppn'];
$status = $_POST['status'];
$kd_bangsal = $_POST['kd_bangsal'];
$kd_rek = $_POST['kd_rek'];
$nama_bayar = $_POST['nama_bayar'];

            
            $penjualan_add = $this->db()->pdo()->prepare('INSERT INTO penjualan VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $penjualan_add->execute([$nota_jual, $tgl_jual, $nip, $no_rkm_medis, $nm_pasien, $keterangan, $jns_jual, $ongkir, $ppn, $status, $kd_bangsal, $kd_rek, $nama_bayar]);

        }
        if ($act=="edit") {

        $nota_jual = $_POST['nota_jual'];
$tgl_jual = $_POST['tgl_jual'];
$nip = $_POST['nip'];
$no_rkm_medis = $_POST['no_rkm_medis'];
$nm_pasien = $_POST['nm_pasien'];
$keterangan = $_POST['keterangan'];
$jns_jual = $_POST['jns_jual'];
$ongkir = $_POST['ongkir'];
$ppn = $_POST['ppn'];
$status = $_POST['status'];
$kd_bangsal = $_POST['kd_bangsal'];
$kd_rek = $_POST['kd_rek'];
$nama_bayar = $_POST['nama_bayar'];


        // BUANG FIELD PERTAMA

            $penjualan_edit = $this->db()->pdo()->prepare("UPDATE penjualan SET nota_jual=?, tgl_jual=?, nip=?, no_rkm_medis=?, nm_pasien=?, keterangan=?, jns_jual=?, ongkir=?, ppn=?, status=?, kd_bangsal=?, kd_rek=?, nama_bayar=? WHERE nota_jual=?");
            $penjualan_edit->execute([$nota_jual, $tgl_jual, $nip, $no_rkm_medis, $nm_pasien, $keterangan, $jns_jual, $ongkir, $ppn, $status, $kd_bangsal, $kd_rek, $nama_bayar,$nota_jual]);
        
        }

        if ($act=="del") {
            $nota_jual= $_POST['nota_jual'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM penjualan WHERE nota_jual='$nota_jual'");
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

            $search_field_penjualan= $_POST['search_field_penjualan'];
            $search_text_penjualan = $_POST['search_text_penjualan'];

            $searchQuery = " ";
            if($search_text_penjualan != ''){
                $searchQuery .= " and (".$search_field_penjualan." like '%".$search_text_penjualan."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from penjualan WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'nota_jual'=>$row['nota_jual'],
'tgl_jual'=>$row['tgl_jual'],
'nip'=>$row['nip'],
'no_rkm_medis'=>$row['no_rkm_medis'],
'nm_pasien'=>$row['nm_pasien'],
'keterangan'=>$row['keterangan'],
'jns_jual'=>$row['jns_jual'],
'ongkir'=>$row['ongkir'],
'ppn'=>$row['ppn'],
'status'=>$row['status'],
'kd_bangsal'=>$row['kd_bangsal'],
'kd_rek'=>$row['kd_rek'],
'nama_bayar'=>$row['nama_bayar']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($nota_jual)
    {
        $detail = $this->db('penjualan')->where('nota_jual', $nota_jual)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/penjualan_bebas/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/penjualan_bebas/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'penjualan_bebas', 'css']));
        $this->core->addJS(url([ADMIN, 'penjualan_bebas', 'javascript']), 'footer');
    }

}
