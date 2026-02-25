<?php

namespace Plugins\Dokter_Igd;

use Systems\SiteModule;
use Systems\Lib\QRCode;

class Site extends SiteModule
{

    public function routes()
    {
        $this->route('dokter_igd/simpantriage', 'getSimpanTriage');
    }

    public function getSimpanTriage() {

        if(!empty($_POST['image'])){
            $imgData = $_POST['image'];
            $no_rawat = $_POST['no_rawat'];
            
            // Menghapus prefix base64 dari string (data:image/png;base64,)
            $imgData = str_replace('data:image/png;base64,', '', $imgData);
            
            // Decode base64 menjadi binary data
            $imgData = base64_decode($imgData);

            // Tentukan nama file (misalnya berdasarkan timestamp)
            $filename = 'triage_form_' . time() . '.png';
            $filePath = WEBAPPS_PATH.'/berkasrawat/pages/upload/' . $filename;

            // Simpan gambar di server
            if (file_put_contents($filePath, $imgData)) {
                echo 'Gambar berhasil disimpan di berkas rawat !';

                $query = $this->db('berkas_digital_perawatan')->save(['no_rawat' => $no_rawat, 'kode' => '011', 'lokasi_file' => 'pages/upload/' . $filename]);
                
            } else {
                echo 'Gagal menyimpan gambar.';
            }
        }
    }
}
