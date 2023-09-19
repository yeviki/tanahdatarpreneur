<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of mata diklat model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_set_jadwal extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*Fungsi Get Data List*/
    var $search = array('nm_sub_kegiatan');
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
        return $this->db->count_all_results('ms_jadwal');
    }

    private function _get_datatables_query() {
        $this->db->select('a.id_jadwal,
                           a.id_master_pelatihan,
                           a.nm_sub_kegiatan,
                           a.tanggal_pelatihan,
                           a.tanggal_pelatihan_akhir,
                           a.mulai_registrasi,
                           a.akhir_registrasi,
                           a.tempat_pelatihan,
                           a.pagu_anggaran,
                           a.nm_sub_kegiatan,
                           a.id_jenis_kegiatan,
                           a.id_opd,
                           a.id_status,
                           b.nm_jenis_kegiatan,
                           c.nm_pelatihan
                           ');
        $this->db->from('ms_jadwal a');
        $this->db->join('ms_jenis_kegiatan b', 'a.id_jenis_kegiatan = b.id_jenis_kegiatan', 'inner');
        $this->db->join('ms_pelatihan c', 'a.id_master_pelatihan = c.id_master_pelatihan', 'left');
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
        $this->db->order_by('id_jadwal ASC');
    }

    /*Fungsi get data edit by id*/
    public function getDataDetail($id) {
        $this->db->where('id_jadwal', abs($id));
        $query = $this->db->get('ms_jadwal');
        return $query->row_array();
    }

    /* Fungsi untuk insert data */
    public function insertData() {
        //get data
        $create_by      = $this->app_loader->current_account();
        $opd_id         = $this->app_loader->current_opdid();
        $create_date    = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip      = $this->input->ip_address();
        $nm_sub_kegiatan        = escape($this->input->post('nm_sub_kegiatan', TRUE));
        $daterange_regis        = escape($this->input->post('daterange', TRUE));
        $daterange_pelatihan    = escape($this->input->post('daterange1', TRUE));
        // die($daterange);

        $stringRegis        = explode(' - ',$daterange_regis);
        $stringPelatihan    = explode(' - ',$daterange_pelatihan);

        $date1 = $stringRegis[0];
        $date2 = $stringRegis[1];

        $date3 = $stringPelatihan[0];
        $date4 = $stringPelatihan[1];

        //cek nama matadiklat duplicate
        $data = array(
            'nm_sub_kegiatan'           => $nm_sub_kegiatan,
            'id_master_pelatihan'       => escape($this->input->post('id_master_pelatihan', TRUE)),
            'mulai_registrasi'          => $date1,
            'akhir_registrasi'          => $date2,
            'tanggal_pelatihan'         => $date3,
            'tanggal_pelatihan_akhir'   => $date4,
            'tempat_pelatihan'          => escape($this->input->post('tempat_pelatihan', TRUE)),
            'pagu_anggaran'             => escape($this->input->post('pagu_anggaran', TRUE)),
            'nm_sub_kegiatan'           => escape($this->input->post('nm_sub_kegiatan', TRUE)),
            'id_jenis_kegiatan'         => escape($this->input->post('id_jenis_kegiatan', TRUE)),
            'id_status'                 => escape($this->input->post('status', TRUE)),
            'id_opd' 			=> $opd_id,
            'create_by' 		=> $create_by,
            'create_date' 		=> $create_date,
            'create_ip' 		=> $create_ip,
            'mod_by' 			=> $create_by,
            'mod_date' 			=> $create_date,
            'mod_ip' 			=> $create_ip
        );
        /*query insert*/
        $this->db->insert('ms_jadwal', $data);
        return array('response'=>'SUCCESS', 'nama'=>$nm_sub_kegiatan);
    }

    /* Fungsi untuk update data */
    public function updateData() {
        //get data
        $create_by          = $this->app_loader->current_account();
        $create_date        = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip          = $this->input->ip_address();
        $id_jadwal	            = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
        $nm_sub_kegiatan        = escape($this->input->post('nm_sub_kegiatan', TRUE));
        $daterange_regis        = escape($this->input->post('daterange', TRUE));
        $daterange_pelatihan    = escape($this->input->post('daterange1', TRUE));
        // die($daterange);

        $stringRegis        = explode(' - ',$daterange_regis);
        $stringPelatihan    = explode(' - ',$daterange_pelatihan);

        $date1 = $stringRegis[0];
        $date2 = $stringRegis[1];

        $date3 = $stringPelatihan[0];
        $date4 = $stringPelatihan[1];

        //cek data by id
        $data_search = $this->getDataDetail($id_jadwal);
        if(count($data_search) <= 0)
            return array('response'=>'ERROR', 'nama'=>'');
        else {
                $data = array(
                    'nm_sub_kegiatan'           => $nm_sub_kegiatan,
                    'id_master_pelatihan'       => escape($this->input->post('id_master_pelatihan', TRUE)),
                    'tanggal_pelatihan'         => escape($this->input->post('tanggal_pelatihan', TRUE)),
                    'mulai_registrasi'          => $date1,
                    'akhir_registrasi'          => $date2,
                    'tanggal_pelatihan'         => $date3,
                    'tanggal_pelatihan_akhir'   => $date4,
                    'tempat_pelatihan'          => escape($this->input->post('tempat_pelatihan', TRUE)),
                    'pagu_anggaran'             => escape($this->input->post('pagu_anggaran', TRUE)),
                    'nm_sub_kegiatan'           => escape($this->input->post('nm_sub_kegiatan', TRUE)),
                    'id_jenis_kegiatan'         => escape($this->input->post('id_jenis_kegiatan', TRUE)),
                    'id_status'                 => escape($this->input->post('status', TRUE)),
					'mod_by' 			 => $create_by,
					'mod_date' 			 => $create_date,
					'mod_ip' 			 => $create_ip
                );
                /*query update*/
                $this->db->where('id_jadwal', abs($id_jadwal));
                $this->db->update('ms_jadwal', $data);
                return array('response'=>'SUCCESS', 'nama'=>$nm_sub_kegiatan);
        }
    }

    /* Fungsi untuk delete data */
    public function deleteData() {
        $id = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
        //cek data by id
        $dataSearch = $this->getDataDetail($id);
        $nm_sub_kegiatan = !empty($dataSearch) ? $dataSearch['nm_sub_kegiatan'] : '';
        if (count($dataSearch) <= 0)
            return array('response'=>'ERROR', 'nama'=>'');
        else {
            $this->db->where('id_jadwal', abs($id));
            $count = $this->db->count_all_results('data_pelatihan');
            if ($count > 0)
                return array('response'=>'ERRDATA', 'nama'=>$nm_sub_kegiatan);
            else {
                $this->db->where('id_jadwal', abs($id));
                $this->db->delete('ms_jadwal');
                return array('response'=>'SUCCESS', 'nama'=>$nm_sub_kegiatan);
            }
        }
    }
}

// This is the end of auth signin model
