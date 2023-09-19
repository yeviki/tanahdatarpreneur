<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of mata diklat model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_syarat_tambahan extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*Fungsi Get Data List*/
    var $search = array('nm_syarat_dinamis');
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
        return $this->db->count_all_results('ms_syarat_dinamis');
    }

    private function _get_datatables_query() {
        $this->db->select('a.id_syarat_dinamis,
                           a.nm_syarat_dinamis,
                           a.id_opd,
                           ');
        $this->db->from('ms_syarat_dinamis a');
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
        $this->db->order_by('id_syarat_dinamis ASC');
    }

    /*Fungsi get data edit by id*/
    public function getDataDetail($id) {
        $this->db->where('id_syarat_dinamis', abs($id));
        $query = $this->db->get('ms_syarat_dinamis');
        return $query->row_array();
    }

    /* Fungsi untuk insert data */
    public function insertData() {
        //get data
        $create_by      = $this->app_loader->current_account();
        $opd_id         = $this->app_loader->current_opdid();
        $create_date    = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip      = $this->input->ip_address();
        $nm_syarat_dinamis = escape($this->input->post('nm_syarat_dinamis', TRUE));
        //cek nama matadiklat duplicate
        $this->db->where('nm_syarat_dinamis', $nm_syarat_dinamis);
        $qTot = $this->db->count_all_results('ms_syarat_dinamis');
        if($qTot > 0)
            return array('response'=>'ERROR', 'nama'=>$nm_syarat_dinamis);
        else {
            $data = array(
                'nm_syarat_dinamis' => $nm_syarat_dinamis,
                'id_opd' 			=> $opd_id
            );
            /*query insert*/
            $this->db->insert('ms_syarat_dinamis', $data);
            return array('response'=>'SUCCESS', 'nama'=>$nm_syarat_dinamis);
        }
    }

    /* Fungsi untuk update data */
    public function updateData() {
        //get data
        $create_by          = $this->app_loader->current_account();
        $create_date        = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip          = $this->input->ip_address();
        $id_syarat_dinamis	    = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
        $nm_syarat_dinamis        = escape($this->input->post('nm_syarat_dinamis', TRUE));
        //cek data by id
        $data_search = $this->getDataDetail($id_syarat_dinamis);
        if(count($data_search) <= 0)
            return array('response'=>'ERROR', 'nama'=>'');
        else {
            //cek nama kontrol duplicate
            $this->db->where('nm_syarat_dinamis', $nm_syarat_dinamis);
            $this->db->where('id_syarat_dinamis !=', $id_syarat_dinamis);
            $qTot = $this->db->count_all_results('ms_syarat_dinamis');
            if($qTot > 0)
                return array('response'=>'ERRDATA', 'nama'=>$nm_syarat_dinamis);
            else {
                $data = array(
                    'nm_syarat_dinamis'  => $nm_syarat_dinamis
                );
                /*query update*/
                $this->db->where('id_syarat_dinamis', abs($id_syarat_dinamis));
                $this->db->update('ms_syarat_dinamis', $data);
                return array('response'=>'SUCCESS', 'nama'=>$nm_syarat_dinamis);
            }
        }
    }

    /* Fungsi untuk delete data */
    public function deleteData() {
        $id = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
        //cek data by id
        $dataSearch = $this->getDataDetail($id);
        $nm_syarat_dinamis = !empty($dataSearch) ? $dataSearch['nm_syarat_dinamis'] : '';
        if (count($dataSearch) <= 0)
            return array('response'=>'ERROR', 'nama'=>'');
        else {
            $this->db->where('id_syarat_dinamis', abs($id));
            $count = $this->db->count_all_results('data_rules_syarat_dinamis');
            if ($count > 0)
                return array('response'=>'ERRDATA', 'nama'=>$nm_syarat_dinamis);
            else {
                $this->db->where('id_syarat_dinamis', abs($id));
                $this->db->delete('ms_syarat_dinamis');
                return array('response'=>'SUCCESS', 'nama'=>$nm_syarat_dinamis);
            }
        }
    }
}

// This is the end of auth signin model
