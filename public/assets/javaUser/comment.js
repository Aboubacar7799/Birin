// La methode permet de faire un commentaire
$(document).ready(function () {
    $('.comment-form').on('submit', function (e) {
        e.preventDefault();

        let form = $(this);
        let postId = form.data('post-id');
        let content = form.find('input[name="content"]').val();
        let token = form.find('input[name="_token"]').val();

        $.ajax({
            url: "/posts/" + postId + "/comments", // Adapte ta route ici
            method: "POST",
            data: {
                content: content,
                _token: token
            },
            success: function (response) {
                // On ajoute le commentaire dynamiquement à la liste
                $('#comments-lists-' + postId).append(
                    '<div><strong>' + response.username + '</strong> : ' + response.content + '</div>'
                );
                // On vide le champ
                form.find('input[name="content"]').val('');
            },
            error: function () {
                alert("Erreur lors de l'envoi du commentaire");
            }
        });
    });
});




