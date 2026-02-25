<?php

namespace Plugins\Kunjungan_Ralan;

use Systems\AdminModule;

class Admin extends AdminModule
{

    public function navigation()
    {
        return [
            'Kelola'   => 'manage',
        ];
    }

    public function anyManage()
    {
        $tgl_kunjungan = date('Y-m-d');
        $tgl_kunjungan_akhir = date('Y-m-d');
        $status_periksa = '';
        

        if (isset($_POST['periode_rawat_jalan'])) {
            $tgl_kunjungan = $_POST['periode_rawat_jalan'];
        }
        if (isset($_POST['periode_rawat_jalan_akhir'])) {
            $tgl_kunjungan_akhir = $_POST['periode_rawat_jalan_akhir'];
        }
        if (isset($_POST['status_periksa'])) {
            $status_periksa = $_POST['status_periksa'];
        }
        // $cek_vclaim = $this->db('mlite_modules')->where('dir', 'vclaim')->oneArray();
        $this->_Display($tgl_kunjungan, $tgl_kunjungan_akhir, $status_periksa);
        return $this->draw('manage.html', [
            'poli'  => $this->db('poliklinik')->where('status', '1')->toArray(),
            'rawat_jalan' => $this->assign
        ]);
    }

    public function anyDisplay()
    {
        $tgl_kunjungan = date('Y-m-d');
        $tgl_kunjungan_akhir = date('Y-m-d');
        $status_periksa = '';

        if (isset($_POST['periode_rawat_jalan'])) {
            $tgl_kunjungan = $_POST['periode_rawat_jalan'];
        }
        if (isset($_POST['periode_rawat_jalan_akhir'])) {
            $tgl_kunjungan_akhir = $_POST['periode_rawat_jalan_akhir'];
        }
        if (isset($_POST['status_periksa'])) {
            $status_periksa = $_POST['status_periksa'];
        }
        // if (isset($_POST['poli'])) {
        //     $poli = $_POST['poli'];
        // }
        //$cek_vclaim = $this->db('mlite_modules')->where('dir', 'vclaim')->oneArray();
        $this->_Display($tgl_kunjungan, $tgl_kunjungan_akhir, $status_periksa);
        echo $this->draw('display.html', [
            'rawat_jalan' => $this->assign
        ]);
        exit();
    }

    public function _Display($tgl_kunjungan, $tgl_kunjungan_akhir, $status_periksa = '')
    {
        $this->_addHeaderFiles();

        if (isset($_POST['poli'])) {
            $poli = $_POST['poli'];
        }
        $this->assign['poliklinik']     = $this->db('poliklinik')->where('status', '1')->toArray();
        $this->assign['dokter']         = $this->db('dokter')->where('status', '1')->toArray();
        $this->assign['penjab']       = $this->db('penjab')->where('status', '1')->toArray();
        $this->assign['no_rawat'] = '';
        $this->assign['no_reg']     = '';
        $this->assign['tgl_registrasi'] = date('Y-m-d');
        $this->assign['jam_reg'] = date('H:i:s');
      
        $sql = "
                SELECT 
                  reg_periksa.*,
                  pasien.*,
                  poliklinik.*,
                  penjab.*,
                  kecamatan.nm_kec,
                  dokter.nm_dokter AS dokter_pemeriksa,
                  dokter_dpjp.nm_dokter AS dokter_dpjp
                FROM reg_periksa
                JOIN pasien ON reg_periksa.no_rkm_medis = pasien.no_rkm_medis
                JOIN dokter ON reg_periksa.kd_dokter = dokter.kd_dokter
                JOIN poliklinik ON reg_periksa.kd_poli = poliklinik.kd_poli
                JOIN penjab ON reg_periksa.kd_pj = penjab.kd_pj
                LEFT JOIN dpjp_ranap AS dpjp ON reg_periksa.no_rawat = dpjp.no_rawat
                LEFT JOIN dokter AS dokter_dpjp ON dpjp.kd_dokter = dokter_dpjp.kd_dokter
                LEFT JOIN kecamatan ON pasien.kd_kec = kecamatan.kd_kec
                WHERE reg_periksa.tgl_registrasi BETWEEN '$tgl_kunjungan' AND '$tgl_kunjungan_akhir'
                  AND reg_periksa.stts != 'Batal'
                ";
      
        if ($status_periksa == 'Ralan') {
            $sql .= " AND reg_periksa.status_lanjut = 'Ralan'";
        }
        if ($status_periksa == 'Ranap') {
            $sql .= " AND reg_periksa.status_lanjut = 'Ranap'";
        }
        if (!empty($_POST['poli'])) {
            // Jika user memilih poli tertentu
            $poli = $_POST['poli'];
            $sql .= " AND reg_periksa.kd_poli = '$poli'";
        } else {
            // Jika user tidak memilih apa pun (kosong)
            $sql .= " AND reg_periksa.kd_poli != ''";
        }

        // if($status_periksa == 'lunas') {
        //   $sql .= " AND reg_periksa.status_bayar = 'Sudah Bayar'";
        // }

        $stmt = $this->db()->pdo()->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll();

        $this->assign['list'] = [];
        foreach ($rows as $row) {
            $this->assign['list'][] = $row;
        }
    }
  
  	public function anyChartData()
    {
        header('Content-Type: application/json');

        $tgl_kunjungan = $_POST['periode_rawat_jalan'] ?? null;
    	$tgl_kunjungan_akhir = $_POST['periode_rawat_jalan_akhir'] ?? null;
        $status_periksa = $_POST['status_periksa'] ?? 'Ralan';
        $poli = $_POST['poli'] ?? '';
      
        if ($tgl_kunjungan == '' || $tgl_kunjungan_akhir == '') {
            $tgl_kunjungan = date('Y-m-d');
        	$tgl_kunjungan_akhir = date('Y-m-d');
        }

        // Mode default: rekap per poli
        if ($poli == '') {
            $sql = "
                SELECT 
                    poliklinik.nm_poli,
                    COUNT(reg_periksa.no_rawat) AS jumlah_kunjungan
                FROM reg_periksa
                JOIN poliklinik ON reg_periksa.kd_poli = poliklinik.kd_poli
                WHERE reg_periksa.tgl_registrasi BETWEEN :tgl1 AND :tgl2
                AND reg_periksa.stts != 'Batal'
            ";

            if ($status_periksa == 'Ralan') {
                $sql .= " AND reg_periksa.status_lanjut = 'Ralan'";
            } elseif ($status_periksa == 'Ranap') {
                $sql .= " AND reg_periksa.status_lanjut = 'Ranap'";
            }

            $sql .= " GROUP BY poliklinik.kd_poli";

            $stmt = $this->db()->pdo()->prepare($sql);
            $stmt->execute([':tgl1' => $tgl_kunjungan, ':tgl2' => $tgl_kunjungan_akhir]);
            $rows = $stmt->fetchAll();

            $labels = [];
            $values = [];

            foreach ($rows as $row) {
                $start = date('d M Y', strtotime($row[':tgl1']));
                $end = date('d M Y', strtotime($row[':tgl2']));
                $labels[] = $row['nm_poli'];
                $values[] = (int)$row['jumlah_kunjungan'];
            }
        } 
        // Mode khusus: rekap mingguan per poli
        else {
            // Query ambil jumlah kunjungan per minggu
            $sql = "
                SELECT 
                    YEARWEEK(rp.tgl_registrasi, 1) AS minggu_ke,
                    MIN(rp.tgl_registrasi) AS tgl_awal,
                    MAX(rp.tgl_registrasi) AS tgl_akhir,
                    COUNT(rp.no_rawat) AS jumlah_kunjungan
                FROM reg_periksa rp
                WHERE rp.tgl_registrasi BETWEEN :tgl1 AND :tgl2
                AND rp.stts != 'Batal'
                AND rp.kd_poli = :kd_poli
                ";

            if ($status_periksa == 'Ralan') {
                $sql .= " AND rp.status_lanjut = 'Ralan'";
            } elseif ($status_periksa == 'Ranap') {
                $sql .= " AND rp.status_lanjut = 'Ranap'";
            }

            $sql .= " GROUP BY minggu_ke ORDER BY minggu_ke ASC";

            $stmt = $this->db()->pdo()->prepare($sql);
            $stmt->execute([
                ':tgl1' => $tgl_kunjungan,
                ':tgl2' => $tgl_kunjungan_akhir,
                ':kd_poli' => $poli
            ]);

            $rows = $stmt->fetchAll();

            // Format hasil ke bentuk JSON
            $labels = [];
            $values = [];

            foreach ($rows as $row) {
                $start = date('d M Y', strtotime($row['tgl_awal']));
                $end = date('d M Y', strtotime($row['tgl_akhir']));
                $labels[] = "$start - $end";
                $values[] = (int) $row['jumlah_kunjungan'];
            }
        }

        echo json_encode([
            'labels' => $labels,
            'values' => $values
        ]);
        exit();
    }

    public function getPoli()
    {
        $this->db('poliklinik')->where('status', '1')->toArray();
    }

    public function getJavascript()
    {
        header('Content-type: text/javascript');
        $this->assign['websocket'] = $this->settings->get('settings.websocket');
        $this->assign['websocket_proxy'] = $this->settings->get('settings.websocket_proxy');
        echo $this->draw(MODULES . '/kunjungan_ralan/js/admin/kunjungan_ralan.js', ['mlite' => $this->assign]);
        exit();
    }
    private function _addHeaderFiles()
    {
        $this->core->addCSS(url('assets/css/dataTables.bootstrap.min.css'));
        $this->core->addJS(url('assets/jscripts/jquery.dataTables.min.js'));
        $this->core->addJS(url('assets/jscripts/dataTables.bootstrap.min.js'));
        $this->core->addCSS(url('assets/css/bootstrap-datetimepicker.css'));
        $this->core->addJS(url('assets/jscripts/moment-with-locales.js'));
        $this->core->addJS(url('assets/jscripts/bootstrap-datetimepicker.js'));
        $this->core->addJS('https://cdn.jsdelivr.net/npm/chart.js');
        $this->core->addJS(url([ADMIN, 'kunjungan_ralan', 'javascript']), 'footer');
    }
}
