<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Autoscript extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_user');
    }

    private $arrPointL = array();
    private $arrPointR = array();
    private $arrPointSpon = array();
    private $arrTodayL = array();
    private $arrTodayR = array();

    /**bonus*/
    public function pairingMatching()
    {
        $dateNow = date('Y-m-d');
        $user    = $this->M_user->get_alluser_payment_one()->result();

        foreach($user as $row_user)
        {
            $userid = $row_user->user_id ?? null;

            $countPointL = $this->_countPositionL($userid);
            $countPointR = $this->_countPositionR($userid);

            // /**calculate omset */
            $omset = $this->_omset($countPointL, $countPointR, $row_user->user_id, $dateNow);
        }
    }

    private function _omset($countPointL, $countPointR, $userid, $date)
    {
        //check whether the user has received a bonus
        //$checkBonusSet = $this->M_user->get_last_balance($userid);
        //$checkBonusSet = $this->M_user->balance_now($userid)->row_array();

        $checkBonusSet = $this->M_user->balance_now_nol($userid)->row_array();
            
        if($countPointL < $countPointR)
        {
            $smallestPoint = $countPointL;
            $largestPoint  = $countPointR;
            $largestPosition = 'R';
        }
        else
        {
            $smallestPoint = $countPointR;
            $largestPoint  = $countPointL;
            $largestPosition = 'L';
        } 

        // $dateNow = $date;
        // $dateBalance = date('Y-m-d', $checkBonusSet['datecreate']);
        
        if($checkBonusSet)
        {
            // if($dateBalance != $dateNow)
            // {
                if($smallestPoint >= 4)
                {
                    $query_poin = $this->M_user->sum_balance($userid);
                    $getAmount = $query_poin['set_amount'];
                    $query_balance_now = $this->M_user->balance_now($userid)->row_array();
                    $balance_now_left = $query_balance_now['amount_left'];
                    $balance_now_right = $query_balance_now['amount_right'];

                    $query_cutPoint = $this->M_user->sum_leftover($userid);
                    // $cutPointLeft = $query_cutPoint['amount_left'];
                    // $cutPointRight = $query_cutPoint['amount_right'];

                    //$increasePointLeft = $countPointL - ($checkBonusSet['amount_left']+$getAmount);
                    // $increasePointRight = $countPointR - ($checkBonusSet['amount_right']+$getAmount);

                    //$newTotalPointL = $checkBonusSet['amount_left'] + $increasePointLeft;
                    // $newTotalPointR = $checkBonusSet['amount_right'] + $increasePointRight;
                    
                    // $increasePointLeft  = $countPointL - ($balance_now_left+$getAmount);
                    // $increasePointRight = $countPointR - ($balance_now_right+$getAmount);

                    $increasePointLeft  = $this->_countPointTodayL($userid);
                    $increasePointRight = $this->_countPointTodayR($userid);
                    
                    $newTotalPointL = $checkBonusSet['balance_a'] + $increasePointLeft;
                    $newTotalPointR = $checkBonusSet['balance_b'] + $increasePointRight;
                    
                    if($newTotalPointL < $newTotalPointR)
                    {
                        $newSmallestPoint = $newTotalPointL;
                        $newLargestPoint  = $newTotalPointR;
                        $newLargestPosition  = 'R';
                    }
                    else
                    {
                        $newSmallestPoint = $newTotalPointR;
                        $newLargestPoint  = $newTotalPointL;
                        $newLargestPosition = 'L';
                    }

                    if($newSmallestPoint >= 4)
                    { 
                        $leftoverPoint = $newSmallestPoint % 4; //sisa bagi 4
                        $quotient = ($newSmallestPoint - $leftoverPoint)/4;  //number of sets obtained

                        $check_level = $this->_level_check($userid);

                        if($quotient >= $check_level)
                        {
                            $numberSet = $check_level;
                        }
                        else
                        {
                            $numberSet = $quotient;
                        }

                        $mtmBonus = $numberSet/2;
                        $setAmount = $numberSet*4;
                        $leftoverPointMax = $newLargestPoint - ($numberSet*4);

                        // // $leftoverPoint      = $newSmallestPoint - 4; //sisa bagi 4
                        // // $leftoverPointMax   = $newLargestPoint - 4;

                        if($newLargestPosition == 'L')
                        {
                            $leftoverA = $leftoverPointMax;
                            $leftoverB = $leftoverPoint;
                            
                            if($leftoverA < $leftoverB)
                            {
                                $balance_a = 0;
                                $balance_b = $leftoverPoint;
                            }
                            else
                            {
                                $balance_a = $leftoverPointMax;
                                $balance_b = 0;
                            }
                        }
                        else
                        {
                            $leftoverA = $leftoverPoint;
                            $leftoverB = $leftoverPointMax;

                            if($leftoverA < $leftoverB)
                            {
                                $balance_a = 0;
                                $balance_b = $leftoverPointMax;
                            }
                            else
                            {
                                $balance_a = $leftoverPoint;
                                $balance_b = 0;
                            } 
                        }

                        $limit_bonus        = $this->_check_limit_bonus($userid, $mtmBonus);
                        $excess_bonus       = $mtmBonus - $limit_bonus;
                        $limit_count_mtm    = $limit_bonus;

                        $data_leftover_real = [
                            'user_id' => $userid,
                            'amount_left' => $leftoverA,
                            'amount_right' => $leftoverB,
                            'datecreate' => time()
                        ];

                        $insert_leftover_real = $this->M_user->insert_data('leftovers_real', $data_leftover_real);

                        $data_balance = [
                            'user_id' => $userid,
                            'balance_a' => $balance_a,
                            'balance_b' => $balance_b,
                            'datecreate' => time()
                        ];
    
                        $insert_balance = $this->M_user->insert_data('balance_point', $data_balance);
                        
                        $data_bonus = [
                            'user_id' => $userid,
                            'mtm' => $limit_count_mtm,
                            'set_amount' => $setAmount,
                            'datecreate' => time()
                        ];
                        
                        $insert_maxmatching = $this->M_user->insert_data('bonus_maxmatching', $data_bonus);

                        $data_excess = [
                            'user_id' => $userid,
                            'type_bonus' => '1',
                            'mtm' => $excess_bonus,
                            'cart_id' => '0',
                            'code_bonus' => '0',
                            'user_sponsor' => '0',
                            'generation' => '0',
                            'note' => 'bonus pairing',
                            'datecreate' => time()
                        ];

                        $insert = $this->M_user->insert_data('excess_bonus', $data_excess);
                    }
                    else
                    {
                        if($newLargestPosition == 'L')
                        {
                            $leftoverA = $newLargestPoint;
                            $leftoverB = $newSmallestPoint;
                        }
                        else
                        {
                            $leftoverA = $newSmallestPoint;
                            $leftoverB = $newLargestPoint;
                        }

                        $data_balance = [
                            'user_id' => $userid,
                            'balance_a' => $leftoverA,
                            'balance_b' => $leftoverB,
                            'datecreate' => time()
                        ];

                        $insert_balance = $this->M_user->insert_data('balance_point', $data_balance);
                    }
                }
            //}
        }
        else
        {
            if($smallestPoint >= 4)
            {
                $leftoverPoint = $smallestPoint % 4;
                $quotient = ($smallestPoint - $leftoverPoint)/4;  //number of sets obtained
                $check_level = $this->_level_check($userid);

                if($quotient >= $check_level)
                {
                    $numberSet = $check_level;
                }
                else
                {
                    $numberSet = $quotient;
                }

                $mtmBonus = $numberSet/2;
                $setAmount = $numberSet*4;
                $leftoverPointMax = $largestPoint - ($numberSet*4);

                // $leftoverPoint      = $smallestPoint - 4; //sisa bagi 4
                // $leftoverPointMax   = $largestPoint - 4;
                
                if($largestPosition == 'L')
                {
                    $leftoverA = $leftoverPointMax;
                    $leftoverB = $leftoverPoint;
                    
                    if($leftoverA < $leftoverB)
                    {
                        $balance_a = 0;
                        $balance_b = $leftoverPoint;
                    }
                    else
                    {
                        $balance_a = $leftoverPointMax;
                        $balance_b = 0;
                    }
                }
                else
                {
                    $leftoverA = $leftoverPoint;
                    $leftoverB = $leftoverPointMax;

                    if($leftoverA < $leftoverB)
                    {
                        $balance_a = 0;
                        $balance_b = $leftoverPointMax;
                    }
                    else
                    {
                        $balance_a = $leftoverPoint;
                        $balance_b = 0;
                    } 
                }

                $limit_bonus        = $this->_check_limit_bonus($userid, $mtmBonus);
                $excess_bonus       = $mtmBonus - $limit_bonus;
                $limit_count_mtm    = $limit_bonus;

                $data_leftover_real = [
                    'user_id' => $userid,
                    'amount_left' => $leftoverA,
                    'amount_right' => $leftoverB,
                    'datecreate' => time()
                ];

                $insert_leftover_real = $this->M_user->insert_data('leftovers_real', $data_leftover_real);

                $data_balance = [
                    'user_id' => $userid,
                    'balance_a' => $balance_a,
                    'balance_b' => $balance_b,
                    'datecreate' => time()
                ];

                $insert_balance = $this->M_user->insert_data('balance_point', $data_balance);  
                
                $data_bonus = [
                    'user_id' => $userid,
                    'mtm' => $limit_count_mtm,
                    'set_amount' => $setAmount,
                    'datecreate' => time()
                ];

                $insert_maxmatching = $this->M_user->insert_data('bonus_maxmatching', $data_bonus); 

                $data_excess = [
                    'user_id' => $userid,
                    'type_bonus' => '1',
                    'mtm' => $excess_bonus,
                    'cart_id' => '0',
                    'code_bonus' => '0',
                    'user_sponsor' => '0',
                    'generation' => '0',
                    'note' => 'bonus pairing',
                    'datecreate' => time()
                ];

                $insert = $this->M_user->insert_data('excess_bonus', $data_excess);
            }  
        } 
    }

    private function _countPointTodayL($userid)
    {
        $dateNow = date('Y-m-d');

        $query = $this->M_user->check_line($userid, 'A');
        $user_position = $query['user_id'] ?? null;

        $query_package = $this->M_user->get_onepoint_byuser($user_position, $dateNow)->row_array();
        $package_datecreate = $query_package['datecreate'] ?? null;

        $packagePoint = $query_package['point'] ?? null;

        $countMember = $this->_get_countPointTodayL($user_position, $dateNow);
        $sumTotal = array_sum($countMember) + $packagePoint;
        $this->arrTodayL = array();

        return $sumTotal;
    }

    private function _get_countPointTodayL($id, $date)
    {
        $query = $this->M_user->get_sumtodaypoint_byposition($id, $date);

        foreach ($query->result() as $row) {
            // if (date('Y-m-d', $row->datecreate) == $date) {
            //     array_push($this->arrTodayL, $row->point);
            // }
            array_push($this->arrTodayL, $row->point);

            $this->_get_countPointTodayL($row->user_id, $date);
        }

        return $this->arrTodayL;
    }

    private function _countPointTodayR($userid)
    {
        $dateNow = date('Y-m-d');

        $query = $this->M_user->check_line($userid, 'B');
        $user_position = $query['user_id'] ?? null;

        $query_package = $this->M_user->get_onepoint_byuser($user_position, $dateNow)->row_array();
        $package_datecreate = $query_package['datecreate'] ?? null;

        $packagePoint = $query_package['point'] ?? null;

        $countMember = $this->_get_countPointTodayR($user_position, $dateNow);
        $sumTotal = array_sum($countMember) + $packagePoint;
        $this->arrTodayR = array();

        return $sumTotal;
    }

    private function _get_countPointTodayR($id, $date)
    {
        $query = $this->M_user->get_sumtodaypoint_byposition($id, $date);

        foreach ($query->result() as $row) {
            // if (date('Y-m-d', $row->datecreate) == $date) {
            //     array_push($this->arrTodayR, $row->point);
            // }

            array_push($this->arrTodayR, $row->point);

            $this->_get_countPointTodayR($row->user_id, $date);
        }

        return $this->arrTodayR;
    }

    private function _level_check($userid)
    {
        $query_fm       = $this->M_user->get_data_byid('level_fm', 'user_id', $userid);
        $fm             = $query_fm['fm'] ?? null;

        if($fm == 'FM')
        {
            $limit = 2;
        }
        elseif($fm == 'FM1')
        {
            $limit = 6;
        }
        elseif($fm == 'FM2')
        {
            $limit = 10;
        }
        elseif($fm == 'FM3')
        {
            $limit = 14;
        }
        elseif($fm == 'FM4')
        {
            $limit = 20;
        }
        elseif($fm == 'FM5')
        {
            $limit = 30;
        }
        elseif($fm == 'FM6')
        {
            $limit = 40;
        }
        elseif($fm == 'FM7')
        {
            $limit = 50;
        }
        elseif($fm == 'FM8')
        {
            $limit = 100;
        }
        elseif($fm == 'FM9')
        {
            $limit = 140;
        }
        elseif($fm == 'FM10')
        {
            $limit = 200;
        }

        return $limit;
    }

    private function _countPositionL($userid){
        $query = $this->M_user->check_line($userid, 'A');
        $user_position = $query['user_id'] ?? null;

        $query_package = $this->M_user->get_point_byuserid($user_position)->row_array();
        $package       = $query_package['point'] ?? null;

        $countMember = $this->_get_countPointL($user_position);

        $sumTotal = array_sum($countMember) + $package;
        $this->arrPointL = array();

        return $sumTotal;
    }

    private function _get_countPointL($id)
    {
        $query = $this->M_user->get_totalpoin_byposition($id);

        foreach($query->result() as $row)
        {
            array_push($this->arrPointL, $row->point);

            $this->_get_countPointL($row->user_id);
        }

        return $this->arrPointL;
    }

    private function _countPositionR($userid){
        $query = $this->M_user->check_line($userid, 'B');
        $user_position = $query['user_id'] ?? null;

        $query_package = $this->M_user->get_point_byuserid($user_position)->row_array();
        $package_poin = $query_package['point'] ?? null;

        $countMember = $this->_get_countPointR($user_position);

        $sumTotal = array_sum($countMember)+$package_poin;
        $this->arrPointR = array();

        return $sumTotal;
    }

    private function _get_countPointR($id)
    {
        $query = $this->M_user->get_totalpoin_byposition($id);

        foreach($query->result() as $row)
        {
            array_push($this->arrPointR, $row->point);

            $this->_get_countPointR($row->user_id);
        }

        return $this->arrPointR;
    }

    //mining result and airdrop
    public function miningResult()
    {
        $dateNow = date('Y-m-d');

        //$query_global = $this->M_user->get_data_bydate('mining', 'datecreate', $dateNow)->row_array();
        $query_global   = $this->M_user->get_data_bydate_user('mining', 'datecreate', 'type', $dateNow, '1')->row_array();
        $query_mtm      = $this->M_user->get_data_bydate_user('mining', 'datecreate', 'type', $dateNow, '2')->row_array();
        $user           = $this->M_user->get_alluser_mining($dateNow)->result();

        $global_mining          = $query_global['amount'];
        $global_airdrop_mtm     = $query_mtm['amount'];
        $date_mining            = $query_global['datecreate'];
        

        foreach($user as $row_user)
        {
            $user_id    = $row_user->user_id;
            //             $hasrate    = $row_user->hashrate;
            $box        = $row_user->name;
            //             $aidrop_mtm = $row_user->airdrp_mtm;
            $daysmining = $row_user->daysmining/2;
            $datepay    = date('Y-m-d', $row_user->datecreate);
            $cart_id    = $row_user->id;
            
            //             $mining_result =  ((($global_mining * $hasrate)/1000) * 85)/100;
            $mining_result  =  $global_mining * $row_user->point;

            $start_mining = date('Y-m-d', strtotime("+45 day", strtotime($datepay)));
            $aidrop_mtm =  $global_airdrop_mtm * $row_user->point;

            if($dateNow >= $start_mining)
            {
                $all_use_mining = (strtotime($dateNow) - strtotime($start_mining)) / (60 * 60 * 24);
                
                if($global_mining > 0)
                {
                    if($all_use_mining <= $daysmining)
                    {
                        $data = [
                            'user_id' => $user_id,
                            'amount' => $mining_result,
                            'box' => $box,
                            'datecreate' => $date_mining,
                            'cart_id' => $cart_id
                        ];
    
                        // echo $user_id."=> ".$box."=>".$mining_result."<br>";
                        
                        $checkdata = $this->M_user->row_data_bydate_user('mining_user', 'datecreate', 'cart_id', $dateNow, $cart_id);
        
                        if($checkdata < 1)
                        {
                            $this->M_user->insert_data('mining_user', $data);
                        }
                    }
                    // elseif($all_use_mining == ($row_user->daysmining/2)) //notifikasi belum jadi
                    // {
                        
                    //     //input notification
                    //     // $link       = 'User/updateDaysMining/'.$row_user->id;
    
                    //     // $data_notif = [
                    //     //     'user_id' => $user_id,
                    //     //     'type' => '3',
                    //     //     'title' => 'Mining',
                    //     //     'message' => 'Your mining time limit is over. Click to confirm.',
                    //     //     'link' => $link,
                    //     //     'datecreate' => time()
                    //     // ];
    
                    //     // $insert_notif = $this->M_user->insert_notif($data_notif);
                        
                    //     //send notification
                    //     // require APPPATH . 'views/vendor/autoload.php';
        
                    //     // $options = array(
                    //     //     'cluster' => 'ap1',
                    //     //     'useTLS' => true
                    //     // );
        
                    //     // $pusher = new Pusher\Pusher(
                    //     //     '375479f0c247cb7708d7',
                    //     //     'cd781cf54e1b067aa767',
                    //     //     '1243088',
                    //     //     $options
                    //     // );
                        
                    //     // $message['message'] = $insert_notif;
                    //     // $message['email']   = $row_user->email;
                    //     // $message['user']    = $user_id;
    
                    //     // $pusher->trigger('channel-auto-mining', 'event-auto-mining', $message);
    
                    // }
                }
            }

            $start_mining_mtm   = date('Y-m-d', strtotime("+1 day", strtotime($datepay)));
            $all_use_mining_mtm = (strtotime($dateNow) - strtotime($start_mining)) / (60 * 60 * 24);

            $limit_bonus        = $this->_check_limit_bonus($user_id, $aidrop_mtm);

            $excess_bonus       = $aidrop_mtm - $limit_bonus;
            $limit_count_mtm    = $limit_bonus;

            if($dateNow >= $start_mining_mtm)
            {
                if($global_airdrop_mtm > 0 )
                {
                    if($all_use_mining_mtm <= 540)
                    {
                        $data_airdrop = [
                            'user_id' => $user_id,
                            'amount' => $limit_count_mtm,
                            'box'  => $box,
                            'cart_id' => $cart_id,
                            'datecreate' => $date_mining
                        ];
    
                        $check_airdrop = $this->M_user->row_data_bydate_user('airdrop_mtm', 'datecreate', 'cart_id', $dateNow, $cart_id);
    
                        if($check_airdrop < 1)
                        {
                            $this->M_user->insert_data('airdrop_mtm', $data_airdrop);

                            $data_excess = [
                                'user_id' => $user_id,
                                'type_bonus' => '1',
                                'mtm' => $excess_bonus,
                                'cart_id' => $cart_id,
                                'code_bonus' => '0',
                                'user_sponsor' => '0',
                                'generation' => '0',
                                'box' => $box,
                                'note' => 'airdrop mtm',
                                'datecreate' => $date_mining
                            ];

                            $this->M_user->insert_data('excess_bonus', $data_excess);
                        }
                    }
                } 
            }
        }
    }

    //recommended mining bonus
    public function miningMatching()
    {
        $user = $this->M_user->get_userpayment_fm_bsecamp()->result();
        $date = date('Y-m-d');
        
        foreach($user as $row_user)
        {
            $query_team_a = $this->M_user->get_mining_team($row_user->user_id, $date, '3', '0');

            foreach($query_team_a as $row_team_a)
            {
                if(!empty($row_team_a->amount))
                {
                    $this->_bonus_minmatching(3, $row_team_a->amount, $row_user->user_id, $row_team_a->user_id, 'A', $date);
                }
            }

            $query_team_b = $this->M_user->get_mining_team($row_user->user_id, $date, '3', '3');
            
            foreach($query_team_b as $row_team_b)
            {
                if(!empty($row_team_b->amount))
                {
                    $this->_bonus_minmatching(4, $row_team_b->amount, $row_user->user_id, $row_team_b->user_id, 'B', $date);
                }
            }

            $query_row_team     = $this->M_user->row_data_byuser('cart', 'sponsor_id' ,$row_user->user_id);
            $query_team_c       = $this->M_user->get_mining_team($row_user->user_id, $date, $query_row_team, '6');

            foreach($query_team_c as $row_team_c)
            {
                if(!empty($row_team_c->amount))
                {
                    $this->_bonus_minmatching(5, $row_team_c->amount, $row_user->user_id, $row_team_c->user_id, 'C', $date);
                }
            }
        }
    }

    private function _bonus_minmatching($percent, $amount, $user_id, $member_id, $team, $date)
    {   
        $newdate    = date($date.' H:i:s');
        $d          = DateTime::createFromFormat('Y-m-d H:i:s', $newdate)->getTimestamp();
        
        $bonus_team = ($percent*$amount)/100;
        
        $data_team = [
            'user_id' => $user_id,
            'member_id' => $member_id,
            'team' => $team,
            'amount' => $bonus_team,
            'datecreate' => $d
        ];
        
        $check_team = $this->M_user->row_data_fourcolumn('bonus_minmatching', 'datecreate', 'user_id', 'team', 'member_id', $date, $user_id, $team, $member_id);
        
        if($check_team < 1)
        {
            $this->M_user->insert_data('bonus_minmatching', $data_team);
        }
    }


    //set level for FM
    public function levelFm()
    {
        $user = $this->M_user->get_userfm_byuser();

        foreach($user->result_array() as $row_user)
        {   
            $count_fm1          = $this->M_user->count_fm_bysponsor($row_user['id'], 'FM1');
            $count_fm2          = $this->M_user->count_fm_bysponsor($row_user['id'], 'FM2');
            $count_fm3          = $this->M_user->count_fm_bysponsor($row_user['id'], 'FM3');
            $count_fm4          = $this->M_user->count_fm_bysponsor($row_user['id'], 'FM4');
            $count_fm5          = $this->M_user->count_fm_bysponsor($row_user['id'], 'FM5');
            $count_fm6          = $this->M_user->count_fm_bysponsor($row_user['id'], 'FM6');
            $count_fm7          = $this->M_user->count_fm_bysponsor($row_user['id'], 'FM7');
            $count_fm8          = $this->M_user->count_fm_bysponsor($row_user['id'], 'FM8');
            $count_fm9          = $this->M_user->count_fm_bysponsor($row_user['id'], 'FM9');
            $count_fm10         = $this->M_user->count_fm_bysponsor($row_user['id'], 'FM10');

            if($row_user['fm'] == 'FM')
            {
                $setlevel = $this->_setLevel($row_user['id'], 3, 15, 0);
            }
            elseif($row_user['fm'] == 'FM1')
            {
                $team_count = $count_fm1+$count_fm2+$count_fm3+$count_fm4+$count_fm5+$count_fm6+$count_fm7+$count_fm8+$count_fm9+$count_fm10;
                $this->_setLevelTeam($row_user['id'], 9, 45, 1, $row_user['fm'], $team_count);
            }
            elseif($row_user['fm'] == 'FM2')
            {
                $team_count = $count_fm2+$count_fm3+$count_fm4+$count_fm5+$count_fm6+$count_fm7+$count_fm8+$count_fm9+$count_fm10;
                $this->_setLevelTeam($row_user['id'], 15, 75, 2, $row_user['fm'], $team_count);
            }
            elseif($row_user['fm'] == 'FM3')
            {
                $team_count = $count_fm3+$count_fm4+$count_fm5+$count_fm6+$count_fm7+$count_fm8+$count_fm9+$count_fm10;
                $this->_setLevelTeam($row_user['id'], 30, 150, 3, $row_user['fm'], $team_count);
            }
            elseif($row_user['fm'] == 'FM4')
            {
                $team_count = $count_fm4+$count_fm5+$count_fm6+$count_fm7+$count_fm8+$count_fm9+$count_fm10;
                $this->_setLevelTeam($row_user['id'], 60, 300, 4, $row_user['fm'], $team_count);
            }
            elseif($row_user['fm'] == 'FM5')
            {
                $team_count = $count_fm5+$count_fm6+$count_fm7+$count_fm8+$count_fm9+$count_fm10;
                $this->_setLevelTeam($row_user['id'], 120, 600, 5, $row_user['fm'], $team_count);
            }
            elseif($row_user['fm'] == 'FM6')
            {
                $team_count = $count_fm6+$count_fm7+$count_fm8+$count_fm9+$count_fm10;
                $this->_setLevelTeam($row_user['id'], 300, 1500, 6, $row_user['fm'], $team_count);
            }
            elseif($row_user['fm'] == 'FM7')
            {
                $team_count = $count_fm7+$count_fm8+$count_fm9+$count_fm10;
                $this->_setLevelTeamC($row_user['id'], 540, 2700, 7, $row_user['fm'], $team_count);
            }
            elseif($row_user['fm'] == 'FM8')
            {
                $team_count = $count_fm8+$count_fm9+$count_fm10;
                $this->_setLevelTeamC($row_user['id'], 720, 3600, 8, $row_user['fm'], $team_count);
            }
            elseif($row_user['fm'] == 'FM9')
            {
                $team_count = $count_fm9+$count_fm10;
                $this->_setLevelTeamC($row_user['id'], 1024, 5120, 9, $row_user['fm'], $team_count);
            }
        }
    }

    private function _setLevel($row_id, $poinSponsor, $poinOmset, $level)
    {
        $query_sponsor = $this->M_user->sum_sponsorbox($row_id);

        $sponsor = 0;

        foreach($query_sponsor as $row_sponsor)
        {
            if(!empty($row_sponsor->point))
            {
                $sponsor = $sponsor+$row_sponsor->point;
                
            }
        }

        $sponsor = $sponsor;
        
        $omset  = $this->_omset_bysponsor($row_id);

        if($sponsor >= $poinSponsor && $omset >= $poinOmset)
        {
            $fmLevel = 'FM'.($level+1);

            $data = [
                'fm' => $fmLevel,
                'update_date' => time()
            ];

            $this->M_user->update_data_byid('level_fm', $data, 'user_id', $row_id);
        }
    }

    private function _setLevelTeam($row_id, $poinSponsor, $poinOmset, $level, $levelSpnr, $team)
    {
        $query_sponsor = $this->M_user->sum_sponsorbox($row_id);

        $sponsor = 0;
        foreach($query_sponsor as $row_sponsor)
        {
            if(!empty($row_sponsor->point))
            {
                $sponsor = $sponsor+$row_sponsor->point;
            }
        }

        $sponsor    = $sponsor;
        $omset      = $this->_omset_bysponsor($row_id);
        $team_a     = $this->M_user->get_team($row_id, 3, 0);

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

        foreach($team_a as $row_team_a)
        {
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

        $team_a_total = 0;

        if($level == '1')
        {
            $team_a_total = $count_a1+$count_a2+$count_a3+$count_a4+$count_a5+$count_a6+$count_a7+$count_a8+$count_a9+$count_a10;
        }
        elseif($level == '2')
        {
            $team_a_total = $count_a2+$count_a3+$count_a4+$count_a5+$count_a6+$count_a7+$count_a8+$count_a9+$count_a10;
        }
        elseif($level == '3')
        {
            $team_a_total = $count_a3+$count_a4+$count_a5+$count_a6+$count_a7+$count_a8+$count_a9+$count_a10;
        }
        elseif($level == '4')
        {
            $team_a_total = $count_a4+$count_a5+$count_a6+$count_a7+$count_a8+$count_a9+$count_a10;
        }
        elseif($level == '5')
        {
            $team_a_total = $count_a5+$count_a6+$count_a7+$count_a8+$count_a9+$count_a10;
        }
        elseif($level == '6')
        {
            $team_a_total = $count_a6+$count_a7+$count_a8+$count_a9+$count_a10;
        }
        elseif($level == '7')
        {
            $team_a_total = $count_a7+$count_a8+$count_a9+$count_a10;
        }
        elseif($level == '8')
        {
            $team_a_total = $count_a8+$count_a9+$count_a10;
        }
        elseif($level == '9')
        {
            $team_a_total = $count_a9+$count_a10;
        }

        if($sponsor >= $poinSponsor && $omset >= $poinOmset && $team >= 3 && $team_a_total >= 1)
        {
            $fmLevel = 'FM'.($level+1);

            $data = [
                'fm' => $fmLevel,
                'update_date' => time()
            ];
            
            $this->M_user->update_data_byid('level_fm', $data, 'user_id', $row_id);
        }
    }

    private function _setLevelTeamC($row_id, $poinSponsor, $poinOmset, $level, $levelSpnr, $team)
    {
        $query_sponsor = $this->M_user->get_sponsor_box($row_id);

        $sponsor = 0;
        foreach($query_sponsor as $row_sponsor)
        {
            if(!empty($row_sponsor->point))
            {
                $sponsor = $sponsor+$row_sponsor->point;
            }
        }

        $sponsor    = $sponsor;
                
        $omset   = $this->_omset_bysponsor($row_id);

        $team_a             = $this->M_user->get_team($row_id, 3, 0);
        $query_row_team     = $this->M_user->row_data_byuser('cart', 'sponsor_id', $row_id);
        $team_c             = $this->M_user->get_team($row_id, $query_row_team, '6');

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

        foreach($team_a as $row_team_a)
        {
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

        foreach($team_c as $row_team_c)
        {
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

        $team_c_total = 0;
        $team_a_total = 0;

        if($level == '7')
        {
            $team_a_total = $count_a7+$count_a8+$count_a9+$count_a10;
            $team_c_total = $count_c7+$count_c8+$count_c9+$count_c10;
        }
        elseif($level == '8')
        {
            $team_a_total = $count_a8+$count_a9+$count_a10;
            $team_c_total = $count_c8+$count_c9+$count_c10;
        }
        elseif($level == '9')
        {
            $team_a_total = $count_a9+$count_a10;
            $team_c_total = $count_c9+$count_c10;
        }



        if($sponsor >= $poinSponsor && $omset >= $poinOmset && $team >= 3 && $team_a_total >= 1 && $team_c_total >= 1)
        {
            $fmLevel = 'FM'.($level+1);

            $data = [
                'fm' => $fmLevel,
                'update_date' => time()
            ];
            
            $this->M_user->update_data_byid('level_fm', $data, 'user_id', $row_id);
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

        foreach($query as $row)
        {
            array_push($this->arrPointSpon, $row->point);

            $this->_get_countPointSponsor($row->user_id);
        }

        return $this->arrPointSpon;
    }

    /**Bonus mining generasi */
    public function miningPairing()
    {
        $user = $this->M_user->get_userfm()->result();
        $date = date('Y-m-d');

        foreach($user as $row_user)
        {
            /**if level FM */
            if($row_user->fm == 'FM')
            {
                $endLoop = 2;
                $this->_minpairing_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM1') /**if level FM1 */
            {
                $endLoop = 3;
                $this->_minpairing_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM2') /**if level FM2 */
            {
                $endLoop = 5;
                $this->_minpairing_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM3') /**if level FM3 */
            {
                $endLoop = 7;
                $this->_minpairing_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM4') /**if level FM4 */
            {
                $endLoop = 9;
                $this->_minpairing_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM5') /**if level FM5 */
            {
                $endLoop = 11;
                $this->_minpairing_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM6') /**if level FM6 */
            {
                $endLoop = 12;
                $this->_minpairing_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM7') /**if level FM7 */
            {
                $endLoop = 15;
                $this->_minpairing_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM8') /**if level FM8 */
            {
                $endLoop = 20;
                $this->_minpairing_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM9') /**if level FM9 */
            {
                $endLoop = 30;
                $this->_minpairing_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM10') /**if level FM10 */
            {
                $endLoop = 50;
                $this->_minpairing_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
        }
    }

    private function _minpairing_generation($userId, $userSpon, $date, $generation, $endLoop)
    {
        if($generation > $endLoop)
        {
            return false;
        }

        $sponsor = $this->M_user->get_poin_bysponsor($userSpon);
        
        foreach($sponsor->result() as $row_spon)
        {
            $this->_count_bonus_minpairing($userId, $row_spon->user_id, $generation, $date);
            
            //looping
            $this->_minpairing_generation($userId, $row_spon->user_id, $date, $generation+1, $endLoop);
        }
    }

    private function _count_bonus_minpairing($id, $user_id, $generation, $date)
    {
        $newdate = $date.' 00:00:00';
        $d = DateTime::createFromFormat('Y-m-d H:i:s', $newdate)->getTimestamp();

        if($generation == '2' || $generation == '9' || $generation == '10')
        {
            $percent = 20;
        }
        elseif($generation == '3' || $generation == '8' || $generation == '11')
        {
            $percent = 15;
        }
        elseif($generation == '4' || $generation == '7' || $generation == '12')
        {
            $percent = 10;
        }
        elseif($generation == '5' || $generation == '6' || $generation == '13' || $generation == '14' || $generation == '15')
        {
            $percent = 5;
        }
        elseif($generation >= '16' && $generation <= '20')
        {
            $percent = 3;
        }
        elseif($generation >= '21' && $generation <= '30')
        {
            $percent = 2;
        }
        elseif($generation >= '31' && $generation <= '50')
        {
            $percent = 1;
        }

        $query_team_a = $this->M_user->get_mining_team($user_id, $date, '3', '0');
        
        //$total_a = 0;
        foreach($query_team_a as $row_team_a)
        {
            if($row_team_a->amount > 0)
            {
                $bonus_team_a = (3*$row_team_a->amount)/100;
    
                /**Bonus mining pairing for team A */
                $bonus_minpairing_a = ($percent*$bonus_team_a)/100;
    
                $data_a = [
                    'user_id' => $id,
                    'user_sponsor' => $user_id,
                    'member_sponsor' => $row_team_a->user_id,
                    'generation' => 'G'.$generation,
                    'team' => 'A',
                    'amount' => $bonus_minpairing_a,
                    'datecreate' => $d
                ];
                
                $check_team_a = $this->M_user->row_data_sixcolumn('bonus_minpairing', 'datecreate', 'user_id', 'team', 'user_sponsor', 'generation', 'member_sponsor', $date, $id, 'A', $user_id, 'G'.$generation, $row_team_a->user_id);
    
                if($check_team_a < 1)
                {
                    $this->M_user->insert_data('bonus_minpairing', $data_a);
                }
            }
        }

        $query_team_b = $this->M_user->get_mining_team($user_id, $date, '3', '3');

        foreach($query_team_b as $row_team_b)
        {
            if($row_team_b->amount > 0)
            {
                $bonus_team_b = (4*$row_team_b->amount)/100;
    
                /**Bonus mining pairing for team B */
                $bonus_minpairing_b = ($percent*$bonus_team_b)/100;
    
                $data_b = [
                    'user_id' => $id,
                    'user_sponsor' => $user_id,
                    'member_sponsor' => $row_team_b->user_id,
                    'generation' => 'G'.$generation,
                    'team' => 'B',
                    'amount' => $bonus_minpairing_b,
                    'datecreate' => $d
                ];
                
                $check_team_b = $this->M_user->row_data_sixcolumn('bonus_minpairing', 'datecreate', 'user_id', 'team', 'user_sponsor', 'generation', 'member_sponsor', $date, $id, 'B', $user_id, 'G'.$generation, $row_team_b->user_id);
    
                if($check_team_b < 1)
                {
                    $this->M_user->insert_data('bonus_minpairing', $data_b);
                }
            }
        }

        $query_row_team     = $this->M_user->row_data_byuser('cart', 'sponsor_id' ,$user_id);
        $query_team_c       = $this->M_user->get_mining_team($user_id, $date, $query_row_team, '6');

        foreach($query_team_c as $row_team_c)
        {
            if($row_team_c->amount > 0)
            {
                $bonus_team_c = (5*$row_team_c->amount)/100;
    
                /**Bonus mining pairing for team C */
                $bonus_minpairing_c = ($percent*$bonus_team_c)/100;
    
                $data_c = [
                    'user_id' => $id,
                    'user_sponsor' => $user_id,
                    'member_sponsor' => $row_team_c->user_id,
                    'generation' => 'G'.$generation,
                    'team' => 'C',
                    'amount' => $bonus_minpairing_c,
                    'datecreate' => $d
                ];
                
                $check_team_c = $this->M_user->row_data_sixcolumn('bonus_minpairing', 'datecreate', 'user_id', 'team', 'user_sponsor', 'generation', 'member_sponsor', $date, $id, 'C', $user_id, 'G'.$generation, $row_team_c->user_id);
    
                if($check_team_c < 1)
                {
                    $this->M_user->insert_data('bonus_minpairing', $data_c);
                }
            }
        }

        return true;
    }

    /**Bonus pairing matching */
    public function binaryMatching()
    {
        $user = $this->M_user->get_userfm()->result();
        $date = date('Y-m-d');

        foreach($user as $row_user)
        {
            if($row_user->fm == 'FM')
            {
                $endLoop = 2;
                $this->_binmatch_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM1')
            {
                $endLoop = 3;
                $this->_binmatch_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM2')
            {
                $endLoop = 5;
                $this->_binmatch_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM3')
            {
                $endLoop = 7;
                $this->_binmatch_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM4')
            {
                $endLoop = 9;
                $this->_binmatch_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM5')
            {
                $endLoop = 11;
                $this->_binmatch_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM6')
            {
                $endLoop = 12;
                $this->_binmatch_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM7')
            {
                $endLoop = 15;
                $this->_binmatch_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM8')
            {
                $endLoop = 20;
                $this->_binmatch_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM9')
            {
                $endLoop = 30;
                $this->_binmatch_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
            elseif($row_user->fm == 'FM10')
            {
                $endLoop = 50;
                $this->_binmatch_generation($row_user->user_id, $row_user->user_id, $date, '2', $endLoop);
            }
        }
    }

    private function _binmatch_generation($userId, $userSpon, $date, $generation, $endLoop)
    {
        if($generation > $endLoop)
        {
            return false;
        }

        $sponsor = $this->M_user->get_poin_bysponsor($userSpon);
        
        foreach($sponsor->result() as $row_spon)
        {
            $this->_count_bonus_binmatch($userId, $row_spon->user_id, $date, $generation);
            
            //looping
            $this->_binmatch_generation($userId, $row_spon->user_id, $date, $generation+1, $endLoop);
        }
    }

    private function _count_bonus_binmatch($id, $user_id, $date, $generation)
    {
        $newdate = $date.' 00:00:00';
        $d = DateTime::createFromFormat('Y-m-d H:i:s', $newdate)->getTimestamp();

        if($generation == '2' || $generation == '9' || $generation == '10')
        {
            $percent = 20;
        }
        elseif($generation == '3' || $generation == '8' || $generation == '11')
        {
            $percent = 15;
        }
        elseif($generation == '4' || $generation == '7' || $generation == '12')
        {
            $percent = 10;
        }
        elseif($generation == '5' || $generation == '6')
        {
            $percent = 5;
        }
        elseif($generation >= '13' && $generation <= '15')
        {
            $percent = 5;
        }
        elseif($generation >= '16' && $generation <= '20')
        {
            $percent = 3;
        }
        elseif($generation >= '21' && $generation <= '30')
        {
            $percent = 2;
        }
        elseif($generation >= '31' && $generation <= '50')
        {
            $percent = 1;
        }

        $omset = $this->M_user->get_total_bydata_date('bonus_maxmatching', 'mtm', 'user_id', $user_id, $date);
                
        if(!empty($omset['mtm']))
        {
            $bonus = (20*$omset['mtm'])/100;

            $limit_bonus        = $this->_check_limit_bonus($user_id, $bonus);
            $excess_bonus       = $bonus - $limit_bonus;
            $limit_count_mtm    = $limit_bonus;

            $data = [
                'user_id' => $id,
                'user_sponsor' => $user_id,
                'generation' => 'G'.$generation,
                'mtm' => $limit_count_mtm,
                'datecreate' => $d
            ];

            $check_data = $this->M_user->row_data_fourcolumn('bonus_binarymatch', 'datecreate', 'user_id', 'user_sponsor', 'generation', $date, $id,  $user_id, 'G'.$generation);
            
            if($check_data < 1)
            {
                $this->M_user->insert_cart('bonus_binarymatch', $data);
                
                $data_excess_bonus = [
                    'user_id' => $user_id,
                    'type_bonus' => '4',
                    'mtm' => $excess_bonus,
                    'cart_id' => '0',
                    'code_bonus' => '0',
                    'user_sponsor' => $user_id,
                    'generation' => 'G'.$generation,
                    'note' => 'bonus pairing matching',
                    'datecreate' => $d
                ];
    
                $insert = $this->M_user->insert_data('excess_bonus', $data_excess_bonus);

                return true;
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

    /**Bonus Global Every moth*/
    public function bonusGlobal()
    {
        $year_month   = date('Y-m', strtotime("-1 month"));
        $date         = date('Y-m-d');
        // $date         = '2022-02-01';
        
        /**Global omset*/
        $query_omset    = $this->M_user->get_global_omset($year_month);
        $global_omset   = $query_omset['fill'] + ($query_omset['mtm']/4) + ($query_omset['zenx']/12);

        if(!empty($global_omset))
        {
            $dateLimit = $year_month.'-15';
            
            /**Get amount FM LEVEL */
            $count_fm4 = $this->M_user->count_fm_bymonth_now($dateLimit, 'FM4');
            $count_fm5 = $this->M_user->count_fm_bymonth_now($dateLimit, 'FM5');
            $count_fm6 = $this->M_user->count_fm_bymonth_now($dateLimit, 'FM6');
            $count_fm7 = $this->M_user->count_fm_bymonth_now($dateLimit, 'FM7');
            $count_fm8 = $this->M_user->count_fm_bymonth_now($dateLimit, 'FM8');
            $count_fm9 = $this->M_user->count_fm_bymonth_now($dateLimit, 'FM9');
            $count_fm10 = $this->M_user->count_fm_bymonth_now($dateLimit, 'FM10');
            
            $amount_fm4  = $count_fm4+$count_fm5+$count_fm6+$count_fm7+$count_fm8+$count_fm9+$count_fm10;
            $amount_fm5  = $count_fm5+$count_fm6+$count_fm7+$count_fm8+$count_fm9+$count_fm10;
            $amount_fm6  = $count_fm6+$count_fm7+$count_fm8+$count_fm9+$count_fm10;
            $amount_fm7  = $count_fm7+$count_fm8+$count_fm9+$count_fm10;
            $amount_fm8  = $count_fm8+$count_fm9+$count_fm10;
            $amount_fm9  = $count_fm9+$count_fm10;
            $amount_fm10 = $count_fm10;
            
            
            /**Count bonus */
            if(!empty($amount_fm4))
            {
                $bonus_fm4  = ((($global_omset * 2)/100)*4)/$amount_fm4;
            }
    
            if(!empty($amount_fm5))
            {
                $bonus_fm5  = ((($global_omset * 1)/100)*4)/$amount_fm5;
            }
    
            if(!empty($amount_fm6))
            {
                $bonus_fm6  = ((($global_omset * 0.5)/100)*4)/$amount_fm6;
            }
    
            if(!empty($amount_fm7))
            {
                $bonus_fm7  = ((($global_omset * 0.4)/100)*4)/$amount_fm7;
            }
    
            if(!empty($amount_fm8))
            {
                $bonus_fm8  = ((($global_omset * 0.3)/100)*4)/$amount_fm8;
            }
            
            if(!empty($amount_fm9))
            {
                $bonus_fm9  = ((($global_omset * 0.2)/100)*4)/$amount_fm9;
            }
            
            if(!empty($amount_fm10))
            {
                $bonus_fm10 = ((($global_omset * 0.1)/100)*4)/$amount_fm10;
            }
            
            $query_user = $this->M_user->get_user_global_limitdate($dateLimit);
            
            foreach($query_user->result() as $row_user)
            {
                if($row_user->fm == 'FM4')
                {                                                                                                   
                    $this->_insert_bonus_global($row_user->id, $bonus_fm4, $date, 'FM4');
                }
                elseif($row_user->fm == 'FM5')
                {
                    $this->_insert_bonus_global($row_user->id, $bonus_fm5, $date, 'FM5');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm4, $date, 'FM4');
                }
                elseif($row_user->fm == 'FM6')
                {
                    $this->_insert_bonus_global($row_user->id, $bonus_fm6, $date, 'FM6');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm5, $date, 'FM5');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm4, $date, 'FM4');
                }
                elseif($row_user->fm == 'FM7')
                {
                    $this->_insert_bonus_global($row_user->id, $bonus_fm7, $date, 'FM7');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm6, $date, 'FM6');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm5, $date, 'FM5');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm4, $date, 'FM4');
                }
                elseif($row_user->fm == 'FM8')
                {
                    $this->_insert_bonus_global($row_user->id, $bonus_fm8, $date, 'FM8');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm7, $date, 'FM7');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm6, $date, 'FM6');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm5, $date, 'FM5');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm4, $date, 'FM4');
                }
                elseif($row_user->fm == 'FM9')
                {
                    $this->_insert_bonus_global($row_user->id, $bonus_fm9, $date, 'FM9');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm8, $date, 'FM8');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm7, $date, 'FM7');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm6, $date, 'FM6');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm5, $date, 'FM5');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm4, $date, 'FM4');
                }
                elseif($row_user->fm == 'FM10')
                {
                    $this->_insert_bonus_global($row_user->id, $bonus_fm10, $date, 'FM10');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm9, $date, 'FM9');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm8, $date, 'FM8');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm7, $date, 'FM7');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm6, $date, 'FM6');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm5, $date, 'FM5');
                    $this->_insert_bonus_global($row_user->id, $bonus_fm4, $date, 'FM4');
                }
            }
        }
    }

    private function _insert_bonus_global($user_id, $bonus, $date, $fm)
    {
        $newdate = $date.' 00:00:00';
        $d = DateTime::createFromFormat('Y-m-d H:i:s', $newdate)->getTimestamp();
        $month      = date('m', strtotime($date));
        $year       = date('Y', strtotime($date));  
         
        $limit_bonus   = $this->_check_limit_bonus($user_id, $bonus);
        $excess_bonus  = $bonus - $limit_bonus;

        $limit_count_mtm    = $limit_bonus;

        $check_data = $this->M_user->row_check_global($user_id, $year.'-'.$month, $fm);

        if($check_data < 1)
        {
            $data = [
                'user_id' => $user_id,
                'mtm' => $limit_count_mtm,
                'level_fm' => $fm,
                'datecreate' => $d
            ];
    
            $this->M_user->insert_data('bonus_global', $data);
        }

        if($limit_count_mtm == 0)
        {
            $level_excess = $fm;
        }
        else
        {
            $level_excess = '';
        }

        $data_excess_bonus = [
            'user_id' => $user_id,
            'type_bonus' => '5',
            'mtm' => $excess_bonus,
            'cart_id' => '0',
            'code_bonus' => '',
            'user_sponsor' => '0',
            'generation' => '0',
            'note' => 'bonus global',
            'level_fm' => $level_excess,
            'note_level' => $fm,
            'datecreate' => $d
        ];

        $insert = $this->M_user->insert_data('excess_bonus', $data_excess_bonus);
    }

    //Bonus basecamp
    public function bonusBasecamp()
    {
        $dateNow = date('Y-m-d');

        $query_user = $this->M_user->get_all_basecamp();

        foreach($query_user as $row_user)
        {
            
            $query_basecamp = $this->M_user->get_basecamp_byuser($row_user->id);
            
            foreach($query_basecamp as $row_basecamp)
            {
                $limit_basecamp         = $this->_check_limit_bonus($row_user->id, $row_basecamp->mtm);
                $excess_bonus_basecamp  = $row_basecamp->mtm - $limit_basecamp;
                $limit_count_basecamp   = $limit_basecamp;
                
                $data_update = [
                    'status' => '1',
                    'mtm' => $limit_count_basecamp,
                    'update_date' => time()
                ];
    
                $update = $this->M_user->update_data_byid('bonus_basecamp', $data_update, 'id', $row_basecamp->id);

                $data_excess_basecamp = [
                    'user_id' => $row_user->id,
                    'type_bonus' => '3',
                    'mtm' => $excess_bonus_basecamp,
                    'cart_id' => $row_basecamp->cart_id,
                    'code_bonus' => $row_basecamp->code_bonus,
                    'user_sponsor' => '0',
                    'generation' => '0',
                    'note' => 'bonus basecamp',
                    'datecreate' => time()
                ];

                $insert = $this->M_user->insert_data('excess_bonus', $data_excess_basecamp);
            }
        }
    }
}
?>