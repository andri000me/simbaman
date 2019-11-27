<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends MX_Controller {

    protected $data = '';
    
    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('profil_query');
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
            
            $idpengguna = $this->session->userdata('idpengguna');
            $query = $this->profil_query->listdataPenggunaWhere($idpengguna);
            foreach($query->result() as $t){
                $data['idpengguna'] = $t->idpengguna;
                $data['username'] = $t->username;
                $data['namalengkap'] = $t->namalengkap;
                $data['kelamin'] = $t->kelamin;
                $data['idgrup'] = $t->idgrup;
                $data['password'] = '';
                $data['foto'] = $t->foto;
            }
            
            $this->template
                    ->set_layout('default')
                    ->build('profil_view',$data);
        } else {
            $this->access->statHakAkses();
        }
    }
    
    function infomodul()
    {
        $this->load->view('profil_info');
    }
    
    function ubahdata()
    {
        $idpengguna = $this->session->userdata('idpengguna');
        $query = $this->profil_query->listdataPenggunaWhere($idpengguna);
        foreach($query->result() as $t){
            $data['idpengguna'] = $t->idpengguna;
            $data['username'] = $t->username;
            $data['namalengkap'] = $t->namalengkap;
            $data['kelamin'] = $t->kelamin;
            $data['idgrup'] = $t->idgrup;
            $data['password'] = '';
            $data['foto'] = $t->foto;
        }
        $this->load->view('profil_ubahdata',$data);
    }
    
    function savedata()
    {
        $up['idpengguna'] = $this->security->xss_clean($this->input->post('idpengguna'));
        $up['username'] = $this->security->xss_clean($this->input->post('username'));
        $up['password'] = $this->security->xss_clean($this->input->post('password'));
        $up['namalengkap'] = $this->security->xss_clean($this->input->post('namalengkap'));
        $up['kelamin'] = $this->security->xss_clean($this->input->post('kelamin'));
        $up['password'] = $this->security->xss_clean($this->input->post('password'));
        $up['pembuatid'] = $this->session->userdata('idpengguna');        
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));       
        $res = $this->profil_query->ExecData($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }
    
    function ubahfoto()
    {
        $data['idpengguna'] = $this->session->userdata('idpengguna');
        $this->load->view('profil_ubahfoto',$data);
    }
    
    function uploadfoto(){
        $idpengguna = $this->security->xss_clean($this->input->post('idpengguna'));
        $namefile = substr($idpengguna, 0, 8);
        
        $type = explode(".", $_FILES["fotoFile"]["name"]);
        $type = $type[count($type)-1];
        
        $url = "./gambar_profil/dp_".$namefile.".".$type;
        
        if ($idpengguna){
            
            $this->profil_query->unlinkFoto($idpengguna);
            
            $config['upload_path']          = './gambar_profil/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 50000;
            $config['max_width']            = 512;
            $config['max_height']           = 512;
            $config['file_name']            = "dp_".$namefile;
            
            $this->load->library('upload', $config);
            
            if ( ! $this->upload->do_upload('fotoFile')) {
                $error = array('error' => $this->upload->display_errors());
                print_r($error);
            } else {
//                $data = array('upload_data' => $this->upload->data());
//                print_r($data);
                $this->profil_query->updateFoto($idpengguna,$url);                
                print 1;
            }      
        }
    }
    
    function hapusfoto(){
        $idpengguna = $this->session->userdata('idpengguna');
        $this->profil_query->hapusFoto($idpengguna);
    }
}