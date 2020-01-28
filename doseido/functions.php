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
//サムネイル有効化
add_theme_support( 'post-thumbnails' );

//ビジュアルエディタにボタンを追加
add_filter( 'mce_external_plugins', 'add_original_tinymce_button_plugin' );
function add_original_tinymce_button_plugin( $plugin_array ) {
  $plugin_array[ 'original_tinymce_button_plugin' ] = get_template_directory_uri() . '/admin/editor-button.js';
  return $plugin_array;
}

add_filter( 'mce_buttons_2', 'add_original_tinymce_button' );
function add_original_tinymce_button( $buttons ) {
  $buttons = array('lineLeft','lineRight');
  return $buttons;
}
add_editor_style( 'admin/editor-style.css' );

///////////////////////
//***  表示の制御 ***//
///////////////////////
//抜粋の制御
function twpp_change_excerpt_length( $length ) {
  return 150;
}
add_filter( 'excerpt_length', 'twpp_change_excerpt_length', 999 );
function twpp_change_excerpt_more( $more ) {
  return '<span class="text-grey-small">...続きをよむ</span>';
}
add_filter( 'excerpt_more', 'twpp_change_excerpt_more' );

///////////////////////
//***  処理の制御 ***//
///////////////////////
//titleタグの出力
add_theme_support( 'title-tag' );

//カテゴリ名を入れるとclass名を出力する関数
function categoryConvert($name){
  $classname = 'other';
  if(strpos($name,'同棲') !== false){
    $classname = 'dousei';
  }elseif($name == '毒親・毒兄弟'){
    $classname = 'dokuoya';
  }elseif($name == '自律神経失調症・不安症・発達障害'){
    $classname = 'shougai';
  }elseif(strpos($name,'ジムニー') !== false){
    $classname = 'jimny';
  }elseif($name == '誰かの役に立つかも？な雑学'){
    $classname = 'zatsugaku';
  }
  return $classname;
}
//post_id名を入れると属するカテゴリの一覧からclass名を出力する関数（優先順位あり）
function idToCategoryConvert($id){
  $post_cats = get_the_category($id);
  $cat_names = array();
  $classname = 'dousei';
  foreach($post_cats as $post_cat){
    $cat_names[] = $post_cat->name;
  }
  if(in_array('毒親・毒兄弟',$cat_names,true)){
    $classname = 'dokuoya';
  }elseif(in_array('自律神経失調症・不安症・発達障害',$cat_names,true)){
    $classname = 'shougai';
  }elseif(in_array('ｊａ１１ジムニー',$cat_names,true)){
    $classname = 'jimny';
  }elseif(in_array('誰かの役に立つかも？な雑学',$cat_names,true)){
    $classname = 'zatsugaku';
  }
  return $classname;
}


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
//post_idをもらい、整形したhtmlを返す
function recommendCall(){
  $post_id = $_POST['id'];
  $html = '';
  $title = get_the_title($post_id);
  $title_split = array_slice(preg_split("//u", $title), 1, -1);
  $ids = get_posts(array(
    'numberposts' => -1,
    'post_type' => 'post',
    'post_status' => 'publish',
    'fields' => 'ids'
  ));
  $recommends = array();
  foreach ($ids as $id) {
    $other_title = get_the_title($id);
    $other_title_split = array_slice(preg_split("//u", $other_title), 1, -1);
    $equal_count = array_intersect($title_split,$other_title_split);
    $recommends[$id] = count($equal_count);
  }
  arsort($recommends);
  $i = 0;
  //$recommends[投稿id] = 一致数
  //一致数スコア1位(0)はこの投稿自身なので除外。一致数2位(1)～4位(3)までをhtml要素にして返す
  foreach($recommends as $key => $value ){
    if($i === 1 && $value === 0){
      $html = '<p class="no-recommend">似た記事はありませんでした。</p>';
      break;
    }
    if($i > 0 && $value !== 0){
      $html = $html . '<a class="recommend" href="' . get_permalink($key) . '">';
      $html = $html . '<div class="recommend__thumb">';
      if(get_the_post_thumbnail($key)){
        $html = $html . '<img src="' . get_the_post_thumbnail_url($key, 'medium') . '" alt="">';
      }else{
        $html = $html . '<div class="recommend__thumb--dummy postcard__thumb--' . idToCategoryConvert($key) . '"></div>';
      }
      $html = $html . '</div>';
      $html = $html . '<h5 class="recommend__title">' . get_the_title($key) . '</h5>';
      $html = $html . '<div class="recommend__date">' . get_the_date('Y.m.d',$key) . '</div>';
      $html = $html . '</a>';
    }
    if($i >= 3){
      break;
    }
    $i++;
  }
  echo $html;
  die();
}
add_action( 'wp_ajax_recommendCall', 'recommendCall' );
add_action( 'wp_ajax_nopriv_recommendCall', 'recommendCall' );

?>
