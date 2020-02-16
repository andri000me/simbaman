<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-26 06:49:48
 * @modify date 2019-09-26 06:49:48
 * @desc [description]
 */

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Masakanbahan extends MX_Controller {
    protected $data = '';
    
    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('masakanbahan_query');
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

            $data['masakan'] = $this->masakanbahan_query->listDataMasakan();
            $data['masakanbahan'] = $this->masakanbahan_query->listDataMasakanBahan();
            
            $this->template
                    ->set_layout('default')
                    ->build('masakanbahan_view',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    public function infomodul()
    {
        $this->load->view('menu_info');
    }

    public function loadform_masakan()
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

            $this->template
                    ->set_layout('default')
                    ->build('masakanbahan_loadform',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    public function form_ubahmasakan()
    {
        $idmasakan = $this->security->xss_clean($this->input->post('idmasakan'));
        $data['masakan'] = $this->masakanbahan_query->listdataMasakanWhere($idmasakan);
        $this->load->view('form_ubahmasakan',$data);
    }

    public function savedata_masakan()
    {
        $up['idmasakan'] = $this->security->xss_clean($this->input->post('idmasakan'));
        $up['namamasakan'] = $this->security->xss_clean($this->input->post('namamasakan'));
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));

        $ceknamamasakan = $this->masakanbahan_query->cek_namamasakan($up['namamasakan']);

        if (count($ceknamamasakan) != 0) {
            echo "gagal";
        } else {
            $res = $this->masakanbahan_query->ExecData_masakan($up);
            // if ($res == 1){
            //     echo 101;
            // } else if ($res == 0){
            //     echo 100;
            // }
        }
    }

    public function detail_masakanbahan()
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

            $idmasakan = $this->uri->segment(3);

            $data['masakan'] = $this->masakanbahan_query->listdataMasakanWhere($idmasakan);

            $data['bahan'] = $this->masakanbahan_query->bahan();

            $data['masakanbahan'] = $this->masakanbahan_query->masakanbahan($idmasakan);

            $data['satuanbahan'] = $this->masakanbahan_query->list_satuan();

            $this->template
                    ->set_layout('default')
                    ->build('masakanbahan_detail_masakanbahan',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    public function loadformdelete_masakan()
    {
        $idmasakan = $this->security->xss_clean($this->input->post('idmasakan'));        
        $data['masakan'] = $this->masakanbahan_query->listdataMasakanWhere($idmasakan);
        $this->load->view('konfirmasi_delete_masakan',$data);
    }

    //----------

    public function bahan()
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
        
        $data['bahan'] = $this->masakanbahan_query->listDataBahan();
            
        $this->template
                ->set_layout('default')
                ->build('bahan_view',$data);
    }

    public function loadform_bahan()
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

            $data['id'] = $this->uri->segment(3);

            if ($data['id'] == NULL) {
                $data['idbahan'] = '';
                $data['namabahan'] = '';
                $data['satuan'] = '';
                $data['jenis'] = '';
            } else {
                $query = $this->masakanbahan_query->listdataBahanWhere($data['id']);
                foreach($query as $t){
                    $data['idbahan'] = $t['idbahan'];
                    $data['namabahan'] = $t['namabahan'];
                    $data['satuan'] = $t['satuan'];
                    $data['jenis'] = $t['jenis'];
                }
            }

            $data['satuanbahan'] = $this->masakanbahan_query->list_satuan();
            $data['jenismasakan'] = $this->masakanbahan_query->list_jenismasakan();

            $this->template
                    ->set_layout('default')
                    ->build('bahan_loadform',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    public function savedata_bahan()
    {
        $up['idbahan'] = $this->security->xss_clean($this->input->post('idbahan'));
        $up['namabahan'] = $this->security->xss_clean($this->input->post('namabahan'));
        $up['satuan'] = $this->security->xss_clean($this->input->post('satuan'));
        $up['jenis'] = $this->security->xss_clean($this->input->post('jenis'));
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));
        $res = $this->masakanbahan_query->ExecData_bahan($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }

    public function loadformdelete_bahan()
    {
        $idbahan = $this->security->xss_clean($this->input->post('idbahan'));        
        $data['bahan'] = $this->masakanbahan_query->listdataBahanWhere($idbahan);
        $this->load->view('konfirmasi_delete_bahan',$data);
    }

    //------------

    public function savedata_masakanbahan()
    {
        $up['idmasakanbahan'] = $this->security->xss_clean($this->input->post('idmasakanbahan'));
        $up['idmasakan'] = $this->security->xss_clean($this->input->post('idmasakan'));
        $up['idbahan'] = $this->security->xss_clean($this->input->post('idbahan'));
        $up['kuantitas'] = $this->security->xss_clean($this->input->post('kuantitas'));
        $up['satuan'] = $this->security->xss_clean($this->input->post('satuan'));
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));
        $res = $this->masakanbahan_query->ExecData_masakanbahan($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }

    public function form_ubahmasakanbahan()
    {
        $idmasakanbahan = $this->security->xss_clean($this->input->post('idmasakanbahan'));
        $data['masakanbahan'] = $this->masakanbahan_query->listdataMasakanBahanWhere($idmasakanbahan);
        $data['satuanbahan'] = $this->masakanbahan_query->list_satuan();
        $this->load->view('form_ubahmasakanbahan',$data);
    }

    public function loadformdelete_masakanbahan()
    {
        $idmasakanbahan = $this->security->xss_clean($this->input->post('idmasakanbahan'));        
        $data['masakanbahan'] = $this->masakanbahan_query->listdataMasakanBahanWhere($idmasakanbahan);
        $this->load->view('konfirmasi_delete_masakanbahan',$data);
    }

}