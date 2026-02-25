<?php

namespace Plugins\Data_Analys;

use Systems\AdminModule;

class Admin extends AdminModule
{
    public function navigation()
    {
        return [
            'Kelola' => 'manage',
            'Data BOR' => 'bor',
            'Data LOS' => 'loss',
            'Kunjungan RS' => 'kunjungan rs'
        ];
    }

    public function getManage()
    {
        $sub_modules = [
            ['name' => 'Data BOR', 'url' => url([ADMIN, 'data_analys', 'display']), 'icon' => 'list', 'desc' => 'Data Bor RS'],
            ['name' => 'Data LOS', 'url' => url([ADMIN, 'data_analys', 'loss']), 'icon' => 'pie-chart', 'desc' => 'Data Los RS'],
            ['name' => 'Data Kunjungan RS', 'url' => url([ADMIN, 'kunjungan_ralan', 'manage']), 'icon' => 'line-chart', 'desc' => 'Data Kunjungan RS'],
        ];
        return $this->draw('manage.html', ['sub_modules' => $sub_modules]);
    }

    public function anyBor()
    {
        //$this->_addHeaderFiles();
        $tgl_kunjungan = 2025 - 10 - 1;
        $tgl_kunjungan_akhir = 2025 - 10 - 30;


        if (isset($_POST['tgl_awal'])) {
            $tgl_kunjungan = $_POST['tgl_awal'];
        }
        if (isset($_POST['tgl_akhir'])) {
            $tgl_kunjungan_akhir = $_POST['tgl_akhir'];
        }

        //$this->_Display($tgl_kunjungan, $tgl_kunjungan_akhir);
        echo $this->draw('bor.html', [
            'jumlah' => $kamarinap
        ]);
    }

    public function anyDisplay()
    {
        //$this->_addHeaderFiles();
        $tgl_kunjungan = date('Y-m-d');
        $tgl_kunjungan_akhir = date('Y-m-d');




        if (isset($_POST['tgl_awal'])) {
            $tgl_kunjungan = $_POST['tgl_awal'];
        }
        if (isset($_POST['tgl_akhir'])) {
            $tgl_kunjungan_akhir = $_POST['tgl_akhir'];
        }



        $kamarinap = $this->db('kamar_inap')->where('tgl_masuk', '>=', $tgl_kunjungan)->where('tgl_masuk', '<=', $tgl_kunjungan_akhir)->toArray();
        //$this->db('mlite_vedika')->where('status', 'Lengkap')->where('tgl_registrasi','>=',$start_date)->where('tgl_registrasi','<=', $end_date)->toArray();
        //$this->_Display($tgl_kunjungan, $tgl_kunjungan_akhir);
        $this->_addHeaderFiles();
        return $this->draw('bor.html', [
            'jumlah' => $kamarinap
        ]);
    }

    public function anyJisplay()
    {
        //$this->_addHeaderFiles();
        $tgl_awal = date('Y-m-d');
        $tgl_akhir = date('Y-m-d');


        if (isset($_POST['tgl_awal'])) {
            $tgl_awal = $_POST['tgl_awal'];
        }
        if (isset($_POST['tgl_akhir'])) {
            $tgl_akhir = $_POST['tgl_akhir'];
        }

        if ($tgl_akhir < $tgl_awal) {
            echo "<h1><center>Tanggal Salah , tanggal akhir harus lebih besar daripada tanggal awal!</center></h1>";
            exit();
        }
      
      
		$jmlkamar = $this->db('kamar')->where('statusdata', '1')->count();
        $kamarinap = $this->db('kamar_inap')
            ->join('reg_periksa', 'kamar_inap.no_rawat=reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis=pasien.no_rkm_medis')
          	->join('kamar','kamar_inap.kd_kamar=kamar.kd_kamar')
            ->where('tgl_masuk', '>=', $tgl_awal)
            ->where('tgl_masuk', '<=', $tgl_akhir)
            ->toArray();

        $totallamainap = 0;
        $selisih       = (strtotime($tgl_akhir) - strtotime($tgl_awal)) / (60 * 60 * 24) + 1;

        foreach ($kamarinap as $k) {
            $lamainap = $k['lama'];
            // $hari = $k['tgl_masuk'];

            $hasil = $totallamainap += $lamainap;
            //$dino = $totallamainap++;



        }

        $bor = ($hasil / ($jmlkamar * $selisih)) * 100;

        $this->_addHeaderFiles();
        echo $this->draw('displaybor.html', [
            'jumlah' => $kamarinap,
            'no' => $selisih,
            'bor' => round($bor, 2),
          	'jmlkamar' => $jmlkamar,
            'hasil' => $hasil
        ]);
        exit();
    }

    public function anyLoss()
    {
        //$this->_addHeaderFiles();
        $tgl_kunjungan = date('Y-m-d');
        $tgl_kunjungan_akhir = date('Y-m-d');




        if (isset($_POST['tgl_awal'])) {
            $tgl_kunjungan = $_POST['tgl_awal'];
        }
        if (isset($_POST['tgl_akhir'])) {
            $tgl_kunjungan_akhir = $_POST['tgl_akhir'];
        }


        $kondisikeluar = "Pindah Kamar";
        $kamarinap = $this->db('kamar_inap')->where('tgl_keluar', '>=', $tgl_kunjungan)->where('tgl_keluar', '<=', $tgl_kunjungan_akhir)->toArray();
        $pulang = $this->db('kamar_inap')->where('tgl_keluar', '>=', $tgl_kunjungan)->where('tgl_keluar', '<=', $tgl_kunjungan_akhir)->where('stts_pulang', !$kondisikeluar)->toArray();



        $this->_addHeaderFiles();
        return $this->draw('los.html', [
            'jumlah' => $kamarinap
        ]);
    }

    public function anyJisplayLos()
    {
        $tgl_awal  = date('Y-m-d');
        $tgl_akhir = date('Y-m-d');

        if (isset($_POST['tgl_awal'])) {
            $tgl_awal = $_POST['tgl_awal'];
        }
        if (isset($_POST['tgl_akhir'])) {
            $tgl_akhir = $_POST['tgl_akhir'];
        }

        // ✅ Validasi tanggal
        if ($tgl_akhir < $tgl_awal) {
            echo "<h1><center>Tanggal salah, tanggal akhir harus lebih besar daripada tanggal awal!</center></h1>";
            exit();
        }

        // ✅ Gunakan operator not equal dengan benar
        $kondisikeluar = "Pindah Kamar";

        // Ambil semua pasien kamar inap dalam rentang tanggal
        $kamarinap = $this->db('kamar_inap')
            ->join('reg_periksa', 'kamar_inap.no_rawat=reg_periksa.no_rawat')
            ->join('pasien', 'reg_periksa.no_rkm_medis=pasien.no_rkm_medis')
            ->where('tgl_masuk', '>=', $tgl_awal)
            ->where('tgl_masuk', '<=', $tgl_akhir)
          	//->where('stts_pulang', '!=', $kondisikeluar)
            ->toArray();

        // Ambil pasien pulang (bukan pindah kamar)
        $pulang = $this->db('kamar_inap')
            ->where('tgl_masuk', '>=', $tgl_awal)
            ->where('tgl_masuk', '<=', $tgl_akhir)
            ->where('stts_pulang', '!=', $kondisikeluar) // ✅ bukan '!', tapi '!='
            ->toArray();

        // ✅ Hitung jumlah hari perawatan
        $totallamainap = 0;
        foreach ($kamarinap as $k) {
            $lamainap = (int) $k['lama']; // pastikan tipe numerik
            $totallamainap += $lamainap;
        }

        // ✅ Hitung jumlah pasien pulang
        $hitung = 0;
        foreach ($pulang as $p) {
            $pasienpulang = $p['stts_pulang'];
            $hitung++;
        }

        $hitungakhir = $hitung;

        // ✅ Hindari pembagian nol
        if ($hitungakhir > 0) {
            $los = $totallamainap / $hitungakhir;
        } else {
            $los = 0;
        }

        // ✅ Selisih hari dihitung benar (bukan operasi antar string)
        $selisih = (strtotime($tgl_akhir) - strtotime($tgl_awal)) / (60 * 60 * 24) + 1;

        // Debug
        // var_dump($hitungakhir, $totallamainap, $los);

        $this->_addHeaderFiles();
        echo $this->draw('displaylos.html', [
            'jumlah'     => $kamarinap,
            'selisih'    => $selisih,
            'los'        => round($los, 2),
            'pulang'     => $hitungakhir,
            'harirawat'  => $totallamainap
        ]);
        exit();
    }


    public function _Display($tgl_kunjungan, $tgl_kunjungan_akhir)
    {
        $this->_addHeaderFiles();

        $kamarinap = $this->db('kamar_inap')->where('tgl_masuk', '>=', $tgl_kunjungan)->where('tgl_masuk', '<=', $tgl_kunjungan_akhir)->toArray();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        echo $this->draw(MODULES . '/data_analys/js/admin/data_analys.js');
        exit();
    }

    private function _addHeaderFiles()
    {
        // CSS
        $this->core->addCSS(url('assets/css/jquery-ui.css'));

        $this->core->addCSS(url('assets/css/dataTables.bootstrap.min.css'));

        // JS
        $this->core->addJS(url('assets/jscripts/jquery.dataTables.min.js'), 'footer');
        $this->core->addJS(url('assets/jscripts/dataTables.bootstrap.min.js'), 'footer');

        $this->core->addCSS(url('assets/css/bootstrap-datetimepicker.css'));
        $this->core->addJS(url('assets/jscripts/moment-with-locales.js'));
        $this->core->addJS(url('assets/jscripts/bootstrap-datetimepicker.js'));

        // MODULE SCRIPTS
        //$this->core->addCSS(url([ADMIN, 'data_analys', 'css']));
        $this->core->addJS(url([ADMIN, 'data_analys', 'javascript']), 'footer');
    }
}
