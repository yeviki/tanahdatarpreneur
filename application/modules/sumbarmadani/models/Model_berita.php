<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of program model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_berita extends CI_Model
{

    private $table = 'data_berita';
    public function __construct()
    {
        parent::__construct();
    }

    public function getDataBerita($limit = 4, $offset = 0, $search = '')
    {

        $this->DataBeritaQuery();
        $this->db->order_by('a.id_berita', 'DESC');
        if($limit != "all"){
            $this->db->limit($limit, $offset);   
        }
        $query = $this->db->get();
        return $query->result_array();
    }

    public function totalDataBerita()
    {
        $this->DataBeritaQuery();
        $query = $this->db->get();
        return $query->num_rows();
    }

    private function DataBeritaQuery()
    {
        $this->db->select('a.id_berita,
                            a.id_opd,
                            a.id_pelatihan,
                            a.judul_berita,
                            a.keterangan,
                            a.file_foto,
                            a.id_status,
                            b.nama_opd
                            ');
        $this->db->from($this->table . ' a');
        $this->db->join('ms_unit_kerja b', 'a.id_opd = b.id_opd', 'LEFT');
        $this->db->where('a.id_status', 1);
    }
}
