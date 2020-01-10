<?php
///////////////////////
//******  共通 ******//
///////////////////////
//***  jQuery制御 ***//
function loadGoogleCdn() {
  if ( !is_admin() ){
    //jQueryを登録解除
    wp_deregister_script( 'jquery' );
    //Google CDNのjQueryを出力
    wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js', array(), NULL, false );
  }
}
add_action( 'init', 'loadGoogleCdn' );


///////////////////////
//****  管理画面 ****//
///////////////////////
add_theme_support( 'post-thumbnails' );

///////////////////////
//***  表示の制御 ***//
///////////////////////
//抜粋の制御
function twpp_change_excerpt_length( $length ) {
  return 150;
}
add_filter( 'excerpt_length', 'twpp_change_excerpt_length', 999 );
function twpp_change_excerpt_more( $more ) {
  return '...[続きを読む]';
}
add_filter( 'excerpt_more', 'twpp_change_excerpt_more' );

///////////////////////
//***  処理の制御 ***//
///////////////////////
//ajaxurlを出力
function add_my_ajaxurl(){
  echo '
  <script>
      var ajaxurl = "' . admin_url( 'admin-ajax.php') . '";
  </script>
  ';
}
add_action( 'wp_head', 'add_my_ajaxurl', 1 );
//レコメンドを呼び出すajaxを追加
function recommendCall(){
  $post_id = $_POST['id'];
  $post_title = get_the_title($post_id);
  echo $post_title;
//  echo json_encode( $returnObj );
  die();
}
add_action( 'wp_ajax_recommendCall', 'recommendCall' );
add_action( 'wp_ajax_nopriv_recommendCall', 'recommendCall' );

?>
