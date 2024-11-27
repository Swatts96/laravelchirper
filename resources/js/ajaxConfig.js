document.addEventListener('DOMContentLoaded', function () {
    // Select all like buttons
    const buttons = document.querySelectorAll('.like-btn');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            // Get the chirp ID and like state from the button's data attributes
            const chirpId = this.dataset.chirpId;
            const isLiked = this.dataset.isLiked === 'true';

            // Determine the URL and HTTP method
            const url = `/chirps/${chirpId}/like`;

            const method = isLiked ? 'delete' : 'post';

            // Send the AJAX request using Axios
            axios({
                method: method,
                url: url,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then(response => {
                    // Toggle the like state
                    this.dataset.isLiked = isLiked ? 'false' : 'true';

                    // Update the button's icon based on the new state
                    this.innerHTML = isLiked
                        ? `<img src="/images/thumb-up.png" alt="Like" class="h-6 w-6">`
                        : `<img src="/images/thumb-down.png" alt="Unlike" class="h-6 w-6">`;

                    // Update the likes count
                    const likesCountElement = document.querySelector(`#likes-count-${chirpId}`);
                    likesCountElement.textContent = `${response.data.likesCount} Likes`;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong. Please try again.');
                });
        });
    });
});

//Ready for marking
