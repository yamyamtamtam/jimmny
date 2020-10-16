<?php
/*
Template Name: 固定ページ
*/
?>
<?php get_header(); ?>
<main>
  <section id="breadcrumb-wrap" class="inner">
    <?php get_template_part('template-parts/breadcrumb','page'); ?>
  </section>
  <article id="page-content">
    <h2 class="headline-dotborder mb30">
    <?php
      $page_headline = get_post_meta($post->ID,'page_headline',true);
      if($page_headline !== ""):
        $page_headline_image = wp_get_attachment_url($page_headline);
    ?>
    <img src="<?php echo $page_headline_image; ?>" alt="">
    <?php endif; ?>
    <span><?php echo get_the_title($post->ID); ?></span></h2>
    <div class="inner">
      <?php
        if(have_posts()){
          while (have_posts()){
            the_post();
            the_content();
            if(!get_the_content()){
              echo '<div class="inner pb40 textC font18"><p>工事中です</p></div>';
            }
          }
        }
      ?>
    </div>
  </article>
</main>
<?php get_footer();
