<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CertCheck{

    public function check_certificate(){
        $CI =& get_instance();
        $class = $CI->router->fetch_class();
        if ($class !== "certificate") {
            if($CI->session->userdata('certified') === NULL){
                $CI->load->model('certificate/Certificate_model','crtmodel');
                $key = $CI->crtmodel->getkey();
                $url = "http://localhost:4000/keys/verify/" . urlencode($key);
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
    
                if(curl_errno($ch)){
                    redirect('/certificate/expire');
                }else{
                    $status = curl_getinfo($ch,CURLINFO_HTTP_CODE);
                    if($status === 200){
                        $CI->session->set_userdata('certified',TRUE);
                    }else{
                        redirect('/certificate/expire');
                    }
                    
                }
            }  
        }
    }
}

?>