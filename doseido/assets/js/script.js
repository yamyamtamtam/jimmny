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
  ////////////////////////////////
  /*スクロールでなにかする系の動作*/
  ///////////////////////////////
  var prevScroll;
  var currentScroll;
  var commonScrollPosition;
  var lineContent;
  var lineContentPosition;
  var postcardContent;
  var postcardContentPosition;
  var postcardItems = [];
  //読み込み時に記事リストを動かす
  apeearPostcard();
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
    apeearPostcard();
  });
  //記事リストを出す関数
  function apeearPostcard(){
    commonScrollPositionBottom = $(document).scrollTop() + window.innerHeight;
    if($('.js-postcard')){
      postcardContent = $('.js-postcard');
      postcardItems = [];
      for( var i=0; i<postcardContent.length; i++) {
        postcardContentPosition = postcardContent[i].offsetTop;
        if(commonScrollPositionBottom >= postcardContentPosition){
          if(!postcardContent[i].classList.contains('postcard--active')){
            postcardItems.push(i);
          }
        }
      }
      var n = 0;
      var start = setInterval(function(){
        if(typeof postcardItems[n] === "undefined"){
          clearInterval(start);
        }else{
          postcardContent[postcardItems[n]].classList.add('postcard--active');
          n++;
        }
      },400);
    }
  }
  ////////////////////////////////
  /////***テキスト操作系***///////
  ///////////////////////////////
  /*h4にh3のテキストを追記する*/
  var h3elements = $('.single-content__main h3');
  var h4elements = $('.single-content__main h4');
  var h3offsetTop;
  var h4offsetTop;
  if(h3elements){
    for( var i=0; i<h3elements.length; i++) {
      h3offsetTop = h3elements[i].offsetTop;
      for( var n=0; n<h4elements.length; n++) {
        h4offsetTop = h4elements[n].offsetTop;
        if(h4offsetTop > h3offsetTop){
          $('.single-content__main h4:eq(' + n + ') .h3-clone-headline').remove();
          $('.single-content__main h4:eq(' + n + ')').prepend('<span class="h3-clone-headline">～' + h3elements[i].textContent + '～</span>');
        }
      }
    }
  }

  
})
