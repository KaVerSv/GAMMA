document.addEventListener('DOMContentLoaded', function () {
    var addPostButton = document.querySelector('.add-post');
    var addPostForm = document.getElementById('add_post');

    var isFormVisible = false;

    addPostButton.addEventListener('click', function () {
        if (isFormVisible) {
            addPostForm.style.display = 'none';
        } else {
            addPostForm.style.display = 'block';
        }
        
        isFormVisible = !isFormVisible;
    });
});

