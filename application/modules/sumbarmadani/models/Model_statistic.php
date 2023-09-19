<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of program model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_statistic extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_peserta()
    {
        $this->db->select('a.id_peserta,b.nik,b.id_province,b.id_regency,a.id_opd,d.id_jenis_kegiatan');
        $this->db->from('data_history_pelatihan a');
        $this->db->join('data_peserta b', 'a.id_peserta = b.id_peserta', 'inner');
        $this->db->join('data_pelatihan c', 'a.id_pelatihan = c.id_pelatihan', 'inner');
        $this->db->join('ms_jadwal d', 'c.id_jadwal = d.id_jadwal', 'inner');
        $this->db->group_by('a.id_peserta');
        $query = $this->db->get();
        $total = 0;
        $milenial = 0;
        $woman = 0;
        foreach ($query->result() as $row) {
            $total = $total + 1;
            if ($row->id_jenis_kegiatan == 1) {
                $milenial = $milenial + 1;
            }
            if ($row->id_jenis_kegiatan == 2) {
                $woman = $woman + 1;
            }
        }

        return array(
            'milenial' => $milenial,
            'woman' => $woman,
            'total' => $total
        );
    }
    public function get_pelatihan()
    {
        $this->db->select('a.id_pelatihan');
        $this->db->from('data_pelatihan a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'inner');
        $query = $this->db->get();
        $total = 0;
        foreach ($query->result() as $row) {
            $total = $total + 1;
        }

        return array(
            'total' => $total
        );
    }

    public function statPelatihanPerOPD()
    {
        $this->db->select('a.id_opd,a.nama_opd,a.singkatan,SUM(IF(b.id_opd,1,0)) as jumlah');
        $this->db->from('ms_unit_kerja a');
        $this->db->join('data_pelatihan b', 'a.id_opd = b.id_opd', 'LEFT');
        $this->db->where('a.id_opd !=', 17);
        $this->db->group_by('a.id_opd');

        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

    public function statPesertaPerOPD($id_cat)
    {
        $this->db->select('distinct(c.id_peserta), a.id_opd,a.nama_opd,a.singkatan,SUM(IF(c.id_peserta,1,0)) as jumlah');
        $this->db->from('ms_unit_kerja a');
        $this->db->join('data_pelatihan b', 'a.id_opd = b.id_opd', 'LEFT');
        $this->db->join('data_history_pelatihan c', 'b.id_pelatihan = c.id_pelatihan', 'LEFT');
        $this->db->join('ms_jadwal d', 'b.id_jadwal = d.id_jadwal', 'LEFT');
        $this->db->where('a.id_opd !=', 17);
        $this->db->where('a.id_opd !=', 18);
        if ($id_cat != 0) {
            $this->db->where('d.id_jenis_kegiatan', $id_cat);
        }
        $this->db->group_by('a.id_opd');

        $query = $this->db->get();
        $data = array();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
        }
        return $data;
    }

    public function statPesertaNew()
    {
        $query = $this->db->query('select count(DISTINCT(nik)) as total from ( select DISTINCT nik from data_peserta where data_peserta.id_peserta in( select id_peserta from data_history_pelatihan where id_pelatihan <> 0 and id_opd <> 0) union all select DISTINCT nik from data_perizinan union all select DISTINCT nik from data_permodalan union all select DISTINCT nik from data_smk_preneur) total')->row_array();
        return $query;
    }

    public function statKategoriPelatihanMilenialNew()
    {
        $query = $this->db->query('select count(DISTINCT(nik)) as total from ( select DISTINCT a.nik from data_peserta a INNER JOIN data_history_pelatihan b ON a.id_peserta = b.id_peserta INNER JOIN data_pelatihan c ON c.id_pelatihan = b.id_pelatihan INNER JOIN ms_jadwal d ON d.id_jadwal = c.id_jadwal where d.id_jenis_kegiatan = 1 AND b.id_pelatihan != 0 AND a.id_peserta in( select id_peserta from data_history_pelatihan where id_pelatihan <> 0 and id_opd <> 0 ) union all select DISTINCT nik from data_perizinan where id_jenis_kegiatan = 1 union all select DISTINCT nik from data_permodalan where id_jenis_kegiatan = 1 union all select DISTINCT nik from data_smk_preneur where id_jenis_kegiatan = 1) total')->row_array();
        return $query;
    }

    public function statKategoriPelatihanWomanNew()
    {
        $query = $this->db->query('select count(DISTINCT(nik)) as total from ( select DISTINCT a.nik from data_peserta a INNER JOIN data_history_pelatihan b ON a.id_peserta = b.id_peserta INNER JOIN data_pelatihan c ON c.id_pelatihan = b.id_pelatihan INNER JOIN ms_jadwal d ON d.id_jadwal = c.id_jadwal where d.id_jenis_kegiatan = 2 AND b.id_pelatihan != 0 AND a.id_peserta in( select id_peserta from data_history_pelatihan where id_pelatihan <> 0 and id_opd <> 0 ) union all select DISTINCT nik from data_perizinan where id_jenis_kegiatan = 2 union all select DISTINCT nik from data_permodalan where id_jenis_kegiatan = 2 union all select DISTINCT nik from data_smk_preneur where id_jenis_kegiatan = 2) total')->row_array();
        return $query;
    }

    public function statKategoriPelatihanKreatifNew()
    {
        $query = $this->db->query('select count(DISTINCT(nik)) as total from ( select DISTINCT a.nik from data_peserta a INNER JOIN data_history_pelatihan b ON a.id_peserta = b.id_peserta INNER JOIN data_pelatihan c ON c.id_pelatihan = b.id_pelatihan INNER JOIN ms_jadwal d ON d.id_jadwal = c.id_jadwal where d.id_jenis_kegiatan = 3 AND b.id_pelatihan != 0 AND a.id_peserta in( select id_peserta from data_history_pelatihan where id_pelatihan <> 0 and id_opd <> 0 ) union all select DISTINCT nik from data_perizinan where id_jenis_kegiatan = 3 union all select DISTINCT nik from data_permodalan where id_jenis_kegiatan = 3 union all select DISTINCT nik from data_smk_preneur where id_jenis_kegiatan = 3) total')->row_array();
        return $query;
    }


    public function get_perizinan()
    {
        $this->db->select('a.nik');
        $this->db->from('data_perizinan a');
        $query = $this->db->get();
        $total = 0;
        foreach ($query->result() as $row) {
            $total = $total + 1;
        }

        return array(
            'total' => $total
        );
    }

    public function get_permodalan()
    {
        $this->db->select('a.nik');
        $this->db->from('data_permodalan a');
        $query = $this->db->get();
        $total = 0;
        foreach ($query->result() as $row) {
            $total = $total + 1;
        }

        return array(
            'total' => $total
        );
    }

    public function get_smk()
    {
        $this->db->select('a.nik');
        $this->db->from('data_smk_preneur a');
        $query = $this->db->get();
        $total = 0;
        foreach ($query->result() as $row) {
            $total = $total + 1;
        }

        return array(
            'total' => $total
        );
    }
}
