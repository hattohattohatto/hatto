/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***************************************!*\
  !*** ./resources/js/followerCount.js ***!
  \***************************************/
jQuery(document).ready(function () {
  var follow = $('.follow-toggle');
  var followReviewId;
  follow.on('click', function () {
    var $this = $(this);
    followReviewId = $this.data('follow-review-id');
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      url: '/follow',
      method: 'POST',
      data: {
        'follow_review_id': followReviewId
      }
    }).done(function (data) {
      document.getElementById('follower-Count').innerHTML = data['followerCount'];
    }).fail(function () {
      console.log('fail');
    });
  });
});
/******/ })()
;