<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    private $arr = array();
    private $arrPointL = array();
    private $arrPointR = array();
    private $arrTodayL = array();
    private $arrTodayR = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('mailer');
        $this->load->library('GoogleAuthenticator');

        $this->load->model('M_user');
        $this->load->helper(array('form', 'url'));
    }
    
    public function month($m)
    {
        if($m == 'January')
        {
            $number = '01';
        }
        elseif($m == 'February')
        {
            $number = '02';
        }
        elseif($m == 'March')
        {
            $number = '03';
        }
        elseif($m == 'April')
        {
            $number = '04';
        }
        elseif($m == 'May')
        {
            $number = '05';
        }
        elseif($m == 'June')
        {
            $number = '06';
        }
        elseif($m == 'July')
        {
            $number = '07';
        }
        elseif($m == 'August')
        {
            $number = '08';
        }
        elseif($m == 'September')
        {
            $number = '09';
        }
        elseif($m == 'October')
        {
            $number = '10';
        }
        elseif($m == 'November')
        {
            $number = '11';
        }
        elseif($m == 'December')
        {
            $number = '12';
        }

        return $number;

    }

    public function payment()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Payment';

        $data['payment'] = $this->M_user->show_list_payment()->result();

        $data['adminClass'] = $this;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/payment', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function trxid($id)
    {
        $query = $this->M_user->get_trx_bycartid($id)->result();
        return $query;
    }

    public function confirmPayment()
    {
        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $data_id = $this->uri->segment(3);
            $updateDate = time();

            $dataUpdateStatus = [
                'is_payment ' => 1,
                'update_date' => $updateDate
            ];

            $updatePayment = $this->M_user->update_payment_withdate($dataUpdateStatus, $data_id);

            if ($updatePayment) {
                /**Bonus sponsor */
                $bonus = $this->_sponsorBonus($data_id);

                if ($bonus) {
                    $insertfm = $this->_insertFm($data_id);

                    if ($insertfm) {
                        $query_cart = $this->M_user->get_cart_useremail($data_id);
                        $link       = 'user/history';

                        $data_notif = [
                            'user_id' => $query_cart['user_id'],
                            'type' => '2',
                            'title' => 'Payment',
                            'message' => 'Your payment has been confirmed',
                            'link' => $link,
                            'datecreate' => time()
                        ];

                        $insert_notif = $this->M_user->insert_notif($data_notif);

                        require APPPATH . 'views/vendor/autoload.php';

                        $options = array(
                            'cluster' => 'ap1',
                            'useTLS' => true
                        );

                        $pusher = new Pusher\Pusher(
                            '375479f0c247cb7708d7',
                            'cd781cf54e1b067aa767',
                            '1243088',
                            $options
                        );

                        $message['message'] = $insert_notif;
                        $message['user']    = $query_cart['user_id'];
                        $message['email']   = $query_cart['email'];
                        $message['cart']    = $query_cart['id'];

                        $pusher->trigger('my-channel', 'my-event', $message);

                        $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                                                        Success. Payment confirmed.
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>');
                        redirect('admin/payment');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    Failed. FM failed to save.
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>');
                        redirect('admin/payment');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    Failed. Bonus sponsor failed to save.
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>');
                    redirect('admin/payment');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    Failed. Failed to confirm payment.
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>');
                redirect('admin/payment');
            }
        } else {
            redirect('auth');
        }
    }

    /**Add bonus sponsor */
    private function _sponsorBonus($id)
    {
        $check_bonus = $this->M_user->check_bonus_byid($id);

        if ($check_bonus) {
            return false;
        } else {
            $datapayment = $this->M_user->get_bonus_amount($id);

            if ($datapayment['fill'] != 0) {

                $count_bonus = ($datapayment['fill'] * $datapayment['amount_sp']) / 100;
                $query_basecamp = $this->M_user->get_camp_fm($datapayment['sponsor_id']);

                if ($datapayment['matching_id'] == 0) {
                    $count_sponsor = $count_bonus / 2;

                    //$wallet = $datapayment['fill'] - $count_bonus;

                    $data_insert = [
                        'cart_id' => $id,
                        'user_id' => $datapayment['sponsor_id'],
                        'code_bonus' => $datapayment['code'],
                        'filecoin' => $count_sponsor,
                        'mtm' => $count_sponsor,
                        'datecreate' => time()
                    ];

                    $insert = $this->M_user->insert_data('bonus', $data_insert);

                    if ($insert) {

                        if ($query_basecamp['is_camp'] == 1) {
                            if ($query_basecamp['fm'] == 'FM5') {
                                $additionalBonus = 1;
                            } elseif ($query_basecamp['fm'] == 'FM6') {
                                $additionalBonus = 1.25;
                            } elseif ($query_basecamp['fm'] == 'FM7') {
                                $additionalBonus = 1.5;
                            } elseif ($query_basecamp['fm'] == 'FM8') {
                                $additionalBonus = 1.75;
                            }

                            $count_bonus_basecamp = ($datapayment['fill'] * $additionalBonus) / 100;

                            $count_sponsor_basecamp = $count_bonus_basecamp / 2;

                            $data_insert_basecamp = [
                                'cart_id' => $id,
                                'user_id' => $datapayment['sponsor_id'],
                                'code_bonus' => $datapayment['code'],
                                'filecoin' => $count_sponsor_basecamp,
                                'mtm' => $count_sponsor_basecamp,
                                'type' => '1',
                                'datecreate' => time()
                            ];

                            $insert_basecamp = $this->M_user->insert_data('bonus_basecamp', $data_insert_basecamp);
                        }

                        // $data_wallet = [
                        //     'user_id' => $datapayment['user_id'],
                        //     'filecoin' => $wallet,
                        //     'datecreate' => time()
                        // ];

                        // $this->M_user->insert_data('wallet_office', $data_wallet);


                        return true;
                    } else {
                        return false;
                    }
                } else {
                    $count_sponsor_matching = (($count_bonus * $datapayment['amount_sm']) / 100) / 2;
                    $count_sponsor          = ($count_bonus) / 2;

                    //$wallet = $datapayment['fill'] - ($count_bonus + (2 * $count_sponsor_matching));

                    $data_insert = [
                        'cart_id' => $id,
                        'user_id' => $datapayment['sponsor_id'],
                        'code_bonus' => $datapayment['code'],
                        'filecoin' => $count_sponsor,
                        'mtm' => $count_sponsor,
                        'datecreate' => time()
                    ];

                    $insert = $this->M_user->insert_data('bonus', $data_insert);

                    if ($insert) {
                        $data_sm = [
                            'user_id' => $datapayment['matching_id'],
                            'cart_id' => $id,
                            'code_bonus' => $datapayment['code'],
                            'filecoin' => $count_sponsor_matching,
                            'mtm' => $count_sponsor_matching,
                            'datecreate' => time()
                        ];

                        // $data_wallet = [
                        //     'user_id' => $datapayment['user_id'],
                        //     'filecoin' => $wallet,
                        //     'datecreate' => time()
                        // ];

                        $insert_bonus_sm = $this->M_user->insert_data('bonus_sm', $data_sm);

                        if ($insert_bonus_sm) {
                            if ($query_basecamp['is_camp'] == 1) {
                                if ($query_basecamp['fm'] == 'FM5') {
                                    $additionalBonus = 1;
                                } elseif ($query_basecamp['fm'] == 'FM6') {
                                    $additionalBonus = 1.25;
                                } elseif ($query_basecamp['fm'] == 'FM7') {
                                    $additionalBonus = 1.5;
                                } elseif ($query_basecamp['fm'] == 'FM8') {
                                    $additionalBonus = 1.75;
                                }

                                $count_bonus_basecamp = ($datapayment['fill'] * $additionalBonus) / 100;

                                $count_sponsor_basecamp = $count_bonus_basecamp / 2;

                                $data_insert_basecamp = [
                                    'cart_id' => $id,
                                    'user_id' => $datapayment['sponsor_id'],
                                    'code_bonus' => $datapayment['code'],
                                    'filecoin' => $count_sponsor_basecamp,
                                    'mtm' => $count_sponsor_basecamp,
                                    'type' => '1',
                                    'datecreate' => time()
                                ];

                                $insert_basecamp = $this->M_user->insert_data('bonus_basecamp', $data_insert_basecamp);
                            }
                            return true;
                        }

                        //$this->M_user->insert_data('wallet_office', $data_wallet);

                    } else {
                        return false;
                    }
                }
            }
        }
    }

    private function _insertFm($id)
    {
        $data_user = $this->M_user->get_cart_byid($id);

        $data_insert = [
            'user_id' => $data_user['user_id'],
            'fm' => 'FM',
            'datecreate' => time()
        ];

        $insert = $this->M_user->insert_data('level_fm', $data_insert);

        if ($insert) {
            return true;
        }
    }

    public function wallet()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Wallet';

        $this->db->select('wallet_office.datecreate, user.username, wallet_office.filecoin');
        $this->db->from('wallet_office');
        $this->db->join('user', 'wallet_office.user_id = user.id');
        $this->db->order_by('wallet_office.datecreate', 'DESC');
        $data['wallet'] = $this->db->get()->result();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/wallet', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function saveNotePayment()
    {
        $this->form_validation->set_rules('note', 'Note', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Warning! can not send the note because it is empty.</div>');
            redirect('admin/payment');
        } else {
            $id         = $this->input->post('idcart');

            $data = [
                'note' => $this->input->post('note', true),
                'update_date' => time()
            ];

            $update = $this->M_user->update_data_byid('cart', $data, 'id', $id);

            if ($update) {
                $query_cart = $this->M_user->get_cart_useremail($id);
                $link       = 'user/payment/' . $query_cart['id'];

                $data_notif = [
                    'user_id' => $query_cart['user_id'],
                    'type' => '1',
                    'title' => 'Payment',
                    'message' => $this->input->post('note', true),
                    'link' => $link,
                    'datecreate' => time()
                ];

                $insert_notif = $this->M_user->insert_notif($data_notif);

                if ($insert_notif) {
                    require APPPATH . 'views/vendor/autoload.php';

                    $options = array(
                        'cluster' => 'ap1',
                        'useTLS' => true
                    );

                    $pusher = new Pusher\Pusher(
                        '375479f0c247cb7708d7',
                        'cd781cf54e1b067aa767',
                        '1243088',
                        $options
                    );

                    $message['message'] = $insert_notif;
                    $message['user']    = $query_cart['user_id'];
                    $message['email']   = $query_cart['email'];
                    $message['cart']    = $query_cart['id'];
                    $pusher->trigger('my-channel', 'my-event', $message);

                    $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Note has been sent.</div>');
                    redirect('admin/payment');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed! failed to send note.</div>');
                    redirect('admin/payment');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed! failed to send note.</div>');
                redirect('admin/payment');
            }
        }
    }

    //show lish notification
    public function listNotification()
    {
        $user_id = $this->input->post('item_user');;

        //show list notification
        $query_row_notif = $this->M_user->row_newnotif_byuser($user_id);
        $query_new_notif = $this->M_user->show_newnotif_byuser($user_id);
        $data2['list_notif'] = $query_new_notif;
        $data2['amount_notif'] = $query_row_notif;

        $this->load->view('user/notification', $data2);
    }

    //show modal notification
    public function modalNotification()
    {
        $query_user = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $id_notif   = $this->input->post('item_id');
        $cart_id    = $this->input->post('item_cart');

        //show single notification
        $query_notif = $this->M_user->show_notif_byuser($id_notif, $query_user['id']);
        $data['message']    = $query_notif['message'];
        $data['link']       = $query_notif['link'] . '/' . $id_notif;
        $data['type']       = $query_notif['type'];

        $this->load->view('user/modal/modal_notif', $data);
    }

    //show modal notification for basecamp
    public function modalNotificationBasecamp()
    {
        $query_user = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $id_notif   = $this->input->post('item_id');

        //show single notification
        $query_notif        = $this->M_user->show_notif_byuser($id_notif, $query_user['id']);
        $data['message']    = $query_notif['message'];
        $data['link']       = $query_notif['link'] . '/' . $id_notif;
        $data['type']       = $query_notif['type'];

        $this->load->view('user/modal/modal_notif_basecamp', $data);
    }

    public function modalNotificationDeposit()
    {
        $id_notif   = $this->input->post('item_id');
        $user_id    =  $this->input->post('item_user');

        //show single notification
        $query_notif        = $this->M_user->show_notif_byuser($id_notif, $user_id );
        
        $message    = $query_notif['message'] ?? null;
        $link       = $query_notif['link'] ?? null;
        $type       = $query_notif['type'] ?? null;
        
        $data['message']    = $message;
        $data['link']       = $link . '/' . $id_notif;
        $data['type']       = $type;

        $this->load->view('user/modal/modal_notif_deposit', $data);
    }

    public function modalNotificationWd()
    {
        $query_user = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $id_notif   = $this->input->post('item_id');

        //show single notification
        $query_notif        = $this->M_user->show_notif_byuser($id_notif, $query_user['id']);
        $data['message']    = $query_notif['message'];
        $data['link']       = $query_notif['link'] . '/' . $id_notif;
        $data['type']       = $query_notif['type'];

        $this->load->view('user/modal/modal_notif_wd', $data);
    }

    public function mining()
    {
        $data['title'] = 'Mining';
        $data['user']  = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['history'] = $this->M_user->get_data_order('mining', 'datecreate', 'DESC')->result();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            if ($this->uri->segment(3) == 1) {
                $this->form_validation->set_rules('miningfil', 'Amount', 'required|decimal');
            } elseif ($this->uri->segment(3) == 2) {
                $this->form_validation->set_rules('miningmtm', 'Amount', 'required|decimal');
            } elseif ($this->uri->segment(3) == 3) {
                $this->form_validation->set_rules('miningzenx', 'Amount', 'required|decimal');
            }

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/admin_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('admin/mining', $data);
                $this->load->view('templates/user_footer');
            } else {
                $dateNow = date('Y-m-d');

                if ($this->uri->segment(3) == 1) {
                    $check_data = $this->M_user->row_data_bydate_user('mining', 'datecreate', 'type', $dateNow, '1');

                    if ($check_data > 0) {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Warning! Mining Fil Amount today already exist</div>');
                        redirect('admin/mining');
                    } else {
                        $data = [
                            'amount' => $this->input->post('miningfil'),
                            'type' => 1,
                            'datecreate' => time()
                        ];

                        $insert = $this->M_user->insert_data('mining', $data);

                        if ($insert) {
                            $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Success! Mining Fil Amount has been save.</div>');
                            redirect('admin/mining');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed! Mining Fil Amount failed to save.</div>');
                            redirect('admin/mining');
                        }
                    }
                } elseif ($this->uri->segment(3) == 2) {
                    $check_data = $this->M_user->row_data_bydate_user('mining', 'datecreate', 'type', $dateNow, '2');

                    if ($check_data > 0) {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Warning! Airdrop MTM Amount today already exist</div>');
                        redirect('admin/mining');
                    } else {
                        $data = [
                            'amount' => $this->input->post('miningmtm'),
                            'type' => 2,
                            'datecreate' => time()
                        ];

                        $insert = $this->M_user->insert_data('mining', $data);

                        if ($insert) {
                            $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Success! Airdrop MTM has been save.</div>');
                            redirect('admin/mining');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed! Airdrop MTM failed to save.</div>');
                            redirect('admin/mining');
                        }
                    }
                } elseif ($this->uri->segment(3) == 3) {
                    $check_data = $this->M_user->row_data_bydate_user('mining', 'datecreate', 'type', $dateNow, '3');

                    if ($check_data > 0) {
                        $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Warning! Airdrop Zenx Amount today already exist</div>');
                        redirect('admin/mining');
                    } else {
                        $data = [
                            'amount' => $this->input->post('miningzenx'),
                            'type' => 3,
                            'datecreate' => time()
                        ];

                        $insert = $this->M_user->insert_data('mining', $data);

                        if ($insert) {
                            $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Success! Airdrop Zenx has been save.</div>');
                            redirect('admin/mining');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed! Airdrop Zenx failed to save.</div>');
                            redirect('admin/mining');
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function editmining($id)
    {
        $data = $this->M_user->get_data_byid('mining', 'id', $id);
        echo json_encode($data);
    }

    public function updatemining()
    {
        $this->_validate();

        $data = [
            'amount' => $this->input->post('mining-edit'),
            'update_date' => time()
        ];

        $this->M_user->update_mining(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }

    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('mining-edit') == '') {
            $data['inputerror'][] = 'mining-edit';
            $data['error_string'][] = 'Mining Amount is required';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }

    public function limitMining()
    {
        $date = date('Y-m-d');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Limit mining';

        $data['list_mining'] = $this->M_user->get_mining_user($date)->result();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/limit_mining', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function pauseMining()
    {
        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $data_id = $this->uri->segment(3);

            $dataUpdateStatus = [
                'pause_min ' => 1
            ];

            $update = $this->M_user->update_data_byid('cart', $dataUpdateStatus, 'id', $data_id);

            if ($update) {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    Success. Success to pause Mining.
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>');
                redirect('admin/limitMining');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    Failed. Failed to pause Mining.
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>');
                redirect('admin/limitMining');
            }
        } else {
            redirect('auth');
        }
    }

    public function continueMining()
    {
        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $data_id = $this->uri->segment(3);

            $dataUpdateStatus = [
                'pause_min ' => ''
            ];

            $update = $this->M_user->update_data_byid('cart', $dataUpdateStatus, 'id', $data_id);

            if ($update) {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                    Success. Success to continue Mining.
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>');
                redirect('admin/limitMining');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                Failed. Failed to continue Mining.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
                redirect('admin/limitMining');
            }
        } else {
            redirect('auth');
        }
    }

    public function message()
    {
        $date = date('Y-m-d');
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['message'] = $this->M_user->get_message_groupby()->result();
        $data['message_end'] = $this->M_user->get_message_end_groupby()->result();
        $data['title'] = 'Message';

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/message', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function reply_message($id)
    {
        $data['user']         = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['get']          = $this->db->get_where('user_messages', ['uniq_id' => $id])->row_array();
        $data['message']      = $this->M_user->get_message($data['get']['email'], $id)->result();
        $data['message_end']  = $this->M_user->get_message_end($data['get']['email'], $id)->result();
        $data['title']        = 'Message';

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/reply_message', $data);
            $this->load->view('templates/user_footer');

            if (isset($_POST['end_chat'])) {
                $id = $data['get']['uniq_id'];
                $this->db->set('is_end', 1);
                $this->db->where('uniq_id', $id);
                $end = $this->db->update('user_messages');

                // PHPMailer object
                $mail = $this->mailer->load();
                // SMTP configuration
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->Username = 'asia.ipfs@gmail.com'; // Email Pengirim
                $mail->Password = 'vssumbdrjgaxdvhd'; // Isikan dengan Password email pengirim
                $mail->Port = 465;
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'ssl';
                $mail->setFrom('asia.ipfs@gmail.com', 'asia.ipfs');
                // Add a recipient
                $mail->addAddress($data['message'][0]->email);
                // Email subject
                $mail->Subject = 'Regarding: Chat with ' . $data['message'][0]->name;
                // Set email format to HTML
                $mail->isHTML(true);
                // Email body content
                $mail->Body .= 'Chat started: ' . date('Y-m-d H:i a', $data['message'][0]->time) . '<br><br>';
                foreach ($data['message'] as $row_message) {
                    $mail->Body .= '(' . date('H:i a', $row_message->time) . ') ';
                    if ($data['user']['email'] != $row_message->sender_email) {
                        $mail->Body .= $row_message->name . ': ';
                    } else {
                        $mail->Body .= $data['user']['first_name'] . ': ';
                    }
                    $mail->Body .= $row_message->message . '<br>';
                };

                if ($end == true) {
                    if ($mail->send()) {
                        redirect('admin/message');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">failed to send message to email</div>');
                        redirect('admin/message');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">End Chat failed</div>');
                    redirect('admin/message');
                }
                $mail->clearAddresses();
                $mail->clearAttachments();
            }

            if (empty($_FILES['image']['name'])) {
                if (isset($_POST['submit'])) {
                    $message = $this->input->post('message');
                    $data = [
                        'uniq_id' => $data['get']['uniq_id'],
                        'name' => $data['user']['first_name'],
                        'sender_email' => $data['user']['email'],
                        'email' => $data['get']['sender_email'],
                        'phone' => $data['get']['phone'],
                        'message' => $message,
                        'time' => time()
                    ];
                    $insert = $this->M_user->insert_data('user_messages', $data);
                    if ($insert == true) {
                        redirect('admin/reply_message/' . $id);
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Send message failed</div>');
                        redirect('admin/reply_message/' . $id);
                    }
                }
            } else {
                if (isset($_POST['submit'])) { // Jika user menekan tombol Submit (Simpan) pada form
                    // lakukan upload file dengan memanggil function upload yang ada di GambarModel.php
                    $upload = $this->M_user->upload_photo_message();

                    if ($upload['result'] == "success") { // Jika proses upload sukses
                        // Panggil function save yang ada di GambarModel.php untuk menyimpan data ke database
                        $data = array(
                            'uniq_id' => $data['get']['uniq_id'],
                            'name' => $data['user']['first_name'],
                            'sender_email' => $data['user']['email'],
                            'email' => $data['get']['sender_email'],
                            'phone' => $data['get']['phone'],
                            'message' => '',
                            'image' => $upload['file']['file_name'],
                            'time' => time()
                        );
                        $this->db->insert('user_messages', $data);

                        redirect('admin/reply_message/' . $id); // Redirect kembali ke halaman awal / halaman view data
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Upload Success</div>');
                    } else { // Jika proses upload gagal
                        redirect('admin/reply_message/' . $id); // Redirect kembali ke halaman awal / halaman view data
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Upload Error</div>');
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function packagePurchase()
    {
        $data['user']   = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title']  = 'Bonus Global';

        $data['purchase'] = $this->M_user->get_purchase_admin()->result();
        $data['user_fm4'] = $this->M_user->get_user_level('FM4')->result();
        $data['user_fm5'] = $this->M_user->get_user_level('FM5')->result();
        $data['user_fm6'] = $this->M_user->get_user_level('FM6')->result();
        $data['user_fm7'] = $this->M_user->get_user_level('FM7')->result();
        $data['user_fm8'] = $this->M_user->get_user_level('FM8')->result();
        $data['user_fm9'] = $this->M_user->get_user_level('FM9')->result();
        $data['user_fm10'] = $this->M_user->get_user_level('FM10')->result();
        $data['fm4']      = $this->M_user->row_data_byuser('level_fm', 'fm', 'FM4');
        $data['fm5']      = $this->M_user->row_data_byuser('level_fm', 'fm', 'FM5');
        $data['fm6']      = $this->M_user->row_data_byuser('level_fm', 'fm', 'FM6');
        $data['fm7']      = $this->M_user->row_data_byuser('level_fm', 'fm', 'FM7');
        $data['fm8']      = $this->M_user->row_data_byuser('level_fm', 'fm', 'FM8');
        $data['fm9']      = $this->M_user->row_data_byuser('level_fm', 'fm', 'FM9');
        $data['fm10']      = $this->M_user->row_data_byuser('level_fm', 'fm', 'FM10');

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/package_purchase', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function detailMonth($year, $month)
    {
        $data['user']   = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title']  = 'Bonus Global Detail';

        if ($month == 1) {
            $monthNow = 'January';
            $date = $year . '-01';
        } elseif ($month == 2) {
            $monthNow = 'February';
            $date = $year . '-02';
        } elseif ($month == 3) {
            $monthNow = 'March';
            $date = $year . '-03';
        } elseif ($month == 4) {
            $monthNow = 'April';
            $date = $year . '-04';
        } elseif ($month == 5) {
            $monthNow = 'May';
            $date = $year . '-05';
        } elseif ($month == 6) {
            $monthNow = 'June';
            $date = $year . '-06';
        } elseif ($month == 7) {
            $monthNow = 'July';
            $date = $year . '-07';
        } elseif ($month == 8) {
            $monthNow = 'August';
            $date = $year . '-08';
        } elseif ($month == 9) {
            $monthNow = 'September';
            $date = $year . '-09';
        } elseif ($month == 10) {
            $monthNow = 'October';
            $date = $year . '-10';
        } elseif ($month == 11) {
            $monthNow = 'November';
            $date = $year . '-11';
        } elseif ($month == 12) {
            $monthNow = 'Desember';
            $date = $year . '-12';
        }

        if ($date == date('Y-m')) {
            $dateLimit = $date.'-15';

            $query_fm4 = $this->M_user->count_fm_bymonth_now($dateLimit, 'FM4');
            $query_fm5 = $this->M_user->count_fm_bymonth_now($dateLimit, 'FM5');
            $query_fm6 = $this->M_user->count_fm_bymonth_now($dateLimit, 'FM6');
            $query_fm7 = $this->M_user->count_fm_bymonth_now($dateLimit, 'FM7');
            $query_fm8 = $this->M_user->count_fm_bymonth_now($dateLimit, 'FM8');
            $query_fm9 = $this->M_user->count_fm_bymonth_now($dateLimit, 'FM9');
            $query_fm10 = $this->M_user->count_fm_bymonth_now($dateLimit, 'FM10');

            $amount_fm4 = $query_fm4+$query_fm5+$query_fm6+$query_fm7+$query_fm8+$query_fm9+$query_fm10;
            $amount_fm5 = $query_fm5+$query_fm6+$query_fm7+$query_fm8+$query_fm9+$query_fm10;
            $amount_fm6 = $query_fm6+$query_fm7+$query_fm8+$query_fm9+$query_fm10;
            $amount_fm7 = $query_fm7+$query_fm8+$query_fm9+$query_fm10;
            $amount_fm8 = $query_fm8+$query_fm9+$query_fm10;
            $amount_fm9 = $query_fm9+$query_fm10;
            $amount_fm10 = $query_fm10;

            $data['fm4']  = $amount_fm4;
            $data['fm5']  = $amount_fm5;
            $data['fm6']  = $amount_fm6;
            $data['fm7']  = $amount_fm7;
            $data['fm8']  = $amount_fm8;
            $data['fm9']  = $amount_fm9;
            $data['fm10'] = $amount_fm10;
        } else {
            // $dateNew = new DateTime($date);
            // $dateNew->modify('1 month');
            // $dateMonth = $dateNew->format('Y-m');

            $fm4Global    = $this->M_user->get_level_month('FM4', $date)['total'];
            $fm4Excess    = $this->M_user->get_level_month2('FM4', $date)['total'];
            
            $fm5Global    = $this->M_user->get_level_month('FM5', $date)['total'];
            $fm5Excess    = $this->M_user->get_level_month2('FM5', $date)['total'];
            
            $fm6Global    = $this->M_user->get_level_month('FM6', $date)['total'];
            $fm6Excess    = $this->M_user->get_level_month2('FM6', $date)['total'];
            
            $fm7Global    = $this->M_user->get_level_month('FM7', $date)['total'];
            $fm7Excess    = $this->M_user->get_level_month2('FM7', $date)['total'];
            
            $fm8Global    = $this->M_user->get_level_month('FM8', $date)['total'];
            $fm8Excess    = $this->M_user->get_level_month2('FM8', $date)['total'];
            
            $fm9Global    = $this->M_user->get_level_month('FM9', $date)['total'];
            $fm9Excess    = $this->M_user->get_level_month2('FM9', $date)['total'];
            
            $fm10Global   = $this->M_user->get_level_month('FM10', $date)['total'];
            $fm10Excess   = $this->M_user->get_level_month2('FM10', $date)['total'];

            $data['fm4']  = $fm4Global + $fm4Excess;
            $data['fm5']  = $fm5Global + $fm5Excess;
            $data['fm6']  = $fm6Global + $fm6Excess;
            $data['fm7']  = $fm7Global + $fm7Excess;
            $data['fm8']  = $fm8Global + $fm8Excess;
            $data['fm9']  = $fm9Global + $fm9Excess;
            $data['fm10'] = $fm10Global + $fm10Excess;
        }


        $data['purchase']      = $this->M_user->get_purchase_admin()->result();
        $data['list_purchase'] = $this->M_user->get_listpurchase_admin($date)->result();
        $data['monthName']     = $monthNow;
        $data['date']          = $date;
        $data['controller']    = $this;

        $query_fil_price        = $this->M_user->get_fil_price();
        $data['price_usdt']      = $query_fil_price['usdt'];
        $data['price_krp']       = $query_fil_price['krp'];

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/detail_purchase', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    

    /**Count total omset network position L */
    public function countPositionL($userid)
    {
        $query = $this->M_user->check_line($userid, 'A');
        $user_id = $query['user_id'] ?? null;
        $user_position = $query['user_id'] ?? null;

        $query_package = $this->M_user->get_point_byuserid($user_id)->row_array();
        $package_poin = $query_package['point'] ?? null;

        $countMember = $this->get_countPointL($user_position);

        $sumTotal = array_sum($countMember) + $package_poin;
        $this->arrPointL = array();

        return $sumTotal;
    }

    public function get_countPointL($id)
    {
        $query = $this->M_user->get_totalpoin_byposition($id);

        foreach ($query->result() as $row) {
            array_push($this->arrPointL, $row->point);

            $this->get_countPointL($row->user_id);
        }

        return $this->arrPointL;
    }

    /**Count total omset network position R */
    public function countPositionR($userid)
    {
        $query = $this->M_user->check_line($userid, 'B');
        $user_id = $query['user_id'] ?? null;
        $user_position = $query['user_id'] ?? null;

        $query_package = $this->M_user->get_point_byuserid($user_id)->row_array();
        $package_poin = $query_package['point'] ?? null;

        $countMember = $this->get_countPointR($user_position);

        $sumTotal = array_sum($countMember) + $package_poin;
        $this->arrPointR = array();

        return $sumTotal;
    }

    public function get_countPointR($id)
    {
        $query = $this->M_user->get_totalpoin_byposition($id);

        foreach ($query->result() as $row) {
            array_push($this->arrPointR, $row->point);

            $this->get_countPointR($row->user_id);
        }

        return $this->arrPointR;
    }

    /**Show Basecamp page */
    public function basecamp()
    {
        $data['user']   = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title']  = 'Basecamp';

        $data['basecamp']   = $this->M_user->get_basecamp_leader();
        $data['list']       = $this->M_user->get_user_basecamp()->result();
        $data['controller'] = $this;

        $query_history = $this->M_user->get_history_bonus_basecamp();

        $data['history'] = $query_history;

        $this->form_validation->set_rules('basecampname', 'Basecamp Name', 'required|is_unique[basecamp_name.name]');
        $this->form_validation->set_rules('usercamp', 'User', 'required');

        if($this->form_validation->run() == false)
        {
            if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/admin_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('admin/basecamp', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
        }
        else
        {
            $basename = htmlspecialchars($this->input->post('basecampname'), true);
            $user     = htmlspecialchars($this->input->post('usercamp'), true);

            $data_name = [
                'name' => $basename,
                'datecreate' => time()
            ];

            $id_basecamp = $this->M_user->last_id('basecamp_name', $data_name);

            $data_leader = [
                'id_bs' => $id_basecamp,
                'user_id' => $user,
                'datecreate' => time()
            ];

            $insert_leader = $this->M_user->insert_data('basecamp_leader', $data_leader);

            if($insert_leader)
            {
                $data_user = [
                    'id_basecamp' => $id_basecamp,
                    'basecamp' => $basename
                ];

                $update = $this->M_user->update_data_byid('user', $data_user, 'id', $user);

                if($update)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                                                    Basecamp name successfully added.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

                    redirect('admin/basecamp');
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    Failed add basecamp!
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

                    redirect('admin/basecamp');
                }
            }
            else
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    Sorry, something wrong!
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

                    redirect('admin/basecamp');
            }
        }
    }
    
    public function confirmBasecamp()
    {
        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') 
        {
            $id_user          = $this->input->post('user');
            $id_basecamp      = $this->input->post('idbasecamp');

            $dataUpdate = [
                'is_camp' => 1
            ];

            $dataBasecamp = [
                'user_id' => $id_user
            ];

            $update        = $this->M_user->update_data_byid("user", $dataUpdate, "id", $id_user);
            $update_leader = $this->M_user->update_data_byid("basecamp_leader", $dataBasecamp, "id_bs", $id_basecamp);

            $query_cart = $this->M_user->get_user_byid($id_user);
            $link       = "user/index";

            if ($update) {
                $data_notif = [
                    'user_id' => $id_user,
                    'type' => '4',
                    'title' => 'Basecamp',
                    'message' => 'Congratulation, you were selected as basecamp',
                    'link' => $link,
                    'datecreate' => time()
                ];

                $insert_notif = $this->M_user->insert_notif($data_notif);

                require APPPATH . 'views/vendor/autoload.php';

                $options = array(
                    'cluster' => 'ap1',
                    'useTLS' => true
                );

                $pusher = new Pusher\Pusher(
                    '375479f0c247cb7708d7',
                    'cd781cf54e1b067aa767',
                    '1243088',
                    $options
                );

                $message['message'] = $insert_notif;
                $message['user']    = $data_id;
                $message['email']   = $query_cart['email'];

                $pusher->trigger('channel-basecamp', 'event-basecamp', $message);

                $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                                                Success. Basecamp confirmed.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

                redirect('admin/basecamp');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    Failed. Failed confirm basecamp.
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>');
                redirect('admin/basecamp');
            }
        }
    }
    
    public function detailLevelPerMonth()
    {
        $data['user']   = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title']  = 'Detail Level Per Month';

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') 
        {
            $level = $this->uri->segment(3);
            $date = $this->uri->segment(4);
    
            $dateNow = date('Y-m');
    
            if($date == $dateNow)
            {
                $dateLimit = $dateNow.'-15';

                if($level == 'FM4')
                {
                    $level_array = array('FM4', 'FM5', 'FM6', 'FM7', 'FM8', 'FM9', 'FM10');
                }
                elseif($level == 'FM5')
                {
                    $level_array = array('FM5', 'FM6', 'FM7', 'FM8', 'FM9', 'FM10');
                }
                elseif($level == 'FM6')
                {
                    $level_array = array('FM6', 'FM7', 'FM8', 'FM9', 'FM10');
                }
                elseif($level == 'FM7')
                {
                    $level_array = array('FM7', 'FM8', 'FM9', 'FM10');
                }
                elseif($level == 'FM8')
                {
                    $level_array = array('FM8', 'FM9', 'FM10');
                }
                elseif($level == 'FM9')
                {
                    $level_array = array('FM9', 'FM10');
                }
                elseif($level == 'FM10')
                {
                    $level_array = array('FM10');
                }

                $query_detail = $this->M_user->get_level_byfm_monthnow($dateLimit, $level_array);
                
                $data['detail'] = $query_detail;
                $data['excess'] = '';
            }
            else
            {
                $query_detail = $this->M_user->get_global_fm_bymonth($date, $level);
                $query_excess = $this->M_user->get_excessglobal_fm_bymonth($date, $level);
                $data['detail'] = $query_detail;
                $data['excess'] = $query_excess;
    
            }
            
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/detail_level_bymonth', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }

    }

    public function cancelBasecamp()
    {
        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $data_id = $this->uri->segment(3);

            $dataUpdate = [
                'is_camp' => 0
            ];

            $update     = $this->M_user->update_data_byid("user", $dataUpdate, "id", $data_id);
            $query_cart = $this->M_user->get_user_byid($data_id);
            $link       = "user/index";

            if ($update) {
                $data_notif = [
                    'user_id' => $data_id,
                    'type' => '5',
                    'title' => 'Basecamp',
                    'message' => 'Sorry, you have been canceled as basecamp',
                    'link' => $link,
                    'datecreate' => time()
                ];

                $insert_notif = $this->M_user->insert_notif($data_notif);

                require APPPATH . 'views/vendor/autoload.php';

                $options = array(
                    'cluster' => 'ap1',
                    'useTLS' => true
                );

                $pusher = new Pusher\Pusher(
                    '375479f0c247cb7708d7',
                    'cd781cf54e1b067aa767',
                    '1243088',
                    $options
                );

                $message['message'] = $insert_notif;
                $message['user']    = $data_id;
                $message['email']   = $query_cart['email'];

                $pusher->trigger('channel-basecamp', 'event-basecamp', $message);

                $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                                                Success. Basecamp canceled.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');

                redirect('admin/basecamp');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    Failed. Failed to cancel basecamp.
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>');
                redirect('admin/basecamp');
            }
        }
    }

    public function withdrawal()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['withdrawal_filecoin'] = $this->M_user->get_withdrawal('filecoin')->result();
        $data['withdrawal_mtm'] = $this->M_user->get_withdrawal('mtm')->result();
        $data['withdrawal_zenx'] = $this->M_user->get_withdrawal('zenx')->result();
        $data['title'] = 'Withdrawal';

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/withdrawal', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function withdrawalSendTXID()
    {
        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            if ($this->input->post('submit')) {
                $txid = $this->input->post('txid');
                $id = $this->input->post('id');
                $username = $this->input->post('username');

                $this->db->set('txid', $txid);
                $this->db->where('id', $id);
                $update = $this->db->update('withdrawal');

                if ($update == true) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully sent txid to user ' . $username . '</div>');
                    redirect('admin/withdrawal');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Failed to send txid</div>');
                    redirect('admin/withdrawal');
                }
            }
        }
    }

    public function deposit()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title'] = 'Deposit';

        $data['wallet_address'] = $this->M_user->walletAddress()->row_array();
        $data['deposit'] = $this->M_user->get_deposit();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/deposit', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function editWalletAddress()
    {
        if (isset($_POST['save_fil'])) {
            $wallet = $this->input->post('wallet_fil');
            $this->db->set('filecoin', $wallet);
            $update = $this->db->update('wallet_address');
            if ($update == true) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Update Wallet FIL success</div>');
                redirect('admin/deposit');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Update Wallet FIL failed</div>');
                redirect('admin/deposit');
            }
        } elseif (isset($_POST['save_usdt'])) {
            $wallet = $this->input->post('wallet_usdt');
            $this->db->set('usdt', $wallet);
            $update = $this->db->update('wallet_address');
            if ($update == true) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Update Wallet USDT success</div>');
                redirect('admin/deposit');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Update Wallet USDT failed</div>');
                redirect('admin/deposit');
            }
        } elseif (isset($_POST['save_krp'])) {
            $wallet = $this->input->post('wallet_krp');
            $this->db->set('krp', $wallet);
            $update = $this->db->update('wallet_address');
            if ($update == true) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Update Wallet KRP success</div>');
                redirect('admin/deposit');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Update Wallet KRP failed</div>');
                redirect('admin/deposit');
            }
        }
    }

    public function editDeposit()
    {
        $id = $this->input->post('id_deposit');
        $type_coin = $this->input->post('type_coin');
        $quantity =  $this->input->post('coin');
        $this->db->set('type_coin', $type_coin);
        $this->db->set('coin', $quantity);
        $this->db->where('id', $id);
        $update = $this->db->update('deposit');

        if ($update == true) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Edit Deposit Success</div>');
            redirect('admin/deposit');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Edit Deposit Failed</div>');
            redirect('admin/deposit');
        }
    }

    public function deleteDeposit()
    {
        $id = $this->input->post('id_deposit');

        $this->db->where('id', $id);
        $del = $this->db->delete('deposit');

        if ($del == true) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Delete Deposit Success</div>');
            redirect('admin/deposit');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Delete Deposit Failed</div>');
            redirect('admin/deposit');
        }
    }

    public function saveNoteDeposit()
    {
        $this->form_validation->set_rules('note', 'Note', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Warning! can not send the note because it is empty.</div>');
            redirect('admin/deposit');
        } else {
            $id   = $this->input->post('id_deposit');

            $data = [
                'note' => $this->input->post('note', true),
                'update_date' => time()
            ];

            $update = $this->M_user->update_data_byid('deposit', $data, 'id', $id);

            if ($update) {
                $query_deposit = $this->M_user->get_deposit_byid($id);
                $link          = 'user/deposit/' . $query_deposit['type_coin'] . '/' . $query_deposit['id'];

                $data_notif = [
                    'user_id' => $query_deposit['user_id'],
                    'type' => '1',
                    'title' => 'Deposit',
                    'message' => $this->input->post('note', true),
                    'link' => $link,
                    'datecreate' => time()
                ];

                $insert_notif = $this->M_user->insert_notif($data_notif);

                if ($insert_notif) {
                    require APPPATH . 'views/vendor/autoload.php';

                    $options = array(
                        'cluster' => 'ap1',
                        'useTLS' => true
                    );

                    $pusher = new Pusher\Pusher(
                        '375479f0c247cb7708d7',
                        'cd781cf54e1b067aa767',
                        '1243088',
                        $options
                    );

                    $message['message']     = $insert_notif;
                    $message['user']        = $query_deposit['user_id'];
                    $message['email']       = $query_deposit['email'];
                    $message['deposit']     = $query_deposit['id'];
                    $pusher->trigger('channel-deposit', 'event-deposit', $message);

                    $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Note has been sent.</div>');
                    redirect('admin/deposit');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed! failed to send note.</div>');
                    redirect('admin/deposit');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed! failed to send note.</div>');
                redirect('admin/deposit');
            }
        }
    }

    public function saveNoteWithdrawal()
    {
        $this->form_validation->set_rules('note', 'Note', 'required');

        if ($this->form_validation->run() == false) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Warning! can not send the note because it is empty.</div>');
            redirect('admin/withdrawal');
        } else {
            $id   = $this->input->post('id_wd');

            $data = [
                'note' => $this->input->post('note', true),
                'update_date' => time()
            ];

            $update = $this->M_user->update_data_byid('withdrawal', $data, 'id', $id);

            if ($update) {
                $query_wd = $this->M_user->get_withdrawal_byid($id);

                $coin_type = $query_wd['coin_type'];

                if ($coin_type == 'filecoin') {
                    $link          = 'user/withdrawal_fil';
                } elseif ($coin_type == 'mtm') {
                    $link          = 'user/withdrawal_mtm';
                } elseif ($coin_type == 'zenx') {
                    $link          = 'user/withdrawal_zenx';
                }

                $data_notif = [
                    'user_id' => $query_wd['user_id'],
                    'type' => '6',
                    'title' => 'Withdrawal',
                    'message' => $this->input->post('note', true),
                    'link' => $link . '/' . $id,
                    'datecreate' => time()
                ];

                $insert_notif = $this->M_user->insert_notif($data_notif);

                if ($insert_notif) {
                    require APPPATH . 'views/vendor/autoload.php';

                    $options = array(
                        'cluster' => 'ap1',
                        'useTLS' => true
                    );

                    $pusher = new Pusher\Pusher(
                        '375479f0c247cb7708d7',
                        'cd781cf54e1b067aa767',
                        '1243088',
                        $options
                    );

                    $message['message']     = $insert_notif;
                    $message['user']        = $query_wd['user_id'];
                    $message['email']       = $query_wd['email'];
                    $message['wd']          = $query_wd['id'];
                    $pusher->trigger('channel-wd', 'event-wd', $message);

                    $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Note has been sent.</div>');
                    redirect('admin/withdrawal');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed! failed to send note.</div>');
                    redirect('admin/withdrawal');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed! failed to send note.</div>');
                redirect('admin/withdrawal');
            }
        }
    }

    public function confirmDeposit()
    {
        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $data_id = $this->uri->segment(3);
            $updateDate = time();

            $dataUpdateStatus = [
                'is_confirm ' => 1,
                'update_date' => $updateDate
            ];

            $updateDeposit = $this->M_user->update_deposit_withdate($dataUpdateStatus, $data_id);

            if ($updateDeposit) {
                $query_deposit = $this->M_user->get_deposit_byid($data_id);
                $link       = 'user/index';

                $data_notif = [
                    'user_id' => $query_deposit['user_id'],
                    'type' => '2',
                    'title' => 'Deposit',
                    'message' => 'Your deposit has been confirmed',
                    'link' => $link,
                    'datecreate' => time()
                ];

                $insert_notif = $this->M_user->insert_notif($data_notif);

                require APPPATH . 'views/vendor/autoload.php';

                $options = array(
                    'cluster' => 'ap1',
                    'useTLS' => true
                );

                $pusher = new Pusher\Pusher(
                    '375479f0c247cb7708d7',
                    'cd781cf54e1b067aa767',
                    '1243088',
                    $options
                );

                $message['message'] = $insert_notif;
                $message['user']    = $query_deposit['user_id'];
                $message['email']   = $query_deposit['email'];

                $pusher->trigger('channel-confirm-deposit', 'event-confirm-deposit', $message);

                $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                                                Success. Deposit confirmed.
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>');
                redirect('admin/deposit');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                    Failed. Failed to confirm deposit.
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>');
                redirect('admin/deposit');
            }
        } else {
            redirect('auth');
        }
    }

    public function iklanHome()
    {
        $data['title'] = 'Iklan Home';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['banner1'] = $this->M_user->get_banner_home(1);
        $data['banner2'] = $this->M_user->get_banner_home(2);

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/banner-home', $data);
            $this->load->view('templates/user_footer');

            if (isset($_POST['submit_1'])) { // Jika user menekan tombol Submit (Simpan) pada form
                // lakukan upload file dengan memanggil function upload yang ada di GambarModel.php
                $upload = $this->M_user->upload_banner_home();

                if ($upload['result'] == "success") { // Jika proses upload sukses
                    // Panggil function save yang ada di GambarModel.php untuk menyimpan data ke database
                    $data = array(
                        'type'       => 1,
                        'image'      => $upload['file']['file_name']
                    );
                    $this->db->insert('banner_home', $data);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Upload Success</div>');
                    redirect('admin/iklanHome'); // Redirect kembali ke halaman awal / halaman view data
                } else { // Jika proses upload gagal
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Upload Failed</div>');
                    redirect('admin/iklanHome'); // Redirect kembali ke halaman awal / halaman view data
                }
            } else if (isset($_POST['submit_2'])) {
                $upload = $this->M_user->upload_banner_home();

                if ($upload['result'] == "success") { // Jika proses upload sukses
                    // Panggil function save yang ada di GambarModel.php untuk menyimpan data ke database
                    $data = array(
                        'type'       => 2,
                        'image'      => $upload['file']['file_name']
                    );
                    $this->db->insert('banner_home', $data);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Upload Success</div>');
                    redirect('admin/iklanHome'); // Redirect kembali ke halaman awal / halaman view data
                } else { // Jika proses upload gagal
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Upload Failed</div>');
                    redirect('admin/iklanHome'); // Redirect kembali ke halaman awal / halaman view data
                }
            }
        } else {
            redirect('auth');
        }
    }
    public function deleteIklanHome()
    {
        $id = $this->input->post('id_banner');
        $old = $this->input->post('image');

        $this->db->where('id', $id);
        $del = $this->db->delete('banner_home');

        unlink('./assets/photo/banner/' . $old);

        if ($del == true) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Delete Success</div>');
            redirect('admin/iklanHome');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Delete Failed</div>');
            redirect('admin/iklanHome');
        }
    }
    public function marketPrice()
    {
        $data['title'] = 'Price Coin';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['price_coin'] = $this->M_user->get_price_coin()->result();
        $data['min_withdrawal'] = $this->M_user->minimum_withdrawal();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/market_price', $data);
            $this->load->view('templates/user_footer');

            // price coin
            if (isset($_POST['submit'])) {
                $filecoin = $this->input->post('filecoin');
                $mtm = $filecoin / 4;
                $zenx = $this->input->post('zenx');

                $data = array(
                    'filecoin' => $filecoin,
                    'mtm' => $mtm,
                    'zenx' => $zenx,
                    'time' => time()
                );
                $insert = $this->db->insert('market_price', $data);
                if ($insert == true) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Successfully updated</div>');
                    redirect('admin/marketPrice');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Update Failed</div>');
                    redirect('admin/marketPrice');
                }
            }

            // minimum WD
            if (isset($_POST['save_fil'])) {
                $min_wd = $this->input->post('filecoin_min');
                $this->db->set('filecoin', $min_wd);
                $update = $this->db->update('minimum_withdrawal');
                if ($update == true) {
                    $this->session->set_flashdata('message_min_wd', '<div class="alert alert-success" role="alert">Update minimum WD FIL success</div>');
                    redirect('admin/marketPrice');
                } else {
                    $this->session->set_flashdata('message_min_wd', '<div class="alert alert-danger" role="alert">Update minimum WD FIL failed</div>');
                    redirect('admin/marketPrice');
                }
            } elseif (isset($_POST['save_mtm'])) {
                $min_wd = $this->input->post('mtm_min');
                $this->db->set('mtm', $min_wd);
                $update = $this->db->update('minimum_withdrawal');
                if ($update == true) {
                    $this->session->set_flashdata('message_min_wd', '<div class="alert alert-success" role="alert">Update minimum WD MTM success</div>');
                    redirect('admin/marketPrice');
                } else {
                    $this->session->set_flashdata('message_min_wd', '<div class="alert alert-danger" role="alert">Update minimum WD MTM failed</div>');
                    redirect('admin/marketPrice');
                }
            } elseif (isset($_POST['save_zenx'])) {
                $min_wd = $this->input->post('zenx_min');
                $this->db->set('zenx', $min_wd);
                $update = $this->db->update('minimum_withdrawal');
                if ($update == true) {
                    $this->session->set_flashdata('message_min_wd', '<div class="alert alert-success" role="alert">Update minimum WD ZENX success</div>');
                    redirect('admin/marketPrice');
                } else {
                    $this->session->set_flashdata('message_min_wd', '<div class="alert alert-danger" role="alert">Update minimum WD ZENX failed</div>');
                    redirect('admin/marketPrice');
                }
            }

            // fee WD
            if (isset($_POST['save_filecoin_fee'])) {
                $fee_wd = $this->input->post('filecoin_fee');
                $this->db->set('fee_filecoin', $fee_wd);
                $update = $this->db->update('minimum_withdrawal');
                if ($update == true) {
                    $this->session->set_flashdata('message_fee_wd', '<div class="alert alert-success" role="alert">Update fee WD FIL success</div>');
                    redirect('admin/marketPrice');
                } else {
                    $this->session->set_flashdata('message_fee_wd', '<div class="alert alert-danger" role="alert">Update fee WD FIL failed</div>');
                    redirect('admin/marketPrice');
                }
            } elseif (isset($_POST['save_mtm_fee'])) {
                $fee_wd = $this->input->post('mtm_fee');
                $this->db->set('fee_mtm', $fee_wd);
                $update = $this->db->update('minimum_withdrawal');
                if ($update == true) {
                    $this->session->set_flashdata('message_fee_wd', '<div class="alert alert-success" role="alert">Update fee WD MTM success</div>');
                    redirect('admin/marketPrice');
                } else {
                    $this->session->set_flashdata('message_fee_wd', '<div class="alert alert-danger" role="alert">Update fee WD MTM failed</div>');
                    redirect('admin/marketPrice');
                }
            } elseif (isset($_POST['save_zenx_fee'])) {
                $fee_wd = $this->input->post('zenx_fee');
                $this->db->set('fee_zenx', $fee_wd);
                $update = $this->db->update('minimum_withdrawal');
                if ($update == true) {
                    $this->session->set_flashdata('message_fee_wd', '<div class="alert alert-success" role="alert">Update fee WD ZENX success</div>');
                    redirect('admin/marketPrice');
                } else {
                    $this->session->set_flashdata('message_fee_wd', '<div class="alert alert-danger" role="alert">Update fee WD ZENX failed</div>');
                    redirect('admin/marketPrice');
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function allUsers()
    {
        $data['title'] = 'All Users';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['all_user'] = $this->M_user->get_users_admin()->result();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/all_user', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    
    public function userDetail($id)
    {
        $query_user                = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_total               = $this->M_user->get_total_bonus($id)->row_array();
        $query_total_fill          = $this->M_user->get_total_byuser('mining_user', 'amount', 'user_id', $id);
        $query_total_mtm           = $this->M_user->get_total_byuser('airdrop_mtm', 'amount', 'user_id', $id);

        $query_transfer_fill       = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $id);
        $query_transfer_mtm        = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $id);
        $query_transfer_bonus_fill = $this->M_user->get_transfer_bonus($id, 'filecoin');
        $query_transfer_bonus_mtm  = $this->M_user->get_transfer_bonus($id, 'mtm');

        $query_withdrawal_fil      = $this->M_user->get_total_withdrawal($id, 'filecoin');
        $query_withdrawal_mtm      = $this->M_user->get_total_withdrawal($id, 'mtm');
        $query_withdrawal_zenx     = $this->M_user->get_total_withdrawal($id, 'zenx');

        $query_total_purchase      = $this->M_user->sum_cart_byid($id);

        $query_deposit_fil         = $this->M_user->get_sum_deposit($id, '1');
        $query_deposit_mtm         = $this->M_user->get_sum_deposit($id, '2');
        $query_deposit_zenx        = $this->M_user->get_sum_deposit($id, '3');

        $data['title'] = 'All Users';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['detail'] = $this->M_user->get_detail_user($id)->row_array();
        $data['camp'] = $this->M_user->get_all_basecampname();

        $total_sponsorfil = $query_total['sponsorfil'] ?? null;
        $total_sponmatchingfil = $query_total['sponmatchingfil'] ?? null;
        $total_minmatchingfil = $query_total['minmatching'] ?? null;
        $total_minpairingfil = $query_total['minpairing'] ?? null;

        $total_sponsormtm = $query_total['sponsormtm'] ?? null;
        $total_sponmatchingmtm = $query_total['sponmatchingmtm'] ?? null;
        $total_pairingmatch_mtm = $query_total['pairingmatch'] ?? null;
        $total_binarymatch_mtm = $query_total['binarymatch'] ?? null;
        $total_bonusglobal_mtm = $query_total['bonusglobal'] ?? null;
        $total_basecampmtm = $query_total['basecampmtm'] ?? null;

        // bonus
        $data['total_fil']           = $total_sponsorfil + $total_sponmatchingfil + $total_minmatchingfil + $total_minpairingfil;
        $data['total_mtm']           = $total_sponsormtm + $total_sponmatchingmtm + $total_pairingmatch_mtm + $total_binarymatch_mtm + $total_bonusglobal_mtm + $total_basecampmtm;
        $data['balance_fil']         = $data['total_fil'] - $query_transfer_bonus_fill['amount'] ?? null;
        $data['balance_mtm']         = $data['total_mtm'] - $query_transfer_bonus_mtm['amount'] ?? null;

        // mining
        $data['mining_fil_total']    = isset($query_total_fill['amount']) ? $query_total_fill['amount'] : 0;
        $data['mining_mtm_total']    = isset($query_total_mtm['amount']) ? $query_total_mtm['amount'] : 0;
        $data['mining_fil_balance']  = $query_total_fill['amount'] - $query_transfer_fill['amount'];
        $data['mining_mtm_balance']  = $query_total_mtm['amount'] - $query_transfer_mtm['amount'];

        // general
        $data['general_balance_fil'] = ($query_transfer_fill['amount'] + $query_transfer_bonus_fill['amount']) - $query_withdrawal_fil['amount'] + $query_deposit_fil['coin'] - $query_total_purchase['fill'];
        $data['general_balance_mtm'] = ($query_transfer_mtm['amount'] + $query_transfer_bonus_mtm['amount']) - $query_withdrawal_mtm['amount'] + $query_deposit_mtm['coin'] - $query_total_purchase['mtm'];
        $data['general_balance_zenx'] = $query_deposit_zenx['coin'] - $query_total_purchase['zenx'] - $query_withdrawal_zenx['amount'];

        // excess bonus
        $data['excess_bonus'] = $this->M_user->get_excess_bonus($id)->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/user_detail', $data);
            $this->load->view('templates/user_footer');

            if (isset($_POST['save'])) {
                $id = $this->input->post('id');
                $username = $this->input->post('username');
                $pass = $this->input->post('password');
                if ($pass != '') {
                    $password = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
                }
                $otp = $this->input->post('otp') == NULL ? $data['detail']['is_otp'] : $this->input->post('otp');
                $name = $this->input->post('first_name');
                $email = $this->input->post('email');
                $country = $this->input->post('country');
                $phone = $this->input->post('phone');
                $basecamp = $this->input->post('basecamp');
                $notif = $this->input->post('notif') == NULL ? NULL : $this->input->post('notif');

                $query_basecamp = $this->M_user->get_data_byid('basecamp_name', 'id', $basecamp);
                $basecamp_name = $query_basecamp['name'];

                if ($pass == '') {
                    $this->db->set('is_otp', $otp);
                    $this->db->set('first_name', $name);
                    $this->db->set('email', $email);
                    $this->db->set('country_code', $country);
                    $this->db->set('phone', $phone);
                    $this->db->set('id_basecamp', $basecamp);
                    $this->db->set('basecamp', $basecamp_name);
                    $this->db->set('note', $notif);
                    $this->db->where('id', $id);
                    $this->db->where('username', $username);
                    $update = $this->db->update('user');
                    if ($update == true) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Change data success</div>');
                        redirect('admin/userDetail/' . $id);
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Change data failed</div>');
                        redirect('admin/userDetail/' . $id);
                    }
                } else {
                    $this->db->set('is_otp', $otp);
                    $this->db->set('password', $password);
                    $this->db->set('first_name', $name);
                    $this->db->set('email', $email);
                    $this->db->set('country_code', $country);
                    $this->db->set('phone', $phone);
                    $this->db->set('id_basecamp', $basecamp);
                    $this->db->set('basecamp', $basecamp_name);
                    $this->db->set('note', $notif);
                    $this->db->where('id', $id);
                    $this->db->where('username', $username);
                    $update = $this->db->update('user');
                    if ($update == true) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Change data success</div>');
                        redirect('admin/userDetail/' . $id);
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Change data failed</div>');
                        redirect('admin/userDetail/' . $id);
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function allUserBonus()
    {
        $data['title'] = 'All User Bonus';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $month = date('m');
        $year  = date('Y');
        $a_date = $year.'-'.$month.'-'.'01';

        $start = '1';
        $enddate   = date("Y-m-t", strtotime($a_date));
        $endplus = date('Y-m-d', strtotime($enddate.' +1 day'));

        $begin = new DateTime($a_date);
        $end   = new DateTime($endplus);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        $data['date'] = $period;
        $data['adminClass']  = $this;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') 
        {
            if(!empty($this->uri->segment(3)))
            {
                $date = $this->uri->segment(3);

                $data['bonus'] = $this->M_user->get_bonusdetail_bydate($date)->result();

                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/admin_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('admin/all_user_bonus_detail', $data);
                $this->load->view('templates/user_footer');
            }
            else
            {
                $data['total'] = $this->M_user->totalBonusUser()->row_array();
                
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/admin_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('admin/all_user_bonus', $data);
                $this->load->view('templates/user_footer');
            }
        } else {
            redirect('auth');
        }
    }
    
    public function userBonusMonth()
    {
        $date = $this->input->post('date');
        
        $exDate = explode(" ", $date);

        $month_text = $exDate[0];

        $month = $this->month($month_text);
        $year = $exDate[1];

        $a_date = $year.'-'.$month.'-'.'01';
        $enddate   = date("Y-m-t", strtotime($a_date));

        $endplus = date('Y-m-d', strtotime($enddate.' +1 day'));

        $begin = new DateTime($a_date);
        $end   = new DateTime($endplus);

        $interval = DateInterval::createFromDateString('1 day');
        $period = new DatePeriod($begin, $interval, $end);

        $output = '';

        $output .= '<table class="table table-bordered" style="width:max-content" cellspacing="4" cellpadding="4">
                        <thead>
                            <tr class="head">
                                <th class="align-middle text-center date" rowspan="2">Date</th>
                                <th class="align-middle text-center" rowspan="2">Airdrop ZENX</th>
                                <th class="align-middle text-center" rowspan="2">Mining FIL</th>
                                <th class="align-middle text-center" rowspan="2">Airdrop MTM</th>
                                <th colspan="2" class="align-middle text-center">Sponsor</th>
                                <th colspan="2" class="align-middle text-center">Sponsor Matching</th>
                                <th colspan="3" class="align-middle text-center">Recommended Mining</th>
                                <th class="align-middle text-center" rowspan="2">Mining Generasi</th>
                                <th class="align-middle text-center" rowspan="2">Pairing</th>
                                <th class="align-middle text-center" rowspan="2">Pairing Matching</th>
                                <th class="align-middle text-center" rowspan="2">Global</th>
                                <th class="align-middle text-center" rowspan="2">Basecamp</th>
                            </tr>
                            <tr class="subhead">
                                <th>Filecoin</th>
                                <th>MTM</th>
                                <th>Filecoin</th>
                                <th>MTM</th>
                                <th>TEAM A</th>
                                <th>TEAM B</th>
                                <th>TEAM C</th>
                            </tr>
                        </thead>';
                        
        
        $total_miningfil = 0;
        $total_airdrop_mtm = 0;
        $total_sponsor_fil = 0;
        $total_sponsor_mtm = 0;
        $total_sponsor_matching_fil = 0;
        $total_sponsor_matching_mtm = 0;
        $total_recomm_mining_a = 0;
        $total_recomm_mining_b = 0;
        $total_recomm_mining_c = 0;
        $total_mining_generation = 0;
        $total_pairing = 0;
        $total_pairing_match = 0;
        $total_global = 0;
        $total_basecamp = 0;

        $output .= "<tbody>";

        foreach ($period as $dt) 
        {
            $showDate                       = $dt->format("Y-m-d");

            $query_minningfil               = $this->totalMiningFil($showDate);
            $query_airdrop_mtm              = $this->totalAirdropMtm($showDate);
            $query_sponsor                  = $this->totalSponsor($showDate);
            $query_sponsor_matching         = $this->totalSponsorMatching($showDate);
            $query_recomm_mining_a          = $this->totalRecommendedMining($showDate, 'A');
            $query_recomm_mining_b          = $this->totalRecommendedMining($showDate, 'B');
            $query_recomm_mining_c          = $this->totalRecommendedMining($showDate, 'C');
            $query_mining_generation        = $this->totalMiningGeneration($showDate);
            $query_pairing                  = $this->totalPairing($showDate);
            $query_pairing_match            = $this->totalPairingMatching($showDate);
            $query_global                   = $this->totalGlobalBonus($showDate);
            $query_basecamp                 = $this->totalBasecampBonus($showDate);

            $minningfil                     = empty($query_minningfil) ? 0 : number_format($query_minningfil, 10)." FIL";
            $airdrop_mtm                    = empty($query_airdrop_mtm) ? 0 : number_format($query_airdrop_mtm, 10)." MTM";
            $recomm_mining_a                = empty($query_recomm_mining_a) ? 0 : number_format($query_recomm_mining_a, 10)." FIL";
            $recomm_mining_b                = empty($query_recomm_mining_b) ? 0 : number_format($query_recomm_mining_b, 10)." FIL";
            $recomm_mining_c                = empty($query_recomm_mining_c) ? 0 : number_format($query_recomm_mining_c, 10)." FIL";
            $mining_generation              = empty($query_mining_generation) ? 0 : number_format($query_mining_generation, 10)." MTM";
            $pairing                        = empty($query_pairing) ? 0 : number_format($query_pairing, 10)." MTM";
            $pairing_match                  = empty($query_pairing_match) ? 0 : number_format($query_pairing_match, 10)." MTM";
            $global                         = empty($query_global) ? 0 : number_format($query_global, 10)." MTM";
            $basecamp                       = empty($query_basecamp) ? 0 : number_format($query_basecamp, 10)." MTM";

            $output .= '<tr>';
                $output .= '<td class="date">
                                <a href="'. base_url('admin/allUserBonus/').$showDate .'">'.$showDate.'
                                </a>
                            </td>
                            <td>0</td>
                            <td>'. $minningfil.'</td>
                            <td>'. $airdrop_mtm.'</td>';

                foreach($query_sponsor as $row_spon)
                {
                    $sponsor_fil = empty($row_spon->filecoin) ? 0 : number_format($row_spon->filecoin, 10)." FIL";
                    $sponsor_mtm = empty($row_spon->mtm) ? 0 : number_format($row_spon->mtm, 10)." MTM";

                    $output .= '<td>'.$sponsor_fil.'</td>
                                <td>'.$sponsor_mtm.'</td>';
                }

                foreach($query_sponsor_matching as $row_sponmatch)
                {
                    $sponsormatch_fil = empty($row_sponmatch->filecoin) ? 0 : number_format($row_sponmatch->filecoin, 10)." FIL";
                    $sponsormatch_mtm = empty($row_sponmatch->mtm) ? 0 : number_format($row_sponmatch->mtm, 10)." MTM";

                    $output .= '<td>'.$sponsormatch_fil.'</td>
                                <td>'.$sponsormatch_mtm.'</td>';
                }

                $output .= '<td>'.$recomm_mining_a.'</td>
                            <td>'.$recomm_mining_b.'</td>
                            <td>'.$recomm_mining_c.'</td>
                            <td>'.$mining_generation.'</td>
                            <td>'.$pairing.'</td>
                            <td>'.$pairing_match.'</td>
                            <td>'.$global.'</td>
                            <td>'.$basecamp.'</td>';

            $output .= '</tr>';

            $total_miningfil = $total_miningfil + $query_minningfil;
            $total_airdrop_mtm = $total_airdrop_mtm + $query_airdrop_mtm;
            $total_sponsor_fil = $total_sponsor_fil + $row_spon->filecoin;
            $total_sponsor_mtm = $total_sponsor_mtm + $row_spon->mtm;
            $total_sponsor_matching_fil = $row_sponmatch->filecoin + $total_sponsor_matching_fil;
            $total_sponsor_matching_mtm = $total_sponsor_matching_mtm + $row_sponmatch->mtm;
            $total_recomm_mining_a = $total_recomm_mining_a + $query_recomm_mining_a;
            $total_recomm_mining_b = $total_recomm_mining_b + $query_recomm_mining_b;
            $total_recomm_mining_c = $total_recomm_mining_c + $query_recomm_mining_c;
            $total_mining_generation = $total_mining_generation + $query_mining_generation;
            $total_pairing = $total_pairing + $query_pairing;
            $total_pairing_match = $total_pairing_match + $query_pairing_match;
            $total_global = $total_global + $query_global;
            $total_basecamp = $total_basecamp + $query_basecamp; 
        }
        
        $output .= '</tbody>';

        $total_miningfil = empty($total_miningfil) ? 0 : number_format($total_miningfil, 10)." FIL";
        $total_airdrop_mtm =  empty($total_airdrop_mtm) ? 0 : number_format($total_airdrop_mtm, 10)." MTM";
        $total_sponsor_fil =  empty($total_sponsor_fil) ? 0 : number_format($total_sponsor_fil, 10)." FIL";
        $total_sponsor_mtm =  empty($total_sponsor_mtm) ? 0 : number_format($total_sponsor_mtm, 10)." MTM";
        $total_sponsor_matching_fil = empty($total_sponsor_matching_fil) ? 0 : number_format($total_sponsor_matching_fil, 10)." FIL";
        $total_sponsor_matching_mtm =  empty($total_sponsor_matching_mtm) ? 0 : number_format($total_sponsor_matching_mtm, 10)." MTM";
        $total_recomm_mining_a = empty($total_recomm_mining_a) ? 0 : number_format($total_recomm_mining_a, 10)." FIL";
        $total_recomm_mining_b = empty($total_recomm_mining_b ) ? 0 : number_format($total_recomm_mining_b , 10)." FIL";
        $total_recomm_mining_c = empty($total_recomm_mining_c) ? 0 : number_format($total_recomm_mining_c, 10)." FIL";
        $total_mining_generation = empty($total_mining_generation) ? 0 : number_format($total_mining_generation, 10)." MTM";
        $total_pairing = empty($total_pairing) ? 0 : number_format($total_pairing, 10)." MTM";
        $total_pairing_match = empty($total_pairing_match) ? 0 : number_format($total_pairing_match, 10)." MTM";
        $total_global = empty($total_global) ? 0 : number_format($total_global, 10)." MTM";
        $total_basecamp = empty($total_basecamp) ? 0 : number_format($total_basecamp, 10)." MTM";
        
        $output .= '<tfoot>
                        <tr>
                            <th class="total">Total</th>
                            <th>0</th>
                            <th>'.$total_miningfil.'</th>
                            <th>'.$total_airdrop_mtm.'</th>
                            <th>'.$total_sponsor_fil.'</th>
                            <th>'.$total_sponsor_mtm.'</th>
                            <th>'.$total_sponsor_matching_fil.'</th>
                            <th>'.$total_sponsor_matching_mtm.'</th>
                            <th>'.$total_recomm_mining_a.'</th>
                            <th>'.$total_recomm_mining_b.'</th>
                            <th>'.$total_recomm_mining_c.'</th>
                            <th>'.$total_mining_generation.'</th>
                            <th>'.$total_pairing.'</th>
                            <th>'.$total_pairing_match.'</th>
                            <th>'.$total_global.'</th>
                            <th>'.$total_basecamp.'</th>
                        </tr>
                    </tfoot>';

        echo $output;
    }

    public function totalMiningFil($date)
    {
        $query = $this->M_user->get_totalmining_bydate($date);

        return $query['amount'];
    }

    public function totalAirdropMtm($date)
    {
        $query = $this->M_user->get_totalairmtm_bydate($date);

        return $query['amount'];
    }

    public function totalSponsor($date)
    {
        $query = $this->M_user->get_totalsponsor_bydate($date);

        return $query;
    }

    public function totalSponsorMatching($date)
    {
        $query = $this->M_user->get_totalmatching_bydate($date);

        return $query;
    }

    public function totalRecommendedMining($date, $team)
    {
        $query = $this->M_user->get_totalrm_bydate($date, $team);

        return $query['amount'];
    }

    public function totalMiningGeneration($date)
    {
        $query = $this->M_user->get_totalmining_gen_bydate($date);

        return $query['amount'];
    }
    
    public function totalPairing($date)
    {
        $query = $this->M_user->get_totalpairing_bydate($date);

        return $query['mtm'];
    }

    public function totalPairingMatching($date)
    {
        $query = $this->M_user->get_totalpairing_match_bydate($date);

        return $query['mtm'];
    }
    
    public function totalGlobalBonus($date)
    {
        $query = $this->M_user->get_totalglobal_bydate($date);

        return $query['mtm'];
    }
    
    public function totalBasecampBonus($date)
    {
        $query = $this->M_user->get_totalbasecamp_bydate($date);

        return $query['mtm'];
    }

    public function usernameBasecamp($id)
    {
        $query = $this->M_user->get_username_basecamp($id);

        return $query['username'];
    }

    public function detailUserBonus($id)
    {
        $data['title']                    = 'Detail User Bonus';
        $data['user']                     = $this->db->get_where('user', ['id' => $id])->row_array();

        $data['bonus_sponsor']            = $this->M_user->get_bonus_bysponsor($id);
        $data['bonus_sponmatching']       = $this->M_user->get_bonus_bysponsormatching($id);
        $data['bonus_recommended_mining'] = $this->M_user->get_bonus_miningmatching($id);
        $data['bonus_mining_generasi']    = $this->M_user->get_bonus_miningpairing($id)->get()->result();
        $data['bonus_pairing']            = $this->M_user->get_bonus_pairingmatching($id);
        $data['bonus_pairing_matching']   = $this->M_user->get_bonus_binarymatch($id);
        $data['bonus_global']             = $this->M_user->get_bonus_global($id);
        $data['bonus_basecamp']           = $this->M_user->get_bonus_basecamp2($id);
        $data['userClass']                = $this;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/detail_user_bonus', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function basecampDetail($id)
    {
        $data['title'] = 'Basecamp';
        $query_user = $this->M_user->get_user_byid($id);
        $data['detail'] = $this->M_user->get_detail_basecamp($id);

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/basecamp_detail', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    private function _color_network($point)
    {
        if ($point < 3) {
            $color = '#FFD11A';
        } elseif ($point >= 3 && $point < 9) {
            $color = '#119A48';
        } elseif ($point >= 9 && $point < 15) {
            $color = '#4169B2';
        } elseif ($point >= 15 && $point < 30) {
            $color = '#874D9E';
        } elseif ($point >= 30 && $point < 60) {
            $color = '#EF3D39';
        } elseif ($point >= 60 && $point < 120) {
            $color = '#8DC63F';
        } elseif ($point >= 120 && $point < 300) {
            $color = '#EB9123';
        } elseif ($point >= 300 && $point < 540) {
            $color = '#46C2CA';
        } elseif ($point >= 540) {
            $color = '#CA4291';
        }

        return $color;
    }
    
    public function flag($code)
    {
        $flag = "";

        if ($code == '62') {
            $flag = 'indonesia.png';
        } elseif ($code == '82') {
            $flag = 'south-korea.png';
        } elseif ($code == '1') {
            $flag = 'united-states.png';
        } elseif ($code == '44') {
            $flag = 'united-kingdom.png';
        } elseif ($code == '66') {
            $flag = 'china.png';
        } elseif ($code == '84') {
            $flag = 'vietnam.png';
        } elseif ($code == '86') {
            $flag = 'thailand.png';
        }

        return $flag;
    }
    
    public function box($name)
    {
        $box = "";

        if ($name < 3) {
            $box = '1box.png';
        } elseif ($name >= 3 &&  $name < 9) {
            $box = '3box.png';
        } elseif ($name >= 9 &&  $name < 15) {
            $box = '9box.png';
        } elseif ($name >= 15 &&  $name < 30) {
            $box = '15box.png';
        } elseif ($name >= 30 &&  $name < 60) {
            $box = '30box.png';
        } elseif ($name >= 60 &&  $name < 120) {
            $box = '60box.png';
        } elseif ($name >= 120 &&  $name < 300) {
            $box = '120box.png';
        } elseif ($name >= 300 &&  $name < 540) {
            $box = '300box.png';
        } elseif ($name >= 540) {
            $box = '540box.png';
        } else {
            $box = '0box.png';
        }

        return $box;
    }
    public function get_countMember($id)
    {
        $query = $this->M_user->get_totaluser_byposition($id);

        foreach ($query->result() as $row) {

            array_push($this->arr, $row->user_id);

            $this->get_countMember($row->user_id);
        }

        return $this->arr;
    }
    
    /**Count total id network left */
    public function countIDL($userid)
    {
        $query          = $this->M_user->check_line($userid, 'A');
        $user_position  = $query['user_id'] ?? null;
        $this->arr = array();

        if (!empty($user_position)) {
            $countId = count($this->get_countMember($user_position)) + 1;
        } else {
            $countId = count($this->get_countMember($user_position));
        }

        return $countId;
    }
    
    /**Count total id network right */
    public function countIDR($userid)
    {
        $query          = $this->M_user->check_line($userid, 'B');
        $user_position  = $query['user_id'] ?? null;
        $this->arr = array();

        if (!empty($user_position)) {
            $countId = count($this->get_countMember($user_position)) + 1;
        } else {
            $countId = count($this->get_countMember($user_position));
        }

        return $countId;
    }

    public function countPointTodayL($userid)
    {
        $dateNow            = date('Y-m-d');

        $query              = $this->M_user->check_line($userid, 'A');
        $user_position      = $query['user_id'] ?? null;

        $query_package      = $this->M_user->get_onepoint_byuser($user_position, $dateNow)->row_array();
        $package_datecreate = $query_package['datecreate'] ?? null;

        $packagePoint       = $query_package['point'] ?? null;

        $countMember        = $this->get_countPointTodayL($user_position, $dateNow);
        $sumTotal           = array_sum($countMember) + $packagePoint;
        $this->arrTodayL    = array();

        return $sumTotal;
    }

    public function get_countPointTodayL($id, $date)
    {
        // $query = $this->M_user->get_totalpoin_byposition($id);
        $query = $this->M_user->get_sumtodaypoint_byposition($id, $date);

        foreach ($query->result() as $row) {
            // if (date('Y-m-d', $row->datecreate) == $date) {
            //     array_push($this->arrTodayL, $row->point);
            // }

            array_push($this->arrTodayL, $row->point);

            $this->get_countPointTodayL($row->user_id, $date);
        }

        return $this->arrTodayL;
    }

    public function countPointTodayR($userid)
    {
        $dateNow = date('Y-m-d');

        $query = $this->M_user->check_line($userid, 'B');
        $user_position = $query['user_id'] ?? null;

        $query_package = $this->M_user->get_onepoint_byuser($user_position, $dateNow)->row_array();
        $package_datecreate = $query_package['datecreate'] ?? null;

        $packagePoint = $query_package['point'] ?? null;

        $countMember = $this->get_countPointTodayR($user_position, $dateNow);
        $sumTotal = array_sum($countMember) + $packagePoint;
        $this->arrTodayR = array();

        return $sumTotal;
    }

    public function get_countPointTodayR($id, $date)
    {
        $query = $this->M_user->get_sumtodaypoint_byposition($id, $date);

        foreach ($query->result() as $row) {
            // if (date('Y-m-d', $row->datecreate) == $date) {
            //     array_push($this->arrTodayR, $row->point);
            // }

            array_push($this->arrTodayR, $row->point);

            $this->get_countPointTodayR($row->user_id, $date);
        }

        return $this->arrTodayR;
    }
    
    public function balance_point($userid)
    {
        $query = $this->M_user->balance_now_nol($userid)->row_array();
        return $query;
    }

    public function sponsornet($id)
    {
        $data['title'] = 'Sponsor';

        $query_user = $this->M_user->get_user_byid($id);

        $idLeft         = $this->countIDL($query_user['id']);
        $idRight        = $this->countIDR($query_user['id']);

        if ($idLeft and $idRight >= 100) {
            $scale = '0.2';
        } elseif ($idLeft and $idRight >= 5 && $idLeft and $idRight < 100) {
            $scale = '0.6';
        } else {
            $scale = '1';
        }
        $data['scale'] = $scale;

        $data['user']           = $query_user;
        $data['sponsor']        = $this->_showSponsor($query_user['id'], $query_user['country_code'], $query_user['username']);

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '1') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/admin_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('admin/detail_sponsornet', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
        } else {
            redirect('auth');
        }
    }

    private function _showSponsor($id, $countryCode, $username)
    {
        $package        = $this->M_user->get_box_fm($id)->row_array();
        $query_sponsor  = $this->M_user->get_sponsor_member1($id);
        $query_box      = $this->M_user->sumPackage($id);
        $package_name   = $query_box['point'] ?? null;
        $package_color  = $this->_color_network($package_name);

        $idLeft         = $this->countIDL($id);
        $idRight        = $this->countIDR($id);

        if ($idLeft and $idRight >= 100) {
            $scale = '0.2';
        } elseif ($idLeft and $idRight >= 5 && $idLeft and $idRight < 100) {
            $scale = '0.6';
        } else {
            $scale = '1';
        }

        $output = '';

        $output .= '<ul>';
        $output .=    '<li class="maindiv" style="overflow: hidden; transform:scale(' . $scale . ')">';
        $output .=    '<div class="item" style="border: 7px solid ' . $package_color . '">
                            <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($countryCode) . '" alt="" width="40px">
                            <h1 class="text-uppercase name-network">' . strtolower($username) . '</h1>
                            <div class="d-flex justify-content-center align-content-center align-items-center text-center position-relative my-2">
                                <img src="' . base_url('assets/img/') . $this->box($package_name) . '" alt="#" height="90px">
                                <p style="position: absolute; bottom:10px">ME</p>
                            </div>
                            <p class="box-network text-white" style="background-color: ' . $package_color . '">' . $package_name . ' BOX</p>
                            <button id="'.$id.'" onClick="reply_click_admin(this.id)" class="charetnet">
                                <i class="fas fa-caret-down"></i>
                            </button>
                        </div>';

            $output .= '<div id="result'.$id.'" class="hideNetwork"></div>';
        $output .=    '</li>';
        $output .=  '</ul>';

        return $output;
    }

    private function _loopingSponsor($id)
    {
        $query_sponsor  = $this->M_user->get_sponsor_member1($id);

        $output = '';

        if (count($query_sponsor) != '') {
            $output .= '<ul>';

            foreach ($query_sponsor as $row_sponsor) {
                $team           = $this->_sponsorTeam($id, $row_sponsor->user_id);
                $query_box      = $this->M_user->sumPackage($row_sponsor->user_id);
                $package_name   = $query_box['point'] ?? null;
                $package_color  = $this->_color_network($package_name);

                $output .=    '<li>';

                $output .=      '<a href="' . base_url('admin/sponsornet/') . $row_sponsor->user_id . '">
                                    <div class="item" style="border:7px solid ' . $package_color . '">
                                        <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($row_sponsor->country_code) . '" alt="" width="40px">
                                        <h1 class="text-uppercase name-network">' . strtolower($row_sponsor->username) . '</h1>
                                        <div class="d-flex justify-content-center align-content-center align-items-center text-center position-relative my-2">
                                            <img src="' . base_url('assets/img/') . $this->box($package_name) . '" alt="" height="90px">
                                            <p style="position: absolute;bottom: 57px;">' . $row_sponsor->fm . '</p>
                                            <p style="position: absolute; bottom:10px">' . $team . '</p>
                                        </div>
                                        <p class="box-network text-white" style="background-color:' . $package_color . '">' . $package_name . ' BOX</p>
                                    </div>
                                </a>';
                //looping
                $output .= $this->_loopingSponsor($row_sponsor->user_id);

                $output .=      '</li>';
            }

            $output .= '</ul>';
        }

        return $output;
    }

    private function _sponsorTeam($sponsor, $member)
    {
        $query = $this->M_user->get_userid_bysponsor($sponsor)->result_array();
        $value = $member;

        $team_number = $this->_searchArray($value, $query);

        if ($team_number >= 0 && $team_number <= 2) {
            $team_name = 'TEAM A';
        } elseif ($team_number >= 3 && $team_number <= 5) {
            $team_name = 'TEAM B';
        } elseif ($team_number >= 6) {
            $team_name = 'TEAM C';
        }

        return $team_name;
    }
    private function _searchArray($value, $array)
    {
        return array_search($value, array_column($array, 'user_id'));
    }

    // network
    public function network($id)
    {

        $data['title'] = 'Network';

        $query_user    = $this->M_user->get_user_byid($id);

        $idLeft         = $this->countIDL($query_user['id']);
        $idRight        = $this->countIDR($query_user['id']);

        if ($idLeft and $idRight >= 100) {
            $scale = '0.2';
        } elseif ($idLeft and $idRight >= 5 && $idLeft and $idRight < 100) {
            $scale = '0.6';
        } else {
            $scale = '1';
        }
        $data['scale'] = $scale;

        $data['user']               = $query_user;
        $data['network']            = $this->_showNetwork($query_user['id'], $query_user['country_code'], $query_user['username']);

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '1') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/admin_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('admin/detail_network', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
        } else {
            redirect('auth');
        }
    }

    private function _showNetwork($id, $countryCode, $username)
    {
        $endLoop        = 10;
        $query_position = $this->M_user->get_network_byposition($id);
        $package        = $this->M_user->get_box_fm($id)->row_array();
        $query_box      = $this->M_user->sumPackage($id);
        $balancePoint   = $this->balance_point($id);

        $pointTodayL    = $this->countPointTodayL($id);
        $pointTodayR    = $this->countPointTodayR($id);
        $idLeft         = $this->countIDL($id);
        $idRight        = $this->countIDR($id);
        $package_fm     = $package['fm'] ?? null;
        $package_name   = $query_box['point'] ?? null;
        $package_color  = $this->_color_network($package_name);

        if ($idLeft and $idRight >= 100) {
            $scale = '0.2';
        } elseif ($idLeft and $idRight >= 5 && $idLeft and $idRight < 100) {
            $scale = '0.6';
        } else {
            $scale = '1';
        }

        if ($balancePoint) {
            $balance_a = $balancePoint['balance_a'] + $pointTodayL;
            $balance_b = $balancePoint['balance_b'] + $pointTodayR;
        } else {
            $balance_a = $this->countPositionL($id);
            $balance_b = $this->countPositionR($id);
        }

        $output = '';

        $output .= '<ul>';
        $output .=    '<li class="maindiv" style="overflow: hidden;">';
        $output .=    '<div class="item" style="border: 7px solid ' . $package_color . ';">
                            <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($countryCode) . '" alt="flag">
                            <h1 class="text-uppercase name-network">' . strtolower($username) . '</h1>
                            <p>' . $package_fm . '</p>
                            <div class="d-flex  justify-content-center align-content-center align-items-center position-relative">
                                <div class="text-right">
                                    <p>(' . $idLeft . ' ID) left</p>
                                    <p style="color:' . $package_color . '">' . $balance_a . '&nbsp;(' . $this->countPositionL($id) . ')</p>
                                    <p>Increase</p>
                                    <p style="color:' . $package_color . '">+ ' . $pointTodayL . '</p>
                                </div>
                                <div class="line"></div>
                                <div class="text-left">
                                    <p>right (' . $idRight . ' ID)</p>
                                    <p style="color: ' . $package_color . '">' . $balance_b . '&nbsp;(' . $this->countPositionR($id) . ')</p>
                                    <p>Increase</p>
                                    <p style="color: ' . $package_color . '">+ ' . $pointTodayR . '</p>
                                </div>
                            </div>
                            <p class="box-network text-white" style="background-color:' . $package_color . '">' . $package_name . ' BOX</p>
                            <button id="'.$id.'" onClick="reply_click(this.id)" class="charetnet">
                                <i class="fas fa-caret-down"></i>
                            </button>
                        </div>';
            
            $output .= '<div id="result'.$id.'" class="hideNetwork"></div>';
        $output .=    '</li>';
        $output .=  '</ul>';

        return $output;
    }

    private function _loopingNetwork($firstLoop, $endLoop, $user_id)
    {
        if($firstLoop > $endLoop)
        {
            return false;
        }

        $query_position = $this->M_user->get_network_byposition($user_id);

        $output = '';

        if (count($query_position) != '') {
            $output .= '<ul>';

            foreach ($query_position as $row_position) 
            {
                $countLeft      = $this->countPositionL($row_position->user_id);
                $countRight     = $this->countPositionR($row_position->user_id);
                $balancePoint   = $this->balance_point($row_position->user_id);
                $pointTodayL    = $this->countPointTodayL($row_position->user_id);
                $pointTodayR    = $this->countPointTodayR($row_position->user_id);
                $idLeft         = $this->countIDL($row_position->user_id);
                $idRight        = $this->countIDR($row_position->user_id);
                $query_box      = $this->M_user->sumPackage($row_position->user_id);
                $package_name   = $query_box['point'] ?? null;
                $package_color  = $this->_color_network($package_name);
    
                if ($balancePoint) {
                    $balance_a = $balancePoint['balance_a'] + $pointTodayL;
                    $balance_b = $balancePoint['balance_b'] + $pointTodayR;
                } else {
                    $balance_a = $countLeft;
                    $balance_b = $countRight;
                }
    
                $output .=    '<li>';
                $output .=      '<div class="item" style="border:7px solid ' . $package_color . '">
                                    <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($row_position->country_code) . '" alt="#" width="40px">
                                    <h1 class="text-uppercase name-network" id="'.strtolower($row_position->username).'">' . strtolower($row_position->username) . '</h1>
                                    <p>' . $row_position->fm . '</p>
                                    <div class="d-flex justify-content-center align-content-center align-items-center position-relative">
                                        <div class="text-right">
                                            <p>(' . $idLeft . ' ID) left</p>
                                            <p style="color:' . $package_color . '">' . $balance_a . '&nbsp;(' . $countLeft . ')</p>
                                            <p>Increase</p>
                                            <p style="color:' . $package_color . '">+ ' . $pointTodayL . '</p>
                                        </div>
                                        <div class="line"></div>
                                        <div class="text-left">
                                            <p>right (' . $idRight . ' ID)</p>
                                            <p style="color:' . $package_color . '">' . $balance_b . '&nbsp;(' . $countRight . ')</p>
                                            <p>Increase</p>
                                            <p style="color:' . $package_color . '">+ ' . $pointTodayR . '</p>
                                        </div>
                                    </div>';

                $query_position_bottom = $this->M_user->get_network_byposition($row_position->user_id);

                if(count($query_position_bottom) != '')
                {
                    $output .=      '<p class="box-network text-white" style="background-color:' . $package_color . '">' . $package_name . ' BOX</p>
                                        <button id="'.$row_position->user_id.'" onClick="reply_click_net(this.id)" class="charetnet">
                                            <i class="fas fa-caret-down"></i>
                                        </button>
                                    </div>';
                }
                else
                {
                    
                    $output .=      '<p class="box-network text-white" style="background-color:' . $package_color . '">' . $package_name . ' BOX</p>
                                        <button id="'.$row_position->user_id.'" onClick="reply_click_net(this.id)" class="charetnet">
                                            <i class="fas fa-caret-down"></i>
                                        </button>
                                    </div>';
                }
                   
                
                if($firstLoop == $endLoop)
                {
                    $output .= '<div id="result'.$row_position->user_id.'" class="hideNetwork">';
                }
                else
                {
                    $output .= '<div id="result'.$row_position->user_id.'" class="displayNetwork">';
                }
                
                //looping
                $output .= $this->_loopingNetwork($firstLoop + 1, $endLoop, $row_position->user_id);
                
                $output .= '</div>';

                $output .=      '</li>';
            }

            $output .= '</ul>';
        }

        return $output;
    }
    
    public function showDownline()
    {
        $id             = $this->input->post('user');
        $query_position = $this->M_user->get_network_byposition($id);
        $level          = $this->input->post('level');

        if(empty($level))
        {
            $endLoop = 0;
        }
        else
        {
            $endLoop        = $level -1;
        }

        $output         = '';

        if (count($query_position) != '') 
        {
            $output .= '<ul>';
    
            foreach ($query_position as $row_position) 
            {
                $countLeft      = $this->countPositionL($row_position->user_id);
                $countRight     = $this->countPositionR($row_position->user_id);
                $balancePoint   = $this->balance_point($row_position->user_id);
                $pointTodayL    = $this->countPointTodayL($row_position->user_id);
                $pointTodayR    = $this->countPointTodayR($row_position->user_id);
                $idLeft         = $this->countIDL($row_position->user_id);
                $idRight        = $this->countIDR($row_position->user_id);
                $query_box      = $this->M_user->sumPackage($row_position->user_id);
                $package_name   = $query_box['point'] ?? null;
                $package_color  = $this->_color_network($package_name);
    
                if ($balancePoint) {
                    $balance_a = $balancePoint['balance_a'] + $pointTodayL;
                    $balance_b = $balancePoint['balance_b'] + $pointTodayR;
                } else {
                    $balance_a = $countLeft;
                    $balance_b = $countRight;
                }
    
                $output .=    '<li>';
                $output .=      '<div class="item" style="border:7px solid ' . $package_color . '">
                                    <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($row_position->country_code) . '" alt="#" width="40px">
                                    <h1 class="text-uppercase name-network" id="'.strtolower($row_position->username).'">' . strtolower($row_position->username) . '</h1>
                                    <p>' . $row_position->fm . '</p>
                                    <div class="d-flex justify-content-center align-content-center align-items-center position-relative">
                                        <div class="text-right">
                                            <p>(' . $idLeft . ' ID) left</p>
                                            <p style="color:' . $package_color . '">' . $balance_a . '&nbsp;(' . $countLeft . ')</p>
                                            <p>Increase</p>
                                            <p style="color:' . $package_color . '">+ ' . $pointTodayL . '</p>
                                        </div>
                                        <div class="line"></div>
                                        <div class="text-left">
                                            <p>right (' . $idRight . ' ID)</p>
                                            <p style="color:' . $package_color . '">' . $balance_b . '&nbsp;(' . $countRight . ')</p>
                                            <p>Increase</p>
                                            <p style="color:' . $package_color . '">+ ' . $pointTodayR . '</p>
                                        </div>
                                    </div>';
                    
                    $query_position_bottom = $this->M_user->get_network_byposition($row_position->user_id);

                    if(count($query_position_bottom) != '')
                    {
                        $output .= '<p class="box-network text-white" style="background-color:' . $package_color . '">' . $package_name . ' BOX</p>
                                            <button id="'.$row_position->user_id.'" onClick="reply_click(this.id)" class="charetnet">
                                                <i class="fas fa-caret-up"></i>
                                            </button>
                                        </div>';
                            
                        $output .= '<div id="result'.$row_position->user_id.'" class="displayNetwork">';
                        
                        $output .= $this->_loopingNetwork(1, $endLoop, $row_position->user_id);
                        
                        $output .= '</div>';
                    }
                    else
                    {
                        $output .= '<p class="box-network text-white" style="background-color:' . $package_color . '">' . $package_name . ' BOX</p>
                                            <button id="'.$row_position->user_id.'" onClick="reply_click(this.id)" class="charetnet">
                                                <i class="fas fa-caret-down"></i>
                                            </button>
                                        </div>';
                            
                        $output .= '<div id="result'.$row_position->user_id.'" class="hideNetwork">';
                        
                        $output .= $this->_loopingNetwork(1, $endLoop, $row_position->user_id);
                        
                        $output .= '</div>';
                    }
    
                $output .=    '</li>';
                
            }

            $output .= '</ul>';
        }
        echo $output;
    }
    
    public function showSponsorBottom()
    {
        $id             = $this->input->post('user');
        $query_sponsor  = $this->M_user->get_sponsor_member1($id);

        $output = '';

        if (count($query_sponsor) != '') 
        {
            $output .= '<ul>';

            foreach ($query_sponsor as $row_sponsor) 
            {
                $team           = $this->_sponsorTeam($id, $row_sponsor->user_id);
                $query_box      = $this->M_user->sumPackage($row_sponsor->user_id);
                $package_name   = $query_box['point'] ?? null;
                $package_color  = $this->_color_network($package_name);

                $output .=    '<li>';

                $output .=      '<div class="item" style="border:7px solid ' . $package_color . '">
                                    <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($row_sponsor->country_code) . '" alt="" width="40px">
                                    <h1 class="text-uppercase name-network" id="'.strtolower($row_sponsor->username).'">' . $row_sponsor->username . '</h1>
                                    <div class="d-flex justify-content-center align-content-center align-items-center text-center position-relative my-2">
                                        <img src="' . base_url('assets/img/') . $this->box($package_name) . '" alt="#" height="90px">
                                        <p style="position: absolute;bottom: 57px;">' . $row_sponsor->fm . '</p>
                                        <p style="position: absolute; bottom:10px">' . $team . '</p>
                                    </div>
                                    <p class="box-network text-white" style="background-color:' . $package_color . '">' . $package_name . ' BOX</p>
                                    <button id="'.$row_sponsor->user_id.'" onClick="reply_click_admin(this.id)" class="charetnet">
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </div>';

                $output .= '<div id="result'.$row_sponsor->user_id.'" class="hideNetwork"></div>';    
                $output .=    '</li>';
            }

            $output .= '</ul>';
        }

        echo $output;
    }
    
    
    
    public function allNetwork()
    {
        $data['title']      = 'All Network';
        $data['user']       = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $query_user         = $this->M_user->get_user_toplevel();   
        $limitLevel         = $this->_countLimitLevel(0, $query_user['id']);

        $data['network']    = $this->_showAllNetwork($query_user['id'], $query_user['country_code'], $query_user['username']);
        $data['limitLevel'] = $limitLevel;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/all_network', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    
    private function _showAllNetwork($id, $countryCode, $username)
    {
        $endLoop        = 10;
        $query_position = $this->M_user->get_network_byposition($id);
        $package        = $this->M_user->get_box_fm($id)->row_array();
        $query_box      = $this->M_user->sumPackage($id);
        $balancePoint   = $this->balance_point($id);

        $pointTodayL    = $this->countPointTodayL($id);
        $pointTodayR    = $this->countPointTodayR($id);
        $idLeft         = $this->countIDL($id);
        $idRight        = $this->countIDR($id);
        $package_fm     = $package['fm'] ?? null;
        $package_name   = $query_box['point'] ?? null;
        $package_color  = $this->_color_network($package_name);

        if ($balancePoint) {
            $balance_a = $balancePoint['balance_a'] + $pointTodayL;
            $balance_b = $balancePoint['balance_b'] + $pointTodayR;
        } else {
            $balance_a = $this->countPositionL($id);
            $balance_b = $this->countPositionR($id);
        }

        $output = '';

        $output .= '<ul>';
        $output .=    '<li class="maindiv" style="overflow: hidden;">';
        $output .=    '<div class="item" id="me" style="border: 7px solid ' . $package_color . ';">
                            <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($countryCode) . '" alt="flag">
                            <h1 class="text-uppercase name-network" id="'.strtolower($username).'">' . strtolower($username) . '</h1>
                            <p>' . $package_fm . '</p>
                            <div class="d-flex  justify-content-center align-content-center align-items-center position-relative">
                                <div class="text-right">
                                    <p>(' . $idLeft . ' ID) left</p>
                                    <p style="color:' . $package_color . '">' . $balance_a . '&nbsp;(' . $this->countPositionL($id) . ')</p>
                                    <p>Increase</p>
                                    <p style="color:' . $package_color . '">+ ' . $pointTodayL . '</p>
                                </div>
                                <div class="line"></div>
                                <div class="text-left">
                                    <p>right (' . $idRight . ' ID)</p>
                                    <p style="color: ' . $package_color . '">' . $balance_b . '&nbsp;(' . $this->countPositionR($id) . ')</p>
                                    <p>Increase</p>
                                    <p style="color: ' . $package_color . '">+ ' . $pointTodayR . '</p>
                                </div>
                            </div>
                            <p class="box-network text-white" style="background-color:' . $package_color . '">' . $package_name . ' BOX</p>
                            <button id="'.$id.'" onClick="reply_click(this.id)" class="charetnet">
                                <i class="fas fa-caret-down"></i>
                            </button>
                        </div>';

                $output .= '<div id="result'.$id.'" class="hideNetwork"></div>';

        $output .=    '</li>';
        $output .=  '</ul>';

        return $output;
    }
    
    //count limit level
    public function _countLimitLevel($endLoop, $user_id)
    {
        $query_position = $this->M_user->get_network_byposition($user_id);

        if (count($query_position) != '') 
        {
            foreach ($query_position as $row_position) 
            {
                return $this->_countLimitLevel($endLoop+1, $row_position->user_id);
            }
        }
        else
        {
            return $endLoop;
        }
    }
    
    public function detailLevel($level)
    {
        $data['user']   = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['title']  = 'Detail Level';

        if ($level == 'FM10') {
            $array_level = array('FM10');
        } else if ($level == 'FM9') {
            $array_level = array('FM9', 'FM10');
        } else if ($level == 'FM8') {
            $array_level = array('FM8', 'FM9', 'FM10');
        } else if ($level == 'FM7') {
            $array_level = array('FM7', 'FM8', 'FM9', 'FM10');
        } else if ($level == 'FM6') {
            $array_level = array('FM6', 'FM7', 'FM8', 'FM9', 'FM10');
        } else if ($level == 'FM5') {
            $array_level = array('FM5', 'FM6', 'FM7', 'FM8', 'FM9', 'FM10');
        } else if ($level == 'FM4') {
            $array_level = array('FM4', 'FM5', 'FM6', 'FM7', 'FM8', 'FM9', 'FM10');
        }

        $data['user_level'] = $this->M_user->get_user_level2($array_level)->result();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/detail_level', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    
    public function detailBasecamp()
    {
        $data['user']   = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();        
        $data['title']  = 'Detail Basecamp';
        
        $id_basecamp = $this->uri->segment(3);

        $query_basecamp = $this->M_user->get_userlist_basecamp($id_basecamp);

        $data['basecamp'] = $query_basecamp;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/detail_basecamp', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function detailBasecampOmset()
    {
        $data['user']   = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();        
        $data['title']  = 'Detail Omset Basecamp';
        
        $id_basecamp = $this->uri->segment(3);
        $id_user = $this->uri->segment(4);

        $query_basecamp = $this->M_user->get_omset_bybasecamp($id_basecamp, $id_user);
        $query_basecamp_gather = $this->M_user->get_omset_bybasecamp_gather($id_basecamp, $id_user);
        $query_basecamp_excess = $this->M_user->get_omset_bybasecamp_excess($id_basecamp, $id_user);

        $data['basecamp'] = $query_basecamp;
        $data['gather'] = $query_basecamp_gather;
        $data['excess'] = $query_basecamp_excess;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/detail_basecamp_omset', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    
    public function showBasecamplist()
    {
        $id   = $this->input->post('id');
        $user = $this->M_user->get_basecamp_user_bycamp($id)->result();

        $output = '';

        $output .= '<form action="'.base_url('admin/confirmBasecamp').'" method="post">';

        $query_top_user = $this->M_user->get_user_toplevel();

        $output .= '<input type="radio" id="user" name="user" value="'.$query_top_user['id'].'">
                            <label for="user">'.$query_top_user['username'].'</label><br>';

        if(!empty($user))
        {   
            foreach($user as $row)
            {
                $output .= '<input type="radio" id="user" name="user" value="'.$row->id.'">
                            <label for="user">'.$row->username.'</label><br>';
            }
                            
            
        }
        
        $output .= '<div class="modal-footer">
        <input type="hidden" value="'.$id.'" name="idbasecamp">
        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" href="#" id="basecampLink">Save</button>
        </div>';
        
        $output .= '</form>';

        echo $output;
    }
    
    public function omsetGlobalPerMonth($date)
    {
        $query = $this->M_user->get_purchase_admin_bymonth($date);
        return $query;
    }
    
    public function omsetGlobalByLevelMonth($date, $level)
    {
        $query_bonus = $this->M_user->get_globalbonus_bymonth_level($date, $level);

        return $query_bonus['mtm'];
    }
    
    public function excessGlobalByLevelMonth($date, $level)
    {
        $query_bonus = $this->M_user->get_excessglobal_bymonth_level($date, $level);

        return $query_bonus['mtm'];
    }
    
    public function news_announcement()
    {
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['news'] = $this->M_user->get_all_news()->result();
        $data['title'] = 'News';

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/news', $data);
            $this->load->view('templates/user_footer');

            if (isset($_POST['addNews'])) {
                $config['upload_path'] = 'assets/photo/news/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size']  = '2048';
                $config['remove_space'] = TRUE;

                $this->load->library('upload', $config);
                if ($this->upload->do_upload('image')) {
                    $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');

                    if ($return['result'] == "success") {
                        $data_insert = [
                            'title' => $this->input->post('title'),
                            'message' => $this->input->post('message'),
                            'title_kr' => $this->input->post('title_kr'),
                            'message_kr' => $this->input->post('message_kr'),
                            'image' => $return['file']['file_name'],
                            'datecreate' => time(),
                            'update_date' => 0,
                        ];

                        $insert = $this->M_user->insert_data('news_announce', $data_insert);

                        if ($insert == true) {
                            $this->db->set('is_news', 0);
                            $update = $this->db->update('user');

                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Add News Success</div>');
                            redirect('admin/news_announcement');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Add News Failed</div>');
                            redirect('admin/news_announcement');
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Upload Image Error</div>');
                        redirect('admin/news_announcement');
                    }
                } else {
                    $data_insert = [
                        'title' => $this->input->post('title'),
                        'message' => $this->input->post('message'),
                        'title_kr' => $this->input->post('title_kr'),
                        'message_kr' => $this->input->post('message_kr'),
                        'datecreate' => time(),
                        'update_date' => 0,
                    ];
                    $insert = $this->M_user->insert_data('news_announce', $data_insert);

                    if ($insert == true) {
                        $this->db->set('is_news', 0);
                        $update = $this->db->update('user');

                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Add News Success</div>');
                        redirect('admin/news_announcement');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Add News Failed</div>');
                        redirect('admin/news_announcement');
                    }
                }
            }
            
            if (isset($_POST['deleteNews'])) {
                $id = $this->input->post('id_news');

                $this->db->where('id', $id);
                $del = $this->db->delete('news_announce');

                if ($del == true) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Delete News Success</div>');
                    redirect('admin/news_announcement');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Delete News Failed</div>');
                    redirect('admin/news_announcement');
                }
            }
        } else {
            redirect('auth');
        }
    }
    
    public function packageMining()
    {
        $data['title']      = 'Package Purchase';
        $data['user']       = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $query_mining       = $this->M_user->show_one_data('package', 'id', '1');
        $query_tour_korea   = $this->M_user->get_data_byid_order('package_tour', 'id', 'ASC', 'type', '1'); 
        $query_tour_bali   = $this->M_user->get_data_byid_order('package_tour', 'id', 'ASC', 'type', '2'); 

        $data['mining']     = $query_mining;
        $data['tour_korea'] = $query_tour_korea;
        $data['tour_bali']  = $query_tour_bali;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('admin/package_mining', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function savePackageMining()
    {
        $data['user']       = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $filecoin = htmlspecialchars($this->input->post('miningfil'), true);
        $mtm      = htmlspecialchars($this->input->post('miningmtm'), true);
        $zenx     = htmlspecialchars($this->input->post('miningzenx'), true);
        
        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') 
        {
            $this->form_validation->set_rules('miningfil', 'Filecoin Price', 'required|numeric');
            $this->form_validation->set_rules('miningmtm', 'MTM Price', 'required|numeric');
            $this->form_validation->set_rules('miningzenx', 'Zenx Price', 'required|numeric');

            if ($this->form_validation->run() == false) 
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                Failed. Failed update data.
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>');
                    redirect('admin/packageMining');
            }
            else
            {
                $query_all_package = $this->M_user->show_all_data('package', 'ASC');

                foreach($query_all_package as $row_package)
                {
                    $filPrice = $row_package->point * $filecoin;
                    $mtmPrice = $row_package->point * $mtm;
                    $zenxPrice = $row_package->point * $zenx;

                    $data = [
                        'fil' => $filPrice,
                        'mtm' => $mtmPrice,
                        'price_fil' => $filPrice,
                        'price_mtm' => $mtmPrice,
                        'price_zenx' => $zenxPrice 
                    ];

                    $update = $this->M_user->update_data_byid('package', $data, 'id', $row_package->id);
                }

                $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                                                            Success. Data has been updated.
                                                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>');
                redirect('admin/packageMining');

            }
        }
        else
        {
            redirect('auth');
        }
    }

    public function savePackageTour()
    {
        $id = $this->uri->segment(3);
        $data['user']       = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $filecoin = htmlspecialchars($this->input->post('tourfil'), true);
        $mtm      = htmlspecialchars($this->input->post('tourmtm'), true);
        $zenx     = htmlspecialchars($this->input->post('tourzenx'), true);
        $usdt     = htmlspecialchars($this->input->post('tourusdt'), true);
        
        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '1') 
        {
            $this->form_validation->set_rules('tourfil', 'Filecoin Price', 'required|numeric');
            $this->form_validation->set_rules('tourmtm', 'MTM Price', 'required|numeric');
            $this->form_validation->set_rules('tourzenx', 'Zenx Price', 'required|numeric');
            $this->form_validation->set_rules('tourusdt', 'USDT Price', 'required|numeric');

            if ($this->form_validation->run() == false) 
            {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                Failed. Failed update data 1.
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>');
                    redirect('admin/packageMining');
            }
            else
            {
                $data = [
                    'price_fil' => $filecoin,
                    'price_mtm' => $mtm,
                    'price_zenx' => $zenx, 
                    'price_usdt' => $usdt 
                ];
                
                $update = $this->M_user->update_data_byid('package_tour', $data, 'id', $id);
    
                if($update)
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-info alert-dismissible fade show" role="alert">
                                                                Success. Data has been updated.
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>');
                    redirect('admin/packageMining');
                }
                else
                {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                                Failed. Failed update data 2.
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>');
                    redirect('admin/packageMining');
                }

            }
        }
        else
        {
            redirect('auth');
        }
    }
}
