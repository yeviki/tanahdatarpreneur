<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of mata diklat class
 *
 * @author Yogi "solop" Kaputra
 */

class Rekap_laporan extends SLP_Controller
{
    protected $_vwName  = '';
    protected $_uriName = '';
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_rekap' => 'mRekapLap', 'master/model_master' => 'mmas'));
        $this->_vwName = 'vRekapLap';
        $this->_uriName = 'laporan/rekap-laporan';
    }

    private function validasiDataValue()
    {
        $this->form_validation->set_rules('nm_pelatihan', 'Nama Pelatihan', 'required|trim');
        $this->form_validation->set_rules('id_kat_urusan', 'Kategori Urusan', 'required|trim');
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
        $this->breadcrumb->add('Rekap Laporan', site_url($this->_uriName));
        $this->session_info['page_name']    = 'Rekap Laporan';
        $this->session_info['siteUri']      = $this->_uriName;
        $this->session_info['page_js']      = $this->load->view($this->_vwName . '/vjs', array('siteUri' => $this->_uriName), true);
        $this->session_info['data_opd']     = $this->mmas->getOPD();
        $this->session_info['tot_peserta']      = $this->mRekapLap->totPeserta();

        // Membuat judul header table dinamis berdasarkan kategori tahun
        $dataTahun = $this->db->query('select distinct(tahun) from data_history_pelatihan where tahun <> "0000" order by tahun')->result_array();
        $tabelKepala = '
        <tr>
            <th width="3%" rowspan="2" class="font-weight-bold">#</th>
            <th width="30%" rowspan="2" class="font-weight-bold">Nama OPD</th>
            <th width="5%" rowspan="2" class="font-weight-bold">Singkatan</th>
            <th class="font-weight-bold" rowspan="2">Total Pelatihan</th>
        ';
        foreach ($dataTahun as $d) {
            $tabelKepala .= '<th colspan="2" class="text-center font-weight-bold">' . $d['tahun'] . '</th>';
        }
        $tabelKepala .= '</tr>';
        $tabelKepala .= '
                        <tr>

                            <th>Pelatihan</th>
                            <th>Peserta</th>
                            <th>Pelatihan</th>
                            <th>Peserta</th>
                            <th>Pelatihan</th>
                            <th>Peserta</th>
                        </tr>';
        $this->session_info['tabelKepala']          = $tabelKepala;
        // Tutup

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
                $dataTahun = $this->db->query('select distinct(tahun) from data_history_pelatihan where tahun <> "0000" and id_pelatihan <> "0" order by tahun')->result_array();
                // die(var_dump($dataTahun));
                $dataList = $this->mRekapLap->get_datatables($dataTahun);
                // die($this->db->last_query());
                // die(var_dump($dataList));
                $no = $this->input->post('start');
                foreach ($dataList as $key => $dl) {
                    if ($this->app_loader->is_super()) {
                        $button = '<button type="button" class="btn btn-default btn-sm px-2 py-1 my-0 mx-0 waves-effect waves-light btnLihatPelatihan" data-id="' . $this->encryption->encrypt($dl['id_opd']) . '" title="Detail Pelatihan"> <i class="fas fa-eye"></i> '.$dl['total'].'</button>';
                    }

                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $dl['nama_opd'];
                    $row[] = $dl['singkatan'];
                    $row[] = $button;
                    foreach ($dataTahun as $d) {
                        $row[] = number_format($dl['pel' . $d['tahun']],0);
                        $row[] = number_format($dl['p' . $d['tahun']],0);
                    }
                    $data[] = $row;
                }

                $output = array(
                    "draw" => $this->input->post('draw'),
                    "recordsTotal" => $this->mRekapLap->count_all(),
                    "recordsFiltered" => $this->mRekapLap->count_filtered(),
                    "data" => $data
                );
            }
            //output to json format
            $this->output->set_content_type('application/json')->set_output(json_encode($output));
        }
    }

    public function download($tahun = "", $opd_id = "", $opsi = "")
    {
        $tahun = $this->input->get('tahun', TRUE);
        $opd_id = $this->input->get('opdID', TRUE);
        $opsi = $this->input->get('opsi', TRUE);
        $session  = $this->app_loader->current_account();
        $csrfHash = $this->security->get_csrf_hash();
        if (!empty($session)) {
            $data['peserta'] = $this->mRekapLap->printDataPeserta($tahun, $opd_id);
            $data['tahun'] = $tahun;
            if ($opsi == 1) {
                // echo $this->load->view($this->_vwName . '/printpage2', $data, TRUE);
                $this->excel_rekap_pelatihan($tahun, $opd_id);
            } else {
                echo $this->load->view($this->_vwName . '/printpage', $data, TRUE);
            }
        } else {
            $result = array('status' => 'RC404', 'message' => array(), 'csrfHash' => $csrfHash);
            echo json_encode($result);
        }
    }

    private function excel_rekap_pelatihan($tahun, $opd_id)
    {
        // die($opd_id);
        require_once APPPATH . 'third_party/php_excel/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';
		$objReader = PHPExcel_IOFactory::createReader('Excel5');
		$dataExcelPelatihan 	= $this->mRekapLap->printDataPelatihan($tahun, $opd_id);

		$template  = 'repository/template/pelatihan_report.xls';
		$objPHPExcel = $objReader->load($template);
		//set title
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A2:D2');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', 'DATA PELATIHAN');
		$objPHPExcel->setActiveSheetIndex(0)->mergeCells('A3:D3');
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', 'TAHUN : '.$tahun);
		//set data TPA
		$noRow = 0;
		$baseRow = 6;
        $total_pelatihan = 0;
		$total_peserta = array();
		if(count($dataExcelPelatihan) > 0) {
			foreach ($dataExcelPelatihan as $key => $dh) {
                $total_pelatihan = $total_pelatihan + 1;
				$total_peserta[] = $dh['total'];

				$noRow++;
				$row = $baseRow + $noRow;
				$objPHPExcel->setActiveSheetIndex(0)->insertNewRowBefore($row,1);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row, $noRow);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, $dh['nm_pelatihan']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, $dh['tanggal_pelatihan']);
				$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, $dh['total']);
			}
		} else {
			$row = $baseRow + 1;
			$objPHPExcel->setActiveSheetIndex(0)->insertNewRowBefore($row,1);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$row, 1);
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$row, '');
			$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row, '');
		}
		$objPHPExcel->setActiveSheetIndex(0)->removeRow($baseRow,1);
		$tot_peserta = array_sum($total_peserta);
		$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$row, $tot_peserta);
		
        
		$file	= 'data_pelatihan_report.xlsx';
		// Redirect output to a client’s web browser (Excel2007)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header("Content-Disposition: attachment;filename=$file");
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
		header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header ('Pragma: public'); // HTTP/1.0
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
    }

    // Fungsi Check Data Pelatihan
    public function review()
    {
        $session  = $this->app_loader->current_account();
        $csrfHash = $this->security->get_csrf_hash();
        $idOPD     = $this->encryption->decrypt(escape($this->input->get('idOPD', TRUE)));
        if (!empty($session)) {
            $data = $this->mRekapLap->getDataPelatihan($idOPD);
            $rules = array();
            foreach ($data as $q => $pel) {
                $dataCount = $this->mRekapLap->getDataListPendaftar($pel['id_pelatihan']);
                $total = !empty($dataCount) ? $dataCount['total'] : 0;
                $isi['id_pelatihan']            = $pel['id_pelatihan'];
                $isi['nm_pelatihan']            = $pel['nm_pelatihan'];
                $isi['tempat_pelatihan']        = $pel['tempat_pelatihan'];
                $isi['mulai_registrasi']        = $pel['mulai_registrasi'];
                $isi['akhir_registrasi']        = $pel['akhir_registrasi'];
                $isi['tanggal_pelatihan']       = $pel['tanggal_pelatihan'];
                $isi['tanggal_pelatihan_akhir'] = $pel['tanggal_pelatihan_akhir'];
                $isi['kuota']                   = $pel['kuota'];
                $isi['tot_baruak']              = $total;
                $rules[] = $isi;
            }
            $result = array('status' => 'RC200', 'message' => $rules, 'csrfHash' => $csrfHash);
        } else {
            $result = array('status' => 'RC404', 'message' => array(), 'csrfHash' => $csrfHash);
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }
}

// This is the end of fungsi class
