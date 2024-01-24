// Nasłuchiwanie kliknięcia na elementy o klasie "likeButton"
$('.likePost').click(function() {
    var postID = $(this).data('post-id');
    polubPost(postID);
});

function polubPost(postID) {
    // Wywołaj AJAX, aby przesłać ID posta do serwera
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



// Nasłuchiwanie kliknięcia na elementy o klasie "likeButton"
$('.likeComment').click(function() {
    var commentID = $(this).data('comment-id');
    polubComment(commentID);
});

function polubComment(commentID) {
    // Wywołaj AJAX, aby przesłać ID posta do serwera
    $.ajax({
        type: 'POST',
        url: 'likeComment', // Ustaw ścieżkę do pliku obsługującego polubienie
        data: { commentID: commentID },
        success: function(response) {
            console.log('Comment polubiony: ' + response);
        },
        error: function(error) {
            console.error('Błąd podczas polubienia: ' + error);
        }
    });
}