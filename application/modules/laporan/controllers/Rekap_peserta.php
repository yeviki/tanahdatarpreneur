<?php (defined('BASEPATH')) or exit('No direct script access allowed');

/**
 * Description of mata diklat class
 *
 * @author Yogi "solop" Kaputra
 */

class Rekap_peserta extends SLP_Controller
{
    protected $_vwName  = '';
    protected $_uriName = '';
    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('model_rekap_peserta' => 'mRekapLap', 'master/model_master' => 'mmas'));
        $this->_vwName = 'vRekapPeserta';
        $this->_uriName = 'laporan/rekap-peserta';
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
        $this->breadcrumb->add('Rekap Peserta', site_url($this->_uriName));
        $this->session_info['page_name']    = 'Rekap Peserta';
        $this->session_info['siteUri']      = $this->_uriName;
        $this->session_info['page_js']      = $this->load->view($this->_vwName . '/vjs', array('siteUri' => $this->_uriName), true);
        $this->session_info['data_regency']     = $this->mmas->getDataRegency();
        $this->session_info['tot_peserta']      = $this->mRekapLap->totPeserta();

        // Membuat judul header table dinamis berdasarkan kategori tahun

        $tabelKepala = '
        <tr>
            <th width="3%" class="font-weight-bold">#</th>
            <th class="font-weight-bold">Kabupaten/Kota</th>
            <th width="30%" class="font-weight-bold">Total Peserta</th>
        ';
        
        $tabelKepala .= '</tr>';
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
                // $dataTahun = $this->db->query('select distinct(tahun) from data_history_pelatihan where tahun <> "0000" and id_pelatihan <> "0" order by tahun')->result_array();
                // die(var_dump($dataTahun));
                $dataList = $this->mRekapLap->get_datatables();
                // die($this->db->last_query());
                // die(var_dump($dataList));
                $no = $this->input->post('start');
                foreach ($dataList as $key => $dl) {
                    $no++;
                    $row = array();
                    $row[] = $no;
                    $row[] = $dl['name'];
                    $row[] = number_format($dl['total'],0);
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

    public function download( $id_regency = "")
    {
        $id_regency = $this->input->get('opdID', TRUE);
        $session  = $this->app_loader->current_account();
        $csrfHash = $this->security->get_csrf_hash();
        if (!empty($session)) {
            $data['peserta'] = $this->mRekapLap->printDataPeserta( $id_regency);
            echo $this->load->view($this->_vwName . '/printpage', $data, TRUE);
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
}

// This is the end of fungsi class
