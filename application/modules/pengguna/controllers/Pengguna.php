<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengguna extends MX_Controller {

    protected $data = '';
    
    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('pengguna_query');
        $this->load->module('access'); 
        $this->load->module('listmenu');
        
        $cek = $this->session->userdata('logged_in');
        if (!$cek) {
            header('location:'.base_url().'access');
        }
    }
    
    public function index()
    {
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
            $data['data'] = $this->pengguna_query->listDataPengguna();
            
            $this->template
                    ->set_layout('default')
                    ->build('pengguna_view',$data);
        } else {
            $this->access->statHakAkses();
        }
    }
    
    function infomodul()
    {
        $this->load->view('pengguna_info');
    }
    
    public function loadform()
    {
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
            
            $data['id'] = $this->uri->segment(3);
            
            if ($data['id'] == NULL){
                
                $data['idpengguna'] = '';
                $data['username'] = '';
                $data['password'] = '';
                $data['namalengkap'] = '';
                $data['kelamin'] = '';
                $data['idgrup'] = '';

                $data['grup'] = $this->pengguna_query->listdataGrup();
            
                $this->template
                    ->set_layout('default')
                    ->build('pengguna_form',$data);
            } else {
                $query = $this->pengguna_query->listdataPenggunaWhere($data['id']);
                foreach($query->result() as $t){
                    $data['idpengguna'] = $t->idpengguna;
                    $data['username'] = $t->username;
                    $data['namalengkap'] = $t->namalengkap;
                    $data['kelamin'] = $t->kelamin;
                    $data['idgrup'] = $t->idgrup;
                    $data['password'] = '';
                }
                
                $data['grup'] = $this->pengguna_query->listdataGrup();
                
                $this->template
                    ->set_layout('default')
                    ->build('pengguna_form',$data);
            }
            
        } else {
            $this->access->statHakAkses();
        }
    }
    
    function savedata()
    {
        $up['idpengguna'] = $this->security->xss_clean($this->input->post('idpengguna'));
        $up['username'] = $this->security->xss_clean($this->input->post('username'));
        $up['password'] = $this->security->xss_clean($this->input->post('password'));
        $up['namalengkap'] = $this->security->xss_clean($this->input->post('namalengkap'));
        $up['kelamin'] = $this->security->xss_clean($this->input->post('kelamin'));
        $up['password'] = $this->security->xss_clean($this->input->post('password'));
        $up['idgrup'] = $this->security->xss_clean($this->input->post('idgrup'));
        $up['idpeserta'] = $this->security->xss_clean($this->input->post('idpeserta')); //untuk ppl 
        $up['pembuatid'] = $this->session->userdata('idpengguna');        
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));       
        $res = $this->pengguna_query->ExecData($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }
    
    public function loadformdelete()
    {
        $idpengguna = $this->security->xss_clean($this->input->post('idpengguna'));
        
        $query = $this->pengguna_query->listdataPenggunaWhere($idpengguna);
        foreach($query->result() as $t){
            $data['idpengguna'] = $t->idpengguna;
            $data['username'] = $t->username;
            $data['namalengkap'] = $t->namalengkap;
            $data['kelamin'] = $t->kelamin;
            $data['idgrup'] = $t->idgrup;
            $data['password'] = '';
        }

        $this->load->view('pengguna_delete',$data);
    }
    
    function deletedata()
    {
        $up['idpengguna'] = $this->security->xss_clean($this->input->post('idpengguna'));
        $up['username'] = '';
        $up['password'] = '';
        $up['namalengkap'] = '';
        $up['kelamin'] = '';
        $up['password'] = '';
        $up['idgrup'] = '';
        $up['pembuatid'] = '';
        $up['idpeserta'] = '';
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));
        $res = $this->pengguna_query->ExecData($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }
    
    function statpublish()
    {
        $up['idpengguna'] = $this->security->xss_clean($this->input->post('idpengguna'));
        $up['pembuatid'] = $this->session->userdata('idpengguna');
        $up['publish'] = $this->security->xss_clean($this->input->post('publish'));
        $res = $this->pengguna_query->ExecPublish($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }
    
    
}