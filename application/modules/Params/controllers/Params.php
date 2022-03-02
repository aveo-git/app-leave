<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Params extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('security/authenticate');
        $this->load->module('mail/mail');
        $this->load->model('main_model', 'main');
        $this->load->library('email');
    }

    public function index() {
        $sess = $this->session->userdata('logged_in');
        if($sess['typeAuth'] == "ldap") {
            redirect('/');
        } else {
            $title = "Paramètre";
            $data['params'] = $this->params->get_all();
            $active_temp = array(
                'ldap' => "active",
                'ad' => "",
                "userad" => "",
                "list" => "",
            );
            $data['system'] = $this->main->get_all_system();
            $data['md'] = $this->params->get_all_md();
            $data['domains'] = $this->params->get_all_domains();
            $data['services'] = $this->params->get_all_services();
            $data['logiciels'] = $this->params->get_all_logiciels();
            $data['active'] = $this->session->userdata('active_button') != NULL ? $this->session->userdata('active_button') : $active_temp ;
            // var_dump($data);
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
        $html['session_userad'] = $this->session->userdata('logged_in');
        
        if (!is_null($content) && $content != '') {
            $html['content'] = $content;
        }
        $this->load->view('index', $html);
    }

    // Set nouveau params
    public function insert_param() {
        $params = array(
            "param_code" => $this->input->post('param_code'),
            "param_lib" => $this->input->post('param_lib'),
            "param_value" => $this->input->post('param_value'),
        );
        $this->params->insert_data($params);
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

    // Inserer un mail de diffusion
    public function insert_maildiffusion() {
        $data = array(
            "md_label" => $this->input->post('md_label'),
            "md_description" => $this->input->post('md_description'),
            "md_typeImport" => $this->input->post('md_typeImport'),
        );
        if($this->input->post('id_mailDiffusion') == NULL) {
            $this->params->insert_maildiffusion($data);
        } else {
            $id = $this->input->post('id_mailDiffusion');
            $this->params->update_maildiffusion($data, $id);
        }
    }
    // Supprimer un mail de diffusion
    public function delete_maildiffusion() {
        $id = $this->input->post('id_mailDiffusion');
        $this->params->delete_maildiffusion($id);
    }

    // Inserer un domaine
    public function insert_domaine() {
        $data = array(
            "d_label" => $this->input->post('d_label'),
            "d_description" => $this->input->post('d_description'),
        );
        if($this->input->post('id_domaine') == NULL) {
            $this->params->insert_domaine($data);
        } else {
            $id = $this->input->post('id_domaine');
            $this->params->update_domaine($data, $id);
        }
    }
    // Supprimer un domaine
    public function delete_domaine() {
        $id = $this->input->post('id_domaine');
        $this->params->delete_domaine($id);
    }

    // Inserer un domaine
    public function insert_system() {
        $data = array(
            "sy_nom" => $this->input->post('sy_nom'),
            "sy_description" => $this->input->post('sy_description'),
        );
        $this->params->insert_system($data);
    }

    // Inserer une service
    public function insert_service() {
        $data = array(
            "sc_label" => $this->input->post('sc_label'),
            "sc_mail" => $this->input->post('sc_mail'),
        );
        if($this->input->post('id_service') == NULL) {
            $data['sc_idSysteme'] = $this->input->post('sc_idSysteme');
            $this->params->insert_service($data);
        } else {
            $id = $this->input->post('id_service');
            $this->params->update_service($data, $id);
        }
    }
    // Supprimer une service
    public function delete_service() {
        $id = $this->input->post('id_service');
        $this->params->delete_service($id);
    }

    // Inserer un logiciel
    public function insert_soft() {
        $data = array(
            "l_label" => $this->input->post('l_label'),
        );
        if($this->input->post('id_logiciel') == NULL) {
            $this->params->insert_soft($data);
        } else {
            $id = $this->input->post('id_logiciel');
            $this->params->update_soft($data, $id);
        }
    }
    // Supprimer une service
    public function delete_logiciel() {
        $id = $this->input->post('id_logiciel');
        $this->params->delete_logiciel($id);
    }

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
            $this->main->insert_collab_imported_on_ad($data['usersLdap']);
            foreach($data as $item) {
                // var_dump($item);
                foreach($item as $d) {
                    $this->main->add_userad($d);
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


        $grp_default = $this->params->get_one_by_code("LDAP_GRP_DEFAULT");
        $grp_default = $grp_default->param_value;

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
                    $description = isset($entries[$i]['description']) ? $entries[$i]['description'][0] : NULL ;
                    $dn = isset($entries[$i]['dn']) ? $entries[$i]['dn'] : NULL ;
                    // Tester si le compte est désactivé (dans OU=Desactive ou bien dans Aveolys mais desactivé)
                    if(!strpos($dn, "OU=Desactive") && $entries[$i]['useraccountcontrol'][0] != "514") {
                        if($principalname != ''){
                            $principalname = str_replace($su_ad->param_value, "", $principalname);
                            $data['usersLdap'][] = array(
                                //'name' => $entries[$i]["cn"][0],
                                'ua_username' => isset($principalname) ? $principalname : NULL,
                                'ua_email' =>  $mail ? : NULL,
                                'ua_prenom' => isset($name[0] )?  $name[0]  : '' ,
                                'ua_nom' => isset($name[1] )?  $name[1]  : '' ,
                                'ua_groupId' => isset($grp_default) ? $grp_default : NULL,
                                'ua_description' => $description,
                                'ua_typeAuth'=> 'ldap',
                                'ua_active' => '0'
                            );
                        }
                    }
                }
            }
            ldap_control_paged_result_response($conn, $result, $cookie);

        } while($cookie !== null && $cookie != '');


        return $data;
    }

    // public function activeCompte_AD() {
    //     $id = $this->input->post('id_userad');
    //     $this->main->activeCompte_AD($id);

    //     $this->session->set_flashdata('error', "NOTE : Compte AD activé.");
    // }

    public function list_userad() {
        $collabs_info = $this->main->get_all_userad();
        // var_dump($collabs_info);
        $data['data'] = $collabs_info;
        $this->output
                ->set_status_header(200)
                ->set_content_type('application/json', 'utf-8')
                ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    public function delete_all_userad() {
        $this->main->delete_userad_not($this->session->userdata('logged_in')['id_userad']);

        $this->session->set_flashdata('error', "NOTE : Compte AD effacé.");
    }

    public function toggle_compte_userad() {
        $statut = $this->input->post('ua_active') == '1' ? '0' : '1';
        $data = array(
            "ua_active" => $statut,
        );
        $this->params->toggle_statut($data, $this->input->post('id_userad'));
        $this->mail->send_mail_toggle_compte(array(
            "ua_email" => $this->main->get_userad_by_id($this->input->post('id_userad'))->ua_email,
            "ua_active" => $statut
        ));

        $this->session->set_flashdata('error', "NOTE : Le statut de l'utilisateur a été changé avec succès.");
    }

    public function delete_userad() {
        $this->params->delete_userad_by_id($this->input->post('id_userad'));
    }

    public function update_userad() {
        $data = array(
            'ua_nom' => $this->input->post('ua_nom'),
            'ua_prenom' => $this->input->post('ua_prenom'),
            'ua_email' => $this->input->post('ua_email'),
            'ua_description' => $this->input->post('ua_description')
        );
        $this->params->update_userad($data, $this->input->post('id_userad'));
        $this->params->update_collab($data, $this->input->post('ua_username'));

        $this->session->set_flashdata('error', "NOTE : L'utilisateur a été modifié avec succès.");
    }

    public function _remap($method) {
        if ($this->authenticate->is_authenticate()) {
            $this->$method();
        } else {
            $this->authenticate->login();
        }
    }

}