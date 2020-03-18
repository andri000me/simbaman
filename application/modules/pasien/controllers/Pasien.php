<?php

/**
 * @author [syafrial zulmi]
 * @email [syafrialzulmi@mail.com]
 * @create date 2019-09-13 07:23:26
 * @modify date 2019-09-13 07:23:26
 * @desc [description]
 */

class Pasien extends MX_Controller {
    private $filename = "import_data"; // Kita tentukan nama filenya

    protected $data = '';

    public function __construct() 
    {
        parent::__construct();        
        $this->load->model('pasien_query');
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
            
            $data['tanggalsekarang'] = date("Y-m-d");
            
            $this->template
                    ->set_layout('default')
                    ->build('rekappasien_view',$data);
        } else {
            $this->access->statHakAkses();
        }
    }

    public function tanggalrekappasien()
    {
        $data['tglrekap'] = $this->security->xss_clean($this->input->post('tglrekap'));

        $tglterakhir = $this->pasien_query->get_tglterakhir($data['tglrekap']);

        if (count($tglterakhir) == 0) {
            $tglrekap = $data['tglrekap'];

            $url='http://sididik.rsjsoerojo.co.id/ranap/pasiengizi/'.$data['tglrekap'];
            $json = file_get_contents($url);
            $pasien = json_decode($json,true);
            $data_pasien = $pasien['data'];
            if (count($data_pasien) == 0) {
                echo '<div class="row" style="margin-bottom:10px">
                    <div class="col-lg-12" style="text-align: center;">
                        <div class="alert alert-danger alert-dismissible">
                            <h4><i class="icon fa fa-warning"></i> Perhatian!</h4>
                            Data pasien tanggal '.$tglrekap.'belum tersedia, silahkan membuka tanggal yang lain.
                        </div>
                    </div>
                </div>';
            } else {
                $this->pasien_query->import_data_json($pasien);

                $data['grupkelas'] = $this->pasien_query->get_grupkelas_tmp();
                $data['grupruangan'] = $this->pasien_query->get_grupruangan_tmp();
                $data['jumlahpasien'] = $this->pasien_query->get_jumlahpasien_tmp();
                $tglrekap = $this->pasien_query->get_tanggalrekappasien_tmp();

                $data['tglrekap'] = $tglrekap[0]['tanggalrekap'];

                $this->load->view('rekappasien_tmp', $data);
            }            
        } else {
            $data['grupkelas'] = $this->pasien_query->get_grupkelas($data['tglrekap']);
            $data['grupruangan'] = $this->pasien_query->get_grupruangan($data['tglrekap']);
            $data['jumlahpasien'] = $this->pasien_query->get_jumlahpasien($data['tglrekap']);

            $this->load->view('rekappasien_tglrekap', $data);
        }
    }

    public function form_ubahjumlahpasien()
    {
        $idjumlahpasien = $this->security->xss_clean($this->input->post('idjumlahpasien'));

        $data['data_jumlahpasien'] = $this->pasien_query->get_data_jumlahpasien($idjumlahpasien);

        $this->load->view('rekappasien_form_ubahjumlahpasien', $data);
    }

    public function ubahjumlahpasien()
    {
        $idrekapjumlahpasien = $this->security->xss_clean($this->input->post('idrekapjumlahpasien'));
        $jumlahpasien = $this->security->xss_clean($this->input->post('jumlahpasien'));

        $ubah = $this->pasien_query->ubahjumlahpasien($idrekapjumlahpasien,$jumlahpasien);
    }

    public function infomodul()
    {
        $this->load->view('rekappasien_info');
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
            
            $this->template
                    ->set_layout('default')
                    ->build('rekappasien_form',$data);
            
        } else {
            $this->access->statHakAkses();
        }
    }

    public function uploadfile()
    {
        $t = time();

        $max_size   = "500000";

        $tglrekap   = $_POST['tglrekap'];

        $error      = $_FILES["InputFile"]["error"];
        $fileSize   = $_FILES['InputFile']['size'];
        
        $type = explode(".", $_FILES["InputFile"]["name"]);
        $type = $type[count($type)-1];

        $namafile = $this->filename."_".$t.".".$type;

        $url = "./excel/".$namafile;

        if ($fileSize <= $max_size){
            if (in_array($type, array("xlsx"))){
                if (is_uploaded_file($_FILES["InputFile"]["tmp_name"])){
                    if (move_uploaded_file ($_FILES["InputFile"]["tmp_name"], $url)){

                        include_once APPPATH."third_party/phpexcel/Classes/PHPExcel.php";

                        $excelreader = new PHPExcel_Reader_Excel2007();
                        $loadexcel = $excelreader->load('excel/'.$this->filename.'_'.$t.'.xlsx'); // Load file yang tadi diupload ke folder excel
                        $sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);

                        //var_dump($sheet);
                        $this->pasien_query->import_data($sheet);

                        $data['grupkelas'] = $this->pasien_query->get_grupkelas_tmp();
                        $data['grupruangan'] = $this->pasien_query->get_grupruangan_tmp();
                        $data['jumlahpasien'] = $this->pasien_query->get_jumlahpasien_tmp();

                        $data['tglrekap'] = $tglrekap;

                        $this->load->view('rekappasien_tmp', $data);
                    }
                }
            } else {
                echo "Tipe file : ".$type." bukan xlsx";
                exit();
            }
        } else {
            echo "Besar file melebihi batas :".$fileSize;
            exit();
        }
	}

    public function file_excel_default()
    {
        $result = $this->pasien_query->default_kelas_kamar();

        // Load plugin PHPExcel nya    
        include_once APPPATH."third_party/phpexcel/Classes/PHPExcel.php";

        // Panggil class PHPExcel nya    
        $excel = new PHPExcel();

        // Settingan awal fil excel    
        $excel->getProperties()->setCreator('Sistem Informasi Instalasi Gizi')                 
            ->setLastModifiedBy('Sistem Informasi Instalasi Gizi')                 
            ->setTitle("Default Upload Rekap Pasien")                 
            ->setSubject("Pasien")                 
            ->setDescription("Default Laporan Rekap Data Pasien")                 
            ->setKeywords("Default Upload Rekap Pasien");

        // Buat sebuah variabel untuk menampung pengaturan style dari header tabel
        $style_col = array(
            'font' => array('bold' => true), // Set font nya jadi bold
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
        $style_row = array(
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ),
            'borders' => array(
            'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
            'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
            'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
            'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
            )
        );

        // Buat header tabel nya pada baris ke 3
        $excel->setActiveSheetIndex(0)->setCellValue('A1', "idruang"); 
        $excel->setActiveSheetIndex(0)->setCellValue('B1', "idbangsal"); 
        $excel->setActiveSheetIndex(0)->setCellValue('C1', "idkelas"); 
        $excel->setActiveSheetIndex(0)->setCellValue('D1', "namaruang"); 
        $excel->setActiveSheetIndex(0)->setCellValue('E1', "namabangsal");
        $excel->setActiveSheetIndex(0)->setCellValue('F1', "namakelas");
        $excel->setActiveSheetIndex(0)->setCellValue('G1', "jumlahpasien"); 

        // Apply style header yang telah kita buat tadi ke masing-masing kolom header
        $excel->getActiveSheet()->getStyle('A1')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('B1')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('C1')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('D1')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('E1')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('F1')->applyFromArray($style_col);
        $excel->getActiveSheet()->getStyle('G1')->applyFromArray($style_col);

        $no = 1; // Untuk penomoran tabel, di awal set dengan 1
        $numrow = 2; // Set baris pertama untuk isi tabel adalah baris ke 4
        foreach($result as $data) { // Lakukan looping pada variabel siswa
        $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $data['idruang']);
        $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['idbangsal']);
        $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['idkelas']);
        $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['namaruang']);
        $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['namabangsal']);
        $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['namakelas']);
        $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, '');
        
        // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
        $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
        $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
        
        $no++; // Tambah 1 setiap kali looping
        $numrow++; // Tambah 1 setiap kali looping
        }

        // Set width kolom
        $excel->getActiveSheet()->getColumnDimension('A')->setWidth(37); 
        $excel->getActiveSheet()->getColumnDimension('B')->setWidth(37); 
        $excel->getActiveSheet()->getColumnDimension('C')->setWidth(37); 
        $excel->getActiveSheet()->getColumnDimension('D')->setWidth(37); 
        $excel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
        $excel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
        $excel->getActiveSheet()->getColumnDimension('G')->setWidth(13);   
        
        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)
        $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(-1);

        // Set orientasi kertas jadi LANDSCAPE
        $excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

        // Set judul file excel nya
        $excel->getActiveSheet(0)->setTitle("Default Upload Rekap Pasien");
        $excel->setActiveSheetIndex(0);

        // Proses file excel
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Format Default Upload Data Rekap Pasien.xlsx"'); // Set nama file excel nya
        header('Cache-Control: max-age=0');

        $write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
        $write->save('php://output');
    }

    public function importdata()
    {
        $tglrekap = $this->security->xss_clean($this->input->post('tglrekap'));

        $result = $this->pasien_query->importdata($tglrekap);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    public function uploadfile_json()
    {
        $t = time();

        $max_size   = "500000";

        $error      = $_FILES["InputFileJson"]["error"];
        $fileSize   = $_FILES['InputFileJson']['size'];
        
        $type = explode(".", $_FILES["InputFileJson"]["name"]);
        $type = $type[count($type)-1];

        $namafile = $this->filename."_".$t.".".$type;

        $url = "./json/".$namafile;

        if ($fileSize <= $max_size){
            if (in_array($type, array("json"))){
                if (is_uploaded_file($_FILES["InputFileJson"]["tmp_name"])){
                    if (move_uploaded_file ($_FILES["InputFileJson"]["tmp_name"], $url)){
                        $pasien_rekap = file_get_contents('json/'.$this->filename.'_'.$t.'.json');
                        $data_pasien = json_decode($pasien_rekap, true);

                        $this->pasien_query->import_data_json($data_pasien);

                        $data['grupkelas'] = $this->pasien_query->get_grupkelas_tmp();
                        $data['grupruangan'] = $this->pasien_query->get_grupruangan_tmp();
                        $data['jumlahpasien'] = $this->pasien_query->get_jumlahpasien_tmp();
                        $tglrekap = $this->pasien_query->get_tanggalrekappasien_tmp();

                        $data['tglrekap'] = $tglrekap[0]['tanggalrekap'];

                        $this->load->view('rekappasien_tmp', $data);
                    }
                }
            } else {
                echo "Tipe file : ".$type." bukan json";
                exit();
            }
        } else {
            echo "Besar file melebihi batas :".$fileSize;
            exit();
        }
    }

    public function kalender()
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

            $get_tanggalkelas = $this->pasien_query->get_tanggalkelas();

            $events = array();
            foreach ($get_tanggalkelas as $kelas) {
                $e = array();
                $e['title'] = $kelas['namakelas'].' - '.$kelas['jmlpasien'];
                $e['start'] = $kelas['tanggalrekap'];
                $e['allDay'] = $kelas['allDay'];
                $e['backgroundColor'] = $kelas['color'];
                $e['borderColor'] = $kelas['color'];

                array_push($events, $e);
            }
            $data['event'] = json_encode($events);
            
            $this->template
                    ->set_layout('default')
                    ->build('kalender',$data);
        } else {
            $this->access->statHakAkses();
        }        
    }

    public function reset_pasien()
    {
        $tglrekap = $this->security->xss_clean($this->input->post('tglrekap'));

        $result = $this->pasien_query->reset_pasien($tglrekap);

        if ($result) {
            return true;
        } else {
            return false;
        }
    }
}