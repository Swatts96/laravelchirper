document.addEventListener('DOMContentLoaded', function () {
    const voteButtons = document.querySelectorAll('.vote-btn');

    voteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const chirpId = this.dataset.chirpId;
            const voteType = this.dataset.voteType;

            axios.post(`/chirps/${chirpId}/vote`, {
                type: voteType,
            })
                .then(response => {
                    const voteCountElement = document.querySelector(`#votes-count-${chirpId}`);
                    voteCountElement.textContent = `${response.data.totalVotes} Votes`;
                })
                .catch(error => {
                    alert('Something went wrong. Please try again.');
                });

        });
    });
});
