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
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    // Update the button state
                    button.dataset.isLiked = isLiked ? 'false' : 'true';
                    button.innerHTML = isLiked
                        ? `<img src="/images/thumb-up.png" alt="Like" class="h-6 w-6">`
                        : `<img src="/images/thumb-down.png" alt="Unlike" class="h-6 w-6">`;

                    // Update the like count
                    document.querySelector(`#likes-count-${chirpId}`).textContent = `${data.likesCount} Likes`;
                })
                .catch(error => console.error('Error:', error));
        });
    });
});
