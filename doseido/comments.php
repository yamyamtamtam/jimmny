<section class="comment">
  <?php if(have_comments()):
    $comment_args = array(
      'post_id' => $post->ID,
      'status' => 'approve'
    );
    $comments = get_comments($comment_args);
    $current_url = (empty($_SERVER['HTTPS']) ? 'http://' : 'https://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    $static_url = explode('?', $current_url);
  ?>
  <p class="comment-count">▼コメント（<?php echo get_comments_number(); ?>）</p>
    <?php foreach($comments as $comment): ?>
    <article class="comment-card" id="comment-<?php echo $comment->comment_ID; ?>">
      <p class="comment-card__date"><?php echo get_comment_date( 'Y.n.d D g:i', $comment->comment_ID ); ?></p>
      <?php
        $comment_parent = $comment->comment_parent;
        if($comment_parent != 0):
      ?>
      <a href="#comment-<?php echo $comment_parent; ?>" class="comment-card__anker">&gt;&gt; <?php echo get_comment_author($comment_parent); ?></a>
      <?php endif; ?>
      <p class="comment-card__text"><?php echo $comment->comment_content; ?></p>
      <p class="comment-card__author">[<span><?php echo $comment->comment_author; ?></span>]</p>
      <a rel='nofollow' class='mt10 btn-gray' href='<?php echo $static_url[0]; ?>?replytocom=<?php echo $comment->comment_ID; ?>#respond' onclick='return addComment.moveForm( "div-comment-<?php $comment->comment_ID; ?>", "<?php $comment->comment_ID; ?>", "respond", "<?php echo $post->ID; ?>" )' aria-label='<?php echo $comment->comment_author; ?> に返信する'>返信する</a>
    </article>
    <?php endforeach; ?>
  <?php endif; ?>
  <div class="comment-form" id="respond">
    <?php
      	$replay_to = htmlspecialchars($_GET["replytocom"]);
        if($replay_to == ''){
          $replay_to = 0;
        }
    ?>
    <p class="comment-reply-title" <?php if($replay_to == 0){ echo 'style="display:none;"'; } ?>>
      <a href="#comment-<?php echo $replay_to; ?>"><?php echo get_comment_author($replay_to); ?></a>にコメントする
      <a rel="nofollow" href="<?php echo $static_url[0]; ?>/#respond">コメントをキャンセル</a>
    </p>
    <form action="<?php echo esc_url(home_url( '/' )); ?>wp-comments-post.php" method="post">
      <div class="comment-form-item">
        <label for="author" class="comment-form__label">お名前（必須）</label>
        <p class="comment-form__input"><input name="author" type="text" value="" /></p>
      </div>
      <div class="comment-form-item">
        <label for="email" class="comment-form__label">メールアドレス（必須）</label>
        <p class="comment-form__input"><input name="email" type="text" value="" /></p>
        <p class="comment-form__cap">※投稿時には表示されません。</p>
      </div>
      <div class="comment-form-item comment-form-item--top">
        <label class="comment-form__label">コメント内容（必須）</label>
        <p class="comment-form__textarea"><textarea name="comment" aria-required="true"/></textarea></p>
        <input name="submit" type="submit" class="comment-form__submit btn-red btn-red--small" value="&gt;&gt; 投稿" />
      </div>
      <p class="comment-form__submit">
        <input type='hidden' name='comment_post_ID' value='<?php echo $post->ID; ?>' />
        <input type='hidden' name='comment_parent' value='<?php echo $replay_to; ?>' />
      </p>
    </form>
  </div>
</section>
