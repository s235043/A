document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('.delete-form');
    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            if (!confirm('この投稿を本当に削除しますか？')) {
                e.preventDefault();
            }
        });
    });
});