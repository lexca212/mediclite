<?php

namespace Plugins\Rawat_Jalan;

use Systems\SiteModule;
use Systems\Lib\QRCode;

class Site extends SiteModule
{

    public function routes()
    {
        $this->route('rawat_jalan/simpanpersetujuanranap', 'getSimpanPersetujuanRanap');
    }

    public function getSimpanPersetujuanRanap() {

        if(!empty($_POST['imgData'])){
            $imgData = $_POST['imgData'];
            $no_rawat = $_POST['no_rawat'];

            // var_dump($no_rawat); die();
            
            // Menghapus prefix base64 dari string (data:image/png;base64,)
            $imgData = str_replace('data:image/png;base64,', '', $imgData);
            
            // Decode base64 menjadi binary data
            $imgData = base64_decode($imgData);

            // Tentukan nama file (misalnya berdasarkan timestamp)
            $filename = 'persetujuan_ranap_' . time() . '.png';
            $filePath = WEBAPPS_PATH.'/berkasrawat/pages/upload/' . $filename;

            // Simpan gambar di server
            if (file_put_contents($filePath, $imgData)) {
                echo 'Gambar berhasil disimpan di berkas rawat !';

                $query = $this->db('berkas_digital_perawatan')->save(['no_rawat' => $no_rawat, 'kode' => '015', 'lokasi_file' => 'pages/upload/' . $filename]);
                
            } else {
                echo 'Gagal menyimpan gambar.';
            }
        }
    }
}
