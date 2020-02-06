<?php
/*
Template Name: TOPページ
*/
?>
<?php get_header(); ?>
<main class="content">
  <?php
    $search_word = htmlspecialchars($_GET["word"], ENT_QUOTES, 'UTF-8');
    $items = get_posts('numberposts=-1&post_type=post&post_status=publish&orderby=data&fields=ids');
    $number_in_page = 6;
    $number_in_page_logic = $number_in_page - 1;
    $page_count = $number_in_page_logic;
    $count = 0;
    if(!empty($items)):
      if($_GET['pagenation']){
        $page_count = $_GET['pagenation'] * $number_in_page - 1;
        $count = $page_count - $number_in_page_logic;
      }
    //wordによってitemsの配列を変更する
    //同棲の時は親カテゴリまでさかのぼって「同棲」の語がカテゴリにある投稿だけ残す
    //「同棲」の語がカテゴリにあって「毒親・毒兄弟」の語「自律神経失調症・不安症・発達障害」の語がカテゴリにない投稿だけ残す
    if($search_word !== '' && $search_word === 'dousei'):
      foreach($items as $key=>$item){
        $current_cat_list = '';
        $current_cats = get_the_category($item);
        foreach($current_cats as $current_cat){
          $current_cat_word = get_category_parents($current_cat->term_id);
          $current_cat_list = $current_cat_list . $current_cat_word;
          if(strpos($current_cat_list,'同棲') === false){
            unset($items[$key]);
          }
          if(
            strpos($current_cat_list,'毒親・毒兄弟') !== false ||
            strpos($current_cat_list,'自律神経失調症・不安症・発達障害') !== false
          ){
            unset($items[$key]);
          }
        }
      }
      $items = array_values($items);
  ?>
    <nav class="breadcrumb">
      <a class="breadcrumb__link" href="<?php echo esc_url(home_url( '/' )); ?>">TOP</a>
      <a class="breadcrumb__current">同棲 の記事一覧</a>
    </nav>
  <?php endif; ?>
  <?php
    //その他の時は親カテゴリまでさかのぼって「同棲」の語がカテゴリになくて「毒親・毒兄弟」の語がカテゴリになくて「自律神経失調症・不安症・発達障害」の語がカテゴリにない投稿だけ残す
    if($search_word !== '' && $search_word === 'other'):
      foreach($items as $key=>$item){
        $current_cat_list = '';
        $current_cats = get_the_category($item);
        foreach($current_cats as $current_cat){
          $current_cat_word = get_category_parents($current_cat->term_id);
          $current_cat_list = $current_cat_list . $current_cat_word;
          if(
            strpos($current_cat_list,'同棲') !== false ||
            strpos($current_cat_list,'毒親・毒兄弟') !== false ||
            strpos($current_cat_list,'自律神経失調症・不安症・発達障害') !== false
          ){
            unset($items[$key]);
          }
        }
      }
      $items = array_values($items);
  ?>
  <nav class="breadcrumb">
    <a class="breadcrumb__link" href="<?php echo esc_url(home_url( '/' )); ?>">TOP</a>
    <a class="breadcrumb__current">その他 の記事一覧</a>
  </nav>
  <?php endif; ?>
  <section class="postlist">
    <?php for($i = $count; $i <= $page_count; $i++): ?>
      <?php if($items[$i]): ?>
    <article class="postcard js-postcard">
      <a href="<?php echo get_permalink($items[$i]); ?>">
        <h2 class="postcard__title"><?php echo get_the_title($items[$i]); ?><!--<span class="postcard__guide">をよむ</span>--></h2>
        <p class="postcard__date"><?php echo get_the_date('Y年m月d日', $items[$i]); ?></p>
        <div class="postcard__thumb">
          <div class="postcard__curtain"></div>
          <div class="postcard__curtain postcard__curtain--reverse"></div>
          <?php if(get_the_post_thumbnail($items[$i])): ?>
          <img src="<?php echo get_the_post_thumbnail_url( $items[$i], 'medium' ); ?>" alt="">
          <?php else: ?>
          <div class="postcard__thumb--dummy postcard__thumb--<?php echo idToCategoryConvert($items[$i]); ?>"></div>
          <?php endif; ?>
        </div>
        <p class="postcard__content">
          <?php
            if(has_excerpt()){
              echo get_the_excerpt($items[$i]);
            }else{
              echo mb_substr(strip_tags(get_post_field('post_content',$items[$i])), 0, 150 ) . '<span class="text-grey-small">...続きをよむ</span>';
            }
          ?>
        </p>
      </a>
      <ul class="postcard__cat">
      <?php
        $post_cats = get_the_category($items[$i]);
        foreach($post_cats as $post_cat):
      ?>
        <li><a class="cat-<?php echo categoryConvert($post_cat->name); ?>" href="<?php echo get_category_link($post_cat->term_id); ?>"><?php echo $post_cat->name; ?></a></li>
      <?php endforeach; ?>
      </ul>
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
    <p class="nocontent">条件に合致する記事はないよ。上のメニューから探してね。</p>
  <?php endif; ?>
  </section>

</main>
<?php get_footer();
