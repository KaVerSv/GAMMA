// Nasłuchiwanie kliknięcia na elementy o klasie "likeButton"
document.addEventListener('DOMContentLoaded', function() {
    var likePostButtons = document.querySelectorAll('.likePost');

    likePostButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var postID = this.getAttribute('data-post-id');
            polubPost(postID);
        });
    });

    function polubPost(postID) {
        $.ajax({
            type: 'POST',
            url: 'likePost', // Ustaw ścieżkę do pliku obsługującego polubienie
            data: { postID: postID },
            success: function(response) {
                console.log('Post polubiony: ' + response);
            },
            error: function(error) {
                console.error('Błąd podczas polubienia: ' + error);
            }
        });
    }
});


// Nasłuchiwanie kliknięcia na elementy o klasie "likeComment"
document.addEventListener('DOMContentLoaded', function() {
    var likeCommentButtons = document.querySelectorAll('.likeComment');

    likeCommentButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var commentID = this.getAttribute('data-comment-id');
            polubComment(commentID);
        });
    });

    function polubComment(commentID) {
    $.ajax({
        type: 'POST',
        url: 'likeComment',
        data: { commentID: commentID },
        success: function(response) {
            console.log('Komentarz polubiony: ' + response);
        },
        error: function(error) {
            console.error('Błąd podczas polubienia: ' + error);
        }
    });
    }
});
