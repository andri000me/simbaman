<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sistemlog extends MX_Controller {
    
    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('sistemlog_query');
        $this->load->module('access'); 
        $this->load->module('listmenu');
        
//        $cek = $this->session->userdata('logged_in');
//        if (!$cek) {
//            header('location:'.base_url().'access');
//        }
    }
    
    public function index()
    {
        $cek = $this->session->userdata('logged_in');
        if ($cek) {
            $idgrup = $this->session->userdata('idgrup');
            $url = $this->uri->segment(1);
            $cekhakakses = $this->access->hakakses($idgrup,$url);
            if ($cekhakakses == 1) {
                $modul = $this->listmenu->namamodul($url);
                foreach($modul->result() as $t){
                    $sess_data['idmodul'] = $t->idmodul;
                    $data['idmodul'] = $t->idmodul;
                    $data['idmenu'] = $t->idmenu;
                    $data['namamodul'] = $t->namamodul;
                    $data['keteranganmodul'] = $t->keterangan;
                    $data['namamenu'] = $t->namamenu;
                }
                $this->session->set_userdata($sess_data);

                $idmodul = $this->session->userdata('idmodul');
                $btnaksi = $this->listmenu->btnaksi($idmodul,$idgrup);
                foreach($btnaksi->result() as $t){
                    $data['add'] = $t->created;
                    $data['edit'] = $t->updated;
                    $data['delete'] = $t->deleted;
                }

                $data['data'] = $this->sistemlog_query->listData();

                $this->template
                        ->set_layout('default')
                        ->build('sistemlog_view',$data);
            } else {
                $this->access->statHakAkses();
            }
        } else {
            header('location:'.base_url().'access');
        }
    }
    
    public function infomodul()
    {
        $this->load->view('menu_info');
    }
    
    public function aktifitas($data)
    {
        $this->sistemlog_query->log_aktifitas($data);
    }
    
}