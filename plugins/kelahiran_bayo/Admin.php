<?php
namespace Plugins\kelahiran_bayo;

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
        $search_field_pasien_bayi= $_POST['search_field_pasien_bayi'];
        $search_text_pasien_bayi = $_POST['search_text_pasien_bayi'];

        $searchQuery = " ";
        if($search_text_pasien_bayi != ''){
            $searchQuery .= " and (".$search_field_pasien_bayi." like '%".$search_text_pasien_bayi."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from pasien_bayi");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from pasien_bayi WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from pasien_bayi WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'no_rkm_medis'=>$row['no_rkm_medis'],
'umur_ibu'=>$row['umur_ibu'],
'nama_ayah'=>$row['nama_ayah'],
'umur_ayah'=>$row['umur_ayah'],
'berat_badan'=>$row['berat_badan'],
'panjang_badan'=>$row['panjang_badan'],
'lingkar_kepala'=>$row['lingkar_kepala'],
'proses_lahir'=>$row['proses_lahir'],
'anakke'=>$row['anakke'],
'jam_lahir'=>$row['jam_lahir'],
'keterangan'=>$row['keterangan'],
'diagnosa'=>$row['diagnosa'],
'penyulit_kehamilan'=>$row['penyulit_kehamilan'],
'ketuban'=>$row['ketuban'],
'lingkar_perut'=>$row['lingkar_perut'],
'lingkar_dada'=>$row['lingkar_dada'],
'penolong'=>$row['penolong'],
'no_skl'=>$row['no_skl'],
'g'=>$row['g'],
'p'=>$row['p'],
'a'=>$row['a'],
'f1'=>$row['f1'],
'u1'=>$row['u1'],
't1'=>$row['t1'],
'r1'=>$row['r1'],
'w1'=>$row['w1'],
'n1'=>$row['n1'],
'f5'=>$row['f5'],
'u5'=>$row['u5'],
't5'=>$row['t5'],
'r5'=>$row['r5'],
'w5'=>$row['w5'],
'n5'=>$row['n5'],
'f10'=>$row['f10'],
'u10'=>$row['u10'],
't10'=>$row['t10'],
'r10'=>$row['r10'],
'w10'=>$row['w10'],
'n10'=>$row['n10'],
'resusitas'=>$row['resusitas'],
'obat_diberikan'=>$row['obat_diberikan'],
'mikasi'=>$row['mikasi'],
'mikonium'=>$row['mikonium']

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

        $no_rkm_medis = $_POST['no_rkm_medis'];
$umur_ibu = $_POST['umur_ibu'];
$nama_ayah = $_POST['nama_ayah'];
$umur_ayah = $_POST['umur_ayah'];
$berat_badan = $_POST['berat_badan'];
$panjang_badan = $_POST['panjang_badan'];
$lingkar_kepala = $_POST['lingkar_kepala'];
$proses_lahir = $_POST['proses_lahir'];
$anakke = $_POST['anakke'];
$jam_lahir = $_POST['jam_lahir'];
$keterangan = $_POST['keterangan'];
$diagnosa = $_POST['diagnosa'];
$penyulit_kehamilan = $_POST['penyulit_kehamilan'];
$ketuban = $_POST['ketuban'];
$lingkar_perut = $_POST['lingkar_perut'];
$lingkar_dada = $_POST['lingkar_dada'];
$penolong = $_POST['penolong'];
$no_skl = $_POST['no_skl'];
$g = $_POST['g'];
$p = $_POST['p'];
$a = $_POST['a'];
$f1 = $_POST['f1'];
$u1 = $_POST['u1'];
$t1 = $_POST['t1'];
$r1 = $_POST['r1'];
$w1 = $_POST['w1'];
$n1 = $_POST['n1'];
$f5 = $_POST['f5'];
$u5 = $_POST['u5'];
$t5 = $_POST['t5'];
$r5 = $_POST['r5'];
$w5 = $_POST['w5'];
$n5 = $_POST['n5'];
$f10 = $_POST['f10'];
$u10 = $_POST['u10'];
$t10 = $_POST['t10'];
$r10 = $_POST['r10'];
$w10 = $_POST['w10'];
$n10 = $_POST['n10'];
$resusitas = $_POST['resusitas'];
$obat_diberikan = $_POST['obat_diberikan'];
$mikasi = $_POST['mikasi'];
$mikonium = $_POST['mikonium'];

            
            $pasien_bayi_add = $this->db()->pdo()->prepare('INSERT INTO pasien_bayi VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $pasien_bayi_add->execute([$no_rkm_medis, $umur_ibu, $nama_ayah, $umur_ayah, $berat_badan, $panjang_badan, $lingkar_kepala, $proses_lahir, $anakke, $jam_lahir, $keterangan, $diagnosa, $penyulit_kehamilan, $ketuban, $lingkar_perut, $lingkar_dada, $penolong, $no_skl, $g, $p, $a, $f1, $u1, $t1, $r1, $w1, $n1, $f5, $u5, $t5, $r5, $w5, $n5, $f10, $u10, $t10, $r10, $w10, $n10, $resusitas, $obat_diberikan, $mikasi, $mikonium]);

        }
        if ($act=="edit") {

        $no_rkm_medis = $_POST['no_rkm_medis'];
$umur_ibu = $_POST['umur_ibu'];
$nama_ayah = $_POST['nama_ayah'];
$umur_ayah = $_POST['umur_ayah'];
$berat_badan = $_POST['berat_badan'];
$panjang_badan = $_POST['panjang_badan'];
$lingkar_kepala = $_POST['lingkar_kepala'];
$proses_lahir = $_POST['proses_lahir'];
$anakke = $_POST['anakke'];
$jam_lahir = $_POST['jam_lahir'];
$keterangan = $_POST['keterangan'];
$diagnosa = $_POST['diagnosa'];
$penyulit_kehamilan = $_POST['penyulit_kehamilan'];
$ketuban = $_POST['ketuban'];
$lingkar_perut = $_POST['lingkar_perut'];
$lingkar_dada = $_POST['lingkar_dada'];
$penolong = $_POST['penolong'];
$no_skl = $_POST['no_skl'];
$g = $_POST['g'];
$p = $_POST['p'];
$a = $_POST['a'];
$f1 = $_POST['f1'];
$u1 = $_POST['u1'];
$t1 = $_POST['t1'];
$r1 = $_POST['r1'];
$w1 = $_POST['w1'];
$n1 = $_POST['n1'];
$f5 = $_POST['f5'];
$u5 = $_POST['u5'];
$t5 = $_POST['t5'];
$r5 = $_POST['r5'];
$w5 = $_POST['w5'];
$n5 = $_POST['n5'];
$f10 = $_POST['f10'];
$u10 = $_POST['u10'];
$t10 = $_POST['t10'];
$r10 = $_POST['r10'];
$w10 = $_POST['w10'];
$n10 = $_POST['n10'];
$resusitas = $_POST['resusitas'];
$obat_diberikan = $_POST['obat_diberikan'];
$mikasi = $_POST['mikasi'];
$mikonium = $_POST['mikonium'];


        // BUANG FIELD PERTAMA

            $pasien_bayi_edit = $this->db()->pdo()->prepare("UPDATE pasien_bayi SET no_rkm_medis=?, umur_ibu=?, nama_ayah=?, umur_ayah=?, berat_badan=?, panjang_badan=?, lingkar_kepala=?, proses_lahir=?, anakke=?, jam_lahir=?, keterangan=?, diagnosa=?, penyulit_kehamilan=?, ketuban=?, lingkar_perut=?, lingkar_dada=?, penolong=?, no_skl=?, g=?, p=?, a=?, f1=?, u1=?, t1=?, r1=?, w1=?, n1=?, f5=?, u5=?, t5=?, r5=?, w5=?, n5=?, f10=?, u10=?, t10=?, r10=?, w10=?, n10=?, resusitas=?, obat_diberikan=?, mikasi=?, mikonium=? WHERE no_rkm_medis=?");
            $pasien_bayi_edit->execute([$no_rkm_medis, $umur_ibu, $nama_ayah, $umur_ayah, $berat_badan, $panjang_badan, $lingkar_kepala, $proses_lahir, $anakke, $jam_lahir, $keterangan, $diagnosa, $penyulit_kehamilan, $ketuban, $lingkar_perut, $lingkar_dada, $penolong, $no_skl, $g, $p, $a, $f1, $u1, $t1, $r1, $w1, $n1, $f5, $u5, $t5, $r5, $w5, $n5, $f10, $u10, $t10, $r10, $w10, $n10, $resusitas, $obat_diberikan, $mikasi, $mikonium,$no_rkm_medis]);
        
        }

        if ($act=="del") {
            $no_rkm_medis= $_POST['no_rkm_medis'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM pasien_bayi WHERE no_rkm_medis='$no_rkm_medis'");
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

            $search_field_pasien_bayi= $_POST['search_field_pasien_bayi'];
            $search_text_pasien_bayi = $_POST['search_text_pasien_bayi'];

            $searchQuery = " ";
            if($search_text_pasien_bayi != ''){
                $searchQuery .= " and (".$search_field_pasien_bayi." like '%".$search_text_pasien_bayi."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from pasien_bayi WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'no_rkm_medis'=>$row['no_rkm_medis'],
'umur_ibu'=>$row['umur_ibu'],
'nama_ayah'=>$row['nama_ayah'],
'umur_ayah'=>$row['umur_ayah'],
'berat_badan'=>$row['berat_badan'],
'panjang_badan'=>$row['panjang_badan'],
'lingkar_kepala'=>$row['lingkar_kepala'],
'proses_lahir'=>$row['proses_lahir'],
'anakke'=>$row['anakke'],
'jam_lahir'=>$row['jam_lahir'],
'keterangan'=>$row['keterangan'],
'diagnosa'=>$row['diagnosa'],
'penyulit_kehamilan'=>$row['penyulit_kehamilan'],
'ketuban'=>$row['ketuban'],
'lingkar_perut'=>$row['lingkar_perut'],
'lingkar_dada'=>$row['lingkar_dada'],
'penolong'=>$row['penolong'],
'no_skl'=>$row['no_skl'],
'g'=>$row['g'],
'p'=>$row['p'],
'a'=>$row['a'],
'f1'=>$row['f1'],
'u1'=>$row['u1'],
't1'=>$row['t1'],
'r1'=>$row['r1'],
'w1'=>$row['w1'],
'n1'=>$row['n1'],
'f5'=>$row['f5'],
'u5'=>$row['u5'],
't5'=>$row['t5'],
'r5'=>$row['r5'],
'w5'=>$row['w5'],
'n5'=>$row['n5'],
'f10'=>$row['f10'],
'u10'=>$row['u10'],
't10'=>$row['t10'],
'r10'=>$row['r10'],
'w10'=>$row['w10'],
'n10'=>$row['n10'],
'resusitas'=>$row['resusitas'],
'obat_diberikan'=>$row['obat_diberikan'],
'mikasi'=>$row['mikasi'],
'mikonium'=>$row['mikonium']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($no_rkm_medis)
    {
        $detail = $this->db('pasien_bayi')->where('no_rkm_medis', $no_rkm_medis)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/kelahiran_bayo/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/kelahiran_bayo/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'kelahiran_bayo', 'css']));
        $this->core->addJS(url([ADMIN, 'kelahiran_bayo', 'javascript']), 'footer');
    }

}
