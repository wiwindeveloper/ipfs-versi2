<?php
                                        $userLine = $userClass->showLine($user['id']);
                                        
                                        if(count($userLine) != '')
                                        {
                                            echo "<ul>";
                                            foreach($userLine as $row_line)
                                            {
                                                $countLeft      = $userClass->countPositionL($row_line['user_id']);
                                                $countRight     = $userClass->countPositionR($row_line['user_id']);
                                                $balancePoint   = $userClass->balance_point($row_line['user_id']);
                                                $increaseLeft   = $userClass->countPositionL($row_line['user_id'])-$userClass->increasePoint($row_line['user_id'], 'L');
                                                $increaseRight  = $userClass->countPositionR($row_line['user_id'])-$userClass->increasePoint($row_line['user_id'], 'R');
                                                $pointTodayL    = $userClass->countPointTodayL($row_line['user_id']);
                                                $pointTodayR    = $userClass->countPointTodayR($row_line['user_id']);
                                                
                                                if($balancePoint)
                                                {
                                                    $balance_a = $balancePoint['amount_left']+$increaseLeft;
                                                    $balance_b = $balancePoint['amount_right']+$increaseRight;
                                                }
                                                else
                                                {
                                                    $balance_a = $increaseLeft;
                                                    $balance_b = $increaseRight;
                                                }

                                                $userLine = $userClass->showLine($row_line['user_id']);

                                                if(count($userLine) != '')
                                                {
                                                    //echo '<li> <a href="#" id="'.$row_line['user_id'].'" onclick="event.preventDefault(); show_details(this);"><span><img src="'.base_url('assets/img/').$row_line['color'].'" alt="image"><p>'.$row_line['username'].'</p> </span></a>';
                                                    
                                                    echo '<li> 
                                                            <a href="'.base_url('user/network/').$row_line['user_id'].'">
                                                                <span>
                                                                    <div class="netusername" style="background: '.$row_line['color'].'">'
                                                                        .$row_line['username'].'
                                                                    </div> 
                                                                    <img style="width: 24px !important;position: absolute;top: 9px;right: 10px;" src="'.base_url('assets/img/').$userClass->flag($row_line['country_code']).'" alt="">
                                                                    <p class="color-bluelight">'.$row_line['name'].'</p>
                                                                    <div class="d-flex netposition">
                                                                        <div class="p-4 bd-right">
                                                                            <p class="position-label">Left</p>
                                                                            <p class="color-bluelight">
                                                                                '.$balance_a.'&nbsp;('.$countLeft.')
                                                                            </p>
                                                                            <p class="mb-0 level-label">
                                                                                Increase
                                                                            </p>
                                                                            <p class="color-bluelight">
                                                                                + '.$pointTodayL.'
                                                                            </p>
                                                                        </div>
                                                                        <div class="p-4 bd-left">
                                                                            <p class="position-label">Right</p>
                                                                            <p class="color-bluelight">
                                                                                '.$balance_b.'&nbsp;('.$countRight.')
                                                                            </p>
                                                                            <p class="mb-0 level-label">
                                                                                Increase
                                                                            </p>
                                                                            <p class="color-bluelight">
                                                                                + '.$pointTodayR.'
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <p class="level-label">Level: </p>
                                                                    <p class="color-bluelight fm">'.$row_line['fm'].'</p>
                                                                </span>
                                                            </a>
                                                            <ul>';

                                                    foreach($userLine as $row_line)
                                                    {
                                                        $countLeft      = $userClass->countPositionL($row_line['user_id']);
                                                        $countRight     = $userClass->countPositionR($row_line['user_id']);
                                                        // $countLeft      = 100;
                                                        // $countRight     = 220;

                                                        $balancePoint   = $userClass->balance_point($row_line['user_id']);
                                                        $increaseLeft   = $userClass->countPositionL($row_line['user_id'])-$userClass->increasePoint($row_line['user_id'], 'L');
                                                        $increaseRight  = $userClass->countPositionR($row_line['user_id'])-$userClass->increasePoint($row_line['user_id'], 'R');
                                                        $pointTodayL    = $userClass->countPointTodayL($row_line['user_id']);
                                                        $pointTodayR    = $userClass->countPointTodayR($row_line['user_id']);
                                                        // $pointTodayL    = 10;
                                                        // $pointTodayR    = 20;

                                                        if($balancePoint)
                                                        {
                                                            $balance_a = $balancePoint['amount_left']+$increaseLeft;
                                                            $balance_b = $balancePoint['amount_right']+$increaseRight;
                                                            // $balance_a = 100;
                                                            // $balance_b = 220;
                                                        }
                                                        else
                                                        {
                                                            $balance_a = $increaseLeft;
                                                            $balance_b = $increaseRight;
                                                            // $balance_a = 100;
                                                            // $balance_b = 220;
                                                        }

                                                        $userLine = $userClass->showLine($row_line['user_id']);
    
                                                        if(count($userLine) != '')
                                                        {
                                                            //echo '<li><a href="#" id="'.$row_line['user_id'].'" onclick="event.preventDefault(); show_details(this);"><span><img src="'.base_url('assets/img/').$row_line['color'].'" alt="image"><p>'.$row_line['username'].'</p></span></a>';
                                                            echo '<li>
                                                                    <a href="'.base_url('user/network/').$row_line['user_id'].'">
                                                                        <span>
                                                                            <div class="netusername" style="background: '.$row_line['color'].'">'.$row_line['username'].'</div>
                                                                            <img style="width: 24px !important;position: absolute;top: 9px;right: 10px;" src="'.base_url('assets/img/').$userClass->flag($row_line['country_code']).'" alt="">
                                                                            <p class="color-bluelight">'.$row_line['name'].'</p>
                                                                            <div class="d-flex netposition">
                                                                                <div class="p-4 bd-right">
                                                                                    <p class="position-label">Left</p>
                                                                                    <p class="color-bluelight">
                                                                                    '.$balance_a.'&nbsp;('.$countLeft.')
                                                                                    </p>
                                                                                    <p class="mb-0 level-label">
                                                                                        Increase
                                                                                    </p>
                                                                                    <p class="color-bluelight">
                                                                                        + '.$pointTodayL.'
                                                                                    </p>
                                                                                </div>
                                                                                <div class="p-4 bd-left">
                                                                                    <p class="position-label">Right</p>
                                                                                    <p class="color-bluelight">
                                                                                    '.$balance_b.'&nbsp;('.$countRight.')
                                                                                    </p>
                                                                                    <p class="mb-0 level-label">
                                                                                        Increase
                                                                                    </p>
                                                                                    <p class="color-bluelight ">
                                                                                        + '.$pointTodayR.'
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <p class="level-label">Level: </p>
                                                                            <p class="color-bluelight fm">'.$row_line['fm'].'</p>
                                                                        </span>
                                                                    </a>';
                                                            
                                                            echo '<ul class="hide-responsive">';
        
                                                            foreach($userLine as $row_line)
                                                            {
                                                                $countLeft      = $userClass->countPositionL($row_line['user_id']);
                                                                $countRight     = $userClass->countPositionR($row_line['user_id']);
                                                                $balancePoint   = $userClass->balance_point($row_line['user_id']);
                                                                $increaseLeft   = $userClass->countPositionL($row_line['user_id'])-$userClass->increasePoint($row_line['user_id'], 'L');
                                                                $increaseRight  = $userClass->countPositionR($row_line['user_id'])-$userClass->increasePoint($row_line['user_id'], 'R');
                                                                $pointTodayL    = $userClass->countPointTodayL($row_line['user_id']);
                                                                $pointTodayR    = $userClass->countPointTodayR($row_line['user_id']);

                                                                if($balancePoint)
                                                                {
                                                                    $balance_a = $balancePoint['amount_left']+$increaseLeft;
                                                                    $balance_b = $balancePoint['amount_right']+$increaseRight;
                                                                }
                                                                else
                                                                {
                                                                    $balance_a = $increaseLeft;
                                                                    $balance_b = $increaseRight;
                                                                }

                                                                $userLine = $userClass->showLine($row_line['user_id']);

                                                                //echo '<li><a href="#" id="'.$row_line['user_id'].'" onclick="event.preventDefault(); show_details(this);"><span><img src="'.base_url('assets/img/').$row_line['color'].'" alt="image"><p>'.$row_line['username'].'</p></span></a></li>';
                                                                echo '<li>
                                                                        <a href="'.base_url('user/network/').$row_line['user_id'].'">
                                                                            <span>
                                                                                <div class="netusername" style="background: '.$row_line['color'].'">'.$row_line['username'].'</div>
                                                                                <img style="width: 24px !important;position: absolute;top: 9px;right: 10px;" src="'.base_url('assets/img/').$userClass->flag($row_line['country_code']).'" alt="">
                                                                                <p class="color-bluelight">'.$row_line['name'].'</p>
                                                                                <div class="d-flex netposition">
                                                                                    <div class="p-4 bd-right">
                                                                                        <p class="position-label">Left</p>
                                                                                        <p class="color-bluelight">
                                                                                        '.$balance_a.'&nbsp;('.$countLeft.')
                                                                                        </p>
                                                                                        <p class="mb-0 level-label">
                                                                                            Increase
                                                                                        </p>
                                                                                        <p class="color-bluelight">
                                                                                            + '.$pointTodayL.'
                                                                                        </p>
                                                                                    </div>
                                                                                    <div class="p-4 bd-left">
                                                                                        <p class="position-label">Right</p>
                                                                                        <p class="color-bluelight">
                                                                                        '.$balance_b.'&nbsp;('.$countRight.')
                                                                                        </p>
                                                                                        <p class="mb-0 level-label">
                                                                                            Increase
                                                                                        </p>
                                                                                        <p class="color-bluelight">
                                                                                            + '.$pointTodayR.'
                                                                                        </p>
                                                                                    </div>
                                                                                </div>
                                                                                <p class="level-label">Level: </p>
                                                                                <p class="color-bluelight fm">'.$row_line['fm'].'</p>
                                                                            </span>
                                                                        </a>
                                                                     </li>';
                                                            }
        
                                                            echo '</ul></li>';
                                                        }
                                                        else
                                                        {
                                                            //echo '<li><a href="#" id="'.$row_line['user_id'].'" onclick="event.preventDefault(); show_details(this);"><span><img src="'.base_url('assets/img/').$row_line['color'].'" alt="img"><p>'.$row_line['username'].'</p></span></a></li>';
                                                            echo '<li>
                                                                    <a href="'.base_url('user/network/').$row_line['user_id'].'">
                                                                        <span>
                                                                            <div class="netusername" style="background: '.$row_line['color'].'">'.$row_line['username'].'</div>
                                                                            <img style="width: 24px !important;position: absolute;top: 9px;right: 10px;" src="'.base_url('assets/img/').$userClass->flag($row_line['country_code']).'" alt="">
                                                                            <p class="color-bluelight">'.$row_line['name'].'</p>
                                                                            <div class="d-flex netposition">
                                                                                <div class="p-4 bd-right">
                                                                                    <p class="position-label">Left</p>
                                                                                    <p class="color-bluelight">
                                                                                        '.$balance_a.'&nbsp;('.$countLeft.')
                                                                                    </p>
                                                                                    <p class="mb-0 level-label">
                                                                                        Increase
                                                                                    </p>
                                                                                    <p class="color-bluelight">
                                                                                        + '.$pointTodayL.'
                                                                                    </p>
                                                                                </div>
                                                                                <div class="p-4 bd-left">
                                                                                    <p class="position-label">Right</p>
                                                                                    <p class="color-bluelight">
                                                                                    '.$balance_b.'&nbsp;('.$countRight.')
                                                                                    </p>
                                                                                    <p class="mb-0 level-label">
                                                                                        Increase
                                                                                    </p>
                                                                                    <p class="color-bluelight">
                                                                                        + '.$pointTodayR.'
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                            <p class="level-label">Level: </p>
                                                                            <p class="color-bluelight fm">'.$row_line['fm'].'</p>
                                                                        </span>
                                                                    </a>
                                                                </li>';
                                                        }
                                                    }
    
                                                    echo "</li></ul>";
    
                                                }
                                                else
                                                {
                                                    //echo '<li> <a href="#" id="'.$row_line['user_id'].'" onclick="event.preventDefault(); show_details(this);"><span><img src="'.base_url('assets/img/').$row_line['color'].'" alt="img"><p>'.$row_line['username'].'</p> </span></a></li>';
                                                    echo '<li> 
                                                            <a href="'.base_url('user/network/').$row_line['user_id'].'">
                                                                <span>
                                                                    <div class="netusername" style="background: '.$row_line['color'].'">'.$row_line['username'].'</div>
                                                                    <img style="width: 24px !important;position: absolute;top: 9px;right: 10px;" src="'.base_url('assets/img/').$userClass->flag($row_line['country_code']).'" alt=""> 
                                                                    <p class="color-bluelight">'.$row_line['name'].'</p>
                                                                    <div class="d-flex netposition">
                                                                        <div class="p-4 bd-right">
                                                                            <p class="position-label">Left</p>
                                                                            <p class="color-bluelight">
                                                                                '.$balance_a.'&nbsp;('.$countLeft.')
                                                                            </p>
                                                                            <p class="mb-0 level-label">
                                                                                Increase
                                                                            </p>
                                                                            <p class="color-bluelight">
                                                                                + '.$pointTodayL.'
                                                                            </p>
                                                                        </div>
                                                                        <div class="p-4 bd-left">
                                                                            <p class="position-label">Right</p>
                                                                            <p class="color-bluelight">
                                                                            '.$balance_b.'&nbsp;('.$countRight.')
                                                                            </p>
                                                                            <p class="mb-0 level-label">
                                                                                Increase
                                                                            </p>
                                                                            <p class="color-bluelight">
                                                                                + '.$pointTodayR.'
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    <p class="level-label">Level: </p>
                                                                    <p class="color-bluelight fm">'.$row_line['fm'].'</p>
                                                                </span>
                                                            </a>
                                                        </li>';
                                                    
                                                } 
                                            }
                                            echo "</ul>";
                                        }  
                                    ?> 






<div class="netusername" style="background: <?= $package['color']; ?>;">
    <?= $user['username']; ?>
</div>
<img style="width: 24px !important;position: absolute;top: 9px;right: 10px;" src="<?= base_url('assets/img/').$userClass->flag($user['country_code']); ?>" alt="">
<p class="color-bluelight"><?= $package['name']; ?></p>
<div class="d-flex netposition">
    <div class="p-4 bd-right">
        <p class="position-label">Left</p>
        <p class="color-bluelight">
            <?= $balance_a . '&nbsp;('.$userClass->countPositionL($user['id']).')'; ?>
        </p>
        <p class="mb-0 level-label">
            Increase
        </p>
        <p class="color-bluelight">
            + <?= $pointTodayL; ?>
        </p>
    </div>
    <div class="p-4 bd-left">
        <p class="position-label">Right</p>
        <p class="color-bluelight">
            <?= $balance_b.'&nbsp;('.$userClass->countPositionR($user['id']).')'; ?>
        </p>
        <p class="mb-0 level-label">
            Increase
        </p>
        <p class="color-bluelight">
            + <?= $pointTodayR; ?>
        </p>
    </div>
</div>
<p class="level-label">Level: </p>
<p class="color-bluelight fm"><?= $package['fm']; ?></p>


                                                $increaseRight  = $userClass->countPositionR($user['id'])-$userClass->increasePoint($user['id'], 'R');
                                                $pointTodayL    = $userClass->countPointTodayL($user['id']);
                                                $pointTodayR    = $userClass->countPointTodayR($user['id']);

                                                if($balancePoint)
                                                {
                                                    $balance_a = $balancePoint['amount_left']+$increaseLeft;
                                                    $balance_b = $balancePoint['amount_right']+$increaseRight;
                                                }
                                                else
                                                {
                                                    $balance_a = $increaseLeft;
                                                    $balance_b = $increaseRight;
                                                }