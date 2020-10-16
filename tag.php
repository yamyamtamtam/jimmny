<?php
/*
Template Name: タグ一覧ページ
*/
?>
<?php get_header(); ?>
<main class="content">
  <?php
    $tag_obj = get_tags(array('slug' => $tag))[0];
    $items = get_posts('numberposts=-1&post_type=post&post_status=publish&orderby=data&fields=ids&tag=' . $tag);
    if(!empty($items)):
      require 'template-parts/pagenation-setup.php';
  ?>
  <nav class="breadcrumb">
    <a class="breadcrumb__link" href="<?php echo esc_url(home_url( '/' )); ?>">TOP</a>
    <a class="breadcrumb__current"><?php echo $tag_obj->name; ?> の記事一覧</a>
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
    <p class="nocontent">条件に合致する記事はないよ。上のメニューから探してね。</p>
  </section>
  <?php endif; ?>
</main>
<?php get_footer();
