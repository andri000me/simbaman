<?php 

include_once dirname(dirname(__FILE__)) . "/fpdf.php";


class PDF_absensi extends FPDF
{
	protected $participants;
	protected $total_participants;
	protected $data_ujian;
	protected $brand;
    // Page header
	public function setBrand($brand)
	{
		$this -> brand = $brand;
	}
	
	public function setDataPeserta($peserta)
	{
		$this -> participants = $peserta;
	}
	
	public function setTotalParticipants($total_participants)
	{
		$this -> total_participants = $total_participants;
	}
	
	public function setDataUjian($data_ujian)
	{
		$this -> data_ujian = $data_ujian;
	}
	
	function Header()
	{
		$this->Image(dirname(__FILE__).'/logofk.gif',10,5,20);


		$this->SetFont('Arial', 'B', 9);		
		$this->Text(40,6, 'UJIAN KOMPETENSI '.$this -> brand);
		$this->Text(40,10, 'FAKULTAS KEDOKTERAN UNISSULA');
		$this->Line(40,12,106,12);
		$this->SetFont('Arial', '', 9);
		$this->Text(40,16, 'ABSENSI CBT (Computer Based Test)');
		
		$this->SetFont('Arial', '', 9);
		$this->Text(124,6, 'Nama Ujian');
		$this->Text(124,11, 'Tanggal Ujian');
		$this->Text(124,16, 'Jumlah Peserta');
		
		$this->Text(152,6, ':');
		$this->Text(152,11, ':');
		$this->Text(152,16, ':');
		
		$this->SetFont('Arial', 'B', 9);
		$this->Text(154,6, $this -> data_ujian['nama_ujian']);
		$this->Text(154,11, $this -> data_ujian['tanggal_ujian_human_id']);
		$this->Text(154,16, $this -> total_participants);
		
		
		$this->Line(350, 26, 5, 26);
		
		$this->Ln(25); /* */

	}
        
        //Page Content
	function Content()
	{
		$width_nama = 88;
		$width_no = 19;
		$width_upass = 45;
		$height = 14;
		$value_height = 15;
        $this->setFont('Arial','',14);
        $this->setFillColor(237,237,237);
		$this->cell($width_no,$height,'NO',1,0,'C',1);
		$this->cell($width_nama,$height,'NAMA PESERTA',1,0,'C',1);
		$this->cell($width_upass,$height,'USERNAME',1,0,'C',1);
		$this->cell($width_upass,$height,'TANDA TANGAN',1,0,'C',1);
		$this->Ln();
		foreach($this -> participants as $key => $participant){
			$nomor = $key+1;
			$this->cell($width_no,$value_height,$nomor,1,0,'C',0);
			$this->cell($width_nama,$value_height,$participant['namalengkap'],1,0,'L',0);
			$this->cell($width_upass,$value_height,$participant['username'],1,0,'C',0);
			if($nomor%2==1){
				$align_ttd = "L";
			} else {
				$align_ttd = "C";
			}
			$this->cell($width_upass,$value_height,$nomor.".",1,0,$align_ttd,0);
			$this->Ln();
		}
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