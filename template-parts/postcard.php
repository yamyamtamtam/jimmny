    <article class="postcard js-postcard">
      <a href="<?php echo get_permalink($items[$i]); ?>">
        <div class="postcard__thumb <?php if(get_the_post_thumbnail($items[$i])): ?>postcard__thumb--exist<?php endif; ?>">
          <?php if(get_the_post_thumbnail($items[$i])): ?>
          <img src="<?php echo get_the_post_thumbnail_url( $items[$i], 'medium' ); ?>" alt="">
          <?php else: ?>
          <img class="postcard__thumb__dummy" src="<?php echo get_template_directory_uri(); ?>/assets/images/jimny-dummy.jpg" alt="">
          <?php endif; ?>
        </div>
        <h2 class="postcard__title"><?php echo get_the_title($items[$i]); ?></h2>
        <p class="postcard__date"><?php echo get_the_date('Y年m月d日', $items[$i]); ?></p>
        <p class="postcard__content">
          <?php
            if(has_excerpt()){
              echo get_the_excerpt($items[$i]);
            }else{
              echo mb_substr(strip_tags(get_post_field('post_content',$items[$i])), 0, 50 ) . '<span class="text-grey-small">...続きをよむ</span>';
            }
          ?>
        </p>
        <ul class="postcard__tag">
          <?php
            $post_tag_list = get_the_tags($items[$i]);
            if(!empty($post_tag_list)):
              foreach($post_tag_list as $post_tag):
          ?>
          <li><?php echo $post_tag->name; ?></li>
          <?php
              endforeach;
            endif;
          ?>
        </ul>
      </a>
    </article>
