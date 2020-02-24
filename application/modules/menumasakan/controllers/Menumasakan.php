<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-15 11:30:53
 * @modify date 2019-09-15 11:30:53
 * @desc [description]
 */

class Menumasakan extends MX_Controller {

    protected $data = '';

    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('menumasakan_query');
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
            
            $data['kelaspasien'] = $this->menumasakan_query->list_kelaspasien();            
            
            $this->template
                    ->set_layout('default')
                    ->build('menumasakan_view',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    public function getkelaspasien()
    {
        $idgrup = $this->session->userdata('idgrup');
        $url = $this->uri->segment(1);
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
        
        $data['idkelas'] = $this->security->xss_clean($this->input->post('idkelas'));

        $data['namakelas'] = $this->menumasakan_query->get_namakelas($data['idkelas']);
        $data['menu'] = $this->menumasakan_query->listDataMenu($data['idkelas']);
        $data['waktumenu'] = $this->menumasakan_query->listDataWaktu($data['idkelas']);
        $data['masakan'] = $this->menumasakan_query->listDataMasakan($data['idkelas']);

        $this->load->view('menumasakan_kelaspasien', $data);        
    }

    public function loadform_menumasakan()
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
            
            $data['idkelas'] = $this->uri->segment(3);
            $data['idjenismenu'] = $this->uri->segment(4);
            
            if ($data['idjenismenu'] == NULL){                
                $data['kelas'] = $this->menumasakan_query->list_kelas();
                $data['jenismenu'] = $this->menumasakan_query->list_jenismenu(); 
                
                $data['namakelas'] = $this->menumasakan_query->listdataKelasWhere($data['idkelas']);
                $data['waktumenumasakan'] = $this->menumasakan_query->listDataKelasMenuWaktu($data['idkelas'],$data['idjenismenu']);
                $data['menumasakan'] = $this->menumasakan_query->listDataKelasMenuMasakan($data['idkelas'],$data['idjenismenu']);
                
            } else {
                $data['kelas'] = $this->menumasakan_query->listdataKelasWhere($data['idkelas']);
                $data['jenismenu'] = $this->menumasakan_query->listdataJenisMenuWhere($data['idjenismenu']);

                $data['namakelas'] = $this->menumasakan_query->listDataKelas($data['idkelas'],$data['idjenismenu']);
                $data['waktumenumasakan'] = $this->menumasakan_query->listDataKelasMenuWaktu($data['idkelas'],$data['idjenismenu']);
                $data['menumasakan'] = $this->menumasakan_query->listDataKelasMenuMasakan($data['idkelas'],$data['idjenismenu']);
                
            }

            $data['waktumenu'] = $this->menumasakan_query->list_waktumenu();
            $data['masakan'] = $this->menumasakan_query->list_masakan();

            $data['get_DataKelasMenuMasakan'] = $this->menumasakan_query->get_DataKelasMenuMasakan($data['idkelas']);

            $this->template
                ->set_layout('default')
                ->build('menumasakan_form_menumasakan',$data);
            
        } else {
            $this->access->statHakAkses();
        }
    }

    public function savedata_menumasakan()
    {
        $up['idmenumasakan'] = $this->security->xss_clean($this->input->post('idmenumasakan'));
        $up['idkelas'] = $this->security->xss_clean($this->input->post('idkelas'));
        $up['idjenismenu'] = $this->security->xss_clean($this->input->post('idjenismenu'));
        $up['idwaktumenu'] = $this->security->xss_clean($this->input->post('idwaktumenu'));
        $up['idmasakan'] = $this->security->xss_clean($this->input->post('idmasakan'));
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));
        $res = $this->menumasakan_query->ExecData_menumasakan($up);        
    }

    public function loadformdelete_menumasakan()
    {
        $data['idmenumasakan'] = $this->security->xss_clean($this->input->post('idmenumasakan'));

        $data['menumasakan'] = $this->menumasakan_query->get_menumasakan($data['idmenumasakan']);

        $this->load->view('konfirmasi_delete_menumasakan',$data);
    }

    public function ref_menumasakan()
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

            $data['idjenismenu'] = 'a0997f19-d775-11e9-8c14-68f72820d6fc';

            $data['jenismenumasakan'] = $this->menumasakan_query->jenismenumasakan($data['idjenismenu']);

            $data['kelasmenumasakan'] = $this->menumasakan_query->kelasmenumasakan($data['idjenismenu']);
            $data['waktumenumasakan'] = $this->menumasakan_query->waktumenumasakan($data['idjenismenu']);
            $data['menumasakan'] = $this->menumasakan_query->menumasakan($data['idjenismenu']);

            $this->template
                ->set_layout('default')
                ->build('referensi_menumasakan',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    function infomodul()
    {
        $this->load->view('menumasakan_info');
    }

    function konfirmasi_reset()
    {
        $this->load->view('konfirmasi_reset');
    }

    public function reset_menumasakan()
    {
        $res = $this->menumasakan_query->get_reset_menumasakan();
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }
}