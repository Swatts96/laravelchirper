function openGifModal() {
    document.getElementById('gifModal').classList.remove('hidden');
}

function closeGifModal() {
    document.getElementById('gifModal').classList.add('hidden');
}

document.getElementById('gifSearch').addEventListener('input', async (e) => {
    const query = e.target.value;
    if (!query) return;

    const apiKey = 'G87j6bzmFMAZbkd9k8VfYqJegmZwvZoZ'; // Giphy API key
    const url = `https://api.giphy.com/v1/gifs/search?api_key=${'G87j6bzmFMAZbkd9k8VfYqJegmZwvZoZ'}&q=${query}&limit=9`;

    const response = await fetch(url);
    const data = await response.json();

    const gifResults = document.getElementById('gifResults');
    gifResults.innerHTML = '';

});

