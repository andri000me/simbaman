<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Grup extends MX_Controller {
    
    protected $data = '';
    
    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('grup_query');
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
            
            $data['data'] = $this->grup_query->listDataGrup();
            
            $this->template
                    ->set_layout('default')
                    ->build('grup_view',$data);
        } else {
            $this->access->statHakAkses();
        }
    }
    
    function infomodul()
    {
        $this->load->view('grup_info');
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
                
                $data['idgrup'] = '';
                $data['namagrup'] = '';
                $data['keterangangrup'] = '';
            
                $this->template
                    ->set_layout('default')
                    ->build('grup_form',$data);
            } else {
                $query = $this->grup_query->listdataGrupWhere($data['id']);
                foreach($query->result() as $t){
                    $data['idgrup'] = $t->idgrup;
                    $data['namagrup'] = $t->namagrup;
                    $data['keterangangrup'] = $t->keterangan;
                }
                $this->template
                    ->set_layout('default')
                    ->build('grup_form',$data);
            }
            
        } else {
            $this->access->statHakAkses();
        }
    }
    
    function savedata()
    {
        $up['idgrup'] = $this->security->xss_clean($this->input->post('idgrup'));
        $up['namagrup'] = $this->security->xss_clean($this->input->post('namagrup'));
        $up['keterangangrup'] = $this->security->xss_clean($this->input->post('keterangangrup'));
        $up['pembuatid'] = $this->session->userdata('idpengguna');        
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));       
        $res = $this->grup_query->ExecData($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }        
    }
    
    public function loadformdelete()
    {
        $idgrup = $this->security->xss_clean($this->input->post('idgrup'));
        
        $query = $this->grup_query->listdataGrupWhere($idgrup);
        foreach($query->result() as $t){
            $data['idgrup'] = $t->idgrup;
            $data['namagrup'] = $t->namagrup;
            $data['keterangangrup'] = $t->keterangan;
        }

        $cekdatagrup = $this->grup_query->cekDataGrupPengguna($idgrup);
        $data['jumlah'] = $cekdatagrup->num_rows();
        $this->load->view('grup_delete',$data);
    }
    
    function deletedata()
    {
        $up['idgrup'] = $this->security->xss_clean($this->input->post('idgrup'));
        $up['namagrup'] = '';
        $up['keterangangrup'] = '';
        $up['pembuatid'] = ''; 
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));
        $res = $this->grup_query->ExecData($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }        
    }
    
    function statpublish()
    {
        $up['idgrup'] = $this->security->xss_clean($this->input->post('idgrup'));
        $up['pembuatid'] = $this->session->userdata('idpengguna');
        $up['publish'] = $this->security->xss_clean($this->input->post('publish'));
        $res = $this->grup_query->ExecPublish($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }
    
    /*Hak Akses*/
    
    public function grupdetail()
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
            
            $data['idgrup'] = $this->uri->segment(3);
            
            $query = $this->grup_query->listdataGrupWhere($data['idgrup']);
            foreach($query->result() as $t){
                $data['idgrup'] = $t->idgrup;
                $data['namagrup'] = $t->namagrup;
                $data['keterangangrup'] = $t->keterangan;
            }
            
            $data['data'] = $this->grup_query->listdataModul();
            
            $this->template
                    ->set_layout('default')
                    ->build('grup_detail',$data);
        } else {
            $this->access->statHakAkses();
        }
    }
    
    function update_view()
    {
        $idgrupx = $this->security->xss_clean($this->input->post('idgrup'));
        $d['idgrup'] = $idgrupx;
        $idmodulx = $this->security->xss_clean($this->input->post('idmodul'));
        $d['idmodul'] = $idmodulx;
        $d['cek'] = $this->security->xss_clean($this->input->post('cek'));
        $d['pembuatid'] = $this->session->userdata('idpengguna');
        $hasil = $this->grup_query->whereView($idmodulx,$idgrupx);
        $row = $hasil->num_rows();
        if($row==1){                
            $UpdateData = $this->grup_query->updateDataView($d);
            if ($UpdateData){
                echo 101;
            } else {
                echo 100;
            }
//                echo "ON/ OFF = Create, Read, Update and Delete";
        } else {
            $AddData = $this->grup_query->insertDataView($d);
            if ($AddData){
                echo 101;
            } else {
                echo 100;
            }
//                echo "ON/ OFF = Create, Read, Update and Delete";
        }
    }
    
    function update_action()
    {
	$d['idgrup'] = $this->security->xss_clean($this->input->post('idgrup'));
        $d['idmodul'] = $this->security->xss_clean($this->input->post('idmodul'));
        $d['cek'] = $this->security->xss_clean($this->input->post('cek'));
        $d['pembuatid'] = $this->session->userdata('idpengguna');
        $stat = $this->security->xss_clean($this->input->post('stat'));
        if ($stat == 'Add') {
            $Add = $this->grup_query->updateDataAdd($d);
            if ($Add){
                echo 101;
            } else {
                echo 100;
            }
        } else if ($stat == 'Edit') {
            $Edit = $this->grup_query->updateDataEdit($d);
            if ($Edit){
                echo 101;
            } else {
                echo 100;
            }
        } else if ($stat == 'Delete') {
            $Delete = $this->grup_query->updateDataDelete($d);
            if ($Delete){
                echo 101;
            } else {
                echo 100;
            }
        }
    }
}