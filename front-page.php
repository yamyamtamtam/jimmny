<?php
/*
Template Name: TOPページ
*/
?>
<?php get_header(); ?>
<main class="content">
  <?php
    $items = get_posts('numberposts=-1&post_type=post&post_status=publish&orderby=data&fields=ids');
    if(!empty($items)):
      require 'template-parts/pagenation-setup.php';
  ?>
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
