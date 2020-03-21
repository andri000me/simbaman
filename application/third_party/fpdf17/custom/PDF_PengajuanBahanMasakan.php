<?php 

include_once dirname(dirname(__FILE__)) . "/fpdf.php";

class PDF_absensi extends FPDF
{
    protected $tanggalpengajuan;
    protected $pengajuanbahan;
    protected $kelas;
    protected $waktumenu;

    public function setTanggalPengajuanBahan($tanggalpengajuan)
	{
		$this -> tanggalpengajuan = $tanggalpengajuan;
    }

    public function setPengajuanBahan($pengajuanbahan)
	{
		$this -> pengajuanbahan = $pengajuanbahan;
    }

    public function setKelasPengajuanBahan($kelas)
    {
        $this -> kelas = $kelas;
    }
    
    public function setWaktuPengajuanBahan($waktumenu)
    {
        $this -> waktumenu = $waktumenu;
    }
    
    function Header()
	{
        $this->SetFont('Arial', 'B', 9);		
        $this->Text(40,6, 'PENGAJUAN BAHAN MASAKAN ');
        $this->Text(40,10, 'INSTALASI GIZI RS');
		$this->Line(40,12,106,12);
		$this->SetFont('Arial', '', 9);
        $this->Text(40,16, 'Tanggal Pengajuan ');
        $this->Text(40,20, 'Kelas');
        $this->Text(40,24, 'Waktu');

        $this->Text(70,16, ':');
        $this->Text(70,20, ':');
        $this->Text(70,24, ':');

        $this->Text(72,16, $this -> tanggalpengajuan);
        $this->Text(72,20, $this -> kelas);
        $this->Text(72,24, $this -> waktumenu);
		
        
        $this->Line(205, 26, 5, 26);
		
        $this->Ln(25); /* */
        
        $width_no = 12;
        $width_namabahan = 50;
        $width_jumlah = 35;
        $width_satuan = 15;
        $width_harga = 30;
        $width_hargatotal = 40;
        $width_ceklist = 20;
        
		$height = 9;
		$value_height = 8;
        $this->setFont('Arial','B',10);
        $this->setFillColor(237,237,237);

		$this->cell($width_no,$height,'No',1,0,'C',1);
		$this->cell($width_namabahan,$height,'Nama Bahan',1,0,'C',1);
        $this->cell($width_jumlah,$height,'Jumlah Kebutuhan',1,0,'C',1);
        $this->cell($width_satuan,$height,'Satuan',1,0,'C',1);
        $this->cell($width_harga,$height,'Harga Supplier',1,0,'C',1);
        $this->cell($width_hargatotal,$height,'Harga Total',1,0,'C',1);
        $this->cell($width_ceklist,$height,'Ceklist',1,0,'C',1);
        $this->Ln();
    }

    //Page Content
	function Content()
	{        
        $width_no = 12;
        $width_namabahan = 50;
        $width_jumlah = 35;
        $width_satuan = 15;
        $width_harga = 30;
        $width_hargatotal = 40;
        $width_ceklist = 20;
        
		$height = 9;
		$value_height = 8;
        // $this->setFont('Arial','',10);
        // $this->setFillColor(237,237,237);

		// $this->cell($width_no,$height,'No',1,0,'C',1);
		// $this->cell($width_namabahan,$height,'Nama Bahan',1,0,'C',1);
        // $this->cell($width_jumlah,$height,'Jumlah Kebutuhan',1,0,'C',1);
        // $this->cell($width_satuan,$height,'Satuan',1,0,'C',1);
        // $this->cell($width_harga,$height,'Harga Supplier',1,0,'C',1);
        // $this->cell($width_hargatotal,$height,'Harga Total',1,0,'C',1);
        // $this->cell($width_ceklist,$height,'Ceklist',1,0,'C',1);
        // $this->Ln();
        $this->setFont('Arial','',9);
        $this->setFillColor(255,255,255);
        $hargatotal = 0;
        foreach($this -> pengajuanbahan as $key => $data){
            if ($data['idpengajuandiet'] != '') {
                $tanda = '*';
            } else {
                $tanda = '';
            }

            if ($data['idsisabahan'] != '') {
                $tandatanda = '^';
            } else {
                $tandatanda = '';
            }
            $nomor = $key+1;
            $this->cell($width_no,$value_height,$nomor.' '.$tanda.''.$tandatanda,1,0,'C',1);
            $this->cell($width_namabahan,$value_height,$data['namabahan'],1,0,'L',1);
            if ($data['satuan'] == 'gr') {
                $totaljumlahkuantitas = number_format(($data['totaljumlahkuantitas']/1000),3,",",".");
                $satuan = 'kg';
            } else if ($data['satuan'] == 'ml') {
                $totaljumlahkuantitas = number_format(($data['totaljumlahkuantitas']/1000),3,",",".");
                $satuan = 'l';
            } else {
                $totaljumlahkuantitas = number_format($data['totaljumlahkuantitas'],0,",",".");
                $satuan = $data['satuan'];
            }
            $this->cell($width_jumlah,$value_height,$totaljumlahkuantitas,1,0,'R',1);
            $this->cell($width_satuan,$value_height,$satuan,1,0,'C',1);
            $this->cell($width_harga,$value_height,number_format($data['hargasatuansupplier'],2),1,0,'R',1);
            $this->cell($width_hargatotal,$value_height,number_format($data['totalhargatotal'],2,",","."),1,0,'R',1);
            $this->cell($width_ceklist,$value_height,'',1,0,'C',1);
            $this->Ln();
            $hargatotal = $hargatotal + $data['totalhargatotal'];
        }
        $this->setFont('Arial','',10);
        $this->setFillColor(237,237,237);
        $this->cell(142,$height,'Harga Total Pengajuan Bahan Masakan',1,0,'C',1);
        $this->cell($width_hargatotal,$height,number_format($hargatotal,2,",","."),1,0,'R',1);
        $this->cell($width_ceklist,$height,'',1,0,'C',1);
        
    }
    // Page footer
	function Footer()
	{            
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}