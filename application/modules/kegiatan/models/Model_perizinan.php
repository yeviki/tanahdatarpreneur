<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of mata diklat model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_perizinan extends CI_Model {

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
        return $this->db->count_all_results('data_perizinan');
    }

    private function _get_datatables_query() {
        $this->db->select('a.id_perizinan,
                           a.nik,
                           a.id_jenis_kegiatan,
                           a.id_pelatihan,
                           a.no_nib,
                           a.nama,
                           a.alamat,
                           a.no_hp,
                           a.npwp,
                           a.email,
                           a.id_province,
						   a.id_regency,
						   a.id_opd,
                           b.nm_jenis_kegiatan
                           ');
        $this->db->from('data_perizinan a');
        $this->db->join('ms_jenis_kegiatan b', 'a.id_jenis_kegiatan = b.id_jenis_kegiatan', 'inner');
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
        $this->db->order_by('id_perizinan ASC');
    }

    /*Fungsi get data edit by id*/
    public function getDataDetail($id) {
        $this->db->where('id_perizinan', abs($id));
        $query = $this->db->get('data_perizinan');
        return $query->row_array();
    }

    /* Fungsi untuk insert data */
    public function insertData() {
        //get data
        $create_by      = $this->app_loader->current_account();
        $create_date    = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip      = $this->input->ip_address();
        $nik            = escape($this->input->post('nik', TRUE));
        //cek nama matadiklat duplicate
        $this->db->where('nik', $nik);
        $qTot = $this->db->count_all_results('data_perizinan');
        if($qTot > 0)
            return array('response'=>'ERROR', 'nama'=>$nik);
        else {
            $data = array(
                'nik'               => $nik,
                'id_jenis_kegiatan' => escape($this->input->post('id_jenis_kegiatan', TRUE)),
                'id_pelatihan'      => escape($this->input->post('id_pelatihan', TRUE)),
                'id_province'       => escape($this->input->post('province', TRUE)),
				'id_regency'        => escape($this->input->post('regency', TRUE)),
                'no_nib'            => escape($this->input->post('no_nib', TRUE)),
                'nama'              => escape($this->input->post('nama', TRUE)),
                'alamat'            => escape($this->input->post('alamat', TRUE)),
                'no_hp'             => escape($this->input->post('no_hp', TRUE)),
                'npwp'              => escape($this->input->post('npwp', TRUE)),
                'email'             => escape($this->input->post('email', TRUE)),
                'create_by' 		=> $create_by,
                'create_date' 		=> $create_date,
                'create_ip' 		=> $create_ip,
                'mod_by' 			=> $create_by,
                'mod_date' 			=> $create_date,
                'mod_ip' 			=> $create_ip
            );
            /*query insert*/
            $this->db->insert('data_perizinan', $data);
            return array('response'=>'SUCCESS', 'nama'=>$nik);
        }
    }

    /* Fungsi untuk update data */
    public function updateData() {
        //get data
        $create_by          = $this->app_loader->current_account();
        $create_date        = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip          = $this->input->ip_address();
        $id_perizinan	    = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
        $nik                = escape($this->input->post('nik', TRUE));
        //cek data by id
        $data_search = $this->getDataDetail($id_perizinan);
        if(count($data_search) <= 0)
            return array('response'=>'ERROR', 'nama'=>'');
        else {
            //cek nama kontrol duplicate
            $this->db->where('nik', $nik);
            $this->db->where('id_perizinan !=', $id_perizinan);
            $qTot = $this->db->count_all_results('data_perizinan');
            if($qTot > 0)
                return array('response'=>'ERRDATA', 'nama'=>$nik);
            else {
                $data = array(
                    'nik'               => $nik,
                    'id_jenis_kegiatan' => escape($this->input->post('id_jenis_kegiatan', TRUE)),
                    'id_pelatihan'      => escape($this->input->post('id_pelatihan', TRUE)),
                    'id_province'       => escape($this->input->post('province', TRUE)),
				    'id_regency'        => escape($this->input->post('regency', TRUE)),
                    'no_nib'            => escape($this->input->post('no_nib', TRUE)),
                    'nama'              => escape($this->input->post('nama', TRUE)),
                    'alamat'            => escape($this->input->post('alamat', TRUE)),
                    'no_hp'             => escape($this->input->post('no_hp', TRUE)),
                    'npwp'              => escape($this->input->post('npwp', TRUE)),
                    'email'             => escape($this->input->post('email', TRUE)),
					'mod_by' 			=> $create_by,
					'mod_date' 			=> $create_date,
					'mod_ip' 			=> $create_ip
                );
                /*query update*/
                $this->db->where('id_perizinan', abs($id_perizinan));
                $this->db->update('data_perizinan', $data);
                return array('response'=>'SUCCESS', 'nama'=>$nik);
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
            $this->db->where('id_perizinan', abs($id));
            $count = $this->db->count_all_results('data_perizinan');
            if ($count == 0)
                return array('response'=>'ERRDATA', 'nama'=>$nik);
            else {
                $this->db->where('id_perizinan', abs($id));
                $this->db->delete('data_perizinan');
                return array('response'=>'SUCCESS', 'nama'=>$nik);
            }
        }
    }

    public function get_nik_existance($nik)
	{
		$this->db->where('nik', $nik);
		$query = $this->db->get('data_perizinan');
		return $query->row_array();
	}

    public function get_user_existance($email)
	{
		$this->db->where('email', $email);
		$query = $this->db->get('data_perizinan');
		return $query->row_array();
	}
}

// This is the end of auth signin model
