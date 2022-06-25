jQuery(document).ready(function () {
    let follow = $('.follow-toggle');
    let followReviewId;
    follow.on('click', function () {
        let $this = $(this);
        followReviewId = $this.data('follow-review-id');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url: '/follow',
            method: 'POST',
            data: {
                'follow_review_id': followReviewId
            },
        })
        .done(function (data) {
            document.getElementById('follower-Count').innerHTML = data['followerCount']
        })
        .fail(function () {
            console.log('fail'); 
        });
    });
});
