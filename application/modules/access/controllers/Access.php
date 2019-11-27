<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends MX_Controller {
    
    public function __construct() 
    {
        parent::__construct();
        $this->load->model('access_query');
        $this->load->module('sistemlog');
    }
    
    function index()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('access/login', 'refresh');
        } else {
            redirect('/', 'refresh');
        }
    }
            
    function login()
    {		
        $data['image'] = $this->createcaptch();
        
        $this->template
                ->set_layout('login')
                ->build('access_login',$data);
    }
    
    function createcaptch()
    {
        $vals = array(
            'img_path'      => './captcha/',
            'img_url'       => base_url().'captcha/',
            'font_path'     => './path/to/fonts/texb.ttf',
            'img_width'     => '150',
            'img_height'    => 30,
            'expiration'    => 7200,
            'word_length'   => 6,
            'font_size'     => 16,
            'img_id'        => 'Imageid',
            'pool'          => '0123456789',

            // White background and border, black text and red grid
            'colors'    => array(
                'background'=> array(255, 255, 255),
                'border'    => array(255, 255, 255),
                'text'      => array(0, 0, 0),
                'grid'      => array(255, 40, 40)
            )
        );

        $cap = create_captcha($vals);
        
        $data = array(
            'captcha_time'  => $cap['time'],
            'ip_address'    => $this->input->ip_address(),
            'word'          => $cap['word']
        );
        
        $query = $this->db->insert_string('captcha', $data);
        $this->db->query($query);
        
        return $cap['image'];
    }
    
    function cekcaptcha($keycaptcha)
    {
        $captcha = $keycaptcha;
        $expiration = time() - 7200; // Two hour limit
        $ip_address = $this->input->ip_address();
        
        // First, delete old captchas        
        $this->db->where('captcha_time < ', $expiration)
                ->delete('captcha');

        // Then see if a captcha exists:
        $sql = 'SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?';
        $binds = array($captcha, $ip_address, $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();

        if ($row->count == 0){
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    function ceklogin()
    {
        $keycaptcha = $this->security->xss_clean($this->input->post('keycaptcha'));        
        $username = $this->security->xss_clean($this->input->post('username'));
        $password = $this->security->xss_clean($this->input->post('password'));
        
        $captcha = $this->cekcaptcha($keycaptcha);
        
        if ($captcha == FALSE){
            echo 104;
        } else {        
            $q = $this->access_query->getLoginData($username,$password);

            $data['type'] = 'system';
            $data['username'] = $username;
            $data['url'] = $this->session->userdata('url');
            $ip_address = $this->input->ip_address();
            $user_agent = $this->input->user_agent();

            if ($q == 101) {
                //username salah            
                $data['msg'] = 'Username: '.$username.' tidak terdaftar, IP: '.$ip_address.', Browser: '.$user_agent;
                $this->sistemlog->aktifitas($data);
                echo $q;
            } else if ($q == 102) {
                //password salah
                $data['msg'] = 'Username: '.$username.' password tidak terdaftar, IP: '.$ip_address.', Browser: '.$user_agent;
                $this->sistemlog->aktifitas($data);
                echo $q;
            } else if ($q == 103) {
                //username dan password tidak terdaftar
                $data['msg'] = 'Username: '.$username.' dan password tidak terdaftar, IP: '.$ip_address.', Browser: '.$user_agent;
                $this->sistemlog->aktifitas($data);
                echo $q;
            } else if ($q == 109) {
                //username dan password terdaftar
                $data['msg'] = 'Username: '.$username.' berhasil login, IP: '.$ip_address.', Browser: '.$user_agent;
                $this->sistemlog->aktifitas($data);
                echo $q;
            }
        }

        //	"101";  username salah
        //	"102";	password salah
        //	"103";	username dan password tidak terdaftar
        //	"109";	username dan password terdaftar
    }
            
    function logout()
    {
        $username = $this->session->userdata('username');
        $data['type'] = 'system';
        $data['username'] = $username;
        $data['url'] = $this->input->server('REQUEST_URI');
        $ip_address = $this->input->ip_address();
        $user_agent = $this->input->user_agent();
        $data['msg'] = 'Username: '.$username.' berhasil logout, IP: '.$ip_address.', Browser: '.$user_agent;
        $this->sistemlog->aktifitas($data);
        $this->session->sess_destroy();
	    redirect('/', 'refresh');
    }
    
    function forgot_password()
    {
        $data['image'] = $this->createcaptch();
        
        $this->template
                ->set_layout('login')
                ->build('access_forgotpassword',$data);
    }
    
    function hakakses($idgrup,$url)
    {
        $q = $this->access_query->getHakAkses($idgrup,$url);
        return $q;
    }
    
    function statHakAkses()
    {
        $this->load->view("access_stathakakses");
    }
    
}