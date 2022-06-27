/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!************************************!*\
  !*** ./resources/js/followShow.js ***!
  \************************************/
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
      var object = document.getElementById('followBtn' + followReviewId);

      if (object.textContent == "フォロー解除") {
        object.textContent = "フォローする";
      } else {
        object.textContent = "フォロー解除";
      }

      $('.follow' + followReviewId).toggleClass('btn-primary');
      $('.follow' + followReviewId).toggleClass('btn-danger');
      document.getElementById('follower-count').innerHTML = data['followerCount'];
    }).fail(function () {
      console.log('fail');
    });
  });
});
/******/ })()
;