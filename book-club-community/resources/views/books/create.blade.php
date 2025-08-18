<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📚 {{ __('Add New Book') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('books.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus placeholder="Enter the book title" />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <!-- Author -->
                        <div>
                            <x-input-label for="author" :value="__('Author')" />
                            <x-text-input id="author" name="author" type="text" class="mt-1 block w-full" :value="old('author')" required placeholder="Enter the author's name" />
                            <x-input-error class="mt-2" :messages="$errors->get('author')" />
                        </div>

                        <!-- ISBN and Genre -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="isbn" :value="__('ISBN (optional)')" />
                                <x-text-input id="isbn" name="isbn" type="text" class="mt-1 block w-full" :value="old('isbn')" placeholder="978-0-123456-78-9" />
                                <x-input-error class="mt-2" :messages="$errors->get('isbn')" />
                            </div>

                            <div>
                                <x-input-label for="genre" :value="__('Genre (optional)')" />
                                <x-text-input id="genre" name="genre" type="text" class="mt-1 block w-full" :value="old('genre')" placeholder="Fiction, Mystery, Romance, etc." />
                                <x-input-error class="mt-2" :messages="$errors->get('genre')" />
                            </div>
                        </div>

                        <!-- Published Year and Pages -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="published_year" :value="__('Published Year (optional)')" />
                                <x-text-input id="published_year" name="published_year" type="number" min="1000" max="{{ date('Y') + 1 }}" class="mt-1 block w-full" :value="old('published_year')" placeholder="{{ date('Y') }}" />
                                <x-input-error class="mt-2" :messages="$errors->get('published_year')" />
                            </div>

                            <div>
                                <x-input-label for="pages" :value="__('Number of Pages (optional)')" />
                                <x-text-input id="pages" name="pages" type="number" min="1" class="mt-1 block w-full" :value="old('pages')" placeholder="300" />
                                <x-input-error class="mt-2" :messages="$errors->get('pages')" />
                            </div>
                        </div>

                        <!-- Description -->
                        <div>
                            <x-input-label for="description" :value="__('Description (optional)')" />
                            <textarea id="description" name="description" rows="6" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Enter a brief description of the book...">{{ old('description') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('description')" />
                        </div>

                        <!-- Cover Image -->
                        <div>
                            <x-input-label for="cover_image" :value="__('Cover Image (optional)')" />
                            <input id="cover_image" name="cover_image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            <x-input-error class="mt-2" :messages="$errors->get('cover_image')" />
                            <p class="mt-1 text-sm text-gray-600">{{ __('JPG, PNG, GIF up to 2MB') }}</p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                                ← Cancel
                            </a>
                            
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                📚 Add Book
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips -->
            <div class="mt-6 bg-blue-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">💡 Tips for Adding Books</h3>
                <ul class="text-blue-800 space-y-2 text-sm">
                    <li>• Make sure the title and author are accurate for easy discovery</li>
                    <li>• Adding a genre helps other users find books they're interested in</li>
                    <li>• A good description helps others decide if they want to read the book</li>
                    <li>• Cover images make the book collection more visually appealing</li>
                    <li>• You can always edit these details later if needed</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
