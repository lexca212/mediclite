<?php

namespace Plugins\Downtime;

use Systems\AdminModule;

class Admin extends AdminModule
{

  public function navigation()
  {
    return [
      'manage' => 'manage',
    ];
  }

  public function getManage()
  {
    $this->_addHeaderFiles();
    $date_start = date('Y-m-d');
    $date_end = date('Y-m-d');
    if (isset_or($_GET['tgl_mulai']) && isset_or($_GET['tgl_selesai'])) {
      $date_start = $_GET['tgl_mulai'];
      $date_end = $_GET['tgl_selesai'];
    }
    $downtime = $this->db('downtime')
      ->where('tgl_mulai', '>=', $date_start)
      ->where('tgl_mulai', '<=', $date_end)
      ->toArray();

    return $this->draw('manage.html', [
      'downtime' => $downtime,
      'tgl_awal' => $date_start,
      'tgl_akhir' => $date_end
    ]);
  }

  public function postSaveDowntime()
  {
    if ($_POST['simpan']) {
      unset($_POST['simpan']);

      $mulai = strtotime($_POST['tgl_mulai'] . ' ' . $_POST['jam_mulai']);
      $selesai = strtotime($_POST['tgl_selesai'] . ' ' . $_POST['jam_selesai']);

      if ($mulai && $selesai && $selesai >= $mulai) {

        $selisih = $selesai - $mulai;

        $jam   = floor($selisih / 3600);
        $menit = floor(($selisih % 3600) / 60);
        $detik = $selisih % 60;

        $durasi = "$jam jam $menit menit $detik detik";
      } else {
        $durasi = "Waktu tidak valid";
      }

      // echo gmdate("H jam i menit s detik", $selisih);

      $this->db('downtime')->save([
        'tgl_mulai' => $_POST['tgl_mulai'],
        'jam_mulai' => $_POST['jam_mulai'],
        'tgl_selesai' => $_POST['tgl_selesai'],
        'jam_selesai' => $_POST['jam_selesai'],
        'keterangan_downtime' => $_POST['keterangan_downtime'],
        'jenis_downtime'  => $_POST['jenis_downtime'],
        'kategori'  => $_POST['kategori'],
        'catatan_downtime'  => $_POST['catatan_downtime'],
        'tindak_lanjut' => $_POST['tindak_lanjut'],
        'durasi'  => $durasi
      ]);
      $this->notify('success', 'Data Downtime telah disimpan');
    } else if ($_POST['update']) {
      //   $no_inventaris = $_POST['no_inventaris'];
      $ketdowntime = $_POST['keterangan_downtime'];
      unset($_POST['update']);
      //unset($_POST['keterangan_downtime']);

      $this->db('downtime')
        ->where('keterangan_downtime', $ketdowntime)
        ->save($_POST);
      $this->notify('failure', 'Data aset telah diubah');
    } else if ($_POST['hapus']) {
      $this->db('downtime')
        ->where('keterangan_downtime', $_POST['keterangan_downtime'])
        ->delete();
      $this->notify('failure', 'Data aset telah dihapus');
    }
    redirect(url([ADMIN, 'downtime', 'manage']));
  }

  public function postCetakDowntime()
  {
    $tgl_awal = $_POST['tgl_awal'];
    $tgl_akhir = $_POST['tgl_akhir'];

    $this->tpl->set('downtime', $this->db('downtime')->where('tgl_mulai', '>=', $tgl_awal)->where('tgl_mulai', '<=', $tgl_akhir)->toArray());
    echo $this->tpl->draw(MODULES . '/downtime/view/admin/cetak.downtime.html', true);
    exit();
  }

  public function getCss()
  {
    header('Content-type: text/css');
    echo $this->draw(MODULES . '/downtime/css/admin/downtime.css');
    exit();
  }

  public function getJavascript()
  {
    header('Content-type: text/javascript');
    echo $this->draw(MODULES . '/downtime/js/admin/downtime.js');
    exit();
  }

  private function _addHeaderFiles()
  {
    $this->core->addCSS(url('assets/css/dataTables.bootstrap.min.css'));
    $this->core->addCSS(url('assets/css/bootstrap-datetimepicker.css'));
    $this->core->addCSS(url('assets/css/jquery.timepicker.css'));
    $this->core->addCSS(url([ADMIN, 'downtime', 'css']));
    $this->core->addJS(url('assets/jscripts/jquery.dataTables.min.js'));
    $this->core->addJS(url('assets/jscripts/dataTables.bootstrap.min.js'));
    $this->core->addJS(url('assets/jscripts/moment-with-locales.js'));
    $this->core->addJS(url('assets/jscripts/bootstrap-datetimepicker.js'));
    $this->core->addJS(url('assets/jscripts/jquery.timepicker.js'), 'footer');
    $this->core->addJS(url([ADMIN, 'downtime', 'javascript']), 'footer');
  }
}
