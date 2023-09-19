<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of mata diklat model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_youtube extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    /*Fungsi Get Data List*/
    var $search = array('title');
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
        return $this->db->count_all_results('data_youtube');
    }

    private function _get_datatables_query() {
        $this->db->select('a.id_youtube,
                           a.title,
                           a.url,
                           a.id_pelatihan,
                           a.id_opd
                           ');
        $this->db->from('data_youtube a');
        $this->db->join('data_pelatihan b', 'a.id_pelatihan = b.id_pelatihan', 'inner');
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
        $this->db->order_by('id_youtube ASC');
    }

    /*Fungsi get data edit by id*/
    public function getDataDetail($id) {
        $this->db->where('id_youtube', abs($id));
        $query = $this->db->get('data_youtube');
        return $query->row_array();
    }

    /* Fungsi untuk insert data */
    public function insertData() {
        //get data
        $create_by      = $this->app_loader->current_account();
        $opd_id         = $this->app_loader->current_opdid();
        $create_date    = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip      = $this->input->ip_address();
        $title = escape($this->input->post('title', TRUE));
        //cek nama matadiklat duplicate
        $this->db->where('title', $title);
        $qTot = $this->db->count_all_results('data_youtube');
        if($qTot > 0)
            return array('response'=>'ERROR', 'nama'=>$title);
        else {
            $data = array(
                'title'             => $title,
                'url'               => escape($this->input->post('url', TRUE)),
                'id_pelatihan'      => escape($this->input->post('id_pelatihan', TRUE)),
                'id_opd' 			=> $opd_id
            );
            /*query insert*/
            $this->db->insert('data_youtube', $data);
            return array('response'=>'SUCCESS', 'nama'=>$title);
        }
    }

    /* Fungsi untuk update data */
    public function updateData() {
        //get data
        $create_by          = $this->app_loader->current_account();
        $create_date        = gmdate('Y-m-d H:i:s', time()+60*60*7);
        $create_ip          = $this->input->ip_address();
        $id_youtube	        = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
        $title              = escape($this->input->post('title', TRUE));
        //cek data by id
        $data_search = $this->getDataDetail($id_youtube);
        if(count($data_search) <= 0)
            return array('response'=>'ERROR', 'nama'=>'');
        else {
            //cek nama
            $this->db->where('title', $title);
            $this->db->where('id_youtube !=', $id_youtube);
            $qTot = $this->db->count_all_results('data_youtube');
            if($qTot > 0)
                return array('response'=>'ERRDATA', 'nama'=>$title);
            else {
                $data = array(
                    'title'             => $title,
                    'url'               => escape($this->input->post('url', TRUE)),
                    'id_pelatihan'      => escape($this->input->post('id_pelatihan', TRUE))
                );
                /*query update*/
                $this->db->where('id_youtube', abs($id_youtube));
                $this->db->update('data_youtube', $data);
                return array('response'=>'SUCCESS', 'nama'=>$title);
            }
        }
    }

    /* Fungsi untuk delete data */
    public function deleteData() {
        $id = $this->encryption->decrypt(escape($this->input->post('tokenId', TRUE)));
        //cek data by id
        $dataSearch = $this->getDataDetail($id);
        $title = !empty($dataSearch) ? $dataSearch['title'] : '';
        if (count($dataSearch) <= 0)
            return array('response'=>'ERROR', 'nama'=>'');
        else {
                $this->db->where('id_youtube', abs($id));
                $this->db->delete('data_youtube');
                return array('response'=>'SUCCESS', 'nama'=>$title);
        }
    }
}

// This is the end of auth signin model
