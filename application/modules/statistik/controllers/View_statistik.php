<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of mata diklat class
 *
 * @author Yogi "solop" Kaputra
 */

class View_statistik extends SLP_Controller {
    protected $_vwName  = '';
    protected $_uriName = '';
    public function __construct() {
        parent::__construct();
        $this->load->model(array('model_statistik' => 'mStat'));
        $this->_vwName = 'vstatistik';
        $this->_uriName = 'statistik/view-statistik';
    }

    public function index() {
        $this->breadcrumb->add('Dashboard', site_url('home'));
        $this->breadcrumb->add('Statistik', '#');
        $this->breadcrumb->add('View Statistik', site_url($this->_uriName));
        $this->session_info['page_name']        = 'Statistik';
        $this->session_info['siteUri']          = $this->_uriName;
        $this->session_info['data_jadwal']      = $this->mStat->getDataTahun();


        $dataHistoryPeserta  = $this->mStat->getDataPesertaPelatihan();
		foreach ($dataHistoryPeserta as $key => $it) {
			$arrPnd[$it['id_opd']] = $it['jml']
			;
		}

		$dataOPD = $this->mStat->getDataOPD_grafik();
		foreach ($dataOPD as $key => $tr) {
			$arrGrafikOPD[] = array(
				'opd'	 	=> $tr['singkatan'],
				'total'  	=> isset($arrPnd[$tr['id_opd']]) ? $arrPnd[$tr['id_opd']] : 0
			);
		}
		// ------------------------------------
        $arr_graph_opd = json_encode($arrGrafikOPD);

        // var_dump($arr_graph_opd);die;
        $this->session_info['page_js']	        = $this->load->view($this->_vwName.'/vjs', array('siteUri'=>$this->_uriName, 'data'=>$arr_graph_opd), true);

        $this->template->build($this->_vwName.'/vpage', $this->session_info);

        

        
    }
}

// This is the end of fungsi class
