<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Params extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('security/authenticate');
        $this->load->module('mail/mail');
        $this->load->model('params_model', 'params');
        $this->load->model('security/authenticate_model', 'auth_model');
        $this->load->library('email');
    }

    public function index() {
        $sess = $this->session->userdata('user');
        if($sess['u_profilId'] != "1") {
            redirect('/main');
        } else {
            $title = "Paramètre";
            $params['params_ldap'] = $this->params->get_all(1);
            $params['params_email'] = $this->params->get_all(2);
            $data['general'] = $this->load->view('navs/general', $params, TRUE);

            $users['services'] = $this->params->get_all_service();
            $data['users'] = $this->load->view('navs/users', $users, TRUE);

            $data['calendar'] = $this->load->view('navs/calendar', array(), TRUE);
            $content = $this->load->view('params', $data, TRUE);
            $this->display($content, TRUE, $title);
        }
    }
    
    // Top front
    public function display($content, $isNeedNav, $title) {
        $html['style'] = $this->load->view('elements/header_style', NULL, TRUE);
        $html['script'] = $this->load->view('elements/header_script', NULL, TRUE);
        $html['title'] = $title; // Titre de la page
        $html['isNeedNav'] = $isNeedNav; // Pour le nav : true or false
        $html['model'] = "params"; // pour bouton active
        
        if (!is_null($content) && $content != '') {
            $html['content'] = $content;
        }
        $this->load->view('index', $html);
    }

    // Update params
    public function update_params() {
        $data = array(
            "param_code" => $this->input->post('param_code'),
            "param_lib" => $this->input->post('param_lib'),
            "param_value" => $this->input->post('param_value'),
        );
        // var_dump($this->input->post('code_params'));
        $this->params->update_param($data, $this->input->post('code_params'));
    }

    // Get user
    public function list_user() {
        $data['data'] = $this->params->get_all_user();
        $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    // Importation des données dans AD
    public function import_AD() {
        $AD_IP = $this->params->get_one_by_code("AD_IP");
        $userad = $this->params->get_one_by_code("ADMIN_AD");
        $passad = $this->params->get_one_by_code("PWD_AD");
        $suffixe_ad = $this->params->get_one_by_code("SU_AD");
        $nbuser = 0;
        
        $pseudo = $userad->param_value."".$suffixe_ad->param_value;
        
        $adServer = "ldap://".$AD_IP->param_value; // ldap://192.168.4.15
        $ldap = ldap_connect($adServer);
        // var_dump($ldap);
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        $bind = ldap_bind($ldap, $pseudo, $passad->param_value);
        // var_dump($bind);

        if($bind) {
            $data = $this->retrieves_users($ldap);
            foreach($data as $item) {
                // var_dump($item);
                foreach($item as $d) {
                    $this->params->cu_user($d);
                }
            }
        }

        $this->session->set_flashdata('error', "NOTE : Compte AD importé.");
    }

    protected function retrieves_users($conn)
    {
        //Base DN
        $basedn = $this->params->get_one_by_code("DN_AC");
        $dn        = $basedn->param_value;
	
		$su_ad = $this->params->get_one_by_code("SU_AD"); //suffixe AD @domaine.local

        //Filtre des user à importé
        $ldaptoimport = $this->params->get_one_by_code("LDAP_TO_IMPORT");
        $filter    = $ldaptoimport->param_value;

        $justthese = array();
        // enable pagination with a page size of 100.
        $pageSize = 100;
        $cookie = '';
        do { 
            ldap_control_paged_result($conn, $pageSize, true, $cookie);
            $result  = ldap_search($conn, $dn, $filter, $justthese);
            $entries = ldap_get_entries($conn, $result);
            // var_dump($entries);
            if(!empty($entries)){
                // var_dump($entries);
                for ($i = 0; $i < $entries["count"]; $i++) {
                    $name = explode(' ' , $entries[$i]["name"][0]);
                    $mail = isset ($entries[$i]["mail"] )  ? $entries[$i]["mail"][0] : '' ;
                    $principalname = isset($entries[$i]["samaccountname"]) ? $entries[$i]["samaccountname"][0] : "";
                    $acount_type = $entries[$i]["samaccounttype"];
                    $service = isset($entries[$i]['description']) ? $entries[$i]['description'][0] : NULL ;
                    $dn = isset($entries[$i]['dn']) ? $entries[$i]['dn'] : NULL ;
                    // Tester si le compte est désactivé (dans OU=Desactive ou bien dans Aveolys mais desactivé)
                    if(!strpos($dn, "OU=Desactive") && $entries[$i]['useraccountcontrol'][0] != "514") {
                        if($principalname != ''){
                            $principalname = str_replace($su_ad->param_value, "", $principalname);
                            // Inserer les services
                            $this->params->insert_service(array('s_label' => $service));
                            $data['usersLdap'][] = array(
                                //'name' => $entries[$i]["cn"][0],
                                'u_pseudo' => isset($principalname) ? $principalname : NULL,
                                'u_email' =>  $mail ? : NULL,
                                'u_prenom' => isset($name[0] ) ? $name[0]  : '' ,
                                'u_avatar' => 'default.png',
                                'u_nom' => isset($name[1] )?  $name[1]  : '' ,
                                'u_idService' => $this->params->get_service_by('s_label', $service)->id_service,
                                'u_archived'=> 0,
                                'u_status' => 0,
                                'u_profilId' => 1
                            );
                        }
                    }
                }
            }
            ldap_control_paged_result_response($conn, $result, $cookie);

        } while($cookie !== null && $cookie != '');


        return $data;
    }

    public function update_user() {
        $data = array(
            "u_pseudo" => $this->input->post('u_pseudo'),
            "u_email" => $this->input->post('u_email'),
            "u_nom" => $this->input->post('u_nom'),
            "u_prenom" => $this->input->post('u_prenom'),
            "u_reference" => $this->input->post('u_reference'),
            "u_idService" => $this->input->post('u_idService'),
            "u_dispo" => $this->input->post('u_dispo'),
            "u_dispoYear" => $this->input->post('u_dispoYear'),
        );
        if($this->input->post('id_user') != '') {
            $this->params->update_user($this->input->post('id_user'), $data);
        } else {
            $data["u_avatar"] = 'default.png';
            $data["u_archived"] = 0;
            $data["u_status"] = true;
            $data["u_profilId"] = 1;
            $this->params->insert_user($data);
        }
    }

    public function delete_user() {
        $data = explode(',', $this->input->post('id_user'));
        foreach($data as $id) {
            $this->params->delete_user_by_id($id);
        }
    }
    
    public function toggle_status() {
        $this->params->toggle_status_user($this->input->post('id_user'), filter_var($this->input->post('u_status'), FILTER_VALIDATE_BOOLEAN));
    }
    
    // Ajouter un jour ferié ou clôture d'agence
    public function add_calendar() {
        $data = array(
            'c_debut' => $this->input->post('c_debut'),
            'c_fin' => $this->input->post('c_fin') != '' ? $this->input->post('c_fin') : NULL,
            'c_description' => $this->input->post('c_description'),
            'c_flag' => $this->input->post('c_flag'),
        );
        $id = $this->input->post('id_calendar') != NULL ? $this->input->post('id_calendar') : NULL;
        $this->params->add_calendar($id, $data);
        $this->set_session_calendar();
        $this->set_session_cloture();
    }

    public function remove_calendar() {
        $this->params->remove_calendar($this->input->post('id_calendar'));
        $this->set_session_calendar();
        $this->set_session_cloture();
    }

    private function set_session_calendar() {
        $calendar = $this->auth_model->get_all_calendar();
        $this->session->set_userdata('calendar', $calendar);
    }

    private function set_session_cloture() {
        $cloture = $this->auth_model->get_all_cloture();
        $this->session->set_userdata('cloture', $cloture);
    }

    public function _remap($method) {
        if ($this->authenticate->is_authenticate()) {
            $this->$method();
        } else {
            $this->authenticate->login();
        }
    }

}