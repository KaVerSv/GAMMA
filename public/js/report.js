// Nasłuchiwanie kliknięcia na elementy o klasie "likeButton"
document.addEventListener('DOMContentLoaded', function() {
    var reportPostButtons = document.querySelectorAll('.reportPost');

    reportPostButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var postID = this.getAttribute('data-post-id');
            reportPost(postID);
            alert(11);
        });
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
});


document.addEventListener('DOMContentLoaded', function() {
    var reportCommentButtons = document.querySelectorAll('.reportComment');

    reportCommentButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var commentID = this.getAttribute('data-comment-id');
            reportComment(commentID);
            alert(22);
        });
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
});