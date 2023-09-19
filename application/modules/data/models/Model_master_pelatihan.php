<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of mata diklat model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_master_pelatihan extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*Fungsi Get Data List*/
    var $search = array('nm_pelatihan');
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
        return $this->db->count_all_results('ms_pelatihan');
    }

    private function _get_datatables_query() {
        $this->db->select('a.id_master_pelatihan,
                           a.nm_pelatihan,
                           a.id_kat_urusan,
                           a.id_opd,
                           b.nm_kat_urusan
                           ');
        $this->db->from('ms_pelatihan a');
        $this->db->join('data_kat_urusan b', 'a.id_kat_urusan = b.id_kat_urusan', 'inner');
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
        $this->db->order_by('id_master_pelatihan ASC');
    }

    /*Fungsi get data edit by id*/
    public function getDataDetail($id) {
        $this->db->where('id_master_pelatihan', abs($id));
        $query = $this->db->get('ms_pelatihan');
        return $query->row_array();
    }

    /* Fungsi untuk insert data */
    public function insertData() {
        //get data
        $create_by      = $this->app_loader->current_account();
        $opd_id         = $this->app_loader->current_opdid();
        $create_date    = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip      = $this->input->ip_address();
        $nm_pelatihan = escape($this->input->post('nm_pelatihan', TRUE));
        //cek nama matadiklat duplicate
        $this->db->where('nm_pelatihan', $nm_pelatihan);
        $qTot = $this->db->count_all_results('ms_pelatihan');
        if($qTot > 0)
            return array('response'=>'ERROR', 'nama'=>$nm_pelatihan);
        else {
            $data = array(
                'nm_pelatihan'      => $nm_pelatihan,
                'id_kat_urusan'     => escape($this->input->post('id_kat_urusan', TRUE)),
                'id_opd' 			=> $opd_id,
                'create_by' 		=> $create_by,
                'create_date' 		=> $create_date,
                'create_ip' 		=> $create_ip,
                'mod_by' 			=> $create_by,
                'mod_date' 			=> $create_date,
                'mod_ip' 			=> $create_ip
            );
            /*query insert*/
            $this->db->insert('ms_pelatihan', $data);
            return array('response'=>'SUCCESS', 'nama'=>$nm_pelatihan);
        }
    }

    /* Fungsi untuk update data */
    public function updateData() {
        //get data
        $create_by          = $this->app_loader->current_account();
        $create_date        = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip          = $this->input->ip_address();
        $id_master_pelatihan	    = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
        $nm_pelatihan        = escape($this->input->post('nm_pelatihan', TRUE));
        //cek data by id
        $data_search = $this->getDataDetail($id_master_pelatihan);
        if(count($data_search) <= 0)
            return array('response'=>'ERROR', 'nama'=>'');
        else {
            //cek nama kontrol duplicate
            $this->db->where('nm_pelatihan', $nm_pelatihan);
            $this->db->where('id_master_pelatihan !=', $id_master_pelatihan);
            $qTot = $this->db->count_all_results('ms_pelatihan');
            if($qTot > 0)
                return array('response'=>'ERRDATA', 'nama'=>$nm_pelatihan);
            else {
                $data = array(
                    'nm_pelatihan'       => $nm_pelatihan,
                    'id_kat_urusan'      => escape($this->input->post('id_kat_urusan', TRUE)),
					'mod_by' 			 => $create_by,
					'mod_date' 			 => $create_date,
					'mod_ip' 			 => $create_ip
                );
                /*query update*/
                $this->db->where('id_master_pelatihan', abs($id_master_pelatihan));
                $this->db->update('ms_pelatihan', $data);
                return array('response'=>'SUCCESS', 'nama'=>$nm_pelatihan);
            }
        }
    }

    /* Fungsi untuk delete data */
    public function deleteData() {
        $id = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
        //cek data by id
        $dataSearch = $this->getDataDetail($id);
        $nm_pelatihan = !empty($dataSearch) ? $dataSearch['nm_pelatihan'] : '';
        if (count($dataSearch) <= 0)
            return array('response'=>'ERROR', 'nama'=>'');
        else {
            $this->db->where('id_master_pelatihan', abs($id));
            $count = $this->db->count_all_results('ms_jadwal');
            if ($count > 0)
                return array('response'=>'ERRDATA', 'nama'=>$nm_pelatihan);
            else {
                $this->db->where('id_master_pelatihan', abs($id));
                $this->db->delete('ms_pelatihan');
                return array('response'=>'SUCCESS', 'nama'=>$nm_pelatihan);
            }
        }
    }
}

// This is the end of auth signin model
