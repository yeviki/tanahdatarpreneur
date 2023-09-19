<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of program model
 *
 * @author Yogi "solop" Kaputra
 */

class Model_pelatihan extends CI_Model
{
    private $table = 'data_pelatihan';
    public function __construct()
    {
        parent::__construct();
    }
    public function getDataPelatihan($limit = 4, $offset = 0, $search = '')
    {

        $this->DataPelatihanQuery();
        $this->db->order_by('b.tanggal_pelatihan', 'DESC');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function totalDataPelatihan()
    {
        $this->DataPelatihanQuery();
        $query = $this->db->get();
        return $query->num_rows();
    }
    private function DataPelatihanQuery()
    {
        $this->db->select('a.id_pelatihan,
                            a.token,
                            a.kuota,
                            a.keterangan,
                            a.id_metode_pelatihan,
                            c.nm_pelatihan,
                            d.id_jenis_kegiatan,
                            d.nm_jenis_kegiatan,
                            b.tanggal_pelatihan,
                            b.mulai_registrasi,
                            b.akhir_registrasi,
                            e.nama_opd
                            ');
        $this->db->from($this->table . ' a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'INNER');
        $this->db->join('ms_pelatihan c', 'b.id_master_pelatihan = c.id_master_pelatihan', 'INNER');
        $this->db->join('ms_jenis_kegiatan d', 'b.id_jenis_kegiatan = d.id_jenis_kegiatan', 'INNER');
        $this->db->join('ms_unit_kerja e', 'a.id_opd = e.id_opd', 'LEFT');

        if ($this->input->post('category') != '' and $this->input->post('category') != '0')
            $this->db->where('b.id_jenis_kegiatan', $this->input->post('category'));
    }
    public function getCategories()
    {
        $query = $this->db->get('ms_jenis_kegiatan');
        return $query->result_array();
    }

    /*Fungsi get data edit by id*/
    public function getDataDetailPelatihan($id)
    {
        $this->db->select('a.id_pelatihan,
                           a.id_opd,
                           a.token,
                           a.id_jadwal,
                           a.id_metode_pelatihan,
                           a.keterangan,
                           a.upload_brosur ,
                           a.kuota,
                           b.id_master_pelatihan,
                           b.nm_sub_kegiatan,
                           b.tanggal_pelatihan,
                           b.mulai_registrasi,
                           b.akhir_registrasi,
                           b.tempat_pelatihan,
                           b.pagu_anggaran,
                           b.nm_sub_kegiatan,
                           b.id_jenis_kegiatan,
                           b.id_status,
                           c.nm_jenis_kegiatan,
                           d.nm_pelatihan,
                           d.id_kat_urusan,
                           g.nm_kat_urusan,
                           GROUP_CONCAT(e.id_syarat ORDER BY e.id_syarat ASC SEPARATOR ",") AS group_syarat,
                           GROUP_CONCAT(i.id_syarat_dinamis ORDER BY i.id_syarat_dinamis ASC SEPARATOR ",") AS group_syarat_dinamis
                           ');
        $this->db->from('data_pelatihan a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'inner');
        $this->db->join('ms_jenis_kegiatan c', 'b.id_jenis_kegiatan = c.id_jenis_kegiatan', 'inner');
        $this->db->join('ms_pelatihan d', 'b.id_master_pelatihan = d.id_master_pelatihan', 'inner');
        $this->db->join('data_rules_syarat e', 'a.id_pelatihan = e.id_pelatihan', 'left');
        $this->db->join('data_syarat f', 'e.id_syarat = f.id_syarat', 'left');
        $this->db->join('data_kat_urusan g', 'd.id_kat_urusan = g.id_kat_urusan', 'inner');
        $this->db->join('data_rules_syarat_dinamis h', 'a.id_pelatihan = h.id_pelatihan', 'left');
        $this->db->join('ms_syarat_dinamis i', 'h.id_syarat_dinamis = i.id_syarat_dinamis', 'left');
        $this->db->where('a.token', $id);
        $this->db->where('e.id_status', 1);
        $this->db->group_by('a.id_pelatihan');
        $this->db->order_by('a.id_pelatihan ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }
    /*Fungsi get data show pada peserta by id*/
    public function getDataDetailShow($id)
    {

        $this->db->select('a.id_pelatihan,
                           a.id_opd,
                           a.token,
                           a.id_jadwal,
                           a.id_metode_pelatihan,
                           a.keterangan,
                           a.upload_brosur ,
                           a.kuota,
                           b.id_master_pelatihan,
                           b.nm_sub_kegiatan,
                           b.tanggal_pelatihan,
                           b.mulai_registrasi,
                           b.akhir_registrasi,
                           b.tempat_pelatihan,
                           b.pagu_anggaran,
                           b.nm_sub_kegiatan,
                           b.id_jenis_kegiatan,
                           b.id_status,
                           c.nm_jenis_kegiatan,
                           d.nm_pelatihan,
                           d.id_kat_urusan,
                           g.nm_kat_urusan,
                           GROUP_CONCAT(e.id_syarat ORDER BY e.id_syarat ASC SEPARATOR ",") AS group_syarat
                           ');
        $this->db->from('data_pelatihan a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'inner');
        $this->db->join('ms_jenis_kegiatan c', 'b.id_jenis_kegiatan = c.id_jenis_kegiatan', 'inner');
        $this->db->join('ms_pelatihan d', 'b.id_master_pelatihan = d.id_master_pelatihan', 'inner');
        $this->db->join('data_rules_syarat e', 'a.id_pelatihan = e.id_pelatihan', 'left');
        $this->db->join('data_syarat f', 'e.id_syarat = f.id_syarat', 'left');
        $this->db->join('data_kat_urusan g', 'd.id_kat_urusan = g.id_kat_urusan', 'inner');
        $this->db->where('a.token', $id);
        $this->db->where('b.id_status', 1);
        $this->db->group_by('a.id_pelatihan');
        $this->db->order_by('a.id_pelatihan ASC');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function getDataSyarat($pelatihanId, $userLogin = "")
    {
        $cekData = array();
        $userLogin = $userLogin != "" ?  $userLogin : 0;
        $this->db->select('a.id_rules_syarat,
                           a.id_pelatihan,
                           a.id_syarat,
                           a.id_status,
                           b.nm_syarat,
                           b.tabel_name,
                           b.field_name');
        $this->db->from('data_rules_syarat a');
        $this->db->join('data_syarat b', 'a.id_syarat = b.id_syarat', 'inner');
        $this->db->where('a.id_pelatihan', $pelatihanId);
        $this->db->where('a.id_status', 1);
        $query = $this->db->get()->result_array();
        foreach ($query as $key => $val) {
            $cek = $this->db->select($val['field_name'] . ' as nilai')->from($val['tabel_name'])->where('id_peserta', $userLogin)->get()->row_array();
            // echo $this->db->last_query(); die;
            $cekData[] = array(
                'id' => $val['id_syarat'],
                'label' => $val['nm_syarat'],
                'nilai' => (!empty($cek['nilai']) ? $cek['nilai'] : ''),
                'field_name' => $val['field_name']
            );
        }
        return $cekData;
    }
    public function getDataSyaratTambahan($pelatihanId, $userLogin = "")
    {
        $cekData = array();
        $userLogin = $userLogin != "" ?  $userLogin : 0;
        $this->db->select('a.id_rules_dinamis,
                           a.id_pelatihan,
                           a.id_syarat_dinamis,
                           a.id_status,
                           b.nm_syarat_dinamis');
        $this->db->from('data_rules_syarat_dinamis a');
        $this->db->join('ms_syarat_dinamis b', 'a.id_syarat_dinamis = b.id_syarat_dinamis', 'inner');
        $this->db->where('a.id_pelatihan', $pelatihanId);
        $this->db->where('a.id_status', 1);
        $query = $this->db->get()->result_array();
        foreach ($query as $key => $val) {
            $cek = $this->db->select($val['id_syarat_dinamis'] . ' as syarat, data_pelatihan.id_pelatihan, nama_file')->from('data_berkas_peserta')->join('data_pelatihan', 'data_pelatihan.id_pelatihan = data_berkas_peserta.id_pelatihan', 'inner')->where('id_peserta', $userLogin)->where('data_pelatihan.id_pelatihan', $pelatihanId)->get()->row_array();
            $cekData[] = array(
                'id'                => $val['id_syarat_dinamis'],
                'label'             => $val['nm_syarat_dinamis'],
                'id_pelatihan'      => (!empty($cek['id_pelatihan']) ? $cek['id_pelatihan'] : ''),
                'syarat'            => (!empty($cek['syarat']) ? $cek['syarat'] : ''),
                'nama_file'         => (!empty($cek['nama_file']) ? $cek['nama_file'] : ''),
                'status'            => (!empty($cek['nama_file']) ? 'OK' : 'Belum Upload')
            );
        }
        return $cekData;
    }

    public function saveSyaratTambahan($idPelatihan, $id_peserta, $id_syarat)
    {
        $tahun              = gmdate('Y');
        $bulan              = date('m');
        $dirname = 'repository/pelatihan/' . $idPelatihan . '/' . $tahun . '/' . $bulan . '/' . $id_peserta;
        if (!is_dir($dirname)) {
            mkdir($dirname, 0777, TRUE);
        }
        $this->db->where('id_peserta', $id_peserta);
        $this->db->where('id_pelatihan', $idPelatihan);
        $this->db->where('id_syarat_dinamis', $id_syarat);
        $nUser = $this->db->count_all_results('data_berkas_peserta');
        if ($nUser > 0) {
            return array('response' => 'ALREADY_UPLOADED');
        }

        if (!empty($_FILES['uploaded_file']['name'])) {

            $config = array(
                'upload_path'         => './' . $dirname . '/',
                'allowed_types'     => 'pdf',
                'file_name'            => 'upload_' . $id_peserta . '_' . $id_syarat,
                'file_ext_tolower'    => TRUE,
                'max_size'             => 1024,
                'max_filename'         => 0,
                'remove_spaces'     => TRUE,
            );
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('uploaded_file')) {
                $uploadData       = $this->upload->data();
                $filename         = $uploadData['file_name'];
                //inser ke table dokumen
                $dataFile = array(
                    'id_pelatihan'      => $idPelatihan,
                    'id_peserta'        => $id_peserta,
                    'date'              => $bulan,
                    'year'              => $tahun,
                    'nama_file'         => $filename,
                    'id_syarat_dinamis' => $id_syarat
                );
                $this->db->insert('data_berkas_peserta', $dataFile);
                return array('response' => 'SUCCESS', 'file' => base_url($dirname . '/' . $filename));
            } else {
                return array('response' => 'FILE_ERROR');
            }
        } else {
            $base64Image = $_POST['uploaded_file'];
            // echo $_POST['uploaded_file'];
            if ($base64Image != '') {
                $filename = 'upload_' . $id_peserta . '_' . $id_syarat . '.pdf';
                $fullpath = $dirname . '/' . $filename;  // file name with full path
                $decoded = base64_decode($base64Image);
                if (file_put_contents($fullpath, $decoded)) {
                    $dataFile = array(
                        'id_pelatihan'      => $idPelatihan,
                        'id_peserta'        => $id_peserta,
                        'date'              => $bulan,
                        'year'              => $tahun,
                        'nama_file'         => $filename,
                        'id_syarat_dinamis' => $id_syarat
                    );
                    $this->db->insert('data_berkas_peserta', $dataFile);
                    return array('response' => 'SUCCESS', 'file' => base_url($fullpath));
                } else {
                    return array('response' => 'FILE_ERROR');
                }
            } else return array('response' => 'NO_FILE');
        }
    }

    public function cekHistoryPelatihan($id_peserta, $tahun)
    {
        $this->db->where('id_peserta', $id_peserta);
        // $this->db->where('id_pelatihan', $id_pelatihan);
        $this->db->where('tahun', $tahun);
        $nUser = $this->db->count_all_results('data_history_pelatihan');
        return $nUser;
    }

    /*Fungsi get data edit by id*/
    public function getIDOPDFromPelatihan($id_pelatihan)
    {
        $this->db->select('a.id_pelatihan,
                           a.id_opd,
                           a.token,
                           ');
        $this->db->from('data_pelatihan a');
        $this->db->where('a.id_pelatihan', $id_pelatihan);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function saveHistoryPelatihan($id_peserta, $id_pelatihan, $tahun)
    {
        $syarat_ketentuan = json_decode(stripslashes($_POST['syarat_ketentuan']));
        $tanggal_daftar = date('Y-m-d');

        $dataP = $this->getIDOPDFromPelatihan($id_pelatihan);
        $id_opd = !empty($dataP) ? $dataP['id_opd'] : 0;
        $data = array(
            'id_pelatihan'      => $id_pelatihan,
            'id_peserta'        => $id_peserta,
            'tahun'             => $tahun,
            'id_opd'            => $id_opd,
            'flag'              => '1',
            'tanggal_daftar'    => $tanggal_daftar,
            'id_status'         => '1'
        );
        /*query insert*/
        if ($this->db->insert('data_history_pelatihan', $data)) {
            $this->saveSyaratKetentuan($id_peserta, $syarat_ketentuan);
            return array('response' => 'SUCCESS');
        } else {
            return array('response' => 'FAILED');
        }
    }

    private function saveSyaratKetentuan($id_peserta, $fields)
    {
        foreach ($fields as $key => $value) {
            $dataSyarat = $this->db->get_where('data_syarat', array('id_syarat' => $value->id))->row();
            if ($dataSyarat->field_name == 'no_nib') {
                if ($value->nilai != 0) {
                    $this->db->where('id_peserta', $id_peserta);
                    $umkm = $this->db->count_all_results('data_umkm');
                    if ($umkm > 0) {
                        $this->db->query('update ' . $dataSyarat->tabel_name . ' set ' . $dataSyarat->field_name . '="' . $value->nilai . '" where id_peserta="' . $id_peserta . '"');
                    } else {
                        $this->db->query('insert into ' . $dataSyarat->tabel_name . ' (' . $dataSyarat->field_name . ', id_peserta) values ("' . $value->nilai . '","' . $id_peserta . '")');
                    }
                    $this->db->query('update data_peserta set id_jenis_akun = 1, minat_usaha = "" where id_peserta="' . $id_peserta . '"');
                }
            } else {
                $this->db->query('update ' . $dataSyarat->tabel_name . ' set ' . $dataSyarat->field_name . '="' . $value->nilai . '" where id_peserta="' . $id_peserta . '"');
            }
        };
    }

    public function getHistoryPelatihan($id_peserta)
    {
        $this->db->select('*');
        $this->db->from('data_history_pelatihan');
        $this->db->join('data_pelatihan', 'data_pelatihan.id_pelatihan = data_history_pelatihan.id_pelatihan');
        $this->db->where('data_history_pelatihan.id_peserta', $id_peserta);
        $this->db->order_by('data_history_pelatihan.tahun', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function getHistory($nik)
    {
        $this->db->select('a.id_pelatihan,
                            a.token,
                            a.kuota,
                            a.keterangan,
                            a.id_metode_pelatihan,
                            c.nm_pelatihan,
                            d.id_jenis_kegiatan,
                            d.nm_jenis_kegiatan,
                            b.tanggal_pelatihan,
                            b.mulai_registrasi,
                            b.akhir_registrasi,
                            e.nama_opd,
                            f.tanggal_daftar,
                            f.flag
                            ');
        $this->db->from($this->table . ' a');
        $this->db->join('ms_jadwal b', 'a.id_jadwal = b.id_jadwal', 'INNER');
        $this->db->join('ms_pelatihan c', 'b.id_master_pelatihan = c.id_master_pelatihan', 'INNER');
        $this->db->join('ms_jenis_kegiatan d', 'b.id_jenis_kegiatan = d.id_jenis_kegiatan', 'INNER');
        $this->db->join('ms_unit_kerja e', 'a.id_opd = e.id_opd', 'LEFT');
        $this->db->join('data_history_pelatihan f', 'a.id_pelatihan = f.id_pelatihan', 'INNER');
        $this->db->join('data_peserta g', 'f.id_peserta = g.id_peserta AND g.nik = "' . $nik . '"', 'INNER');
        return $this->db->get()->result_array();
    }

    public function getStatperCategory()
    {
        $query1 = "SELECT b.id_jenis_kegiatan, c.nm_jenis_kegiatan,
        SUM(IF(b.id_jenis_kegiatan,1,0)) as jml_pelatihan
        FROM data_pelatihan a
        INNER JOIN ms_jadwal b ON a.id_jadwal = b.id_jadwal
        INNER JOIN ms_jenis_kegiatan c ON b.id_jenis_kegiatan = c.id_jenis_kegiatan
        GROUP BY b.id_jenis_kegiatan;";

        $query2 = "SELECT c.id_jenis_kegiatan , d.nm_jenis_kegiatan,
        SUM(IF(c.id_jenis_kegiatan, 1, 0)) as jml_peserta
        FROM data_history_pelatihan a 
        INNER JOIN data_pelatihan b ON a.id_pelatihan = b.id_pelatihan
        INNER JOIN ms_jadwal c ON b.id_jadwal = c.id_jadwal
        INNER JOIN ms_jenis_kegiatan d ON c.id_jenis_kegiatan = d.id_jenis_kegiatan
        GROUP BY c.id_jenis_kegiatan;";

        $exe1 = $this->db->query($query1)->result_array();
        $exe2 = $this->db->query($query2)->result_array();
        $result = array();
        foreach ($exe1 as $key => $value) {
            $row['id_jenis_kegiatan'] = $value['id_jenis_kegiatan'];
            $row['jml_pelatihan'] = $value['jml_pelatihan'];
            $row['jml_peserta'] = $exe2[$key]['jml_peserta'];
            $result[] = $row;
        }
        return $result;
    }


    // Testing Baru
    public function saveUploadSyaratTambahan($idPelatihan, $id_peserta, $id_syarat, $upload_berkas)
    {
        $tahun              = gmdate('Y');
        $bulan              = date('m');
        $dirname = 'repository/pelatihan/' . $idPelatihan . '/' . $tahun . '/' . $bulan . '/' . $id_peserta;
        if (!is_dir($dirname)) {
            mkdir($dirname, 0777, TRUE);
        }
        $this->db->where('id_peserta', $id_peserta);
        $this->db->where('id_pelatihan', $idPelatihan);
        $this->db->where('id_syarat_dinamis', $id_syarat);
        $nUser = $this->db->count_all_results('data_berkas_peserta');
        if ($nUser > 0) {
            return array('response' => 'ALREADY_UPLOADED');
        }

        if (!empty($upload_berkas)) {

            $config = array(
                'upload_path'           => './' . $dirname . '/',
                'allowed_types'         => 'pdf',
                'file_name'             => 'upload_' . $id_peserta . '_' . $id_syarat,
                'file_ext_tolower'      => TRUE,
                'max_size'              => 1024,
                'max_filename'          => 0,
                'remove_spaces'         => TRUE,
            );
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('uploaded_file')) {
                $uploadData       = $this->upload->data();
                $filename         = $uploadData['file_name'];
                //inser ke table dokumen
                $dataFile = array(
                    'id_pelatihan'      => $idPelatihan,
                    'id_peserta'        => $id_peserta,
                    'date'              => $bulan,
                    'year'              => $tahun,
                    'nama_file'         => $filename,
                    'id_syarat_dinamis' => $id_syarat
                );
                $this->db->insert('data_berkas_peserta', $dataFile);
                return array('response' => 'SUCCESS', 'file' => base_url($dirname . '/' . $filename));
            } else {
                return array('response' => 'FILE_ERROR');
            }
        } else {
            $base64Image = $upload_berkas;
            // echo $_POST['uploaded_file'];
            if ($base64Image != '') {
                $filename = 'upload_' . $id_peserta . '_' . $id_syarat . '.pdf';
                $fullpath = $dirname . '/' . $filename;  // file name with full path
                $decoded = base64_decode($base64Image);
                if (file_put_contents($fullpath, $decoded)) {
                    $dataFile = array(
                        'id_pelatihan'      => $idPelatihan,
                        'id_peserta'        => $id_peserta,
                        'date'              => $bulan,
                        'year'              => $tahun,
                        'nama_file'         => $filename,
                        'id_syarat_dinamis' => $id_syarat
                    );
                    $this->db->insert('data_berkas_peserta', $dataFile);
                    return array('response' => 'SUCCESS', 'file' => base_url($fullpath));
                } else {
                    return array('response' => 'FILE_ERROR');
                }
            } else return array('response' => 'NO_FILE');
        }
    }
}
