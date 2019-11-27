<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {
    
    protected $data = '';

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('dashboard_query');
		
    }
    
    public function index()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('access/login', 'refresh');
        } else {
            $data['namamodul'] = 'Dashboard';
            $data['keteranganmodul'] = 'Dashboard';
            $data['namamenu'] = 'Dashboard';

            $tgl_sekarang = $this->dashboard_query->get_datepasien();
            $data['pasien'] = $this->dashboard_query->get_pasien($tgl_sekarang[0]['tanggalrekap']);

            $this->template
                    ->set_layout('default')
                    ->build('dashboard_view',$data);
        }
    }

    public function detail_pasien()
    {
        $idkelas = $this->security->xss_clean($this->input->post('idkelas'));
        $tanggalrekap = $this->security->xss_clean($this->input->post('tanggalrekap'));
        $data['detail'] = $this->dashboard_query->get_detailpasien($idkelas,$tanggalrekap);
        $this->load->view('detail_pasien',$data);
    }
    
    
}