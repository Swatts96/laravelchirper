document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', () => {
            const chirpId = button.dataset.chirpId;
            const isLiked = button.dataset.isLiked === 'true';

            // Determine the HTTP method and endpoint
            const method = isLiked ? 'DELETE' : 'POST';
            const url = `/chirps/${chirpId}/like`;

            // Send AJAX request
            fetch(url, {
                method: method,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                },
            })

        });
    });
});
