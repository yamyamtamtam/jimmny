<?php
/*
Template Name: カテゴリページ
*/
?>
<?php get_header(); ?>
<main>
  <?php
    $items = get_posts('numberposts=-1&post_type=post&post_status=publish&orderby=data&fields=ids&category=' . $cat);
    $number_in_page = 6;
    $page_count = $number_in_page;
    $count = 0;
    if(!empty($items)):
      if($_GET['pagenation']){
        $page_count = $_GET['pagenation'] * $number_in_page - 1;
        $count = $page_count - ($number_in_page - 1);
      }
  ?>
  <section class="postlist">
    <?php for($i = $count; $i <= $page_count; $i++): ?>
      <?php if($items[$i]): ?>
    <article class="postcard">
      <a href="<?php echo get_permalink($items[$i]); ?>">
        <h2 class="postcard__title"><?php echo get_the_title($items[$i]); ?><span class="postcard__guide">をよむ</span></h2>
        <p class="postcard__date"><?php echo get_the_date('Y年m月d日', $items[$i]); ?></p>
        <div class="postcard__thumb">
          <?php if(get_the_post_thumbnail($items[$i])): ?>
          <img src="<?php echo get_the_post_thumbnail( $items[$i], 'medium' ); ?>" alt="">
          <?php else: ?>
          <div class="postcard__thumb--dummy"></div>
          <?php endif; ?>
        </div>
        <p class="postcard__content"><?php echo get_the_excerpt($items[$i]); ?></p>
        <ul class="postcard_catlist">
        <?php
          $post_cats = get_the_category($items[$i]);
          foreach($post_cats as $post_cat):
        ?>
          <li><a href="<?php echo esc_url(home_url( '/' )); ?>category/<?php echo $post_cat->name; ?>"><?php echo $post_cat->name; ?></a></li>
        <?php endforeach; ?>
        </ul>
      </a>
    </article>
      <?php endif; ?>
    <?php endfor; ?>
  </section>
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
  else:
  ?>
    <p>条件に合致する記事はありません。</p>
  <?php endif; ?>
  </section>

</main>
<?php get_footer();
