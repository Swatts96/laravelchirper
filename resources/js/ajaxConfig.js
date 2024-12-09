document.addEventListener('DOMContentLoaded', function () {
    const buttons = document.querySelectorAll('.vote-btn');

    buttons.forEach(button => {
        button.addEventListener('click', function () {
            const chirpId = this.dataset.chirpId;
            const voteType = this.dataset.voteType; // 'upvote' or 'downvote'

            const url = `/chirps/${chirpId}/${voteType}`;
            const method = 'post';

            axios({
                method: method,
                url: url,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
                .then(response => {
                    // Update vote count in UI
                    const voteCountElement = document.querySelector(`#votes-count-${chirpId}`);
                    voteCountElement.textContent = `${response.data.totalVotes} Votes`;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Something went wrong. Please try again.');
                });
        });
    });
});
