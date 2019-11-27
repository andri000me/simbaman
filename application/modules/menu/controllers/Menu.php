<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu extends MX_Controller {

    protected $data = '';
    
    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('menu_query');
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
            $data['data'] = $this->menu_query->listDataMenu();
            
            $this->template
                    ->set_layout('default')
                    ->build('menu_view',$data);
        } else {
            $this->access->statHakAkses();
        }
    }
    
    function infomodul()
    {
        $this->load->view('menu_info');
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
                
                $data['idmenu'] = '';
                $data['namamenu'] = '';
                $data['ikonmenu'] = '';
                $data['keteranganmenu'] = '';
                $data['urutanmenu'] = '';
            
                $this->template
                    ->set_layout('default')
                    ->build('menu_form',$data);
            } else {
                $query = $this->menu_query->listDataMenuWhere($data['id']);
                foreach($query->result() as $t){
                    $data['idmenu'] = $t->idmenu;
                    $data['namamenu'] = $t->namamenu;
                    $data['ikonmenu'] = $t->ikon;
                    $data['keteranganmenu'] = $t->keterangan;
                    $data['urutanmenu'] = $t->urutan;
                }
                $this->template
                    ->set_layout('default')
                    ->build('menu_form',$data);
            }
            
        } else {
            $this->access->statHakAkses();
        }
    }
    
    public function searchicon() 
    {
        $this->load->view('menu_icon');
    }
    
    public function savedata() 
    {
        $up['idmenu'] = $this->security->xss_clean($this->input->post('idmenu'));
        $up['namamenu'] = $this->security->xss_clean($this->input->post('namamenu'));
        $up['ikonmenu'] = $this->security->xss_clean($this->input->post('ikonmenu'));
        $up['keteranganmenu'] = $this->security->xss_clean($this->input->post('keteranganmenu'));
        $up['urutanmenu'] = $this->security->xss_clean($this->input->post('urutanmenu'));
        $up['pembuatid'] = $this->session->userdata('idpengguna');        
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));

        $res = $this->menu_query->ExecData($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }
    
    public function loadformdelete()
    {
        $idmenu = $this->security->xss_clean($this->input->post('idmenu'));
        
        $query = $this->menu_query->listDataMenuWhere($idmenu);
        foreach($query->result() as $t){
            $data['idmenu'] = $t->idmenu;
            $data['namamenu'] = $t->namamenu;
            $data['ikonmenu'] = $t->ikon;
            $data['keteranganmenu'] = $t->keterangan;
            $data['urutanmenu'] = $t->urutan;
        }

        $cekdatamenu = $this->menu_query->cekDataMenuModul($idmenu);
        $data['jumlahmodul'] = $cekdatamenu->num_rows();
        $this->load->view('menu_delete',$data);
    }
    
    function deletedata()
    {
        $up['idmenu'] = $this->security->xss_clean($this->input->post('idmenu'));
        $up['namamenu'] = '';
        $up['ikonmenu'] = '';
        $up['keteranganmenu'] = '';
        $up['urutanmenu'] = '';
        $up['pembuatid'] = '';
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));
        $res = $this->menu_query->ExecData($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }        
    }
    
    function statpublish()
    {
        $up['idmenu'] = $this->security->xss_clean($this->input->post('idmenu'));
        $up['pembuatid'] = $this->session->userdata('idpengguna');
        $up['publish'] = $this->security->xss_clean($this->input->post('publish'));
        $res = $this->menu_query->ExecPublish($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }        
    }
    
    /*Modul*/
    public function menudetail()
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
            
            $idmenu = $this->uri->segment(3);
            
            $query = $this->menu_query->listDataMenuWhere($idmenu);
            foreach($query->result() as $t){
                $data['idmenu'] = $t->idmenu;
                $data['namamenu'] = $t->namamenu;
                $data['ikonmenu'] = $t->ikon;
                $data['keteranganmenu'] = $t->keterangan;
                $data['urutanmenu'] = $t->urutan;
            }
            
            $data['listmodul'] = $this->menu_query->listDataModulWhere_Menu($idmenu);
            
            $this->template
                    ->set_layout('default')
                    ->build('modul_detail',$data);
        } else {
            $this->access->statHakAkses();
        }
    }
    
    public function savedata_modul()
    {
        $up['idmenu'] = $this->security->xss_clean($this->input->post('idmenu'));
        $up['idmodul'] = $this->security->xss_clean($this->input->post('idmodul'));
        $up['namamodul'] = $this->security->xss_clean($this->input->post('namamodul'));
        $up['linkmodul'] = $this->security->xss_clean($this->input->post('linkmodul'));
        $up['keteranganmodul'] = $this->security->xss_clean($this->input->post('keteranganmodul'));
        $up['urutanmodul'] = $this->security->xss_clean($this->input->post('urutanmodul'));
        $up['pembuatid'] = $this->session->userdata('idpengguna');        
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));       
        $res = $this->menu_query->ExecData_Modul($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }
    
    public function moduldetail()
    {
        $idmodul = $this->security->xss_clean($this->input->post('idmodul'));
        
        $res = $this->menu_query->listDataWhere_Modul($idmodul);
        foreach($res as $key => $val){
            $data= array(
                'idmodul' => $val['idmodul'],
                'idmenu' => $val['idmenu'],
                'namamodul' => $val['namamodul'],
                'linkmodul' => $val['linkmodul'],
                'urutan' => $val['urutan'],
                'namamenu' => $val['namamenu'],
                'keterangan' => $val['keterangan']
              );
        }
        $dat = json_encode($data);
        echo $dat;
    }
    
    function konfirmasihapus_modul()
    {
        $idmodul = $this->security->xss_clean($this->input->post('idmodul'));
        $data = $this->menu_query->listdataWhere_Modul($idmodul);
        foreach($data as $key => $val){
            $d['idmenu'] = $val['idmenu'];
            $d['idmodul'] = $val['idmodul'];
            $d['namamodul'] = $val['namamodul'];
        }
        $this->load->view('modul_konfirmasihapus',$d);
    }
    
    function deletedata_modul()
    {
        $up['idmodul'] = $this->security->xss_clean($this->input->post('idmodul'));
        $up['idmenu'] = '';
        $up['namamodul'] = '';
        $up['linkmodul'] = '';
        $up['keteranganmodul'] = '';
        $up['urutanmodul'] = '';
        $up['pembuatid'] = '';        
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));
        $res = $this->menu_query->ExecData_Modul($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }        
    }
    
    function statpublish_modul()
    {
        $up['idmodul'] = $this->security->xss_clean($this->input->post('idmodul'));
        $up['pembuatid'] = $this->session->userdata('idpengguna');
        $up['publish'] = $this->security->xss_clean($this->input->post('publish'));
        $res = $this->menu_query->ExecPublish_Modul($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }
    
}