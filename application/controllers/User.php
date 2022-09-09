<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    private $arr = array();
    private $arr2 = array();
    private $arrPointL = array();
    private $arrPointR = array();
    private $arrTodayL = array();
    private $arrTodayR = array();
    private $arrPointSpon = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->library('mailer');
        $this->load->library('GoogleAuthenticator');

        $this->load->library('GoogleAuthenticator');

        $this->load->model('M_user');
        $this->load->helper(array('form', 'url'));
        
        $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
        $this->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
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

    public function index()
    {
        $this->_unset_payment();
        $dateNow = date('Y-m-d');

        //update notif
        if (!empty($this->uri->segment(3))) {
            $data_notif = [
                'is_show' => 1
            ];

            $update_notif = $this->M_user->update_data_byid('notifi', $data_notif, 'id', $this->uri->segment(3));
        }

        $data['news']               = $this->M_user->get_all_news()->row_array();
        $data['news_limit']         = $this->M_user->get_all_news_limit()->result();
        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $user_id                    = $query_user['id'] ?? null;
        $query_today                = $this->M_user->get_today_bonus($dateNow, $user_id)->row_array();
        $query_total                = $this->M_user->get_total_bonus($user_id)->row_array();
        $query_today_fill           = $this->M_user->get_data_bydate_user('mining_user', 'datecreate', 'user_id', $dateNow, $user_id)->row_array();
        $query_total_fill           = $this->M_user->get_total_byuser('mining_user', 'amount', 'user_id', $user_id);
        $query_transfer_fill        = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $user_id);
        $query_transfer_bonus_fill  = $this->M_user->get_transfer_bonus($user_id, 'filecoin');
        $query_transfer_bonus_usdt  = $this->M_user->get_transfer_bonus($user_id, 'usdt');
        $query_transfer_bonus_krp   = $this->M_user->get_transfer_bonus($user_id, 'krp');
        $query_withdrawal_fil       = $this->M_user->get_total_withdrawal($user_id, 'filecoin');
        $query_withdrawal_usdt      = $this->M_user->get_total_withdrawal($user_id, 'usdt');
        $query_withdrawal_krp       = $this->M_user->get_total_withdrawal($user_id, 'krp');

        $query_deposit_fil         = $this->M_user->get_sum_deposit($user_id, '1');
        $query_deposit_usdt        = $this->M_user->get_sum_deposit($user_id, '4');
        $query_deposit_krp        = $this->M_user->get_sum_deposit($user_id, '5');

        $query_row_notif = $this->M_user->row_newnotif_byuser($user_id);
        $query_new_notif = $this->M_user->show_newnotif_byuser($user_id);
        $query_new_notif_order = $this->M_user->show_newnotif_byuser_order($user_id);

        $query_total_purchase      = $this->M_user->sum_cart_byid($user_id);

        $data['title']            = 'My Home';
        $data['user']             = $query_user;
        $data['amount_notif']     = $query_row_notif;
        $data['list_notif']       = $query_new_notif;
        $data['list_notif_order'] = $query_new_notif_order;

        $today_sponsorusdt          = $query_today['sponsorusdt'] ?? null;
        $today_sponmatchingusdt     = $query_today['sponmatchingusdt'] ?? null;
        $today_pairingmatch_usdt    = $query_today['pairingmatchusdt'] ?? null;
        $today_minmatchingusdt      = $query_today['minmatchingusdt'] ?? null;
        $today_minpairingusdt       = $query_today['minpairingusdt'] ?? null;
        $today_binarymatch_usdt     = $query_today['binarymatchusdt'] ?? null;
        $today_bonusglobal_usdt     = $query_today['bonusglobalusdt'] ?? null;
        $today_basecamp_usdt        = $query_today['basecampusdt'] ?? null;

        $today_sponsorkrp           = $query_today['sponsorkrp'] ?? null;
        $today_sponmatchingkrp      = $query_today['sponmatchingkrp'] ?? null;
        $today_pairingmatch_krp     = $query_today['pairingmatchkrp'] ?? null;
        $today_minmatchingkrp       = $query_today['minmatchingkrp'] ?? null;
        $today_minpairingkrp        = $query_today['minpairingkrp'] ?? null;
        $today_binarymatch_krp      = $query_today['binarymatchkrp'] ?? null;
        $today_bonusglobal_krp      = $query_today['bonusglobalkrp'] ?? null;
        $today_basecamp_krp         = $query_today['basecampkrp'] ?? null;

        $total_sponsorusdt          = $query_total['sponsorusdt'] ?? null;
        $total_sponmatchingusdt     = $query_total['sponmatchingusdt'] ?? null;
        $total_pairingmatchusdt     = $query_total['pairingmatchusdt'] ?? null;
        $total_minmatchingusdt      = $query_total['minmatchingusdt'] ?? null;
        $total_minpairingusdt       = $query_total['minpairingusdt'] ?? null;
        $total_binarymatchusdt      = $query_total['binarymatchusdt'] ?? null;
        $total_globalusdt           = $query_total['bonusglobalusdt'] ?? null;
        $total_basecampusdt         = $query_total['basecampusdt'] ?? null;

        $total_sponsorkrp           = $query_total['sponsorkrp'] ?? null;
        $total_sponmatchingkrp      = $query_total['sponmatchingkrp'] ?? null;
        $total_pairingmatch_krp     = $query_total['pairingmatchkrp'] ?? null;
        $total_minmatchingkrp       = $query_total['minmatchingkrp'] ?? null;
        $total_minpairingkrp        = $query_total['minpairingkrp'] ?? null;
        $total_binarymatch_krp      = $query_total['binarymatchkrp'] ?? null;
        $total_global_krp           = $query_total['bonusglobalkrp'] ?? null;
        $total_basecampkrp          = $query_total['basecampkrp'] ?? null;

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $data['cart']                = $this->M_user->show_home_withsumpoint($user_id)->row_array();
                $data['banner1']             = $this->M_user->get_banner_home(1);
                $data['banner2']             = $this->M_user->get_banner_home(2);
                $data['today_usdt']          = $today_sponsorusdt + $today_sponmatchingusdt + $today_pairingmatch_usdt + $today_minmatchingusdt + $today_minpairingusdt + $today_binarymatch_usdt + $today_bonusglobal_usdt + $today_basecamp_usdt;
                $data['today_krp']           = $today_sponsorkrp + $today_sponmatchingkrp + $today_pairingmatch_krp + $today_minmatchingkrp + $today_minpairingusdt + $today_binarymatch_usdt + $today_bonusglobal_krp + $today_basecamp_krp;
                $data['total_usdt']          = $total_sponsorusdt + $total_sponmatchingusdt + $total_pairingmatchusdt + $total_minmatchingusdt + $total_minpairingusdt + $total_binarymatchusdt + $total_globalusdt + $total_basecampusdt;
                $data['total_krp']           = $total_sponsorkrp + $total_sponmatchingkrp + $total_pairingmatch_krp + $total_minmatchingkrp + $total_minpairingkrp + $total_binarymatch_krp + $total_global_krp + $total_basecampkrp;

                $data['balance_usdt']        = $data['total_usdt'] - $query_transfer_bonus_usdt['amount'];
                $data['balance_krp']         = $data['total_krp'] - $query_transfer_bonus_krp['amount'];
                $data['mining_fil_today']    = isset($query_today_fill['amount']) ? $query_today_fill['amount'] : 0;
                $data['mining_fil_total']    = isset($query_total_fill['amount']) ? $query_total_fill['amount'] : 0;
                $data['mining_fil_balance']  = $query_total_fill['amount'] - $query_transfer_fill['amount'];

                $data['market_price']        = $this->M_user->get_price_coin()->row_array();

                $data['general_balance_fil']    = $query_transfer_fill['amount'] + $query_transfer_bonus_fill['amount'] + $query_deposit_fil['coin'] - $query_withdrawal_fil['amount'] - $query_total_purchase['fill'];
                $data['general_balance_usdt']   = ($query_transfer_bonus_usdt['amount']) - $query_withdrawal_usdt['amount'] + $query_deposit_usdt['coin'] - $query_total_purchase['usdt'];
                $data['general_balance_krp']   = ($query_transfer_bonus_krp['amount']) - $query_withdrawal_krp['amount'] + $query_deposit_krp['coin'] - $query_total_purchase['krp'];

                $data['total_balance_fil']      = $data['mining_fil_total'] + $query_deposit_fil['coin'] - $query_total_purchase['fill'] - $query_withdrawal_fil['amount'];
                $data['total_balance_usdt']     =  $data['total_usdt']  + $query_deposit_usdt['coin'] - $query_total_purchase['usdt'] - $query_withdrawal_usdt['amount'];
                $data['total_balance_krp']      =  $data['total_krp']  + $query_deposit_krp['coin'] - $query_total_purchase['krp'] - $query_withdrawal_krp['amount'];

                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/index', $data);
                $this->load->view('templates/user_footer');
            } elseif ($this->session->userdata('role_id') == '1') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/admin_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('admin/index', $data);
                $this->load->view('templates/user_footer');
            }
        } else {
            redirect('auth');
        }
    }

    public function package()
    {
        $this->_unset_payment();

        $data['title']  = 'Package Purchase';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['package_filecoin']   = $this->M_user->show_package('1');
        $data['package_mtmcoin']    = $this->M_user->show_package('2');
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_purchase', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function packageTour()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('package_purchase');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_purchase_tour', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function packageKoreaVIP()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('package_purchase');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/vip_korea', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function packageBaliVIP()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('package_purchase');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/vip_bali', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function packageBaliVVIP()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('package_purchase');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/vvip_bali', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function packageKoreaVVIP()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('package_purchase');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/vvip_korea', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function packageKoreaGoldVVIP()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('package_purchase');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/gold_vvip_korea', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function packageBaliGoldVVIP()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('package_purchase');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/gold_vvip_bali', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function gyeongbokPalace()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('geongbok_palace');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/gyeongbok_palace', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function insadong()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('insa_dash_dong');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/insadong', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function namsanTower()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('namsan_tower');;
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/namsan_tower', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function lotteTower()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('lotte_tower');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/lotte_tower', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function observatoriumLotteTower()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('observatorium_lotte_tower');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/observatorium_lotte_tower', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    
    public function lotteWorld()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('lotte_world');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/lotte_world', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function yonginMinsokchon()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('yongin_misokchon');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/yongin_minsokchon', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function myeongdongStreet()
    {
        $this->_unset_payment();

        $data['title']  = 'Myeongdong Street';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/myeongdong_street', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    
    public function namiIsland()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('nami_island');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/nami_island', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function incheonAirport()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('incheon_airport');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/incheon_airport', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function seoulCity()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('seoul_city');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/seoul_city', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function gwk()
    {
        $this->_unset_payment();

        $data['title']  = 'GWK Park';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/gwk_park', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function padangpadangBeach()
    {
        $this->_unset_payment();

        $data['title']  = 'Padang-padang Beach';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/padang-padang_beach', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function singleFin()
    {
        $this->_unset_payment();

        $data['title']  = $this->lang->line('single_fin');
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/single_fin', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function ubudMonkeyForest()
    {
        $this->_unset_payment();

        $data['title']  = 'Ubud Monkey Forest';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/ubud_monkey_forest', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function ubudPalace()
    {
        $this->_unset_payment();

        $data['title']  = 'Ubud Palace';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/ubud_palace', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function saraswatiTemple()
    {
        $this->_unset_payment();

        $data['title']  = 'Saraswati Temple';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/saraswati_temple', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function ubudMarket()
    {
        $this->_unset_payment();

        $data['title']  = 'Ubud Market';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/ubud_market', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function tegalalangRiceTerrace()
    {
        $this->_unset_payment();

        $data['title']  = 'Tegalalang Rice Terrace';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/tegalalang_rice_terrace', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function tegenunganWaterfall()
    {
        $this->_unset_payment();

        $data['title']  = 'Tegenungan Waterfall';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/tegenungan_waterfall', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function bajraSandhi()
    {
        $this->_unset_payment();

        $data['title']  = 'Bajra Sandhi';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/bajra_sandhi', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function kutaCity()
    {
        $this->_unset_payment();

        $data['title']  = 'Kuta City';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/kuta_city', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    public function ngurahRaiAirport()
    {
        $this->_unset_payment();

        $data['title']  = 'Ngurah Rai Airport';
        $query_user     = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $data['user']   = $query_user;

        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/place/ngurah_rai_airport', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    private function _unset_payment()
    {
        $this->session->unset_userdata('purchase');
        $this->session->unset_userdata('cart');
    }

    public function fil()
    {
        $data_id        = $this->uri->segment(3);
        $data_package   = $this->M_user->get_package_byid($data_id);
        $id_package     = $data_package['id'];

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_fill = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_fill = $this->M_user->get_transfer_bonus($query_user['id'], 'filecoin');
        $query_withdrawal_fil      = $this->M_user->get_total_withdrawal($query_user['id'], 'filecoin');
        $query_transfer_mtm        = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_mtm  = $this->M_user->get_transfer_bonus($query_user['id'], 'mtm');
        $query_withdrawal_mtm      = $this->M_user->get_total_withdrawal($query_user['id'], 'mtm');
        $query_deposit_fil         = $this->M_user->get_sum_deposit($query_user['id'], '1');
        $query_deposit_mtm         = $this->M_user->get_sum_deposit($query_user['id'], '2');
        $query_deposit_zenx        = $this->M_user->get_sum_deposit($query_user['id'], '3');
        $query_total_purchase      = $this->M_user->sum_cart_byid($query_user['id']);

        $data['title']              = 'Terms and Conditions';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['general_balance_fil'] = ($query_transfer_fill['amount'] + $query_transfer_bonus_fill['amount']) - $query_withdrawal_fil['amount'] + $query_deposit_fil['coin'] - $query_total_purchase['fill'];
        $data['general_balance_mtm'] = ($query_transfer_mtm['amount'] + $query_transfer_bonus_mtm['amount']) - $query_withdrawal_mtm['amount'] + $query_deposit_mtm['coin'] - $query_total_purchase['mtm'];
        $data['general_balance_zenx'] = $query_deposit_zenx['coin'] - $query_total_purchase['zenx'];

        $this->session->set_userdata('purchase', $id_package);

        $data['fil'] = $data_package['fil'];
        $data['price_fil'] = $data_package['price_fil'];
        $data['price_mtm'] = $data_package['price_mtm'];
        $data['price_zenx'] = $data_package['price_zenx'];

        // $deposit = $this->_count_deposit($query_user['id']);

        // $data['balance'] = $deposit;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/term_condition', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function tour()
    {
        $data_id        = $this->uri->segment(3);
        $data_package   = $this->M_user->get_packagetour_byid($data_id);
        $id_package     = $data_package['id'] ?? null;

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_fill = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_fill = $this->M_user->get_transfer_bonus($query_user['id'], 'filecoin');
        $query_withdrawal_fil      = $this->M_user->get_total_withdrawal($query_user['id'], 'filecoin');
        $query_transfer_mtm        = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_mtm  = $this->M_user->get_transfer_bonus($query_user['id'], 'mtm');
        $query_withdrawal_mtm      = $this->M_user->get_total_withdrawal($query_user['id'], 'mtm');
        $query_deposit_fil         = $this->M_user->get_sum_deposit($query_user['id'], '1');
        $query_deposit_mtm         = $this->M_user->get_sum_deposit($query_user['id'], '2');
        $query_deposit_zenx        = $this->M_user->get_sum_deposit($query_user['id'], '3');
        $query_total_purchase      = $this->M_user->sum_cart_byid($query_user['id']);

        $data['title']              = $this->lang->line('term_condition');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['general_balance_fil'] = ($query_transfer_fill['amount'] + $query_transfer_bonus_fill['amount']) - $query_withdrawal_fil['amount'] + $query_deposit_fil['coin'] - $query_total_purchase['fill'];
        $data['general_balance_mtm'] = ($query_transfer_mtm['amount'] + $query_transfer_bonus_mtm['amount']) - $query_withdrawal_mtm['amount'] + $query_deposit_mtm['coin'] - $query_total_purchase['mtm'];
        $data['general_balance_zenx'] = $query_deposit_zenx['coin'] - $query_total_purchase['zenx'];
        $data['general_balance_usdt'] = 0;

        $this->session->set_userdata('purchase', $id_package);

        // $data['fil'] = $data_package['fil'];
        $data['price_fil'] = $data_package['price_fil'] ?? null;
        $data['price_mtm'] = $data_package['price_mtm'] ?? null;
        $data['price_zenx'] = $data_package['price_zenx'] ?? null;
        $data['price_usdt'] = $data_package['price_usdt'] ?? null;

        // $deposit = $this->_count_deposit($query_user['id']);

        // $data['balance'] = $deposit;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/package_tour/term_packagetour', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    // private function _count_deposit($userid)
    // {
    //     $query_deposit = $this->db->select_sum('coin')->where(['is_confirm' => 1, 'user_id' => $userid])->get('deposit')->row();
    //     $qty_deposit = $query_deposit->coin;

    //     $query_cart = $this->db->select_sum('fill')->where(['is_payment' => 1, 'user_id' => $userid])->get('cart')->row();
    //     $qty_cart = $query_cart->fill;

    //     $deposit = $qty_deposit-$qty_cart;

    //     return $deposit;
    // }

    public function cart()
    {
        $user = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($user['id']);
        $query_transfer_fill = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $user['id']);
        $query_transfer_bonus_fill = $this->M_user->get_transfer_bonus($user['id'], 'filecoin');
        $query_withdrawal_fil      = $this->M_user->get_total_withdrawal($user['id'], 'filecoin');
        $query_transfer_mtm        = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $user['id']);
        $query_transfer_bonus_mtm  = $this->M_user->get_transfer_bonus($user['id'], 'mtm');
        $query_withdrawal_mtm      = $this->M_user->get_total_withdrawal($user['id'], 'mtm');
        $query_deposit_fil         = $this->M_user->get_sum_deposit($user['id'], '1');
        $query_deposit_mtm         = $this->M_user->get_sum_deposit($user['id'], '2');
        $query_deposit_zenx        = $this->M_user->get_sum_deposit($user['id'], '3');
        $query_total_purchase      = $this->M_user->sum_cart_byid($user['id']);

        $data['title']                  = $this->lang->line('term_condition');
        $data['user']                   = $user;
        $data['amount_notif']           = $query_row_notif;
        $data['list_notif']             = $query_new_notif;
        $data['cart']                   = $this->M_user->show_home_withsumpoint($user['id'])->row_array();
        $data['general_balance_fil']    = ($query_transfer_fill['amount'] + $query_transfer_bonus_fill['amount']) - $query_withdrawal_fil['amount'] + $query_deposit_fil['coin'] - $query_total_purchase['fill'];
        $data['general_balance_mtm']    = ($query_transfer_mtm['amount'] + $query_transfer_bonus_mtm['amount']) - $query_withdrawal_mtm['amount'] + $query_deposit_mtm['coin'] - $query_total_purchase['mtm'];
        $data['general_balance_zenx']   =  $query_deposit_zenx['coin'] - $query_total_purchase['zenx'];

        // $query_deposit = $this->db->select_sum('coin')->where(['is_confirm' => 1, 'user_id' => $user['id']])->get('deposit')->row();
        // $data['balance'] = $query_deposit->coin;

        if (empty($data['cart']['name'])) {
            $this->form_validation->set_rules('sponsor', 'Recommended ID', 'required|trim', [
                'required' => $this->lang->line('require_recommended')
            ]);
            $this->form_validation->set_rules('position', 'Position ID', 'required|trim', [
                'required' => $this->lang->line('require_position')
            ]);
            $this->form_validation->set_rules('line', 'Line', 'required', [
                'required' => $this->lang->line('require_line')
            ]);
        }

        $this->form_validation->set_rules('accept_terms', '...', 'callback_accept_terms');
        $this->form_validation->set_rules('agree_term', '...', 'callback_agree_term');
        $this->form_validation->set_rules('agree_privacy', '...', 'callback_agree_privacy');

        $this->session->set_userdata('purchase', $this->input->post('data_purchase'));

        $data_package   = $this->M_user->get_package_byid($this->session->userdata('purchase'));

        $data['fil']        = $data_package['fil'];
        $data['price_fil']  = $data_package['price_fil'];
        $data['price_mtm']  = $data_package['price_mtm'];
        $data['price_zenx'] = $data_package['price_zenx'];

        //$check_matching_id = $this->db->get_where('user', ['username' => $this->input->post('matching')])->row_array();
        //$check_sponsor_id  = $this->db->get_where('user', ['username' => $this->input->post('sponsor')])->row_array();
        //$check_position_id = $this->db->get_where('user', ['username' => $this->input->post('position')])->row_array();
        //$check_belong_matching = $this->db->get_where('cart', ['user_id' => $check_sponsor_id['id']])->row_array();

        $check_sponsor_id   = $this->M_user->get_member_byusername($this->input->post('sponsor'));

        $sponsorid_notnull = $check_sponsor_id['user_id'] ?? null;

        $check_position_id  = $this->M_user->get_member_byusername($this->input->post('position'));
        $query_matching     = $this->M_user->get_mactching_id($sponsorid_notnull);

        // if (isset($_POST['buy'])) {
        //     $balance = explode(' ', trim($this->input->post('balance')))[0];
        //     $price = explode(' ', trim($this->input->post('price')))[0];
        //     var_dump($balance);
        //     var_dump($price);
        //     die;
        // }

        if ($this->form_validation->run() == false) {
            $data['checked1'] = $this->input->post('accept_terms');
            $data['checked2'] = $this->input->post('agree_term');
            $data['checked3'] = $this->input->post('agree_privacy');

            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/term_condition', $data);
            $this->load->view('templates/user_footer');
        } else {
            if (!empty($this->input->post('data_purchase'))) {
                // if($this->input->post('matching') == '' && $this->input->post('sponsor') == '' && $this->input->post('position') == '')
                // {
                //     $this->_insert_cart($this->input->post('data_purchase'), $user['id'], $this->input->post('data_fil'), '0', '0', '0', '');
                // }
                // elseif($this->input->post('matching') == '' && $this->input->post('sponsor') != '' && $this->input->post('position') != '')
                // {
                //     $check_line = $this->db->get_where('cart', ['sponsor_id' => $check_position_id['id'], 'line' => $this->input->post('line')])->row_array();

                //     if($check_line)
                //     {
                //         $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Line '.$this->input->post('line').' for this Position ID is already filled</div>');

                //         $this->load->view('templates/user_header', $data);
                //         $this->load->view('templates/user_sidebar', $data);
                //         $this->load->view('templates/user_topbar', $data);
                //         $this->load->view('user/term_condition', $data);
                //         $this->load->view('templates/user_footer');
                //     }
                //     else
                //     {
                //         $this->_insert_cart($this->input->post('data_purchase'), $user['id'], $this->input->post('data_fil'), '0', $check_sponsor_id['id'], $check_position_id['id'], $this->input->post('line'));
                //     }
                // }
                // elseif($check_matching_id['id'] == $check_position_id['id'] || $check_matching_id['id'] == $check_sponsor_id['id'])
                // {
                //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Invalid Matching ID</div>');

                //     $this->load->view('templates/user_header', $data);
                //     $this->load->view('templates/user_sidebar', $data);
                //     $this->load->view('templates/user_topbar', $data);
                //     $this->load->view('user/term_condition', $data);
                //     $this->load->view('templates/user_footer');
                // }
                // elseif($check_matching_id['id'] != $check_belong_matching['position_id'])
                // {
                //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Matching ID has no relationship with Sponsor ID</div>');

                //     $this->load->view('templates/user_header', $data);
                //     $this->load->view('templates/user_sidebar', $data);
                //     $this->load->view('templates/user_topbar', $data);
                //     $this->load->view('user/term_condition', $data);
                //     $this->load->view('templates/user_footer');
                // }
                // else
                // {
                // if($check_matching_id)
                // {

                //komentar start
                if (empty($data['cart']['name'])) {
                    if ($check_sponsor_id) {
                        if ($check_position_id) {
                            $check_line = $this->M_user->check_line($check_position_id['user_id'], $this->input->post('line'));

                            if ($check_line) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('line').' ' . $this->input->post('line') . ' '.$this->lang->line('fail_line').'</div>');

                                $this->load->view('templates/user_header', $data);
                                $this->load->view('templates/user_sidebar', $data);
                                $this->load->view('templates/user_topbar', $data);
                                $this->load->view('user/term_condition', $data);
                                $this->load->view('templates/user_footer');
                            } else {
                                if ($this->input->post('cointype') == 'fil') {
                                    $dataBalance = $data['general_balance_fil'];
                                    $dataPrice = $data['price_fil'];
                                } elseif ($this->input->post('cointype') == 'mtm') {
                                    $dataBalance = $data['general_balance_mtm'];
                                    $dataPrice = $data['price_mtm'];
                                } elseif ($this->input->post('cointype') == 'zenx') {
                                    $dataBalance = $data['general_balance_zenx'];
                                    $dataPrice = $data['price_zenx'];
                                }

                                if ($dataBalance < $dataPrice) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('fail_belance_low').'</div>');

                                    $this->load->view('templates/user_header', $data);
                                    $this->load->view('templates/user_sidebar', $data);
                                    $this->load->view('templates/user_topbar', $data);
                                    $this->load->view('user/term_condition', $data);
                                    $this->load->view('templates/user_footer');
                                } else {
                                    $this->_insert_cart($this->input->post('data_purchase'), $user['id'], $dataPrice, $query_matching['sponsor_id'], $check_sponsor_id['user_id'], $check_position_id['user_id'], $this->input->post('line'), $this->input->post('cointype'));
                                }
                            }
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('invalid_position').'</div>');

                            $this->load->view('templates/user_header', $data);
                            $this->load->view('templates/user_sidebar', $data);
                            $this->load->view('templates/user_topbar', $data);
                            $this->load->view('user/term_condition', $data);
                            $this->load->view('templates/user_footer');
                        }
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('invalid_recommended').'</div>');

                        $this->load->view('templates/user_header', $data);
                        $this->load->view('templates/user_sidebar', $data);
                        $this->load->view('templates/user_topbar', $data);
                        $this->load->view('user/term_condition', $data);
                        $this->load->view('templates/user_footer');
                    }
                } else {
                    if ($this->input->post('cointype') == 'fil') {
                        $dataBalance = $data['general_balance_fil'];
                        $dataPrice = $data['price_fil'];
                    } elseif ($this->input->post('cointype') == 'mtm') {
                        $dataBalance = $data['general_balance_mtm'];
                        $dataPrice = $data['price_mtm'];
                    } elseif ($this->input->post('cointype') == 'zenx') {
                        $dataBalance = $data['general_balance_zenx'];
                        $dataPrice = $data['price_zenx'];
                    }

                    if ($dataBalance < $dataPrice) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('low_balance').'</div>');

                        $this->load->view('templates/user_header', $data);
                        $this->load->view('templates/user_sidebar', $data);
                        $this->load->view('templates/user_topbar', $data);
                        $this->load->view('user/term_condition', $data);
                        $this->load->view('templates/user_footer');
                    } else {
                        $this->_insert_cart($this->input->post('data_purchase'), $user['id'], $dataPrice, 0, 0, 0, '', $this->input->post('cointype'));
                    }
                }

                //komentar end

                // }
                // else
                // {
                //     $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Matching ID not found</div>');

                //     $this->load->view('templates/user_header', $data);
                //     $this->load->view('templates/user_sidebar', $data);
                //     $this->load->view('templates/user_topbar', $data);
                //     $this->load->view('user/term_condition', $data);
                //     $this->load->view('templates/user_footer');
                // }
                // }
            } else {
                redirect('user/package');
            }
        }
    }

    private function _insert_cart($dataPurchase, $userId, $price, $matchingId, $sponsorId, $positionId, $line, $typeCoin)
    {
        if ($typeCoin == 'fil') {
            $data_insert = [
                'package_id' => $dataPurchase,
                'user_id' => $userId,
                'fill' => $price,
                'matching_id' => $matchingId,
                'sponsor_id' => $sponsorId,
                'position_id' => $positionId,
                'line' => $line,
                'is_payment' => 1,
                'datecreate' => time(),
                'update_date' => time()
            ];
        } elseif ($typeCoin == 'mtm') {
            $data_insert = [
                'package_id' => $dataPurchase,
                'user_id' => $userId,
                'mtm' => $price,
                'matching_id' => $matchingId,
                'sponsor_id' => $sponsorId,
                'position_id' => $positionId,
                'line' => $line,
                'is_payment' => 1,
                'datecreate' => time(),
                'update_date' => time()
            ];
        } elseif ($typeCoin == 'zenx') {
            $data_insert = [
                'package_id' => $dataPurchase,
                'user_id' => $userId,
                'zenx' => $price,
                'matching_id' => $matchingId,
                'sponsor_id' => $sponsorId,
                'position_id' => $positionId,
                'line' => $line,
                'is_payment' => 1,
                'datecreate' => time(),
                'update_date' => time()
            ];
        }

        $last_cartid = $this->M_user->insert_cart('cart', $data_insert);

        // /**Bonus sponsor */
        $bonus = $this->_sponsorBonus($last_cartid);

        // /**Level FM */
        $this->_insertFm($last_cartid);

        //Excess Bonus
        $this->_insert_Excess($userId);

        $this->session->set_userdata('cart', $last_cartid);
        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">'.$this->lang->line('success_purchase').'</div>');
        redirect('user/history');
    }
    
    private function _insert_Excess($userId)
    {
        $query_excess = $this->M_user->get_all_excess($userId);

        if(!empty($query_excess))
        {
            foreach($query_excess as $row)
            {
                $limit_bonus        = $this->_check_limit_bonus($userId, $row->mtm);
                
                $limit_count_mtm    = $limit_bonus;
                $excess_bonus       = $row->mtm - $limit_count_mtm;    
                
                //ketika limit 0 tidak jalan lagi
                if($limit_count_mtm == 0)
                {
                    break;
                }
                else
                {
                    //ketika limit tidak 0 bonus masuk, excess bonus update
                    if($row->note == 'bonus sponsor')
                    {
                        $data = [
                            'user_id' => $row->user_id,
                            'cart_id' => $row->cart_id,
                            'code_bonus' => $row->code_bonus,
                            'filecoin' => 0,
                            'mtm' => $limit_count_mtm,
                            'datecreate' => $row->datecreate
                        ];

                        $this->M_user->insert_data('bonus', $data);
                        
                        //update excess bonus
                        $this->_update_excess($excess_bonus, $row->id);
                    }
                    elseif($row->note == 'bonus sponsor matching')
                    {
                        $data = [
                            'user_id' => $row->user_id,
                            'cart_id' => $row->cart_id,
                            'code_bonus' => $row->code_bonus,
                            'filecoin' => 0,
                            'mtm' => $limit_count_mtm,
                            'datecreate' => $row->datecreate
                        ];

                        $this->M_user->insert_data('bonus_sm', $data);

                        //update excess bonus
                        $this->_update_excess($excess_bonus, $row->id);
                    }
                    elseif($row->note == 'bonus pairing')
                    {
                        $data = [
                            'user_id' => $row->user_id,
                            'mtm' => $limit_count_mtm,
                            'set_amount' => '0',
                            'datecreate' => $row->datecreate
                        ];

                        $this->M_user->insert_data('bonus_maxmatching', $data);

                        
                        $this->_update_excess($excess_bonus, $row->id);
                    }
                    elseif($row->note == 'airdrop mtm')
                    {
                        $data = [
                            'user_id' => $row->user_id,
                            'cart_id' => $row->cart_id,
                            'amount' => $limit_count_mtm,
                            'box' => $row->box,
                            'datecreate' => $row->datecreate
                        ];

                        $this->M_user->insert_data('airdrop_mtm', $data);

                        //update excess bonus
                        $this->_update_excess($excess_bonus, $row->id);
                    }
                    elseif($row->note == 'bonus pairing matching')
                    {
                        $data = [
                            'user_id' => $row->user_id,
                            'user_sponsor' => $row->user_sponsor,
                            'mtm' => $limit_count_mtm,
                            'generation' => $row->generation,
                            'datecreate' => $row->datecreate
                        ];

                        $this->M_user->insert_data('bonus_binarymatch', $data);

                        //update excess bonus
                        $this->_update_excess($excess_bonus, $row->id);
                    }
                    elseif($row->note == 'bonus global')
                    {
                        $data = [
                            'user_id' => $row->user_id,
                            'mtm' => $limit_count_mtm,
                            'level_fm' => $row->level_fm,
                            'note_level' => $row->note_level,
                            'datecreate' => $row->datecreate
                        ];

                        $this->M_user->insert_data('bonus_global', $data);

                        //update excess bonus
                        $this->_update_excess($excess_bonus, $row->id);
                    }
                    elseif($row->note == 'bonus basecamp')
                    {
                        $data = [
                            'user_id' => $row->user_id,
                            'id_bs' => $row->id_bs,
                            'cart_id' => $row->cart_id,
                            'mtm' => $limit_count_mtm,
                            'code_bonus' => $row->code_bonus,
                            'filecoin' => '0',
                            'type' => '1',
                            'status' => '1',
                            'datecreate' => $row->datecreate
                        ];

                        $this->M_user->insert_data('bonus_basecamp', $data);

                        //update excess bonus
                        $this->_update_excess($excess_bonus, $row->id);
                    }
                }
            }
            return true;  
        }
    }
    
    public function _update_excess($excess_bonus, $id)
    {
        //ketika excess bonus tidak sama dengan 0 update excess bonus
        if($excess_bonus != 0)
        {
            $data_update = [
                'mtm' => $excess_bonus
            ];

            $this->M_user->update_data_byid('excess_bonus', $data_update, 'id', $id);
        }
        else
        {
            //ketika excess = 0, update excess keterangan excess has transfer
            $data_update = [
                'mtm' => $excess_bonus,
                'note' => 'excess has transfer to bonus'
            ];

            $this->M_user->update_data_byid('excess_bonus', $data_update, 'id', $id);
        }

        return 0;
    }

    /**Add bonus sponsor */
    private function _sponsorBonus($id)
    {
        $check_bonus = $this->M_user->check_bonus_byid($id);

        if ($check_bonus) {
            return false;
        } else {
            $datapayment    = $this->M_user->get_bonus_amount($id);
            $user_id        = $datapayment['user_id'] ?? null;

            $id_bs_user     = $datapayment['id_basecamp'] ?? null;
            
            $query_top_user = $this->M_user->get_cart_notnullsponsor($user_id);
            $sponsor_id     = $query_top_user['sponsor_id'] ?? null;
            $matching_id    = $query_top_user['matching_id'] ?? null;
            
            $query_bs_sponsor = $this->M_user->get_basecampid_byuser($sponsor_id);
            
            $id_bs_sponsor = $query_bs_sponsor['id_basecamp'] ?? null;

            if ($datapayment['price'] != 0) {
                $count_bonus    = ($datapayment['price'] * $datapayment['amount_sp']) / 100;
                // $query_basecamp = $this->M_user->get_camp_fm($sponsor_id);

                if ($matching_id == 0) {
                    $count_sponsor  = $count_bonus / 2;
                    $count_mtm      = $count_sponsor * 4;

                    $limit_bonus        = $this->_check_limit_bonus($sponsor_id, $count_mtm);

                    $excess_bonus       = $count_mtm - $limit_bonus;

                    $limit_count_mtm    = $limit_bonus;

                    $data_excess_sponsor = [
                        'user_id' => $sponsor_id,
                        'type_bonus' => '1',
                        'mtm' => $excess_bonus,
                        'cart_id' => $id,
                        'code_bonus' => $datapayment['code'],
                        'user_sponsor' => '0',
                        'generation' => '0',
                        'note' => 'bonus sponsor',
                        'datecreate' => time()
                    ];

                    $this->M_user->insert_data('excess_bonus', $data_excess_sponsor);

                    $data_insert = [
                        'cart_id' => $id,
                        'user_id' => $sponsor_id,
                        'code_bonus' => $datapayment['code'],
                        'filecoin' => $count_sponsor,
                        'mtm' => $limit_count_mtm,
                        'datecreate' => time()
                    ];

                    $insert = $this->M_user->insert_data('bonus', $data_insert);

                    if ($insert) 
                    {
                        if($id_bs_sponsor == $id_bs_user)
                        {
                            $query_leader   = $this->M_user->get_leader_bybs($id_bs_sponsor);
                            $leader_id      = $query_leader['user_id'];

                            $query_basecamp = $this->M_user->get_camp_fm($leader_id);
    
                            if (!empty($leader_id)) {
                                if ($query_basecamp['fm'] == 'FM5') {
                                    $additionalBonus = 2;
                                } elseif ($query_basecamp['fm'] == 'FM6') {
                                    $additionalBonus = 2.5;
                                } elseif ($query_basecamp['fm'] == 'FM7') {
                                    $additionalBonus = 3;
                                } elseif ($query_basecamp['fm'] == 'FM8') {
                                    $additionalBonus = 3.5;
                                }
    
                                $count_bonus_basecamp = ($datapayment['price'] * $additionalBonus) / 100;
    
                                $bonus_basecamp_mtm = $count_bonus_basecamp * 4;
                                
                                $data_insert_basecamp = [
                                    'cart_id' => $id,
                                    'user_id' => $leader_id,
                                    'id_bs' => $id_bs_sponsor,
                                    'code_bonus' => $datapayment['code'],
                                    'mtm' => $bonus_basecamp_mtm,
                                    'type' => '1',
                                    'status' => '0',
                                    'datecreate' => time()
                                ];
    
                                $insert_basecamp = $this->M_user->insert_data('bonus_basecamp', $data_insert_basecamp);
                                
                            }
                        }

                        return true;
                    } else {
                        return false;
                    }
                } else {
                    $count_sponsor_matching = (($count_bonus * $datapayment['amount_sm']) / 100) / 2;
                    $count_sm_mtm           = $count_sponsor_matching * 4;

                    $count_sponsor          = ($count_bonus) / 2;
                    $count_mtm              = $count_sponsor * 4;

                    $limit_bonus    = $this->_check_limit_bonus($sponsor_id, $count_mtm);

                    $excess_bonus  = $count_mtm - $limit_bonus;

                    $data_excess_sponsor = [
                        'user_id' => $sponsor_id,
                        'type_bonus' => '1',
                        'mtm' => $excess_bonus,
                        'cart_id' => $id,
                        'code_bonus' => $datapayment['code'],
                        'user_sponsor' => '0',
                        'generation' => '0',
                        'note' => 'bonus sponsor',
                        'datecreate' => time()
                    ];

                    $this->M_user->insert_data('excess_bonus', $data_excess_sponsor);

                    $limit_count_mtm = $limit_bonus;

                    $data_insert = [
                        'cart_id' => $id,
                        'user_id' => $sponsor_id,
                        'code_bonus' => $datapayment['code'],
                        'filecoin' => $count_sponsor,
                        'mtm' => $limit_count_mtm,
                        'datecreate' => time()
                    ];

                    $insert = $this->M_user->insert_data('bonus', $data_insert);

                    if ($insert) 
                    {
                        $limit_bonus_sm    = $this->_check_limit_bonus($matching_id, $count_sm_mtm);
                        $excess_bonus_sm = $count_sm_mtm - $limit_bonus_sm;

                        $limit_count_sm_mtm = $limit_bonus_sm;

                        $data_excess_sm = [
                            'user_id' => $matching_id,
                            'type_bonus' => '2',
                            'mtm' => $excess_bonus_sm,
                            'cart_id' => $id,
                            'code_bonus' => $datapayment['code'],
                            'user_sponsor' => '0',
                            'generation' => '0',
                            'note' => 'bonus sponsor matching',
                            'datecreate' => time()
                        ];

                        $insert = $this->M_user->insert_data('excess_bonus', $data_excess_sm);

                        $data_sm = [
                            'user_id' => $matching_id,
                            'cart_id' => $id,
                            'code_bonus' => $datapayment['code'],
                            'filecoin' => $count_sponsor_matching,
                            'mtm' => $limit_count_sm_mtm,
                            'datecreate' => time()
                        ];

                        $insert_bonus_sm = $this->M_user->insert_data('bonus_sm', $data_sm);

                        if ($insert_bonus_sm) 
                        {
                            if($id_bs_sponsor == $id_bs_user)
                            {
                                $query_leader   = $this->M_user->get_leader_bybs($id_bs_sponsor);
                                $leader_id      = $query_leader['user_id'];

                                $query_basecamp = $this->M_user->get_camp_fm($leader_id);

                                if (!empty($leader_id)) 
                                {
    
                                    if ($query_basecamp['fm'] == 'FM5') {
                                        $additionalBonus = 2;
                                    } elseif ($query_basecamp['fm'] == 'FM6') {
                                        $additionalBonus = 2.5;
                                    } elseif ($query_basecamp['fm'] == 'FM7') {
                                        $additionalBonus = 3;
                                    } elseif ($query_basecamp['fm'] == 'FM8') {
                                        $additionalBonus = 3.5;
                                    }
    
                                    $count_bonus_basecamp = ($datapayment['price'] * $additionalBonus) / 100;
    
                                    $bonus_basecamp_mtm = $count_bonus_basecamp * 4;
                                    
                                    $data_insert_basecamp = [
                                        'cart_id' => $id,
                                        'user_id' => $leader_id,
                                        'id_bs' => $id_bs_sponsor,
                                        'code_bonus' => $datapayment['code'],
                                        'mtm' => $bonus_basecamp_mtm,
                                        'type' => '1',
                                        'status' => '0',
                                        'datecreate' => time()
                                    ];
    
                                    $insert_basecamp = $this->M_user->insert_data('bonus_basecamp', $data_insert_basecamp);
                                }
                            }

                            return true;
                        }
                    } else {
                        return false;
                    }
                }
            }
        }
    }

    private function _check_limit_bonus($user_id, $count_mtm)
    {
        $query_top = $this->M_user->get_user_toplevel($user_id);
        $user_top = $query_top['id'] ?? null;

        if($user_id == $user_top)
        {
            return $count_mtm;
        }
        else
        {
            $query_box      = $this->M_user->get_totalbox_byid($user_id);
            $query_total    = $this->M_user->get_total_bonus($user_id)->row_array();
            $query_airdrop  = $this->M_user->sum_airdrop_byuser($user_id); 
    
            $box    = $query_box['mtm'];
            $limit  = ($box*300)/100;
    
            $total_bonus = $query_airdrop['amount']+$query_total['sponsormtm']+$query_total['sponmatchingmtm']+$query_total['pairingmatch']+$query_total['binarymatch']+$query_total['bonusglobal']+$query_total['basecampmtm']+$count_mtm;
            
            if($total_bonus <= $limit)
            {
                return $count_mtm;
            }
            else
            {
                $total_now = $total_bonus - $count_mtm;
    
                if($total_now < $limit)
                {
                    $bonus_new = $limit - $total_now;
    
                    if($bonus_new < $count_mtm)
                    {
                        $result = $bonus_new;
                    }
                    else
                    {
                        $result = $count_mtm;
                    }
                }
                else
                {
                    $result = 0;
                }
    
                return $result;
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

        $check_data = $this->M_user->get_data_byid('level_fm', 'user_id', $data_user['user_id']);

        if (empty($check_data['id'])) {
            $insert     = $this->M_user->insert_data('level_fm', $data_insert);
            return true;
        } else {
            return true;
        }
    }

    public function payment()
    {
        if (!empty($this->uri->segment(4))) {
            $this->M_user->update_data_byid('notifi', ['is_show' => 1], 'id', $this->uri->segment(4));
        }

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['user']               = $query_user;
        $data['title']              = 'Package Payment';

        if (!empty($this->uri->segment(3))) {
            $data['cart_pay']               = $this->M_user->get_cart_byid($this->uri->segment(3));
            $this->session->set_userdata('cart', $this->uri->segment(3));
        } else {
            $data['cart_pay']               = $this->M_user->get_cart_byid($this->session->userdata('cart'));
        }

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        $this->form_validation->set_rules('txid', 'TXID', 'required|is_unique[txid.txid]', [
            'is_unique' => 'TXID not valid'
        ]);

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            if (!empty($this->session->userdata('cart'))) {
                if ($this->form_validation->run() == false) {
                    $this->load->library('ciqrcode');
                    $config['cacheable']    = true;
                    $config['cachedir']     = 'assets/';
                    $config['errorlog']     = 'assets/';
                    $config['imagedir']     = 'assets/img/';
                    $config['quality']      = true;
                    $config['size']         = '1024';
                    $config['black']        = array(224, 255, 255);
                    $config['white']        = array(70, 130, 180);
                    $this->ciqrcode->initialize($config);

                    $image_name = 'new_qrcode.png';

                    $params['data'] = 'f1fzgcduywwfq7dqkahiwztsbdzv3g6j2hxjhgzey';
                    $params['level'] = 'H';
                    $params['size'] = 10;
                    $params['savename'] = FCPATH . $config['imagedir'] . $image_name;
                    $this->ciqrcode->generate($params);

                    $this->load->view('templates/user_header', $data);
                    $this->load->view('templates/user_sidebar', $data);
                    $this->load->view('templates/user_topbar', $data);
                    $this->load->view('user/payment', $data);
                    $this->load->view('templates/user_footer');
                } else {
                    $txid    = $this->input->post('txid', true);
                    $cartid  = $this->input->post('cartid', true);

                    $data_txid = [
                        'cart_id'       => $cartid,
                        'txid'          => $txid,
                        'datecreate'    => time(),
                    ];

                    $insert = $this->M_user->insert_data('txid', $data_txid);

                    if ($insert) {
                        $update_cart = $this->M_user->update_payment('3', $cartid);

                        if ($update_cart) {
                            $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">Success! Your payment has been received, wait for the payment to be confirmed!</div>');
                            redirect('user/history');
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Failed! Failed to save your payment!</div>');
                            redirect('user/history');
                        }
                    } else {
                        redirect('user/payment');
                    }
                }
            } else {
                redirect('user/package');
            }
        } else {
            redirect('auth');
        }
    }

    public function cancelPayment()
    {
        if (!empty($this->session->userdata('cart'))) {
            $this->M_user->update_payment_status('2', $this->session->userdata('cart'));

            redirect('user/package');
        } else {
            redirect('user/package');
        }
    }

    public function accept_terms()
    {
        if (isset($_POST['accept_terms'])) return true;
        $this->form_validation->set_message('accept_terms', $this->lang->line('calback_accept_term'));
        return false;
    }

    public function agree_term()
    {
        if (isset($_POST['agree_term'])) return true;
        $this->form_validation->set_message('agree_term', $this->lang->line('calback_agree_term'));
        return false;
    }

    public function agree_privacy()
    {
        if (isset($_POST['agree_privacy'])) return true;
        $this->form_validation->set_message('agree_privacy', $this->lang->line('calback_agree_policy'));
        return false;
    }

    public function history()
    {
        if (!empty($this->uri->segment(3))) {
            $this->M_user->update_data_byid('notifi', ['is_show' => 1], 'id', $this->uri->segment(3));
        }

        $user = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($user['id']);

        $data['user']               = $user;
        $data['title']              = $this->lang->line('payment_history');;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($user['id'])->row_array();
        $data['payment']            = $this->M_user->show_cart_byid($user['id']);
        $datacart_updatedate        = $data['cart']['update_date'] ?? null;

        $mining_payment = date('Y-m-d', $datacart_updatedate);

        $date_fil = new DateTime($mining_payment);
        $date_fil->modify('45 days');
        $data['fil_startpayment'] = $date_fil->format('d/m/Y');
        $date_fil->modify('1100 days');
        $data['fil_endpayment'] = $date_fil->format('d/m/Y');

        $date_mtm = new DateTime($mining_payment);
        $date_mtm->modify('1 week');
        $data['mtm_startpayment'] = $date_mtm->format('d/m/Y');
        $date_mtm->modify('540 days');
        $data['mtm_endpayment'] = $date_mtm->format('d/m/Y');

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/payment_history', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function deposit()
    {
        $user               = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $query_row_notif    = $this->M_user->row_newnotif_byuser($user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($user['id']);

        $data['user']               = $user;
        $data['title']              = $this->lang->line('deposit');
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($user['id'])->row_array();
        $data['wallet_address']     = $this->M_user->walletAddress()->row_array();

        if (!empty($this->uri->segment(4))) {
            $data['id_deposit']       = $this->uri->segment(4);
            $data['id_notif']         = $this->uri->segment(5);
        } else {
            $data['id_deposit']       = '';
            $data['id_notif']         = '';
        }

        $this->form_validation->set_rules('txid', 'TXID', 'required|trim|is_unique[deposit.txid]', [
            'required' => $this->lang->line('require_txid'),
            'is_unique' => $this->lang->line('is_unique_txid')
        ]);
        $this->form_validation->set_rules('coinqty', 'Coin quantity', 'required|numeric', [
            'required' => $this->lang->line('require_coin'),
            'numeric' => $this->lang->line('numeric_coin')
        ]);

        if ($this->uri->segment(3) == '2') {
            $data['currentTab'] = 'mtm';
        } elseif ($this->uri->segment(3) == '3') {
            $data['currentTab'] = 'zenx';
        } else {
            $data['currentTab'] = 'fil';
        }

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            if ($this->form_validation->run() == false) //check validation
            {
                $this->load->library('ciqrcode');
                $config['cacheable']    = true;
                $config['cachedir']     = 'assets/';
                $config['errorlog']     = 'assets/';
                $config['imagedir']     = 'assets/img/';
                $config['quality']      = true;
                $config['size']         = '1024';
                $config['black']        = array(224, 255, 255);
                $config['white']        = array(70, 130, 180);
                $this->ciqrcode->initialize($config);

                $image_name     = 'wallet_fil_qr.png';
                $image_name2    = 'wallet_mtm_qr.png';
                $image_name3    = 'wallet_zenx_qr.png';

                $params['data'] = $data['wallet_address']['filecoin'];
                $params['level'] = 'H';
                $params['size'] = 10;
                $params['savename'] = FCPATH . $config['imagedir'] . $image_name;
                $this->ciqrcode->generate($params);

                $params2['data'] = $data['wallet_address']['mtm'];
                $params2['level'] = 'H';
                $params2['size'] = 10;
                $params2['savename'] = FCPATH . $config['imagedir'] . $image_name2;
                $this->ciqrcode->generate($params2);

                $params3['data'] = $data['wallet_address']['zenx'];
                $params3['level'] = 'H';
                $params3['size'] = 10;
                $params3['savename'] = FCPATH . $config['imagedir'] . $image_name3;
                $this->ciqrcode->generate($params3);


                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/deposit', $data);
                $this->load->view('templates/user_footer');
            } else {
                if (!empty($this->input->post('iddeposit'))) 
                {
                    $txid       = htmlspecialchars($this->input->post('txid', true));
                    $coin       = htmlspecialchars($this->input->post('coinqty', true));

                    $config = array(
                        'upload_path' => "assets/deposit/",
                        'file_name' => $txid,
                        'allowed_types' => "gif|jpg|png|jpeg|pdf",
                        'overwrite' => TRUE,
                        'max_size' => "2048" // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    );

                    $this->load->library('upload', $config);

                    if($this->upload->do_upload())
                    {
                        $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                        $filename    = $upload_data['file_name'];
    
                        //update deposit
                        $data_update = [
                            'txid' => $txid,
                            'coin' => $coin,
                            'image' => $filename,
                            'note' => ''
                        ];
    
                        $update_cart = $this->M_user->update_data_byid('deposit', $data_update, 'id', $this->input->post('iddeposit'));
    
                        //update notification
                        $data_notif = [
                            'is_show' => 1
                        ];
    
                        $update_notif = $this->M_user->update_data_byid('notifi', $data_notif, 'id', $this->input->post('id_notif'));
    
                        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">'.$this->lang->line('success_deposit').'</div>');
                        redirect('user/deposit');
                    }
                    else
                    {
                        //update deposit
                        $data_update = [
                            'txid' => $txid,
                            'coin' => $coin,
                            'note' => ''
                        ];
    
                        $update_cart = $this->M_user->update_data_byid('deposit', $data_update, 'id', $this->input->post('iddeposit'));
    
                        //update notification
                        $data_notif = [
                            'is_show' => 1
                        ];
    
                        $update_notif = $this->M_user->update_data_byid('notifi', $data_notif, 'id', $this->input->post('id_notif'));
    
                        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">'.$this->lang->line('success_deposit').'</div>');
                        redirect('user/deposit');
                    }
                } else {
                    $txid       = htmlspecialchars($this->input->post('txid', true));
                    $coin       = htmlspecialchars($this->input->post('coinqty', true));
                    $typeCoin   = htmlspecialchars($this->input->post('typecoin', true)); 

                    //upload image
                    $config = array(
                        'upload_path' => "assets/deposit/",
                        'file_name' => $txid,
                        'allowed_types' => "gif|jpg|png|jpeg|pdf",
                        'overwrite' => TRUE,
                        'max_size' => "2048" // Can be set to particular file size , here it is 2 MB(2048 Kb)
                    );

                    $this->load->library('upload', $config);

                    if($this->upload->do_upload())
                    {
                        $upload_data = $this->upload->data(); //Returns array of containing all of the data related to the file you uploaded.
                        $filename    = $upload_data['file_name'];

                        //insert deposit
                        $data_insert = [
                            'user_id' => $user['id'],
                            'txid' => $txid,
                            'coin' => $coin,
                            'type_coin' => $typeCoin,
                            'image' => $filename,
                            'datecreate' => time()
                        ];
    
                        $this->db->insert('deposit', $data_insert);
    
                        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">'.$this->lang->line('success_deposit_create').'</div>');
                        redirect('user/deposit');
                    }
                    else
                    {
                        //insert deposit
                        $data_insert = [
                            'user_id' => $user['id'],
                            'txid' => $txid,
                            'coin' => $coin,
                            'type_coin' => $typeCoin,
                            'image' => $filename,
                            'datecreate' => time()
                        ];
    
                        $this->db->insert('deposit', $data_insert);
    
                        $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">'.$this->lang->line('success_deposit_create').'</div>');
                        redirect('user/deposit');
                    }

                }
            }
        } else {
            redirect('auth');
        }
    }

    public function bonusList()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = $this->lang->line('bonus');
        $data['user']               = $query_user;
        $data['userClass']          = $this;

        $query_airdrops      = $this->M_user->show_all_byid($query_user['id'], 'airdrop_mtm', 'user_id');
        $query_sum_air       = $this->M_user->get_total_byuser('airdrop_mtm', 'amount', 'user_id', $query_user['id']);
        $query_transfer      = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_list = $this->M_user->get_transfer_list('airdrop_mtm_transfer', 'datecreate', $query_user['id'], 'DESC')->result();

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['airdrops']           = $query_airdrops;
        $data['transfer_list']      = $query_transfer_list;
        $data['balance']            = $query_sum_air['amount'] - $query_transfer['amount'];
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        $query_mining        = $this->M_user->show_all_byid($query_user['id'], 'mining_user', 'user_id');
        $query_total         = $this->M_user->get_total_byuser('mining_user', 'amount', 'user_id', $query_user['id']);
        $query_transfer_fil      = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_list_fil = $this->M_user->get_transfer_list('mining_user_transfer', 'datecreate', $query_user['id'], 'DESC')->result();

        $data['list_mining']        = $query_mining;
        $data['transfer_list']      = $query_transfer_list_fil;
        $data['balance_mining']     = $query_total['amount'] - $query_transfer_fil['amount'];

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/bonus/index', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
        } else {
            redirect('auth');
        }
    }

    //Bonus Sponsor 
    public function sponsor()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_bonus_sponsor_byid($query_user['id']);
        $query_total_excess = $this->M_user->get_total_excess_byid($query_user['id'], 'bonus sponsor');

        $data['title']              = $this->lang->line('recommended');
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['excess_bonus']       = $this->M_user->get_excess_sponsor($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total_excess']       = $query_total_excess['mtm'];
        $data['total_fil']          = $query_total['filecoin'];
        $data['total_mtm']          = $query_total['mtm'];
        $data['userClass']          = $this;

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/bonus/sponsor', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
        } else {
            redirect('auth');
        }
    }

    public function sponsorMatching()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_bonus_sponsormatch_byid($query_user['id']);
        $query_total_excess = $this->M_user->get_total_excess_byid($query_user['id'], 'bonus sponsor matching');

        $data['title']              = $this->lang->line('recommended_matching');
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsormatching($query_user['id']);
        $data['excess_bonus']       = $this->M_user->get_excess_sponsor_matching($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['total_excess']       = $query_total_excess['mtm'];
        $data['total_fil']          = $query_total['filecoin'];
        $data['total_mtm']          = $query_total['mtm'];
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/bonus/sponsor_matching', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
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

    public function network()
    {
        $this->_unset_payment();

        $data['title'] = $this->lang->line('network');

        if ($this->uri->segment(3) != '') 
        {
            $id = $this->uri->segment(3);

            $query_user    = $this->M_user->get_user_byid($id);
        } 
        else 
        {
            $query_user    = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        }

        $limitLevel     = $this->_countLimitLevel(0, $query_user['id']);

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

        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['network']            = $this->_showNetwork($query_user['id'], $query_user['country_code'], $query_user['username']);
        $sidebar['user']            = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['limitLevel']         = $limitLevel;

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/network', $data);
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
        // $increaseLeft   = $this->countPositionL($id) - $this->increasePoint($id, 'L');
        // $increaseRight  = $this->countPositionR($id) - $this->increasePoint($id, 'R');

        $pointTodayL    = $this->countPointTodayL($id);
        $pointTodayR    = $this->countPointTodayR($id);
        $idLeft         = $this->countIDL($id);
        $idRight        = $this->countIDR($id);
        $package_fm     = $package['fm'] ?? null;
        $package_name   = $query_box['point'] ?? null;
        $package_color  = $this->_color_network($package_name);

        if ($balancePoint) {
            // $balance_a = $balancePoint['amount_left'] + $increaseLeft;
            // $balance_b = $balancePoint['amount_right'] + $increaseRight;
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
                            <h1 class="text-uppercase name-network">' . strtolower($username) . '</h1>
                            <p>' . $package_fm . '</p>
                            <div class="d-flex  justify-content-center align-content-center align-items-center position-relative">
                                <div class="text-right">
                                    <p>(' . $idLeft . ' ID) '.$this->lang->line('left').'</p>
                                    <p style="color:' . $package_color . '">' . $balance_a . '&nbsp;(' . $this->countPositionL($id) . ')</p>
                                    <p>'.$this->lang->line('increase').'</p>
                                    <p style="color:' . $package_color . '">+ ' . $pointTodayL . '</p>
                                </div>
                                <div class="line"></div>
                                <div class="text-left">
                                    <p>'.$this->lang->line('right').' (' . $idRight . ' ID)</p>
                                    <p style="color: ' . $package_color . '">' . $balance_b . '&nbsp;(' . $this->countPositionR($id) . ')</p>
                                    <p>'.$this->lang->line('increase').'</p>
                                    <p style="color: ' . $package_color . '">+ ' . $pointTodayR . '</p>
                                </div>
                            </div>
                            <p class="box-network text-white text-uppercase" style="background-color:' . $package_color . '">' . $package_name . ' '.$this->lang->line('box').'</p>

                            <button id="'.$id.'" onClick="reply_click_net(this.id)" class="charetnet">
                                <i class="fas fa-caret-down"></i>
                            </button>
                        </div>';
            
        $output .= '<div id="result'.$id.'" class="hideNetwork"></div>';

        $output .=    '</li>';
        $output .=  '</ul>';

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
                                            <p>(' . $idLeft . ' ID) '.$this->lang->line('left').'</p>
                                            <p style="color:' . $package_color . '">' . $balance_a . '&nbsp;(' . $countLeft . ')</p>
                                            <p>'.$this->lang->line('increase').'</p>
                                            <p style="color:' . $package_color . '">+ ' . $pointTodayL . '</p>
                                        </div>
                                        <div class="line"></div>
                                        <div class="text-left">
                                            <p>'.$this->lang->line('right').' (' . $idRight . ' ID)</p>
                                            <p style="color:' . $package_color . '">' . $balance_b . '&nbsp;(' . $countRight . ')</p>
                                            <p>'.$this->lang->line('increase').'</p>
                                            <p style="color:' . $package_color . '">+ ' . $pointTodayR . '</p>
                                        </div>
                                    </div>';

                $query_position_bottom = $this->M_user->get_network_byposition($row_position->user_id);

                if(count($query_position_bottom) != '')
                {
                    $output .= '<p class="box-network text-white" style="background-color:' . $package_color . '">' . $package_name . ' '.$this->lang->line('box').'</p>
                                        <button id="'.$row_position->user_id.'" onClick="reply_click_net(this.id)" class="charetnet">
                                            <i class="fas fa-caret-up"></i>
                                        </button>
                                    </div>';
                        
                    $output .= '<div id="result'.$row_position->user_id.'" class="displayNetwork">';
                    
                    $output .= $this->_loopingNetwork(1, $endLoop, $row_position->user_id);
                    
                    $output .= '</div>';
                }
                else
                {
                    $output .= '<p class="box-network text-white" style="background-color:' . $package_color . '">' . $package_name . ' '.$this->lang->line('box').'</p>
                                        <button id="'.$row_position->user_id.'" onClick="reply_click_net(this.id)" class="charetnet">
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

    private function _loopingNetwork($firstLoop, $endLoop, $user_id)
    {
        if($firstLoop > $endLoop)
        {
            return false;
        }

        $query_position = $this->M_user->get_network_byposition($user_id);

        $output = '';

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
                                            <p>(' . $idLeft . ' ID) '.$this->lang->line('left').'</p>
                                            <p style="color:' . $package_color . '">' . $balance_a . '&nbsp;(' . $countLeft . ')</p>
                                            <p>'.$this->lang->line('increase').'</p>
                                            <p style="color:' . $package_color . '">+ ' . $pointTodayL . '</p>
                                        </div>
                                        <div class="line"></div>
                                        <div class="text-left">
                                            <p>'.$this->lang->line('right').' (' . $idRight . ' ID)</p>
                                            <p style="color:' . $package_color . '">' . $balance_b . '&nbsp;(' . $countRight . ')</p>
                                            <p>'.$this->lang->line('increase').'</p>
                                            <p style="color:' . $package_color . '">+ ' . $pointTodayR . '</p>
                                        </div>
                                    </div>';

                $query_position_bottom = $this->M_user->get_network_byposition($row_position->user_id);

                if(count($query_position_bottom) != '')
                {
                    $output .=      '<p class="box-network text-white" style="background-color:' . $package_color . '">' . $package_name . ' '.$this->lang->line('box').'</p>
                                        <button id="'.$row_position->user_id.'" onClick="reply_click_net(this.id)" class="charetnet">
                                            <i class="fas fa-caret-down"></i>
                                        </button>
                                    </div>';
                }
                else
                {
                    
                    $output .=      '<p class="box-network text-white" style="background-color:' . $package_color . '">' . $package_name . ' '.$this->lang->line('box').'</p>
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

                $output .= '</li>';
            }

            $output .= '</ul>';
        }

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

    //count limit level sponsor
    public function _countLimitLevelSponsor($endLoop, $user_id)
    {
        $query_position = $this->M_user->get_sponsor_member1($user_id);
        
        if (count($query_position) != '') 
        {
            foreach ($query_position as $row_position) 
            {
                return $this->_countLimitLevelSponsor($endLoop+1, $row_position->user_id);
            }
        }
        else
        {
            return $endLoop;
        }
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


    public function balance_point($userid)
    {
        //$query = $this->M_user->balance_now($userid)->row_array();
        $query = $this->M_user->balance_now_nol($userid)->row_array();
        return $query;
    }

    public function increasePoint($userid, $position)
    {
        // $query_poin = $this->M_user->secondlast_balance($userid);
        // $getAmount = $query_poin['set_amount'];

        // $query_cutPoint = $this->M_user->sum_leftover($userid);
        // $cutPointLeft = $query_cutPoint['amount_left'];
        // $cutPointRight = $query_cutPoint['amount_right'];

        // $increasePointLeft = $cutPointLeft+$getAmount;
        // $increasePointRight = $cutPointRight+$getAmount;

        $query_set =  $this->M_user->sum_balance($userid);

        if ($query_set) {
            $total_set = $query_set['set_amount'];
        } else {
            $total_set = 0;
        }

        $query_balance_now = $this->M_user->balance_now($userid)->row_array();

        if ($query_balance_now) {
            $balance_now_left = $query_balance_now['amount_left'];
            $balance_now_right = $query_balance_now['amount_right'];
        } else {
            $balance_now_left = 0;
            $balance_now_right = 0;
        }

        $total_before_left = $total_set + $balance_now_left;
        $total_before_right = $total_set + $balance_now_right;

        if ($position == 'L') {
            return $total_before_left;
        } else {
            return $total_before_right;
        }
    }

    public function showLine($id)
    {
        $query_line = $this->M_user->get_network_byposition($id);

        return json_decode(json_encode($query_line), true);
    }

    public function sponsornet()
    {
        $this->_unset_payment();

        $data['title'] = $this->lang->line('recommended');

        if ($this->uri->segment(3) != '') {
            $id = $this->uri->segment(3);

            $query_user = $this->M_user->get_user_byid($id);
        } else {
            $query_user = $this->M_user->get_user_byemail($this->session->userdata('email'));
        }

        $limitLevel     = $this->_countLimitLevelSponsor(0, $query_user['id']);

        $idLeft         = $this->countIDL($query_user['id'] ?? null);
        $idRight        = $this->countIDR($query_user['id'] ?? null);

        if ($idLeft and $idRight >= 100) {
            $scale = '0.2';
        } elseif ($idLeft and $idRight >= 5 && $idLeft and $idRight < 100) {
            $scale = '0.6';
        } else {
            $scale = '1';
        }
        $data['scale'] = $scale;

        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id'] ?? null);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_row_team     = $this->M_user->row_data_byuser('cart', 'sponsor_id', $query_user['id']);

        $data['user']           = $query_user;
        $data['cart']           = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['amount_notif']   = $query_row_notif;
        $data['list_notif']     = $query_new_notif;
        $data['sponsor']        = $this->_showSponsor($query_user['id'], $query_user['country_code'], $query_user['username']);
        $data['limitLevel']     = $limitLevel;

        $sidebar['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        //$sidebar['cart'] = $this->M_user->show_data_home($sidebar['user']['id'])->row_array();

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/sponsornet', $data);
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

        $output = '';

        $output .= '<ul>';
        $output .=    '<li class="maindiv" style="overflow: hidden;">';
        $output .=    '<div class="item" style="border: 7px solid ' . $package_color . '">
                            <img class="flag-network" src="' . base_url('assets/img/') . $this->flag($countryCode) . '" alt="" width="40px">
                            <h1 class="text-uppercase name-network" id="'.strtolower($username).'">' . strtolower($username) . '</h1>
                            <div class="d-flex justify-content-center align-content-center align-items-center text-center position-relative my-2">
                                <img src="' . base_url('assets/img/') . $this->box($package_name) . '" alt="#" height="90px">
                                <p style="position: absolute; bottom:10px">'.$this->lang->line('me').'</p>
                            </div>
                            <p class="box-network text-white text-uppercase" style="background-color: ' . $package_color . '">' . $package_name . ' '.$this->lang->line('box').'</p>
                            <button id="'.$id.'" onClick="reply_click_user(this.id)" class="charetnet">
                                <i class="fas fa-caret-down"></i>
                            </button>
                        </div>';

            $output .= '<div id="result'.$id.'" class="hideNetwork"></div>';
        $output .=    '</li>';
        $output .=  '</ul>';

        return $output;
    }
    
    public function showSponsorBottom()
    {
        $id             = $this->input->post('user');
        $level          = $this->input->post('level');
        $query_sponsor  = $this->M_user->get_sponsor_member1($id);

        if(empty($level))
        {
            $endLoop = 0;
        }
        else
        {
            $endLoop        = $level - 1;
        }

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
                                    <h1 class="text-uppercase name-network" id="'.strtolower($row_sponsor->username).'">' . strtolower($row_sponsor->username) . '</h1>
                                    <div class="d-flex justify-content-center align-content-center align-items-center text-center position-relative my-2">
                                        <img src="' . base_url('assets/img/') . $this->box($package_name) . '" alt="#" height="90px">
                                        <p style="position: absolute;bottom: 57px;">' . $row_sponsor->fm . '</p>
                                        <p style="position: absolute; bottom:10px">' . $team . '</p>
                                    </div>
                                    <p class="box-network text-white text-uppercase" style="background-color:' . $package_color . '">' . $package_name . ' '.$this->lang->line('box').'</p>';

                $query_position_bottom = $this->M_user->get_sponsor_member1($row_sponsor->user_id);

                if(count($query_position_bottom) != '')
                {
                    $output .= '<button id="'.$row_sponsor->user_id.'" onClick="reply_click_user(this.id)" class="charetnet">
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </div>';

                    $output .= '<div id="result'.$row_sponsor->user_id.'" class="displayNetwork">';
    
                    $output .= $this->_loopingSponsor(1, $endLoop, $row_sponsor->user_id);
                }

                $output .= '</div>';   

                $output .= '</li>';
            }

            $output .= '</ul>';
        }

        echo $output;
    }

    private function _loopingSponsor($firstLoop, $endLoop, $id)
    {
        if($firstLoop > $endLoop)
        {
            return false;
        }

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
                                        <h1 class="text-uppercase name-network">' . $row_sponsor->username . '</h1>
                                        <div class="d-flex justify-content-center align-content-center align-items-center text-center position-relative my-2">
                                            <img src="' . base_url('assets/img/') . $this->box($package_name) . '" alt="" height="90px">
                                            <p style="position: absolute;bottom: 57px;">' . $row_sponsor->fm . '</p>
                                            <p style="position: absolute; bottom:10px">' . $team . '</p>
                                        </div>
                                        <p class="box-network text-white text-uppercase" style="background-color:' . $package_color . '">' . $package_name . ' '.$this->lang->line('box').'</p>';

                //looping
                $query_position_bottom = $this->M_user->get_sponsor_member1($row_sponsor->user_id);

                if(count($query_position_bottom) != '')
                {
                    $output .= '<button id="'.$row_sponsor->user_id.'" onClick="reply_click_user(this.id)" class="charetnet">
                                        <i class="fas fa-caret-down"></i>
                                </button>
                            </div>'; 

                    if($firstLoop == $endLoop)
                    {
                        $output .= '<div id="result'.$row_sponsor->user_id.'" class="hideNetwork">';
                    }
                    else
                    {
                        $output .= '<div id="result'.$row_sponsor->user_id.'" class="displayNetwork">';
                    }
    
                    $output .= $this->_loopingSponsor($firstLoop+1, $endLoop, $row_sponsor->user_id);
    
                    $output .= '</div>'; 
                }
                                
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

    public function showSponsorMemberA($id)
    {
        $query_line = $this->M_user->get_sponsor_member($id, '3', '0');

        return json_decode(json_encode($query_line), true);
    }

    public function showSponsorMemberB($id)
    {
        $query_line = $this->M_user->get_sponsor_member($id, '3', '3');

        return json_decode(json_encode($query_line), true);
    }

    public function showSponsorMemberC($id)
    {
        $query_line = $this->M_user->get_sponsor_member($id, '6', '6');

        return json_decode(json_encode($query_line), true);
    }

    public function showSponsorMember($id)
    {
        $query_line = $this->M_user->get_sponsor_member1($id);

        return json_decode(json_encode($query_line), true);
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

    public function get_countMemberSponsor($id)
    {
        $query = $this->M_user->get_totaluser_bysponsor($id);

        foreach ($query->result() as $row) {
            array_push($this->arr2, $row->user_id);

            $this->get_countMemberSponsor($row->user_id);
        }

        return $this->arr2;
    }

    public function countPointTodayL($userid)
    {
        $dateNow = date('Y-m-d');

        $query = $this->M_user->check_line($userid, 'A');
        $user_position = $query['user_id'] ?? null;

        $query_package = $this->M_user->get_onepoint_byuser($user_position, $dateNow)->row_array();
        $package_datecreate = $query_package['datecreate'] ?? null;

        $packagePoint = $query_package['point'] ?? null;

        $countMember = $this->get_countPointTodayL($user_position, $dateNow);
        $sumTotal = array_sum($countMember) + $packagePoint;
        $this->arrTodayL = array();

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

        foreach ($query->result() as $row) 
        {
            // if (date('Y-m-d', $row->datecreate) == $date) {
            //     array_push($this->arrTodayR, $row->point);
            // }

            array_push($this->arrTodayR, $row->point);

            $this->get_countPointTodayR($row->user_id, $date);
        }

        return $this->arrTodayR;
    }

    /**Count total omset network left */
    public function countPositionL($userid)
    {
        $query = $this->M_user->check_line($userid, 'A');
        $user_position = $query['user_id'] ?? null;

        $query_package = $this->M_user->get_point_byuserid($user_position)->row_array();
        $package       = $query_package['point'] ?? null;

        $countMember = $this->get_countPointL($user_position);

        $sumTotal = array_sum($countMember) + $package;
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
        $user_position = $query['user_id'] ?? null;

        $query_package = $this->M_user->get_point_byuserid($user_position)->row_array();
        $package_poin  = $query_package['point'] ?? null;

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

    //url bonus perhari matching
    public function pairingmatching()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_bonus_pairing_byid($query_user['id']);
        $query_total_excess = $this->M_user->get_total_excess_pairing_byid($query_user['id']);

        $data['title']              = $this->lang->line('pairing');
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_pairingmatching($query_user['id']);
        $data['bonus_excess']       = $this->M_user->get_excess_pairing($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['total_mtm']          = $query_total['mtm'];
        $data['total_mtm_excess']   = $query_total_excess['mtm'];

        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/bonus/pairing_matching', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    //my wallet link
    public function mywallet()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = $this->lang->line('my_wallet');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/my_wallet', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function mywalletzenx()
    {
        $this->_unset_payment();

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '3');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'zenx');

        
        $data['title']              = 'ZENX '.$this->lang->line('wallet');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['deposit']            = $this->M_user->get_deposit_general($query_user['id'], '3');
        $data['general']            = $query_sum_deposit['coin'] - $query_total_purchase['zenx'] - $query_total_withdrawal['amount'];
        $data['purchase']           = $this->M_user->get_purchase_zenx_byid($query_user['id']);
        $data['withdrawal']         = $this->M_user->get_withdrawal_by($query_user['id'], 'zenx')->result();
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();
        
        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/my_wallet_zenx', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function mywalletfil()
    {
        $this->_unset_payment();

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_fill        = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_fill  = $this->M_user->get_transfer_bonus($query_user['id'], 'filecoin');
        $query_transfer_list        = $this->M_user->get_transfer_list('mining_user_transfer', 'datecreate', $query_user['id'], 'DESC')->result();
        $query_transfer_bonus_list  = $this->M_user->get_transfer_bonus_list($query_user['id'], 'filecoin', 'DESC')->result();
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'filecoin');
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '1');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);

        $query_total               = $this->M_user->get_total_bonus($query_user['id'])->row_array();

        
        $data['title']                  = 'Fill '.$this->lang->line('wallet');
        $data['user']                   = $query_user;
        $data['amount_notif']           = $query_row_notif;
        $data['list_notif']             = $query_new_notif;
        $data['transfer_list_mining']   = $query_transfer_list;
        $data['transfer_list_bonus']    = $query_transfer_bonus_list;
        $data['cart']                   = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['general_balance_fil']    = ($query_transfer_fill['amount'] + $query_transfer_bonus_fill['amount']) - $query_total_withdrawal['amount'] + $query_sum_deposit['coin'] - $query_total_purchase['fill'];
        $data['withdrawal']             = $this->M_user->get_withdrawal_by($query_user['id'], 'filecoin')->result();
        $data['deposit']                = $this->M_user->get_deposit_general($query_user['id'], '1');
        $data['purchase']               = $this->M_user->get_purchase_fill_byid($query_user['id']);
        $data['market_price']           = $this->M_user->get_price_coin()->row_array();
        
        $data['total_fil']          = $query_total['sponsorfil'] + $query_total['sponmatchingfil'] + $query_total['minmatching'] + $query_total['minpairing'];
        $data['balance']            = $data['total_fil'] - $query_transfer_bonus_fill['amount'];
        $data['bonus_list']         = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['bonus_sm_list']      = $this->M_user->get_bonus_bysponsormatching($query_user['id']);
        $data['bonus_minmatching_list'] = $this->M_user->get_bonus_miningmatching($query_user['id']);
        $data['bonus_minpairing_list'] = $this->M_user->get_bonus_miningpairing($query_user['id'])->get()->result();
        $data['transfer_list']      = $query_transfer_bonus_list;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/my_wallet_fil', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function mywalletmtm()
    {
        $this->_unset_payment();

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_mtm         = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_mtm   = $this->M_user->get_transfer_bonus($query_user['id'], 'mtm');
        $query_transfer_list        = $this->M_user->get_transfer_list('airdrop_mtm_transfer', 'datecreate', $query_user['id'], 'DESC')->result();
        $query_transfer_bonus_list  = $this->M_user->get_transfer_bonus_list($query_user['id'], 'mtm', 'DESC')->result();
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'mtm');
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '2');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);

        //total bonus mtm 
        $query_total                = $this->M_user->get_total_bonus($query_user['id'])->row_array();
        $total_sponsormtm           = $query_total['sponsormtm'] ?? null;
        $total_sponmatchingmtm      = $query_total['sponmatchingmtm'] ?? null;
        $total_pairingmatch_mtm     = $query_total['pairingmatch'] ?? null;
        $total_binarymatch_mtm      = $query_total['binarymatch'] ?? null;
        $total_bonusglobal_mtm      = $query_total['bonusglobal'] ?? null;
        $total_basecampmtm          = $query_total['basecampmtm'] ?? null;

        // total airdrop mtm
        $query_total_mtm           = $this->M_user->get_total_byuser('airdrop_mtm', 'amount', 'user_id', $query_user['id']);

        $data['title']                  = 'MTM '.$this->lang->line('wallet');
        $data['user']                   = $query_user;
        $data['amount_notif']           = $query_row_notif;
        $data['list_notif']             = $query_new_notif;
        $data['transfer_list_mining']   = $query_transfer_list;
        $data['transfer_list_bonus']    = $query_transfer_bonus_list;
        $data['cart']                   = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['general_balance_mtm']    = ($query_transfer_mtm['amount'] + $query_transfer_bonus_mtm['amount']) - $query_total_withdrawal['amount'] + $query_sum_deposit['coin'] - $query_total_purchase['mtm'];
        $data['withdrawal']             = $this->M_user->get_withdrawal_by($query_user['id'], 'mtm')->result();
        $data['deposit']                = $this->M_user->get_deposit_general($query_user['id'], '2');
        $data['purchase']               = $this->M_user->get_purchase_mtm_byid($query_user['id']);
        $data['market_price']           = $this->M_user->get_price_coin()->row_array();
        $data['detail']                 = $this->M_user->get_detail_user($query_user['id'])->row_array();
        $data['excess_bonus']           = $this->M_user->get_excess_bonus($query_user['id'])->row_array();
        $data['total_mtm']              = $total_sponsormtm + $total_sponmatchingmtm + $total_pairingmatch_mtm + $total_binarymatch_mtm + $total_bonusglobal_mtm + $total_basecampmtm;
        $data['mining_mtm_total']       = isset($query_total_mtm['amount']) ? $query_total_mtm['amount'] : 0;

        $data['balance']            = $data['total_mtm'] - $query_transfer_bonus_mtm['amount'];
        $data['bonus_list']         = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['bonus_sm_list']      = $this->M_user->get_bonus_bysponsormatching($query_user['id']);
        $data['bonus_pairingmatch_list'] = $this->M_user->get_bonus_pairingmatching($query_user['id']);
        $data['bonus_binary_list']  = $this->M_user->get_bonus_binarymatch($query_user['id']);
        $data['bonus_global_list']  = $this->M_user->get_bonus_global($query_user['id']);
        $data['bonus_basecamp_list'] = $this->M_user->get_bonus_basecamp2($query_user['id']);
        $data['transfer_list']      = $query_transfer_bonus_list;
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/my_wallet_mtm', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletfillgeneral()
    {
        $this->_unset_payment();

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_fill        = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_fill  = $this->M_user->get_transfer_bonus($query_user['id'], 'filecoin');
        $query_transfer_list        = $this->M_user->get_transfer_list('mining_user_transfer', 'datecreate', $query_user['id'], 'DESC')->result();
        $query_transfer_bonus_list  = $this->M_user->get_transfer_bonus_list($query_user['id'], 'filecoin', 'DESC')->result();
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'filecoin');
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '1');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);

        $data['title']                  = 'Fill General '.$this->lang->line('balance');
        $data['user']                   = $query_user;
        $data['amount_notif']           = $query_row_notif;
        $data['list_notif']             = $query_new_notif;
        $data['transfer_list_mining']   = $query_transfer_list;
        $data['transfer_list_bonus']    = $query_transfer_bonus_list;
        $data['cart']                   = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['general_balance_fil']    = ($query_transfer_fill['amount'] + $query_transfer_bonus_fill['amount']) - $query_total_withdrawal['amount'] + $query_sum_deposit['coin'] - $query_total_purchase['fill'];
        $data['withdrawal']             = $this->M_user->get_withdrawal_by($query_user['id'], 'filecoin')->result();
        $data['deposit']                = $this->M_user->get_deposit_general($query_user['id'], '1');
        $data['purchase']               = $this->M_user->get_purchase_fill_byid($query_user['id']);
        $data['market_price']           = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/fill/general', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletfillmining()
    {
        $this->_unset_payment();

        $query_user          = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif     = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif     = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_mining        = $this->M_user->show_all_byid($query_user['id'], 'mining_user', 'user_id');
        $query_total         = $this->M_user->get_total_byuser('mining_user', 'amount', 'user_id', $query_user['id']);
        $query_transfer      = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_list = $this->M_user->get_transfer_list('mining_user_transfer', 'datecreate', $query_user['id'], 'DESC')->result();

        $data['title']              = 'Fill Mining '.$this->lang->line('balance');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['list_mining']        = $query_mining;
        $data['transfer_list']      = $query_transfer_list;
        $data['balance']            = $query_total['amount'] - $query_transfer['amount'];
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/fill/mining', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletfillbonus()
    {
        $this->_unset_payment();

        $query_user                = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif           = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif           = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total               = $this->M_user->get_total_bonus($query_user['id'])->row_array();
        $query_transfer_bonus_fill = $this->M_user->get_transfer_bonus($query_user['id'], 'filecoin');
        $query_transfer_bonus_list = $this->M_user->get_transfer_bonus_list($query_user['id'], 'filecoin', 'DESC')->result();

        $data['title']              = 'Fill '.$this->lang->line('bonus_balance');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total_fil']          = $query_total['sponsorfil'] + $query_total['sponmatchingfil'] + $query_total['minmatching'] + $query_total['minpairing'];
        $data['balance']            = $data['total_fil'] - $query_transfer_bonus_fill['amount'];
        $data['bonus_list']         = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['bonus_sm_list']      = $this->M_user->get_bonus_bysponsormatching($query_user['id']);
        $data['bonus_minmatching_list'] = $this->M_user->get_bonus_miningmatching($query_user['id']);
        $data['bonus_minpairing_list'] = $this->M_user->get_bonus_miningpairing($query_user['id'])->get()->result();
        $data['transfer_list']      = $query_transfer_bonus_list;
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/fill/bonus', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletmtmgeneral()
    {
        $this->_unset_payment();

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_mtm         = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_mtm   = $this->M_user->get_transfer_bonus($query_user['id'], 'mtm');
        $query_transfer_list        = $this->M_user->get_transfer_list('airdrop_mtm_transfer', 'datecreate', $query_user['id'], 'DESC')->result();
        $query_transfer_bonus_list  = $this->M_user->get_transfer_bonus_list($query_user['id'], 'mtm', 'DESC')->result();
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'mtm');
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '2');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);

        //total bonus mtm 
        $query_total                = $this->M_user->get_total_bonus($query_user['id'])->row_array();
        $total_sponsormtm           = $query_total['sponsormtm'] ?? null;
        $total_sponmatchingmtm      = $query_total['sponmatchingmtm'] ?? null;
        $total_pairingmatch_mtm     = $query_total['pairingmatch'] ?? null;
        $total_binarymatch_mtm      = $query_total['binarymatch'] ?? null;
        $total_bonusglobal_mtm      = $query_total['bonusglobal'] ?? null;
        $total_basecampmtm          = $query_total['basecampmtm'] ?? null;

        // total airdrop mtm
        $query_total_mtm           = $this->M_user->get_total_byuser('airdrop_mtm', 'amount', 'user_id', $query_user['id']);

        $data['title']                  = 'MTM '.$this->lang->line('general_balance');
        $data['user']                   = $query_user;
        $data['amount_notif']           = $query_row_notif;
        $data['list_notif']             = $query_new_notif;
        $data['transfer_list_mining']   = $query_transfer_list;
        $data['transfer_list_bonus']    = $query_transfer_bonus_list;
        $data['cart']                   = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['general_balance_mtm']    = ($query_transfer_mtm['amount'] + $query_transfer_bonus_mtm['amount']) - $query_total_withdrawal['amount'] + $query_sum_deposit['coin'] - $query_total_purchase['mtm'];
        $data['withdrawal']             = $this->M_user->get_withdrawal_by($query_user['id'], 'mtm')->result();
        $data['deposit']                = $this->M_user->get_deposit_general($query_user['id'], '2');
        $data['purchase']               = $this->M_user->get_purchase_mtm_byid($query_user['id']);
        $data['market_price']           = $this->M_user->get_price_coin()->row_array();
        $data['detail']                 = $this->M_user->get_detail_user($query_user['id'])->row_array();
        $data['excess_bonus']           = $this->M_user->get_excess_bonus($query_user['id'])->row_array();
        $data['total_mtm']              = $total_sponsormtm + $total_sponmatchingmtm + $total_pairingmatch_mtm + $total_binarymatch_mtm + $total_bonusglobal_mtm + $total_basecampmtm;
        $data['mining_mtm_total']       = isset($query_total_mtm['amount']) ? $query_total_mtm['amount'] : 0;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/mtm/general', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletmtmairdrop()
    {
        $this->_unset_payment();

        $query_user          = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif     = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif     = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_airdrops      = $this->M_user->show_all_byid($query_user['id'], 'airdrop_mtm', 'user_id');
        $query_sum_air       = $this->M_user->get_total_byuser('airdrop_mtm', 'amount', 'user_id', $query_user['id']);
        $query_transfer      = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_list = $this->M_user->get_transfer_list('airdrop_mtm_transfer', 'datecreate', $query_user['id'], 'DESC')->result();

        $data['title']              = 'MTM Air Drops '.$this->lang->line('balance');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['airdrops']           = $query_airdrops;
        $data['transfer_list']      = $query_transfer_list;
        $data['balance']            = $query_sum_air['amount'] - $query_transfer['amount'];
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/mtm/airdrops', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletmtmbonus()
    {
        $this->_unset_payment();

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total                = $this->M_user->get_total_bonus($query_user['id'])->row_array();
        $query_transfer_bonus_mtm   = $this->M_user->get_transfer_bonus($query_user['id'], 'mtm');
        $query_transfer_bonus_list  = $this->M_user->get_transfer_bonus_list($query_user['id'], 'mtm', 'DESC')->result();

        $data['title']              = 'MTM '.$this->lang->line('bonus_balance');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total_mtm']          = $query_total['sponsormtm'] + $query_total['sponmatchingmtm'] + $query_total['pairingmatch'] + $query_total['binarymatch'] + $query_total['bonusglobal'] + $query_total['basecampmtm'];
        $data['balance']            = $data['total_mtm'] - $query_transfer_bonus_mtm['amount'];
        $data['bonus_list']         = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['bonus_sm_list']      = $this->M_user->get_bonus_bysponsormatching($query_user['id']);
        $data['bonus_pairingmatch_list'] = $this->M_user->get_bonus_pairingmatching($query_user['id']);
        $data['bonus_binary_list']  = $this->M_user->get_bonus_binarymatch($query_user['id']);
        $data['bonus_global_list']  = $this->M_user->get_bonus_global($query_user['id']);
        $data['bonus_basecamp_list'] = $this->M_user->get_bonus_basecamp2($query_user['id']);
        $data['transfer_list']      = $query_transfer_bonus_list;
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/mtm/bonus', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletzenxgeneral()
    {
        $this->_unset_payment();

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '3');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'zenx');

        $data['title']              = 'ZENX '.$this->lang->line('general_balance');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['deposit']            = $this->M_user->get_deposit_general($query_user['id'], '3');
        $data['general']            = $query_sum_deposit['coin'] - $query_total_purchase['zenx'] - $query_total_withdrawal['amount'];
        $data['purchase']           = $this->M_user->get_purchase_zenx_byid($query_user['id']);
        $data['withdrawal']         = $this->M_user->get_withdrawal_by($query_user['id'], 'zenx')->result();
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/zenx/general', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletzenxairdrop()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = 'ZENX Air Drops '.$this->lang->line('balance');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/zenx/airdrops', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function walletzenxbonus()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = 'ZENX '.$this->lang->line('bonus_balance');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['market_price']       = $this->M_user->get_price_coin()->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/zenx/bonus', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function myteam()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_team_a       = $this->M_user->get_team($query_user['id'], '3', '0');
        $query_team_b       = $this->M_user->get_team($query_user['id'], '3', '3');
        $query_row_team     = $this->M_user->row_data_byuser('cart', 'sponsor_id', $query_user['id']);
        $query_team_c       = $this->M_user->get_team($query_user['id'], $query_row_team, '6');

        $data['title']              = $this->lang->line('my_team');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['team_a']             = $query_team_a;
        $data['team_b']             = $query_team_b;
        $data['team_c']             = $query_team_c;
        $data['userClass']          = $this;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/myteam', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function miningMatching()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_bonus_minmatch_byid($query_user['id']);

        $data['title']              = $this->lang->line('recommended_mining');
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_miningmatching($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total']              = $query_total['amount'];

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/bonus/mining_matching', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function binaryMatching()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_bonus_pairingmatch_byid($query_user['id']);
        $query_total_excess = $this->M_user->get_total_excess_pairingmatch_byid($query_user['id']);

        $data['title']              = $this->lang->line('pairing_matching');
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_binarymatch($query_user['id']);
        $data['excess']             = $this->M_user->get_excess_binarymatch($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total']              = $query_total['mtm'];
        $data['total_excess']       = $query_total_excess['mtm'];

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/bonus/binary_matching', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function bonusGlobal()
    {
        $this->_unset_payment();

        $dateNow    = date('Y-m-d');
        $monthNow   = date('Y-m');

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_bonus_global_byid($query_user['id']);
        $query_total_excess = $this->M_user->get_total_excess_byid($query_user['id'], 'bonus global');

        $data['title']              = $this->lang->line('global');
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_global($query_user['id']);
        $data['excess_bonus']       = $this->M_user->get_excess_global($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total_excess']       = $query_total_excess['mtm'];
        $data['total']              = $query_total['mtm'];

        $fm = $data['cart']['fm'] ?? null;

        $query_fm_today         = $this->M_user->get_today_fm($fm, $dateNow);
        $query_all_fm           = $this->M_user->get_all_fm($fm);
        $query_today_omset      = $this->M_user->get_today_purchase($dateNow);
        $query_current_omset    = $this->M_user->get_currentmonth_purchase($monthNow);

        $today_omset_fill       = $query_today_omset['fill'] + ($query_today_omset['mtm'] / 4) + ($query_today_omset['zenx'] / 12); 
        $today_omset_mtm        = $today_omset_fill * 4;

        $current_omset_fill     = $query_current_omset['fill'] + ($query_current_omset['mtm'] / 4) + ($query_current_omset['zenx'] / 12);
        $current_omset_mtm      =  $current_omset_fill * 4;

        $data['today_fm']        = $query_fm_today;
        $data['all_fm']          = $query_all_fm;
        $data['today_omset']     = $today_omset_mtm;
        $data['current_omset']   = $current_omset_mtm;
        $data['omset_fil']      = $current_omset_fill;

        $dateLimit = $monthNow.'-15';

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

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/bonus/global', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    
    public function detailLevelMonthNow()
    {
        $query_user   = $this->M_user->get_user_byemail($this->session->userdata('email'));

        $data['title']              = 'Bonus Global';
        $data['user']               = $query_user;

        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;

        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        $fm = $data['cart']['fm'];
        $array_fm = explode('M', $fm);
        $level_user = $array_fm[1];
        
        $level          = $this->uri->segment(3);
        $array_level    = explode('M', $level);
        $level_url      = $array_level[1];

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

        $monthNow   = date('Y-m');
        $dateLimit  = $monthNow.'-15';

        $query_detail   = $this->M_user->get_level_monthnow_user($dateLimit, $level_array);
        $data['detail'] = $query_detail;

        
        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') 
        {
            if($level_url > $level_user)
            {
                redirect('user');
            }
            else
            {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/bonus/global_level', $data);
                $this->load->view('templates/user_footer');
            }
        } else {
            redirect('auth');
        }
    }

    public function achievement()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_sponsor      = $this->M_user->sum_sponsorbox($query_user['id']);
        $omset              = $this->_omset_bysponsor($query_user['id']);
        $count_fm1          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM1');
        $count_fm2          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM2');
        $count_fm3          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM3');
        $count_fm4          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM4');
        $count_fm5          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM5');
        $count_fm6          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM6');
        $count_fm7          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM7');
        $count_fm8          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM8');
        $count_fm9          = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM9');
        $count_fm10         = $this->M_user->count_fm_bysponsor($query_user['id'], 'FM10');
        $team_a             = $this->M_user->get_team($query_user['id'], 3, 0);
        $query_row_team     = $this->M_user->row_data_byuser('cart', 'sponsor_id', $query_user['id']);
        $team_c             = $this->M_user->get_team($query_user['id'], $query_row_team, '6');

        $total_sponsor = 0;
        foreach ($query_sponsor as $row_sponsor) {
            $total_sponsor = $total_sponsor + $row_sponsor->point;
        }

        $sponsor            = $total_sponsor;

        $count_a1  = 0;
        $count_a2  = 0;
        $count_a3  = 0;
        $count_a4  = 0;
        $count_a5  = 0;
        $count_a6  = 0;
        $count_a7  = 0;
        $count_a8  = 0;
        $count_a9  = 0;
        $count_a10  = 0;

        foreach ($team_a as $row_team_a) {
            if ($row_team_a->fm == 'FM1') {
                $count_a1 = $count_a1 + 1;
            } elseif ($row_team_a->fm == 'FM2') {
                $count_a2 = $count_a2 + 1;
            } elseif ($row_team_a->fm == 'FM3') {
                $count_a3 = $count_a3 + 1;
            } elseif ($row_team_a->fm == 'FM4') {
                $count_a4 = $count_a4 + 1;
            } elseif ($row_team_a->fm == 'FM5') {
                $count_a5 = $count_a5 + 1;
            } elseif ($row_team_a->fm == 'FM6') {
                $count_a6 = $count_a6 + 1;
            } elseif ($row_team_a->fm == 'FM7') {
                $count_a7 = $count_a7 + 1;
            } elseif ($row_team_a->fm == 'FM8') {
                $count_a8 = $count_a8 + 1;
            } elseif ($row_team_a->fm == 'FM9') {
                $count_a9 = $count_a9 + 1;
            } elseif ($row_team_a->fm == 'FM10') {
                $count_a10 = $count_a10 + 1;
            }
        }

        $count_c7  = 0;
        $count_c8   = 0;
        $count_c9   = 0;
        $count_c10   = 0;

        foreach ($team_c as $row_team_c) {
            if ($row_team_c->fm == 'FM7') {
                $count_c7 = $count_c7 + 1;
            } elseif ($row_team_c->fm == 'FM8') {
                $count_c8 = $count_c8 + 1;
            } elseif ($row_team_c->fm == 'FM9') {
                $count_c9 = $count_c9 + 1;
            } elseif ($row_team_c->fm == 'FM10') {
                $count_c10 = $count_c10 + 1;
            }
        }

        $data['title']              = $this->lang->line('achievements');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['sponsor']            = $sponsor;
        $data['omset']              = $omset;
        $data['fm1']                = $count_fm1;
        $data['fm2']                = $count_fm2;
        $data['fm3']                = $count_fm3;
        $data['fm4']                = $count_fm4;
        $data['fm5']                = $count_fm5;
        $data['fm6']                = $count_fm6;
        $data['fm7']                = $count_fm7;
        $data['fm8']                = $count_fm8;
        $data['fm9']                = $count_fm9;
        $data['fm10']               = $count_fm10;
        $data['team_a1']            = $count_a1;
        $data['team_a2']            = $count_a2;
        $data['team_a3']            = $count_a3;
        $data['team_a4']            = $count_a4;
        $data['team_a5']            = $count_a5;
        $data['team_a6']            = $count_a6;
        $data['team_a7']            = $count_a7;
        $data['team_a8']            = $count_a8;
        $data['team_a9']            = $count_a9;
        $data['team_a10']           = $count_a10;
        $data['team_c7']            = $count_c7;
        $data['team_c8']            = $count_c8;
        $data['team_c9']            = $count_c9;
        $data['team_c10']           = $count_c10;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/achievement', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    private function _omset_bysponsor($user_id)
    {
        $countMember = $this->_get_countPointSponsor($user_id);

        $sumTotal = array_sum($countMember);
        $this->arrPointSpon = array();

        return $sumTotal;
    }

    private function _get_countPointSponsor($user_id)
    {
        $query = $this->M_user->sum_sponsorbox($user_id);

        foreach ($query as $row) {
            array_push($this->arrPointSpon, $row->point);

            $this->_get_countPointSponsor($row->user_id);
        }

        return $this->arrPointSpon;
    }

    public function information_detail()
    {
        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_detail       = $this->M_user->get_information_detail($query_user['id']);

        $data['title']              = 'Information Detail';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['payment']            = $this->M_user->show_cart_byid($query_user['id']);
        $data['information_detail'] = $query_detail;
        $datacart_updatedate        = $data['cart']['update_date'] ?? null;

        $mining_payment = date('Y-m-d', $datacart_updatedate);

        $date_fil = new DateTime($mining_payment);
        $date_fil->modify('45 days');
        $data['fil_startpayment'] = $date_fil->format('Y/m/d');
        $date_fil->modify('1100 days');
        $data['fil_endpayment'] = $date_fil->format('Y/m/d');

        $date_mtm = new DateTime($mining_payment);
        $date_mtm->modify('1 week');
        $data['mtm_startpayment'] = $date_mtm->format('Y/m/d');
        $date_mtm->modify('540 days');
        $data['mtm_endpayment'] = $date_mtm->format('Y/m/d');

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/information_detail', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function upload()
    {
        $data = array();

        if ($this->input->post('submit')) { // Jika user menekan tombol Submit (Simpan) pada form
            // lakukan upload file dengan memanggil function upload yang ada di GambarModel.php
            $upload = $this->M_user->upload_photo();

            if ($upload['result'] == "success") { // Jika proses upload sukses
                // Panggil function save yang ada di GambarModel.php untuk menyimpan data ke database
                $this->M_user->save_photo($upload);

                redirect('user/information_detail'); // Redirect kembali ke halaman awal / halaman view data
            } else { // Jika proses upload gagal
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('upload_error').'</div>');
            }
        }

        $this->load->view('user/information_detail', $data);
    }

    function switch($language)
    {
        $this->session->set_userdata('language', $language);
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function marketing_plan()
    {
        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = $this->lang->line('marketing_plan');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['payment']            = $this->M_user->show_cart_byid($query_user['id']);


        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/marketing_plan', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function market_trade()
    {
        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = $this->lang->line('market_trade');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['payment']            = $this->M_user->show_cart_byid($query_user['id']);

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/market_trade', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    //show modal notification limit mining
    public function modalLimitMining()
    {
        $query_user = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $id_notif   = $this->input->post('item_id');

        //show single notification
        $query_notif = $this->M_user->show_notif_byuser($id_notif, $query_user['id']);
        $data['message']    = $query_notif['message'];
        $data['link']       = $query_notif['link'] . '/' . $id_notif;

        $this->load->view('user/modal/notif_mining', $data);
    }

    public function updateDaysMining()
    {
        $cartid     = $this->uri->segment(3);
        $notifid    = $this->uri->segment(4);
        $stat       = $this->uri->segment(5);

        $data = [
            'pause_min' => $stat
        ];

        $data_notif = [
            'is_show' => 1
        ];

        $update_cart = $this->M_user->update_data_byid('cart', $data, 'id', $cartid);

        if ($update_cart) {
            $update_notif = $this->M_user->update_data_byid('notifi', $data_notif, 'id', $notifid);
            if ($update_notif) {
                if ($stat == 2) {
                    $message = 'Your mining time limit has been extended.';
                } else {
                    $message = 'Your mining timeout has been stopped.';
                }

                $this->session->set_flashdata('message', '<div class="alert alert-info" role="alert">' . $message . '</div>');
                redirect('user/index');
            }
        }
    }

    //show lish notification
    public function listNotification()
    {
        $query_user = $this->M_user->get_user_byemail($this->session->userdata('email'));

        //show list notification
        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);
        $data2['list_notif'] = $query_new_notif;
        $data2['amount_notif'] = $query_row_notif;

        $this->load->view('user/notification', $data2);
    }

    public function setting()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = $this->lang->line('setting');
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/setting/index', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
        } else {
            redirect('auth');
        }
    }

    public function changeEmail()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email')) {
            if ($this->session->userdata('role_id') == '2') {

                $this->form_validation->set_rules('email', 'Current Email', 'trim|required', [
                    'required' => $this->lang->line('require_current_email')
                ]);
                $this->form_validation->set_rules('email2', 'New Email', 'trim|required', [
                    'required' => $this->lang->line('require_new_email')
                ]);
                $this->form_validation->set_rules('check_code1', 'Current Email Code', 'trim|required', [
                    'required' => $this->lang->line('require_current_email_code')
                ]);
                $this->form_validation->set_rules('check_code2', 'New Email Code', 'trim|required', [
                    'required' => $this->lang->line('require_new_email_code')
                ]);

                $code1 = date('mHd');

                if ($this->form_validation->run() == false) {
                    $data['title'] = 'Change Email';
                    $this->load->view('templates/user_header', $data);
                    $this->load->view('templates/user_sidebar', $data);
                    $this->load->view('templates/user_topbar', $data);
                    $this->load->view('user/setting/change_email', $data);
                    $this->load->view('templates/user_footer');


                    if (isset($_POST['check1'])) {
                        $email = $data['user']['email'];
                        $subject = "=?UTF-8?B?".base64_encode($this->lang->line('checking_email'))."?=";
                        $message  = $this->lang->line('message_copy_current_email_code').": <br/><br/> $code1";
                        $sendmail = array(
                            'recipient_email' => $email,
                            'subject' => $subject,
                            'content' => $message
                        );
                        $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                        echo "<script>
                                alert('".$this->lang->line('alert_checking_current_email')."')
                            </script>";
                    } elseif (isset($_POST['check2'])) {

                        $permitted_chars = '0123456789';
                        $code2 = substr(str_shuffle($permitted_chars), 0, 6);
                        $this->db->set('email_code', $code2);
                        $this->db->where('email', $data['user']['email']);
                        $this->db->update('user');

                        $email = $this->input->post('email2');
                        $subject = "=?UTF-8?B?".base64_encode($this->lang->line('checking_email'))."?=";
                        $message  = $this->lang->line('message_copy_new_email_code').": <br/><br/> $code2";
                        $sendmail = array(
                            'recipient_email' => $email,
                            'subject' => $subject,
                            'content' => $message
                        );

                        $this->mailer->send($sendmail); // Panggil fungsi send yang ada di librari Mailer
                        echo "<script>
                            alert('".$this->lang->line('alert_checking_new_email')."')
                        </script>";
                    }
                } else {
                    $current_email = $this->input->post('email');
                    $email2 = $this->input->post('email2');
                    $check_code1 = $this->input->post('check_code1');
                    $check_code2 = $this->input->post('check_code2');

                    if ($current_email != $data['user']['email']) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('wrong_current_email').'</div>');
                        redirect('user/changeEmail');
                    } else {
                        if ($current_email == $email2) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('new_email_cannot_same').'</div>');
                            redirect('user/changeEmail');
                        } else {
                            if ($code1 == $check_code1) {
                                if ($data['user']['email_code'] == $check_code2) {
                                    $newemail = $email2;
                                    $id = $data['user']['id'];

                                    $this->db->set('email', $newemail);
                                    $this->db->where('id', $id);
                                    $this->db->update('user');

                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('success_change_email').'</div>');
                                    redirect('auth');
                                } else {
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('wrong_new_email_code').'</div>');
                                    redirect('user/changeEmail');
                                }
                            } else {
                                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('wrong_current_email').'</div>');
                                redirect('user/changeEmail');
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function changePassword()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);


        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email')) 
        {
            if ($this->session->userdata('role_id') == '2') {

                $this->form_validation->set_rules('password', 'Current Password', 'trim|required', [
                    'required' => $this->lang->line('require_current_password')
                ]);
                $this->form_validation->set_rules('password1', 'New Password', 'trim|required|min_length[3]', [
                    'required' => $this->lang->line('require_new_password'),
                    'min_length' => $this->lang->line('min_length_new_password')
                ]);
                $this->form_validation->set_rules('password2', 'Repeat New Password', 'trim|required|min_length[3]|matches[password1]', [
                    'required' => $this->lang->line('require_repeat_new_password'),
                    'min_length' => $this->lang->line('min_length_repeat_new_password'),
                    'matches' => $this->lang->line('matches_new_password')
                ]);
                $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required', [
                    'required' => $this->lang->line('require_email_code')
                ]);

                if ($this->form_validation->run() == false) {
                    $data['title'] = 'Change Password';
                    $this->load->view('templates/user_header', $data);
                    $this->load->view('templates/user_sidebar', $data);
                    $this->load->view('templates/user_topbar', $data);
                    $this->load->view('user/setting/change_password', $data);
                    $this->load->view('templates/user_footer');

                    if (isset($_POST['check'])) {
                        $email = $data['user']['email'];

                        $permitted_chars = '0123456789';
                        $code = substr(str_shuffle($permitted_chars), 0, 6);
                        $this->db->set('email_code', $code);
                        $this->db->where('email', $email);
                        $this->db->update('user');

                        $subject = "=?UTF-8?B?".base64_encode($this->lang->line('checking_email'))."?=";
                        $message  = $this->lang->line('message_copy_code').": <br/><br/> $code";
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
                    $current_password = $this->input->post('password');
                    $password1 = $this->input->post('password1');
                    $email_code = $this->input->post('email_code');

                    if (!password_verify($current_password, $data['user']['password'])) {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('wrong_current_password').'</div>');
                        redirect('user/changePassword');
                    } else {
                        if ($current_password == $password1) {
                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('not_same_current_password').'</div>');
                            redirect('user/changePassword');
                        } else {
                            if ($data['user']['email_code'] == $email_code) {
                                $password = password_hash($password1, PASSWORD_DEFAULT);
                                $email = $data['user']['email'];

                                $this->db->set('password', $password);
                                $this->db->where('email', $email);
                                $this->db->update('user');

                                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('success_change_password').'</div>');
                                redirect('auth');
                            } else {
                                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('wrong_email_code').'</div>');
                                redirect('user/changePassword');
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function google_otp()
    {
        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = 'Google OTP';
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['payment']            = $this->M_user->show_cart_byid($query_user['id']);

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {

            $email = $data['user']['email'];
            $user_secret = $data['user']['secret_otp'];


            $ga = new GoogleAuthenticator();
            $secret = $ga->createSecret();

            $this->form_validation->set_rules('code', 'OTP Code', 'trim|required', [
                'required' => $this->lang->line('require_otp_code')
            ]);

            if ($user_secret == '') {
                $data['qrCodeUrl'] = $ga->getQRCodeGoogleUrl($data['user']['username'], $secret, 'mining');
                $this->db->set('secret_otp', $secret);
                $this->db->where('email', $email);
                $this->db->update('user');
            } else {
                $data['qrCodeUrl'] = $ga->getQRCodeGoogleUrl($data['user']['username'], $user_secret, 'mining');
                if (isset($_POST['submit'])) {
                    $code = $this->input->post('code');
                    $checkResult = $ga->verifyCode($user_secret, $code);
                    if ($checkResult) {
                        $this->db->set('is_otp', 1);
                        $this->db->where('email', $email);
                        $this->db->update('user');
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('success_create_otp').'</div>');
                        redirect('user/google_otp');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('wrong_otp_code').'</div>');
                    }
                }
            }

            if (isset($_POST['unactivated'])) {
                $code = $this->input->post('code');
                $checkResult = $ga->verifyCode($user_secret, $code);
                if ($checkResult) {
                    $this->db->set('is_otp', 0);
                    $this->db->set('secret_otp', '');
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('message_otp_success').'</div>');
                    redirect('user/google_otp');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('wrong_otp_code').'</div>');
                    redirect('user/google_otp');
                }
            }

            if (isset($_POST['unactivated'])) {
                $code = $this->input->post('code');
                $checkResult = $ga->verifyCode($user_secret, $code);
                if ($checkResult) {
                    $this->db->set('is_otp', 0);
                    $this->db->set('secret_otp', '');
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('message_otp_success').'</div>');
                    redirect('user/google_otp');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('wrong_otp_code').'</div>');
                    redirect('user/google_otp');
                }
            }

            if (isset($_POST['unactivated'])) {
                $code = $this->input->post('code');
                $checkResult = $ga->verifyCode($user_secret, $code);
                if ($checkResult) {
                    $this->db->set('is_otp', 0);
                    $this->db->set('secret_otp', '');
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('message_otp_success').'</div>');
                    redirect('user/google_otp');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('wrong_otp_code').'</div>');
                    redirect('user/google_otp');
                }
            }

            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/setting/google_otp', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function customer_service()
    {
        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        $data['title']              = $this->lang->line('customer_service');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['get_uniq']           = $this->M_user->getUniqMessage($query_user['email'])->row_array();
        $data['message']            = $this->M_user->get_message($query_user['email'], $data['get_uniq']['uniq_id'] ?? null)->result();
        $data['message_robot']      = $this->M_user->get_message_robot($query_user['email'])->result();
        // $data['get_user']           = $this->M_user->get_user_by($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
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
                        'name' => $data['user']['first_name'],
                        'sender_email' => $data['user']['email'],
                        'email' => $data['user']['email'],
                        'phone' => $data['user']['phone'],
                        'message' => $message,
                        'image' => '',
                        'time' => time()
                    ];
                    $insert = $this->M_user->insert_data('user_messages', $data);
                    if ($insert == true) {
                        redirect('user/customer_service');
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('send_message_failed').'</div>');
                        redirect('user/customer_service');
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

                        redirect('user/customer_service'); // Redirect kembali ke halaman awal / halaman view data
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('upload_success').'</div>');
                    } else { // Jika proses upload gagal
                        redirect('user/customer_service'); // Redirect kembali ke halaman awal / halaman view data
                        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('upload_error').'</div>');
                    }
                }
            }

            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/customer_service', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function miningGenerasi()
    {
        $this->_unset_payment();

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_bonus_mingeneration_byid($query_user['id']);

        $data['title']              = $this->lang->line('mining_generation');
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_miningpairing($query_user['id'])->get()->result();
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total']              = $query_total['amount'];

        if ($this->session->userdata('email')) 
        {
            if ($this->session->userdata('role_id') == '2') 
            {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/bonus/mining_pairing', $data);
                $this->load->view('templates/user_footer');
            } else {
                redirect('auth');
            }
        }
    }

    public function withdrawal_fil()
    {
        if (!empty($this->uri->segment(4))) {
            $id_notif = $this->uri->segment(4);
        }

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_fill        = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_fill  = $this->M_user->get_transfer_bonus($query_user['id'], 'filecoin');
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'filecoin');
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '1');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);
        $query_minimum_withdrawal   = $this->M_user->minimum_withdrawal();


        $data['title']              = $this->lang->line('withdrawal');;
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['general_balance_fil'] = ($query_transfer_fill['amount'] + $query_transfer_bonus_fill['amount']) - $query_total_withdrawal['amount'] + $query_sum_deposit['coin'] - $query_total_purchase['fill'];
        $data['fee_withdrawal']     = $query_minimum_withdrawal;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('wallet_address', 'Wallet Address', 'trim|required|callback_checkfirstchar', [
                'required' => $this->lang->line('require_wallet_address')
            ]);
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required', [
                'required' =>  $this->lang->line('require_amount')
            ]);
            $this->form_validation->set_rules('fee', 'Fee', 'trim|required', [
                'required' => $this->lang->line('require_fee')
            ]);
            $this->form_validation->set_rules('total', 'Total', 'trim|required', [
                'required' => $this->lang->line('require_total')
            ]);
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required', [
                'required' => $this->lang->line('require_email_code')
            ]);
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required', [
                'required' => $this->lang->line('require_otp_code')
            ]);

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/fill/withdrawal_fil', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "=?UTF-8?B?".base64_encode($this->lang->line('checking_email'))."?=";
                    $message  = $this->lang->line('message_copy_code').": <br/><br/> $code";
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
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('message_register_otp').' > Goggle OTP</div>');
                    redirect('user/withdrawal_fil');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $wallet = $this->input->post('wallet_address');
                    $amount = $this->input->post('amount');
                    $total = $this->input->post('total');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_email_code').'</div>');
                        redirect('user/withdrawal_fil');
                    } else {
                        if ($amount > $data['general_balance_fil']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('not_enough').' filecoins</div>');
                            redirect('user/withdrawal_fil');
                        } else {
                            if ($amount < $query_minimum_withdrawal['filecoin']) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('minimum_amount_wd'). ' '. $query_minimum_withdrawal['filecoin'] . ' FIL</div>');
                                redirect('user/withdrawal_fil');
                            } else {
                                $checkResult = $ga->verifyCode($secret, $otp_code);
                                if (!$checkResult) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('otp_code_wrong').'</div>');
                                    redirect('user/withdrawal_fil');
                                } else {
                                     if (!empty($this->uri->segment(4))) {
                                        $id_wd = $this->uri->segment(3);
                                        $data_update = [
                                            'wallet_address' => $wallet,
                                            'amount' => $amount,
                                            'total' => $total,
                                            'note' => ''
                                        ];

                                        $update_cart = $this->M_user->update_data_byid('withdrawal', $data_update, 'id', $id_wd);


                                        $data_notif = [
                                            'is_show' => 1
                                        ];
                                        $id_notif = $this->uri->segment(4);
                                        $update_notif = $this->M_user->update_data_byid('notifi', $data_notif, 'id', $id_notif);

                                        if ($update_notif == true) {
                                            //update notification
                                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('request_wd_success').'</div>');
                                            redirect('user/mywalletfil');
                                        } else {
                                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('request_wd_failed').'</div>');
                                            redirect('user/withdrawal_fil');
                                        }
                                    } else {
                                        $withdrawal = [
                                            'user_id' => $user_id,
                                            'coin_type' => 'filecoin',
                                            'wallet_address' => $wallet,
                                            'amount' => $amount,
                                            'total' => $total,
                                            'datecreate' => time(),
                                        ];
                                        $insert = $this->M_user->insert_data('withdrawal', $withdrawal);
                                        if ($insert == true) {
                                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('request_wd_success').'</div>');
                                            redirect('user/mywalletfil');
                                        } else {
                                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('request_wd_failed').'</div>');
                                            redirect('user/withdrawal_fil');
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function checkfirstchar($text)
    {
        $first_ch = substr($text, 0, 1);
        $count = strlen($text);

        if ($first_ch == 'f' && $count == 41) {
            return TRUE;
        } else {
            $this->form_validation->set_message('checkfirstchar', $this->lang->line('firstchar_fil'));
            return FALSE;
        }
    }

    public function checkfirstcharm($text)
    {
        $first_ch = substr($text, 0, 1);
        $count = strlen($text);

        if ($first_ch == 'm' && $count == 34) {
            return TRUE;
        } else {
            $this->form_validation->set_message('checkfirstcharm', $this->lang->line('firstchar_mtm'));
            return FALSE;
        }
    }

    public function checkfirstcharz($text)
    {
        $first_ch = substr($text, 0, 1);
        $count = strlen($text);

        if ($first_ch == '0' && $count == 42) {
            return TRUE;
        } else {
            $this->form_validation->set_message('checkfirstcharz', $this->lang->line('firstchar_wallet_zenx'));
            return FALSE;
        }
    }
    
    public function withdrawal_mtm()
    {
        if (!empty($this->uri->segment(4))) {
            $id_notif = $this->uri->segment(4);
        }

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_transfer_mtm         = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);
        $query_transfer_bonus_mtm   = $this->M_user->get_transfer_bonus($query_user['id'], 'mtm');
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'mtm');
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '2');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);
        $query_minimum_withdrawal   = $this->M_user->minimum_withdrawal();

        $data['title']              = $this->lang->line('withdrawal');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['general_balance_mtm'] = ($query_transfer_mtm['amount'] + $query_transfer_bonus_mtm['amount']) - $query_total_withdrawal['amount'] + $query_sum_deposit['coin'] - $query_total_purchase['mtm'];
        $data['fee_withdrawal']     = $query_minimum_withdrawal;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('wallet_address', 'Wallet Address', 'trim|required|callback_checkfirstcharm', [
                'required' => $this->lang->line('require_wallet_address')
            ]);
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required', [
                'required' => $this->lang->line('require_amount')
            ]);
            $this->form_validation->set_rules('fee', 'Fee', 'trim|required', [
                'required' => $this->lang->line('require_fee')
            ]);
            $this->form_validation->set_rules('total', 'Total', 'trim|required', [
                'required' => $this->lang->line('require_total')
            ]);
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required', [
                'required' => $this->lang->line('require_email_code')
            ]);
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required', [
                'required' => $this->lang->line('require_otp_code')
            ]);

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/mtm/withdrawal_mtm', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "=?UTF-8?B?".base64_encode($this->lang->line('checking_email'))."?=";
                    $message  = $this->lang->line('message_copy_code').": <br/><br/> $code";
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
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('message_register_otp').' > Goggle OTP</div>');
                    redirect('user/withdrawal_mtm');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $wallet = $this->input->post('wallet_address');
                    $amount = $this->input->post('amount');
                    $total = $this->input->post('total');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_email_code').'</div>');
                        redirect('user/withdrawal_mtm');
                    } else {
                        if ($amount > $data['general_balance_mtm']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('not_enough').' MTM</div>');
                            redirect('user/withdrawal_mtm');
                        } else {
                            if ($amount < $query_minimum_withdrawal['mtm']) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('minimum_amount_wd').' ' . $query_minimum_withdrawal['mtm'] . ' MTM</div>');
                                redirect('user/withdrawal_mtm');
                            } else {
                                $checkResult = $ga->verifyCode($secret, $otp_code);
                                if (!$checkResult) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('otp_code_wrong').'</div>');
                                    redirect('user/withdrawal_mtm');
                                } else {
                                     if (!empty($this->uri->segment(4))) {
                                        $id_wd = $this->uri->segment(3);
                                        $data_update = [
                                            'wallet_address' => $wallet,
                                            'amount' => $amount,
                                            'total' => $total,
                                            'note' => ''
                                        ];

                                        $update_cart = $this->M_user->update_data_byid('withdrawal', $data_update, 'id', $id_wd);


                                        $data_notif = [
                                            'is_show' => 1
                                        ];
                                        $id_notif = $this->uri->segment(4);
                                        $update_notif = $this->M_user->update_data_byid('notifi', $data_notif, 'id', $id_notif);

                                        if ($update_notif == true) {
                                            //update notification
                                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('request_wd_success').'</div>');
                                            redirect('user/mywalletmtm');
                                        } else {
                                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('request_wd_failed').'</div>');
                                            redirect('user/withdrawal_mtm');
                                        }
                                    } else {
                                        $withdrawal = [
                                            'user_id' => $user_id,
                                            'coin_type' => 'mtm',
                                            'wallet_address' => $wallet,
                                            'amount' => $amount,
                                            'total' => $total,
                                            'datecreate' => time(),
                                        ];
                                        $insert = $this->M_user->insert_data('withdrawal', $withdrawal);
                                        if ($insert == true) {
                                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('request_wd_success').'</div>');
                                            redirect('user/mywalletmtm');
                                        } else {
                                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('request_wd_failed').'</div>');
                                            redirect('user/withdrawal_mtm');
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }
    public function withdrawal_zenx()
    {
        if (!empty($this->uri->segment(3))) {
            $id_notif = $this->uri->segment(3);
        }

        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_minimum_withdrawal   = $this->M_user->minimum_withdrawal();
        $query_total_withdrawal     = $this->M_user->get_total_withdrawal($query_user['id'], 'zenx');
        $query_sum_deposit          = $this->M_user->get_sum_deposit($query_user['id'], '3');
        $query_total_purchase       = $this->M_user->sum_cart_byid($query_user['id']);

        $data['title']              = $this->lang->line('withdrawal');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['deposit']            = $this->M_user->get_deposit_general($query_user['id'], '3');
        $data['general']            = $query_sum_deposit['coin'] - $query_total_purchase['zenx'] - $query_total_withdrawal['amount'];
        $data['fee_withdrawal']     = $query_minimum_withdrawal;

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('wallet_address', 'Wallet Address', 'trim|required|callback_checkfirstcharz', [
                'required' => $this->lang->line('require_wallet_address')
            ]);
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required', [
                'required' => $this->lang->line('require_amount')
            ]);
            $this->form_validation->set_rules('fee', 'Fee', 'trim|required', [
                'required' => $this->lang->line('require_fee')
            ]);
            $this->form_validation->set_rules('total', 'Total', 'trim|required', [
                'required' => $this->lang->line('require_total')
            ]);
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required', [
                'required' => $this->lang->line('require_email_code')
            ]);
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required', [
                'required' => $this->lang->line('require_otp_code')
            ]);

            if ($this->form_validation->run() == false) 
            {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/zenx/withdrawal_zenx', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) 
                {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "=?UTF-8?B?".base64_encode($this->lang->line('checking_email'))."?=";
                    $message  = $this->lang->line('message_copy_code').": <br/><br/> $code";
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
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('message_register_otp').' > Goggle OTP</div>');
                    redirect('user/withdrawal_mtm');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $wallet = $this->input->post('wallet_address');
                    $amount = $this->input->post('amount');
                    $total = $this->input->post('total');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_email_code').'</div>');
                        redirect('user/withdrawal_zenx');
                    } else {
                        if ($amount > $data['general']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_email_code').'</div>');
                            redirect('user/withdrawal_zenx');
                        } else {
                            if ($amount < $query_minimum_withdrawal['zenx']) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('minimum_amount_wd').' ' . $query_minimum_withdrawal['zenx'] . ' ZENX</div>');
                                redirect('user/withdrawal_zenx');
                            } else {
                                $checkResult = $ga->verifyCode($secret, $otp_code);
                                if (!$checkResult) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('otp_code_wrong').'</div>');
                                    redirect('user/withdrawal_zenx');
                                } else {
                                     if (!empty($this->uri->segment(4))) {
                                        $id_wd = $this->uri->segment(3);
                                        $data_update = [
                                            'wallet_address' => $wallet,
                                            'amount' => $amount,
                                            'total' => $total,
                                            'note' => ''
                                        ];

                                        $update_cart = $this->M_user->update_data_byid('withdrawal', $data_update, 'id', $id_wd);


                                        $data_notif = [
                                            'is_show' => 1
                                        ];
                                        $id_notif = $this->uri->segment(4);
                                        $update_notif = $this->M_user->update_data_byid('notifi', $data_notif, 'id', $id_notif);

                                        if ($update_notif == true) {
                                            //update notification
                                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('request_wd_success').'</div>');
                                            redirect('user/mywalletzenx');
                                        } else {
                                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('request_wd_failed').'</div>');
                                            redirect('user/withdrawal_zenx');
                                        }
                                    } else {
                                        $withdrawal = [
                                            'user_id' => $user_id,
                                            'coin_type' => 'zenx',
                                            'wallet_address' => $wallet,
                                            'amount' => $amount,
                                            'total' => $total,
                                            'datecreate' => time(),
                                        ];
                                        $insert = $this->M_user->insert_data('withdrawal', $withdrawal);
                                        if ($insert == true) {
                                            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('request_wd_success').'</div>');
                                            redirect('user/mywalletzenx');
                                        } else {
                                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('request_wd_failed').'</div>');
                                            redirect('user/withdrawal_zenx');
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function transfer_mining_fil()
    {
        $query_user      = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total     = $this->M_user->get_total_byuser('mining_user', 'amount', 'user_id', $query_user['id']);
        $query_transfer  = $this->M_user->get_total_byuser('mining_user_transfer', 'amount', 'user_id', $query_user['id']);

        $data['title']        = $this->lang->line('trf_to_general');
        $data['user']         = $query_user;
        $data['amount_notif'] = $query_row_notif;
        $data['list_notif']   = $query_new_notif;
        $data['balance']      = $query_total['amount'] - $query_transfer['amount'];
        $data['cart']         = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required', [
                'required' => $this->lang->line('require_amount')
            ]);
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required', [
                'required' => $this->lang->line('require_email_code')
            ]);
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required', [
                'required' => $this->lang->line('require_otp_code')
            ]);

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/fill/transfer_mining_general', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "=?UTF-8?B?".base64_encode($this->lang->line('checking_email'))."?=";
                    $message  = $this->lang->line('message_copy_code').": <br/><br/> $code";
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
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('message_register_otp').' > Goggle OTP</div>');
                    redirect('user/transfer_mining_fil');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $amount = $this->input->post('amount');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_email_code').'</div>');
                        redirect('user/transfer_mining_fil');
                    } else {
                        if ($amount > $data['balance']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('not_enough').' filecoins</div>');
                            redirect('user/transfer_mining_fil');
                        } else {
                            $checkResult = $ga->verifyCode($secret, $otp_code);
                            if (!$checkResult) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('otp_code_wrong').'</div>');
                                redirect('user/transfer_mining_fil');
                            } else {
                                $data = [
                                    'user_id' => $user_id,
                                    'amount' => $amount,
                                    'datecreate' => time(),
                                ];
                                $insert = $this->M_user->insert_data('mining_user_transfer', $data);
                                if ($insert == true) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('success_trf_general').'</div>');
                                    redirect('user/bonusList/mining');
                                } else {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('failed_trf_general').'</div>');
                                    redirect('user/transfer_mining_fil');
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function usernameBasecamp($id)
    {
        $query = $this->M_user->get_username_basecamp($id);

        return $query['username'];
    }


    public function transfer_airdrops_mtm()
    {
        $query_user      = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total     = $this->M_user->get_total_byuser('airdrop_mtm', 'amount', 'user_id', $query_user['id']);
        $query_transfer  = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);

        $data['title']        = $this->lang->line('trf_to_general');
        $data['user']         = $query_user;
        $data['amount_notif'] = $query_row_notif;
        $data['list_notif']   = $query_new_notif;
        $data['balance']      = $query_total['amount'] - $query_transfer['amount'];
        $data['cart']         = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required', [
                'required' => $this->lang->line('require_amount')
            ]);
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required', [
                'required' => $this->lang->line('require_email_code')
            ]);
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required', [
                'required' => $this->lang->line('require_otp_code')
            ]);

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/mtm/transfer_airdrops_general', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "=?UTF-8?B?".base64_encode($this->lang->line('checking_email'))."?=";
                    $message  = $this->lang->line('message_copy_code').": <br/><br/> $code";
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
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('message_register_otp').' > Goggle OTP</div>');
                    redirect('user/transfer_airdrops_mtm');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $amount = $this->input->post('amount');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_email_code').'</div>');
                        redirect('user/transfer_airdrops_mtm');
                    } else {
                        if ($amount > $data['balance']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('not_enough').' MTM</div>');
                            redirect('user/transfer_airdrops_mtm');
                        } else {
                            $checkResult = $ga->verifyCode($secret, $otp_code);
                            if (!$checkResult) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('otp_code_wrong').'</div>');
                                redirect('user/transfer_airdrops_mtm');
                            } else {
                                $data = [
                                    'user_id' => $user_id,
                                    'amount' => $amount,
                                    'datecreate' => time(),
                                ];
                                $insert = $this->M_user->insert_data('airdrop_mtm_transfer', $data);
                                if ($insert == true) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('success_trf_general').'</div>');
                                    redirect('user/bonusList');
                                } else {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('failed_trf_general').'</div>');
                                    redirect('user/transfer_airdrops_mtm');
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function transfer_airdrops_zenx()
    {
        $query_user      = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total     = $this->M_user->get_total_byuser('airdrop_mtm', 'amount', 'user_id', $query_user['id']);
        $query_transfer  = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);

        $data['title']        = $this->lang->line('trf_to_general');
        $data['user']         = $query_user;
        $data['amount_notif'] = $query_row_notif;
        $data['list_notif']   = $query_new_notif;
        $data['balance']      = $query_total['amount'] - $query_transfer['amount'];
        $data['cart']         = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/zenx/transfer_airdrops_general', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function transfer_bonus_fil()
    {
        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total                = $this->M_user->get_total_bonus($query_user['id'])->row_array();
        $query_transfer_bonus_fill  = $this->M_user->get_transfer_bonus($query_user['id'], 'filecoin');

        $data['title']              = $this->lang->line('my_wallet');
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total_fil']          = $query_total['sponsorfil'] + $query_total['sponmatchingfil'] + $query_total['minmatching'] + $query_total['minpairing'];
        $data['balance']            = $data['total_fil'] - $query_transfer_bonus_fill['amount'];

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required',[
                'required' => $this->lang->line('require_amount')
            ]);
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required', [
                'required' => $this->lang->line('require_email_code')
            ]);
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required', [
                'required' => $this->lang->line('require_otp_code')
            ]);

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/fill/transfer_bonus_general', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "=?UTF-8?B?".base64_encode($this->lang->line('checking_email'))."?=";
                    $message  = $this->lang->line('message_copy_code').": <br/><br/> $code";
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
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('message_register_otp').' > Goggle OTP</div>');
                    redirect('user/transfer_bonus_fil');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $amount = $this->input->post('amount');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_email_code').'</div>');
                        redirect('user/transfer_bonus_fil');
                    } else {
                        if ($amount > $data['balance']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('not_enough').' filecoins</div>');
                            redirect('user/transfer_bonus_fil');
                        } else {
                            $checkResult = $ga->verifyCode($secret, $otp_code);
                            if (!$checkResult) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('otp_code_wrong').'</div>');
                                redirect('user/transfer_bonus_fil');
                            } else {
                                $data = [
                                    'user_id' => $user_id,
                                    'amount' => $amount,
                                    'coin_type' => 'filecoin',
                                    'datecreate' => time(),
                                ];
                                $insert = $this->M_user->insert_data('bonus_transfer_general', $data);
                                if ($insert == true) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('success_trf_general').'</div>');
                                    redirect('user/mywalletfil/bonus');
                                } else {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('failed_trf_general').'</div>');
                                    redirect('user/transfer_bonus_fil');
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function transfer_bonus_mtm()
    {
        $query_user                 = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif            = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif            = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total                = $this->M_user->get_total_bonus($query_user['id'])->row_array();
        $query_transfer_bonus_mtm   = $this->M_user->get_transfer_bonus($query_user['id'], 'mtm');

        $data['title']              = $this->lang->line('trf_to_general');
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_bysponsor($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['total_mtm']          = $query_total['sponsormtm'] + $query_total['sponmatchingmtm'] + $query_total['pairingmatch'] + $query_total['binarymatch'] + $query_total['bonusglobal'] + $query_total['basecampmtm'];
        $data['balance']            = $data['total_mtm'] - $query_transfer_bonus_mtm['amount'];

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->form_validation->set_rules('amount', 'Amount', 'trim|required', [
                'required' => $this->lang->line('require_amount')
            ]);
            $this->form_validation->set_rules('email_code', 'Email Code', 'trim|required', [
                'required' => $this->lang->line('require_email_code')
            ]);
            $this->form_validation->set_rules('otp_code', 'OTP Code', 'trim|required', [
                'required' => $this->lang->line('require_otp_code')
            ]);

            if ($this->form_validation->run() == false) {
                $this->load->view('templates/user_header', $data);
                $this->load->view('templates/user_sidebar', $data);
                $this->load->view('templates/user_topbar', $data);
                $this->load->view('user/wallet/mtm/transfer_bonus_general', $data);
                $this->load->view('templates/user_footer');

                if (isset($_POST['check'])) {
                    $email = $data['user']['email'];

                    $permitted_chars = '0123456789';
                    $code = substr(str_shuffle($permitted_chars), 0, 6);
                    $this->db->set('email_code', $code);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $subject = "=?UTF-8?B?".base64_encode($this->lang->line('checking_email'))."?=";
                    $message  = $this->lang->line('message_copy_code').": <br/><br/> $code";
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
                if ($data['user']['is_otp'] == '0') {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('message_register_otp').' > Goggle OTP</div>');
                    redirect('user/transfer_bonus_mtm');
                } else {
                    $ga = new GoogleAuthenticator();
                    $secret = $data['user']['secret_otp'];

                    $amount = $this->input->post('amount');
                    $email_code = $this->input->post('email_code');
                    $otp_code = $this->input->post('otp_code');
                    $user_id = $data['user']['id'];

                    if ($data['user']['email_code'] != $email_code) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('wrong_email_code').'</div>');
                        redirect('user/transfer_bonus_mtm');
                    } else {
                        if ($amount > $data['balance']) {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('not_enough').' MTM</div>');
                            redirect('user/transfer_bonus_mtm');
                        } else {
                            $checkResult = $ga->verifyCode($secret, $otp_code);
                            if (!$checkResult) {
                                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('otp_code_wrong').'</div>');
                                redirect('user/transfer_bonus_mtm');
                            } else {
                                $data = [
                                    'user_id' => $user_id,
                                    'amount' => $amount,
                                    'coin_type' => 'mtm',
                                    'datecreate' => time(),
                                ];
                                $insert = $this->M_user->insert_data('bonus_transfer_general', $data);
                                if ($insert == true) {
                                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">'.$this->lang->line('success_trf_general').'</div>');
                                    redirect('user/mywalletmtm/bonus');
                                } else {
                                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">'.$this->lang->line('failed_trf_general').'</div>');
                                    redirect('user/transfer_bonus_mtm');
                                }
                            }
                        }
                    }
                }
            }
        } else {
            redirect('auth');
        }
    }

    public function transfer_bonus_zenx()
    {
        $query_user      = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total     = $this->M_user->get_total_byuser('airdrop_mtm', 'amount', 'user_id', $query_user['id']);
        $query_transfer  = $this->M_user->get_total_byuser('airdrop_mtm_transfer', 'amount', 'user_id', $query_user['id']);

        $data['title']        = $this->lang->line('bonus_balance');
        $data['user']         = $query_user;
        $data['amount_notif'] = $query_row_notif;
        $data['list_notif']   = $query_new_notif;
        $data['balance']      = $query_total['amount'] - $query_transfer['amount'];
        $data['cart']         = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/wallet/zenx/transfer_bonus_general', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }

    public function filDeposit()
    {
        $user  = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //Validation Proses
        $this->form_validation->set_rules('txid', 'TXID', 'required|trim');
        $this->form_validation->set_rules('fil', 'Coin quantity', 'required');

        if ($this->form_validation->run() == false) //check validation
        {
        }
        //echo $user['id'];
    }
    
    public function bonusBasecamp()
    {
        $this->_unset_payment();
        $date = date('Y-m-d');
        $month = date('m');

        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);
        $query_total        = $this->M_user->get_total_basecamp_byid($query_user['id']);
        $query_total_box    = $this->M_user->get_total_basecampbox_byid($query_user['id']);
        $query_total_excess = $this->M_user->get_total_excess_basecamp_byid($query_user['id']);
        $query_total_collected = $this->M_user->get_total_collected_basecamp_byid($query_user['id']);
        $query_total_collected_box = $this->M_user->get_total_collectedbox_basecamp_byid($query_user['id']);

        $basecamp = $query_user['basecamp'] ?? null;

        $data['title']              = $this->lang->line('basecamp');
        $data['user']               = $query_user;
        $data['bonus']              = $this->M_user->get_bonus_basecamp($query_user['id']);
        $data['bonus_excess']       = $this->M_user->get_excess_basecamp($query_user['id']);
        $data['bonus_collected']    = $this->M_user->get_collected_basecamp($query_user['id']);
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['userClass']          = $this;
        $data['payment']            = $this->M_user->show_cart_byid($query_user['id']);
        $data['today_omset']        = $this->M_user->get_today_purchase_basecamp($date, $basecamp);
        $data['total_omset']        = $this->M_user->get_current_purchase_basecamp($date, $basecamp);
        $data['today_omset_box']    = $this->M_user->get_today_purchasebox_basecamp($date, $basecamp);
        $data['total_omset_box']    = $this->M_user->get_current_purchasebox_basecamp($month, $basecamp);
        $data['total']              = $query_total['mtm'];
        $data['total_box']          = $query_total_box['point'];
        $data['total_excess']       = $query_total_excess['mtm'];
        $data['total_collected']    = $query_total_collected['mtm'];
        $data['total_collected_box']= $query_total_collected_box['point'];

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/bonus/basecamp', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
    
    public function news_announcement()
    {
        $this->_unset_payment();
        $query_user         = $this->M_user->get_user_byemail($this->session->userdata('email'));
        $query_row_notif    = $this->M_user->row_newnotif_byuser($query_user['id']);
        $query_new_notif    = $this->M_user->show_newnotif_byuser($query_user['id']);

        if ($query_user['is_news'] == 0) {
            $data_news = [
                'is_news' => 1
            ];
            $update_news = $this->M_user->update_data_byid('user', $data_news, 'id', $query_user['id']);
        }

        $data['title']              = $this->lang->line('news');
        $data['user']               = $query_user;
        $data['amount_notif']       = $query_row_notif;
        $data['list_notif']         = $query_new_notif;
        $data['cart']               = $this->M_user->show_home_withsumpoint($query_user['id'])->row_array();
        $data['userClass']          = $this;
        $data['payment']            = $this->M_user->show_cart_byid($query_user['id']);
        $data['news']               = $this->M_user->get_all_news()->result();

        if ($this->session->userdata('email') && $this->session->userdata('role_id') == '2') {
            $this->load->view('templates/user_header', $data);
            $this->load->view('templates/user_sidebar', $data);
            $this->load->view('templates/user_topbar', $data);
            $this->load->view('user/news_announcement', $data);
            $this->load->view('templates/user_footer');
        } else {
            redirect('auth');
        }
    }
}
