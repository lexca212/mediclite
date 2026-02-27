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
    if(isset_or($_GET['tgl_mulai']) && isset_or($_GET['tgl_selesai'])){
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
    if($_POST['simpan']) {
      unset($_POST['simpan']);
      $this->db('downtime')->save($_POST);
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
?>