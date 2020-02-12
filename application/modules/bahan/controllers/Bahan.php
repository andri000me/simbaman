<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bahan extends MX_Controller {

    protected $data = '';

    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('bahan_qry');
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

            $data['data'] = $this->bahan_qry->listDataMenu();
            
            $this->template
                    ->set_layout('default')
                    ->build('index',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    function infomodul()
    {
        $this->load->view('bahan_info');
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
                
                $data['idbahan'] = '';
                $data['namabahan'] = '';
                $data['satuan'] = '';
                $data['jenis'] = '';
                $data['stat'] = '';
            
                $this->template
                    ->set_layout('default')
                    ->build('bahan_form',$data);
            } else {
                $query = $this->bahan_qry->listDataMenuWhere($data['id']);
                foreach($query->result() as $t){
                    $data['idbahan'] = $t->idbahan;
                    $data['namabahan'] = $t->namabahan;
                    $data['satuan'] = $t->satuan;
                    $data['jenis'] = $t->jenis;
                    $data['stat'] = $t->stat;
                }
                $this->template
                    ->set_layout('default')
                    ->build('bahan_form',$data);
            }
            
        } else {
            $this->access->statHakAkses();
        }
    }

    public function savedata() 
    {
        $up['idbahan'] = $this->security->xss_clean($this->input->post('idbahan'));
        $up['namabahan'] = $this->security->xss_clean($this->input->post('namabahan'));
        $up['satuan'] = $this->security->xss_clean($this->input->post('satuan'));
        $up['jenis'] = $this->security->xss_clean($this->input->post('jenis'));
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));
        $up['status'] = $this->security->xss_clean($this->input->post('status'));

        $res = $this->bahan_qry->ExecData($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }

    public function loadformdelete()
    {
        $idbahan = $this->security->xss_clean($this->input->post('idbahan'));
        
        $query = $this->bahan_qry->listDataMenuWhere($idbahan);
        foreach($query->result() as $t){
            $data['idbahan'] = $t->idbahan;
            $data['namabahan'] = $t->namabahan;
            $data['satuan'] = $t->satuan;
            $data['jenis'] = $t->jenis;
            $data['stat'] = $t->stat;
        }

        $cekdata = $this->bahan_qry->cekDataBahan($idbahan);
        $data['jumlah'] = $cekdata->num_rows();
        $this->load->view('bahan_delete',$data);
    }

    function deletedata()
    {
        $up['idbahan'] = $this->security->xss_clean($this->input->post('idbahan'));
        $up['namabahan'] = '';
        $up['satuan'] = '';
        $up['jenis'] = '';
        $up['stat'] = '';
        $up['status'] = $this->security->xss_clean($this->input->post('status'));
        $res = $this->bahan_qry->ExecData($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }        
    }

}