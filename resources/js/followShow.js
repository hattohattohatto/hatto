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
            let object = document.getElementById('followBtn'+followReviewId);

            if (object.textContent == "フォロー解除"){
                object.textContent = "フォローする";
            }else{
                object.textContent = "フォロー解除"; 
            }

            $('.follow'+followReviewId).toggleClass('btn-primary');
            $('.follow'+followReviewId).toggleClass('btn-danger');

            document.getElementById('follower-count').innerHTML = data['followerCount']
        })
        .fail(function () {
            console.log('fail'); 
        });
    });
});
