{{-- Notre model de suppression --}}
<div class="modal fade" id="deletePostModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supprimer le post ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                Cette action supprimera définitivement le post,
                tous les commentaires et tous les likes.
            </div>

            <div class="modal-footer">
                <button type="button"
                        id="confirmDeletePost"
                        class="btn btn-danger">
                    Oui, supprimer
                </button>
                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>