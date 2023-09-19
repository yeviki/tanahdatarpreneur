<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of mata diklat model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_permodalan extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*Fungsi Get Data List*/
    var $search = array('nik');
    public function get_datatables() {
        $this->_get_datatables_query();
        if($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function count_filtered() {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all() {
        if ($this->app_loader->is_admin()) {
            $this->db->where('id_opd', $this->app_loader->current_opdid());
        }
        return $this->db->count_all_results('data_permodalan');
    }

    private function _get_datatables_query() {
        $this->db->select('a.id_permodalan,
                           a.nik,
                           a.id_pelatihan,
                           a.id_jenis_kegiatan,
                           a.id_bentuk_permodalan,
                           a.no_nib,
                           a.nama,
                           a.no_hp,
                           a.npwp,
                           a.email,
                           a.unit_usaha,
                           a.tahun_bantuan,
                           a.jumlah_uang_diterima,
                           a.unit_pemberi_modal,
                           a.opd_pemberi_bantuan,
                           a.sub_kegiatan,
                           a.nm_alat,
                           a.upload_foto_alat,
                           a.pemberi_permodalan,
                           a.id_opd,
                           b.nm_jenis_kegiatan,
                           c.nm_bentuk_permodalan
                           ');
        $this->db->from('data_permodalan a');
        $this->db->join('ms_jenis_kegiatan b', 'a.id_jenis_kegiatan = b.id_jenis_kegiatan', 'inner');
        $this->db->join('ref_bentuk_permodalan c', 'a.id_bentuk_permodalan = c.id_bentuk_permodalan', 'inner');
        $this->db->join('data_pelatihan d', 'a.id_pelatihan = d.id_pelatihan', 'inner');
        if ($this->app_loader->is_admin()) {
            $this->db->where('a.id_opd', $this->app_loader->current_opdid());
        }
        $i = 0;
        foreach ($this->search as $item) { // loop column
            if($_POST['search']['value']) { // if datatable send POST for search
                if($i===0) { // first loop
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
        $this->db->order_by('id_permodalan ASC');
    }

    /*Fungsi get data edit by id*/
    public function getDataDetail($id) {
        $this->db->where('id_permodalan', abs($id));
        $query = $this->db->get('data_permodalan');
        return $query->row_array();
    }

    /* Fungsi untuk insert data */
    public function insertData() {
        //get data
        $create_by      = $this->app_loader->current_account();
        $create_date    = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip      = $this->input->ip_address();
        $nik            = escape($this->input->post('nik', TRUE));
        $upload_foto    	= $_FILES['upload_foto']['name'];
        //cek duplicate
        $this->db->where('nik', $nik);
        $qTot = $this->db->count_all_results('data_permodalan');
        if($qTot > 0)
            return array('response'=>'ERROR', 'nama'=>$nik);
        else {
            $dirname = 'uploads/alat';
            if (!is_dir($dirname)) {
                mkdir('./' . $dirname, 0777, TRUE);
            }
            //cek upload file	
            $config = array(
                'upload_path'       => './' . $dirname . '/',
                'allowed_types'     => 'png|jpg|jpeg',
                'file_name'         => 'file_'.$nik,
                'file_ext_tolower'  => TRUE,
                'max_size'          => 3072,
                'max_filename'      => 0,
                'remove_spaces'     => TRUE
            );
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('upload_foto')) {
                $file_upload = '';
            } else {
                $upload_data = $this->upload->data();
                $file_upload = $upload_data['file_name'];
            }
            $data = array(
                'nik'                       => $nik,
                'id_pelatihan'              => escape($this->input->post('id_pelatihan', TRUE)),
                'id_jenis_kegiatan'         => escape($this->input->post('id_jenis_kegiatan', TRUE)),
                'no_nib'                    => escape($this->input->post('no_nib', TRUE)),
                'nama'                      => escape($this->input->post('nama', TRUE)),
                'no_hp'                     => escape($this->input->post('no_hp', TRUE)),
                'npwp'                      => escape($this->input->post('npwp', TRUE)),
                'email'                     => escape($this->input->post('email', TRUE)),
                'unit_usaha'                => escape($this->input->post('unit_usaha', TRUE)),
                'id_bentuk_permodalan'      => escape($this->input->post('id_bentuk_permodalan', TRUE)),
                'tahun_bantuan'             => escape($this->input->post('tahun_bantuan', TRUE)),
                'jumlah_uang_diterima'      => escape($this->input->post('jumlah_uang_diterima', TRUE)),
                'unit_pemberi_modal'        => escape($this->input->post('unit_pemberi_modal', TRUE)),
                'opd_pemberi_bantuan'       => escape($this->input->post('opd_pemberi_bantuan', TRUE)),
                'sub_kegiatan'              => escape($this->input->post('sub_kegiatan', TRUE)),
                'nm_alat'                   => escape($this->input->post('nm_alat', TRUE)),
                'upload_foto_alat'          => $file_upload,
                'pemberi_permodalan'        => escape($this->input->post('pemberi_permodalan', TRUE)),
                'create_by' 		        => $create_by,
                'create_date' 		        => $create_date,
                'create_ip' 		        => $create_ip,
                'mod_by' 			        => $create_by,
                'mod_date' 			        => $create_date,
                'mod_ip' 			        => $create_ip
            );
            /*query insert*/
            $this->db->insert('data_permodalan', $data);
            return array('response'=>'SUCCESS', 'nama'=>$nik);
        }
    }

    /* Fungsi untuk update data */
    public function updateData() {
        //get data
        $create_by          = $this->app_loader->current_account();
        $create_date        = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip          = $this->input->ip_address();
        $id_permodalan	    = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
        $permodalanId       = escape($this->input->post('permodalanId', TRUE));
        $nik                = escape($this->input->post('nik', TRUE));
        $id                 = escape($this->input->post('id_bentuk_permodalan', TRUE));
        $file_data    	    = $_FILES['upload_foto']['name'];
		$foto_old  	  	    = escape($this->input->post('fileshow', TRUE));
        //cek data by id

        $dirname 	   	= 'uploads/alat';
        if (!is_dir($dirname)) {
            mkdir('./' . $dirname, 0777, TRUE);
        }

        $data_search = $this->getDataDetail($id_permodalan);
        if(count($data_search) <= 0)
            return array('response'=>'NODATA', 'nikID'=>'');
        else {
            //cek nama kontrol duplicate
            $this->db->where('nik', $nik);
            $this->db->where('id_permodalan !=', $id_permodalan);
            $qTot = $this->db->count_all_results('data_permodalan');
            if($qTot > 0)
                return array('response'=>'ERRDATA', 'nikID'=>$nik);
            else {
                if (!file_exists(realpath('./' . $dirname . '/' . $foto_old))) {
                    if($id != $permodalanId) {
                        if($id == 1 ) {
                            $data = array(
                                'nik'                       => $nik,
                                'id_pelatihan'              => escape($this->input->post('id_pelatihan', TRUE)),
                                'id_jenis_kegiatan'         => escape($this->input->post('id_jenis_kegiatan', TRUE)),
                                'no_nib'                    => escape($this->input->post('no_nib', TRUE)),
                                'nama'                      => escape($this->input->post('nama', TRUE)),
                                'no_hp'                     => escape($this->input->post('no_hp', TRUE)),
                                'npwp'                      => escape($this->input->post('npwp', TRUE)),
                                'email'                     => escape($this->input->post('email', TRUE)),
                                'unit_usaha'                => escape($this->input->post('unit_usaha', TRUE)),
                                'id_bentuk_permodalan'      => escape($this->input->post('id_bentuk_permodalan', TRUE)),
                                'tahun_bantuan'             => escape($this->input->post('tahun_bantuan', TRUE)),
                                'jumlah_uang_diterima'      => escape($this->input->post('jumlah_uang_diterima', TRUE)),
                                'unit_pemberi_modal'        => escape($this->input->post('unit_pemberi_modal', TRUE)),
                                'opd_pemberi_bantuan'       => null,
                                'sub_kegiatan'              => null,
                                'nm_alat'                   => null,
                                'upload_foto_alat'          => null,
                                'pemberi_permodalan'        => null,
                                'mod_by' 			        => $create_by,
                                'mod_date' 			        => $create_date,
                                'mod_ip' 			        => $create_ip
                            );
                            /*query update*/
                            $this->db->where('id_permodalan', abs($id_permodalan));
                            $this->db->update('data_permodalan', $data);
                            return array('response'=>'SUCCESS', 'nikID'=>$nik);
                        } else {
                            $config = array(
                                'upload_path'       => './' . $dirname . '/',
                                'allowed_types'     => 'png|jpg|jpeg',
                                'file_name'         => 'file_'.$nik,
                                'file_ext_tolower'  => TRUE,
                                'max_size'          => 3072,
                                'max_filename'      => 0,
                                'remove_spaces'     => TRUE
                            );
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('upload_foto')) {
                                $file_upload = $foto_old;
                            } else {
                                $upload_data = $this->upload->data();
                                $file_upload = $upload_data['file_name'];
                            }
            
                            $data = array(
                            'nik'                       => $nik,
                            'id_pelatihan'              => escape($this->input->post('id_pelatihan', TRUE)),
                            'id_jenis_kegiatan'         => escape($this->input->post('id_jenis_kegiatan', TRUE)),
                            'no_nib'                    => escape($this->input->post('no_nib', TRUE)),
                            'nama'                      => escape($this->input->post('nama', TRUE)),
                            'no_hp'                     => escape($this->input->post('no_hp', TRUE)),
                            'npwp'                      => escape($this->input->post('npwp', TRUE)),
                            'email'                     => escape($this->input->post('email', TRUE)),
                            'unit_usaha'                => escape($this->input->post('unit_usaha', TRUE)),
                            'id_bentuk_permodalan'      => escape($this->input->post('id_bentuk_permodalan', TRUE)),
                            'tahun_bantuan'             => escape($this->input->post('tahun_bantuan', TRUE)),
                            'jumlah_uang_diterima'      => null,
                            'unit_pemberi_modal'        => null,
                            'opd_pemberi_bantuan'       => escape($this->input->post('opd_pemberi_bantuan', TRUE)),
                            'sub_kegiatan'              => escape($this->input->post('sub_kegiatan', TRUE)),
                            'nm_alat'                   => escape($this->input->post('nm_alat', TRUE)),
                            'upload_foto_alat'          => $file_upload,
                            'pemberi_permodalan'        => escape($this->input->post('pemberi_permodalan', TRUE)),
                            'mod_by' 			        => $create_by,
                            'mod_date' 			        => $create_date,
                            'mod_ip' 			        => $create_ip
                            );
                            /*query update*/
                            $this->db->where('id_permodalan', abs($id_permodalan));
                            $this->db->update('data_permodalan', $data);
                            return array('response'=>'SUCCESS', 'nikID'=>$nik);
                        }
                    } else {
                        if($id == 1 ) {
                            $data = array(
                                'nik'                       => $nik,
                                'id_pelatihan'              => escape($this->input->post('id_pelatihan', TRUE)),
                                'id_jenis_kegiatan'         => escape($this->input->post('id_jenis_kegiatan', TRUE)),
                                'no_nib'                    => escape($this->input->post('no_nib', TRUE)),
                                'nama'                      => escape($this->input->post('nama', TRUE)),
                                'no_hp'                     => escape($this->input->post('no_hp', TRUE)),
                                'npwp'                      => escape($this->input->post('npwp', TRUE)),
                                'email'                     => escape($this->input->post('email', TRUE)),
                                'unit_usaha'                => escape($this->input->post('unit_usaha', TRUE)),
                                'id_bentuk_permodalan'      => escape($this->input->post('id_bentuk_permodalan', TRUE)),
                                'tahun_bantuan'             => escape($this->input->post('tahun_bantuan', TRUE)),
                                'jumlah_uang_diterima'      => escape($this->input->post('jumlah_uang_diterima', TRUE)),
                                'unit_pemberi_modal'        => escape($this->input->post('unit_pemberi_modal', TRUE)),
                                'opd_pemberi_bantuan'       => null,
                                'sub_kegiatan'              => null,
                                'nm_alat'                   => null,
                                'upload_foto_alat'          => null,
                                'pemberi_permodalan'        => null,
                                'mod_by' 			        => $create_by,
                                'mod_date' 			        => $create_date,
                                'mod_ip' 			        => $create_ip
                            );
                            /*query update*/
                            $this->db->where('id_permodalan', abs($id_permodalan));
                            $this->db->update('data_permodalan', $data);
                            return array('response'=>'SUCCESS', 'nikID'=>$nik);
                        } else {
                            $config = array(
                                'upload_path'       => './' . $dirname . '/',
                                'allowed_types'     => 'png|jpg|jpeg',
                                'file_name'         => 'file_'.$nik,
                                'file_ext_tolower'  => TRUE,
                                'max_size'          => 3072,
                                'max_filename'      => 0,
                                'remove_spaces'     => TRUE
                            );
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('upload_foto')) {
                                $file_upload = $foto_old;
                            } else {
                                //hapus image
                                if (file_exists(realpath('./' . $dirname . '/' . $foto_old))) {
                                    unlink(realpath('./' . $dirname . '/' . $foto_old));
                                }
                                $upload_data = $this->upload->data();
                                $file_upload = $upload_data['file_name'];
                            }
            
                            $data = array(
                            'nik'                       => $nik,
                            'id_pelatihan'              => escape($this->input->post('id_pelatihan', TRUE)),
                            'id_jenis_kegiatan'         => escape($this->input->post('id_jenis_kegiatan', TRUE)),
                            'no_nib'                    => escape($this->input->post('no_nib', TRUE)),
                            'nama'                      => escape($this->input->post('nama', TRUE)),
                            'no_hp'                     => escape($this->input->post('no_hp', TRUE)),
                            'npwp'                      => escape($this->input->post('npwp', TRUE)),
                            'email'                     => escape($this->input->post('email', TRUE)),
                            'unit_usaha'                => escape($this->input->post('unit_usaha', TRUE)),
                            'id_bentuk_permodalan'      => escape($this->input->post('id_bentuk_permodalan', TRUE)),
                            'tahun_bantuan'             => escape($this->input->post('tahun_bantuan', TRUE)),
                            'jumlah_uang_diterima'      => null,
                            'unit_pemberi_modal'        => null,
                            'opd_pemberi_bantuan'       => escape($this->input->post('opd_pemberi_bantuan', TRUE)),
                            'sub_kegiatan'              => escape($this->input->post('sub_kegiatan', TRUE)),
                            'nm_alat'                   => escape($this->input->post('nm_alat', TRUE)),
                            'upload_foto_alat'          => $file_upload,
                            'pemberi_permodalan'        => escape($this->input->post('pemberi_permodalan', TRUE)),
                            'mod_by' 			        => $create_by,
                            'mod_date' 			        => $create_date,
                            'mod_ip' 			        => $create_ip
                            );
                            /*query update*/
                            $this->db->where('id_permodalan', abs($id_permodalan));
                            $this->db->update('data_permodalan', $data);
                            return array('response'=>'SUCCESS', 'nikID'=>$nik);
                        }
                    }
                } else {
                    if($id != $permodalanId) {
                        if($id == 1 ) {
                            $data = array(
                                'nik'                       => $nik,
                                'id_pelatihan'              => escape($this->input->post('id_pelatihan', TRUE)),
                                'id_jenis_kegiatan'         => escape($this->input->post('id_jenis_kegiatan', TRUE)),
                                'no_nib'                    => escape($this->input->post('no_nib', TRUE)),
                                'nama'                      => escape($this->input->post('nama', TRUE)),
                                'no_hp'                     => escape($this->input->post('no_hp', TRUE)),
                                'npwp'                      => escape($this->input->post('npwp', TRUE)),
                                'email'                     => escape($this->input->post('email', TRUE)),
                                'unit_usaha'                => escape($this->input->post('unit_usaha', TRUE)),
                                'id_bentuk_permodalan'      => escape($this->input->post('id_bentuk_permodalan', TRUE)),
                                'tahun_bantuan'             => escape($this->input->post('tahun_bantuan', TRUE)),
                                'jumlah_uang_diterima'      => escape($this->input->post('jumlah_uang_diterima', TRUE)),
                                'unit_pemberi_modal'        => escape($this->input->post('unit_pemberi_modal', TRUE)),
                                'opd_pemberi_bantuan'       => null,
                                'sub_kegiatan'              => null,
                                'nm_alat'                   => null,
                                'upload_foto_alat'          => null,
                                'pemberi_permodalan'        => null,
                                'mod_by' 			        => $create_by,
                                'mod_date' 			        => $create_date,
                                'mod_ip' 			        => $create_ip
                            );
                            /*query update*/
                            $this->db->where('id_permodalan', abs($id_permodalan));
                            $this->db->update('data_permodalan', $data);
                            return array('response'=>'SUCCESS', 'nikID'=>$nik);
                        } else {
                            $config = array(
                                'upload_path'       => './' . $dirname . '/',
                                'allowed_types'     => 'png|jpg|jpeg',
                                'file_name'         => 'file_'.$nik,
                                'file_ext_tolower'  => TRUE,
                                'max_size'          => 3072,
                                'max_filename'      => 0,
                                'remove_spaces'     => TRUE
                            );
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('upload_foto')) {
                                $file_upload = $foto_old;
                            } else {
                                if (file_exists(realpath('./' . $dirname . '/' . $foto_old))) {
                                    unlink(realpath('./' . $dirname . '/' . $foto_old));
                                }
                                $upload_data = $this->upload->data();
                                $file_upload = $upload_data['file_name'];
                            }
            
                            $data = array(
                            'nik'                       => $nik,
                            'id_pelatihan'              => escape($this->input->post('id_pelatihan', TRUE)),
                            'id_jenis_kegiatan'         => escape($this->input->post('id_jenis_kegiatan', TRUE)),
                            'no_nib'                    => escape($this->input->post('no_nib', TRUE)),
                            'nama'                      => escape($this->input->post('nama', TRUE)),
                            'no_hp'                     => escape($this->input->post('no_hp', TRUE)),
                            'npwp'                      => escape($this->input->post('npwp', TRUE)),
                            'email'                     => escape($this->input->post('email', TRUE)),
                            'unit_usaha'                => escape($this->input->post('unit_usaha', TRUE)),
                            'id_bentuk_permodalan'      => escape($this->input->post('id_bentuk_permodalan', TRUE)),
                            'tahun_bantuan'             => escape($this->input->post('tahun_bantuan', TRUE)),
                            'jumlah_uang_diterima'      => null,
                            'unit_pemberi_modal'        => null,
                            'opd_pemberi_bantuan'       => escape($this->input->post('opd_pemberi_bantuan', TRUE)),
                            'sub_kegiatan'              => escape($this->input->post('sub_kegiatan', TRUE)),
                            'nm_alat'                   => escape($this->input->post('nm_alat', TRUE)),
                            'upload_foto_alat'          => $file_upload,
                            'pemberi_permodalan'        => escape($this->input->post('pemberi_permodalan', TRUE)),
                            'mod_by' 			        => $create_by,
                            'mod_date' 			        => $create_date,
                            'mod_ip' 			        => $create_ip
                            );
                            /*query update*/
                            $this->db->where('id_permodalan', abs($id_permodalan));
                            $this->db->update('data_permodalan', $data);
                            return array('response'=>'SUCCESS', 'nikID'=>$nik);
                        }
                    } else {
                        if($id == 1 ) {
                            $data = array(
                                'nik'                       => $nik,
                                'id_pelatihan'              => escape($this->input->post('id_pelatihan', TRUE)),
                                'id_jenis_kegiatan'         => escape($this->input->post('id_jenis_kegiatan', TRUE)),
                                'no_nib'                    => escape($this->input->post('no_nib', TRUE)),
                                'nama'                      => escape($this->input->post('nama', TRUE)),
                                'no_hp'                     => escape($this->input->post('no_hp', TRUE)),
                                'npwp'                      => escape($this->input->post('npwp', TRUE)),
                                'email'                     => escape($this->input->post('email', TRUE)),
                                'unit_usaha'                => escape($this->input->post('unit_usaha', TRUE)),
                                'id_bentuk_permodalan'      => escape($this->input->post('id_bentuk_permodalan', TRUE)),
                                'tahun_bantuan'             => escape($this->input->post('tahun_bantuan', TRUE)),
                                'jumlah_uang_diterima'      => escape($this->input->post('jumlah_uang_diterima', TRUE)),
                                'unit_pemberi_modal'        => escape($this->input->post('unit_pemberi_modal', TRUE)),
                                'opd_pemberi_bantuan'       => null,
                                'sub_kegiatan'              => null,
                                'nm_alat'                   => null,
                                'upload_foto_alat'          => null,
                                'pemberi_permodalan'        => null,
                                'mod_by' 			        => $create_by,
                                'mod_date' 			        => $create_date,
                                'mod_ip' 			        => $create_ip
                            );
                            /*query update*/
                            $this->db->where('id_permodalan', abs($id_permodalan));
                            $this->db->update('data_permodalan', $data);
                            return array('response'=>'SUCCESS', 'nikID'=>$nik);
                        } else {
                            $config = array(
                                'upload_path'       => './' . $dirname . '/',
                                'allowed_types'     => 'png|jpg|jpeg',
                                'file_name'         => 'file_'.$nik,
                                'file_ext_tolower'  => TRUE,
                                'max_size'          => 3072,
                                'max_filename'      => 0,
                                'remove_spaces'     => TRUE
                            );
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            if (!$this->upload->do_upload('upload_foto')) {
                                $file_upload = $foto_old;
                            } else {
                                //hapus image
                                if (file_exists(realpath('./' . $dirname . '/' . $foto_old))) {
                                    unlink(realpath('./' . $dirname . '/' . $foto_old));
                                }
                                $upload_data = $this->upload->data();
                                $file_upload = $upload_data['file_name'];
                            }
            
                            $data = array(
                            'nik'                       => $nik,
                            'id_pelatihan'              => escape($this->input->post('id_pelatihan', TRUE)),
                            'id_jenis_kegiatan'         => escape($this->input->post('id_jenis_kegiatan', TRUE)),
                            'no_nib'                    => escape($this->input->post('no_nib', TRUE)),
                            'nama'                      => escape($this->input->post('nama', TRUE)),
                            'no_hp'                     => escape($this->input->post('no_hp', TRUE)),
                            'npwp'                      => escape($this->input->post('npwp', TRUE)),
                            'email'                     => escape($this->input->post('email', TRUE)),
                            'unit_usaha'                => escape($this->input->post('unit_usaha', TRUE)),
                            'id_bentuk_permodalan'      => escape($this->input->post('id_bentuk_permodalan', TRUE)),
                            'tahun_bantuan'             => escape($this->input->post('tahun_bantuan', TRUE)),
                            'jumlah_uang_diterima'      => null,
                            'unit_pemberi_modal'        => null,
                            'opd_pemberi_bantuan'       => escape($this->input->post('opd_pemberi_bantuan', TRUE)),
                            'sub_kegiatan'              => escape($this->input->post('sub_kegiatan', TRUE)),
                            'nm_alat'                   => escape($this->input->post('nm_alat', TRUE)),
                            'upload_foto_alat'          => $file_upload,
                            'pemberi_permodalan'        => escape($this->input->post('pemberi_permodalan', TRUE)),
                            'mod_by' 			        => $create_by,
                            'mod_date' 			        => $create_date,
                            'mod_ip' 			        => $create_ip
                            );
                            /*query update*/
                            $this->db->where('id_permodalan', abs($id_permodalan));
                            $this->db->update('data_permodalan', $data);
                            return array('response'=>'SUCCESS', 'nikID'=>$nik);
                        }
                    }
                }
                
            }
        }
    }

    /* Fungsi untuk delete data */
    public function deleteData() {
        $id = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
        //cek data by id
        $dataSearch = $this->getDataDetail($id);
        $nik = !empty($dataSearch) ? $dataSearch['nik'] : '';
        if (count($dataSearch) <= 0)
            return array('response'=>'ERROR', 'nama'=>'');
        else {
            $this->db->where('id_permodalan', abs($id));
            $count = $this->db->count_all_results('data_permodalan');
            if ($count == 0)
                return array('response'=>'ERRDATA', 'nama'=>$nik);
            else {
                $upload_foto_alat 	= !empty($dataSearch) ? $dataSearch['upload_foto_alat'] : 0;
				unlink(realpath('./uploads/alat/' . $upload_foto_alat));

                $this->db->where('id_permodalan', abs($id));
                $this->db->delete('data_permodalan');
                return array('response'=>'SUCCESS', 'nama'=>$nik);
            }
        }
    }

    public function get_nik_existance($nik)
	{
		$this->db->where('nik', $nik);
		$query = $this->db->get('data_permodalan');
		return $query->row_array();
	}

    public function get_user_existance($email)
	{
		$this->db->where('email', $email);
		$query = $this->db->get('data_permodalan');
		return $query->row_array();
	}
}

// This is the end of auth signin model
