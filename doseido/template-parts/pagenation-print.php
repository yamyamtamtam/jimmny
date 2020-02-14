<section class="pagenation">
  <?php
    //ページネーションのナビゲーション出力
    $pagenation_count = ceil(count($items) / $number_in_page); //総数を9で割って切り上げ
    $current_url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    if(strpos($current_url,'pagenation=') !== false){ //URLにpagenation=の文言ある場合、文言削除
        preg_match('/pagenation=(\w+)/', $current_url, $current_pagenation);
        $current_url = preg_replace('/pagenation=(\w+)/', '', $current_url);
    }else{
      $current_pagenation[1] = 1;
    }
    for($i = 1; $i <= $pagenation_count; $i++):
      if($current_pagenation[1] == $i){
        $add_active = ' pagenation__active';
      }else{
        $add_active = '';
      }
    ?>
      <?php
      if($pagenation_count >= 10): //ページネーションが10個以上のとき
        $last_diff = $pagenation_count - $current_pagenation[1];
        //12345.....10としたい
        if($current_pagenation[1] < 5){
          if($i > 5 && $i != $pagenation_count){
            continue;
          }elseif($i == $pagenation_count){
            echo '<div class="pagenation__dot">・・・・・</div>';
          }
        //1...34567...10としたい
        }elseif($current_pagenation[1] >= 5 && $last_diff >= 4){
          $current_diff_first = $current_pagenation[1] - 2;
          $current_diff_last = $current_pagenation[1] + 2;
          if($i == $current_diff_first || $i == $pagenation_count){
            echo '<div class="pagenation__dot">・・・</div>';
          }
          if($i == 1 || $i == $pagenation_count){ //最初と最後は出力
          }elseif($i >= $current_diff_first && $i <= $current_diff_last){ //現在のページネーション+-2まで出力
          }else{
            continue;
          }
        //1...678910としたい
        }elseif($last_diff < 4){
          $last_first = $pagenation_count - 5;
          $last_dot = $pagenation_count - 4;
          if($i <= $last_first && $i != 1){
            continue;
          }elseif($i == $last_dot){
            echo '<div class="pagenation__dot">・・・・・</div>';
          }
        }
      ?>
        <?php if(strpos($current_url,'?') === false): //?ない場合 ?>
          <a class="pagenation__number<?php echo $add_active; ?>" href="<?php echo $current_url . '?pagenation=' . $i; ?>"><span><?php echo $i; ?></span></a>
        <?php elseif(mb_substr($current_url, -1)  === '&'): //&pagenation=からpagenation=を消しているので、&pagenation=あるとき末尾が&になる。 ?>
          <a class="pagenation__number<?php echo $add_active; ?>" href="<?php echo $current_url . 'pagenation=' . $i; ?>"><span><?php echo $i; ?></span></a>
        <?php else: ?>
          <a class="pagenation__number<?php echo $add_active; ?>" href="<?php echo $current_url . '&pagenation=' . $i; ?>"><span><?php echo $i; ?></span></a>
        <?php endif; ?>
      <?php else: //ページネーションが10個以下のとき ?>
        <?php if(strpos($current_url,'?') === false): //?ない場合 ?>
          <a class="pagenation__number<?php echo $add_active; ?>" href="<?php echo $current_url . '?pagenation=' . $i; ?>"><span><?php echo $i; ?></span></a>
        <?php elseif(mb_substr($current_url, -1)  === '&'): //&pagenation=からpagenation=を消しているので、&pagenation=あるとき末尾が&になる。 ?>
          <a class="pagenation__number<?php echo $add_active; ?>" href="<?php echo $current_url . 'pagenation=' . $i; ?>"><span><?php echo $i; ?></span></a>
        <?php else: ?>
          <a class="pagenation__number<?php echo $add_active; ?>" href="<?php echo $current_url . '&pagenation=' . $i; ?>"><span><?php echo $i; ?></span></a>
        <?php endif; ?>
      <?php endif; ?>
  <?php
    endfor;
  ?>
  </section>
