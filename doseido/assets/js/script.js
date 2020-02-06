jQuery(function($){
////////////////////
//****  共通  ****//
////////////////////
//TOPへ戻る
  var topBtn = $('.js-page-top');
  topBtn.hide();
  //スルスルっとスクロールでトップへもどる
  topBtn.click(function () {
    $('body,html').animate({
      scrollTop: 0
    }, 500);
    return false;
  });
  $(".js-humbergerButton").click(function(){
    $(".humberger-nav").addClass("humberger-nav--active");
  });
  $(".js-humbergerClose").click(function(){
    $(".humberger-nav").removeClass("humberger-nav--active");
  });
  /*スクロールでなにかする系の動作*/
  var prevScroll;
  var currentScroll;
  var commonScrollPosition;
  var lineContent;
  var lineContentPosition;
  var postcardContent;
  var postcardContentPosition;
  var postcardItem;
  $(".js-SpNextPrev").addClass("sp-nextprev-wrap--active");
  $(window).scroll(function(){
    //TOPへ戻るボタン
    if ($(this).scrollTop() > 300) {
      topBtn.fadeIn();
    } else {
      topBtn.fadeOut();
    }
    //SP版の次へ前へボタン
    prevScroll = $(this).scrollTop();
    if(prevScroll < currentScroll){
      $(".js-SpNextPrev").addClass("sp-nextprev-wrap--active");
    }else{
      $(".js-SpNextPrev").removeClass("sp-nextprev-wrap--active");
    }
    currentScroll = prevScroll;
    //LINE風
    commonScrollPosition = $(document).scrollTop() + window.innerHeight - 120;
    if($('.js-line')){
      lineContent = $('.js-line');
      for( var i=0; i<lineContent.length; i++) {
        lineContentPosition = lineContent[i].offsetTop;
        if(commonScrollPosition > lineContentPosition){
          lineContent[i].classList.add('line--active');
        }
      }
    }
    //記事リストを動かす
    if($('.js-postcard')){
      postcardContent = $('.js-postcard');
      for( var i=0; i<postcardContent.length; i++) {
        postcardItem = postcardContent[i];
        postcardContentPosition = postcardItem.offsetTop;
        if(commonScrollPosition > postcardContentPosition){
          postcardItem.classList.add('postcard--active');
        }
      }
    }

  });
})
