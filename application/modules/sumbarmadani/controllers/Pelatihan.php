<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of fungsi class
 *
 * @author Yogi "solop" Kaputra
 */

class Pelatihan extends SLP_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_pelatihan', 'mpelatihan');
        header("Access-Control-Allow-Origin: *");
    }
    public function listdata()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            if ($this->uri->segment(4) != "all") {
                $pelatihan = $this->mpelatihan->getDataPelatihan();
                $page = 1;
                $totalpages = 1;
                $totalrecords = count($pelatihan);
            } else {
                $limitperpage = 6;
                $totalrecords = $this->mpelatihan->totalDataPelatihan();
                $totalpages = ceil($totalrecords / $limitperpage);
                $page = $this->input->post('page') != 0 ? $this->input->post('page') : 1;

                $offset = ($page - 1) * $limitperpage;

                $pelatihan = $this->mpelatihan->getDataPelatihan($limitperpage, $offset, '');
            }
            if (count($pelatihan) > 0) {
                $tanggal_daftar = date('Y-m-d');
                foreach ($pelatihan as $pel) {
                    if ($tanggal_daftar < $pel['mulai_registrasi']) {
                        $validasi = '1';
                        $flagRegistrasi = '1';
                        $status_pelatihan = $this->convert_statpel($flagRegistrasi);
                    } else if ($tanggal_daftar > $pel['akhir_registrasi']) {
                        $validasi = '2';
                        $flagRegistrasi = '2';
                        $status_pelatihan = $this->convert_statpel($flagRegistrasi);
                    } else if (($tanggal_daftar >= $pel['mulai_registrasi']) && ($tanggal_daftar <= $pel['akhir_registrasi'])) {
                        $validasi = '3';
                        $flagRegistrasi = '3';
                        $status_pelatihan = $this->convert_statpel($flagRegistrasi);
                    }
                    $row[] = array(
                        'id_pelatihan' => $pel['id_pelatihan'],
                        'token' => $pel['token'],
                        'nm_pelatihan' => $pel['nm_pelatihan'],
                        'category' => $pel['id_jenis_kegiatan'],
                        'nm_jenis_kegiatan' => $pel['nm_jenis_kegiatan'],
                        'tanggal_pelatihan' => $pel['tanggal_pelatihan'],
                        'mulai_registrasi' => $pel['mulai_registrasi'],
                        'akhir_registrasi' => $pel['akhir_registrasi'],
                        'registrasi' => tgl_indo($pel['mulai_registrasi'], 'short') . ' - ' . tgl_indo($pel['akhir_registrasi'], 'short'),
                        'kuota' => $pel['kuota'],
                        'keterangan' => $pel['keterangan'],
                        'status_pelatihan' => $status_pelatihan,
                        'id_metode_pelatihan' => $pel['id_metode_pelatihan'],
                        'metode_pelatihan' => $this->convert_metodepel($pel['id_metode_pelatihan']),
                        'validasi' => $validasi,
                        'nama_opd' => $pel['nama_opd'] ? $pel['nama_opd'] : 'Pemerintah Provinsi Sumatera Barat',
                    );
                }
                $pelatihan = $row;
            }
            $data = array(
                "status" => true,
                "message" => "Daftar pelatihan digitalent",
                "data" => $pelatihan,
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

    private function convert_statpel($id_status)
    {
        $status = array(
            4 => 'DONE',
            3 => 'OPEN',
            2 => 'CLOSE',
            1 => 'WAIT',
            0 => 'REGISTER',
        );
        return $status[intval($id_status)];
    }
    private function convert_metodepel($id_status)
    {
        $status = array(
            1 => 'Offline',
            2 => 'Online',
        );
        return $status[intval($id_status)];
    }


    public function getCategories()
    {
        if ($_SERVER['REQUEST_METHOD'] === "GET") {
            $stats = $this->mpelatihan->getStatperCategory();
            $categories = $this->mpelatihan->getCategories();
            if (count($categories) > 0) {
                $options = array();
                $options[] = array(
                    'value' => '0',
                    'label' => 'Semua'
                );
                $tpel = 0;
                $tpes = 0;
                foreach ($categories as $cat) {
                    $option = array(
                        'value' => $cat['id_jenis_kegiatan'],
                        'label' => $cat['nm_jenis_kegiatan']
                    );
                    foreach ($stats as $stat) {
                        if ($cat['id_jenis_kegiatan'] == $stat['id_jenis_kegiatan']) {
                            $statistic = array(
                                'jml_peserta' => $stat['jml_peserta'],
                                'jml_pelatihan' => $stat['jml_pelatihan']
                            );
                            $tpel = $tpel + $stat['jml_pelatihan'];
                            $tpes = $tpes + $stat['jml_peserta'];
                            $option = array_merge($option, $statistic);
                        }
                    }
                    $options[] = $option;
                }
                $options[0]['jml_peserta'] = $tpes;
                $options[0]['jml_pelatihan'] = $tpel;
                $data = array(
                    "status" => true,
                    "message" => "Daftar kategori pelatihan",
                    "data" => $options
                );
                $statuscode = 200;
                $this->output->set_status_header($statuscode)->set_content_type('application/json')->set_output(json_encode($data));
            } else {
                $data = array(
                    "status" => false,
                    "message" => "Tidak ada data kategori pelatihan",
                    "data" => []
                );
                $statuscode = 200;
                $this->output->set_status_header($statuscode)->set_content_type('application/json')->set_output(json_encode($data));
            }
        } else {
            $this->output->set_status_header(401)->set_content_type('application/json')->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }
    public function getDetails()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $contId = $this->input->post('token');
            $nik = $this->input->post('nik');
            // echo $contId; die;
            $this->load->model('model_peserta', 'mpeserta');
            $getDataUser = $this->mpeserta->getDataUser($nik);
            $id_peserta = empty($getDataUser) ? '' : $getDataUser['id_peserta'];
            $dataShow   = $this->mpelatihan->getDataDetailShow($contId);



            // $dataSyarat = $this->mpelatihan->cekSyarat($dataShow['group_syarat']);
            // Syarat Pelatihan
            $dataSyarat = $this->mpelatihan->getDataSyarat($dataShow['id_pelatihan'], $id_peserta);
            $row['syarat_ketentuan']            = !empty($dataSyarat) ? $dataSyarat : array();

            // Syarat Tambahan
            $dataSyaratTambahan = $this->mpelatihan->getDataSyaratTambahan($dataShow['id_pelatihan'], $id_peserta);
            $row['syarat_tambahan']    = !empty($dataSyaratTambahan) ? $dataSyaratTambahan : array();

            $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode([
                'status' => true,
                'message' => 'detail pelatihan',
                'data' => $row
            ]));
        } else {
            $this->output->set_status_header(401)->set_content_type('application/json')->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }

    public function saveSyaratTambahan()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            // echo $_POST;
            // $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($_POST));

            $nik = $this->input->post('nik');
            $id_pelatihan = $this->input->post('id_pelatihan');
            $id_syarat = $this->input->post('id_syarat');

            // echo $contId; die;
            $this->load->model('model_peserta', 'mpeserta');
            $getDataUser = $this->mpeserta->getDataUser($nik);
            $id_peserta = empty($getDataUser) ? '' : $getDataUser['id_peserta'];

            $save = $this->mpelatihan->saveSyaratTambahan($id_pelatihan, $id_peserta, $id_syarat);
            $data = '';
            if ($save['response'] == 'SUCCESS') {
                $code = 200;
                $message = "File berhasil diupload";
                $status = true;
                $data = $save['file'];
            } else if ($save['response'] == 'FILE_ERROR') {
                $code = 422;
                $message = "File gagal diupload karna tidak sesuai ketentuan";
                $status = false;
            } else if ($save['response'] == 'ALREADY_UPLOADED') {
                $code = 422;
                $message = "File sudah diupload sebelumnya";
                $status = false;
            } else {
                $code = 422;
                $message = "Tidak ada file yang diupload";
                $status = false;
            }

            $this->output->set_status_header($code)->set_content_type('application/json')->set_output(json_encode([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ]));
        } else {
            $this->output->set_status_header(401)->set_content_type('application/json')->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }

    public function Register()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $nik = $this->input->post('nik');
            $id_pelatihan = $this->input->post('id_pelatihan');
            // $syarat = json_decode(stripslashes($_POST['syarat_ketentuan']));
            // $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($_POST));

            $this->load->model('model_peserta', 'mpeserta');
            $getDataUser = $this->mpeserta->getDataUser($nik);
            $id_peserta = empty($getDataUser) ? '' : $getDataUser['id_peserta'];
            $tahun = date('Y');
            if ($this->mpelatihan->cekHistoryPelatihan($id_peserta, $tahun) > 0) {
                $code = 200;
                $status = false;
                $message = "Pendaftaran pelatihan gagal, anda sudah terdaftar pada tahun ini";
            } else {
                $saveHistory = $this->mpelatihan->saveHistoryPelatihan($id_peserta, $id_pelatihan, $tahun);
                if ($saveHistory['response'] == 'SUCCESS') {
                    $code = 200;
                    $status = true;
                    $message = "Pendaftaran pelatihan berhasil";
                } else {
                    $code = 422;
                    $status = false;
                    $message = "Pendaftaran pelatihan gagal";
                }
            }
            $this->output->set_status_header($code)->set_content_type('application/json')->set_output(json_encode([
                'status' => $status,
                'message' => $message,
            ]));
        } else {
            $this->output->set_status_header(401)->set_content_type('application/json')->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }
    public function listHistory()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {

            $nik = $this->input->post('nik');
            $history = $this->mpelatihan->getHistory($nik);
            $status_saya = [
                [
                    'id' => 1,
                    'label' => 'SEDANG DIVERIFIKASI'
                ],
                [
                    'id' => 2,
                    'label' => 'SETUJU'
                ],
                [
                    'id' => 3,
                    'label' => 'TOLAK'
                ],
                [
                    'id' => 4,
                    'label' => 'SELESAI'
                ]
            ];
            if (count($history) > 0) {
                // $tanggal_daftar = date('Y-m-d');
                foreach ($history as $pel) {
                    if ($pel['tanggal_daftar'] < $pel['mulai_registrasi']) {
                        $validasi = '1';
                        $flagRegistrasi = '1';
                        $status_pelatihan = $this->convert_statpel($flagRegistrasi);
                    } else if ($pel['tanggal_daftar'] > $pel['akhir_registrasi']) {
                        $validasi = '2';
                        $flagRegistrasi = '2';
                        $status_pelatihan = $this->convert_statpel($flagRegistrasi);
                    } else if (($pel['tanggal_daftar'] >= $pel['mulai_registrasi']) && ($pel['tanggal_daftar'] <= $pel['akhir_registrasi'])) {
                        $validasi = '3';
                        $flagRegistrasi = '3';
                        $status_pelatihan = $this->convert_statpel($flagRegistrasi);
                    }
                    $row[] = array(
                        'id_pelatihan' => $pel['id_pelatihan'],
                        'token' => $pel['token'],
                        'nm_pelatihan' => $pel['nm_pelatihan'],
                        'category' => $pel['id_jenis_kegiatan'],
                        'nm_jenis_kegiatan' => $pel['nm_jenis_kegiatan'],
                        'tanggal_pelatihan' => $pel['tanggal_pelatihan'],
                        'mulai_registrasi' => $pel['mulai_registrasi'],
                        'akhir_registrasi' => $pel['akhir_registrasi'],
                        'registrasi' => tgl_indo($pel['mulai_registrasi'], 'short') . ' - ' . tgl_indo($pel['akhir_registrasi'], 'short'),
                        'kuota' => $pel['kuota'],
                        'keterangan' => $pel['keterangan'],
                        'status_pelatihan' => $status_pelatihan,
                        'id_metode_pelatihan' => $pel['id_metode_pelatihan'],
                        'metode_pelatihan' => $this->convert_metodepel($pel['id_metode_pelatihan']),
                        'validasi' => $validasi,
                        'nama_opd' => $pel['nama_opd'] ? $pel['nama_opd'] : 'Pemerintah Provinsi Sumatera Barat',
                        'tanggal_daftar' => tgl_indo($pel['tanggal_daftar']),
                        'status_saya' => $this->convert_flag($pel['flag']),

                    );
                }
                $history = $row;
            }
            $data = array(
                "status" => true,
                "message" => "History pelatihan digitalent",
                "data" => array(
                    "history" => $history,
                    "status_saya" => $status_saya
                ),
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
    private function convert_flag($flag)
    {
        $status = array(
            4 => 'SELESAI',
            3 => 'TOLAK',
            2 => 'SETUJU',
            1 => 'SEDANG DIVERIFIKASI',
        );
        return $status[intval($flag)];
    }

    // Testing Upload Baru
    public function uploadSyaratTambahan()
    {
        if ($_SERVER['REQUEST_METHOD'] === "POST") {
            // echo $_POST;
            // $this->output->set_status_header(200)->set_content_type('application/json')->set_output(json_encode($_POST));

            $nik            = $this->input->post('nik');
            $id_pelatihan   = $this->input->post('id_pelatihan');
            $id_syarat      = $this->input->post('id_syarat');
            $upload_berkas      = $this->input->post('uploaded_file');

            // echo $contId; die;
            $this->load->model('model_peserta', 'mpeserta');
            $getDataUser = $this->mpeserta->getDataUser($nik);
            $id_peserta = empty($getDataUser) ? '' : $getDataUser['id_peserta'];

            $save = $this->mpelatihan->saveUploadSyaratTambahan($id_pelatihan, $id_peserta, $id_syarat, $upload_berkas);
            $data = '';
            if ($save['response'] == 'SUCCESS') {
                $code = 200;
                $message = "File berhasil diupload";
                $status = true;
                $data = $save['file'];
            } else if ($save['response'] == 'FILE_ERROR') {
                $code = 422;
                $message = "File gagal diupload karna tidak sesuai ketentuan";
                $status = false;
            } else if ($save['response'] == 'ALREADY_UPLOADED') {
                $code = 422;
                $message = "File sudah diupload sebelumnya";
                $status = false;
            } else {
                $code = 422;
                $message = "Tidak ada file yang diupload";
                $status = false;
            }

            $this->output->set_status_header($code)->set_content_type('application/json')->set_output(json_encode([
                'status' => $status,
                'message' => $message,
                'data' => $data
            ]));
        } else {
            $this->output->set_status_header(401)->set_content_type('application/json')->set_output(json_encode([
                'status' => false,
                'message' => 'tidak diizinkan'
            ]));
        }
    }
}
