<?php
/*
Template Name: 検索結果ページ
*/
?>
<?php get_header(); ?>
<main class="content">
  <?php
    $search_query = get_search_query();
    $items = get_posts('numberposts=-1&post_type=post&post_status=publish&orderby=data&fields=ids&s=' . $search_query);
    if(!empty($items)):
      require 'template-parts/pagenation-setup.php';
      $category = get_category($cat);
      $parents = get_ancestors($cat,'category');
      $parents = array_reverse($parents);
  ?>
  <nav class="breadcrumb">
    <a class="breadcrumb__link" href="<?php echo esc_url(home_url( '/' )); ?>">TOP</a>
    <?php
      if($parents):
        foreach($parents as $parent):
          $current_category = get_category($parent);
    ?>
    <a class="breadcrumb__link" href="<?php echo esc_url(home_url( '/' )) . 'category/' . $current_category->slug; ?>"><?php echo $current_category->name; ?></a>
    <?php
        endforeach;
      endif;
    ?>
    <a class="breadcrumb__current"><?php echo $search_query; ?> の検索結果</a>
  </nav>
  <section class="postlist">
    <?php for($i = $count; $i <= $page_count; $i++){
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
    <p class="nocontent">検索条件に合致する記事はないよ。<br>検索ワードを変えるか上のメニューから探してね。</p>
  </section>
  <?php endif; ?>
</main>
<?php get_footer();
