// Nasłuchiwanie kliknięcia na elementy o klasie "likeButton"
$('.reportPost').click(function() {
    var postID = $(this).data('post-id');
    reportPost(postID);
});

function reportPost(postID) {
    // Wywołaj AJAX, aby przesłać ID posta do serwera
    $.ajax({
        type: 'POST',
        url: 'reportPost', // Ustaw ścieżkę do pliku obsługującego polubienie
        data: { postID: postID },
        success: function(response) {
            console.log('Post reported: ' + response);
        },
        error: function(error) {
            console.error('Błąd podczas reportu: ' + error);
        }
    });
}



// Nasłuchiwanie kliknięcia na elementy o klasie "likeButton"
$('.reportComment').click(function() {
    var commentID = $(this).data('comment-id');
    reportComment(commentID);
});

function reportComment(commentID) {
    // Wywołaj AJAX, aby przesłać ID posta do serwera
    $.ajax({
        type: 'POST',
        url: 'reportComment', // Ustaw ścieżkę do pliku obsługującego polubienie
        data: { commentID: commentID },
        success: function(response) {
            console.log('Comment reported: ' + response);
        },
        error: function(error) {
            console.error('Błąd podczas reportu: ' + error);
        }
    });
}