<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('GoogleAuthenticator');
        $this->load->library('mailer');
        $this->load->model('M_user');
        $this->load->helper('cookie');
    }

    public function index()
    {
        $this->form_validation->set_rules('email', 'E-Mail or Username', 'required|trim', [
            'required' => $this->lang->line('require_email_username')
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => $this->lang->line('require_password')
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Sign in';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $otp_code = $this->input->post('otp_code');

        $user = $this->M_user->get_user_byemail($email);

        //$this->db->get_where('user', ['email' => $email])->row_array();
        // OTP
        $user_secret = $user['secret_otp'] ?? null;
        $is_otp = $user['is_otp'] ?? null;
        $ga = new GoogleAuthenticator();

        if ($user) {
            if ($user['is_active'] == 1) {
                if ($user_secret != '' and $is_otp == 1) {
                    if ($otp_code != '') {
                        $checkResult = $ga->verifyCode($user_secret, $otp_code);
                        if ($checkResult) {
                            if (password_verify($password, $user['password'])) {
                                $data = [
                                    'email' => $user['email'],
                                    'role_id' => $user['role_id'],
                                    'purchase' => '0'
                                ];

                                $this->session->set_userdata($data);
                                redirect('user');
                            } else {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_password').'</div>');
                                redirect('auth');
                            }
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_otp_code').'</div>');
                            redirect('auth');
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('enter_otp_code').'</div>');
                        redirect('auth');
                    }
                } else {
                    if ($otp_code == '') {
                        if (password_verify($password, $user['password'])) {
                            $data = [
                                'email' => $user['email'],
                                'role_id' => $user['role_id'],
                                'purchase' => '0'
                            ];

                            $this->session->set_userdata($data);
                            redirect('user');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_password').'</div>');
                            redirect('auth');
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('donthave_otp').'</div>');
                        redirect('auth');
                    }
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('email_not_active').'</div>');
                redirect('auth');
            }
        } else {
            $user_name = $this->M_user->get_user_byusername($email);
            //$this->db->get_where('user', ['username' => $email])->row_array();
            $secret = $user_name['secret_otp'];
            $is_otp = $user_name['is_otp'];

            if ($user_name) {
                if ($user_name['is_active'] == 1) {
                    if ($secret != '' and $is_otp == 1) {
                        if ($otp_code != '') {
                            $checkResult = $ga->verifyCode($secret, $otp_code);
                            if ($checkResult) {
                                if (password_verify($password, $user_name['password'])) {
                                    $data = [
                                        'email' => $user_name['email'],
                                        'role_id' => $user_name['role_id'],
                                        'purchase' => '0'
                                    ];

                                    $this->session->set_userdata($data);
                                    redirect('user');
                                } else {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_password').'</div>');
                                    redirect('auth');
                                }
                            } else {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_otp_code').'</div>');
                                redirect('auth');
                            }
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('enter_otp_code').'</div>');
                            redirect('auth');
                        }
                    } else {
                        if ($otp_code == '') {
                            if (password_verify($password, $user_name['password'])) {
                                $data = [
                                    'email' => $user_name['email'],
                                    'role_id' => $user_name['role_id'],
                                    'purchase' => '0'
                                ];

                                $this->session->set_userdata($data);
                                redirect('user');
                            } else {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_password').'</div>');
                                redirect('auth');
                            }
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('donthave_otp').'</div>');
                            redirect('auth');
                        }
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('email_not_active').'</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('email_username_not_register').'</div>');
                redirect('auth');
            }
        }
    }

    //Registration Proses
    public function registration()
    {
        $this->form_validation->set_rules('username', 'ID', 'required|trim|min_length[5]', [
            'required' => $this->lang->line('to_short'),
            'min_length' => $this->lang->line('to_short')
        ]);
        $this->form_validation->set_rules('firstname', 'Name', 'required|trim', [
            'required' => $this->lang->line('to_short')
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'required' => $this->lang->line('to_short'),
            'valid_email' => $this->lang->line('not_valid_email')
        ]);
        $this->form_validation->set_rules('check_code', 'Email Code', 'required', [
            'required' => $this->lang->line('require_email_code')
        ]);
        $this->form_validation->set_rules('country', 'Country Code', 'required', [
            'required' => $this->lang->line('require_country_code')
        ]);
        $this->form_validation->set_rules('phone', 'Phone', 'required|numeric|max_length[13]', [
            'required' => $this->lang->line('require_country_code')
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'callback_valid_password');
        $this->form_validation->set_rules('password2', 'Repeat Password', 'matches[password1]', [
            'matches' => $this->lang->line('matches_password')
        ]);
        $this->form_validation->set_rules('accept_terms', '...', 'callback_accept_terms');
        $this->form_validation->set_rules('basecamp', 'Basecamp', 'required', [
            'required' => $this->lang->line('require_basecamp')
        ]);

        if ($this->form_validation->run() == false) //check validation
        {
            $data['title'] = 'Sign Up';
            $data['user'] = $this->M_user->get_user_byemail($this->session->userdata('email'));
            $data['camp'] = $this->M_user->get_all_basecampname();
            $data['check'] = $this->M_user->get_all_user($this->input->post('username'));
            $data['count'] = $this->M_user->count_all_user();

            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');

            if (isset($_POST['check'])) {
                $permitted_chars = '0123456789';
                $code = substr(str_shuffle($permitted_chars), 0, 6);
                $email = $this->input->post('email');

                // Check Code
                $user_token = [
                    'email' => $email,
                    'token' => $code,
                    'date_create' => time()
                ];
                $this->M_user->insert_token('user_token', $user_token);

                $subject = "=?UTF-8?B?".base64_encode($this->lang->line('checking_email'))."?=";
                $message  = $this->lang->line('message_copy_code')." : <br/><br/> $code";
                $sendmail = array(
                    'recipient_email' => $email,
                    'subject' => $subject,
                    'content' => $message
                );

                $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                echo "<script>
                    alert('".$this->lang->line('alert_check_email')."')
                </script>";
            }
        } else {
            $email = $this->input->post('email', true);
            $check_code = $this->input->post('check_code');
            $data['token'] = $this->M_user->get_token_byemail($email);

            $basecamp_input = htmlspecialchars($this->input->post('basecamp'), true);

            $query_basecamp = $this->M_user->get_data_byid('basecamp_name', 'id', $basecamp_input);

            $id_bs   = $query_basecamp['id'];
            $name_bs = $query_basecamp['name'];

            if ($data['token']['token'] == $check_code) {
                $data = [
                    'username' => htmlspecialchars($this->input->post('username', true)),
                    'first_name' => htmlspecialchars($this->input->post('firstname', true)),
                    'email' => htmlspecialchars($email),
                    'country_code' => htmlspecialchars($this->input->post('country'), true),
                    'phone' => $this->input->post('phone'),
                    'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                    'basecamp' => $name_bs,
                    'id_basecamp' => $id_bs,
                    'role_id' => 2,
                    'is_active' => 1,
                    'date_created' => time()
                ];
                $this->M_user->insert_user('user', $data);

                $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">'.$this->lang->line('success_register').'</div>');
                redirect('auth');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_email_check_again').'</div>');
                redirect('auth/registration');
            }
        }
    }

    public function accept_terms()
    {
        if (isset($_POST['accept_terms'])) return true;
        $this->form_validation->set_message('accept_terms', $this->lang->line('must_accept_term'));
        return false;
    }

    //Create strong password 
    public function valid_password($password = '')
    {
        $password = trim($password);

        $regex_lowercase = '/[a-z]/';
        $regex_uppercase = '/[A-Z]/';
        $regex_number = '/[0-9]/';
        $regex_special = '/[!@#$%^&*()\-_=+{};:,<.>ยง~]/';

        if (empty($password)) {
            $this->form_validation->set_message('valid_password', $this->lang->line('incorrect_password'));

            return FALSE;
        }

        if (preg_match_all($regex_lowercase, $password) < 1) {
            $this->form_validation->set_message('valid_password', $this->lang->line('at_least_lowercase'));

            return FALSE;
        }

        if (preg_match_all($regex_uppercase, $password) < 1) {
            $this->form_validation->set_message('valid_password', $this->lang->line('at_least_uppercase'));

            return FALSE;
        }

        if (preg_match_all($regex_number, $password) < 1) {
            $this->form_validation->set_message('valid_password', $this->lang->line('at_least_number'));

            return FALSE;
        }

        if (strlen($password) < 10) {
            $this->form_validation->set_message('valid_password', $this->lang->line('at_least_character'));

            return FALSE;
        }

        if (strlen($password) > 32) {
            $this->form_validation->set_message('valid_password', $this->lang->line('max_char_password'));

            return FALSE;
        }

        return TRUE;
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'wiwin7120ck5@gmail.com',
            'smtp_pass' => 'neg4r4Api3',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];

        $this->load->library('email', $config);
        $this->email->initialize($config);

        $this->email->from('wiwin7120ck5@gmail.com', 'Noreply Minning Login Test');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Acount Verification');
            $this->email->message('Click this link to verify your account: <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
        } elseif ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password: <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();;

            if ($user_token) {
                $time = time() - $user_token['date_create'];

                if ($time < (60 * 60 * 24)) {
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">' . $email . ' has been activated. Please login!</div>');
                    redirect('auth');
                } else {
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Token expired</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Token invalid</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Wrong email</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('purchase');
        $this->session->unset_userdata('cart');
        $this->session->unset_userdata('language');
        setcookie('pop', '0', 'filecoin.id', '/');
        setcookie('pop2', '0', 'filecoin.id', '/');

        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">'.$this->lang->line('success_logout').'</div>');
        redirect('auth');
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
            'required' => $this->lang->line('require_email'),
            'valid_email' => $this->lang->line('not_valid_email')
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $username = $this->input->post('username');
            $user = $this->M_user->get_user_byusername($username);

            if ($email != $user['email']) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('not_your_email').'</div>');
                redirect('auth/forgotPassword');
            } else {
                $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                $token = substr(str_shuffle($permitted_chars), 0, 6);
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_create' => time()
                ];
                $this->db->insert('user_token', $user_token);

                $token = $this->M_user->get_token_byemail($email);
                $email = $email;
                $subject = "=?UTF-8?B?".base64_encode($this->lang->line('reset_password'))."?=";
                $message  = $this->lang->line('message_reset_password').':<br/><br/> <a href="' . base_url() . 'auth/resetPassword?token=' . $token['token'] . '&id=' . $username . '">'.$this->lang->line('reset_password').'</a> ';
                $sendmail = array(
                    'recipient_email' => $email,
                    'subject' => $subject,
                    'content' => $message
                );
                $send = $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                if ($send == true) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('alert_check_email').'</div>');
                    redirect('auth/forgotPassword');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('cannot_send_email').'</div>');
                    redirect('auth/forgotPassword');
                }
            }
        }
    }

    public function resetPassword()
    {
        $username = $this->input->get('id');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['username' => $username])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_token', $token);
                $this->session->set_userdata('reset_username', $username);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('failed_reset_password_token').'</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('failed_reset_password_email').'</div>');
            redirect('auth');
        }
    }

    public function changePassword()
    {
        if (!$this->session->userdata('reset_token')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]', [
            'required' => $this->lang->line('failed_reset_password_email'),
            'min_length' => $this->lang->line('min_length_new_password')
        ]);
        $this->form_validation->set_rules('password2', 'Repeat Password', 'trim|required|matches[password1]', [
            'required' => $this->lang->line('require_repeat_password'),
            'matches' => $this->lang->line('matches_password')
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $username = $this->session->userdata('reset_username');

            $this->db->set('password', $password);
            $this->db->where('username', $username);
            $this->db->update('user');

            $this->session->unset_userdata('reset_token');
            $this->session->unset_userdata('reset_username');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('success_change_password').'</div>');
            redirect('auth');
        }
    }

    public function forgotOTP()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required', [
            'required' => $this->lang->line('require_username')
        ]);
        $this->form_validation->set_rules('email', 'Email', 'trim|required', [
            'required' => $this->lang->line('require_email')
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = $this->lang->line('forgot_otp');
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-otp');
            $this->load->view('templates/auth_footer');
        } else {
            $username = $this->input->post('username');
            $mail = $this->input->post('email');
            $user = $this->M_user->get_user_byusername($username);

            if ($mail != $user['email']) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('not_your_email').'</div>');
                redirect('auth/forgotOTP');
            } else {
                $email = $mail;
                $subject = "=?UTF-8?B?".base64_encode($this->lang->line('unactive_otp'))."?=";
                $message  = $this->lang->line('message_unactive_otp').':<br/><br/> <a href="' . base_url() . 'auth/unactiveOTP?email=' . $email . '&id=' . $username . '">'.$this->lang->line('unactive_otp').'</a> ';
                $sendmail = array(
                    'recipient_email' => $email,
                    'subject' => $subject,
                    'content' => $message
                );
                $send = $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                if ($send == true) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('alert_check_email').'</div>');
                    redirect('auth/forgotOTP');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('cannot_send_email').'</div>');
                    redirect('auth/forgotOTP');
                }
            }
        }
    }

    public function unactiveOTP()
    {
        $email = $this->input->get('email');
        $username = $this->input->get('id');

        $user = $this->db->get_where('user', ['username' => $username])->row_array();

        if ($user) {
            $data = [
                'email' => $user['email'],
                'role_id' => $user['role_id'],
                'purchase' => '0'
            ];
            $this->session->set_userdata($data);

            $this->db->set('is_otp', 0);
            $this->db->set('secret_otp', '');
            $this->db->where('username', $username);
            $update = $this->db->update('user');

            if ($update == true) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('success_unactive_otp').'</div>');
                redirect('user/google_otp');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('failed_unactive_otp').'</div>');
                redirect('auth/forgotOTP');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('failed_unactive_otp').'</div>');
            redirect('auth/forgotOTP');
        }
    }
    
    public function customer_service()
    {
        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email_cs'));

        $data['title']              = $this->lang->line('customer_service');
        $data['user']               = $query_user;
        $data['get_uniq']           = $this->M_user->getUniqMessage($this->session->userdata('email_cs'))->row_array();
        $data['message']            = $this->M_user->get_message($this->session->userdata('email_cs'), $data['get_uniq']['uniq_id'] ?? null)->result();
        $data['message_robot']      = $this->M_user->get_message_robot($this->session->userdata('email_cs'))->result();
        // $data['get_user']           = $this->M_user->get_user_by($query_user['id'])->row_array();

        if (isset($_POST['send'])) {
            $this->session->set_userdata('email_cs', $this->input->post('email'));

            $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            $uniq = substr(str_shuffle($permitted_chars), 0, 6);

            $uniq_id = $uniq;
            $name = $this->input->post('name');
            $email = $this->input->post('email');
            $phone = $this->input->post('phone');
            $message = $this->input->post('message');
            $time = time();
            $data = [
                'uniq_id' => $uniq_id,
                'name' => $name,
                'sender_email' => $email,
                'email' => $email,
                'phone' => $phone,
                'message' => $message,
                'image' => '',
                'time' => $time
            ];
            // var_dump($data);
            // die;
            $insert = $this->M_user->insert_data('user_messages', $data);
            if ($insert == true) {
                redirect('auth/customer_service');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('send_message_failed').'</div>');
                redirect('auth/customerservice');
            }
        }

        if (empty($_FILES['image']['name'])) {
            if (isset($_POST['submit'])) {
                $message = $this->input->post('message');
                $permitted_chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
                $uniq = substr(str_shuffle($permitted_chars), 0, 6);
                if ($data['get_uniq'] == NULL) {
                    $uniq_id = $uniq;
                } else {
                    $uniq_id = $data['get_uniq']['uniq_id'];
                }
                $data = [
                    'uniq_id' => $uniq_id,
                    'name' => $data['get_uniq']['name'],
                    'sender_email' => $data['get_uniq']['email'],
                    'email' => $data['get_uniq']['email'],
                    'phone' => $data['get_uniq']['phone'],
                    'message' => $message,
                    'image' => '',
                    'time' => time()
                ];
                $insert = $this->M_user->insert_data('user_messages', $data);
                if ($insert == true) {
                    redirect('auth/customer_service');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('send_message_failed').'</div>');
                    redirect('auth/customer_service');
                }
            }
        } else {
            if (isset($_POST['submit'])) { // Jika user menekan tombol Submit (Simpan) pada form
                // lakukan upload file dengan memanggil function upload yang ada di GambarModel.php
                $upload = $this->M_user->upload_photo_message();

                if ($upload['result'] == "success") { // Jika proses upload sukses
                    // Panggil function save yang ada di GambarModel.php untuk menyimpan data ke database
                    $data = array(
                        'uniq_id' => $data['get_uniq']['uniq_id'],
                        'name' => $data['get_uniq']['name'],
                        'sender_email' => $data['get_uniq']['sender_email'],
                        'email' => $data['get_uniq']['email'],
                        'phone' => $data['get_uniq']['phone'],
                        'message' => '',
                        'image' => $upload['file']['file_name'],
                        'time' => time()
                    );
                    $this->db->insert('user_messages', $data);

                    redirect('auth/customer_service'); // Redirect kembali ke halaman awal / halaman view data
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('upload_success').'</div>');
                } else { // Jika proses upload gagal
                    redirect('auth/customer_service'); // Redirect kembali ke halaman awal / halaman view data
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('upload_error').'</div>');
                }
            }
        }

        $this->load->view('templates/auth_header', $data);
        $this->load->view('auth/customer-service');
        $this->load->view('templates/auth_footer');
    }
}
