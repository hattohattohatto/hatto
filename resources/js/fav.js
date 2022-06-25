jQuery(document).ready(function () {
    let fav = $('.fav-toggle');
    let favReviewId;
    fav.on('click', function () {
        let $this = $(this);
        favReviewId = $this.data('review-id');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
            },
            url: '/favorites',
            method: 'POST',
            data: {
                'review_id': favReviewId
            },
        })
        .done(function (data) {
            $('.favIcon'+favReviewId).toggleClass('far');
            $('.favIcon'+favReviewId).toggleClass('fas');
            $('.favColor'+favReviewId).toggleClass('text-primary'); 
            $('.favColor'+favReviewId).toggleClass('text-danger'); 
            document.getElementById('favCounted'+favReviewId).innerHTML = data['favoriteCount'];
        })
        .fail(function () {
            console.log('fail'); 
        });
    });
});
