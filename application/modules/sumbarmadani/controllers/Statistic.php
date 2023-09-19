<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of fungsi class
 *
 * @author Yogi "solop" Kaputra
 */

class Statistic extends SLP_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_statistic', 'mstats');
        header("Access-Control-Allow-Origin: *");
    }
    public function getData()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $peserta = $this->mstats->get_peserta();
            $pelatihan = $this->mstats->get_pelatihan();
            $statis = array(
                'peserta' => $peserta['total'],
                'millenial' => $peserta['milenial'],
                'woman' => $peserta['woman'],
                'pelatihan' => $pelatihan['total']
            );
            $data = array(
                "status" => true,
                "message" => "Data Statistik Digital Talent Provinsi Sumatera Barat",
                "data" => $statis,
            );
            $statuscode = 200;
            $this->output->set_status_header($statuscode)->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $this->output->set_status_header(401)->set_content_type('application/json')->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }
    public function getPelatihanPerOPD()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $pelatihan = $this->mstats->statPelatihanPerOPD();
            $total = 0;
            foreach ($pelatihan as $row) {
                $total = $total + $row['jumlah'];
            }
            $pelatihan[] = array(
                'id_opd' => '9999',
                'nama_opd' => 'Total pelatihan',
                'singkatan' => '',
                'jumlah' => $total
            );
            $data = array(
                "status" => true,
                "message" => "Data Statistik Pelatihan per OPD Digital Talent Provinsi Sumatera Barat",
                "category" => "Pelatihan per OPD",
                "data" => $pelatihan,
            );
            $statuscode = 200;
            $this->output->set_status_header($statuscode)->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $this->output->set_status_header(401)->set_content_type('application/json')->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }

    public function getPesertaPerOPD_Old($category = "")
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $id_cat = $category == 'millenial' ? 1 : ($category == 'woman' ? 2 : 0);
            $category = $category != "" ? $category : "Semua";
            $peserta = $this->mstats->statPesertaPerOPD($id_cat);
            // $total = 0;
            // foreach ($peserta as $row) {
            //     $total = $total + $row['jumlah'];
            // }
            // $peserta[] = array(
            //     'id_opd' => '9999',
            //     'nama_opd' => 'Total peserta',
            //     'singkatan' => '',
            //     'jumlah' => $total
            // );
            $data = array(
                "status" => true,
                "message" => "Data Statistik Peserta per OPD Digital Talent Provinsi Sumatera Barat",
                "category" => $category,
                "data" => $peserta,
            );
            $statuscode = 200;
            $this->output->set_status_header($statuscode)->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $this->output->set_status_header(401)->set_content_type('application/json')->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }

    public function getPesertaPerOPD($category = "")
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $id_cat = $category == 'millenial' ? 1 : ($category == 'woman' ? 2 : 0);
            $category = $category != "" ? $category : "Semua";
            $peserta = $this->mstats->statPesertaPerOPDNew($id_cat);
            $total = 0;
            foreach ($peserta as $row) {
                $total = $total + $row['jumlah'];
            }
            $peserta[] = array(
                'id_opd' => '9999',
                'nama_opd' => 'Total peserta',
                'singkatan' => '',
                'jumlah' => $total
            );
            $data = array(
                "status" => true,
                "message" => "Data Statistik Peserta per OPD Digital Talent Provinsi Sumatera Barat",
                "category" => $category,
                "data" => $peserta,
            );
            $statuscode = 200;
            $this->output->set_status_header($statuscode)->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $this->output->set_status_header(401)->set_content_type('application/json')->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }

    public function newGetData()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $peserta    = $this->mstats->statPesertaNew();
            $milenial   = $this->mstats->statKategoriPelatihanMilenialNew();
            $woman      = $this->mstats->statKategoriPelatihanWomanNew();
            $kreatif      = $this->mstats->statKategoriPelatihanKreatifNew();
            $peserta_pelatihan      = $this->mstats->statPesertaNew();
            $statis = array(
                'peserta' => number_format($peserta['total'],0,",","."),
                'millenial' => number_format($milenial['total'],0,",","."),
                'woman' => number_format($woman['total'],0,",","."),
                'kreatif' => number_format($kreatif['total'],0,",","."),
                // Ini Total yang mengikuti Pelatihan Sementara Brooo....
                // 'total_peserta' => number_format(($milenial['total'] + $woman['total'] + $kreatif['total']),0,",",".")
                'total_peserta' => number_format($peserta_pelatihan['total'],0,",",".")
                // demi agung kamprettt
            );
            $data = array(
                "status" => true,
                "message" => "Data Statistik Digital Talent Provinsi Sumatera Barat",
                "data" => $statis,
            );
            $statuscode = 200;
            $this->output->set_status_header($statuscode)->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $this->output->set_status_header(401)->set_content_type('application/json')->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }

    public function newStatKategori()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            // $peserta    = $this->mstats->statPesertaNew();
            $izin                   = $this->mstats->get_perizinan();
            $permodalan             = $this->mstats->get_permodalan();
            $smk                    = $this->mstats->get_smk();
            $pelatihan              = $this->mstats->get_pelatihan();
            // Total Pelatihan Diganti Sementara
            // $peserta_pelatihan      = $this->mstats->statPesertaNew();
            $milenial   = $this->mstats->statKategoriPelatihanMilenialNew();
            $woman      = $this->mstats->statKategoriPelatihanWomanNew();
            $kreatif      = $this->mstats->statKategoriPelatihanKreatifNew();
            
            $statis = array(
                'perizinan'                 => number_format($izin['total'],0,",","."),
                // 'perizinan'                 => number_format(1743,0,",","."),
                //'permodalan'                => number_format($permodalan['total'],0,",","."),
                'permodalan'                => number_format(672,0,",","."),
                'smk_preneur'               => number_format($smk['total'],0,",","."),
                // Ini Total Seluruh Pelatihan Sementara Brooo....
                // 'total_pelatihan'           => number_format($peserta_pelatihan['total'],0,",","."),
                'total_pelatihan'           => number_format(($milenial['total'] + $woman['total'] + $kreatif['total']),0,",","."),
                // Baccoooootottttttttttt
                'total_pelatihan_opd'       => number_format($pelatihan['total'],0,",",".")
            );
            $data = array(
                "status" => true,
                "message" => "Data Statistik Digital Talent Provinsi Sumatera Barat",
                "data" => $statis,
            );
            $statuscode = 200;
            $this->output->set_status_header($statuscode)->set_content_type('application/json')->set_output(json_encode($data));
        } else {
            $this->output->set_status_header(401)->set_content_type('application/json')->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }
}
