<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-26 20:49:08
 * @modify date 2019-09-26 20:49:08
 * @desc [description]
 */


class Supplier extends MX_Controller {
    
    protected $data = '';
    
    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('supplier_query');
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
            
            $data['supplier'] = $this->supplier_query->listDataSupplier();
            
            $this->template
                    ->set_layout('default')
                    ->build('supplier_view',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    function infomodul()
    {
        $this->load->view('grup_info');
    }

    public function detailbahan()
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
        
        $idsupplier = $this->uri->segment(3);
        $data['bahansupplier'] = $this->supplier_query->listDataBahanSupplier($idsupplier);
        $data['idsupplier'] = $idsupplier;
            
        $this->template
                ->set_layout('default')
                ->build('supplier_bahandetail',$data);
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
                
                $data['idsupplier'] = '';
                $data['namasupplier'] = '';
                $data['kontraktanggalawal'] = '';
                $data['kontraktanggalakhir'] = ''; 
                $data['stat_supplier'] = '';            
                
            } else {
                $query = $this->supplier_query->listdataSupplierWhere($data['id']);
                foreach($query as $t){
                    $data['idsupplier'] = $t['idsupplier'];
                    $data['namasupplier'] = $t['namasupplier'];
                    $data['kontraktanggalawal'] = $t['kontraktanggalawal'];
                    $data['kontraktanggalakhir'] = $t['kontraktanggalakhir'];
                    $data['stat_supplier'] = $t['stat'];
                }                
            }

            $this->template
                ->set_layout('default')
                ->build('supplier_form',$data);
            
        } else {
            $this->access->statHakAkses();
        }
    }

    public function savedata_supplier()
    {
        $up['idsupplier'] = $this->security->xss_clean($this->input->post('idsupplier'));
        $up['namasupplier'] = $this->security->xss_clean($this->input->post('namasupplier'));
        $up['kontraktanggalawal'] = $this->security->xss_clean($this->input->post('kontraktanggalawal'));
        $up['kontraktanggalakhir'] = $this->security->xss_clean($this->input->post('kontraktanggalakhir'));
        $up['stat_supplier'] = $this->security->xss_clean($this->input->post('stat_supplier'));
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));       
        $res = $this->supplier_query->ExecData_supplier($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }

    public function konfirmasi_hapussupplier()
    {
        $data['idsupplier'] = $this->security->xss_clean($this->input->post('idsupplier'));
        $data['supplier'] = $this->supplier_query->listdataSupplierWhere($data['idsupplier']);
        $this->load->view('konfirmasi_hapussupplier',$data);
    }

    //==========

    public function loadform_bahansupplier_manual()
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
            
            $data['idsupplier'] = $this->uri->segment(3);
            $data['id'] = $this->uri->segment(4);

            $idsupplier = $data['idsupplier'];
            
            if ($data['id'] == NULL){
                $data['idbahansupplier'] = '';
                $data['idsupplier'] = '';                
                $data['idbahan'] = '';
                $data['hargasatuan'] = '';
                $data['satuan'] = ''; 
                $data['jenis'] = '';
                $data['spesifikasi'] = '';     
                
                $data['supplier'] = $this->supplier_query->listdataSupplierWhere($idsupplier);
                $data['bahan'] = $this->supplier_query->listDataBahan_suplier($idsupplier);
                
            } else {
                $query = $this->supplier_query->listdataBahanSupplierWhere($data['id']);
                foreach($query as $t){
                    $data['idbahansupplier'] = $t['idbahansupplier'];
                    $data['idsupplier'] = $t['idsupplier'];                    
                    $data['idbahan'] = $t['idbahan'];
                    $data['hargasatuan'] = $t['hargasatuan'];
                    $data['satuan'] = $t['satuan'];
                    $data['jenis'] = $t['jenis'];
                    $data['spesifikasi'] = $t['spesifikasi'];
                }                

                $data['supplier'] = $this->supplier_query->listdataSupplierWhere($data['idsupplier']);
                $data['bahan'] = $this->supplier_query->listdataBahanWhere($data['idbahan']);
            }

            $data['satuanbahan'] = $this->supplier_query->list_satuan();
            $data['jenismasakan'] = $this->supplier_query->list_jenismasakan();

            $this->template
                ->set_layout('default')
                ->build('bahansupplier_form',$data);
            
        } else {
            $this->access->statHakAkses();
        }
    }

    public function loadform_bahansupplier()
    {
        $data['idsupplier'] = $this->security->xss_clean($this->input->post('idsupplier'));
        $data['supplier'] = $this->supplier_query->get_supplierbahan($data['idsupplier']);
        $this->load->view('supplier_formbahansupplier',$data);
    }

    public function copy_supplier()
    {
        $data['idsupplier'] = $this->security->xss_clean($this->input->post('idsupplier'));
        $data['idsupplier_copy'] = $this->security->xss_clean($this->input->post('idsupplier_copy'));

        $copy = $this->supplier_query->copy_supplier($data['idsupplier'],$data['idsupplier_copy']);
    }

    public function konfirmasi_hapusbahansupplier()
    {
        $data['idsupplier'] = $this->security->xss_clean($this->input->post('idsupplier'));
        $data['supplier'] = $this->supplier_query->listdataSupplierWhere($data['idsupplier']);

        $this->load->view('konfirmasi_hapusbahansupplier',$data);
    }

    public function hapussemua_bahansupplier()
    {
        $data['idsupplier'] = $this->security->xss_clean($this->input->post('idsupplier'));

        $deleteall = $this->supplier_query->hapussemua_bahansupplier($data['idsupplier']);
    }

    public function savedata_bahansupplier()
    {
        $up['idbahansupplier'] = $this->security->xss_clean($this->input->post('idbahansupplier'));
        $up['idsupplier'] = $this->security->xss_clean($this->input->post('idsupplier'));
        $up['idbahan'] = $this->security->xss_clean($this->input->post('idbahan'));
        $up['hargasatuan'] = $this->security->xss_clean($this->input->post('hargasatuan'));
        $up['satuan'] = $this->security->xss_clean($this->input->post('satuan'));
        $up['jenis'] = $this->security->xss_clean($this->input->post('jenis'));
        $up['spesifikasi'] = $this->security->xss_clean($this->input->post('spesifikasi'));
        $up['stat'] = $this->security->xss_clean($this->input->post('stat'));       
        $res = $this->supplier_query->ExecData_bahansupplier($up);
        if ($res == 1){
            echo 101;
        } else if ($res == 0){
            echo 100;
        }
    }

    public function konfirmasi_hapusbahansupplier_manual()
    {
        $data['idbahansupplier'] = $this->security->xss_clean($this->input->post('idbahansupplier'));
        $data['bahansupplier'] = $this->supplier_query->listdataBahanSupplierWhere($data['idbahansupplier']);

        $this->load->view('konfirmasi_hapusbahansupplier_manual',$data);
    }

}