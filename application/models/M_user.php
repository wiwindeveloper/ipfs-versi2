<?php

use GuzzleHttp\Psr7\Message;

class M_user extends CI_Model
{
    public function get_alluser_payment()
    {
        return $this->db->select('user_id')
            ->from('cart')
            ->where('is_payment', 1)
            ->get();
    }

    public function get_alluser_payment_one()
    {
        return $this->db->select('user_id')
            ->from('cart')
            ->where(['is_payment' => 1, 'position_id !=' => 0])
            ->get();
    }

    public function get_userpayment_fm_bsecamp()
    {
        return $this->db->select('cart.user_id, level_fm.fm, user.is_camp')
            ->from('cart')
            ->join('level_fm', 'level_fm.user_id = cart.user_id')
            ->join('user', 'user.id = cart.user_id')
            ->where('cart.is_payment', 1)
            ->get();
    }

    public function get_alluser_mining($date)
    {
        return $this->db->select('cart.id, cart.user_id, user.email, cart.datecreate, package.hashrate, package.name, package.airdrp_mtm, package.daysmining, package.point')
            ->from('cart')
            ->join('package', 'package.id = cart.package_id')
            ->join('user', 'user.id = cart.user_id')
            ->where(['cart.is_payment' => 1, 'cart.pause_min !=' => '1', 'from_unixtime(cart.datecreate, "%Y-%m-%d") <' => $date])
            ->get();
    }

    public function get_user_notinbalance($date)
    {
        return $this->db->select('cart.user_id')
            ->from('cart')
            ->where('cart.is_payment', 1)
            ->where('cart.user_id NOT IN (SELECT balance_point.user_id FROM balance_point WHERE from_unixtime(balance_point.datecreate, "%Y-%m-%d") = "' . $date . '")', NULL, FALSE)
            ->get();
    }

    public function get_all_user($username)
    {
        return $this->db->select('*')
            ->from('user')
            ->like('username', $username)
            ->count_all_results();
    }
        public function count_all_user()
    {
        return $this->db->select('*')
            ->from('user')
            ->count_all_results();
    }

    public function get_user_byid($id)
    {
        return $this->db->get_where('user', ['id' => $id])->row_array();
    }

    public function get_user_byemail($email)
    {
        return $this->db->get_where('user', ['email' => $email])->row_array();
    }

    public function get_user_byusername($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row_array();
    }

    public function insert_user($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    public function insert_token($table, $data)
    {
        return $this->db->insert($table, $data);
    }
    public function get_token_byemail($email)
    {
        return $this->db->order_by('user_token.date_create', 'DESC')->get_where('user_token', ['email' => $email])->row_array();
    }

    public function show_package($type)
    {
        $query = $this->db->where('type', $type)->get('package');
        return $query->result();
    }

    public function get_package_byid($id)
    {
        return $this->db->get_where('package', ['id' => $id])->row_array();
    }
    public function get_packagetour_byid($id)
    {
        return $this->db->get_where('package_tour', ['id' => $id])->row_array();
    }

    public function get_member_byusername($username)
    {
        return $this->db->select('cart.user_id')
            ->from('cart')
            ->join('user', 'cart.user_id = user.id')
            ->where(['user.username' => $username, 'cart.is_payment' => 1, 'user.role_id' => 2])
            ->get()->row_array();
    }

    public function get_mactching_id($id)
    {
        return $this->db->get_where('cart', ['cart.user_id' => $id])->row_array();
    }

    public function check_line($id, $line)
    {
        return $this->db->get_where('cart', ['position_id' => $id, 'line' => $line])->row_array();
    }

    public function insert_cart($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    public function update_payment_status($is, $id)
    {
        $this->db->set('is_payment', $is)->where('id', $id)->update('cart');
        return true;
    }

    public function show_cart_byid($id)
    {
        return $this->db->select('cart.id, cart.datecreate, cart.update_date, package.name, package.type, cart.fill, cart.usdt, cart.mtm, cart.zenx, cart.usdt, cart.krp, cart.is_payment')
            ->from('cart')
            ->join('package', 'cart.package_id = package.id')
            ->where('cart.user_id', $id)
            ->get()->result();
    }

    public function sum_cart_byid($id)
    {
        return $this->db->select_sum('cart.fill')
            ->select_sum('cart.usdt')
            ->select_sum('cart.krp')
            ->from('cart')
            ->join('package', 'cart.package_id = package.id')
            ->where('cart.user_id', $id)
            ->get()->row_array();
    }

    public function get_purchase_fill_byid($user_id)
    {
        return $this->db->select('cart.id, cart.fill, cart.datecreate, package.name')
            ->from('cart')
            ->join('package', 'package.id =  cart.package_id')
            ->where(['cart.user_id' => $user_id, 'cart.fill !=' => 0])
            ->get()->result();
    }

    public function get_purchase_mtm_byid($user_id)
    {
        return $this->db->select('cart.id, cart.mtm, cart.datecreate, package.name')
            ->from('cart')
            ->join('package', 'package.id =  cart.package_id')
            ->where(['cart.user_id' => $user_id, 'cart.mtm !=' =>  0])
            ->get()->result();
    }

    public function get_purchase_zenx_byid($user_id)
    {
        return $this->db->select('cart.id, cart.zenx, cart.datecreate, package.name')
            ->from('cart')
            ->join('package', 'package.id =  cart.package_id')
            ->where(['cart.user_id' => $user_id, 'cart.zenx !=' => 0])
            ->get()->result();
    }

    public function get_purchase_usdt_byid($user_id)
    {
        return $this->db->select('cart.id, cart.usdt, cart.datecreate, package.name')
            ->from('cart')
            ->join('package', 'package.id =  cart.package_id')
            ->where(['cart.user_id' => $user_id, 'cart.usdt !=' => 0])
            ->get()->result();
    }

    public function get_purchase_krp_byid($user_id)
    {
        return $this->db->select('cart.id, cart.krp, cart.datecreate, package.name')
            ->from('cart')
            ->join('package', 'package.id =  cart.package_id')
            ->where(['cart.user_id' => $user_id, 'cart.krp !=' => 0])
            ->get()->result();
    }

    public function show_data_home($id)
    {
        return $this->db->select('cart.datecreate, cart.update_date, package.name, level_fm.fm, (SELECT user.username FROM user WHERE user.id = cart.sponsor_id) sponsor')
            ->from('cart')
            ->join('package', 'cart.package_id = package.id')
            ->join('level_fm', 'cart.user_id = level_fm.user_id')
            ->where(['cart.user_id' => $id, 'cart.is_payment' => 1])
            ->get();
    }

    public function show_all_byid($id, $table, $column)
    {
        return $this->db->select('*')
            ->from($table)
            ->where($column, $id)
            ->get()->result();
    }

    public function show_home_withsumpoint($id)
    {
        return $this->db->select('a.datecreate, a.update_date, (SELECT SUM(package.point) FROM cart JOIN package ON package.id = cart.package_id WHERE cart.user_id = a.user_id) name, level_fm.fm, (SELECT user.username FROM user WHERE user.id = a.sponsor_id) sponsor')
            ->from('cart as a')
            ->join('package', 'a.package_id = package.id')
            ->join('level_fm', 'a.user_id = level_fm.user_id')
            ->where(['a.user_id' => $id, 'a.is_payment' => 1, 'a.sponsor_id !=' => '0'])
            ->get();
    }

    public function get_cart_byusrid($id)
    {
        return $this->db->select('package.name')
            ->from('cart')
            ->join('package', 'cart.package_id = package.id')
            ->where('cart.user_id', $id)
            ->get();
    }

    public function get_box_fm($id)
    {
        return $this->db->select('package.name, package.color, level_fm.fm')
            ->from('cart')
            ->join('package', 'cart.package_id = package.id')
            ->join('level_fm', 'cart.user_id = level_fm.user_id')
            ->where('cart.user_id', $id)
            ->get();
    }

    public function get_cart_byid($id)
    {
        return $this->db->get_where('cart', ['id' => $id])->row_array();
    }

    public function get_cart_useremail($id)
    {
        return $this->db->select('cart.*, user.email')
            ->from('cart')
            ->join('user', 'user.id = cart.user_id')
            ->where('cart.id', $id)
            ->get()
            ->row_array();
    }

    public function get_bonus_bysponsor($id)
    {
        return $this->db->select('bonus.datecreate, user.username, bonus.filecoin, bonus.mtm, bonus.usdt, bonus.krp')
            ->from('bonus')
            ->join('cart', 'bonus.cart_id = cart.id')
            ->join('user', 'cart.user_id = user.id')
            ->where('bonus.user_id', $id)
            ->order_by('bonus.datecreate', 'DESC')
            ->get()->result();
    }

    public function get_bonus_bysponsormatching($id)
    {
        return $this->db->select('bonus_sm.datecreate, user.username, bonus_sm.filecoin, bonus_sm.mtm, bonus_sm.usdt, bonus_sm.krp')
            ->from('bonus_sm')
            ->join('cart', 'bonus_sm.cart_id = cart.id')
            ->join('user', 'cart.user_id = user.id')
            ->where('bonus_sm.user_id', $id)
            ->order_by('bonus_sm.datecreate', 'DESC')
            ->get()->result();
    }

    public function get_bonus_pairingmatching($id)
    {
        return $this->db->select('bonus_maxmatching.id, user.username, bonus_maxmatching.krp, bonus_maxmatching.usdt, bonus_maxmatching.set_amount, bonus_maxmatching.datecreate')
            ->from('bonus_maxmatching')
            ->join('user', 'user.id = bonus_maxmatching.user_id')
            ->where('bonus_maxmatching.user_id', $id)
            ->order_by('bonus_maxmatching.datecreate', 'DESC')
            ->get()->result();
    }

    public function get_bonus_miningmatching($id)
    {
        return $this->db->select('bonus_minmatching.id, user.username, member_id, team, amount, bonus_minmatching.datecreate')
            ->from('bonus_minmatching')
            ->join('user', 'user.id = bonus_minmatching.member_id')
            ->where('user_id', $id)
            ->order_by('datecreate', 'DESC')
            ->get()->result();
    }

    public function get_bonus_miningmatching_usdt($id)
    {
        return $this->db->select('bonus_minmatching.id, user.username, bonus_minmatching.member_id, bonus_minmatching.team, bonus_minmatching.usdt, bonus_minmatching.datecreate')
            ->from('bonus_minmatching')
            ->join('user', 'user.id = bonus_minmatching.member_id')
            ->where(['user_id' => $id, 'bonus_minmatching.usdt != ' => 0])
            ->order_by('datecreate', 'DESC')
            ->get()->result();
    }

    public function get_bonus_miningmatching_krp($id)
    {
        return $this->db->select('bonus_minmatching.id, user.username, bonus_minmatching.member_id, bonus_minmatching.team, bonus_minmatching.krp, bonus_minmatching.datecreate')
            ->from('bonus_minmatching')
            ->join('user', 'user.id = bonus_minmatching.member_id')
            ->where(['user_id' => $id, 'bonus_minmatching.krp != ' => 0])
            ->order_by('datecreate', 'DESC')
            ->get()->result();
    }

    public function get_bonus_miningpairing($id)
    {
        return $this->db->select('bonus_minpairing.datecreate, user.username, bonus_minpairing.member_sponsor, bonus_minpairing.generation, bonus_minpairing.team, bonus_minpairing.amount')
            ->from('bonus_minpairing')
            ->join('user', 'user.id = bonus_minpairing.user_sponsor')
            ->where('bonus_minpairing.user_id ', $id)
            ->order_by('bonus_minpairing.datecreate', 'DESC');
    }

    public function get_bonus_miningpairing_usdt($id)
    {
        return $this->db->select('bonus_minpairing.datecreate, user.username, bonus_minpairing.member_sponsor, bonus_minpairing.generation, bonus_minpairing.team, bonus_minpairing.krp')
            ->from('bonus_minpairing')
            ->join('user', 'user.id = bonus_minpairing.user_sponsor')
            ->where(['bonus_minpairing.user_id' => $id, 'bonus_minpairing.krp != ' => '0'])
            ->order_by('bonus_minpairing.datecreate', 'DESC')
            ->get()->result();
    }

    public function get_bonus_binarymatch($id)
    {
        return $this->db->select('bonus_binarymatch.id, user.username, bonus_binarymatch.generation, bonus_binarymatch.krp, bonus_binarymatch.usdt, bonus_binarymatch.datecreate')
            ->from('bonus_binarymatch')
            ->join('user', 'bonus_binarymatch.user_sponsor = user.id')
            ->where('bonus_binarymatch.user_id', $id)
            ->order_by('bonus_binarymatch.datecreate', 'DESC')
            ->get()->result();
    }

    // public function get_bonus_global($id)
    // {
    //     return $this->db->select('bonus_global.id, user.username, bonus_global.mtm, bonus_global.datecreate, SUM(package.fil) AS total')
    //         ->from('bonus_global')
    //         ->join('user', 'bonus_global.user_id = user.id')
    //         ->from('cart', 'user.id = cart.user_id')
    //         ->join('package', 'package.id = cart.package_id')
    //         ->where('bonus_global.user_id', $id)
    //         ->group_by(['YEAR(DATE_FORMAT(FROM_UNIXTIME(cart.datecreate), "%Y-%m-%d"))', 'MONTH(DATE_FORMAT(FROM_UNIXTIME(cart.datecreate), "%Y-%m-%d"))'])
    //         ->order_by('bonus_global.datecreate', 'DESC')
    //         ->get()->result();
    // }

    public function get_bonus_global($id)
    {
        return $this->db->select('bonus_global.id, user.username, bonus_global.mtm, bonus_global.note_level, bonus_global.level_fm, bonus_global.datecreate')
            ->from('bonus_global')
            ->join('user', 'bonus_global.user_id = user.id')
            ->where('bonus_global.user_id', $id)
            ->where('mtm !=', 0)
            ->order_by('bonus_global.datecreate', 'DESC')
            ->get()->result();
    }

    public function get_bonus_global_usdt($id)
    {
        return $this->db->select('bonus_global.id, user.username, bonus_global.usdt, bonus_global.note_level, bonus_global.level_fm, bonus_global.datecreate')
            ->from('bonus_global')
            ->join('user', 'bonus_global.user_id = user.id')
            ->where('bonus_global.user_id', $id)
            ->where('usdt !=', 0)
            ->order_by('bonus_global.datecreate', 'DESC')
            ->get()->result();
    }

    public function get_omset_global($date)
    {
        return $this->db->select('SUM(cart.fill) AS total_fil, SUM(cart.usdt) AS total_usdt, SUM(cart.krp) AS total_krp')
            ->from('cart')
            ->where('from_unixtime(cart.datecreate, "%Y-%m") = "'.$date.'"')
            ->get()->row_array();
    }

    public function get_bonus_basecamp2($id)
    {
        return $this->db->select('bonus_basecamp.update_date, user.username, bonus_basecamp.cart_id, bonus_basecamp.team, bonus_basecamp.filecoin, bonus_basecamp.mtm, bonus_basecamp.usdt, bonus_basecamp.krp, bonus_basecamp.type')
            ->from('bonus_basecamp')
            ->join('cart', 'bonus_basecamp.cart_id = cart.id')
            ->join('user', 'cart.user_id = user.id')
            ->where(['bonus_basecamp.user_id' => $id, 'bonus_basecamp.status' => '1'])
            ->order_by('bonus_basecamp.update_date', 'DESC')
            ->get()->result();
    }
    
    public function get_bonus_basecamp($id)
    {
        return $this->db->select('user.username, basecamp_name.name AS bs_name, bonus_basecamp.update_date, bonus_basecamp.cart_id, bonus_basecamp.team, bonus_basecamp.usdt, bonus_basecamp.type, package.name')
            ->from('bonus_basecamp')
            ->join('cart', 'bonus_basecamp.cart_id = cart.id')
            ->join('user', 'cart.user_id = user.id')
            ->join('package', 'package.id = cart.package_id')
            ->join('basecamp_name', 'bonus_basecamp.id_bs = basecamp_name.id', 'left')
            ->where(['bonus_basecamp.user_id' => $id, 'status' => '1', 'bonus_basecamp.usdt !=' => '0'])
            ->order_by('bonus_basecamp.update_date', 'DESC')
            ->get()->result();
    }

    public function get_cart_bynetwork($id)
    {
        return $this->db->select('cart.is_payment, package.color')
            ->from('cart')
            ->join('package', 'cart.package_id = package.id')
            ->where('cart.user_id', $id)
            ->get()->row_array();
    }

    public function get_network_byposition($id)
    {
        return $this->db->select('user.username, user.country_code, cart.user_id, cart.is_payment, package.name, package.color, level_fm.fm')
            ->from('cart')
            ->join('user', 'cart.user_id = user.id')
            ->join('package', 'package.id = cart.package_id')
            ->join('level_fm', 'level_fm.user_id = cart.user_id')
            ->where(['cart.position_id' => $id, 'cart.is_payment' => 1])
            ->order_by('cart.line', 'ASC')
            ->get()->result();
    }

    public function get_cart_bysponsor($id)
    {
        return $this->db->select('user.*, cart.id AS cart_id, package.color')
            ->from('user')
            ->join('cart', 'user.id = cart.user_id')
            ->join('package', 'cart.package_id = package.id')
            ->where('user.id', $id)
            ->get()->row_array();
    }

    public function get_network_bysponsor($id)
    {
        return $this->db->select('user.username, cart.user_id, package.color, cart.is_payment')
            ->from('cart')
            ->join('user', 'cart.user_id = user.id')
            ->join('package', 'package.id = cart.package_id')
            ->where(['cart.sponsor_id' => $id, 'cart.is_payment' => 1])
            ->get()->row_array();
    }

    public function get_sponsor_member($id, $limit, $offset)
    {
        return $this->db->select('user.username, cart.user_id, package.color, cart.is_payment, user.country_code, package.name, level_fm.fm')
            ->from('cart')
            ->join('user', 'cart.user_id = user.id')
            ->join('level_fm', 'level_fm.user_id = cart.user_id')
            ->join('package', 'package.id = cart.package_id')
            ->where(['cart.sponsor_id' => $id, 'cart.is_payment' => 1])
            ->limit($limit, $offset)
            ->get()->result();
    }
    public function get_sponsor_member1($id)
    {
        return $this->db->select('user.username, cart.user_id, package.color, cart.is_payment, user.country_code, package.name, level_fm.fm')
            ->from('cart')
            ->join('user', 'cart.user_id = user.id')
            ->join('level_fm', 'level_fm.user_id = cart.user_id')
            ->join('package', 'package.id = cart.package_id')
            ->where(['cart.sponsor_id' => $id, 'cart.is_payment' => 1])
            ->get()->result();
    }

    public function get_totaluser_byposition($id)
    {
        return $this->db->select('user_id')
            ->from('cart')
            ->where(['position_id' => $id, 'is_payment' => 1])
            ->get();
    }

    public function get_totaluser_bysponsor($id)
    {
        return $this->db->select('user_id')
            ->from('cart')
            ->where(['sponsor_id' => $id, 'is_payment' => 1])
            ->get();
    }

    public function get_totalpoin_byposition($id)
    {
        return $this->db->select('(SELECT SUM(b.point) FROM cart as a JOIN package as b ON b.id = a.package_id WHERE a.user_id = cart.user_id) point, cart.user_id, cart.datecreate')
            ->from('cart')
            ->join('package', 'cart.package_id = package.id')
            ->where(['cart.position_id' => $id, 'cart.is_payment' => 1])
            ->get();
    }

    public function get_poin_bysponsor($id)
    {
        return $this->db->select('cart.user_id, package.point')
            ->from('cart')
            ->join('package', 'package.id = cart.package_id')
            ->where(['cart.sponsor_id' => $id, 'cart.is_payment' => 1])
            ->get();
    }

    public function get_userid_bysponsor($id)
    {
        return $this->db->select('cart.user_id')
            ->from('cart')
            ->where(['cart.sponsor_id' => $id, 'cart.is_payment' => 1])
            ->order_by('cart.datecreate', 'ASC')
            ->get();
    }

    public function get_todaypoin_byposition($id, $date)
    {
        return $this->db->select('package.point, cart.user_id')
            ->from('cart')
            ->join('package', 'cart.package_id = package.id')
            ->where(['cart.position_id' => $id, 'cart.is_payment' => 1, 'from_unixtime(cart.datecreate, "%Y-%m-%d") =' => $date])
            ->get();
    }

    public function get_point_byuserid($id)
    {
        return $this->db->select('(SELECT SUM(b.point) FROM cart as a JOIN package as b ON b.id = a.package_id WHERE a.user_id = cart.user_id) point, cart.datecreate, cart.update_date')
            ->from('cart')
            ->join('package', 'cart.package_id = package.id')
            ->where(['cart.user_id' => $id, 'cart.is_payment' => 1])
            ->get();
    }

    public function get_onepoint_byuser($id, $date)
    {
        return $this->db->select_sum('package.point')
            ->from('cart')
            ->join('package', 'cart.package_id = package.id')
            ->where(["cart.user_id" => $id, "cart.is_payment" => 1, "FROM_UNIXTIME(cart.datecreate, '%Y-%m-%d') =" => $date])
            ->get();
    }

    public function get_sumtodaypoint_byposition($id, $date)
    {
        return $this->db->select("cart.user_id, (SELECT SUM(b.point) FROM cart as a JOIN package b ON b.id = a.package_id WHERE a.user_id = cart.user_id AND FROM_UNIXTIME(a.datecreate, '%Y-%m-%d') = '$date') point")
            ->from('cart')
            ->where('cart.position_id', $id)
            ->get();
    }

    public function get_point_byuserid_now($id, $date)
    {
        return $this->db->select('package.point')
            ->from('cart')
            ->join('package', 'cart.package_id = package.id')
            ->where(['cart.user_id' => $id, 'cart.is_payment' => 1, 'from_unixtime(cart.datecreate, "%Y-%m-%d") = ' => $date])
            ->get();
    }

    //update payment status
    public function update_payment($status, $id)
    {
        return $this->db->set('is_payment', $status)->where('id', $id)->update('cart');
    }

    public function update_payment_withdate($data, $id)
    {
        return $this->db->where('id', $id)->update('cart', $data);
    }

    //update deposit
    public function update_deposit_withdate($data, $id)
    {
        return $this->db->where('id', $id)->update('deposit', $data);
    }

    //check bonus by cart id
    public function check_bonus_byid($id)
    {
        return $this->db->get_where('bonus', ['cart_id' => $id])->row_array();
    }

    //get bonus amount
    public function get_bonus_amount($id)
    {
        return $this->db->select('cart.user_id, cart.fill, cart.sponsor_id, cart.matching_id, package.id AS package_id, code_bonus.code, code_bonus.amount_sp, code_bonus.amount_sm, package.fil as price, user.id_basecamp')
            ->from('cart')
            ->join('package', 'cart.package_id = package.id')
            ->join('code_bonus', 'package.code_bonus = code_bonus.id')
            ->join('user', 'user.id = cart.user_id')
            ->where('cart.id', $id)
            ->get()
            ->row_array();
    }

    //insert data
    public function insert_data($table, $data)
    {
        return $this->db->insert($table, $data);
    }

    //insert notif get last id
    public function insert_notif($data)
    {
        $this->db->insert('notifi', $data);
        return $this->db->insert_id();
    }

    //show notif by id and userid
    public function show_notif_byuser($id, $userid)
    {
        return $this->db->select('*')
            ->from('notifi')
            ->where(['id' => $id, 'user_id' => $userid])
            ->get()
            ->row_array();
    }

    public function show_newnotif_byuser($userid)
    {
        return $this->db->select('*')
            ->from('notifi')
            ->where(['user_id' => $userid, 'is_show' => 0])
            ->order_by('is_show ASC', 'id DESC')
            ->limit(5, 0)
            ->get()->result();
    }

    public function row_newnotif_byuser($userid)
    {
        return $this->db->select('*')
            ->from('notifi')
            ->where(['user_id' => $userid, 'is_show' => 0])
            ->count_all_results();
    }

    //query all table bonus_set
    public function get_balance($id)
    {
        return $this->db->get_where('balance_point', ['user_id' => $id])->row_array();
    }

    //query get last balance by user id
    public function get_last_balance($id)
    {
        return $this->db->select('*')
            ->where('user_id', $id)
            ->order_by('datecreate', 'DESC')
            ->limit(1, 0)
            ->get('balance_point')
            ->row_array();
    }

    //query sum balance
    public function sum_balance($id)
    {
        return $this->db->select_sum('set_amount')
            ->from('bonus_maxmatching')
            ->where('user_id', $id)
            ->get()
            ->row_array();
    }

    //query sum leftover point
    public function sum_leftover($id)
    {
        return $this->db->select_sum('amount_left')
            ->select_sum('amount_right')
            ->from('leftovers_real')
            ->where('user_id', $id)
            ->get()
            ->row_array();
    }

    public function balance_now($id)
    {
        return $this->db->select('*')
            ->from('leftovers_real')
            ->where('user_id', $id)
            ->order_by('id', 'DESC')
            ->limit(1, 0)
            ->get();
    }

    public function balance_now_nol($id)
    {
        return $this->db->select('*')
            ->from('balance_point')
            ->where('user_id', $id)
            ->order_by('id', 'DESC')
            ->limit(1, 0)
            ->get();
    }

    //update data by id
    public function update_data_byid($table, $data, $column, $id)
    {
        return $this->db->update($table, $data, [$column => $id]);
    }

    //select row by date
    public function row_data_bydate($table, $column, $date)
    {
        return $this->db->select('*')
            ->from($table)
            ->where(['from_unixtime(' . $column . ', "%Y-%m-%d") =' => $date])
            ->count_all_results();
    }

    //select data by date
    public function get_data_bydate($table, $column, $date)
    {
        return $this->db->select('*')
            ->from($table)
            ->where(['from_unixtime(' . $column . ', "%Y-%m-%d") =' => $date])
            ->get();
    }

    //select data by date and id
    public function get_data_bydate_id($table, $column, $date, $column2, $id)
    {
        return $this->db->select('*')
            ->from($table)
            ->where(["FROM_UNIXTIME($column, '%Y-%m-%d') =" => $date, $column2 => $id])
            ->get();
    }

    //select row by date and user
    public function row_data_bydate_user($table, $column1, $column2, $data1, $data2)
    {
        return $this->db->select('*')
            ->from($table)
            ->where(['from_unixtime(' . $column1 . ', "%Y-%m-%d") =' => $data1, $column2 => $data2])
            ->count_all_results();
    }

    //select row by date, user and other
    public function row_data_byother($table, $column1, $column2, $column3, $data1, $data2, $data3)
    {
        return $this->db->select('*')
            ->from($table)
            ->where(['from_unixtime(' . $column1 . ', "%Y-%m-%d") =' => $data1, $column2 => $data2, $column3 => $data3])
            ->count_all_results();
    }

    public function row_data_fourcolumn($table, $column1, $column2, $column3, $column4, $data1, $data2, $data3, $data4)
    {
        return $this->db->select('*')
            ->from($table)
            ->where(["FROM_UNIXTIME($column1, '%Y-%m-%d') =" => $data1, $column2 => $data2, $column3 => $data3, $column4 => $data4])
            ->count_all_results();
    }

    //select row by 5 column
    public function row_data_fivecolumn($table, $column1, $column2, $column3, $column4, $column5, $data1, $data2, $data3, $data4, $data5)
    {
        return $this->db->select('*')
            ->from($table)
            ->where(['from_unixtime(' . $column1 . ', "%Y-%m-%d") =' => $data1, $column2 => $data2, $column3 => $data3, $column4 => $data4, $column5 => $data5])
            ->count_all_results();
    }

    //select row by 6 column
    public function row_data_sixcolumn($table, $column1, $column2, $column3, $column4, $column5, $column6, $data1, $data2, $data3, $data4, $data5, $data6)
    {
        return $this->db->select('*')
            ->from($table)
            ->where(["FROM_UNIXTIME($column1, '%Y-%m-%d') =" => $data1, $column2 => $data2, $column3 => $data3, $column4 => $data4, $column5 => $data5, $column6 => $data6])
            ->count_all_results();
    }

    //select row by one condition
    public function row_data_byuser($table, $column, $id)
    {
        return $this->db->select('*')
            ->from($table)
            ->where($column, $id)
            ->count_all_results();
    }

    //select data by date and user
    public function get_data_bydate_user($table, $column1, $column2, $data1, $data2)
    {
        return $this->db->select('*')
            ->from($table)
            ->where(['from_unixtime(' . $column1 . ', "%Y-%m-%d") =' => $data1, $column2 => $data2])
            ->get();
    }

    public function get_today_bonus($date, $id)
    {
        return $this->db->select('user.id,
                                    (SELECT sum(bonus.usdt) FROM bonus WHERE bonus.user_id = user.id AND from_unixtime(bonus.datecreate, "%Y-%m-%d") = "' . $date . '") sponsorusdt,
                                    (SELECT sum(bonus.krp) FROM bonus WHERE bonus.user_id = user.id AND from_unixtime(bonus.datecreate, "%Y-%m-%d") = "' . $date . '") sponsorkrp,
                                    (SELECT sum(bonus_sm.usdt) FROM bonus_sm WHERE bonus_sm.user_id = user.id AND from_unixtime(bonus_sm.datecreate, "%Y-%m-%d") = "' . $date . '") sponmatchingusdt,
                                    (SELECT sum(bonus_sm.krp) FROM bonus_sm WHERE bonus_sm.user_id = user.id AND from_unixtime(bonus_sm.datecreate, "%Y-%m-%d") = "' . $date . '") sponmatchingkrp,
                                    (SELECT sum(bonus_maxmatching.usdt) FROM bonus_maxmatching WHERE bonus_maxmatching.user_id = user.id AND from_unixtime(bonus_maxmatching.datecreate, "%Y-%m-%d") = "' . $date . '") pairingmatchusdt,
                                    (SELECT sum(bonus_maxmatching.krp) FROM bonus_maxmatching WHERE bonus_maxmatching.user_id = user.id AND from_unixtime(bonus_maxmatching.datecreate, "%Y-%m-%d") = "' . $date . '") pairingmatchkrp,
                                    (SELECT sum(bonus_minmatching.usdt) FROM bonus_minmatching WHERE bonus_minmatching.user_id = user.id AND from_unixtime(bonus_minmatching.datecreate, "%Y-%m-%d") = "' . $date . '") minmatchingusdt,
                                    (SELECT sum(bonus_minmatching.krp) FROM bonus_minmatching WHERE bonus_minmatching.user_id = user.id AND from_unixtime(bonus_minmatching.datecreate, "%Y-%m-%d") = "' . $date . '") minmatchingkrp,
                                    (SELECT sum(bonus_minpairing.usdt) FROM bonus_minpairing WHERE bonus_minpairing.user_id = user.id AND from_unixtime(bonus_minpairing.datecreate, "%Y-%m-%d") = "' . $date . '") minpairingusdt,
                                    (SELECT sum(bonus_minpairing.krp) FROM bonus_minpairing WHERE bonus_minpairing.user_id = user.id AND from_unixtime(bonus_minpairing.datecreate, "%Y-%m-%d") = "' . $date . '") minpairingkrp,
                                    (SELECT sum(bonus_binarymatch.usdt) FROM bonus_binarymatch WHERE bonus_binarymatch.user_id = user.id AND from_unixtime(bonus_binarymatch.datecreate, "%Y-%m-%d") = "' . $date . '") binarymatchusdt,
                                    (SELECT sum(bonus_binarymatch.krp) FROM bonus_binarymatch WHERE bonus_binarymatch.user_id = user.id AND from_unixtime(bonus_binarymatch.datecreate, "%Y-%m-%d") = "' . $date . '") binarymatchkrp,
                                    (SELECT sum(bonus_global.usdt) FROM bonus_global WHERE bonus_global.user_id = user.id AND from_unixtime(bonus_global.datecreate, "%Y-%m-%d") = "' . $date . '") bonusglobalusdt,
                                    (SELECT sum(bonus_global.krp) FROM bonus_global WHERE bonus_global.user_id = user.id AND from_unixtime(bonus_global.datecreate, "%Y-%m-%d") = "' . $date . '") bonusglobalkrp,
                                    (SELECT sum(bonus_basecamp.usdt) FROM bonus_basecamp WHERE bonus_basecamp.user_id = user.id AND bonus_basecamp.status = 1 AND from_unixtime(bonus_basecamp.update_date, "%Y-%m-%d") = "' . $date . '") basecampusdt,
                                    (SELECT sum(bonus_basecamp.krp) FROM bonus_basecamp WHERE bonus_basecamp.user_id = user.id AND bonus_basecamp.status = 1 AND from_unixtime(bonus_basecamp.update_date, "%Y-%m-%d") = "' . $date . '") basecampkrp,')
            ->from('user')
            ->where('user.id', $id)
            ->get();
    }

    public function get_total_bonus($id)
    {
        return $this->db->select('user.id, 
                                    (SELECT sum(bonus.usdt) FROM bonus WHERE bonus.user_id = user.id) sponsorusdt, 
                                    (SELECT sum(bonus.krp) FROM bonus WHERE bonus.user_id = user.id) sponsorkrp, 
                                    (SELECT sum(bonus_sm.usdt) FROM bonus_sm WHERE bonus_sm.user_id = user.id) sponmatchingusdt, 
                                    (SELECT sum(bonus_sm.krp) FROM bonus_sm WHERE bonus_sm.user_id = user.id) sponmatchingkrp,
                                    (SELECT sum(bonus_maxmatching.usdt) FROM bonus_maxmatching WHERE bonus_maxmatching.user_id = user.id) pairingmatchusdt,
                                    (SELECT sum(bonus_maxmatching.krp) FROM bonus_maxmatching WHERE bonus_maxmatching.user_id = user.id) pairingmatchkrp,
                                    (SELECT sum(bonus_minmatching.usdt) FROM bonus_minmatching WHERE bonus_minmatching.user_id = user.id) minmatchingusdt,
                                    (SELECT sum(bonus_minmatching.krp) FROM bonus_minmatching WHERE bonus_minmatching.user_id = user.id) minmatchingkrp,
                                    (SELECT sum(bonus_minpairing.usdt) FROM bonus_minpairing WHERE bonus_minpairing.user_id = user.id) minpairingusdt,
                                    (SELECT sum(bonus_minpairing.krp) FROM bonus_minpairing WHERE bonus_minpairing.user_id = user.id) minpairingkrp,
                                    (SELECT sum(bonus_binarymatch.usdt) FROM bonus_binarymatch WHERE bonus_binarymatch.user_id = user.id) binarymatchusdt,
                                    (SELECT sum(bonus_binarymatch.krp) FROM bonus_binarymatch WHERE bonus_binarymatch.user_id = user.id) binarymatchkrp,
                                    (SELECT sum(bonus_global.usdt) FROM bonus_global WHERE bonus_global.user_id = user.id) bonusglobalusdt,
                                    (SELECT sum(bonus_global.krp) FROM bonus_global WHERE bonus_global.user_id = user.id) bonusglobalkrp,
                                    (SELECT sum(bonus_basecamp.usdt) FROM bonus_basecamp WHERE bonus_basecamp.user_id = user.id and bonus_basecamp.status = 1) basecampusdt,
                                    (SELECT sum(bonus_basecamp.krp) FROM bonus_basecamp WHERE bonus_basecamp.user_id = user.id and bonus_basecamp.status = 1) basecampkrp
                                    ')
            ->from('user')
            ->where('user.id', $id)
            ->get();
    }

    public function get_transfer_bonus($userid, $coin_type)
    {
        return $this->db->select_sum('amount')
            ->from('bonus_transfer_general')
            ->where('user_id', $userid)
            ->where('coin_type', $coin_type)
            ->get()
            ->row_array();
    }

    public function get_transfer_bonus_list($userid, $coin_type, $order)
    {
        return $this->db->select('*')
            ->from('bonus_transfer_general')
            ->where('user_id', $userid)
            ->where('coin_type', $coin_type)
            ->order_by('datecreate', $order)
            ->get();
    }

    public function show_list_payment()
    {
        return $this->db->select('cart.id, cart.datecreate, user.username, package.name, package.type, cart.fill, cart.usdt, cart.mtm, cart.note, cart.is_payment')
            ->from('cart')
            ->join('package', 'cart.package_id = package.id')
            ->join('user', 'cart.user_id = user.id')
            ->order_by('cart.is_payment', 'DESC')
            ->get();
    }

    public function get_trx_bycartid($id)
    {
        return $this->db->select('txid')
            ->from('txid')
            ->where('cart_id', $id)
            ->order_by('datecreate', 'DESC')
            ->get();
    }

    //get data and order
    public function get_data_order($table, $column, $order)
    {
        return $this->db->select('*')
            ->from($table)
            ->order_by($column, $order)
            ->get();
    }

    public function get_data_orderuser($table, $column1, $column2, $userid, $order)
    {
        return $this->db->select($table . '.*, package.name')
            ->from($table)
            ->join('cart', $column2)
            ->join('package', 'cart.package_id = package.id')
            ->where([$column2 => $userid, 'cart.is_payment' => 1])
            ->order_by($column1, $order)
            ->get();
    }

    public function get_transfer_list($table, $column1, $userid, $order)
    {
        return $this->db->select('*')
            ->from($table)
            ->where('user_id', $userid)
            ->order_by($column1, $order)
            ->get();
    }

    //get data by id
    public function get_data_byid($table, $column, $id)
    {
        return $this->db->get_where($table, [$column => $id])->row_array();
    }

    public function update_mining($where, $data)
    {
        $this->db->update('mining', $data, $where);
        return $this->db->affected_rows();
    }

    //get total by one column
    public function get_total_byuser($table, $column1, $column2, $userid)
    {
        return $this->db->select_sum($column1)
            ->from($table)
            ->where($column2, $userid)
            ->get()
            ->row_array();
    }

    //get total by data and date
    public function get_total_bydata_date($table, $column1, $column2, $data1, $date)
    {
        return $this->db->select_sum($column1)
            ->from($table)
            ->where([$column2 => $data1, 'from_unixtime(datecreate, "%Y-%m-%d") =' => $date])
            ->get()
            ->row_array();
    }

    //get team
    public function get_team($id, $limit, $offset)
    {
        return $this->db->select('user.username, user.email, package.color, cart.datecreate, level_fm.fm, user.country_code, 
        (SELECT SUM(package.point) FROM cart JOIN package ON package.id = cart.package_id WHERE cart.user_id = user.id) name')
            ->from('cart')
            ->join('user', 'user.id = cart.user_id')
            ->join('package', 'package.id = cart.package_id')
            ->join('level_fm', 'level_fm.user_id = user.id')
            ->where('cart.sponsor_id', $id)
            ->order_by('cart.datecreate', 'ASC')
            ->limit($limit, $offset)
            ->get()->result();
    }

    public function get_mining_team($id, $date, $limit, $offset)
    {
        return $this->db->select('cart.user_id, (SELECT SUM(mining_user.amount) FROM mining_user WHERE from_unixtime(mining_user.datecreate, "%Y-%m-%d") = "' . $date . '"AND mining_user.user_id = cart.user_id) amount')
            ->from('cart')
            ->where('cart.sponsor_id', $id)
            ->order_by('cart.datecreate', 'ASC')
            ->limit($limit, $offset)
            ->get()->result();
    }

    public function get_mining_user($date)
    {
       return $this->db->select('user.username, package.name, package.daysmining, cart.id, cart.datecreate , cart.pause_min, cart.update_date')
            ->from('cart')
            ->join('package', 'package.id = cart.package_id')
            ->join('user', 'user.id = cart.user_id')
            ->where(['cart.is_payment' => 1, 'from_unixtime(cart.datecreate, "%Y-%m-%d") <' => $date])
            ->order_by('cart.datecreate', 'ASC')
            ->get();
    }

    public function get_userfm()
    {
        return $this->db->select('cart.user_id, level_fm.fm')
            ->from('cart')
            ->join('level_fm', 'cart.user_id = level_fm.user_id')
            ->where('cart.is_payment', '1')
            ->get();
    }

    public function get_sponsor_box($user_id)
    {
        return $this->db->select_sum('package.point')
            ->from('cart')
            ->join('package', 'package.id = cart.package_id')
            ->where(['cart.is_payment' => 1, 'cart.sponsor_id' => $user_id])
            ->get()->row_array();
    }

    public function sum_sponsorbox($user_id)
    {
        return $this->db->select('cart.user_id, (SELECT SUM(b.point) FROM cart AS a JOIN package AS b ON b.id = a.package_id WHERE a.is_payment = 1 AND a.user_id = cart.user_id) point')
            ->from('cart')
            ->where(['cart.is_payment' => 1, 'cart.sponsor_id' => $user_id])
            ->get()->result();
    }

    public function get_information_detail($user_id)
    {
        return $this->db->select('*')
            ->from('user')
            ->where('user.id', $user_id)
            ->get()
            ->row_array();
    }

    // Fungsi untuk melakukan proses upload file
    public function upload_photo()
    {
        $config['upload_path'] = './assets/photo';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size']  = '2048';
        $config['remove_space'] = TRUE;

        $this->load->library('upload', $config); // Load konfigurasi uploadnya
        if ($this->upload->do_upload('photo')) { // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        } else {
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

    // Fungsi untuk menyimpan data ke database
    public function save_photo($upload)
    {
        $id = $this->input->post('id');
        $old = $this->input->post('old_photo');
        $data = array(
            'photo' => $upload['file']['file_name']
        );
        $where = array(
            'id' => $id
        );

        unlink('./assets/photo/' . $old);

        $this->db->where($where);
        $this->db->update('user', $data);
    }

    public function count_fm_bysponsor($id, $level)
    {
        $query = $this->db->select('cart.user_id')
            ->from('cart')
            ->join('level_fm', 'level_fm.user_id = cart.user_id')
            ->where(['cart.sponsor_id' => $id, 'level_fm.fm' => $level])
            ->get()->result();

        return count($query);
    }

    /**Total global omset per month */
    public function get_global_omset($date)
    {
        return $this->db->select_sum('cart.fill')
                        ->select_sum('cart.mtm')
                        ->select_sum('cart.zenx')
                        ->select_sum('cart.usdt')
                        ->select_sum('cart.krp')
                        ->from('cart')
                        ->where(['cart.is_payment' => '1', 'from_unixtime(cart.datecreate, "%Y-%m") =' => $date])
                        ->get()
                        ->row_array();
    }

    /**get user FM4-10 */
    public function get_user_global()
    {
        $level_array = array('FM4', 'FM5', 'FM6', 'FM7', 'FM8', 'FM9', 'FM10');

        return $this->db->select('user.id, level_fm.fm')
            ->from('user')
            ->join('level_fm', 'level_fm.user_id = user.id')
            ->where_in('level_fm.fm', $level_array)
            ->get();
    }

    public function row_check_global($user_id, $date, $fm)
    {
        return $this->db->select('*')
            ->from('bonus_global')
            ->where(['from_unixtime(datecreate, "%Y-%m") =' => $date, 'user_id' => $user_id, 'level_fm' => $fm])
            ->count_all_results();
    }
    
    public function get_mtm_airdrop($user_id)
    {
        return $this->db->select('airdrop_mtm.user_id, airdrop_mtm.amount, airdrop_mtm.datecreate, cart.package_id, package.name')
            ->from('airdrop_mtm')
            ->join('cart', 'airdrop_mtm.user_id = cart.user_id')
            ->join('package', 'cart.package_id = package.id')
            ->where('airdrop_mtm.user_id', $user_id)
            ->get();
    }
    
    public function get_summtm_airdrop($user_id)
    {
        return $this->db->select_sum('airdrop_mtm.amount')
            ->from('airdrop_mtm')
            ->join('cart', 'airdrop_mtm.user_id = cart.user_id')
            ->join('package', 'cart.package_id = package.id')
            ->where('airdrop_mtm.user_id', $user_id)
            ->get();
    }

    // Fungsi untuk melakukan proses upload file
    public function upload_photo_message()
    {
        $config['upload_path'] = './assets/photo/cs';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size']  = '2048';
        $config['remove_space'] = TRUE;

        $this->load->library('upload', $config); // Load konfigurasi uploadnya
        if ($this->upload->do_upload('image')) { // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        } else {
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

    public function get_message($email, $uniqid)
    {
        return $this->db->select('*')
            ->from('user_messages')
            ->where('user_messages.email', $email)
            ->where('user_messages.uniq_id', $uniqid)
            ->where('user_messages.is_end', 0)
            ->get();
    }

    public function get_message_end($email, $uniqid)
    {
        return $this->db->select('*')
            ->from('user_messages')
            ->where('user_messages.email', $email)
            ->where('user_messages.uniq_id', $uniqid)
            ->where('user_messages.is_end', 1)
            ->get();
    }

    public function get_message_groupby()
    {
        return $this->db->select('*')
            ->select_max('time', 'max_time')
            ->from('user_messages')
            ->where('user_messages.is_end', 0)
            ->group_by('user_messages.uniq_id')
            ->get();
    }

    public function get_message_end_groupby()
    {
        return $this->db->select('*')
            ->select_max('time', 'max_time')
            ->from('user_messages')
            ->where('user_messages.is_end', 1)
            ->order_by('user_messages.time')
            ->group_by('user_messages.uniq_id')
            ->get();
    }

    public function get_user_by($id)
    {
        return $this->db->select('user.username, user.photo, user_messages.user_id, user_messages.sender_id')
            ->from('user_messages')
            ->join('user', 'user_messages.sender_id = user.id')
            ->where('user_messages.user_id = ', $id)
            ->where('user_messages.sender_id != ', $id)
            ->get();
    }

    public function get_message_robot($email)
    {
        return $this->db->select('*')
            ->from('user_messages')
            ->where('user_messages.email', $email)
            ->where('user_messages.sender_email != ', $email)
            ->where('user_messages.is_end', 0)
            ->get();
    }

    public function getUniqMessage($email)
    {
        return $this->db->select('*')
            ->from('user_messages')
            ->where('user_messages.email', $email)
            ->where('user_messages.is_end', 0)
            ->get();
    }

    /**get package purchase admin */
    // public function get_purchase_admin()
    // {
    //     return $this->db->select('YEAR(DATE_FORMAT(FROM_UNIXTIME(cart.datecreate), "%Y-%m-%d")) AS year, MONTH(DATE_FORMAT(FROM_UNIXTIME(cart.datecreate), "%Y-%m-%d")) AS month, SUM(package.fil) AS total, SUM(package.mtm) AS total_mtm, SUM(package.point) AS total_box')
    //         ->from('cart')
    //         ->join('user', 'user.id = cart.user_id')
    //         ->join('package', 'package.id = cart.package_id')
    //         ->where('cart.is_payment', 1)
    //         ->group_by(['YEAR(DATE_FORMAT(FROM_UNIXTIME(cart.datecreate), "%Y-%m-%d"))', 'MONTH(DATE_FORMAT(FROM_UNIXTIME(cart.datecreate), "%Y-%m-%d"))'])
    //         ->get();
    // }
    
    public function get_purchase_admin()
    {
        return $this->db->select('YEAR(DATE_FORMAT(FROM_UNIXTIME(cart.datecreate), "%Y-%m-%d")) AS year, MONTH(DATE_FORMAT(FROM_UNIXTIME(cart.datecreate), "%Y-%m-%d")) AS month, SUM(cart.fill) AS total_fil, SUM(cart.mtm) AS total_mtm, SUM(cart.zenx) AS total_zenx, SUM(package.point) AS total_box')
            ->from('cart')
            ->join('user', 'user.id = cart.user_id')
            ->join('package', 'package.id = cart.package_id')
            ->where('cart.is_payment', 1)
            ->group_by(['YEAR(DATE_FORMAT(FROM_UNIXTIME(cart.datecreate), "%Y-%m-%d"))', 'MONTH(DATE_FORMAT(FROM_UNIXTIME(cart.datecreate), "%Y-%m-%d"))'])
            ->get();
    }
    
    public function count_fm_bymonth_now($date, $fm)
    {
        return $this->db->select('*')
                        ->from('level_fm')
                        ->where(['level_fm.fm' => $fm, 'FROM_UNIXTIME(level_fm.update_date, "%Y-%m-%d") <=' => $date])
                        ->count_all_results();
    }
    
    public function get_listpurchase_admin($date)
    {
        return $this->db->select('cart.update_date, user.username, package.name, cart.fill, cart.mtm, cart.zenx, cart.usdt, cart.krp')
            ->from('cart')
            ->join('user', 'user.id = cart.user_id')
            ->join('package', 'package.id = cart.package_id')
            ->where('cart.is_payment', 1)
            ->where('from_unixtime(cart.datecreate, "%Y-%m") = "' . $date . '"')
            ->get();
    }

    public function get_user_level($level)
    {
        return $this->db->select('user.id, user.username, level_fm.fm')
            ->from('user')
            ->join('level_fm', 'level_fm.user_id = user.id')
            ->where('level_fm.fm', $level)
            ->order_by('level_fm.fm', 'DESC')
            ->get();
    }

    public function get_user_level2($level)
    {
        return $this->db->select('user.*, level_fm.fm, cart.user_id, cart.sponsor_id, cart.position_id, cart.update_date, SUM(package.point) AS name')
            ->from('user')
            ->join('level_fm', 'level_fm.user_id = user.id', 'left outer')
            ->join('cart', 'cart.user_id = user.id', 'left outer')
            ->join('package', 'cart.package_id = package.id', 'left outer')
            ->where('role_id', 2)
            ->where_in('level_fm.fm', $level)
            ->group_by('user.id')
            ->get();
    }
    
    public function get_level_month_usdt($level, $date)
    {
        return $this->db->select('user_id, usdt, COUNT(level_fm) AS total')
            ->from('bonus_global')
            ->where('level_fm', $level)
            ->where('usdt !=', 0)
            ->where('from_unixtime(datecreate, "%Y-%m") = "' . $date . '"')
            ->get()->row_array();
    }

    public function get_level_month($level, $date)
    {
        return $this->db->select('user_id, mtm, COUNT(level_fm) AS total')
            ->from('bonus_global')
            ->where('level_fm', $level)
            ->where('mtm !=', 0)
            ->where('from_unixtime(datecreate, "%Y-%m") = "' . $date . '"')
            ->get()->row_array();
    }

    public function get_level_month2($level, $date)
    {
        return $this->db->select('user_id, mtm, COUNT(level_fm) AS total')
            ->from('excess_bonus')
            ->where('level_fm', $level)
            ->where('note', 'bonus global')
            ->where('mtm !=', 0)
            ->where('from_unixtime(datecreate, "%Y-%m") = "' . $date . '"')
            ->get()->row_array();
    }

    public function get_level_month2_usdt($level, $date)
    {
        return $this->db->select('user_id, usdt, COUNT(level_fm) AS total')
            ->from('excess_bonus')
            ->where('level_fm', $level)
            ->where('note', 'bonus global')
            ->where('usdt !=', 0)
            ->where('from_unixtime(datecreate, "%Y-%m") = "' . $date . '"')
            ->get()->row_array();
    }

    public function get_today_purchase($date)
    {
        return $this->db->select('SUM(cart.fill) as fill, SUM(cart.mtm) as mtm, SUM(cart.zenx) as zenx, SUM(cart.usdt) as usdt, SUM(cart.krp) as krp')
                        ->from('cart')
                        ->where(["cart.is_payment" => "1", "FROM_UNIXTIME(cart.datecreate, '%Y-%m-%d') = " => $date])
                        ->get()->row_array();
    }

    public function get_currentmonth_purchase($monthNow)
    {
        return $this->db->select('SUM(cart.fill) as fill, SUM(cart.mtm) as mtm, SUM(cart.zenx) as zenx, SUM(cart.usdt) as usdt, SUM(cart.krp) as krp')
                        ->from('cart')
                        ->where(['cart.is_payment' => '1', 'FROM_UNIXTIME(cart.datecreate, "%Y-%m") = ' => $monthNow])
                        ->get()->row_array();
    }

    public function get_today_purchase_basecamp($date, $basecamp)
    {
        return $this->db->select_sum('package.fil')
            ->from('cart')
            ->join('package', 'package.id = cart.package_id')
            ->join('user', 'user.id = cart.user_id')
            ->where(['cart.is_payment' => '1', 'FROM_UNIXTIME(cart.datecreate, "%Y-%m-%d") =' => $date, 'user.basecamp LIKE' => $basecamp])
            ->get()->row_array();
    }

    public function get_current_purchase_basecamp($month, $basecamp)
    {
        return $this->db->select_sum('package.fil')
            ->from('cart')
            ->join('package', 'package.id = cart.package_id')
            ->join('user', 'user.id = cart.user_id')
            ->where(['cart.is_payment' => '1', 'MONTH(DATE_FORMAT(FROM_UNIXTIME(cart.datecreate), "%Y-%m-%d")) = ' => $month, 'user.basecamp LIKE' => $basecamp])
            ->get()->row_array();
    }

    public function get_today_purchasebox_basecamp($date, $basecamp)
    {
        return $this->db->select_sum('package.point')
            ->from('cart')
            ->join('package', 'package.id = cart.package_id')
            ->join('user', 'user.id = cart.user_id')
            ->where(['cart.is_payment' => '1', 'FROM_UNIXTIME(cart.datecreate, "%Y-%m-%d") =' => $date, 'user.basecamp LIKE' => $basecamp])
            ->get()->row_array();
    }
    public function get_current_purchasebox_basecamp($month, $basecamp)
    {
        return $this->db->select_sum('package.point')
            ->from('cart')
            ->join('package', 'package.id = cart.package_id')
            ->join('user', 'user.id = cart.user_id')
            ->where(['cart.is_payment' => '1', 'MONTH(DATE_FORMAT(FROM_UNIXTIME(cart.datecreate), "%Y-%m-%d")) = ' => $month, 'user.basecamp LIKE' => $basecamp])
            ->get()->row_array();
    }

    public function get_user_basecamp()
    {
        $level_array = array('FM5', 'FM6', 'FM7', 'FM8');

        return $this->db->select('user.id, user.username, level_fm.fm, user.is_camp')
            ->from('user')
            ->join('level_fm', 'level_fm.user_id = user.id')
            ->where_in('level_fm.fm', $level_array)
            ->or_where('user.top_level', '1')
            ->order_by('level_fm.fm', 'DESC')
            ->get();
    }

    public function get_camp_fm($id)
    {
        return $this->db->select('user.is_camp, level_fm.fm')
            ->from('user')
            ->join('level_fm', 'level_fm.user_id = user.id')
            ->where('user.id', $id)
            ->get()->row_array();
    }

    

    public function get_username_basecamp($id)
    {
        return $this->db->select('cart.user_id, user.username')
            ->from('cart')
            ->join('user', 'user.id = cart.user_id')
            ->where('cart.id', $id)
            ->get()->row_array();
    }

    public function get_withdrawal($coin_type)
    {
        return $this->db->select('user.username, withdrawal.id, withdrawal.wallet_address, withdrawal.total, withdrawal.txid, withdrawal.datecreate, withdrawal.note')
            ->from('withdrawal')
            ->join('user', 'withdrawal.user_id = user.id')
            ->where('coin_type', $coin_type)
            ->order_by('withdrawal.datecreate', 'DESC')
            ->get();
    }

    public function get_withdrawal_by($id, $coin_type)
    {
        return $this->db->select('user.username, withdrawal.id, withdrawal.wallet_address, withdrawal.total, withdrawal.amount, withdrawal.txid, withdrawal.datecreate')
            ->from('withdrawal')
            ->join('user', 'withdrawal.user_id = user.id')
            ->where('user.id', $id)
            ->where('coin_type', $coin_type)
            ->order_by('withdrawal.datecreate', 'DESC')
            ->get();
    }

    public function get_total_withdrawal($userid, $coin_type)
    {
        return $this->db->select_sum('amount')
            ->from('withdrawal')
            ->where('user_id', $userid)
            ->where('coin_type', $coin_type)
            ->get()
            ->row_array();
    }

    public function get_deposit()
    {
        return $this->db->select('deposit.id, deposit.datecreate, user.username, deposit.coin, deposit.txid, deposit.image, deposit.type_coin, deposit.note, deposit.is_confirm')
            ->from('deposit')
            ->join('user', 'user.id = deposit.user_id')
            ->order_by('deposit.type_coin', 'ASC')
            ->get()
            ->result();
    }

    public function get_deposit_byid($id)
    {
        return $this->db->select('deposit.*, user.email')
            ->from('deposit')
            ->join('user', 'user.id = deposit.user_id')
            ->where('deposit.id', $id)
            ->get()
            ->row_array();
    }

    public function get_deposit_general($user_id, $type)
    {
        return $this->db->select('*')
            ->from('deposit')
            ->where(['user_id' => $user_id, 'type_coin' => $type, 'is_confirm' => '1'])
            ->get()->result();
    }

    public function get_sum_deposit($user_id, $type)
    {
        return $this->db->select_sum('coin')
            ->from('deposit')
            ->where(['user_id' => $user_id, 'type_coin' => $type, 'is_confirm' => '1'])
            ->get()->row_array();
    }

    public function get_banner_home($type)
    {
        return $this->db->select('*')
            ->from('banner_home')
            ->where('type', $type)
            ->get()->result();
    }
    // Fungsi untuk melakukan proses upload file
    public function upload_banner_home()
    {
        $config['upload_path'] = './assets/photo/banner';
        $config['allowed_types'] = 'jpg|png|jpeg';
        $config['max_size']  = '2048';
        $config['remove_space'] = TRUE;

        $this->load->library('upload', $config); // Load konfigurasi uploadnya
        if ($this->upload->do_upload('image')) { // Lakukan upload dan Cek jika proses upload berhasil
            // Jika berhasil :
            $return = array('result' => 'success', 'file' => $this->upload->data(), 'error' => '');
            return $return;
        } else {
            // Jika gagal :
            $return = array('result' => 'failed', 'file' => '', 'error' => $this->upload->display_errors());
            return $return;
        }
    }

    public function get_price_coin()
    {
        return $this->db->select('*')
            ->from('market_price')
            ->order_by('market_price.time', 'DESC')
            ->get();
    }
    
    public function minimum_withdrawal()
    {
        return $this->db->select('*')
            ->from('minimum_withdrawal')
            ->get()->row_array();
    }

    public function get_users_admin()
    {
        return $this->db->select('user.*, level_fm.fm, cart.user_id, cart.sponsor_id, cart.position_id, cart.update_date, SUM(package.point) AS name')
            ->from('user')
            ->join('level_fm', 'level_fm.user_id = user.id', 'left outer')
            ->join('cart', 'cart.user_id = user.id', 'left outer')
            ->join('package', 'cart.package_id = package.id', 'left outer')
            ->where('role_id', 2)
            ->group_by('user.id')
            ->get();
    }
    public function get_detail_user($id)
    {
        return $this->db->select('user.*, level_fm.fm, cart.user_id, cart.sponsor_id, cart.position_id, cart.update_date, SUM(package.point) AS name, SUM(package.usdt) AS total_usdt, SUM(package.krp) AS total_krp')
            ->from('user')
            ->join('level_fm', 'level_fm.user_id = user.id', 'left outer')
            ->join('cart', 'cart.user_id = user.id', 'left outer')
            ->join('package', 'cart.package_id = package.id', 'left outer')
            ->where('role_id', 2)
            ->where('user.id', $id)
            ->get();
    }

    public function totalBonusUser()
    {
        return $this->db->select('user.id, 
        (SELECT SUM(package.point) FROM cart JOIN package ON package.id = cart.package_id) name,
        (SELECT sum(mining_user.amount) FROM mining_user) mining_fil,
        (SELECT sum(airdrop_mtm.amount) FROM airdrop_mtm) airdrop_mtm,
        (SELECT sum(bonus.filecoin) FROM bonus) sponsorfil, 
        (SELECT sum(bonus.mtm) FROM bonus) sponsormtm,
        (SELECT sum(bonus_sm.filecoin) FROM bonus_sm) sponmatchingfil, 
        (SELECT sum(bonus_sm.mtm) FROM bonus_sm) sponmatchingmtm,
        (SELECT sum(bonus_maxmatching.mtm) FROM bonus_maxmatching) pairingmatch,
        (SELECT sum(bonus_minmatching.amount) FROM bonus_minmatching WHERE bonus_minmatching.team="A") minmatchingA,
        (SELECT sum(bonus_minmatching.amount) FROM bonus_minmatching WHERE bonus_minmatching.team="B") minmatchingB,
        (SELECT sum(bonus_minmatching.amount) FROM bonus_minmatching WHERE bonus_minmatching.team="C") minmatchingC,
        (SELECT sum(bonus_minpairing.amount) FROM bonus_minpairing) minpairing,
        (SELECT sum(bonus_binarymatch.mtm) FROM bonus_binarymatch) binarymatch,
        (SELECT sum(bonus_global.mtm) FROM bonus_global) bonusglobal,
        (SELECT sum(bonus_basecamp.filecoin) FROM bonus_basecamp) basecampfill,
        (SELECT sum(bonus_basecamp.mtm) FROM bonus_basecamp) basecampmtm')
            ->from('user')
            ->get();
    }

    public function totalBonusUserByDate($date)
    {
        return $this->db->select('user.id, 
        (SELECT SUM(package.point) FROM cart JOIN package ON package.id = cart.package_id WHERE from_unixtime(cart.update_date, "%Y-%m-%d") = "' . $date . '") name,
        (SELECT sum(mining_user.amount) FROM mining_user WHERE from_unixtime(mining_user.datecreate, "%Y-%m-%d") = "' . $date . '") mining_fil,
        (SELECT sum(airdrop_mtm.amount) FROM airdrop_mtm WHERE from_unixtime(airdrop_mtm.datecreate, "%Y-%m-%d") = "' . $date . '") airdrop_mtm,
        (SELECT sum(bonus.filecoin) FROM bonus WHERE from_unixtime(bonus.datecreate, "%Y-%m-%d") = "' . $date . '") sponsorfil, 
        (SELECT sum(bonus.mtm) FROM bonus WHERE from_unixtime(bonus.datecreate, "%Y-%m-%d") = "' . $date . '") sponsormtm,
        (SELECT sum(bonus_sm.filecoin) FROM bonus_sm WHERE from_unixtime(bonus_sm.datecreate, "%Y-%m-%d") = "' . $date . '") sponmatchingfil, 
        (SELECT sum(bonus_sm.mtm) FROM bonus_sm WHERE from_unixtime(bonus_sm.datecreate, "%Y-%m-%d") = "' . $date . '") sponmatchingmtm,
        (SELECT sum(bonus_maxmatching.mtm) FROM bonus_maxmatching WHERE from_unixtime(bonus_maxmatching.datecreate, "%Y-%m-%d") = "' . $date . '") pairingmatch,
        (SELECT sum(bonus_minmatching.amount) FROM bonus_minmatching WHERE bonus_minmatching.team="A" AND from_unixtime(bonus_minmatching.datecreate, "%Y-%m-%d") = "' . $date . '") minmatchingA,
        (SELECT sum(bonus_minmatching.amount) FROM bonus_minmatching WHERE bonus_minmatching.team="B" AND from_unixtime(bonus_minmatching.datecreate, "%Y-%m-%d") = "' . $date . '") minmatchingB,
        (SELECT sum(bonus_minmatching.amount) FROM bonus_minmatching WHERE bonus_minmatching.team="C" AND from_unixtime(bonus_minmatching.datecreate, "%Y-%m-%d") = "' . $date . '") minmatchingC,
        (SELECT sum(bonus_minpairing.amount) FROM bonus_minpairing WHERE from_unixtime(bonus_minpairing.datecreate, "%Y-%m-%d") = "' . $date . '") minpairing,
        (SELECT sum(bonus_binarymatch.mtm) FROM bonus_binarymatch WHERE from_unixtime(bonus_binarymatch.datecreate, "%Y-%m-%d") = "' . $date . '") binarymatch,
        (SELECT sum(bonus_global.mtm) FROM bonus_global WHERE from_unixtime(bonus_global.datecreate, "%Y-%m-%d") = "' . $date . '") bonusglobal,
        (SELECT sum(bonus_basecamp.filecoin) FROM bonus_basecamp WHERE from_unixtime(bonus_basecamp.datecreate, "%Y-%m-%d") = "' . $date . '") basecampfill,
        (SELECT sum(bonus_basecamp.mtm) FROM bonus_basecamp WHERE from_unixtime(bonus_basecamp.datecreate, "%Y-%m-%d") = "' . $date . '") basecampmtm')
            ->from('user')
            ->join('mining', 'mining.type = user.is_active', 'left')
            ->where('from_unixtime(mining.datecreate, "%Y-%m-%d") = "' . $date . '"')
            ->get();
    }

    public function allBonusUser($date)
    {
        return $this->db->select('user.id, user.username, mining.datecreate, 
        (SELECT sum(mining_user.box) FROM mining_user WHERE mining_user.user_id = user.id) box,
        (SELECT SUM(package.point) FROM cart JOIN package ON package.id = cart.package_id WHERE cart.user_id = user.id) name,
        (SELECT sum(mining_user.amount) FROM mining_user WHERE mining_user.user_id = user.id AND from_unixtime(mining_user.datecreate, "%Y-%m-%d") = "' . $date . '") mining_fil,
        (SELECT sum(airdrop_mtm.amount) FROM airdrop_mtm WHERE airdrop_mtm.user_id = user.id AND from_unixtime(airdrop_mtm.datecreate, "%Y-%m-%d") = "' . $date . '") airdrop_mtm,
        (SELECT sum(bonus.filecoin) FROM bonus WHERE bonus.user_id = user.id AND from_unixtime(bonus.datecreate, "%Y-%m-%d") = "' . $date . '") sponsorfil, 
        (SELECT sum(bonus.mtm) FROM bonus WHERE bonus.user_id = user.id AND from_unixtime(bonus.datecreate, "%Y-%m-%d") = "' . $date . '") sponsormtm,
        (SELECT sum(bonus_sm.filecoin) FROM bonus_sm WHERE bonus_sm.user_id = user.id AND from_unixtime(bonus_sm.datecreate, "%Y-%m-%d") = "' . $date . '") sponmatchingfil, 
        (SELECT sum(bonus_sm.mtm) FROM bonus_sm WHERE bonus_sm.user_id = user.id AND from_unixtime(bonus_sm.datecreate, "%Y-%m-%d") = "' . $date . '") sponmatchingmtm,
        (SELECT sum(bonus_minmatching.amount) FROM bonus_minmatching WHERE bonus_minmatching.user_id = user.id AND bonus_minmatching.team="A" AND from_unixtime(bonus_minmatching.datecreate, "%Y-%m-%d") = "' . $date . '") minmatchingA,
        (SELECT sum(bonus_minmatching.amount) FROM bonus_minmatching WHERE bonus_minmatching.user_id = user.id AND bonus_minmatching.team="B" AND from_unixtime(bonus_minmatching.datecreate, "%Y-%m-%d") = "' . $date . '") minmatchingB,
        (SELECT sum(bonus_minmatching.amount) FROM bonus_minmatching WHERE bonus_minmatching.user_id = user.id AND bonus_minmatching.team="C" AND from_unixtime(bonus_minmatching.datecreate, "%Y-%m-%d") = "' . $date . '") minmatchingC,
        (SELECT sum(bonus_maxmatching.mtm) FROM bonus_maxmatching WHERE bonus_maxmatching.user_id = user.id AND from_unixtime(bonus_maxmatching.datecreate, "%Y-%m-%d") = "' . $date . '") pairingmatch,
        (SELECT sum(bonus_minpairing.amount) FROM bonus_minpairing WHERE bonus_minpairing.user_id = user.id AND from_unixtime(bonus_minpairing.datecreate, "%Y-%m-%d") = "' . $date . '") minpairing,
        (SELECT sum(bonus_binarymatch.mtm) FROM bonus_binarymatch WHERE bonus_binarymatch.user_id = user.id AND from_unixtime(bonus_binarymatch.datecreate, "%Y-%m-%d") = "' . $date . '") binarymatch,
        (SELECT sum(bonus_global.mtm) FROM bonus_global WHERE bonus_global.user_id = user.id AND from_unixtime(bonus_global.datecreate, "%Y-%m-%d") = "' . $date . '") bonusglobal,
        (SELECT sum(bonus_basecamp.filecoin) FROM bonus_basecamp WHERE bonus_basecamp.user_id = user.id AND from_unixtime(bonus_basecamp.datecreate, "%Y-%m-%d") = "' . $date . '") basecampfill,
        (SELECT sum(bonus_basecamp.mtm) FROM bonus_basecamp WHERE bonus_basecamp.user_id = user.id AND from_unixtime(bonus_basecamp.datecreate, "%Y-%m-%d") = "' . $date . '") basecampmtm')
            ->from('user')
            ->join('mining', 'mining.type = user.is_active', 'left')
            ->where('from_unixtime(mining.datecreate, "%Y-%m-%d") = "' . $date . '"')
            ->get();
    }

    // public function allBonusUser($date)
    // {
    //     return $this->db->select('user.id, user.username, mining_user.datecreate, mining_user.box, 
    //     (SELECT DISTINCT(mining_user.box)FROM mining_user WHERE mining_user.user_id = user.id) box,
    //     (SELECT sum(mining_user.amount) FROM mining_user WHERE mining_user.user_id = user.id AND from_unixtime(mining_user.datecreate, "%Y-%m-%d") = "' . $date . '") mining_fil,
    //     (SELECT sum(airdrop_mtm.amount) FROM airdrop_mtm WHERE airdrop_mtm.user_id = user.id AND from_unixtime(airdrop_mtm.datecreate, "%Y-%m-%d") = "' . $date . '") airdrop_mtm,
    //     (SELECT sum(bonus.filecoin) FROM bonus WHERE bonus.user_id = user.id AND from_unixtime(bonus.datecreate, "%Y-%m-%d") = "' . $date . '") sponsorfil, 
    //     (SELECT sum(bonus.mtm) FROM bonus WHERE bonus.user_id = user.id AND from_unixtime(bonus.datecreate, "%Y-%m-%d") = "' . $date . '") sponsormtm,
    //     (SELECT sum(bonus_sm.filecoin) FROM bonus_sm WHERE bonus_sm.user_id = user.id AND from_unixtime(bonus_sm.datecreate, "%Y-%m-%d") = "' . $date . '") sponmatchingfil, 
    //     (SELECT sum(bonus_sm.mtm) FROM bonus_sm WHERE bonus_sm.user_id = user.id AND from_unixtime(bonus_sm.datecreate, "%Y-%m-%d") = "' . $date . '") sponmatchingmtm,
    //     (SELECT sum(bonus_minmatching.amount) FROM bonus_minmatching WHERE bonus_minmatching.user_id = user.id AND from_unixtime(bonus_minmatching.datecreate, "%Y-%m-%d") = "' . $date . '") minmatching,
    //     (SELECT sum(bonus_maxmatching.mtm) FROM bonus_maxmatching WHERE bonus_maxmatching.user_id = user.id AND from_unixtime(bonus_maxmatching.datecreate, "%Y-%m-%d") = "' . $date . '") pairingmatch,
    //     (SELECT sum(bonus_minpairing.amount) FROM bonus_minpairing WHERE bonus_minpairing.user_id = user.id AND from_unixtime(bonus_minpairing.datecreate, "%Y-%m-%d") = "' . $date . '") minpairing,
    //     (SELECT sum(bonus_binarymatch.mtm) FROM bonus_binarymatch WHERE bonus_binarymatch.user_id = user.id AND from_unixtime(bonus_binarymatch.datecreate, "%Y-%m-%d") = "' . $date . '") binarymatch,
    //     (SELECT sum(bonus_global.mtm) FROM bonus_global WHERE bonus_global.user_id = user.id AND from_unixtime(bonus_global.datecreate, "%Y-%m-%d") = "' . $date . '") bonusglobal,
    //     (SELECT sum(bonus_basecamp.filecoin) FROM bonus_basecamp WHERE bonus_basecamp.user_id = user.id AND from_unixtime(bonus_basecamp.datecreate, "%Y-%m-%d") = "' . $date . '") basecampfill,
    //     (SELECT sum(bonus_basecamp.mtm) FROM bonus_basecamp WHERE bonus_basecamp.user_id = user.id AND from_unixtime(bonus_basecamp.datecreate, "%Y-%m-%d") = "' . $date . '") basecampmtm')
    //         ->from('user')
    //         ->join('mining_user', 'mining_user.user_id = user.id', 'left')
    //         ->where('from_unixtime(mining_user.datecreate, "%Y-%m-%d") = "' . $date . '"')
    //         ->get();
    // }

    public function walletAddress()
    {
        return $this->db->select('*')
            ->from('wallet_address')
            ->get();
    }

    public function sumPackage($id)
    {
        return $this->db->select_sum('package.point')
            ->from('cart')
            ->join('package', 'package.id = cart.package_id')
            ->where('cart.user_id', $id)
            ->get()->row_array();
    }

    public function get_cart_notnullsponsor($id)
    {
        return $this->db->select('cart.sponsor_id, cart.matching_id')
            ->from('cart')
            ->where(['cart.user_id' => $id, 'cart.sponsor_id !=' => '0'])
            ->get()->row_array();
    }

    public function get_all_basecamp()
    {
        return $this->db->select('*')
            ->from('user')
            ->where('is_camp', '1')
            ->get()->result();
    }

    public function sum_basecamp_temp($userid)
    {
        return $this->db->select_sum('mtm')
            ->from('basecamp_temp')
            ->where(['user_id' => $userid, 'status' => '0'])
            ->get()->result();
    }

    public function get_detail_basecamp($id)
    {
        return $this->db->select('user.username, package.name, bonus_basecamp.update_date, bonus_basecamp.cart_id, bonus_basecamp.team, bonus_basecamp.mtm, bonus_basecamp.type')
            ->from('bonus_basecamp')
            ->join('cart', 'bonus_basecamp.cart_id = cart.id')
            ->join('package', 'cart.package_id = package.id')
            ->join('user', 'cart.user_id = user.id')
            ->where(['bonus_basecamp.user_id' => $id, 'status' => '1'])
            ->order_by('bonus_basecamp.update_date', 'DESC')
            ->get()->result();
    }

    public function get_excess_bonus($id)
    {
        return $this->db->select_sum('mtm')
            ->from('excess_bonus')
            ->where('user_id', $id)
            ->get();
    }

    public function get_excess_bonus_usdt($id)
    {
        return $this->db->select_sum('usdt')
            ->from('excess_bonus')
            ->where('user_id', $id)
            ->get();
    }

    public function get_excess_bonus_krp($id)
    {
        return $this->db->select_sum('krp')
            ->from('excess_bonus')
            ->where('user_id', $id)
            ->get();
    }

    public function get_today_fm($fm, $date)
    {
        if ($fm == 'FM') {
            return $this->db->select('*')
                ->from('level_fm')
                ->where(["fm" => $fm, "FROM_UNIXTIME(datecreate, '%Y-%m-%d') ="  => $date])
                ->count_all_results();
        } else {
            return $this->db->select('*')
                ->from('level_fm')
                ->where(["fm" => $fm, "FROM_UNIXTIME(update_date, '%Y-%m-%d') ="  => $date])
                ->count_all_results();
        }
    }

    public function get_all_fm($fm)
    {
        if ($fm == 'FM') {
            return $this->db->select('*')
                ->from('level_fm')
                ->where(["fm" => $fm])
                ->count_all_results();
        } else {
            return $this->db->select('*')
                ->from('level_fm')
                ->where(["fm" => $fm])
                ->count_all_results();
        }
    }

    public function get_totalbox_byid($user_id)
    {
        return $this->db->select_sum('package.mtm')
                        ->from('cart')
                        ->join('package', 'package.id = cart.package_id')
                        ->where(['cart.user_id' => $user_id, 'cart.is_payment' => '1'])
                        ->get()->row_array();
    }

    public function get_totalbox_usdt_byid($user_id)
    {
        return $this->db->select_sum('package.usdt')
                        ->from('cart')
                        ->join('package', 'package.id = cart.package_id')
                        ->where(['cart.user_id' => $user_id, 'cart.is_payment' => '1'])
                        ->get()->row_array();
    }

    public function get_totalbox_krp_byid($user_id)
    {
        return $this->db->select_sum('package.krp')
                        ->from('cart')
                        ->join('package', 'package.id = cart.package_id')
                        ->where(['cart.user_id' => $user_id, 'cart.is_payment' => '1'])
                        ->get()->row_array();
    }

    public function get_withdrawal_byid($id)
    {
        return $this->db->select('withdrawal.*, user.email')
            ->from('withdrawal')
            ->join('user', 'user.id = withdrawal.user_id')
            ->where('withdrawal.id', $id)
            ->get()
            ->row_array();
    }
    
    public function get_userfm_byuser()
    {
        return $this->db->select('user.id, level_fm.fm')
            ->from('user')
            ->join('level_fm', 'user.id = level_fm.user_id')
            ->get();
    }
    
    public function get_user_toplevel()
    {
        return $this->db->get_where('user', ['top_level' => '1'])->row_array();
    }
    
    public function get_basecamp_byuser($userid)
    {
        return $this->db->select('*')
                        ->from('bonus_basecamp')
                        ->where(['user_id' => $userid, 'status' => 0])
                        ->order_by('id', 'ASC')
                        ->get()->result();
    }

    public function sum_airdrop_byuser($userid)
    {
        return $this->db->select_sum('amount')
                        ->from('airdrop_mtm')
                        ->where('user_id', $userid)
                        ->get()->row_array();
    }
    
    public function get_bonusdetail_bydate($date)
    {
        return $this->db->select('user.id, user.username,
                            (SELECT SUM(package.point) FROM cart JOIN package ON package.id = cart.package_id WHERE cart.user_id = user.id and cart.is_payment = 1) name,
                            (SELECT sum(mining_user.amount) FROM mining_user WHERE mining_user.user_id = user.id AND from_unixtime(mining_user.datecreate, "%Y-%m-%d") = "'.$date.'") mining_fil,
                            (SELECT sum(airdrop_mtm.amount) FROM airdrop_mtm WHERE airdrop_mtm.user_id = user.id AND from_unixtime(airdrop_mtm.datecreate, "%Y-%m-%d") = "'.$date.'") airdrop_mtm,
                            (SELECT sum(bonus.filecoin) FROM bonus WHERE bonus.user_id = user.id AND from_unixtime(bonus.datecreate, "%Y-%m-%d") = "'.$date.'") sponsorfil,
                            (SELECT sum(bonus.mtm) FROM bonus WHERE bonus.user_id = user.id AND from_unixtime(bonus.datecreate, "%Y-%m-%d") = "'.$date.'") sponsormtm,
                            (SELECT sum(bonus_sm.filecoin) FROM bonus_sm WHERE bonus_sm.user_id = user.id AND from_unixtime(bonus_sm.datecreate, "%Y-%m-%d") = "'.$date.'") sponmatchingfil,
                            (SELECT sum(bonus_sm.mtm) FROM bonus_sm WHERE bonus_sm.user_id = user.id AND from_unixtime(bonus_sm.datecreate, "%Y-%m-%d") = "'.$date.'") sponmatchingmtm,
                            (SELECT sum(bonus_minmatching.amount) FROM bonus_minmatching WHERE bonus_minmatching.user_id = user.id AND bonus_minmatching.team="A" AND from_unixtime(bonus_minmatching.datecreate, "%Y-%m-%d") = "'.$date.'") minmatchingA,
                            (SELECT sum(bonus_minmatching.amount) FROM bonus_minmatching WHERE bonus_minmatching.user_id = user.id AND bonus_minmatching.team="B" AND from_unixtime(bonus_minmatching.datecreate, "%Y-%m-%d") = "'.$date.'") minmatchingB,
                            (SELECT sum(bonus_minmatching.amount) FROM bonus_minmatching WHERE bonus_minmatching.user_id = user.id AND bonus_minmatching.team="C" AND from_unixtime(bonus_minmatching.datecreate, "%Y-%m-%d") = "'.$date.'") minmatchingC,
                            (SELECT sum(bonus_maxmatching.mtm) FROM bonus_maxmatching WHERE bonus_maxmatching.user_id = user.id AND from_unixtime(bonus_maxmatching.datecreate, "%Y-%m-%d") = "'.$date.'") pairingmatch,
                            (SELECT sum(bonus_minpairing.amount) FROM bonus_minpairing WHERE bonus_minpairing.user_id = user.id AND from_unixtime(bonus_minpairing.datecreate, "%Y-%m-%d") = "'.$date.'") minpairing,
                            (SELECT sum(bonus_binarymatch.mtm) FROM bonus_binarymatch WHERE bonus_binarymatch.user_id = user.id AND from_unixtime(bonus_binarymatch.datecreate, "%Y-%m-%d") = "'.$date.'") binarymatch,
                            (SELECT sum(bonus_global.mtm) FROM bonus_global WHERE bonus_global.user_id = user.id AND from_unixtime(bonus_global.datecreate, "%Y-%m-%d") = "'.$date.'") bonusglobal,
                            (SELECT sum(bonus_basecamp.filecoin) FROM bonus_basecamp WHERE bonus_basecamp.user_id = user.id AND from_unixtime(bonus_basecamp.datecreate, "%Y-%m-%d") = "'.$date.'") basecampfill,
                            (SELECT sum(bonus_basecamp.mtm) FROM bonus_basecamp WHERE bonus_basecamp.user_id = user.id AND from_unixtime(bonus_basecamp.datecreate, "%Y-%m-%d") = "'.$date.'") basecampmtm')
                ->from('user')
                ->get();
    }
    
    public function get_totalmining_bydate($date)
    {
        return $this->db->select_sum('amount')
                        ->from('mining_user')
                        ->where('from_unixtime(mining_user.datecreate, "%Y-%m-%d") = ', $date)
                        ->get()->row_array();
    }

    public function get_totalairmtm_bydate($date)
    {
        return $this->db->select_sum('amount')
                        ->from('airdrop_mtm')
                        ->where('from_unixtime(airdrop_mtm.datecreate, "%Y-%m-%d") = ', $date)
                        ->get()->row_array();
    }

    public function get_totalsponsor_bydate($date)
    {
        return $this->db->select_sum('filecoin')
                        ->select_sum('mtm')
                        ->from('bonus')
                        ->where('from_unixtime(bonus.datecreate, "%Y-%m-%d") = ', $date)
                        ->get()->result();
    }

    public function get_totalmatching_bydate($date)
    {
        return $this->db->select_sum('filecoin')
                        ->select_sum('mtm')
                        ->from('bonus_sm')
                        ->where('from_unixtime(bonus_sm.datecreate, "%Y-%m-%d") = ', $date)
                        ->get()->result();
    }
    
    public function get_totalmining_gen_bydate($date)
    {
        return $this->db->select_sum('amount')
                        ->from('bonus_minpairing')
                        ->where('from_unixtime(bonus_minpairing.datecreate, "%Y-%m-%d") = ', $date)
                        ->get()->row_array();
    }
    
    public function get_totalpairing_bydate($date)
    {
        return $this->db->select_sum('mtm')
                        ->from('bonus_maxmatching')
                        ->where('from_unixtime(bonus_maxmatching.datecreate, "%Y-%m-%d") = ', $date)
                        ->get()->row_array();
    }
    
    public function get_totalrm_bydate($date, $team)
    {
        return $this->db->select_sum('amount')
                        ->from('bonus_minmatching')
                        ->where(['from_unixtime(bonus_minmatching.datecreate, "%Y-%m-%d") =' => $date, 'bonus_minmatching.team' => $team])
                        ->get()->row_array();
    }
    
    public function get_totalpairing_match_bydate($date)
    {
        return $this->db->select_sum('mtm')
                        ->from('bonus_binarymatch')
                        ->where(['from_unixtime(bonus_binarymatch.datecreate, "%Y-%m-%d") =' => $date])
                        ->get()->row_array();
    }
    
    public function get_totalglobal_bydate($date)
    {
        return $this->db->select_sum('mtm')
                        ->from('bonus_global')
                        ->where(['from_unixtime(bonus_global.datecreate, "%Y-%m-%d") =' => $date])
                        ->get()->row_array();
    }
    
    public function get_totalbasecamp_bydate($date)
    {
        return $this->db->select_sum('mtm')
                        ->from('bonus_basecamp')
                        ->where(['from_unixtime(bonus_basecamp.datecreate, "%Y-%m-%d") =' => $date])
                        ->get()->row_array();
    }
    
    public function get_all_excess($user_id)
    {
        return $this->db->select('*')
                        ->from('excess_bonus')
                        ->where(['user_id' => $user_id, 'mtm != ' => '0'])
                        ->order_by('id', 'ASC')
                        ->get()->result();
    }

    public function get_all_excess_usdt($user_id)
    {
        return $this->db->select('*')
                        ->from('excess_bonus')
                        ->where(['user_id' => $user_id, 'usdt != ' => '0'])
                        ->order_by('id', 'ASC')
                        ->get()->result();
    }
    
    public function get_total_bonus_sponsor_byid($userid)
    {
        return $this->db->select_sum('usdt')
                        ->select_sum('krp')
                        ->from('bonus')
                        ->where('user_id', $userid)
                        ->get()->row_array();
    }
    
    public function get_total_bonus_sponsormatch_byid($userid)
    {
        return $this->db->select_sum('usdt')
                        ->select_sum('krp')
                        ->from('bonus_sm')
                        ->where('user_id', $userid)
                        ->get()->row_array();
    }
    
    public function get_total_bonus_minmatch_byid($userid)
    {
        return $this->db->select_sum('amount')
                        ->from('bonus_minmatching')
                        ->where('user_id', $userid)
                        ->get()->row_array();
    }
    
    public function get_total_bonus_mingeneration_byid($userid)
    {
        return $this->db->select_sum('amount')
                        ->from('bonus_minpairing')
                        ->where('user_id', $userid)
                        ->get()->row_array();
    }
    
    public function get_total_bonus_pairing_byid($userid)
    {
        return $this->db->select_sum('mtm')
                        ->from('bonus_maxmatching')
                        ->where('user_id', $userid)
                        ->get()->row_array();
    }

    public function get_total_bonus_pairing_byid_usdt($userid)
    {
        return $this->db->select_sum('usdt')
                        ->from('bonus_maxmatching')
                        ->where('user_id', $userid)
                        ->get()->row_array();
    }
    
    public function get_total_bonus_pairingmatch_byid($userid)
    {
        return $this->db->select_sum('mtm')
                        ->from('bonus_binarymatch')
                        ->where('user_id', $userid)
                        ->get()->row_array();
    }

    public function get_total_bonus_pairingmatch_byid_usdt($userid)
    {
        return $this->db->select_sum('usdt')
                        ->from('bonus_binarymatch')
                        ->where('user_id', $userid)
                        ->get()->row_array();
    }
    
    public function get_total_bonus_global_byid($userid)
    {
        return $this->db->select_sum('mtm')
                        ->from('bonus_global')
                        ->where('user_id', $userid)
                        ->get()->row_array();
    }

    public function get_total_bonus_global_byid_usdt($userid)
    {
        return $this->db->select_sum('usdt')
                        ->from('bonus_global')
                        ->where('user_id', $userid)
                        ->get()->row_array();
    }
    
    public function get_total_basecamp_byid($userid)
    {
        return $this->db->select_sum('usdt')
                        ->from('bonus_basecamp')
                        ->where(['user_id' => $userid, 'status' => 1])
                        ->get()->row_array();
    }
    
    public function get_total_basecampbox_byid($userid)
    {
        return $this->db->select_sum('package.point')
            ->from('bonus_basecamp')
            ->join('cart', 'bonus_basecamp.cart_id = cart.id')
            ->join('package', 'package.id = cart.package_id')
            ->where(['bonus_basecamp.user_id' => $userid, 'bonus_basecamp.status' => 1])
            ->get()->row_array();
    }
    
    public function get_basecamp_leader()
    {
        return $this->db->select('basecamp_name.id, basecamp_name.name, user.id as userid, user.username, 
                                (SELECT sum(package.point) FROM cart JOIN package ON cart.package_id = package.id JOIN user as a ON a.id = cart.user_id WHERE cart.is_payment = 1 AND a.id_basecamp = basecamp_name.id AND cart.user_id != user.id) omset, 
                                (SELECT sum(bonus_basecamp.usdt) FROM bonus_basecamp WHERE bonus_basecamp.id_bs = basecamp_name.id and bonus_basecamp.user_id = user.id) bonus, (SELECT sum(excess_bonus.usdt) FROM excess_bonus WHERE excess_bonus.user_id = user.id AND excess_bonus.note = "bonus basecamp") excess')
                        ->from('basecamp_name')
                        ->join('basecamp_leader', 'basecamp_leader.id_bs = basecamp_name.id')
                        ->join('user', 'user.id = basecamp_leader.user_id')
                        ->get()->result();
    }
    
    
    
    //insert last id
    public function last_id($table, $data)
    {
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }
    
   public function get_userlist_basecamp($id)
    {
        return $this->db->select('cart.datecreate, user.id, user.username, user.first_name, user.country_code, user.phone, level_fm.fm, package.name,
                                (SELECT b.username from cart as a join user as b ON b.id = a.sponsor_id WHERE a.user_id = user.id and a.sponsor_id != 0 group by b.id) sponsor,
                                (SELECT d.username from cart as c JOIN user as d ON d.id = c.position_id WHERE c.user_id = user.id and c.position_id != 0 GROUP BY user.id) position')
                        ->from('user')
                        ->join('level_fm', 'level_fm.user_id = user.id')
                        ->join('cart', 'cart.user_id = user.id')
                        ->join('package', 'package.id = cart.package_id')
                        ->where('user.id_basecamp', $id)
                        ->order_by('level_fm.fm', 'DESC')
                        ->get()->result();
    }
    
    public function get_basecamp_user_bycamp($id)
    {
        $level_array = array('FM5', 'FM6', 'FM7', 'FM8');

        return $this->db->select('user.id, user.username')
            ->from('user')
            ->join('level_fm', 'level_fm.user_id = user.id')
            ->where_in('level_fm.fm', $level_array)
            ->where('user.id_basecamp', $id)
            ->get();
    }
    
    public function get_all_basecampname()
    {
        return $this->db->select('*')
                        ->from('basecamp_name')
                        ->order_by('name', 'asc')
                        ->get()->result();
    }
    
    public function get_omset_bybasecamp($id_bs, $iduser)
    {
        return $this->db->select('bonus_basecamp.datecreate, user.username, basecamp_name.name, (SELECT b.username from cart as a JOIN user as b on b.id = a.user_id WHERE a.id = bonus_basecamp.cart_id) member, (SELECT d.name from cart as c JOIN package as d on d.id = c.package_id WHERE c.id = bonus_basecamp.cart_id) purchase, bonus_basecamp.usdt')
                        ->from('bonus_basecamp')
                        ->join('user', 'user.id = bonus_basecamp.user_id')
                        ->join('basecamp_name', 'basecamp_name.id = bonus_basecamp.id_bs')
                        ->where(['bonus_basecamp.id_bs' => $id_bs, 'bonus_basecamp.user_id' => $iduser, 'bonus_basecamp.usdt !=' =>'0', 'bonus_basecamp.status' => '1'])
                        ->get()->result();
    }
    
    public function get_omset_bybasecamp_gather($id_bs, $iduser)
    {
        return $this->db->select('bonus_basecamp.datecreate, user.username, basecamp_name.name, (SELECT b.username from cart as a JOIN user as b on b.id = a.user_id WHERE a.id = bonus_basecamp.cart_id) member, (SELECT d.name from cart as c JOIN package as d on d.id = c.package_id WHERE c.id = bonus_basecamp.cart_id) purchase, bonus_basecamp.usdt')
                        ->from('bonus_basecamp')
                        ->join('user', 'user.id = bonus_basecamp.user_id')
                        ->join('basecamp_name', 'basecamp_name.id = bonus_basecamp.id_bs')
                        ->where(['bonus_basecamp.id_bs' => $id_bs, 'bonus_basecamp.user_id' => $iduser, 'bonus_basecamp.usdt !=' =>'0', 'bonus_basecamp.status' => '0'])
                        ->get()->result();
    }
    
    
    
    public function get_basecampid_byuser($id)
    {
        return $this->db->select('id_basecamp')
                        ->from('user')
                        ->where('id', $id)
                        ->get()->row_array();
    }
    
    public function get_leader_bybs($id)
    {
        return $this->db->select('basecamp_leader.user_id')
                        ->from('basecamp_leader')
                        ->where('basecamp_leader.id_bs', $id)
                        ->get()->row_array();
    }
    
    public function get_level_byfm_monthnow($date, $level)
    {
        return $this->db->select('cart.update_date, user.id, user.username, user.first_name, user.country_code, user.phone, package.name, 
                                (SELECT b.id from cart as a join user as b ON b.id = a.sponsor_id WHERE a.user_id = user.id and a.sponsor_id != 0) sponsor_id,
                                (SELECT b.username from cart as a join user as b ON b.id = a.sponsor_id WHERE a.user_id = user.id and a.sponsor_id != 0) sponsor, 
                                (SELECT d.id from cart as c JOIN user as d ON d.id = c.position_id WHERE c.user_id = user.id and c.position_id != 0) position_id,
                                (SELECT d.username from cart as c JOIN user as d ON d.id = c.position_id WHERE c.user_id = user.id and c.position_id != 0) position, 
                                level_fm.fm as level_fm')
                        ->from('user')
                        ->join('cart', 'cart.user_id = user.id')
                        ->join('package', 'package.id = cart.package_id')
                        ->join('level_fm', 'level_fm.user_id = user.id')
                        ->where_in('level_fm.fm', $level)
                        ->where('from_unixtime(level_fm.update_date, "%Y-%m-%d") <=', $date)
                        ->get()->result();
    }
    
    public function get_global_fm_bymonth($date, $level)
    {
        return $this->db->select('cart.update_date, user.id, user.username, user.first_name, user.country_code, user.phone, package.name, 
                                (SELECT b.id from cart as a join user as b ON b.id = a.sponsor_id WHERE a.user_id = user.id and a.sponsor_id != 0) sponsor_id,
                                (SELECT b.username from cart as a join user as b ON b.id = a.sponsor_id WHERE a.user_id = user.id and a.sponsor_id != 0) sponsor, 
                                (SELECT d.id from cart as c JOIN user as d ON d.id = c.position_id WHERE c.user_id = user.id and c.position_id != 0) position_id,
                                (SELECT d.username from cart as c JOIN user as d ON d.id = c.position_id WHERE c.user_id = user.id and c.position_id != 0) position, 
                                bonus_global.level_fm')
                        ->from('user')
                        ->join('cart', 'cart.user_id = user.id')
                        ->join('package', 'package.id = cart.package_id')
                        ->join('bonus_global', 'bonus_global.user_id = user.id')
                        ->where(['from_unixtime(bonus_global.datecreate, "%Y-%m") =' => $date, 'bonus_global.mtm != ' => '0', 'bonus_global.level_fm' => $level])
                        ->get()->result();
    }
    
    public function get_excessglobal_fm_bymonth($date, $level)
    {
        return $this->db->select('cart.update_date, user.id, user.username, user.first_name, user.country_code, user.phone, package.name, 
                                (SELECT b.id from cart as a join user as b ON b.id = a.sponsor_id WHERE a.user_id = user.id and a.sponsor_id != 0) sponsor_id,
                                (SELECT b.username from cart as a join user as b ON b.id = a.sponsor_id WHERE a.user_id = user.id and a.sponsor_id != 0) sponsor, 
                                (SELECT d.id from cart as c JOIN user as d ON d.id = c.position_id WHERE c.user_id = user.id and c.position_id != 0) position_id,
                                (SELECT d.username from cart as c JOIN user as d ON d.id = c.position_id WHERE c.user_id = user.id and c.position_id != 0) position, 
                                excess_bonus.level_fm')
                        ->from('user')
                        ->join('cart', 'cart.user_id = user.id')
                        ->join('package', 'package.id = cart.package_id')
                        ->join('excess_bonus', 'excess_bonus.user_id = user.id')
                        ->where(['from_unixtime(excess_bonus.datecreate, "%Y-%m") =' => $date, 'excess_bonus.mtm !=' => '0', 'excess_bonus.level_fm' => $level, 'excess_bonus.note' => 'bonus global'])
                        ->get()->result();
    }
    
    public function get_history_bonus_basecamp()
    {
        return $this->db->select('sum(bonus_basecamp.usdt) as bonus, basecamp_name.name, user.username, user.first_name, level_fm.fm, user.id, (SELECT SUM(package.point) FROM cart JOIN package ON package.id = cart.package_id WHERE cart.user_id = user.id) purchase')
                        ->from('bonus_basecamp')
                        ->join('user', 'user.id = bonus_basecamp.user_id')
                        ->join('level_fm', 'level_fm.user_id = user.id')
                        ->join('basecamp_name', 'basecamp_name.id = bonus_basecamp.id_bs')
                        ->where('bonus_basecamp.status', 1)
                        ->group_by('bonus_basecamp.user_id')
                        ->get()->result();
    }
    
    public function get_omset_bybasecamp_excess($id_bs, $iduser)
    {
        return $this->db->select('excess_bonus.datecreate, user.username, basecamp_name.name, (SELECT b.username from cart as a JOIN user as b on b.id = a.user_id WHERE a.id = excess_bonus.cart_id) member, (SELECT d.name from cart as c JOIN package as d on d.id = c.package_id WHERE c.id = excess_bonus.cart_id) purchase, excess_bonus.usdt')
                        ->from('excess_bonus')
                        ->join('user', 'user.id = excess_bonus.user_id')
                        ->join('basecamp_name', 'basecamp_name.id = excess_bonus.id')
                        ->where(['excess_bonus.id_bs' => $id_bs, 'excess_bonus.user_id' => $iduser, 'excess_bonus.usdt !=' =>'0', 'excess_bonus.note' => 'bonus basecamp'])
                        ->get()->result();
    }
    
    public function get_globalbonus_bymonth_level($date, $level)
    {
        return $this->db->select_sum('mtm')
                        ->from('bonus_global')
                        ->where(['from_unixtime(datecreate, "%Y-%m") = ' => $date, 'level_fm' => $level])
                        ->get()->row_array();
    }
    
    public function get_excessglobal_bymonth_level($date, $level)
    {
        return $this->db->select_sum('mtm')
                        ->from('excess_bonus')
                        ->where(['from_unixtime(datecreate, "%Y-%m") = ' => $date, 'level_fm' => $level, 'note' => 'bonus global'])
                        ->get()->row_array();
    }
    
    public function get_purchase_admin_bymonth($date)
    {
        return $this->db->select('SUM(cart.fill) AS total_fil, SUM(cart.mtm) AS total_mtm, SUM(cart.zenx) AS total_zenx, SUM(cart.usdt) AS total_usdt, SUM(cart.krp) AS total_krp, SUM(package.point) AS total_box')
                        ->from('cart')
                        ->join('user', 'user.id = cart.user_id')
                        ->join('package', 'package.id = cart.package_id')
                        ->where(['cart.is_payment' => '1', 'FROM_UNIXTIME(cart.datecreate, "%Y-%m") =' => $date])
                        ->get()->row_array();
    }
    
    public function get_excess_sponsor($id)
    {
        return $this->db->select('excess_bonus.datecreate, user.username, excess_bonus.mtm, excess_bonus.usdt, excess_bonus.krp')
            ->from('excess_bonus')
            ->join('cart', 'excess_bonus.cart_id = cart.id')
            ->join('user', 'cart.user_id = user.id')
            ->where('excess_bonus.user_id', $id)
            ->where('excess_bonus.note', 'bonus sponsor')
            ->where('excess_bonus.mtm !=', 0)
            ->order_by('excess_bonus.datecreate', 'DESC')
            ->get()->result();
    }

    public function get_excess_sponsor_matching($id)
    {
        return $this->db->select('excess_bonus.datecreate, user.username, excess_bonus.mtm, excess_bonus.usdt, excess_bonus.krp')
            ->from('excess_bonus')
            ->join('cart', 'excess_bonus.cart_id = cart.id')
            ->join('user', 'cart.user_id = user.id')
            ->where('excess_bonus.user_id', $id)
            ->where('excess_bonus.note', 'bonus sponsor matching')
            ->where('excess_bonus.mtm !=', 0)
            ->order_by('excess_bonus.datecreate', 'DESC')
            ->get()->result();
    }

    public function get_excess_global($id)
    {
        return $this->db->select('excess_bonus.id, user.username, excess_bonus.mtm, excess_bonus.level_fm, excess_bonus.datecreate, excess_bonus.note_level')
            ->from('excess_bonus')
            ->join('user', 'excess_bonus.user_id = user.id')
            ->where('excess_bonus.user_id', $id)
            ->where('excess_bonus.note', 'bonus global')
            ->where('excess_bonus.mtm !=', 0)
            ->order_by('excess_bonus.datecreate', 'DESC')
            ->get()->result();
    }

    public function get_excess_global_usdt($id)
    {
        return $this->db->select('excess_bonus.id, user.username, excess_bonus.usdt, excess_bonus.level_fm, excess_bonus.datecreate, excess_bonus.note_level')
            ->from('excess_bonus')
            ->join('user', 'excess_bonus.user_id = user.id')
            ->where('excess_bonus.user_id', $id)
            ->where('excess_bonus.note', 'bonus global')
            ->where('excess_bonus.usdt !=', 0)
            ->order_by('excess_bonus.datecreate', 'DESC')
            ->get()->result();
    }

    public function get_total_excess_byid($userid, $note)
    {
        return $this->db->select_sum('usdt')
            ->select_sum('krp')
            ->from('excess_bonus')
            ->where('user_id', $userid)
            ->where('note', $note)
            ->get()->row_array();
    }
    
    public function get_total_excess_pairing_byid($userid)
    {
        return $this->db->select_sum('mtm')
                        ->from('excess_bonus')
                        ->where(['user_id' => $userid, 'note' => 'bonus pairing'])
                        ->get()->row_array();
    }

    public function get_total_excess_pairing_byid_usdt($userid)
    {
        return $this->db->select_sum('usdt')
                        ->from('excess_bonus')
                        ->where(['user_id' => $userid, 'note' => 'bonus pairing'])
                        ->get()->row_array();
    }

    public function get_excess_binarymatch($id)
    {
        return $this->db->select('excess_bonus.id, user.username, excess_bonus.generation, excess_bonus.mtm, excess_bonus.usdt, excess_bonus.datecreate')
                        ->from('excess_bonus')
                        ->join('user', 'user.id = excess_bonus.user_id')
                        ->where(['excess_bonus.user_id' => $id, 'excess_bonus.note' => 'bonus pairing matching'])
                        ->order_by('excess_bonus.datecreate', 'DESC')
                        ->get()->result();
    }

    public function get_total_excess_pairingmatch_byid($userid)
    {
        return $this->db->select_sum('mtm')
                        ->from('excess_bonus')
                        ->where(['user_id' => $userid, 'note' => 'bonus pairing matching'])
                        ->get()->row_array();
    }

    public function get_total_excess_pairingmatch_byid_usdt($userid)
    {
        return $this->db->select_sum('usdt')
                        ->from('excess_bonus')
                        ->where(['user_id' => $userid, 'note' => 'bonus pairing matching'])
                        ->get()->row_array();
    }

    public function get_excess_basecamp($id)
    {
        return $this->db->select('user.username, excess_bonus.datecreate, excess_bonus.cart_id, excess_bonus.usdt, basecamp_name.name AS bs_name, package.name')
            ->from('excess_bonus')
            ->join('cart', 'excess_bonus.cart_id = cart.id')
            ->join('user', 'cart.user_id = user.id')
            ->join('package', 'package.id = cart.package_id')
            ->join('basecamp_name', 'basecamp_name.id = excess_bonus.id_bs', 'left')
            ->where(['excess_bonus.user_id' => $id, 'excess_bonus.usdt !=' => '0', 'excess_bonus.note' => 'bonus basecamp'])
            ->order_by('excess_bonus.datecreate', 'DESC')
            ->get()->result();
    }

    public function get_total_excess_basecamp_byid($userid)
    {
        return $this->db->select_sum('usdt')
                        ->from('excess_bonus')
                        ->where(['user_id' => $userid, 'note' => 'bonus basecamp'])
                        ->get()->row_array();
    }
    
    public function get_total_collected_basecamp_byid($userid)
    {
        return $this->db->select_sum('usdt')
            ->from('bonus_basecamp')
            ->where(['user_id' => $userid, 'status' => 0])
            ->get()->row_array();
    }
    public function get_total_collectedbox_basecamp_byid($userid)
    {
        return $this->db->select_sum('package.point')
            ->from('bonus_basecamp')
            ->join('cart', 'bonus_basecamp.cart_id = cart.id')
            ->join('package', 'package.id = cart.package_id')
            ->where(['bonus_basecamp.user_id' => $userid, 'bonus_basecamp.status' => 0])
            ->get()->row_array();
    }

    public function get_collected_basecamp($iduser)
    {
        return $this->db->select('bonus_basecamp.datecreate, user.username, basecamp_name.name AS bs_name, bonus_basecamp.cart_id, bonus_basecamp.team, (SELECT b.username from cart as a JOIN user as b on b.id = a.user_id WHERE a.id = bonus_basecamp.cart_id) member, (SELECT d.name from cart as c JOIN package as d on d.id = c.package_id WHERE c.id = bonus_basecamp.cart_id) purchase, bonus_basecamp.usdt')
            ->from('bonus_basecamp')
            ->join('user', 'user.id = bonus_basecamp.user_id')
            ->join('basecamp_name', 'basecamp_name.id = bonus_basecamp.id_bs', 'left')
            ->where(['bonus_basecamp.user_id' => $iduser, 'bonus_basecamp.usdt !=' => '0', 'bonus_basecamp.status' => '0'])
            ->order_by('bonus_basecamp.datecreate', 'DESC')
            ->get()->result();
    }
    
    public function get_excess_pairing($id)
    {
        return $this->db->select('excess_bonus.id, user.username, excess_bonus.mtm, excess_bonus.usdt, excess_bonus.datecreate')
                        ->from('excess_bonus')
                        ->join('user', 'user.id = excess_bonus.user_id')
                        ->where(['excess_bonus.note' => 'bonus pairing', 'excess_bonus.user_id' => $id, 'excess_bonus.mtm !=' => '0'])
                        ->order_by('excess_bonus.datecreate', 'DESC')
                        ->get()->result();
    }
    
    public function get_level_monthnow_user($date, $level)
    {
        return $this->db->select('user.first_name, (SELECT SUM(package.point) FROM cart JOIN package ON cart.package_id = package.id WHERE cart.user_id = user.id) package, level_fm.fm as level_fm')
                        ->from('user')
                        ->join('level_fm', 'level_fm.user_id = user.id')
                        ->where_in('level_fm.fm', $level)
                        ->where('from_unixtime(level_fm.update_date, "%Y-%m-%d") <=', $date)
                        ->get()->result();
    }
    
    public function get_user_global_limitdate($date)
    {
        $level_array = array('FM4', 'FM5', 'FM6', 'FM7', 'FM8', 'FM9', 'FM10');

        return $this->db->select('user.id, level_fm.fm')
            ->from('user')
            ->join('level_fm', 'level_fm.user_id = user.id')
            ->where_in('level_fm.fm', $level_array)
            ->where('from_unixtime(level_fm.update_date, "%Y-%m-%d") <=', $date)
            ->get();
    }
    
    public function show_newnotif_byuser_order($userid)
    {
        return $this->db->select('*')
            ->from('notifi')
            ->where(['user_id' => $userid, 'is_show' => 0])
            ->order_by('id', 'DESC')
            ->limit(5, 0)
            ->get()->result();
    }
    
    public function get_all_news()
    {
        return $this->db->select('*')
            ->from('news_announce')
            ->order_by('datecreate', 'DESC')
            ->get();
    }
    
    public function get_all_news_limit()
    {
        return $this->db->select('*')
            ->from('news_announce')
            ->order_by('datecreate', 'DESC')
            ->limit(5, 0)
            ->get();
    }
    
    public function show_one_data($table, $column, $id)
    {
        return $this->db->select('*')
                        ->from($table)
                        ->where($column, $id)
                        ->get()->result();
    }

    public function get_data_byid_order($table, $column1, $order, $column2, $data)
    {
        return $this->db->select('*')
                        ->from($table)
                        ->where($column2, $data)
                        ->order_by($column1, $order)
                        ->get()->result();
    }
    
    public function show_all_data($table, $order)
    {
        return $this->db->select('*')
                        ->from($table)
                        ->order_by('id', $order)
                        ->get()->result();
    }

    public function get_fil_price()
    {
        return $this->db->select('*')
                        ->from('filecoin_price')
                        ->order_by('id', 'DESC')
                        ->limit(1, 0)
                        ->get()
                        ->row_array();
    }

    public function get_set_amount_bydate($userid, $date)
    {
        return $this->db->select_sum('set_amount')
                        ->from('bonus_maxmatching')
                        ->where(['user_id' => $userid, 'from_unixtime(datecreate, "%Y-%m-%d") = ' => $date])
                        ->get()->row_array();
    }

    public function get_last_reset_pairing($user_id)
    {
        return $this->db->select('*')
                        ->from('bonus_maxmatching')
                        ->where(['user_id' => $user_id, 'reset_date != ' => '0'])
                        ->order_by('id', 'DESC')
                        ->limit(1,0)
                        ->get()->row_array();
    }

    public function sum_user_set_amount_get($date, $user)
    {
        return $this->db->select_sum('set_amount')
                        ->from('bonus_maxmatching')
                        ->where(['reset_date > ' => $date, 'user_id' => $user])
                        ->get()->row_array();
    }

    public function sum_user_set_amount_nol($user)
    {
        return $this->db->select_sum('set_amount')
                        ->from('bonus_maxmatching')
                        ->where(['user_id' => $user])
                        ->get()->row_array();
    }
}
