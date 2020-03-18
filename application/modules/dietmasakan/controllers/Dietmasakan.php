<?php

class Dietmasakan extends MX_Controller {

    protected $data = '';

    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('dietmasakan_query');
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
            
            $data['dietpasien'] = $this->dietmasakan_query->list_dietpasien();            
            
            $this->template
                    ->set_layout('default')
                    ->build('dietmasakan_view',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    public function getdietpasien()
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
        
        $data['iddiet'] = $this->security->xss_clean($this->input->post('iddiet'));

        $data['namadiet'] = $this->dietmasakan_query->get_diet($data['iddiet']);
        $data['dietmasakan'] = $this->dietmasakan_query->get_dietmasakan($data['iddiet']);
        $data['dietmasakanbahan'] = $this->dietmasakan_query->get_dietmasakanbahan($data['iddiet']);

        $this->load->view('dietmasakan_dietpasien', $data);   
    }

    public function loadform_dietmasakan()
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
            
            $data['iddiet'] = $this->uri->segment(3);

            $data['dietpasien'] = $this->dietmasakan_query->list_dietpasien();
            $data['masakan'] = $this->dietmasakan_query->list_masakan();
            $data['satuan'] = $this->dietmasakan_query->list_satuan();

            $data['namadiet'] = $this->dietmasakan_query->get_diet($data['iddiet']);
            $data['dietmasakan'] = $this->dietmasakan_query->get_dietmasakan($data['iddiet']);
            $data['dietmasakanbahan'] = $this->dietmasakan_query->get_dietmasakanbahan($data['iddiet']);

            $this->template
                ->set_layout('default')
                ->build('form_dietasakan',$data);
            
        } else {
            $this->access->statHakAkses();
        }
    }

    public function get_bahanmasakan()
    {
        $data['idmasakan'] = $this->security->xss_clean($this->input->post('idmasakan'));

        $data['masakanbahan'] = $this->dietmasakan_query->list_masakanbahan($data['idmasakan']);

        echo $data['masakanbahan'];
    }

    public function savedata_dietmasakan()
    {
        $up['iddietmasakanbahan'] = $this->security->xss_clean($this->input->post('iddietmasakanbahan'));
        $up['iddiet'] = $this->security->xss_clean($this->input->post('iddiet'));
        $up['idmasakan'] = $this->security->xss_clean($this->input->post('idmasakan'));
        $up['idbahan'] = $this->security->xss_clean($this->input->post('idbahan'));
        $up['pengurangan'] = $this->security->xss_clean($this->input->post('pengurangan'));
        $up['satuan'] = $this->security->xss_clean($this->input->post('satuan'));
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));

        $res = $this->dietmasakan_query->ExecData_dietmasakan($up);
    }

    public function form_ubahdietmasakan()
    {
        $data['iddietmasakanbahan'] = $this->security->xss_clean($this->input->post('iddietmasakanbahan'));

        $data['dietmasakanbahan'] = $this->dietmasakan_query->get_dietmasakanbahanwhere($data['iddietmasakanbahan']);

        $data['satuan'] = $this->dietmasakan_query->list_satuan();

        $this->load->view('form_ubahdietmasakan',$data);
    }

    public function savedata_dietmasakan_ubah()
    {
        $up['iddietmasakanbahan'] = $this->security->xss_clean($this->input->post('iddietmasakanbahan_ubah'));
        $up['iddiet'] = '';
        $up['idmasakan'] = '';
        $up['idbahan'] = '';
        $up['pengurangan'] = $this->security->xss_clean($this->input->post('pengurangan_ubah'));
        $up['satuan'] = $this->security->xss_clean($this->input->post('satuan_ubah'));
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));

        $res = $this->dietmasakan_query->ExecData_dietmasakan($up);
    }

    public function form_hapusdietmasakan()
    {
        $data['iddietmasakanbahan'] = $this->security->xss_clean($this->input->post('iddietmasakanbahan'));

        $data['dietmasakanbahan'] = $this->dietmasakan_query->get_dietmasakanbahanwhere($data['iddietmasakanbahan']);

        $this->load->view('form_hapusdietmasakan',$data);
    }

    public function listdiet()
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
            $data['listdiet'] = $this->dietmasakan_query->listdiet();
            $this->template
                    ->set_layout('default')
                    ->build('form_listdiet',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    public function savedata_diet()
    {
        $up['iddiet'] = $this->security->xss_clean($this->input->post('iddiet'));
        $up['namadiet'] = $this->security->xss_clean($this->input->post('namadiet'));
        $up['urutan'] = $this->security->xss_clean($this->input->post('urutan'));
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));       
        $res = $this->dietmasakan_query->ExecData_Diet($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }

    public function statpublish_diet()
    {
        $up['iddiet'] = $this->security->xss_clean($this->input->post('iddiet'));
        $up['namadiet'] = '';
        $up['urutan'] = '';
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));
        $res = $this->dietmasakan_query->ExecPublish_Diet($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }

    public function dietdetail()
    {
        $iddiet = $this->security->xss_clean($this->input->post('iddiet'));
        
        $res = $this->dietmasakan_query->listDataWhere_Diet($iddiet);
        foreach($res as $key => $val){
            $data= array(
                'iddiet' => $val['iddiet'],
                'namadiet' => $val['namadiet'],
                'urutan' => $val['urutan']
              );
        }
        $dat = json_encode($data);
        echo $dat;
    }

    function konfirmasihapus_diet()
    {
        $iddiet = $this->security->xss_clean($this->input->post('iddiet'));
        $data = $this->dietmasakan_query->listDataWhere_Diet($iddiet);
        foreach($data as $key => $val){
            $d['iddiet'] = $val['iddiet'];
            $d['namadiet'] = $val['namadiet'];
        }
        $this->load->view('diet_konfirmasihapus',$d);
    }
    
    function deletedata_diet()
    {
        $up['iddiet'] = $this->security->xss_clean($this->input->post('iddiet'));
        $up['namadiet'] = '';
        $up['urutan'] = '';
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));
        $res = $this->dietmasakan_query->ExecData_Diet($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }        
    }
}