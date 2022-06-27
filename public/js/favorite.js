/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!**********************************!*\
  !*** ./resources/js/favorite.js ***!
  \**********************************/
jQuery(document).ready(function () {
  var fav = $('.fav-toggle');
  var favReviewId;
  fav.on('click', function () {
    var $this = $(this);
    favReviewId = $this.data('review-id');
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/favorites',
      method: 'POST',
      data: {
        'tweet_id': favReviewId
      }
    }).done(function (data) {
      $('.favIcon' + favReviewId).toggleClass('far');
      $('.favIcon' + favReviewId).toggleClass('fas');
      $('.favColor' + favReviewId).toggleClass('text-primary');
      $('.favColor' + favReviewId).toggleClass('text-danger');
      document.getElementById('favCounted' + favReviewId).innerHTML = data['favoriteCount'];
    }).fail(function () {
      console.log('fail');
    });
  });
});
/******/ })()
;