<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Params extends MX_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->module('security/authenticate');
        $this->load->module('mail/mail');
        $this->load->model('params_model', 'params');
        $this->load->model('security/authenticate_model', 'auth_model');
        $this->load->library('email');

        $this->ciphering = "AES-128-CTR";
        $this->encryption_key = "EgteqOMGgX1MRrDxm2q22t0Iy9FzpNHB9bLtL";
        $this->description_iv = '1234567891011121';
    }

    public function index()
    {
        $sess = $this->session->userdata('user');
        if ($sess['u_profilId'] != "3") {
            redirect('/main');
        } else {
            $title = "Paramètre";
            $services = $this->params->get_all_service();
            $params['users'] = json_encode((array) $this->params->get_all_user());
            $params['params_ldap'] = $this->params->get_all(1);
            $params['params_ldap'][5]->param_value = $this->decrypt($params['params_ldap'][5]->param_value);
            $params['params_email'] = $this->params->get_all(2);
            $params['params_email'][4]->param_value = $this->decrypt($params['params_email'][4]->param_value);
            $params['services'] = $services;
            $params['params_sell'] = $this->params->get_all(3);
            $data['general'] = $this->load->view('navs/general', $params, TRUE);

            $users['resp'] = $this->params->get_one_by_code("email_destinataire")->param_value;
            $users['services'] = $services;
            $data['users'] = $this->load->view('navs/users', $users, TRUE);

            $data['calendar'] = $this->load->view('navs/calendar', array(), TRUE);
            if ($this->session->userdata('link') == null) {
                $this->session->set_userdata('link', array(
                    'general' => 'active',
                    'users' => '',
                    'calendar' => ''
                ));
            }
            $content = $this->load->view('params', $data, TRUE);
            $this->display($content, TRUE, $title);
        }
    }

    // Top front
    public function display($content, $isNeedNav, $title)
    {
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
    public function update_params()
    {
        $data = array(
            "param_code" => $this->input->post('param_code'),
            "param_lib" => $this->input->post('param_lib'),
            "param_value" => $this->input->post('param_value'),
        );
        if ($data['param_code'] == "PWD_AD" || $data['param_code'] == "email_password") {
            $data['param_value'] = $this->encrypt($data['param_value']);
        }
        // var_dump($this->input->post('code_params'));
        $this->params->update_param($data, $this->input->post('code_params'));
    }

    // Get user
    public function list_user()
    {
        $data['data'] = $this->params->get_all_user();
        $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    }

    // Importation des données dans AD
    public function import_AD()
    {
        $AD_IP = $this->params->get_one_by_code("AD_IP");
        $userad = $this->params->get_one_by_code("ADMIN_AD");
        $passad = $this->params->get_one_by_code("PWD_AD");
        $suffixe_ad = $this->params->get_one_by_code("SU_AD");
        $nbuser = 0;

        $pseudo = $userad->param_value . "" . $suffixe_ad->param_value;

        $adServer = "ldap://" . $AD_IP->param_value; // ldap://192.168.4.15
        $ldap = ldap_connect($adServer);
        // var_dump($ldap);
        ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

        $bind = ldap_bind($ldap, $pseudo, $this->decrypt($passad->param_value));
        // var_dump($bind);

        if ($bind) {
            $data = $this->retrieves_users($ldap);
            foreach ($data as $item) {
                // var_dump($item);
                foreach ($item as $d) {
                    $this->params->cu_user($d);
                }
            }
        }

        $this->session->set_flashdata('alert', "NOTE : Compte AD importé.");
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
            if (!empty($entries)) {
                // var_dump($entries);
                for ($i = 0; $i < $entries["count"]; $i++) {
                    $name = explode(' ', $entries[$i]["name"][0]);
                    $mail = isset($entries[$i]["mail"])  ? $entries[$i]["mail"][0] : '';
                    $principalname = isset($entries[$i]["samaccountname"]) ? $entries[$i]["samaccountname"][0] : "";
                    $acount_type = $entries[$i]["samaccounttype"];
                    $service = isset($entries[$i]['description']) ? $entries[$i]['description'][0] : NULL;
                    $dn = isset($entries[$i]['dn']) ? $entries[$i]['dn'] : NULL;
                    // Tester si le compte est désactivé (dans OU=Desactive ou bien dans Aveolys mais desactivé)
                    if (!strpos($dn, "OU=Desactive") && $entries[$i]['useraccountcontrol'][0] != "514") {
                        if ($principalname != '') {
                            $principalname = str_replace($su_ad->param_value, "", $principalname);
                            // Inserer les services
                            $this->params->insert_service(array('s_label' => $service));
                            $data['usersLdap'][] = array(
                                //'name' => $entries[$i]["cn"][0],
                                'u_pseudo' => isset($principalname) ? $principalname : NULL,
                                'u_email' =>  $mail ?: NULL,
                                'u_prenom' => isset($name[0]) ? $name[0]  : '',
                                'u_avatar' => 'default.png',
                                'u_nom' => isset($name[1]) ?  $name[1]  : '',
                                'u_idService' => $this->params->get_service_by('s_label', $service)->id_service,
                                'u_archived' => 0,
                                'u_status' => 1,
                                'u_profilId' => 1
                            );
                        }
                    }
                }
            }
            ldap_control_paged_result_response($conn, $result, $cookie);
        } while ($cookie !== null && $cookie != '');


        return $data;
    }

    public function update_user()
    {
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
        if ($this->input->post('id_user') != '') {
            $this->params->update_user($this->input->post('id_user'), $data);

            $this->session->set_flashdata('alert', "NOTE : Utilisateur modifié avec succès.");
        } else {
            $password = $this->random_password();
            $data["u_avatar"] = 'default.png';
            $data["u_archived"] = 0;
            $data['u_password'] = password_hash($password, PASSWORD_BCRYPT);
            $data["u_status"] = true;
            $data["u_profilId"] = 2;
            $this->params->insert_user($data);
            $data['u_password'] = $password;
            $this->mail->send_mail_newuser($data);

            $this->session->set_flashdata('alert', "NOTE : Utilisateur ajouté avec succès.");
        }
    }

    public function delete_user()
    {
        $data = explode(',', $this->input->post('id_user'));
        foreach ($data as $id) {
            $this->params->delete_user_by_id($id);
        }
    }

    public function toggle_status()
    {
        $this->params->toggle_status_user($this->input->post('id_user'), filter_var($this->input->post('u_status'), FILTER_VALIDATE_BOOLEAN));
    }

    // Ajouter un jour ferié ou clôture d'agence
    public function add_calendar()
    {
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

    public function send_test()
    {
        $this->mail->send_test();

        $this->session->set_flashdata('alert', "NOTE : Mail envoyé. \n Vérifier à nouveau les paramètres si vous ne recevrez aucun mail.");
    }

    public function add_service()
    {
        $data = array(
            's_label' => $this->input->post('s_label'),
            's_description' => $this->input->post('s_description')
        );
        $this->params->insert_service($data);
    }

    public function update_service()
    {
        $data = array(
            's_label' => $this->input->post('s_label'),
            's_description' => $this->input->post('s_description')
        );
        $this->params->update_service($this->input->post('id_service'), $data);
    }

    public function delete_service()
    {
        $this->params->delete_service($this->input->post('id_service'));
    }

    public function set_link()
    {
        $data = array('general' => '', 'users' => '', 'calendar' => '');
        switch ($this->input->post('link')) {
            case 'general':
                $data['general'] = 'active';
                break;
            case 'users':
                $data['users'] = 'active';
                break;
            case 'calendar':
                $data['calendar'] = 'active';
                break;
        }
        $this->session->set_userdata('link', $data);
    }

    public function remove_calendar()
    {
        $this->params->remove_calendar($this->input->post('id_calendar'));
        $this->set_session_calendar();
        $this->set_session_cloture();
    }

    private function set_session_calendar()
    {
        $calendar = $this->auth_model->get_all_calendar();
        $this->session->set_userdata('calendar', $calendar);
    }

    private function set_session_cloture()
    {
        $cloture = $this->auth_model->get_all_cloture();
        $this->session->set_userdata('cloture', $cloture);
    }

    public function random_password()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 12; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public function encrypt($password)
    {
        return openssl_encrypt($password, $this->ciphering, $this->encryption_key, 0, $this->description_iv);
    }

    public function decrypt($password)
    {
        return openssl_decrypt($password, $this->ciphering, $this->encryption_key, 0, $this->description_iv);
    }

    public function _remap($method)
    {
        if ($this->authenticate->is_authenticate()) {
            $this->$method();
        } else {
            $this->authenticate->login();
        }
    }
}
