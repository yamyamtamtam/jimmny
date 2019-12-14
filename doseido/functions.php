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
///////////////////////
//***  表示の制御 ***//
///////////////////////

///////////////////////
//***  処理の制御 ***//
///////////////////////

?>
