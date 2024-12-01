<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('chirps.store') }}">
            @csrf
            <textarea
                name="message"
                placeholder="{{ __('What\'s on your mind?') }}"
                class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            >{{ old('message') }}</textarea>
            <x-input-error :messages="$errors->get('message')" class="mt-2" />

            <!-- GIF Button -->
            <button type="button" onclick="openGifModal()" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded">
                Add GIF
            </button>

            <!-- Submit Button-->
            <x-primary-button class="mt-4 ">{{ __('Chirp') }}</x-primary-button>
        </form>

        <!-- GIF Modal -->
        <div id="gifModal" class="hidden fixed z-10 inset-0 overflow-y-auto bg-gray-900 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-3/4 max-w-lg">
                <input
                    type="text"
                    id="gifSearch"
                    placeholder="Search for GIFs"
                    class="w-full border-gray-300 rounded-md mb-4"
                >
                <div id="gifResults"></div> <!-- Should populate using our giphy api, using the collection of gifs I saved for the assignment -->
                <button onclick="closeGifModal()" class="mt-4 bg-gray-500 text-white px-4 py-2 rounded">
                    Close
                </button>
            </div>
        </div>


        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($chirps as $chirp)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">{{ $chirp->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $chirp->created_at->format('j M Y, g:i a') }}</small>
                                @unless ($chirp->created_at->eq($chirp->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                @endunless
                            </div>
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $chirp->message }}</p>

                        <!-- Like/Unlike buttons and Like count -->
                        <div class="mt-4 flex items-center space-x-4">
                            <button
                                type="button"
                                class="like-btn focus:outline-none"
                                data-chirp-id="{{ $chirp->id }}"
                                data-is-liked="{{ $chirp->likes->contains('user_id', auth()->id()) ? 'true' : 'false' }}"
                            >
                                @if ($chirp->likes->contains('user_id', auth()->id()))
                                    <img src="{{ asset('images/thumb-down.png') }}" alt="Unlike" class="h-6 w-6">
                                @else
                                    <img src="{{ asset('images/thumb-up.png') }}" alt="Like" class="h-6 w-6">
                                @endif
                            </button>
                            <span class="text-gray-500 likes-count" id="likes-count-{{ $chirp->id }}">
                                {{ $chirp->likes->count() }} Likes
                            </span>
                        </div>


                    </div>
                    @if ($chirp->user->is(auth()->user()))
                        <x-dropdown>
                            <x-slot name="trigger">
                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                            </x-slot>
                            <x-slot name="content">
                                <x-dropdown-link :href="route('chirps.edit', $chirp)">
                                    {{ __('Edit') }}
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('chirps.destroy', $chirp) }}">
                                    @csrf
                                    @method('delete')
                                    <x-dropdown-link :href="route('chirps.destroy', $chirp)" onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('Delete') }}
                                    </x-dropdown-link>
                                </form>
                                <x-dropdown-link :href="route('chirps.show', $chirp)">
                                    {{ __('Details') }}
                                </x-dropdown-link>
                            </x-slot>
                        </x-dropdown>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
<script>
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

</script>
