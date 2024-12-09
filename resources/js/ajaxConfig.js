document.addEventListener('DOMContentLoaded', function () {
    const voteButtons = document.querySelectorAll('.vote-btn');

    voteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const chirpId = this.dataset.chirpId;
            const voteType = this.dataset.voteType;

            console.log(`Voting ${voteType} for chirp ID: ${chirpId}`); // Debug log

            axios.post(`/chirps/${chirpId}/vote`, {
                type: voteType,
            })
                .then(response => {
                    console.log('Response from server:', response.data);
                    const voteCountElement = document.querySelector(`#votes-count-${chirpId}`);
                    voteCountElement.textContent = `${response.data.totalVotes} Votes`;
                })
                .catch(error => {
                    console.error('Error occurred:', error.response || error.message);
                    alert('Something went wrong. Please try again.');
                });

        });
    });
});
