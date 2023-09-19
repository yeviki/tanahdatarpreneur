<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of fungsi class
 *
 * @author Yogi "solop" Kaputra
 */

class Berita extends SLP_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_berita', 'mberita');
        header("Access-Control-Allow-Origin: *");
    }
    public function getdataberita()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $limit = $this->uri->segment(4);
            $limitperpage = $limit;
            $totalrecords = $this->mberita->totalDataBerita();
            if($limit != "all"){
                $totalpages = ceil($totalrecords / $limitperpage);
                $page = $this->input->post('page') != 0 ? $this->input->post('page') : 1;
                $offset = ($page - 1) * $limitperpage;
                $berita = $this->mberita->getDataBerita($limitperpage, $offset, '');
            }
            $totalpages = ceil($limit);
            $page = $this->input->post('page') != 0 ? $this->input->post('page') : 1;
            $berita = $this->mberita->getDataBerita($limitperpage, $offset = 0, '');

            $dirname 	   	= 'repository/foto';
            if (!is_dir($dirname)) {
                mkdir('./' . $dirname, 0777, TRUE);
            }

            if (count($berita) > 0) {
                foreach ($berita as $pel) {
                    $row[] = array(
                        'id_berita'     => $pel['id_berita'],
                        'detailurl'     => base_url('detail_kegiatan?id='.$pel['id_berita']),
                        'id_opd'        => $pel['id_opd'],
                        'id_pelatihan'  => $pel['id_pelatihan'],
                        'judul_berita'  => $pel['judul_berita'],
                        'keterangan'    => $pel['keterangan'],
                        'file_foto'     => base_url().$dirname.'/'.$pel['file_foto'],
                        'id_status'     => $pel['id_status'],
                        'nama_opd'      => $pel['nama_opd'] ? $pel['nama_opd'] : 'Pemerintah Provinsi Sumatera Barat',
                    );
                }
                $berita = $row;
            }
            $data = array(
                "status" => true,
                "message" => "Daftar berita sumbarpreneur",
                "data" => $berita,
                "page" => $page,
                "totalpages" => $totalpages,
                "totalrecords" => $totalrecords
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
