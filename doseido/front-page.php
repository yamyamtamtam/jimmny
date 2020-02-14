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
    if(!empty($items)):
      require 'template-parts/pagenation-setup.php';
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
  <?php
    for($i = $count; $i <= $page_count; $i++){
      if($items[$i]){
        require 'template-parts/postcard.php';
      }
    }
  ?>
  </section>
  <?php
    require 'template-parts/pagenation-print.php';
    else:
  ?>
  <section class="postlist">
    <p class="nocontent">条件に合致する記事はないよ。上のメニューから探してね。</p>
  </section>
  <?php endif; ?>
</main>
<?php get_footer();
