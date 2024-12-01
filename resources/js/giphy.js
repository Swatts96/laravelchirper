function openGifModal() {
    document.getElementById('gifModal').classList.remove('hidden');
}

function closeGifModal() {
    document.getElementById('gifModal').classList.add('hidden');
}

document.getElementById('gifSearch').addEventListener('input', async (e) => {
    const query = e.target.value;
    if (!query) return;

    const apiKey = 'G87j6bzmFMAZbkd9k8VfYqJegmZwvZoZ'; // Replace with your Giphy API key
    const url = `https://api.giphy.com/v1/gifs/search?api_key=${apiKey}&q=${query}&limit=9`;

    const response = await fetch(url);
    const data = await response.json();

    const gifResults = document.getElementById('gifResults');
    gifResults.innerHTML = '';

    data.data.forEach(gif => {
        const img = document.createElement('img');
        img.src = gif.images.fixed_width.url;
        img.classList.add('cursor-pointer', 'rounded', 'hover:opacity-75');
        img.addEventListener('click', () => selectGif(gif.images.fixed_width.url));
        gifResults.appendChild(img);
    });
});

function selectGif(url) {
    const messageInput = document.getElementById('chirpMessage');
    messageInput.value += ` ![GIF](${url}) `;
    closeGifModal();
}
