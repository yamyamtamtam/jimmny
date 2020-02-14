<?php
/*
Template Name: 日付別ページ
*/
?>
<?php get_header(); ?>
<main class="content">
  <?php
    $current_year = get_query_var('year');
    $current_month = get_query_var('monthnum');
    $current_day = get_query_var('day');
    $items = get_posts(array(
      'numberposts' => -1,
      'post_type' => 'post',
      'post_status' => 'publish',
      'orderby' => 'data',
      'fields'=> 'ids',
      'date_query' => array(
        'year' => $current_year,
        'month' => $current_month,
        'day' => $current_day
      )
    ));
    if(!empty($items)):
      require 'template-parts/pagenation-setup.php';
  ?>
  <nav class="breadcrumb">
    <a class="breadcrumb__link" href="<?php echo esc_url(home_url( '/' )); ?>">TOP</a>
    <a class="breadcrumb__current">
      <?php
        if($current_year !== 0){
          echo $current_year . '年';
        }
        if($current_month !== 0){
          echo $current_month . '月';
        }
        if($current_day !== 0){
          echo $current_day . '日';
        }
      ?>
      の記事一覧
    </a>
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
