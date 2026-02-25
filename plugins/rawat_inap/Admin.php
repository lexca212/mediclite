<?php
namespace Plugins\Rawat_Inap;

use Systems\AdminModule;
use Plugins\Icd\DB_ICD;
use Systems\Lib\BpjsService;

class Admin extends AdminModule
{
    public function init()
    {
      $this->consid = $this->settings->get('settings.BpjsConsID');
      $this->secretkey = $this->settings->get('settings.BpjsSecretKey');
      $this->user_key = $this->settings->get('settings.BpjsUserKey');
      $this->api_url = $this->settings->get('settings.BpjsApiUrl');
    }

    // =========================== START FITUR PLAFON ===========================

    public function postKirimInacbgs()
    {
        $no_rawat = $_POST['no_rawat'];
        $reg_periksa = $this->db('reg_periksa')
          ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
          ->join('poliklinik', 'poliklinik.kd_poli=reg_periksa.kd_poli')
          ->join('dokter', 'dokter.kd_dokter=reg_periksa.kd_dokter')
          ->join('penjab', 'penjab.kd_pj=reg_periksa.kd_pj')
          ->where('no_rawat', $no_rawat)
          ->oneArray();
        //Tensi
        if($reg_periksa['status_lanjut'] == 'Ranap') {
          $pemeriksaan = $this->db('pemeriksaan_ranap')->where('no_rawat', $reg_periksa['no_rawat'])->limit(1)->desc('tgl_perawatan')->desc('jam_rawat')->toArray();
          $reg_periksa['sistole'] = strtok($pemeriksaan[0]['tensi'], '/');
          $reg_periksa['diastole'] = substr($pemeriksaan[0]['tensi'], strpos($pemeriksaan[0]['tensi'], '/') + 1);
        }else{
            if($reg_periksa['kd_poli'] == 'IGDK'){
            $pemeriksaan = $this->db('data_triase_igd')
              ->where('no_rawat', $reg_periksa['no_rawat'])
              ->limit(1)
              ->desc('tgl_kunjungan')
              ->toArray();
            $reg_periksa['sistole'] = strtok($pemeriksaan[0]['tekanan_darah'], '/');
            $reg_periksa['diastole'] = substr($pemeriksaan[0]['tekanan_darah'], strpos($pemeriksaan[0]['tekanan_darah'], '/') + 1);
          }else{
            $pemeriksaan = $this->db('pemeriksaan_ralan')
              ->where('no_rawat', $reg_periksa['no_rawat'])
              ->limit(1)->desc('tgl_perawatan')
              ->desc('jam_rawat')->toArray();
            $reg_periksa['sistole'] = strtok($pemeriksaan[0]['tensi'], '/');
            $reg_periksa['diastole'] = substr($pemeriksaan[0]['tensi'], strpos($pemeriksaan[0]['tensi'], '/') + 1);
          } 
        }
        $reg_periksa['no_sep'] = $this->_getSEPInfo('no_sep', $no_rawat);
        $reg_periksa['klsrawat'] = $this->_getSEPInfo('klsrawat', $no_rawat);
        $reg_periksa['no_kartu'] = $this->_getSEPInfo('no_kartu', $no_rawat);

        //cara masuk
        $reg_periksa['asal_rujukan'] = $this->_getSEPInfo('asal_rujukan', $no_rawat);
        $reg_periksa['tujuankunjungan'] = $this->_getSEPInfo('tujuankunjungan', $no_rawat);
        $reg_periksa['flagprosedur'] = $this->_getSEPInfo('flagprosedur', $no_rawat);
        $reg_periksa['penunjang'] = $this->_getSEPInfo('penunjang', $no_rawat);
        $reg_periksa['asesmenpelayanan'] = $this->_getSEPInfo('asesmenpelayanan', $no_rawat);
        $reg_periksa['jnspelayanan'] = $this->_getSEPInfo('jnspelayanan', $no_rawat);
        $reg_periksa['kdpolitujuan'] = $this->_getSEPInfo('kdpolitujuan', $no_rawat);

        $reg_periksa['stts_pulang'] = '';
        $reg_periksa['tgl_keluar'] = $reg_periksa['tgl_registrasi'];
        if($reg_periksa['status_lanjut'] == 'Ranap') { 
          $_get_kamar_inap = $this->db('kamar_inap')->where('no_rawat', $no_rawat)->limit(1)->desc('tgl_keluar')->toArray();
          $reg_periksa['tgl_keluar'] = $reg_periksa['tgl_registrasi'].' 23:59:59';
          $reg_periksa['stts_pulang'] = $_get_kamar_inap[0]['stts_pulang'];
          $get_kamar = $this->db('kamar')->where('kd_kamar', $_get_kamar_inap[0]['kd_kamar'])->oneArray();
          $get_bangsal = $this->db('bangsal')->where('kd_bangsal', $get_kamar['kd_bangsal'])->oneArray();
          $reg_periksa['nm_poli'] = $get_bangsal['nm_bangsal'].'/'.$get_kamar['kd_kamar'];
          $reg_periksa['nm_dokter'] = $this->db('dpjp_ranap')
            ->join('dokter', 'dokter.kd_dokter=dpjp_ranap.kd_dokter')
            ->where('no_rawat', $no_rawat)
            ->toArray();
        }

        $row_diagnosa = $this->db('diagnosa_pasien')
          ->where('no_rawat', $no_rawat)
          ->asc('prioritas')
          ->toArray();
        $a_diagnosa=1;
        foreach ($row_diagnosa as $row) {
          if($a_diagnosa==1){
              $penyakit=$row["kd_penyakit"];
          }else{
              $penyakit=$penyakit."#".$row["kd_penyakit"];
          }
          $a_diagnosa++;
        }

        $row_prosedur = $this->db('prosedur_pasien')
          ->where('no_rawat', $no_rawat)
          ->asc('prioritas')
          ->toArray();
        $prosedur= '';
        $a_prosedur=1;
        foreach ($row_prosedur as $row) {
          $kode = $row["kode"];
          if(strpos($row["kode"],'.') == false) {
            $kode = substr_replace($row["kode"],".", 2, 0);
          }
          if($a_prosedur==1){
              $prosedur=$kode;
          }else{
              $prosedur=$prosedur."#".$kode;
          }
          $a_prosedur++;
        }

      $no_rkm_medis      = $reg_periksa['no_rkm_medis'];

      $reg_periksa['ventilator_hour'] = '0';
      $reg_periksa['jk'] = $this->core->getPasienInfo('jk', $no_rkm_medis);
      $reg_periksa['tgl_lahir'] = $this->core->getPasienInfo('tgl_lahir', $no_rkm_medis);

      $norawat           = $reg_periksa['no_rawat'];
      $tgl_registrasi    = $reg_periksa['tgl_registrasi'];
      $nosep             = $reg_periksa['no_sep'];
      $nokartu           = $reg_periksa['no_kartu'];
      $nm_pasien         = $reg_periksa['nm_pasien'];
      $keluar            = $reg_periksa['tgl_keluar'];
      $kelas_rawat       = $reg_periksa['klsrawat'];
      $adl_sub_acute     = '';
      $adl_chronic       = '';
      $icu_indikator     = '0';
      $icu_los           = '0';
      $ventilator_hour   = $reg_periksa['ventilator_hour'];
      $upgrade_class_ind = '0';
      $upgrade_class_class = '';
      $upgrade_class_los = '0';
      $add_payment_pct   = '0';
      $birth_weight      = '0';
      $sistole           = $reg_periksa['sistole'];
      $diastole           = $reg_periksa['diastole'];
      $discharge_status  = '1';
      $cara_masuk        = 'emd';
      $diagnosa          = $penyakit;
      $procedure         = $prosedur;
      $prosedur_non_bedah = '0';
      $prosedur_bedah    = '0';
      $konsultasi        = '0';
      $tenaga_ahli       = '0';
      $keperawatan       = '0';
      $penunjang         = '0';
      $radiologi         = '0';
      $laboratorium      = '0';
      $pelayanan_darah   = '0';
      $rehabilitasi      = '0';
      $kamar             = '0';
      $rawat_intensif    = '0';
      $obat              = '0';
      $obat_kronis       = '0';
      $obat_kemoterapi   = '0';
      $alkes             = '0';
      $bmhp              = '0';
      $sewa_alat         = '0';
      $tarif_poli_eks    = '0';
      $nama_dokter       = $reg_periksa['nm_dokter'];
      $jk                = $reg_periksa['jk'];
      $tgl_lahir         = $reg_periksa['tgl_lahir'];
      $appearance_1      = '0';
      $pulse_1           = '0';
      $grimace_1         = '0';
      $activity_1        = '0';
      $respiration_1     = '0';
      $appearance_5      = '0';
      $pulse_5           = '0';
      $grimace_5         = '0';
      $activity_5        = '0';
      $respiration_5     = '0';
      $usia_kehamilan    = '0';
      $onset_kontraksi   = 'spontan';
      $delivery_dttm     = '';
      $delivery_method   = 'vaginal';
      $use_manual        = '0';
      $use_forcep        = '0';
      $use_vacuum        = '0';
      $letak_janin       = 'kepala';
      $kondisi           = 'livebirth';
      $gravida           = '0';
      $partus            = '0';
      $abortus           = '0';

      $jnsrawat="2";
      if($this->getRegPeriksaInfo('status_lanjut', $_POST['no_rawat']) == "Ranap"){
          $jnsrawat="1";
      }

      $gender = "";
      if($jk=="L"){
          $gender="1";
      }else{
          $gender="2";
      }

      $nik = $this->core->getPegawaiInfo('no_ktp', $this->core->getUserInfo('username', $_SESSION['mlite_user']));
      $coder_nik = $nik;
      
      $this->BuatKlaimBaru2($nokartu,$nosep,$no_rkm_medis,$nm_pasien,$tgl_lahir." 00:00:00", $gender,$norawat);
      $this->EditUlangKlaim($nosep);
      $this->UpdateDataKlaim2($nosep,$nokartu,$tgl_registrasi,$keluar,$jnsrawat,$kelas_rawat,$adl_sub_acute,
          $adl_chronic,$icu_indikator,$icu_los,$ventilator_hour,$upgrade_class_ind,$upgrade_class_class,
          $upgrade_class_los,$add_payment_pct,$birth_weight,$sistole,$diastole,$discharge_status,$cara_masuk,$diagnosa,$procedure,
          $tarif_poli_eks,$nama_dokter,$this->settings->get('vedika.eklaim_kelasrs'),$this->settings->get('vedika.eklaim_payor_id'),$this->settings->get('vedika.eklaim_payor_cd'),$this->settings->get('vedika.eklaim_cob_cd'),$coder_nik,
          $prosedur_non_bedah,$prosedur_bedah,$konsultasi,$tenaga_ahli,$keperawatan,$penunjang,
          $radiologi,$laboratorium,$pelayanan_darah,$rehabilitasi,$kamar,$rawat_intensif,$obat,
          $obat_kronis,$obat_kemoterapi,$alkes,$bmhp,$sewa_alat,$appearance_1,$pulse_1,$grimace_1,$activity_1,$respiration_1,
          $appearance_5,$pulse_5,$grimace_5,$activity_5,$respiration_5,
          $usia_kehamilan,$onset_kontraksi,$delivery_dttm,$delivery_method,$use_manual,$use_forcep,$use_vacuum,$letak_janin,$kondisi,
          $gravida,$partus,$abortus);

      exit();
    }

    private function BuatKlaimBaru2($nomor_kartu,$nomor_sep,$nomor_rm,$nama_pasien,$tgl_lahir,$gender,$norawat){
        $request ='{
                        "metadata":{
                            "method":"new_claim"
                        },
                        "data":{
                            "nomor_kartu":"'.$nomor_kartu.'",
                            "nomor_sep":"'.$nomor_sep.'",
                            "nomor_rm":"'.$nomor_rm.'",
                            "nama_pasien":"'.$nama_pasien.'",
                            "tgl_lahir":"'.$tgl_lahir.'",
                            "gender":"'.$gender.'"
                        }
                    }';
        $msg= $this->Request($request);
        if($msg['metadata']['message']=="Ok"){
            //InsertData2("inacbg_klaim_baru2","'".$norawat."','".$nomor_sep."','".$msg['response']['patient_id']."','".$msg['response']['admission_id']."','".$msg['response']['hospital_admission_id']."'");
        }
        return $msg['metadata']['message'];
    }

    private function EditUlangKlaim($nomor_sep){
        $request ='{
                        "metadata": {
                            "method":"reedit_claim"
                        },
                        "data": {
                            "nomor_sep":"'.$nomor_sep.'"
                        }
                  }';
        $msg= $this->Request($request);
        //echo $msg['metadata']['message']."";
    }

    private function UpdateDataKlaim2($nomor_sep,$nomor_kartu,$tgl_masuk,$tgl_pulang,$jenis_rawat,$kelas_rawat,$adl_sub_acute,
        $adl_chronic,$icu_indikator,$icu_los,$ventilator_hour,$upgrade_class_ind,$upgrade_class_class,
        $upgrade_class_los,$add_payment_pct,$birth_weight,$sistole,$diastole,$discharge_status,$cara_masuk,$diagnosa,$procedure,
        $tarif_poli_eks,$nama_dokter,$kode_tarif,$payor_id,$payor_cd,$cob_cd,$coder_nik,
        $prosedur_non_bedah,$prosedur_bedah,$konsultasi,$tenaga_ahli,$keperawatan,$penunjang,
        $radiologi,$laboratorium,$pelayanan_darah,$rehabilitasi,$kamar,$rawat_intensif,$obat,
        $obat_kronis,$obat_kemoterapi,$alkes,$bmhp,$sewa_alat,$appearance_1,$pulse_1,$grimace_1,$activity_1,$respiration_1,
        $appearance_5,$pulse_5,$grimace_5,$activity_5,$respiration_5,
        $usia_kehamilan,$onset_kontraksi,$delivery_dttm,$delivery_method,$use_manual,$use_forcep,$use_vacuum,$letak_janin,$kondisi,
        $gravida,$partus,$abortus ){
      $request ='{
      "metadata": {
        "method": "set_claim_data",
        "nomor_sep": "'.$nomor_sep.'"
      },
      "data": {
        "nomor_sep": "'.$nomor_sep.'",
        "nomor_kartu": "'.$nomor_kartu.'",
        "tgl_masuk": "'.$tgl_masuk.' 00:00:01",
        "tgl_pulang": "'.$tgl_pulang.' 23:59:59",
        "cara_masuk": "'.$cara_masuk.'",
        "jenis_rawat": "'.$jenis_rawat.'",
        "kelas_rawat": "'.$kelas_rawat.'",
        "adl_sub_acute": "'.$adl_sub_acute.'",
        "adl_chronic": "'.$adl_chronic.'",
        "icu_indikator": "'.$icu_indikator.'",
        "icu_los": "'.$icu_los.'",
        "ventilator_hour": "'.$ventilator_hour.'",
        "upgrade_class_ind": "'.$upgrade_class_ind.'",
        "upgrade_class_class": "'.$upgrade_class_class.'",
        "upgrade_class_los": "'.$upgrade_class_los.'",
        "add_payment_pct": "'.$add_payment_pct.'",
        "birth_weight": "'.$birth_weight.'",
        "sistole": '.intval($sistole).',
        "diastole": '.intval($diastole).',
        "discharge_status": "'.$discharge_status.'",
        "diagnosa": "'.$diagnosa.'",
        "procedure": "'.$procedure.'",
        "diagnosa_inagrouper": "'.$diagnosa.'",
        "procedure_inagrouper": "'.$procedure.'",
        "tarif_rs": {
            "prosedur_non_bedah": "'.$prosedur_non_bedah.'",
            "prosedur_bedah": "'.$prosedur_bedah.'",
            "konsultasi": "'.$konsultasi.'",
            "tenaga_ahli": "'.$tenaga_ahli.'",
            "keperawatan": "'.$keperawatan.'",
            "penunjang": "'.$penunjang.'",
            "radiologi": "'.$radiologi.'",
            "laboratorium": "'.$laboratorium.'",
            "pelayanan_darah": "'.$pelayanan_darah.'",
            "rehabilitasi": "'.$rehabilitasi.'",
            "kamar": "'.$kamar.'",
            "rawat_intensif": "'.$rawat_intensif.'",
            "obat": "'.$obat.'",
            "obat_kronis": "'.$obat_kronis.'",
            "obat_kemoterapi": "'.$obat_kemoterapi.'",
            "alkes": "'.$alkes.'",
            "bmhp": "'.$bmhp.'",
            "sewa_alat": "'.$sewa_alat.'"
        },
        "apgar": {
          "menit_1": {
              "appearance": '.intval($appearance_1).',
              "pulse": '.intval($pulse_1).',
              "grimace": '.intval($grimace_1).',
              "activity": '.intval($activity_1).',
              "respiration": '.intval($respiration_1).'
          },
          "menit_5": {
              "appearance": '.intval($appearance_5).',
              "pulse": '.intval($pulse_5).',
              "grimace": '.intval($grimace_5).',
              "activity": '.intval($activity_5).',
              "respiration": '.intval($respiration_5).'
          }
        },
        "persalinan": {
          "usia_kehamilan": "'.$usia_kehamilan.'",
          "gravida": '.intval($gravida).',
          "partus": '.intval($partus).',
          "abortus": '.intval($abortus).',
          "onset_kontraksi": "'.$onset_kontraksi.'",
          "delivery": [
              {
                "shk_spesimen_ambil" : "tidak",
                  "shk_alasan" : "tidak-dapat",
                "delivery_sequence": "1",
                "delivery_method": "'.$delivery_method.'",
                "delivery_dttm": "'.$delivery_dttm.'",
                "letak_janin": "'.$letak_janin.'",
                "kondisi": "'.$kondisi.'",
                "use_manual": "'.$use_manual.'",
                "use_forcep": "'.$use_forcep.'",
                "use_vacuum": "'.$use_vacuum.'"
              }
            ]
        },
        "tarif_poli_eks": "'.$tarif_poli_eks.'",
        "nama_dokter": "'.$nama_dokter.'",
        "kode_tarif": "'.$kode_tarif.'",
        "payor_id": "'.$payor_id.'",
        "payor_cd": "'.$payor_cd.'",
        "cob_cd": "'.$cob_cd.'",
        "coder_nik": "'.$coder_nik.'"
      }
      }';
      echo "Data : ".$request;
      $msg= $this->Request($request);
      if($msg['metadata']['message']=="Ok"){
      //echo 'Sukses';
      //Hapus2("inacbg_data_terkirim2", "no_sep='".$nomor_sep."'");
      //InsertData2("inacbg_data_terkirim2","'".$nomor_sep."','".$coder_nik."'");
      $this->GroupingStage12($nomor_sep,$coder_nik);
      } else {
        echo 'Update Data Klaim';
        echo json_encode($msg);
      }
    }

    private function GroupingStage12($nomor_sep,$coder_nik){
        $bridging_sep = $this->db('bridging_sep')->where('no_sep', $nomor_sep)->oneArray();
        $request ='{
                        "metadata": {
                            "method":"grouper",
                            "stage":"1"
                        },
                        "data": {
                            "nomor_sep":"'.$nomor_sep.'"
                        }
                  }';
        $msg= $this->Request($request);

        $get_claim_data1 = $msg;

        $code = $get_claim_data1['response']['cbg']['code'];
        $deskripsi = $get_claim_data1['response']['cbg']['description'];
        $tarif = $get_claim_data1['response']['cbg']['tariff'];

        $cek = $this->db('plafon')->where('no_sep', $nomor_sep)->oneArray();
        if ($cek) {
          echo 'Ada Cek';
        } else {
          echo 'Tidak Ada Cek';
        }

        $bridging_sep = $this->db('bridging_sep')->where('no_sep', $nomor_sep)->oneArray();
        if ($bridging_sep) {
          echo 'Ada bridging_sep';
        } else {
          echo 'Tidak Ada bridging_sep';
        }

        if($cek){
          $save_plafon = $this->db('plafon')->where('no_sep', $nomor_sep)->update(['no_sep' => $nomor_sep, 'code_cbg' => $code, 'deskripsi' => $deskripsi, 'tarif' => $tarif]);
        	if($save_plafon){
            	echo 'Berhasil Simpan !';
            }
        } else {
          $save_plafon = $this->db('plafon')->save(['no_sep' => $nomor_sep, 'code_cbg' => $code, 'deskripsi' => $deskripsi, 'tarif' => $tarif]);
        	if($save_plafon){
            	echo 'Berhasil Simpan Data Plafon Wooooyy !';
              	echo $nomor_sep;
              	echo $code;
              	echo $deskripsi;
              	echo $tarif;
            } else {
            	echo 'Tidak Berhasil Simpan Oyyyy !';
              	echo $nomor_sep;
              	echo $code;
              	echo $deskripsi;
              	echo $tarif;
            }
        }

        echo 'Grouping Stage';
        echo json_encode($msg);
        if($msg['metadata']['message']=="Ok"){
            //$this->FinalisasiKlaim($nomor_sep,$coder_nik);
            //$this->HapusKlaim($nomor_sep,$coder_nik);
        }
    }

    private function HapusKlaim($nomor_sep,$coder_nik){
      $request ='{
                      "metadata": {
                          "method":"delete_claim"
                      },
                      "data": {
                          "nomor_sep":"'.$nomor_sep.'",
                          "coder_nik": "'.$coder_nik.'"
                      }
                }';
      $msg= $this->Request($request);
      echo json_encode($msg);
      if($msg['metadata']['message']=="Ok"){
          //KirimKlaimIndividualKeDC($nomor_sep);
      }
  }

    private function Request($request){
        $json = $this->mc_encrypt($request, $this->settings->get('vedika.eklaim_key'));
        $header = array("Content-Type: application/x-www-form-urlencoded");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $this->settings->get('vedika.eklaim_url'));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $response = curl_exec($ch);
        $first = strpos($response, "\n")+1;
        $last = strrpos($response, "\n")-1;
        $hasilresponse = substr($response,$first,strlen($response) - $first - $last);
        $hasildecrypt = $this->mc_decrypt($hasilresponse, $this->settings->get('vedika.eklaim_key'));
        //echo $hasildecrypt;
        $msg = json_decode($hasildecrypt,true);
        return $msg;
    }

    private function mc_encrypt($data, $strkey) {
        $key = hex2bin($strkey);
        if (mb_strlen($key, "8bit") !== 32) {
                throw new Exception("Needs a 256-bit key!");
        }

        $iv_size = openssl_cipher_iv_length("aes-256-cbc");
        $iv = openssl_random_pseudo_bytes($iv_size);
        $encrypted = openssl_encrypt($data,"aes-256-cbc",$key,OPENSSL_RAW_DATA,$iv );
        $signature = mb_substr(hash_hmac("sha256",$encrypted,$key,true),0,10,"8bit");
        $encoded = chunk_split(base64_encode($signature.$iv.$encrypted));
        return $encoded;
    }

    private function mc_decrypt($str, $strkey){
        $key = hex2bin($strkey);
        if (mb_strlen($key, "8bit") !== 32) {
            throw new Exception("Needs a 256-bit key!");
        }

        $iv_size = openssl_cipher_iv_length("aes-256-cbc");
        $decoded = base64_decode($str);
        $signature = mb_substr($decoded,0,10,"8bit");
        $iv = mb_substr($decoded,10,$iv_size,"8bit");
        $encrypted = mb_substr($decoded,$iv_size+10,NULL,"8bit");
        $calc_signature = mb_substr(hash_hmac("sha256",$encrypted,$key,true),0,10,"8bit");
        if(!$this->mc_compare($signature,$calc_signature)) {
            return "SIGNATURE_NOT_MATCH";
        }

        $decrypted = openssl_decrypt($encrypted,"aes-256-cbc",$key,OPENSSL_RAW_DATA,$iv);
        return $decrypted;
    }

    private function mc_compare($a, $b) {
        if (strlen($a) !== strlen($b)) {
            return false;
        }

        $result = 0;

        for($i = 0; $i < strlen($a); $i ++) {
            $result |= ord($a[$i]) ^ ord($b[$i]);
        }

        return $result == 0;
    }

    private function validTeks($data){
      $save=str_replace("'","",$data);
      $save=str_replace("\\","",$save);
      $save=str_replace(";","",$save);
      $save=str_replace("`","",$save);
      $save=str_replace("--","",$save);
      $save=str_replace("/*","",$save);
      $save=str_replace("*/","",$save);
      //$save=str_replace("#","",$save);
      return $save;
    }

    public function convertNorawat($text)
    {
        setlocale(LC_ALL, 'en_EN');
        $text = str_replace('/', '', trim($text));
        return $text;
    }

    public function revertNorawat($text)
    {
      setlocale(LC_ALL, 'en_EN');
      $tahun = substr($text, 0, 4);
      $bulan = substr($text, 4, 2);
      $tanggal = substr($text, 6, 2);
      $nomor = substr($text, 8, 6);
      $result = $tahun . '/' . $bulan . '/' . $tanggal . '/' . $nomor;
      return $result;
    }

    private function _getSEPInfo($field, $no_rawat)
    {
      $cek = $this->db('reg_periksa')->where('no_rawat', $no_rawat)->oneArray();
      if ($cek['status_lanjut'] == 'Ranap') {
        $row = $this->db('bridging_sep')->where('no_rawat', $no_rawat)->where('jnspelayanan','1')->oneArray();
      }
      else {
        $cek_sep = $this->db('bridging_sep')->where('no_rawat', $no_rawat)->where('jnspelayanan','2')->count();
        if ($cek_sep == 0) {
          $row = $this->db('bridging_sep')->where('no_rawat', $no_rawat)->where('jnspelayanan','1')->oneArray();
        }
        else {
          $row = $this->db('bridging_sep')->where('no_rawat', $no_rawat)->where('jnspelayanan','2')->oneArray();
        }
      }

      if(!$row) {
        $row[$field] = '';
      }
      return $row[$field];
    }

    public function getRegPeriksaInfo($field, $no_rawat)
    {
      $row = $this->db('reg_periksa')->where('no_rawat', $no_rawat)->oneArray();
      return $row[$field];
    }

    public function getPasienInfo($field, $no_rkm_medis)
    {
      $row = $this->db('pasien')->where('no_rkm_medis', $no_rkm_medis)->oneArray();
      if(!$row) {
        $row[$field] = '';
      }
      return $row[$field];
    }

    public function getSepDetail($no_sep){
      $sep = $this->db('bridging_sep')->where('no_sep', $no_sep)->oneArray();
      $this->tpl->set('sep', $this->tpl->noParse_array(htmlspecialchars_array($sep)));

      $potensi_prb = $this->db('bpjs_prb')->where('no_sep', $no_sep)->oneArray();
      $data_sep['potensi_prb'] = $potensi_prb['prb'];
      echo $this->draw('sep.detail.html', ['data_sep' => $data_sep]);
      exit();
    }

    // =========================== END FITUR PLAFON ===========================

    private $_uploads = WEBAPPS_PATH.'/berkasrawat/pages/upload';
    public function navigation()
    {
        return [
            'Kelola'   => 'manage',
        ];
    }

    public function anyManage()
    {
        $tgl_masuk = '';
        $tgl_masuk_akhir = '';
        $status_pulang = '';
        $this->assign['stts_pulang'] = [];

        if(isset($_POST['periode_rawat_inap'])) {
          $tgl_masuk = $_POST['periode_rawat_inap'];
        }
        if(isset($_POST['periode_rawat_inap_akhir'])) {
          $tgl_masuk_akhir = $_POST['periode_rawat_inap_akhir'];
        }
        if(isset($_POST['status_pulang'])) {
          $status_pulang = $_POST['status_pulang'];
        }
        $cek_vclaim = $this->db('mlite_modules')->where('dir', 'vclaim')->oneArray();
        $master_berkas_digital = $this->db('master_berkas_digital')->toArray();
        $this->_Display($tgl_masuk, $tgl_masuk_akhir, $status_pulang);
        return $this->draw('manage.html', ['rawat_inap' => $this->assign, 'cek_vclaim' => $cek_vclaim, 'master_berkas_digital' => $master_berkas_digital]);
    }

    public function anyDisplay()
    {
        $tgl_masuk = '';
        $tgl_masuk_akhir = '';
        $status_pulang = '';
        $this->assign['stts_pulang'] = [];

        if(isset($_POST['periode_rawat_inap'])) {
          $tgl_masuk = $_POST['periode_rawat_inap'];
        }
        if(isset($_POST['periode_rawat_inap_akhir'])) {
          $tgl_masuk_akhir = $_POST['periode_rawat_inap_akhir'];
        }
        if(isset($_POST['status_pulang'])) {
          $status_pulang = $_POST['status_pulang'];
        }
        $cek_vclaim = $this->db('mlite_modules')->where('dir', 'vclaim')->oneArray();
        $this->_Display($tgl_masuk, $tgl_masuk_akhir, $status_pulang);
        echo $this->draw('display.html', ['rawat_inap' => $this->assign, 'cek_vclaim' => $cek_vclaim]);
        exit();
    }

    public function _Display($tgl_masuk='', $tgl_masuk_akhir='', $status_pulang='')
    {
        $this->_addHeaderFiles();

        $this->assign['kamar'] = $this->db('kamar')->join('bangsal', 'bangsal.kd_bangsal=kamar.kd_bangsal')->where('statusdata', '1')->toArray();
        $this->assign['dokter']         = $this->db('dokter')->where('status', '1')->toArray();
        $this->assign['penjab']       = $this->db('penjab')->where('status', '1')->toArray();
        $this->assign['no_rawat'] = '';

        $bangsal = str_replace(",","','", $this->core->getUserInfo('cap', null, true));

        $sql = "SELECT 
                    kamar_inap.*, 
                    reg_periksa.*, 
                    pasien.*, 
                    kamar.*, 
                    bangsal.*, 
                    penjab.*
                FROM kamar_inap
                JOIN reg_periksa ON kamar_inap.no_rawat = reg_periksa.no_rawat
                JOIN pasien ON reg_periksa.no_rkm_medis = pasien.no_rkm_medis
                JOIN kamar ON kamar_inap.kd_kamar = kamar.kd_kamar
                JOIN bangsal ON kamar.kd_bangsal = bangsal.kd_bangsal
                JOIN penjab ON reg_periksa.kd_pj = penjab.kd_pj";


        // --- GET PATIENT DATA BY MERGING WITH ranap_gabung ---
        $sql_rg = "SELECT 
                      kamar_inap.*, 
                      reg_periksa.*, 
                      pasien.*, 
                      kamar.*, 
                      bangsal.*, 
                      penjab.*
                  FROM kamar_inap
                  JOIN ranap_gabung ON ranap_gabung.no_rawat = kamar_inap.no_rawat
                  JOIN reg_periksa ON reg_periksa.no_rawat = ranap_gabung.no_rawat2
                  JOIN pasien ON reg_periksa.no_rkm_medis = pasien.no_rkm_medis
                  JOIN kamar ON kamar_inap.kd_kamar = kamar.kd_kamar
                  JOIN bangsal ON kamar.kd_bangsal = bangsal.kd_bangsal
                  JOIN penjab ON reg_periksa.kd_pj = penjab.kd_pj
                  ";

        if ($this->core->getUserInfo('role') != 'admin') {
          $sql .= " AND bangsal.kd_bangsal IN ('$bangsal')";
          $sql_rg .= " AND bangsal.kd_bangsal IN ('$bangsal')"; // --- ADD FILTER FOR RANAP GABUNG
        }

        if ($status_pulang == '') {
          $sql .= " AND kamar_inap.stts_pulang = '-'";
          $sql_rg .= " AND kamar_inap.stts_pulang = '-'"; // --- ADD FILTER FOR RANAP GABUNG
        }

        if ($status_pulang == 'all' && $tgl_masuk !== '' && $tgl_masuk_akhir !== '') {
          $sql .= " AND kamar_inap.stts_pulang = '-' AND kamar_inap.tgl_masuk BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'";
          $sql_rg .= " AND kamar_inap.stts_pulang = '-' AND kamar_inap.tgl_masuk BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'"; // --- ADD FILTER FOR RANAP GABUNG
        }

        if ($status_pulang == 'masuk' && $tgl_masuk !== '' && $tgl_masuk_akhir !== '') {
          $sql .= " AND kamar_inap.tgl_masuk BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'";
          $sql_rg .= " AND kamar_inap.tgl_masuk BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'"; // --- ADD FILTER FOR RANAP GABUNG
        }

        if ($status_pulang == 'pulang' && $tgl_masuk !== '' && $tgl_masuk_akhir !== '') {
          $sql .= " AND kamar_inap.tgl_keluar BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'";
          $sql_rg .= " AND kamar_inap.tgl_keluar BETWEEN '$tgl_masuk' AND '$tgl_masuk_akhir'"; // --- ADD FILTER FOR RANAP GABUNG
        }

        // --- MERGE BOTH SQL QUERIES ---
        $sql_final = $sql . " UNION " . $sql_rg;

        $stmt = $this->db()->pdo()->prepare($sql_final);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $this->assign['list'] = [];
        foreach ($rows as $row) {
          $row['status_billing'] = 'Sudah Bayar';
          $get_billing = $this->db('mlite_billing')->where('no_rawat', $row['no_rawat'])->like('kd_billing', 'RI%')->oneArray();
          if(empty($get_billing['kd_billing'])) {
            $row['kd_billing'] = 'RI.'.date('d.m.Y.H.i.s');
            $row['tgl_billing'] = date('Y-m-d H:i');
            $row['status_billing'] = 'Belum Bayar';
          }

          $dpjp_ranap = $this->db('dpjp_ranap')
            ->join('dokter', 'dokter.kd_dokter=dpjp_ranap.kd_dokter')
            ->where('no_rawat', $row['no_rawat'])
            ->toArray();
          $row['dokter'] = $dpjp_ranap;
          $bridging_sep = $this->db('bridging_sep')->where('no_rawat', $row['no_rawat'])->where('jnspelayanan','1')->oneArray();
          $row['no_sep'] = isset_or($bridging_sep['no_sep']);
          $plafon = $this->db('plafon')->where('no_sep', $bridging_sep['no_sep'])->oneArray();
          $no_rawat = $row['no_rawat'];
          
          $sql1 = "SELECT SUM(
                      COALESCE(biayaoperator1, 0) +
                      COALESCE(biayaoperator2, 0) +
                      COALESCE(biayaoperator3, 0) +
                      COALESCE(biayaasisten_operator1, 0) +
                      COALESCE(biayaasisten_operator2, 0) +
                      COALESCE(biayaasisten_operator3, 0) +
                      COALESCE(biayainstrumen, 0) +
                      COALESCE(biayadokter_anak, 0) +
                      COALESCE(biayaperawaat_resusitas, 0) +
                      COALESCE(biayadokter_anestesi, 0) +
                      COALESCE(biayaasisten_anestesi, 0) +
                      COALESCE(biayaasisten_anestesi2, 0) +
                      COALESCE(biayabidan, 0) +
                      COALESCE(biayabidan2, 0) +
                      COALESCE(biayabidan3, 0) +
                      COALESCE(biayaperawat_luar, 0) +
                      COALESCE(biayaalat, 0) +
                      COALESCE(biayasewaok, 0) +
                      COALESCE(akomodasi, 0) +
                      COALESCE(bagian_rs, 0) +
                      COALESCE(biaya_omloop, 0) +
                      COALESCE(biaya_omloop2, 0) +
                      COALESCE(biaya_omloop3, 0) +
                      COALESCE(biaya_omloop4, 0) +
                      COALESCE(biaya_omloop5, 0) +
                      COALESCE(biayasarpras, 0) +
                      COALESCE(biaya_dokter_pjanak, 0) +
                      COALESCE(biaya_dokter_umum, 0)
                  ) AS total_biaya
                  FROM operasi
                  WHERE no_rawat = '$no_rawat'";

          $stmt1 = $this->db()->pdo()->prepare($sql1);
          $stmt1->execute();
          $rows1 = $stmt1->fetch();

          $sql2 = "SELECT SUM(biaya) as total_biaya
                FROM periksa_radiologi
                WHERE no_rawat = '$no_rawat'
                GROUP BY no_rawat";
          $stmt2 = $this->db()->pdo()->prepare($sql2);
          $stmt2->execute();
          $rows2 = $stmt2->fetch();

          $sql3 = "SELECT SUM(biaya) as total_biaya
                FROM periksa_lab
                WHERE no_rawat = '$no_rawat'
                GROUP BY no_rawat";
          $stmt3 = $this->db()->pdo()->prepare($sql3);
          $stmt3->execute();
          $rows3 = $stmt3->fetch();

          $sql4 = "SELECT SUM(biaya_item) as total_biaya
                FROM detail_periksa_lab
                WHERE no_rawat = '$no_rawat'
                GROUP BY no_rawat";
          $stmt4 = $this->db()->pdo()->prepare($sql4);
          $stmt4->execute();
          $rows4 = $stmt4->fetch();

          $sql5 = "SELECT SUM(biaya_rawat) as total_biaya
                FROM rawat_jl_dr
                WHERE no_rawat = '$no_rawat'
                GROUP BY no_rawat";
          $stmt5 = $this->db()->pdo()->prepare($sql5);
          $stmt5->execute();
          $rows5 = $stmt5->fetch();

          $sql6 = "SELECT SUM(biaya_rawat) as total_biaya
                FROM rawat_jl_drpr
                WHERE no_rawat = '$no_rawat'
                GROUP BY no_rawat";
          $stmt6 = $this->db()->pdo()->prepare($sql6);
          $stmt6->execute();
          $rows6 = $stmt6->fetch();

          $sql7 = "SELECT SUM(biaya_rawat) as total_biaya
                FROM rawat_jl_pr
                WHERE no_rawat = '$no_rawat'
                GROUP BY no_rawat";
          $stmt7 = $this->db()->pdo()->prepare($sql7);
          $stmt7->execute();
          $rows7 = $stmt7->fetch();

          $sql8 = "SELECT SUM(biaya_rawat) as total_biaya
                FROM rawat_inap_dr
                WHERE no_rawat = '$no_rawat'
                GROUP BY no_rawat";
          $stmt8 = $this->db()->pdo()->prepare($sql8);
          $stmt8->execute();
          $rows8 = $stmt8->fetch();

          $sql9 = "SELECT SUM(biaya_rawat) as total_biaya
                FROM rawat_inap_drpr
                WHERE no_rawat = '$no_rawat'
                GROUP BY no_rawat";
          $stmt9 = $this->db()->pdo()->prepare($sql9);
          $stmt9->execute();
          $rows9 = $stmt9->fetch();

          $sql10 = "SELECT SUM(biaya_rawat) as total_biaya
                FROM rawat_inap_pr
                WHERE no_rawat = '$no_rawat'
                GROUP BY no_rawat";
          $stmt10 = $this->db()->pdo()->prepare($sql10);
          $stmt10->execute();
          $rows10 = $stmt10->fetch();

          $sql11 = "SELECT CEIL(SUM(((biaya_obat * jml) + (biaya_obat * jml) * 11 / 100))) as total_biaya
                    FROM detail_pemberian_obat
                    WHERE no_rawat = '$no_rawat'
                    GROUP BY no_rawat";
          $stmt11 = $this->db()->pdo()->prepare($sql11);
          $stmt11->execute();
          $rows11 = $stmt11->fetch();

          $sql12 = "SELECT SUM(ttl_biaya) as total_biaya
                    FROM kamar_inap
                    WHERE no_rawat = '$no_rawat'
                    GROUP BY no_rawat";
          $stmt12 = $this->db()->pdo()->prepare($sql12);
          $stmt12->execute();
          $rows12 = $stmt12->fetch();

          $sql13 = "SELECT SUM(biaya_sekali.besar_biaya) as total_biaya
                    FROM biaya_sekali JOIN kamar_inap ON biaya_sekali.kd_kamar = kamar_inap.kd_kamar
                    WHERE kamar_inap.no_rawat = '$no_rawat'
                    GROUP BY kamar_inap.no_rawat";
          $stmt13 = $this->db()->pdo()->prepare($sql13);
          $stmt13->execute();
          $rows13 = $stmt13->fetch();

          //==================== SET ERVICE RANAP ====================

          $service_ranap = $this->db('set_service_ranap')->oneArray();

          $operasi = $this->set_service_ranap($service_ranap['operasi']) * $rows1['total_biaya'];
          $radiologi = $this->set_service_ranap($service_ranap['radiologi']) * $rows2['total_biaya'];
          $laborat = $this->set_service_ranap($service_ranap['laborat']) * ($rows3['total_biaya'] + $rows4['total_biaya']);
          $ralan_dr = $this->set_service_ranap($service_ranap['ralan_dokter']) * $rows5['total_biaya'];
          $ralan_drpr = $this->set_service_ranap($service_ranap['ralan_dokter']) * $rows6['total_biaya'];
          $ralan_pr = $this->set_service_ranap($service_ranap['ralan_paramedis']) * $rows7['total_biaya'];
          $ranap_dr = $this->set_service_ranap($service_ranap['ranap_dokter']) * $rows8['total_biaya'];
          $ranap_drpr = $this->set_service_ranap($service_ranap['ranap_dokter']) * $rows9['total_biaya'];
          $ranap_pr = $this->set_service_ranap($service_ranap['ranap_paramedis']) * $rows10['total_biaya'];
          $obat = $this->set_service_ranap($service_ranap['obat']) * $rows11['total_biaya'];
          $kamar = $this->set_service_ranap($service_ranap['kamar']) * ($rows12['total_biaya'] + $rows13['total_biaya']);

          $service = ($service_ranap['besar'] * ($operasi + $radiologi + $laborat + $ralan_dr + $ralan_drpr + $ralan_pr + $ranap_dr + $ranap_drpr + $ranap_pr + $obat + $kamar))/100;

          //==================== SET ERVICE RANAP ====================
          
          $sql_diagnosa = "SELECT 
                              GROUP_CONCAT(kd_penyakit ORDER BY prioritas ASC SEPARATOR ', ') AS list_kd_penyakit
                            FROM 
                              diagnosa_pasien
                            WHERE
                              no_rawat = '$no_rawat'
                            GROUP BY 
                              no_rawat";
          $diagnosa = $this->db()->pdo()->prepare($sql_diagnosa);
          $diagnosa->execute();
          $list_diagnosa = $diagnosa->fetch();
          $row['list_diagnosa'] = $list_diagnosa['list_kd_penyakit'];

          $sql_prosedur = "SELECT 
                              GROUP_CONCAT(kode ORDER BY prioritas ASC SEPARATOR ', ') AS list_kd_prosedur
                            FROM 
                              prosedur_pasien
                            WHERE
                              no_rawat = '$no_rawat'
                            GROUP BY 
                              no_rawat";
          $prosedur = $this->db()->pdo()->prepare($sql_prosedur);
          $prosedur->execute();
          $list_prosedur = $prosedur->fetch();
          $row['list_prosedur'] = $list_prosedur['list_kd_prosedur'];
          
          $row['plafon'] = isset_or($plafon['tarif']);
          $row['total_billing'] = $rows1['total_biaya'] + $rows2['total_biaya'] + $rows3['total_biaya'] + $rows4['total_biaya'] + $rows5['total_biaya'] + $rows6['total_biaya'] + $rows7['total_biaya'] + $rows8['total_biaya'] + $rows9['total_biaya'] + $rows10['total_biaya'] + $rows11['total_biaya'] + $rows12['total_biaya'] + $rows13['total_biaya'] + $row['biaya_reg'] + $service;
          
          $percentage = 0;
          if ($row['plafon'] != 0) {
            $percentage = ($row['total_billing'] / $row['plafon']) * 100;
          }

          if ($percentage < 50) {
            $row['warna'] = 'Putih';
          } elseif($percentage > 50 && $percentage < 80){
            $row['warna'] = 'Kuning';
          } elseif($percentage > 80){
            $row['warna'] = 'Merah';
          }

          $row['sisa'] = $row['plafon'] - $row['total_billing'];

          $row['total_billing'] = 'Rp ' . number_format($row['total_billing'], 0, ',', '.');
          $row['plafon'] = 'Rp ' . number_format($row['plafon'], 0, ',', '.');
          $row['sisa'] = 'Rp ' . number_format($row['sisa'], 0, ',', '.');
          
          $this->assign['list'][] = $row;
        }

        if (isset($_POST['no_rawat'])){
          $this->assign['kamar_inap'] = $this->db('kamar_inap')
            ->join('reg_periksa', 'reg_periksa.no_rawat=kamar_inap.no_rawat')
            ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
            ->join('kamar', 'kamar.kd_kamar=kamar_inap.kd_kamar')
            ->join('dpjp_ranap', 'dpjp_ranap.no_rawat=kamar_inap.no_rawat')
            ->join('dokter', 'dokter.kd_dokter=dpjp_ranap.kd_dokter')
            ->join('penjab', 'penjab.kd_pj=reg_periksa.kd_pj')
            ->where('kamar_inap.no_rawat', $_POST['no_rawat'])
            ->oneArray();
        } else {
          $this->assign['kamar_inap'] = [
            'tgl_masuk' => date('Y-m-d'),
            'jam_masuk' => date('H:i:s'),
            'tgl_keluar' => date('Y-m-d'),
            'jam_keluar' => date('H:i:s'),
            'no_rkm_medis' => '',
            'nm_pasien' => '',
            'no_rawat' => '',
            'kd_dokter' => '',
            'kd_kamar' => '',
            'kd_pj' => '',
            'diagnosa_awal' => '',
            'diagnosa_akhir' => '',
            'stts_pulang' => '',
            'lama' => ''
          ];
        }
    }
  
    private function set_service_ranap($text){
      if($text == 'No'){
        $besaran = 0;
      }else if($text == 'Yes'){
        $besaran = 1;
      }

      return $besaran;
    }

    public function anyForm()
    {

      $this->assign['kamar'] = $this->db('kamar')->join('bangsal', 'bangsal.kd_bangsal=kamar.kd_bangsal')->where('statusdata', '1')->toArray();
      $this->assign['dokter'] = $this->db('dokter')->where('status', '1')->toArray();
      $this->assign['penjab'] = $this->db('penjab')->where('status', '1')->toArray();
      $this->assign['stts_pulang'] = ['Sehat','Rujuk','APS','+','Meninggal','Sembuh','Membaik','Pulang Paksa','-','Pindah Kamar','Status Belum Lengkap','Atas Persetujuan Dokter','Atas Permintaan Sendiri','Lain-lain'];
      $this->assign['no_rawat'] = '';
      if (isset($_POST['no_rawat'])){
        $this->assign['kamar_inap'] = $this->db('kamar_inap')
          ->join('reg_periksa', 'reg_periksa.no_rawat=kamar_inap.no_rawat')
          ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
          ->join('kamar', 'kamar.kd_kamar=kamar_inap.kd_kamar')
          ->join('dpjp_ranap', 'dpjp_ranap.no_rawat=kamar_inap.no_rawat')
          ->join('dokter', 'dokter.kd_dokter=dpjp_ranap.kd_dokter')
          ->join('penjab', 'penjab.kd_pj=reg_periksa.kd_pj')
          ->where('kamar_inap.no_rawat', $_POST['no_rawat'])
          ->oneArray();
        echo $this->draw('form.html', [
          'rawat_inap' => $this->assign
        ]);
      } else {
        $this->assign['kamar_inap'] = [
          'tgl_masuk' => date('Y-m-d'),
          'jam_masuk' => date('H:i:s'),
          'tgl_keluar' => date('Y-m-d'),
          'jam_keluar' => date('H:i:s'),
          'no_rkm_medis' => '',
          'nm_pasien' => '',
          'no_rawat' => '',
          'kd_dokter' => '',
          'kd_kamar' => '',
          'kd_pj' => '',
          'diagnosa_awal' => '',
          'diagnosa_akhir' => '',
          'stts_pulang' => '',
          'lama' => ''
        ];
        echo $this->draw('form.html', [
          'rawat_inap' => $this->assign
        ]);
      }
      exit();
    }

    public function anyStatusDaftar()
    {
      if(isset($_POST['no_rkm_medis'])) {
        $rawat = $this->db('reg_periksa')
          ->where('no_rkm_medis', $_POST['no_rkm_medis'])
          ->where('status_bayar', 'Belum Bayar')
          ->limit(1)
          ->oneArray();
          if($rawat) {
            $stts_daftar ="Transaki tanggal ".date('Y-m-d', strtotime($rawat['tgl_registrasi']))." belum diselesaikan" ;
            $bg_status = 'text-danger';
          } else {
            $result = $this->db('reg_periksa')->where('no_rkm_medis', $_POST['no_rkm_medis'])->oneArray();
            if(!empty($result['no_rawat'])) {
              $stts_daftar = 'Lama';
              $bg_status = 'text-info';
            } else {
              $stts_daftar = 'Baru';
              $bg_status = 'text-success';
            }
          }
        echo $this->draw('stts.daftar.html', ['stts_daftar' => $stts_daftar, 'bg_status' =>$bg_status]);
      } else {
        $rawat = $this->db('reg_periksa')
          ->where('no_rawat', $_POST['no_rawat'])
          ->oneArray();
        echo $this->draw('stts.daftar.html', ['stts_daftar' => $rawat['stts_daftar']]);
      }
      exit();
    }

    public function postSave()
    {
      $kamar = $this->db('kamar')->where('kd_kamar', $_POST['kd_kamar'])->oneArray();
      $kamar_inap = $this->db('kamar_inap')->save([
        'no_rawat' => $_POST['no_rawat'],
        'kd_kamar' => $_POST['kd_kamar'],
        'trf_kamar' => $kamar['trf_kamar'],
        'lama' => $_POST['lama'],
        'tgl_masuk' => $_POST['tgl_masuk'],
        'jam_masuk' => $_POST['jam_masuk'],
        'ttl_biaya' => $kamar['trf_kamar']*$_POST['lama'],
        'tgl_keluar' => '0000-00-00',
        'jam_keluar' => '00:00:00',
        'diagnosa_akhir' => '',
        'diagnosa_awal' => $_POST['diagnosa_awal'],
        'stts_pulang' => '-'
      ]);
      if($kamar_inap) {
        $this->db('dpjp_ranap')->save(['no_rawat' => $_POST['no_rawat'], 'kd_dokter' => $_POST['kd_dokter']]);
        $this->db('kamar')->where('kd_kamar', $_POST['kd_kamar'])->save(['status' => 'ISI']);
      }
      exit();
    }

    public function postSaveKeluar()
    {
      $kamar = $this->db('kamar')->where('kd_kamar', $_POST['kd_kamar'])->oneArray();
      $this->db('kamar_inap')->where('no_rawat', $_POST['no_rawat'])->save([
        'stts_pulang' => $_POST['stts_pulang'],
        'lama' => $_POST['lama'],
        'tgl_keluar' => $_POST['tgl_keluar'],
        'jam_keluar' => $_POST['jam_keluar'],
        'diagnosa_akhir' => $_POST['diagnosa_akhir'],
        'ttl_biaya' => $kamar['trf_kamar']*$_POST['lama']
      ]);
      $this->db('reg_periksa')->where('no_rawat', $_POST['no_rawat'])->save([
        'kd_pj' => $_POST['kd_pj'],
        'stts' => 'Sudah'
      ]);
      $this->db('kamar')->where('kd_kamar', $_POST['kd_kamar'])->save(['status' => 'KOSONG']);
      exit();
    }

    public function postSetDPJP()
    {
      $this->db('dpjp_ranap')->save(['no_rawat' => $_POST['no_rawat'], 'kd_dokter' => $_POST['kd_dokter']]);
      exit();
    }

    public function postHapusDPJP()
    {
      $this->db('dpjp_ranap')->where('no_rawat', $_POST['no_rawat'])->where('kd_dokter', $_POST['kd_dokter'])->delete();
      exit();
    }

    public function postUbahPenjab()
    {
      $this->db('reg_periksa')->where('no_rawat', $_POST['no_rawat'])->save([
        'kd_pj' => $_POST['kd_pj']
      ]);
      exit();
    }

    public function anyPasien()
    {
      $cari = $_POST['cari'];
      if(isset($_POST['cari'])) {
        $sql = "SELECT
            pasien.nm_pasien,
            pasien.no_rkm_medis,
            reg_periksa.no_rawat
          FROM
            reg_periksa,
            pasien
          WHERE
            reg_periksa.status_lanjut='Ranap'
          AND
            pasien.no_rkm_medis=reg_periksa.no_rkm_medis
          AND
            (reg_periksa.no_rkm_medis LIKE ? OR reg_periksa.no_rawat LIKE ? OR pasien.nm_pasien LIKE ?)
          LIMIT 10";

        $stmt = $this->db()->pdo()->prepare($sql);
        $stmt->execute(['%'.$cari.'%', '%'.$cari.'%', '%'.$cari.'%']);
        $pasien = $stmt->fetchAll();

        /*$pasien = $this->db('reg_periksa')
          ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
          ->like('reg_periksa.no_rkm_medis', '%'.$_POST['cari'].'%')
          ->where('status_lanjut', 'Ranap')
          ->asc('reg_periksa.no_rkm_medis')
          ->limit(15)
          ->toArray();*/

      }
      echo $this->draw('pasien.html', ['pasien' => $pasien]);
      exit();
    }

    public function getAntrian()
    {
      $settings = $this->settings('settings');
      $this->tpl->set('settings', $this->tpl->noParse_array(htmlspecialchars_array($settings)));
      $rawat_inap = $this->db('reg_periksa')
        ->join('pasien', 'pasien.no_rkm_medis=reg_periksa.no_rkm_medis')
        ->join('poliklinik', 'poliklinik.kd_poli=reg_periksa.kd_poli')
        ->join('dokter', 'dokter.kd_dokter=reg_periksa.kd_dokter')
        ->join('penjab', 'penjab.kd_pj=reg_periksa.kd_pj')
        ->where('no_rawat', $_GET['no_rawat'])
        ->oneArray();
      echo $this->draw('antrian.html', ['rawat_inap' => $rawat_inap]);
      exit();
    }

    public function postHapus()
    {
      $this->db('kamar_inap')->where('no_rawat', $_POST['no_rawat'])->delete();
      exit();
    }

    public function postSaveDetail()
    {
      if($_POST['kat'] == 'tindakan') {
        $jns_perawatan = $this->db('jns_perawatan_inap')->where('kd_jenis_prw', $_POST['kd_jenis_prw'])->oneArray();
        if($_POST['provider'] == 'rawat_inap_dr') {
          $this->db('rawat_inap_dr')->save([
            'no_rawat' => $_POST['no_rawat'],
            'kd_jenis_prw' => $_POST['kd_jenis_prw'],
            'kd_dokter' => $_POST['kode_provider'],
            'tgl_perawatan' => $_POST['tgl_perawatan'],
            'jam_rawat' => $_POST['jam_rawat'],
            'material' => $jns_perawatan['material'],
            'bhp' => $jns_perawatan['bhp'],
            'tarif_tindakandr' => $jns_perawatan['tarif_tindakandr'],
            'kso' => $jns_perawatan['kso'],
            'menejemen' => $jns_perawatan['menejemen'],
            'biaya_rawat' => $jns_perawatan['total_byrdr']
          ]);
        }
        if($_POST['provider'] == 'rawat_inap_pr') {
          $this->db('rawat_inap_pr')->save([
            'no_rawat' => $_POST['no_rawat'],
            'kd_jenis_prw' => $_POST['kd_jenis_prw'],
            'nip' => $_POST['kode_provider2'],
            'tgl_perawatan' => $_POST['tgl_perawatan'],
            'jam_rawat' => $_POST['jam_rawat'],
            'material' => $jns_perawatan['material'],
            'bhp' => $jns_perawatan['bhp'],
            'tarif_tindakanpr' => $jns_perawatan['tarif_tindakanpr'],
            'kso' => $jns_perawatan['kso'],
            'menejemen' => $jns_perawatan['menejemen'],
            'biaya_rawat' => $jns_perawatan['total_byrpr']
          ]);
        }
        if($_POST['provider'] == 'rawat_inap_drpr') {
          $this->db('rawat_inap_drpr')->save([
            'no_rawat' => $_POST['no_rawat'],
            'kd_jenis_prw' => $_POST['kd_jenis_prw'],
            'kd_dokter' => $_POST['kode_provider'],
            'nip' => $_POST['kode_provider2'],
            'tgl_perawatan' => $_POST['tgl_perawatan'],
            'jam_rawat' => $_POST['jam_rawat'],
            'material' => $jns_perawatan['material'],
            'bhp' => $jns_perawatan['bhp'],
            'tarif_tindakandr' => $jns_perawatan['tarif_tindakandr'],
            'tarif_tindakanpr' => $jns_perawatan['tarif_tindakanpr'],
            'kso' => $jns_perawatan['kso'],
            'menejemen' => $jns_perawatan['menejemen'],
            'biaya_rawat' => $jns_perawatan['total_byrdrpr']
          ]);
        }
      }
      if($_POST['kat'] == 'obat') {

        $no_resep = $this->core->setNoResep($_POST['tgl_perawatan']);
        $cek_resep = $this->db('resep_obat')->where('no_rawat', $_POST['no_rawat'])->where('tgl_peresepan', $_POST['tgl_perawatan'])->where('tgl_perawatan', '0000-00-00')->where('status', 'ranap')->oneArray();

        if(empty($cek_resep)) {

          $resep_obat = $this->db('resep_obat')
            ->save([
              'no_resep' => $no_resep,
              'tgl_perawatan' => '0000-00-00',
              'jam' => '00:00:00',
              'no_rawat' => $_POST['no_rawat'],
              'kd_dokter' => $_POST['kode_provider'],
              'tgl_peresepan' => $_POST['tgl_perawatan'],
              'jam_peresepan' => $_POST['jam_rawat'],
              'status' => 'ranap',
              'tgl_penyerahan' => '0000-00-00',
              'jam_penyerahan' => '00:00:00'
            ]);

          if ($this->db('resep_obat')->where('no_resep', $no_resep)->where('kd_dokter', $_POST['kode_provider'])->oneArray()) {
            $this->db('resep_dokter')
              ->save([
                'no_resep' => $no_resep,
                'kode_brng' => $_POST['kd_jenis_prw'],
                'jml' => $_POST['jml'],
                'aturan_pakai' => $_POST['aturan_pakai']
              ]);
          }

        } else {

          $no_resep = $cek_resep['no_resep'];

          $this->db('resep_dokter')
            ->save([
              'no_resep' => $no_resep,
              'kode_brng' => $_POST['kd_jenis_prw'],
              'jml' => $_POST['jml'],
              'aturan_pakai' => $_POST['aturan_pakai']
            ]);

        }

      }
      exit();
    }

    public function postHapusDetail()
    {
      if($_POST['provider'] == 'rawat_inap_dr') {
        $this->db('rawat_inap_dr')
        ->where('no_rawat', $_POST['no_rawat'])
        ->where('kd_jenis_prw', $_POST['kd_jenis_prw'])
        ->where('tgl_perawatan', $_POST['tgl_perawatan'])
        ->where('jam_rawat', $_POST['jam_rawat'])
        ->delete();
      }
      if($_POST['provider'] == 'rawat_inap_pr') {
        $this->db('rawat_inap_pr')
        ->where('no_rawat', $_POST['no_rawat'])
        ->where('kd_jenis_prw', $_POST['kd_jenis_prw'])
        ->where('tgl_perawatan', $_POST['tgl_perawatan'])
        ->where('jam_rawat', $_POST['jam_rawat'])
        ->delete();
      }
      if($_POST['provider'] == 'rawat_inap_drpr') {
        $this->db('rawat_inap_drpr')
        ->where('no_rawat', $_POST['no_rawat'])
        ->where('kd_jenis_prw', $_POST['kd_jenis_prw'])
        ->where('tgl_perawatan', $_POST['tgl_perawatan'])
        ->where('jam_rawat', $_POST['jam_rawat'])
        ->delete();
      }
      exit();
    }

    public function postHapusResep()
    {
      if(isset($_POST['kd_jenis_prw'])) {
        $this->db('resep_dokter')
        ->where('no_resep', $_POST['no_resep'])
        ->where('kode_brng', $_POST['kd_jenis_prw'])
        ->delete();
      } else {
        $this->db('resep_obat')
        ->where('no_resep', $_POST['no_resep'])
        ->where('no_rawat', $_POST['no_rawat'])
        ->where('tgl_peresepan', $_POST['tgl_peresepan'])
        ->where('jam_peresepan', $_POST['jam_peresepan'])
        ->delete();
      }

      exit();
    }

    public function anyRincian()
    {
      $rows_rawat_inap_dr = $this->db('rawat_inap_dr')->where('no_rawat', $_POST['no_rawat'])->toArray();
      $rows_rawat_inap_pr = $this->db('rawat_inap_pr')->where('no_rawat', $_POST['no_rawat'])->toArray();
      $rows_rawat_inap_drpr = $this->db('rawat_inap_drpr')->where('no_rawat', $_POST['no_rawat'])->toArray();

      $jumlah_total = 0;
      $rawat_inap_dr = [];
      $rawat_inap_pr = [];
      $rawat_inap_drpr = [];
      $i = 1;

      if($rows_rawat_inap_dr) {
        foreach ($rows_rawat_inap_dr as $row) {
          $jns_perawatan = $this->db('jns_perawatan_inap')->where('kd_jenis_prw', $row['kd_jenis_prw'])->oneArray();
          $row['nm_perawatan'] = $jns_perawatan['nm_perawatan'];
          $jumlah_total = $jumlah_total + $row['biaya_rawat'];
          $row['provider'] = 'rawat_inap_dr';
          $rawat_inap_dr[] = $row;
        }
      }

      if($rows_rawat_inap_pr) {
        foreach ($rows_rawat_inap_pr as $row) {
          $jns_perawatan = $this->db('jns_perawatan_inap')->where('kd_jenis_prw', $row['kd_jenis_prw'])->oneArray();
          $row['nm_perawatan'] = $jns_perawatan['nm_perawatan'];
          $jumlah_total = $jumlah_total + $row['biaya_rawat'];
          $row['provider'] = 'rawat_inap_pr';
          $rawat_inap_pr[] = $row;
        }
      }

      if($rows_rawat_inap_drpr) {
        foreach ($rows_rawat_inap_drpr as $row) {
          $jns_perawatan = $this->db('jns_perawatan_inap')->where('kd_jenis_prw', $row['kd_jenis_prw'])->oneArray();
          $row['nm_perawatan'] = $jns_perawatan['nm_perawatan'];
          $jumlah_total = $jumlah_total + $row['biaya_rawat'];
          $row['provider'] = 'rawat_inap_drpr';
          $rawat_inap_drpr[] = $row;
        }
      }

      $rows = $this->db('resep_obat')
        ->join('dokter', 'dokter.kd_dokter=resep_obat.kd_dokter')
        ->where('no_rawat', $_POST['no_rawat'])
        ->where('resep_obat.status', 'ranap')
        ->toArray();
      $resep = [];
      $jumlah_total_resep = 0;
      foreach ($rows as $row) {
        $row['nomor'] = $i++;
        $row['resep_dokter'] = $this->db('resep_dokter')->join('databarang', 'databarang.kode_brng=resep_dokter.kode_brng')->where('no_resep', $row['no_resep'])->toArray();
        foreach ($row['resep_dokter'] as $value) {
          $value['dasar'] = $value['jml'] * $value['dasar'];
          $jumlah_total_resep += floatval($value['dasar']);
        }
        $resep[] = $row;
      }
      echo $this->draw('rincian.html', ['rawat_inap_dr' => $rawat_inap_dr, 'rawat_inap_pr' => $rawat_inap_pr, 'rawat_inap_drpr' => $rawat_inap_drpr, 'jumlah_total' => $jumlah_total, 'jumlah_total_resep' => $jumlah_total_resep, 'resep' =>$resep, 'no_rawat' => $_POST['no_rawat']]);
      exit();
    }

    public function anySoap()
    {

      $prosedurs = $this->db('prosedur_pasien')
         ->where('no_rawat', $_POST['no_rawat'])
         ->asc('prioritas')
         ->toArray();
       $prosedur = [];
       foreach ($prosedurs as $row) {
         $icd9 = $this->db('icd9')->where('kode', $row['kode'])->oneArray();
         $row['nama'] = $icd9['deskripsi_panjang'];
         $prosedur[] = $row;
       }
       $diagnosas = $this->db('diagnosa_pasien')
         ->where('no_rawat', $_POST['no_rawat'])
         ->asc('prioritas')
         ->toArray();
       $diagnosa = [];
       foreach ($diagnosas as $row) {
         $icd10 = $this->db('penyakit')->where('kd_penyakit', $row['kd_penyakit'])->oneArray();
         $row['nama'] = $icd10['nm_penyakit'];
         $diagnosa[] = $row;
       }

      $i = 1;
      $row['nama_petugas'] = '';
      $row['departemen_petugas'] = '';
      $rows = $this->db('pemeriksaan_ralan')
        ->where('no_rawat', $_POST['no_rawat'])
        ->toArray();
      $result = [];
      foreach ($rows as $row) {
        $row['nomor'] = $i++;
        $row['nama_petugas'] = $this->core->getPegawaiInfo('nama',$row['nip']);
        $row['departemen_petugas'] = $this->core->getDepartemenInfo($this->core->getPegawaiInfo('departemen',$row['nip']));
        $result[] = $row;
      }

      $rows_ranap = $this->db('pemeriksaan_ranap')
        ->where('no_rawat', $_POST['no_rawat'])
        ->toArray();
      $result_ranap = [];
      foreach ($rows_ranap as $row) {
        $row['nomor'] = $i++;
        $row['nama_petugas'] = $this->core->getPegawaiInfo('nama',$row['nip']);
        $row['departemen_petugas'] = $this->core->getDepartemenInfo($this->core->getPegawaiInfo('departemen',$row['nip']));
        $result_ranap[] = $row;
      }

      echo $this->draw('soap.html', ['pemeriksaan' => $result, 'pemeriksaan_ranap' => $result_ranap, 'diagnosa' => $diagnosa, 'prosedur' => $prosedur]);
      exit();
    }

    public function postSaveSOAP()
    {
      $_POST['nip'] = $this->core->getUserInfo('username', null, true);

      if(!$this->db('pemeriksaan_ranap')->where('no_rawat', $_POST['no_rawat'])->where('tgl_perawatan', $_POST['tgl_perawatan'])->where('jam_rawat', $_POST['jam_rawat'])->where('nip', $_POST['nip'])->oneArray()) {
        $this->db('pemeriksaan_ranap')->save($_POST);
      } else {
        $this->db('pemeriksaan_ranap')->where('no_rawat', $_POST['no_rawat'])->where('tgl_perawatan', $_POST['tgl_perawatan'])->where('jam_rawat', $_POST['jam_rawat'])->where('nip', $_POST['nip'])->save($_POST);
      }
      exit();
    }

    public function postHapusSOAP()
    {
      $this->db('pemeriksaan_ranap')->where('no_rawat', $_POST['no_rawat'])->where('tgl_perawatan', $_POST['tgl_perawatan'])->where('jam_rawat', $_POST['jam_rawat'])->delete();
      exit();
    }

    public function anyLayanan()
    {
      $layanan = $this->db('jns_perawatan_inap')
        ->where('status', '1')
        ->like('nm_perawatan', '%'.$_POST['layanan'].'%')
        ->limit(10)
        ->toArray();
      echo $this->draw('layanan.html', ['layanan' => $layanan]);
      exit();
    }

    public function anyObat()
    {
      $obat = $this->db('databarang')
        ->join('gudangbarang', 'gudangbarang.kode_brng=databarang.kode_brng')
        ->where('status', '1')
        ->where('gudangbarang.kd_bangsal', $this->settings->get('farmasi.deporanap'))
        ->like('databarang.nama_brng', '%'.$_POST['obat'].'%')
        ->limit(10)
        ->toArray();
      echo $this->draw('obat.html', ['obat' => $obat]);
      exit();
    }

    public function postAturanPakai()
    {

      if(isset($_POST["query"])){
        $output = '';
        $key = "%".$_POST["query"]."%";
        $rows = $this->db('master_aturan_pakai')->like('aturan', $key)->limit(10)->toArray();
        $output = '';
        if(count($rows)){
          foreach ($rows as $row) {
            $output .= '<li class="list-group-item link-class">'.$row["aturan"].'</li>';
          }
        }
        echo $output;
      }

      exit();

    }

    public function anyBerkasDigital()
    {
      $berkas_digital = $this->db('berkas_digital_perawatan')->where('no_rawat', $_POST['no_rawat'])->toArray();
      echo $this->draw('berkasdigital.html', ['berkas_digital' => $berkas_digital]);
      exit();
    }

    public function postSaveBerkasDigital()
    {

      if(MULTI_APP) {

        $curl = curl_init();
        $filePath = $_FILES['file']['tmp_name'];

        curl_setopt_array($curl, array(
          CURLOPT_URL => str_replace('webapps','',WEBAPPS_URL).'api/berkasdigital',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => array('file'=> new \CURLFILE($filePath),'token' => $this->settings->get('api.berkasdigital_key'), 'no_rawat' => $_POST['no_rawat'], 'kode' => $_POST['kode']),
          CURLOPT_HTTPHEADER => array(),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $json = json_decode($response, true);
        if($json['status'] == 'Success') {
          echo '<br><img src="'.WEBAPPS_URL.'/berkasrawat/'.$json['msg'].'" width="150" />';
        } else {
          echo 'Gagal menambahkan gambar';
        }

      } else {      
        $dir    = $this->_uploads;
        $cntr   = 0;

        $image = $_FILES['file']['tmp_name'];
        $img = new \Systems\Lib\Image();
        $id = convertNorawat($_POST['no_rawat']);
        if ($img->load($image)) {
            $imgName = time().$cntr++;
            $imgPath = $dir.'/'.$id.'_'.$imgName.'.'.$img->getInfos('type');
            $lokasi_file = 'pages/upload/'.$id.'_'.$imgName.'.'.$img->getInfos('type');
            $img->save($imgPath);
            $query = $this->db('berkas_digital_perawatan')->save(['no_rawat' => $_POST['no_rawat'], 'kode' => $_POST['kode'], 'lokasi_file' => $lokasi_file]);
            if($query) {
              echo '<br><img src="'.WEBAPPS_URL.'/berkasrawat/'.$lokasi_file.'" width="150" />';
            }
        }
      }
      exit();

    }

    public function postProviderList()
    {

      if(isset($_POST["query"])){
        $output = '';
        $key = "%".$_POST["query"]."%";
        $rows = $this->db('dokter')->like('nm_dokter', $key)->where('status', '1')->limit(10)->toArray();
        $output = '';
        if(count($rows)){
          foreach ($rows as $row) {
            $output .= '<li class="list-group-item link-class">'.$row["kd_dokter"].': '.$row["nm_dokter"].'</li>';
          }
        }
        echo $output;
      }

      exit();

    }

    public function postProviderList2()
    {

      if(isset($_POST["query"])){
        $output = '';
        $key = "%".$_POST["query"]."%";
        $rows = $this->db('petugas')->like('nama', $key)->limit(10)->toArray();
        $output = '';
        if(count($rows)){
          foreach ($rows as $row) {
            $output .= '<li class="list-group-item link-class">'.$row["nip"].': '.$row["nama"].'</li>';
          }
        }
        echo $output;
      }

      exit();

    }

    public function postCekWaktu()
    {
      echo date('H:i:s');
      exit();
    }

    public function postMaxid()
    {
      $max_id = $this->db('reg_periksa')->select(['no_rawat' => 'ifnull(MAX(CONVERT(RIGHT(no_rawat,6),signed)),0)'])->where('tgl_registrasi', date('Y-m-d'))->oneArray();
      if(empty($max_id['no_rawat'])) {
        $max_id['no_rawat'] = '000000';
      }
      $_next_no_rawat = sprintf('%06s', ($max_id['no_rawat'] + 1));
      $next_no_rawat = date('Y/m/d').'/'.$_next_no_rawat;
      echo $next_no_rawat;
      exit();
    }

    public function postMaxAntrian()
    {
      $max_id = $this->db('reg_periksa')->select(['no_reg' => 'ifnull(MAX(CONVERT(RIGHT(no_reg,3),signed)),0)'])->where('kd_poli', $_POST['kd_poli'])->where('tgl_registrasi', date('Y-m-d'))->desc('no_reg')->limit(1)->oneArray();
      if(empty($max_id['no_reg'])) {
        $max_id['no_reg'] = '000';
      }
      $_next_no_reg = sprintf('%03s', ($max_id['no_reg'] + 1));
      echo $_next_no_reg;
      exit();
    }

    public function getSuratRujukan($no_rawat)
    {
        $kd_dokter = $this->core->getRegPeriksaInfo('kd_dokter', revertNoRawat($no_rawat));
        $no_rkm_medis = $this->core->getRegPeriksaInfo('no_rkm_medis', revertNoRawat($no_rawat));
        $pasien = $this->db('pasien')
          ->join('kelurahan', 'kelurahan.kd_kel=pasien.kd_kel')
          ->join('kecamatan', 'kecamatan.kd_kec=pasien.kd_kec')
          ->join('kabupaten', 'kabupaten.kd_kab=pasien.kd_kab')
          ->join('propinsi', 'propinsi.kd_prop=pasien.kd_prop')
          ->where('no_rkm_medis', $no_rkm_medis)
          ->oneArray();
        $nm_dokter = $this->core->getPegawaiInfo('nama', $kd_dokter);
        $sip_dokter = $this->core->getDokterInfo('no_ijn_praktek', $kd_dokter);
        $this->tpl->set('pasien', $this->tpl->noParse_array(htmlspecialchars_array($pasien)));
        $this->tpl->set('nm_dokter', $nm_dokter);
        $this->tpl->set('sip_dokter', $sip_dokter);
        $this->tpl->set('no_rawat', revertNoRawat($no_rawat));
        $this->tpl->set('settings', $this->tpl->noParse_array(htmlspecialchars_array($this->settings('settings'))));
        $this->tpl->set('surat', $this->db('mlite_surat_rujukan')->where('no_rawat', revertNoRawat($no_rawat))->oneArray());
        echo $this->tpl->draw(MODULES.'/rawat_inap/view/admin/surat.rujukan.html', true);
        exit();
    }

    public function getSuratSehat($no_rawat)
    {
        $kd_dokter = $this->core->getRegPeriksaInfo('kd_dokter', revertNoRawat($no_rawat));
        $no_rkm_medis = $this->core->getRegPeriksaInfo('no_rkm_medis', revertNoRawat($no_rawat));
        $pasien = $this->db('pasien')
          ->join('kelurahan', 'kelurahan.kd_kel=pasien.kd_kel')
          ->join('kecamatan', 'kecamatan.kd_kec=pasien.kd_kec')
          ->join('kabupaten', 'kabupaten.kd_kab=pasien.kd_kab')
          ->join('propinsi', 'propinsi.kd_prop=pasien.kd_prop')
          ->where('no_rkm_medis', $no_rkm_medis)
          ->oneArray();
        $nm_dokter = $this->core->getPegawaiInfo('nama', $kd_dokter);
        $sip_dokter = $this->core->getDokterInfo('no_ijn_praktek', $kd_dokter);
        $this->tpl->set('pasien', $this->tpl->noParse_array(htmlspecialchars_array($pasien)));
        $this->tpl->set('nm_dokter', $nm_dokter);
        $this->tpl->set('sip_dokter', $sip_dokter);
        $this->tpl->set('no_rawat', revertNoRawat($no_rawat));
        $this->tpl->set('settings', $this->tpl->noParse_array(htmlspecialchars_array($this->settings('settings'))));
        $this->tpl->set('surat', $this->db('mlite_surat_sehat')->where('no_rawat', revertNoRawat($no_rawat))->oneArray());
        echo $this->tpl->draw(MODULES.'/rawat_inap/view/admin/surat.sehat.html', true);
        exit();
    }
  
  	public function getSuratSakit($no_rawat)
    {
        $no_rawat = revertNoRawat($no_rawat);

        $dpjp = $this->db('dpjp_ranap')->where('no_rawat', $no_rawat)->oneArray();

        if (!empty($dpjp)) {
            $kd_dokter = $dpjp['kd_dokter'];
        } else {
            $kd_dokter = $this->core->getRegPeriksaInfo('kd_dokter', $no_rawat);
        }

        $no_rkm_medis = $this->core->getRegPeriksaInfo('no_rkm_medis', $no_rawat);

        $pasien = $this->db('pasien')
            ->join('kelurahan', 'kelurahan.kd_kel=pasien.kd_kel')
            ->join('kecamatan', 'kecamatan.kd_kec=pasien.kd_kec')
            ->join('kabupaten', 'kabupaten.kd_kab=pasien.kd_kab')
            ->join('propinsi', 'propinsi.kd_prop=pasien.kd_prop')
            ->where('no_rkm_medis', $no_rkm_medis)
            ->oneArray();

        $nm_dokter = $this->core->getPegawaiInfo('nama', $kd_dokter);
        $sip_dokter = $this->core->getDokterInfo('no_ijn_praktek', $kd_dokter);

        $this->tpl->set('pasien', $this->tpl->noParse_array(htmlspecialchars_array($pasien)));
        $this->tpl->set('nm_dokter', $nm_dokter);
        $this->tpl->set('sip_dokter', $sip_dokter);
        $this->tpl->set('no_rawat', $no_rawat);
        $this->tpl->set('settings', $this->tpl->noParse_array(htmlspecialchars_array($this->settings('settings'))));
        $this->tpl->set('surat', $this->db('mlite_surat_sakit')->where('no_rawat', $no_rawat)->oneArray());

        echo $this->tpl->draw(MODULES . '/rawat_inap/view/admin/surat.sakit.html', true);
        exit();
    }

    /*public function getSuratSakit($no_rawat)
    {
        $kd_dokter = $this->core->getRegPeriksaInfo('kd_dokter', revertNoRawat($no_rawat));
        $no_rkm_medis = $this->core->getRegPeriksaInfo('no_rkm_medis', revertNoRawat($no_rawat));
        $pasien = $this->db('pasien')
          ->join('kelurahan', 'kelurahan.kd_kel=pasien.kd_kel')
          ->join('kecamatan', 'kecamatan.kd_kec=pasien.kd_kec')
          ->join('kabupaten', 'kabupaten.kd_kab=pasien.kd_kab')
          ->join('propinsi', 'propinsi.kd_prop=pasien.kd_prop')
          ->where('no_rkm_medis', $no_rkm_medis)
          ->oneArray();
        $nm_dokter = $this->core->getPegawaiInfo('nama', $kd_dokter);
        $sip_dokter = $this->core->getDokterInfo('no_ijn_praktek', $kd_dokter);
        $this->tpl->set('pasien', $this->tpl->noParse_array(htmlspecialchars_array($pasien)));
        $this->tpl->set('nm_dokter', $nm_dokter);
        $this->tpl->set('sip_dokter', $sip_dokter);
        $this->tpl->set('no_rawat', revertNoRawat($no_rawat));
        $this->tpl->set('settings', $this->tpl->noParse_array(htmlspecialchars_array($this->settings('settings'))));
        $this->tpl->set('surat', $this->db('mlite_surat_sakit')->where('no_rawat', revertNoRawat($no_rawat))->oneArray());
        echo $this->tpl->draw(MODULES.'/rawat_inap/view/admin/surat.sakit.html', true);
        exit();
    }*/

    public function postSimpanSuratSakit()
    {
      $query = $this->db('mlite_surat_sakit')->save([
        'id' => NULL, 
        'nomor_surat' => $_POST['nomor_surat'], 
        'no_rawat' => $_POST['no_rawat'], 
        'no_rkm_medis' => $_POST['no_rkm_medis'], 
        'nm_pasien' => $_POST['nm_pasien'], 
        'tgl_lahir' => $_POST['tgl_lahir'], 
        'umur' => $_POST['umur'], 
        'jk' => $_POST['jk'], 
        'alamat' => $_POST['alamat'], 
        'keadaan' => $_POST['keadaan'], 
        'diagnosa' => $_POST['diagnosa'], 
        'lama_angka' => $_POST['lama_angka'], 
        'lama_huruf' => $_POST['lama_huruf'], 
        'tanggal_mulai' => $_POST['tanggal_mulai'], 
        'tanggal_selesai' => $_POST['tanggal_selesai'], 
        'dokter' => $_POST['dokter'], 
        'petugas' => $_POST['petugas']
      ]);

      if($query) {
        $data['status'] = 'success';
        echo json_encode($data);
      } else {
        $data['status'] = 'error';
        $data['msg'] = $query->errorInfo()['2'];
        echo json_encode($data);
      }

      exit();
    }

    public function postSimpanSuratSehat()
    {
      $query = $this->db('mlite_surat_sehat')->save([
        'id' => NULL, 
        'nomor_surat' => $_POST['nomor_surat'], 
        'no_rawat' => $_POST['no_rawat'], 
        'no_rkm_medis' => $_POST['no_rkm_medis'], 
        'nm_pasien' => $_POST['nm_pasien'], 
        'tgl_lahir' => $_POST['tgl_lahir'], 
        'umur' => $_POST['umur'], 
        'jk' => $_POST['jk'], 
        'alamat' => $_POST['alamat'], 
        'tanggal' => $_POST['tanggal'], 
        'berat_badan' => $_POST['berat_badan'], 
        'tinggi_badan' => $_POST['tinggi_badan'], 
        'tensi' => $_POST['tensi'], 
        'gol_darah' => $_POST['gol_darah'], 
        'riwayat_penyakit' => $_POST['riwayat_penyakit'], 
        'keperluan' => $_POST['keperluan'], 
        'dokter' => $_POST['dokter'], 
        'petugas' => $_POST['petugas']
      ]);

      if($query) {
        $data['status'] = 'success';
        echo json_encode($data);
      } else {
        $data['status'] = 'error';
        $data['msg'] = $query->errorInfo()['2'];
        echo json_encode($data);
      }

      exit();
    }

    public function postSimpanSuratRujukan()
    {
      $query = $this->db('mlite_surat_rujukan')->save([
        'id' => NULL, 
        'nomor_surat' => $_POST['nomor_surat'], 
        'no_rawat' => $_POST['no_rawat'], 
        'no_rkm_medis' => $_POST['no_rkm_medis'], 
        'nm_pasien' => $_POST['nm_pasien'], 
        'tgl_lahir' => $_POST['tgl_lahir'], 
        'umur' => $_POST['umur'], 
        'jk' => $_POST['jk'], 
        'alamat' => $_POST['alamat'], 
        'kepada' => $_POST['kepada'], 
        'di' => $_POST['di'], 
        'anamnesa' => $_POST['anamnesa'], 
        'pemeriksaan_fisik' => $_POST['pemeriksaan_fisik'], 
        'pemeriksaan_penunjang' => $_POST['pemeriksaan_penunjang'], 
        'diagnosa' => $_POST['diagnosa'], 
        'terapi' => $_POST['terapi'], 
        'alasan_dirujuk' => $_POST['alasan_dirujuk'], 
        'dokter' => $_POST['dokter'], 
        'petugas' => $_POST['petugas']
      ]);

      if($query) {
        $data['status'] = 'success';
        echo json_encode($data);
      } else {
        $data['status'] = 'error';
        $data['msg'] = $query->errorInfo()['2'];
        echo json_encode($data);
      }

      exit();
    }

    public function anyKontrol()
    {
      $rows = $this->db('booking_registrasi')
        ->join('poliklinik', 'poliklinik.kd_poli=booking_registrasi.kd_poli')
        ->join('dokter', 'dokter.kd_dokter=booking_registrasi.kd_dokter')
        ->join('penjab', 'penjab.kd_pj=booking_registrasi.kd_pj')
        ->where('no_rkm_medis', $_POST['no_rkm_medis'])
        ->toArray();
      $i = 1;
      $result = [];
      foreach ($rows as $row) {
        $row['nomor'] = $i++;
        $result[] = $row;
      }
      echo $this->draw('kontrol.html', ['booking_registrasi' => $result]);
      exit();
    }

    public function postSaveKontrol()
    {

      $query = $this->db('skdp_bpjs')->save([
        'tahun' => date('Y'),
        'no_rkm_medis' => $_POST['no_rkm_medis'],
        'diagnosa' => $_POST['diagnosa'],
        'terapi' => $_POST['terapi'],
        'alasan1' => $_POST['alasan1'],
        'alasan2' => '',
        'rtl1' => $_POST['rtl1'],
        'rtl2' => '',
        'tanggal_datang' => $_POST['tanggal_datang'],
        'tanggal_rujukan' => $_POST['tanggal_rujukan'],
        'no_antrian' => $this->core->setNoSKDP(),
        'kd_dokter' => $this->core->getRegPeriksaInfo('kd_dokter', $_POST['no_rawat']),
        'status' => 'Menunggu'
      ]);

      if ($query) {
        $this->db('booking_registrasi')
          ->save([
            'tanggal_booking' => date('Y-m-d'),
            'jam_booking' => date('H:i:s'),
            'no_rkm_medis' => $_POST['no_rkm_medis'],
            'tanggal_periksa' => $_POST['tanggal_datang'],
            'kd_dokter' => $this->core->getRegPeriksaInfo('kd_dokter', $_POST['no_rawat']),
            'kd_poli' => $this->core->getRegPeriksaInfo('kd_poli', $_POST['no_rawat']),
            'no_reg' => $this->core->setNoBooking($this->core->getRegPeriksaInfo('kd_dokter', $_POST['no_rawat']), $_POST['tanggal_datang'], $this->core->getRegPeriksaInfo('kd_poli', $_POST['no_rawat'])),
            'kd_pj' => $this->core->getRegPeriksaInfo('kd_pj', $_POST['no_rawat']),
            'limit_reg' => 0,
            'waktu_kunjungan' => $_POST['tanggal_datang'].' '.date('H:i:s'),
            'status' => 'Belum'
          ]);
      }

      exit();
    }

    //========observasi Persalinan
/*
 public function getObservasiPersalinan($no_rawat)
    {
        $kd_dokter = $this->core->getRegPeriksaInfo('kd_dokter', revertNoRawat($no_rawat));
        $no_rkm_medis = $this->core->getRegPeriksaInfo('no_rkm_medis', revertNoRawat($no_rawat));
        $pasien = $this->db('pasien')
          ->join('kelurahan', 'kelurahan.kd_kel=pasien.kd_kel')
          ->join('kecamatan', 'kecamatan.kd_kec=pasien.kd_kec')
          ->join('kabupaten', 'kabupaten.kd_kab=pasien.kd_kab')
          ->join('propinsi', 'propinsi.kd_prop=pasien.kd_prop')
          ->where('no_rkm_medis', $no_rkm_medis)
          ->oneArray();
        $nm_dokter = $this->core->getPegawaiInfo('nama', $kd_dokter);
        $sip_dokter = $this->core->getDokterInfo('no_ijn_praktek', $kd_dokter);
        $this->tpl->set('pasien', $this->tpl->noParse_array(htmlspecialchars_array($pasien)));
        $this->tpl->set('nm_dokter', $nm_dokter);
        $this->tpl->set('sip_dokter', $sip_dokter);
        $this->tpl->set('no_rawat', revertNoRawat($no_rawat));
        $this->tpl->set('settings', $this->tpl->noParse_array(htmlspecialchars_array($this->settings('settings'))));
        //$this->tpl->set('pemeriksaan_ralan', $this->db('pemeriksaan_ralan')->where('no_rawat', revertNoRawat($no_rawat))->join('petugas', 'petugas.nip=pemeriksaan_ralan.nip')->toArray());
        $this->tpl->set('pemeriksaan_ranap', $this->db('pemeriksaan_ranap')->where('pemeriksaan_ranap.no_rawat', revertNoRawat($no_rawat))->join('petugas', 'petugas.nip=pemeriksaan_ranap.nip')->join('catatan_observasi_ranap_kebidanan', 'catatan_observasi_ranap_kebidanan.no_rawat=pemeriksaan_ranap.no_rawat')->toArray());
        echo $this->tpl->draw(MODULES.'/rawat_inap/view/admin/observasi.persalinan.html', true);
        exit();
    }
*/
public function getObservasiPersalinan($no_rawat)
{
    // Ambil data dokter dan pasien
    $kd_dokter = $this->core->getRegPeriksaInfo('kd_dokter', revertNoRawat($no_rawat));
    $no_rkm_medis = $this->core->getRegPeriksaInfo('no_rkm_medis', revertNoRawat($no_rawat));

    $pasien = $this->db('pasien')
        ->join('kelurahan', 'kelurahan.kd_kel=pasien.kd_kel')
        ->join('kecamatan', 'kecamatan.kd_kec=pasien.kd_kec')
        ->join('kabupaten', 'kabupaten.kd_kab=pasien.kd_kab')
        ->join('propinsi', 'propinsi.kd_prop=pasien.kd_prop')
        ->where('no_rkm_medis', $no_rkm_medis)
        ->oneArray();

    $nm_dokter = $this->core->getPegawaiInfo('nama', $kd_dokter);
    $sip_dokter = $this->core->getDokterInfo('no_ijn_praktek', $kd_dokter);

    // Kirim variabel ke template
    $this->tpl->set('pasien', $this->tpl->noParse_array(htmlspecialchars_array($pasien)));
    $this->tpl->set('nm_dokter', $nm_dokter);
    $this->tpl->set('sip_dokter', $sip_dokter);
    $this->tpl->set('no_rawat', revertNoRawat($no_rawat));
    $this->tpl->set('settings', $this->tpl->noParse_array(htmlspecialchars_array($this->settings('settings'))));

    // Ambil parameter tanggal, default hari ini
    $tgl_awal  = isset($_GET['dari'])   ? $_GET['dari']   : date('Y-m-d');
    $tgl_akhir = isset($_GET['sampai']) ? $_GET['sampai'] : date('Y-m-d');

    // Ambil parameter pencarian opsional
    $search_field = isset($_GET['search_field']) ? $_GET['search_field'] : '';
    $search_text  = isset($_GET['search_text'])  ? $_GET['search_text']  : '';

    // Bangun query dasar
    $searchQuery = " AND pemeriksaan_ranap.no_rawat = '".revertNoRawat($no_rawat)."'";

    // Jika ada pencarian, tambahkan filter LIKE
    if (!empty($search_field) && !empty($search_text)) {
        $searchQuery .= " AND ($search_field LIKE '%$search_text%')";
    }

    // Filter tanggal
    if (!empty($tgl_awal) && !empty($tgl_akhir)) {
        $searchQuery .= " AND pemeriksaan_ranap.tgl_perawatan BETWEEN '".$tgl_awal."' AND '".$tgl_akhir."'";
    }

    // Query ambil data pemeriksaan
    $sql = "
        SELECT pemeriksaan_ranap.*, petugas.nama AS nama_petugas, catatan_observasi_ranap_kebidanan.*
        FROM pemeriksaan_ranap
        LEFT JOIN petugas ON petugas.nip = pemeriksaan_ranap.nip
        LEFT JOIN catatan_observasi_ranap_kebidanan ON catatan_observasi_ranap_kebidanan.no_rawat = pemeriksaan_ranap.no_rawat
        WHERE 1 {$searchQuery}
        ORDER BY pemeriksaan_ranap.tgl_perawatan ASC
    ";

    // Eksekusi query
    $stmt = $this->db()->pdo()->prepare($sql);
    $stmt->execute();
    $pemeriksaan = $stmt->fetchAll(\PDO::FETCH_ASSOC);

    // Kirim hasil ke template
    $this->tpl->set('pemeriksaan_ranap', $pemeriksaan);

    // Render view
    echo $this->tpl->draw(MODULES.'/rawat_inap/view/admin/observasi.persalinan.html', true);
    exit();
}


    public function getPersalinan($no_rawat)
    {
      $persalinan = $this->core->db('pemeriksaan_ranap')
        ->where('no_rawat', revertNoRawat($no_rawat))
        ->oneArray();
        return $this->draw('observasi.persalinan.html', [
          'persalinan' => $persalinan
        ]);
    }
//=============================

    public function postSaveKontrolBPJS()
    {

      date_default_timezone_set('UTC');
      $tStamp = strval(time() - strtotime("1970-01-01 00:00:00"));
      $key = $this->consid . $this->secretkey . $tStamp;
      $_POST['sep_user']  = $this->core->getUserInfo('fullname', null, true);

      $maping_dokter_dpjpvclaim = $this->db('maping_dokter_dpjpvclaim')->where('kd_dokter', $this->core->getRegPeriksaInfo('kd_dokter', $_POST['no_rawat']))->oneArray();
      $maping_poli_bpjs = $this->db('maping_poli_bpjs')->where('kd_poli_rs', $this->core->getRegPeriksaInfo('kd_poli', $_POST['no_rawat']))->oneArray();
      $get_sep = $this->db('bridging_sep')->where('no_rawat', $_POST['no_rawat'])->oneArray();
      $_POST['no_sep'] = $get_sep['no_sep'];
      $get_sep_internal = $this->db('bridging_sep_internal')->where('no_rawat', $_POST['no_rawat'])->oneArray();

      if(empty($get_sep['no_sep'])) {
        $_POST['no_sep'] = $get_sep_internal['no_sep'];
      }

      $data = [
        'request' => [
          'noSEP' => $_POST['no_sep'],
          'kodeDokter' => $maping_dokter_dpjpvclaim['kd_dokter_bpjs'],
          'poliKontrol' => $maping_poli_bpjs['kd_poli_bpjs'],
          'tglRencanaKontrol' => $_POST['tanggal_datang'],
          'user' => $_POST['sep_user']
        ]
      ];
      $statusUrl = 'insert';
      $method = 'post';

      $data = json_encode($data);

      $url = $this->api_url . 'RencanaKontrol/' . $statusUrl;
      $output = BpjsService::$method($url, $data, $this->consid, $this->secretkey, $this->user_key, $tStamp);
      $data = json_decode($output, true);
      //echo $data['metaData']['message'];
      if ($data == NULL) {
        echo 'Koneksi ke server BPJS terputus. Silahkan ulangi beberapa saat lagi!';
      } else if ($data['metaData']['code'] == 200) {
        $stringDecrypt = stringDecrypt($key, $data['response']);
        $decompress = '""';
        $decompress = \LZCompressor\LZString::decompressFromEncodedURIComponent(($stringDecrypt));
        $spri = json_decode($decompress, true);
        //echo $spri['noSuratKontrol'];

        $bridging_surat_pri_bpjs = $this->db('bridging_surat_kontrol_bpjs')->save([
          'no_sep' => $_POST['no_sep'],
          'tgl_surat' => $_POST['tanggal_rujukan'],
          'no_surat' => $spri['noSuratKontrol'],
          'tgl_rencana' => $_POST['tanggal_datang'],
          'kd_dokter_bpjs' => $maping_dokter_dpjpvclaim['kd_dokter_bpjs'],
          'nm_dokter_bpjs' => $maping_dokter_dpjpvclaim['nm_dokter_bpjs'],
          'kd_poli_bpjs' => $maping_poli_bpjs['kd_poli_bpjs'],
          'nm_poli_bpjs' => $maping_poli_bpjs['nm_poli_bpjs']
        ]);

      }

      exit();
    }

    public function postHapusKontrol()
    {
      $this->db('booking_registrasi')->where('kd_dokter', $_POST['kd_dokter'])->where('no_rkm_medis', $_POST['no_rkm_medis'])->where('tanggal_periksa', $_POST['tanggal_periksa'])->where('status', 'Belum')->delete();
      $this->db('skdp_bpjs')->where('kd_dokter', $_POST['kd_dokter'])->where('no_rkm_medis', $_POST['no_rkm_medis'])->where('tanggal_datang', $_POST['tanggal_periksa'])->where('status', 'Menunggu')->delete();
      exit();
    }

    public function getPersetujuanUmum($no_rkm_medis)
    {
      $settings = $this->settings('settings');
      $this->tpl->set('settings', $this->tpl->noParse_array(htmlspecialchars_array($settings)));
      $pasien = $this->db('pasien')->where('no_rkm_medis', $no_rkm_medis)->oneArray();
      echo $this->draw('persetujuan.umum.html', ['pasien' => $pasien]);
      exit();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $cek_pegawai = $this->db('pegawai')->where('nik', $this->core->getUserInfo('username', $_SESSION['mlite_user']))->oneArray();
        $cek_role = '';
        if($cek_pegawai) {
          $cek_role = $this->core->getPegawaiInfo('nik', $this->core->getUserInfo('username', $_SESSION['mlite_user']));
        }
        echo $this->draw(MODULES.'/rawat_inap/js/admin/rawat_inap.js', ['cek_role' => $cek_role]);
        exit();
    }

    private function _addHeaderFiles()
    {
        $this->core->addCSS(url('assets/css/dataTables.bootstrap.min.css'));
        $this->core->addJS(url('assets/jscripts/jquery.dataTables.min.js'));
        $this->core->addJS(url('assets/jscripts/dataTables.bootstrap.min.js'));
        $this->core->addJS(url('assets/jscripts/lightbox/lightbox.min.js'));
        $this->core->addCSS(url('assets/jscripts/lightbox/lightbox.min.css'));
        $this->core->addCSS(url('assets/css/bootstrap-datetimepicker.css'));
        $this->core->addJS(url('assets/jscripts/moment-with-locales.js'));
        $this->core->addJS(url('assets/jscripts/bootstrap-datetimepicker.js'));
        $this->core->addJS(url([ADMIN, 'rawat_inap', 'javascript']), 'footer');
    }

}
