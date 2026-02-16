
let postIdToDelete = null;

// Ouvrir modal
document.querySelectorAll('.delete-post-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        postIdToDelete = this.dataset.id;
        let modal = new bootstrap.Modal(document.getElementById('deletePostModal'));
        modal.show();
    });
});

// Confirmer suppression
document.getElementById('confirmDeletePost').addEventListener('click', function() {

    fetch(`/posts/${postIdToDelete}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type':'application/json'
        }
    })
    .then(response => response.ok ? response.json() : Promise.reject())
    .then(data => {

        // Animation fade out
        let postElement = document.getElementById(`post-${postIdToDelete}`);
        postElement.style.transition = "opacity 0.5s";
        postElement.style.opacity = "0";

        setTimeout(() => {
            postElement.remove();
        }, 500);

        bootstrap.Modal.getInstance(document.getElementById('deletePostModal')).hide();

        showToast(data.message, "success");
    })
    .catch(() => showToast("Erreur lors de la suppression", "danger"));
});