<?php
namespace Plugins\khanza_referensi_mjkn_bpjs;

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
        $search_field_referensi_mobilejkn_bpjs= $_POST['search_field_referensi_mobilejkn_bpjs'];
        $search_text_referensi_mobilejkn_bpjs = $_POST['search_text_referensi_mobilejkn_bpjs'];

        $searchQuery = " ";
        if($search_text_referensi_mobilejkn_bpjs != ''){
            $searchQuery .= " and (".$search_field_referensi_mobilejkn_bpjs." like '%".$search_text_referensi_mobilejkn_bpjs."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from referensi_mobilejkn_bpjs");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from referensi_mobilejkn_bpjs WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from referensi_mobilejkn_bpjs WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'nobooking'=>$row['nobooking'],
'no_rawat'=>$row['no_rawat'],
'nomorkartu'=>$row['nomorkartu'],
'nik'=>$row['nik'],
'nohp'=>$row['nohp'],
'kodepoli'=>$row['kodepoli'],
'pasienbaru'=>$row['pasienbaru'],
'norm'=>$row['norm'],
'tanggalperiksa'=>$row['tanggalperiksa'],
'kodedokter'=>$row['kodedokter'],
'jampraktek'=>$row['jampraktek'],
'jeniskunjungan'=>$row['jeniskunjungan'],
'nomorreferensi'=>$row['nomorreferensi'],
'nomorantrean'=>$row['nomorantrean'],
'angkaantrean'=>$row['angkaantrean'],
'estimasidilayani'=>$row['estimasidilayani'],
'sisakuotajkn'=>$row['sisakuotajkn'],
'kuotajkn'=>$row['kuotajkn'],
'sisakuotanonjkn'=>$row['sisakuotanonjkn'],
'kuotanonjkn'=>$row['kuotanonjkn'],
'status'=>$row['status'],
'validasi'=>$row['validasi'],
'statuskirim'=>$row['statuskirim']

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

        $nobooking = $_POST['nobooking'];
$no_rawat = $_POST['no_rawat'];
$nomorkartu = $_POST['nomorkartu'];
$nik = $_POST['nik'];
$nohp = $_POST['nohp'];
$kodepoli = $_POST['kodepoli'];
$pasienbaru = $_POST['pasienbaru'];
$norm = $_POST['norm'];
$tanggalperiksa = $_POST['tanggalperiksa'];
$kodedokter = $_POST['kodedokter'];
$jampraktek = $_POST['jampraktek'];
$jeniskunjungan = $_POST['jeniskunjungan'];
$nomorreferensi = $_POST['nomorreferensi'];
$nomorantrean = $_POST['nomorantrean'];
$angkaantrean = $_POST['angkaantrean'];
$estimasidilayani = $_POST['estimasidilayani'];
$sisakuotajkn = $_POST['sisakuotajkn'];
$kuotajkn = $_POST['kuotajkn'];
$sisakuotanonjkn = $_POST['sisakuotanonjkn'];
$kuotanonjkn = $_POST['kuotanonjkn'];
$status = $_POST['status'];
$validasi = $_POST['validasi'];
$statuskirim = $_POST['statuskirim'];

            
            $referensi_mobilejkn_bpjs_add = $this->db()->pdo()->prepare('INSERT INTO referensi_mobilejkn_bpjs VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $referensi_mobilejkn_bpjs_add->execute([$nobooking, $no_rawat, $nomorkartu, $nik, $nohp, $kodepoli, $pasienbaru, $norm, $tanggalperiksa, $kodedokter, $jampraktek, $jeniskunjungan, $nomorreferensi, $nomorantrean, $angkaantrean, $estimasidilayani, $sisakuotajkn, $kuotajkn, $sisakuotanonjkn, $kuotanonjkn, $status, $validasi, $statuskirim]);

        }
        if ($act=="edit") {

        $nobooking = $_POST['nobooking'];
$no_rawat = $_POST['no_rawat'];
$nomorkartu = $_POST['nomorkartu'];
$nik = $_POST['nik'];
$nohp = $_POST['nohp'];
$kodepoli = $_POST['kodepoli'];
$pasienbaru = $_POST['pasienbaru'];
$norm = $_POST['norm'];
$tanggalperiksa = $_POST['tanggalperiksa'];
$kodedokter = $_POST['kodedokter'];
$jampraktek = $_POST['jampraktek'];
$jeniskunjungan = $_POST['jeniskunjungan'];
$nomorreferensi = $_POST['nomorreferensi'];
$nomorantrean = $_POST['nomorantrean'];
$angkaantrean = $_POST['angkaantrean'];
$estimasidilayani = $_POST['estimasidilayani'];
$sisakuotajkn = $_POST['sisakuotajkn'];
$kuotajkn = $_POST['kuotajkn'];
$sisakuotanonjkn = $_POST['sisakuotanonjkn'];
$kuotanonjkn = $_POST['kuotanonjkn'];
$status = $_POST['status'];
$validasi = $_POST['validasi'];
$statuskirim = $_POST['statuskirim'];


        // BUANG FIELD PERTAMA

            $referensi_mobilejkn_bpjs_edit = $this->db()->pdo()->prepare("UPDATE referensi_mobilejkn_bpjs SET nobooking=?, no_rawat=?, nomorkartu=?, nik=?, nohp=?, kodepoli=?, pasienbaru=?, norm=?, tanggalperiksa=?, kodedokter=?, jampraktek=?, jeniskunjungan=?, nomorreferensi=?, nomorantrean=?, angkaantrean=?, estimasidilayani=?, sisakuotajkn=?, kuotajkn=?, sisakuotanonjkn=?, kuotanonjkn=?, status=?, validasi=?, statuskirim=? WHERE nobooking=?");
            $referensi_mobilejkn_bpjs_edit->execute([$nobooking, $no_rawat, $nomorkartu, $nik, $nohp, $kodepoli, $pasienbaru, $norm, $tanggalperiksa, $kodedokter, $jampraktek, $jeniskunjungan, $nomorreferensi, $nomorantrean, $angkaantrean, $estimasidilayani, $sisakuotajkn, $kuotajkn, $sisakuotanonjkn, $kuotanonjkn, $status, $validasi, $statuskirim,$nobooking]);
        
        }

        if ($act=="del") {
            $nobooking= $_POST['nobooking'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM referensi_mobilejkn_bpjs WHERE nobooking='$nobooking'");
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

            $search_field_referensi_mobilejkn_bpjs= $_POST['search_field_referensi_mobilejkn_bpjs'];
            $search_text_referensi_mobilejkn_bpjs = $_POST['search_text_referensi_mobilejkn_bpjs'];

            $searchQuery = " ";
            if($search_text_referensi_mobilejkn_bpjs != ''){
                $searchQuery .= " and (".$search_field_referensi_mobilejkn_bpjs." like '%".$search_text_referensi_mobilejkn_bpjs."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from referensi_mobilejkn_bpjs WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'nobooking'=>$row['nobooking'],
'no_rawat'=>$row['no_rawat'],
'nomorkartu'=>$row['nomorkartu'],
'nik'=>$row['nik'],
'nohp'=>$row['nohp'],
'kodepoli'=>$row['kodepoli'],
'pasienbaru'=>$row['pasienbaru'],
'norm'=>$row['norm'],
'tanggalperiksa'=>$row['tanggalperiksa'],
'kodedokter'=>$row['kodedokter'],
'jampraktek'=>$row['jampraktek'],
'jeniskunjungan'=>$row['jeniskunjungan'],
'nomorreferensi'=>$row['nomorreferensi'],
'nomorantrean'=>$row['nomorantrean'],
'angkaantrean'=>$row['angkaantrean'],
'estimasidilayani'=>$row['estimasidilayani'],
'sisakuotajkn'=>$row['sisakuotajkn'],
'kuotajkn'=>$row['kuotajkn'],
'sisakuotanonjkn'=>$row['sisakuotanonjkn'],
'kuotanonjkn'=>$row['kuotanonjkn'],
'status'=>$row['status'],
'validasi'=>$row['validasi'],
'statuskirim'=>$row['statuskirim']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($nobooking)
    {
        $detail = $this->db('referensi_mobilejkn_bpjs')->where('nobooking', $nobooking)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/khanza_referensi_mjkn_bpjs/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/khanza_referensi_mjkn_bpjs/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'khanza_referensi_mjkn_bpjs', 'css']));
        $this->core->addJS(url([ADMIN, 'khanza_referensi_mjkn_bpjs', 'javascript']), 'footer');
    }

}
