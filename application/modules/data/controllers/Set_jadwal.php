<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of mata diklat class
 *
 * @author Yogi "solop" Kaputra
 */

class Set_jadwal extends SLP_Controller
{
    protected $_vwName  = '';
    protected $_uriName = '';
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_set_jadwal' => 'mSetJadwal', 'master/model_master' => 'mmas'));
        $this->_vwName = 'vjadwal';
        $this->_uriName = 'data/set-jadwal';
    }

    private function validasiDataValue()
    {
        $this->form_validation->set_rules('daterange1', 'Tanggal Mulai Pelatihan', 'required|trim');
        $this->form_validation->set_rules('daterange', 'Tanggal Mulai Pendaftaran', 'required|trim');
        $this->form_validation->set_rules('tempat_pelatihan', 'Tempat Pelatihan', 'required|trim');
        $this->form_validation->set_rules('pagu_anggaran', 'Pagu Anggaran', 'required|trim');
        $this->form_validation->set_rules('nm_sub_kegiatan', 'Nama Sub Kegiatan DPA', 'required|trim');
        $this->form_validation->set_rules('id_jenis_kegiatan', 'Jenis Pelatihan', 'required|trim');
        $this->form_validation->set_rules('id_master_pelatihan', 'Judul Pelatihan', 'required|trim');
        validation_message_setting();
        if ($this->form_validation->run() == FALSE)
            return false;
        else
            return true;
    }

    public function index()
    {
        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Data', '#');
        $this->breadcrumb->add('Set Jadwal', site_url($this->_uriName));
        $this->session_info['page_name']        = 'Set Jadwal';
        $this->session_info['siteUri']          = $this->_uriName;
        $this->session_info['page_js']            = $this->load->view($this->_vwName . '/vjs', array('siteUri' => $this->_uriName), true);
        $this->session_info['data_pelatihan']   = $this->mmas->getMasterPelatihan();
        $this->session_info['data_jenkeg']      = $this->mmas->getJenisKegiatan();
        $this->template->build($this->_vwName . '/vpage', $this->session_info);
    }

    public function listview()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $data = array();
            $session = $this->app_loader->current_account();
            if (isset($session)) {
                $dataList = $this->mSetJadwal->get_datatables();
                $no = $this->input->post('start');
                foreach ($dataList as $key => $dl) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $dl['nm_pelatihan'];
                    $row[] = $dl['tanggal_pelatihan'];
                    $row[] = $dl['mulai_registrasi'] . ' - ' . $dl['akhir_registrasi'];
                    $row[] = $dl['pagu_anggaran'];
                    $row[] = $dl['nm_sub_kegiatan'];
                    $row[] = $dl['id_jadwal'];
                    $row[] = '<button type="button" class="btn btn-orange btn-sm px-2 py-1 my-0 mx-0 waves-effect waves-light btnEdit" data-id="' . $this->encryption->encrypt($dl['id_jadwal']) . '" title="Edit data"><i class="fas fa-pencil-alt"></i></button>
                    <button type="button" class="btn btn-danger btn-sm px-2 py-1 my-0 mx-0 waves-effect waves-light btnDelete" data-id="' . $this->encryption->encrypt($dl['id_jadwal']) . '" title="Hapus data"><i class="fas fa-trash-alt"></i></button>';
                    $data[] = $row;
                }
                $output = array(
                    "draw" => $this->input->post('draw'),
                    "recordsTotal" => $this->mSetJadwal->count_all(),
                    "recordsFiltered" => $this->mSetJadwal->count_filtered(),
                    "data" => $data,
                );
            }
            //output to json format
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
    }

    public function create()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            if (!empty($session)) {
                if ($this->validasiDataValue() == FALSE) {
                    $result = array('status' => 'RC404', 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->mSetJadwal->insertData();
                    if ($data['response'] == 'SUCCESS') {
                        $result = array('status' => 'RC200', 'message' => 'Proses insert data baru dengan nama ' . $data['nama'] . ' sukses', 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses insert data baru gagal, mohon coba kembali'), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function details()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $contId   = $this->input->post('token', TRUE);
            if (!empty($contId) and !empty($session)) {
                $data = $this->mSetJadwal->getDataDetail($this->encryption->decrypt($contId));
                $row = array();

                $row['id_master_pelatihan']    = !empty($data) ? $data['id_master_pelatihan'] : '';
                $row['id_jenis_kegiatan']    = !empty($data) ? $data['id_jenis_kegiatan'] : '';
                $row['tanggal_pelatihan']    = !empty($data) ? $data['tanggal_pelatihan'] . ' - ' . $data['tanggal_pelatihan_akhir'] : '';
                $row['daterange']            = !empty($data) ? $data['mulai_registrasi'] . ' - ' . $data['akhir_registrasi'] : '';
                $row['tempat_pelatihan']    = !empty($data) ? $data['tempat_pelatihan'] : '';
                $row['pagu_anggaran']        = !empty($data) ? $data['pagu_anggaran'] : '';
                $row['nm_sub_kegiatan']        = !empty($data) ? $data['nm_sub_kegiatan'] : '';
                $row['status']                = !empty($data) ? $data['id_status'] : 1;

                $result = array('status' => 'RC200', 'message' => $row, 'csrfHash' => $csrfHash);
            } else {
                $result = array('status' => 'RC404', 'message' => array(), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function update()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $contId   = escape($this->input->post('tokenId', TRUE));
            if (!empty($session) and !empty($contId)) {
                if ($this->validasiDataValue() == FALSE) {
                    $result = array('status' => 'RC404', 'message' => $this->form_validation->error_array(), 'csrfHash' => $csrfHash);
                } else {
                    $data = $this->mSetJadwal->updateData();
                    if ($data['response'] == 'ERROR') {
                        $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data gagal, karena data tidak ditemukan'), 'csrfHash' => $csrfHash);
                    } else if ($data['response'] == 'SUCCESS') {
                        $result = array('status' => 'RC200', 'message' => 'Proses update data dengan nama ' . $data['nama'] . ' sukses', 'csrfHash' => $csrfHash);
                    }
                }
            } else {
                $result = array('status' => 'RC404', 'message' => array('isi' => 'Proses update data gagal, mohon coba kembali'), 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }

    public function delete()
    {
        if (!$this->input->is_ajax_request()) {
            exit('No direct script access allowed');
        } else {
            $session  = $this->app_loader->current_account();
            $csrfHash = $this->security->get_csrf_hash();
            $contId   = escape($this->input->post('tokenId', TRUE));
            if (!empty($session) and !empty($contId)) {
                $data = $this->mSetJadwal->deleteData();
                if ($data['response'] == 'ERROR') {
                    $result = array('status' => 'RC404', 'message' => 'Proses delete data gagal, karena data tidak ditemukan', 'csrfHash' => $csrfHash);
                } else if ($data['response'] == 'ERRDATA') {
                    $result = array('status' => 'RC404', 'message' => 'Proses delete data dengan nama ' . $data['nama'] . ' gagal, karena data sedang digunakan', 'csrfHash' => $csrfHash);
                } else if ($data['response'] == 'SUCCESS') {
                    $result = array('status' => 'RC200', 'message' => 'Proses delete data dengan nama ' . $data['nama'] . ' sukses', 'csrfHash' => $csrfHash);
                }
            } else {
                $result = array('status' => 0, 'message' => 'Proses delete data gagal, mohon coba kembali', 'csrfHash' => $csrfHash);
            }
            $this->output->set_content_type('application/json')->set_output(json_encode($result));
        }
    }
}

// This is the end of fungsi class
