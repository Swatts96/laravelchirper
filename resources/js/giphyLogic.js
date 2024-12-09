
import axios from 'axios';
function openGifModal() {
    document.getElementById('gifModal').classList.remove('hidden');
}

function closeGifModal() {
    // Hide the modal
    document.getElementById('gifModal').classList.add('hidden');

    // Clear the search query input
    document.getElementById('gifSearch').value = '';

    // Clear the search results
    document.getElementById('gifResults').innerHTML = '';
}

document.getElementById('gifSearch').addEventListener('input', async (e) => {
    const query = e.target.value;
    if (!query) return;

    const apiKey = 'G87j6bzmFMAZbkd9k8VfYqJegmZwvZoZ'; // Replace with our Giphy API key
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

// Close the modal with the escape key
document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        closeGifModal();
    }
});

function adjustTextareaHeight(textarea) {
    // Optional: Reset the height so we can correctly calculate the scrollHeight
    textarea.style.height = 'auto';

    // Optional: Set the height to match the scrollHeight
    textarea.style.height = `${textarea.scrollHeight}px`;
}

// Optional: Adjust height on page load for pre-filled content
document.addEventListener('DOMContentLoaded', () => {
    const textarea = document.getElementById('chirpMessage');
    if (textarea) {
        adjustTextareaHeight(textarea);
    }
});
