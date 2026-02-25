<?php
namespace Plugins\BPJS_SEP;

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
        $search_field_bridging_sep= $_POST['search_field_bridging_sep'];
        $search_text_bridging_sep = $_POST['search_text_bridging_sep'];

        $searchQuery = " ";
        if($search_text_bridging_sep != ''){
            $searchQuery .= " and (".$search_field_bridging_sep." like '%".$search_text_bridging_sep."%' ) ";
        }

        ## Total number of records without filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from bridging_sep");
        $sel->execute();
        $records = $sel->fetch();
        $totalRecords = $records['allcount'];

        ## Total number of records with filtering
        $sel = $this->db()->pdo()->prepare("select count(*) as allcount from bridging_sep WHERE 1 ".$searchQuery);
        $sel->execute();
        $records = $sel->fetch();
        $totalRecordwithFilter = $records['allcount'];

        ## Fetch records
        $sel = $this->db()->pdo()->prepare("select * from bridging_sep WHERE 1 ".$searchQuery." order by ".$columnName." ".$columnSortOrder." limit ".$row1.",".$rowperpage);
        $sel->execute();
        $result = $sel->fetchAll(\PDO::FETCH_ASSOC);

        $data = array();
        foreach($result as $row) {
            $data[] = array(
                'no_sep'=>$row['no_sep'],
'no_rawat'=>$row['no_rawat'],
'tglsep'=>$row['tglsep'],
'tglrujukan'=>$row['tglrujukan'],
'no_rujukan'=>$row['no_rujukan'],
'kdppkrujukan'=>$row['kdppkrujukan'],
'nmppkrujukan'=>$row['nmppkrujukan'],
'kdppkpelayanan'=>$row['kdppkpelayanan'],
'nmppkpelayanan'=>$row['nmppkpelayanan'],
'jnspelayanan'=>$row['jnspelayanan'],
'catatan'=>$row['catatan'],
'diagawal'=>$row['diagawal'],
'nmdiagnosaawal'=>$row['nmdiagnosaawal'],
'kdpolitujuan'=>$row['kdpolitujuan'],
'nmpolitujuan'=>$row['nmpolitujuan'],
'klsrawat'=>$row['klsrawat'],
'klsnaik'=>$row['klsnaik'],
'pembiayaan'=>$row['pembiayaan'],
'pjnaikkelas'=>$row['pjnaikkelas'],
'lakalantas'=>$row['lakalantas'],
'user'=>$row['user'],
'nomr'=>$row['nomr'],
'nama_pasien'=>$row['nama_pasien'],
'tanggal_lahir'=>$row['tanggal_lahir'],
'peserta'=>$row['peserta'],
'jkel'=>$row['jkel'],
'no_kartu'=>$row['no_kartu'],
'tglpulang'=>$row['tglpulang'],
'asal_rujukan'=>$row['asal_rujukan'],
'eksekutif'=>$row['eksekutif'],
'cob'=>$row['cob'],
'notelep'=>$row['notelep'],
'katarak'=>$row['katarak'],
'tglkkl'=>$row['tglkkl'],
'keterangankkl'=>$row['keterangankkl'],
'suplesi'=>$row['suplesi'],
'no_sep_suplesi'=>$row['no_sep_suplesi'],
'kdprop'=>$row['kdprop'],
'nmprop'=>$row['nmprop'],
'kdkab'=>$row['kdkab'],
'nmkab'=>$row['nmkab'],
'kdkec'=>$row['kdkec'],
'nmkec'=>$row['nmkec'],
'noskdp'=>$row['noskdp'],
'kddpjp'=>$row['kddpjp'],
'nmdpdjp'=>$row['nmdpdjp'],
'tujuankunjungan'=>$row['tujuankunjungan'],
'flagprosedur'=>$row['flagprosedur'],
'penunjang'=>$row['penunjang'],
'asesmenpelayanan'=>$row['asesmenpelayanan'],
'kddpjplayanan'=>$row['kddpjplayanan'],
'nmdpjplayanan'=>$row['nmdpjplayanan']

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
$no_rawat = $_POST['no_rawat'];
$tglsep = $_POST['tglsep'];
$tglrujukan = $_POST['tglrujukan'];
$no_rujukan = $_POST['no_rujukan'];
$kdppkrujukan = $_POST['kdppkrujukan'];
$nmppkrujukan = $_POST['nmppkrujukan'];
$kdppkpelayanan = $_POST['kdppkpelayanan'];
$nmppkpelayanan = $_POST['nmppkpelayanan'];
$jnspelayanan = $_POST['jnspelayanan'];
$catatan = $_POST['catatan'];
$diagawal = $_POST['diagawal'];
$nmdiagnosaawal = $_POST['nmdiagnosaawal'];
$kdpolitujuan = $_POST['kdpolitujuan'];
$nmpolitujuan = $_POST['nmpolitujuan'];
$klsrawat = $_POST['klsrawat'];
$klsnaik = $_POST['klsnaik'];
$pembiayaan = $_POST['pembiayaan'];
$pjnaikkelas = $_POST['pjnaikkelas'];
$lakalantas = $_POST['lakalantas'];
$user = $_POST['user'];
$nomr = $_POST['nomr'];
$nama_pasien = $_POST['nama_pasien'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$peserta = $_POST['peserta'];
$jkel = $_POST['jkel'];
$no_kartu = $_POST['no_kartu'];
$tglpulang = $_POST['tglpulang'];
$asal_rujukan = $_POST['asal_rujukan'];
$eksekutif = $_POST['eksekutif'];
$cob = $_POST['cob'];
$notelep = $_POST['notelep'];
$katarak = $_POST['katarak'];
$tglkkl = $_POST['tglkkl'];
$keterangankkl = $_POST['keterangankkl'];
$suplesi = $_POST['suplesi'];
$no_sep_suplesi = $_POST['no_sep_suplesi'];
$kdprop = $_POST['kdprop'];
$nmprop = $_POST['nmprop'];
$kdkab = $_POST['kdkab'];
$nmkab = $_POST['nmkab'];
$kdkec = $_POST['kdkec'];
$nmkec = $_POST['nmkec'];
$noskdp = $_POST['noskdp'];
$kddpjp = $_POST['kddpjp'];
$nmdpdjp = $_POST['nmdpdjp'];
$tujuankunjungan = $_POST['tujuankunjungan'];
$flagprosedur = $_POST['flagprosedur'];
$penunjang = $_POST['penunjang'];
$asesmenpelayanan = $_POST['asesmenpelayanan'];
$kddpjplayanan = $_POST['kddpjplayanan'];
$nmdpjplayanan = $_POST['nmdpjplayanan'];

            
            $bridging_sep_add = $this->db()->pdo()->prepare('INSERT INTO bridging_sep VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $bridging_sep_add->execute([$no_sep, $no_rawat, $tglsep, $tglrujukan, $no_rujukan, $kdppkrujukan, $nmppkrujukan, $kdppkpelayanan, $nmppkpelayanan, $jnspelayanan, $catatan, $diagawal, $nmdiagnosaawal, $kdpolitujuan, $nmpolitujuan, $klsrawat, $klsnaik, $pembiayaan, $pjnaikkelas, $lakalantas, $user, $nomr, $nama_pasien, $tanggal_lahir, $peserta, $jkel, $no_kartu, $tglpulang, $asal_rujukan, $eksekutif, $cob, $notelep, $katarak, $tglkkl, $keterangankkl, $suplesi, $no_sep_suplesi, $kdprop, $nmprop, $kdkab, $nmkab, $kdkec, $nmkec, $noskdp, $kddpjp, $nmdpdjp, $tujuankunjungan, $flagprosedur, $penunjang, $asesmenpelayanan, $kddpjplayanan, $nmdpjplayanan]);

        }
        if ($act=="edit") {

        $no_sep = $_POST['no_sep'];
$no_rawat = $_POST['no_rawat'];
$tglsep = $_POST['tglsep'];
$tglrujukan = $_POST['tglrujukan'];
$no_rujukan = $_POST['no_rujukan'];
$kdppkrujukan = $_POST['kdppkrujukan'];
$nmppkrujukan = $_POST['nmppkrujukan'];
$kdppkpelayanan = $_POST['kdppkpelayanan'];
$nmppkpelayanan = $_POST['nmppkpelayanan'];
$jnspelayanan = $_POST['jnspelayanan'];
$catatan = $_POST['catatan'];
$diagawal = $_POST['diagawal'];
$nmdiagnosaawal = $_POST['nmdiagnosaawal'];
$kdpolitujuan = $_POST['kdpolitujuan'];
$nmpolitujuan = $_POST['nmpolitujuan'];
$klsrawat = $_POST['klsrawat'];
$klsnaik = $_POST['klsnaik'];
$pembiayaan = $_POST['pembiayaan'];
$pjnaikkelas = $_POST['pjnaikkelas'];
$lakalantas = $_POST['lakalantas'];
$user = $_POST['user'];
$nomr = $_POST['nomr'];
$nama_pasien = $_POST['nama_pasien'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$peserta = $_POST['peserta'];
$jkel = $_POST['jkel'];
$no_kartu = $_POST['no_kartu'];
$tglpulang = $_POST['tglpulang'];
$asal_rujukan = $_POST['asal_rujukan'];
$eksekutif = $_POST['eksekutif'];
$cob = $_POST['cob'];
$notelep = $_POST['notelep'];
$katarak = $_POST['katarak'];
$tglkkl = $_POST['tglkkl'];
$keterangankkl = $_POST['keterangankkl'];
$suplesi = $_POST['suplesi'];
$no_sep_suplesi = $_POST['no_sep_suplesi'];
$kdprop = $_POST['kdprop'];
$nmprop = $_POST['nmprop'];
$kdkab = $_POST['kdkab'];
$nmkab = $_POST['nmkab'];
$kdkec = $_POST['kdkec'];
$nmkec = $_POST['nmkec'];
$noskdp = $_POST['noskdp'];
$kddpjp = $_POST['kddpjp'];
$nmdpdjp = $_POST['nmdpdjp'];
$tujuankunjungan = $_POST['tujuankunjungan'];
$flagprosedur = $_POST['flagprosedur'];
$penunjang = $_POST['penunjang'];
$asesmenpelayanan = $_POST['asesmenpelayanan'];
$kddpjplayanan = $_POST['kddpjplayanan'];
$nmdpjplayanan = $_POST['nmdpjplayanan'];


        // BUANG FIELD PERTAMA

            $bridging_sep_edit = $this->db()->pdo()->prepare("UPDATE bridging_sep SET no_sep=?, no_rawat=?, tglsep=?, tglrujukan=?, no_rujukan=?, kdppkrujukan=?, nmppkrujukan=?, kdppkpelayanan=?, nmppkpelayanan=?, jnspelayanan=?, catatan=?, diagawal=?, nmdiagnosaawal=?, kdpolitujuan=?, nmpolitujuan=?, klsrawat=?, klsnaik=?, pembiayaan=?, pjnaikkelas=?, lakalantas=?, user=?, nomr=?, nama_pasien=?, tanggal_lahir=?, peserta=?, jkel=?, no_kartu=?, tglpulang=?, asal_rujukan=?, eksekutif=?, cob=?, notelep=?, katarak=?, tglkkl=?, keterangankkl=?, suplesi=?, no_sep_suplesi=?, kdprop=?, nmprop=?, kdkab=?, nmkab=?, kdkec=?, nmkec=?, noskdp=?, kddpjp=?, nmdpdjp=?, tujuankunjungan=?, flagprosedur=?, penunjang=?, asesmenpelayanan=?, kddpjplayanan=?, nmdpjplayanan=? WHERE no_sep=?");
            $bridging_sep_edit->execute([$no_sep, $no_rawat, $tglsep, $tglrujukan, $no_rujukan, $kdppkrujukan, $nmppkrujukan, $kdppkpelayanan, $nmppkpelayanan, $jnspelayanan, $catatan, $diagawal, $nmdiagnosaawal, $kdpolitujuan, $nmpolitujuan, $klsrawat, $klsnaik, $pembiayaan, $pjnaikkelas, $lakalantas, $user, $nomr, $nama_pasien, $tanggal_lahir, $peserta, $jkel, $no_kartu, $tglpulang, $asal_rujukan, $eksekutif, $cob, $notelep, $katarak, $tglkkl, $keterangankkl, $suplesi, $no_sep_suplesi, $kdprop, $nmprop, $kdkab, $nmkab, $kdkec, $nmkec, $noskdp, $kddpjp, $nmdpdjp, $tujuankunjungan, $flagprosedur, $penunjang, $asesmenpelayanan, $kddpjplayanan, $nmdpjplayanan,$no_sep]);
        
        }

        if ($act=="del") {
            $no_sep= $_POST['no_sep'];
            $check_db = $this->db()->pdo()->prepare("DELETE FROM bridging_sep WHERE no_sep='$no_sep'");
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

            $search_field_bridging_sep= $_POST['search_field_bridging_sep'];
            $search_text_bridging_sep = $_POST['search_text_bridging_sep'];

            $searchQuery = " ";
            if($search_text_bridging_sep != ''){
                $searchQuery .= " and (".$search_field_bridging_sep." like '%".$search_text_bridging_sep."%' ) ";
            }

            $user_lihat = $this->db()->pdo()->prepare("SELECT * from bridging_sep WHERE 1 ".$searchQuery);
            $user_lihat->execute();
            $result = $user_lihat->fetchAll(\PDO::FETCH_ASSOC);

            $data = array();

            foreach($result as $row) {
                $data[] = array(
                    'no_sep'=>$row['no_sep'],
'no_rawat'=>$row['no_rawat'],
'tglsep'=>$row['tglsep'],
'tglrujukan'=>$row['tglrujukan'],
'no_rujukan'=>$row['no_rujukan'],
'kdppkrujukan'=>$row['kdppkrujukan'],
'nmppkrujukan'=>$row['nmppkrujukan'],
'kdppkpelayanan'=>$row['kdppkpelayanan'],
'nmppkpelayanan'=>$row['nmppkpelayanan'],
'jnspelayanan'=>$row['jnspelayanan'],
'catatan'=>$row['catatan'],
'diagawal'=>$row['diagawal'],
'nmdiagnosaawal'=>$row['nmdiagnosaawal'],
'kdpolitujuan'=>$row['kdpolitujuan'],
'nmpolitujuan'=>$row['nmpolitujuan'],
'klsrawat'=>$row['klsrawat'],
'klsnaik'=>$row['klsnaik'],
'pembiayaan'=>$row['pembiayaan'],
'pjnaikkelas'=>$row['pjnaikkelas'],
'lakalantas'=>$row['lakalantas'],
'user'=>$row['user'],
'nomr'=>$row['nomr'],
'nama_pasien'=>$row['nama_pasien'],
'tanggal_lahir'=>$row['tanggal_lahir'],
'peserta'=>$row['peserta'],
'jkel'=>$row['jkel'],
'no_kartu'=>$row['no_kartu'],
'tglpulang'=>$row['tglpulang'],
'asal_rujukan'=>$row['asal_rujukan'],
'eksekutif'=>$row['eksekutif'],
'cob'=>$row['cob'],
'notelep'=>$row['notelep'],
'katarak'=>$row['katarak'],
'tglkkl'=>$row['tglkkl'],
'keterangankkl'=>$row['keterangankkl'],
'suplesi'=>$row['suplesi'],
'no_sep_suplesi'=>$row['no_sep_suplesi'],
'kdprop'=>$row['kdprop'],
'nmprop'=>$row['nmprop'],
'kdkab'=>$row['kdkab'],
'nmkab'=>$row['nmkab'],
'kdkec'=>$row['kdkec'],
'nmkec'=>$row['nmkec'],
'noskdp'=>$row['noskdp'],
'kddpjp'=>$row['kddpjp'],
'nmdpdjp'=>$row['nmdpdjp'],
'tujuankunjungan'=>$row['tujuankunjungan'],
'flagprosedur'=>$row['flagprosedur'],
'penunjang'=>$row['penunjang'],
'asesmenpelayanan'=>$row['asesmenpelayanan'],
'kddpjplayanan'=>$row['kddpjplayanan'],
'nmdpjplayanan'=>$row['nmdpjplayanan']
                );
            }

            echo json_encode($data);
        }
        exit();
    }

    public function getDetail($no_sep)
    {
        $detail = $this->db('bridging_sep')->where('no_sep', $no_sep)->toArray();
        echo $this->draw('detail.html', ['detail' => $detail]);
        exit();
    }

    public function getCss()
    {
        header('Content-type: text/css');
        echo $this->draw(MODULES.'/bpjs_sep/css/admin/styles.css');
        exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $settings = $this->settings('settings');
        echo $this->draw(MODULES.'/bpjs_sep/js/admin/scripts.js', ['settings' => $settings]);
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

        $this->core->addCSS(url([ADMIN, 'bpjs_sep', 'css']));
        $this->core->addJS(url([ADMIN, 'bpjs_sep', 'javascript']), 'footer');
    }

}
