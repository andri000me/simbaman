<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jenismasakan extends MX_Controller {

    protected $data = '';

    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('jenismasakan_qry');
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

            $data['data'] = $this->jenismasakan_qry->listDataJenismasakan();
            
            $this->template
                    ->set_layout('default')
                    ->build('index',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    function infomodul()
    {
        $this->load->view('jenismasakan_info');
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
                
                $data['idjenismasakan'] = '';
                $data['namajenismasakan'] = '';
                $data['stat'] = '';
            
                $this->template
                    ->set_layout('default')
                    ->build('jenismasakan_form',$data);
            } else {
                $query = $this->jenismasakan_qry->listDataJenismasakanWhere($data['id']);
                foreach($query->result() as $t){
                    $data['idjenismasakan'] = $t->idjenismasakan;
                    $data['namajenismasakan'] = $t->namajenismasakan;
                    $data['stat'] = $t->stat;
                }
                $this->template
                    ->set_layout('default')
                    ->build('jenismasakan_form',$data);
            }
            
        } else {
            $this->access->statHakAkses();
        }
    }

    public function savedata() 
    {
        $up['idjenismasakan'] = $this->security->xss_clean($this->input->post('idjenismasakan'));
        $up['namajenismasakan'] = $this->security->xss_clean($this->input->post('namajenismasakan'));
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));
        $up['status'] = $this->security->xss_clean($this->input->post('status'));

        $res = $this->jenismasakan_qry->ExecData($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }

    public function loadformdelete()
    {
        $idjenismasakan = $this->security->xss_clean($this->input->post('idjenismasakan'));
        
        $query = $this->jenismasakan_qry->listDataJenismasakanWhere($idjenismasakan);
        foreach($query->result() as $t){
            $data['idjenismasakan'] = $t->idjenismasakan;
            $data['namajenismasakan'] = $t->namajenismasakan;
            $data['stat'] = $t->stat;
        }

        $cekdata = $this->jenismasakan_qry->cekDataJenisMasakan($data['namajenismasakan']);
        $data['jumlah'] = $cekdata->num_rows();
        $this->load->view('jenismasakan_delete',$data);
    }

    function deletedata()
    {
        $up['idjenismasakan'] = $this->security->xss_clean($this->input->post('idjenismasakan'));
        $up['namajenismasakan'] = '';
        $up['stat'] = '';
        $up['status'] = $this->security->xss_clean($this->input->post('status'));
        $res = $this->jenismasakan_qry->ExecData($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }        
    }

}