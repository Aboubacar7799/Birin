
<?php echo $__env->make('navbar/navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('navbar/mobile', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startSection('content'); ?>
    <div class="container mt-3">
        
        <div class="card-body pt-2">
            
            <div id="comments-lists-<?php echo e($post->id); ?>" class="mb-3">

                <?php $__currentLoopData = $post->comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex">
                        <a href="<?php echo e(route('app_profil', $comment->user->profil->id)); ?>" class="text-decoration-none">
                            <img src="<?php echo e($comment->user->profil->getImage()); ?>" class="rounded-circle me-2" width="35"
                                height="35">

                            <strong class="px-1"><?php echo e($comment->user->name); ?></strong>
                        </a>
                        <?php if($comment->user_id === auth()->id()): ?>
                            <div class="dropdown d-inline ml-5">
                                <button class="btn btn-sm btn-light" type="button"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    <img
                                        src="<?php echo e(asset('assets/svg/menu_3P.png')); ?>"
                                        class="img-fluid"
                                        alt=""
                                        width="30"
                                        height="30"
                                    />
                                </button>
                                <ul class="dropdown-menu">
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('update', $comment)): ?><li><a class="dropdown-item edit-btn" href="#" data-id="<?php echo e($comment->id); ?>">Modifier</a></li><?php endif; ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('delete', $comment)): ?><li><a class="dropdown-item delete-btn" href="#" data-id="<?php echo e($comment->id); ?>">Supprimer</a></li><?php endif; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="rounded px-5 mb-3">
                        <div class="comment-item" id="comment-<?php echo e($comment->id); ?>">
                            <p class="comment-content"><?php echo e($comment->content); ?></p>
                            <small class="text-muted">
                                <?php echo e($comment->created_at->diffForHumans()); ?>

                            </small>

                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

        </div>

        
        <form class="comment-form border-top pt-3" data-post-id="<?php echo e($post->id); ?>"
            action="<?php echo e(route('comments.store', $post->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="d-flex align-items-center">
                <img src="<?php echo e(auth()->user()->profil->getImage()); ?>" class="rounded-circle me-2" width="35"
                    height="35">

                <input type="text" name="content" class="form-control rounded-pill" placeholder="Écrire un commentaire…">
            </div>
        </form>

    </div>



    <!-- Modal Modifier -->
<div class="modal fade" id="editModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifier le commentaire</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <textarea id="editContent" class="form-control" rows="3"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirmEdit" class="btn btn-primary">Enregistrer</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Supprimer -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supprimer le commentaire ?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Voulez-vous vraiment supprimer ce commentaire ?
            </div>
            <div class="modal-footer">
                <button type="button" id="confirmDelete" class="btn btn-danger">Oui, supprimer</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            </div>
        </div>
    </div>
</div>

<script>
    // La suppression et la modification de commentaire
let commentIdToEdit = null;
let commentIdToDelete = null;

// ------------------ Modifier ------------------
document.querySelectorAll('.edit-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault()
        commentIdToEdit = this.dataset.id;
        let commentText = document.querySelector(`#comment-${commentIdToEdit} .comment-content`).textContent;
        document.getElementById('editContent').value = commentText;

        let modal = new bootstrap.Modal(document.getElementById('editModal'));
        modal.show();
    });
});

document.getElementById('confirmEdit').addEventListener('click', function() {
    let newContent = document.getElementById('editContent').value;

    fetch(`/comments/${commentIdToEdit}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type':'application/json'
        },
        body: JSON.stringify({ content: newContent })
    })
    .then(response => response.ok ? response.json() : Promise.reject())
    .then(data => {
        document.querySelector(`#comment-${commentIdToEdit} .comment-content`).textContent = data.content;
        bootstrap.Modal.getInstance(document.getElementById('editModal')).hide();
        showToast("Commentaire modifié avec succès", "success");
    })
    .catch(() => showToast("Erreur lors de la modification", "danger"));
});

// ------------------ Supprimer ------------------
document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        commentIdToDelete = this.dataset.id;
        let modal = new bootstrap.Modal(document.getElementById('deleteModal'));
        modal.show();
    });
});

document.getElementById('confirmDelete').addEventListener('click', function() {
    fetch(`/comments/${commentIdToDelete}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Content-Type':'application/json'
        }
    })
    .then(response => response.ok ? response.json() : Promise.reject())
    .then(() => {
        document.getElementById(`comment-${commentIdToDelete}`).remove();
        bootstrap.Modal.getInstance(document.getElementById('deleteModal')).hide();
        showToast("Commentaire supprimé", "success");
    })
    .catch(() => showToast("Erreur lors de la suppression", "danger"));
});

// ------------------ Toast ------------------
function showToast(message, type="success") {
    let toastEl = document.createElement('div');
    toastEl.className = `toast align-items-center text-bg-${type} border-0`;
    toastEl.role = "alert";
    toastEl.innerHTML = `
        <div class="d-flex">
            <div class="toast-body">${message}</div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>`;
    document.body.appendChild(toastEl);
    let toast = new bootstrap.Toast(toastEl);
    toast.show();

    setTimeout(() => { toastEl.remove(); }, 5000);
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('base', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\instagram\resources\views/posts/comments.blade.php ENDPATH**/ ?>