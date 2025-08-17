<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit News Article') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('news.update', $news) }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title', $news->title)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <!-- Content -->
                        <div>
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea id="content" name="content" rows="12" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Write your news article content here...">{{ old('content', $news->content) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>

                        <!-- Featured Image -->
                        <div>
                            <x-input-label for="featured_image" :value="__('Featured Image')" />
                            @if($news->featured_image)
                                <div class="mt-2">
                                    <img src="{{ $news->featured_image_url }}" alt="Current featured image" class="w-32 h-20 object-cover rounded">
                                    <p class="text-sm text-gray-600 mt-1">Current image</p>
                                </div>
                            @endif
                            <input id="featured_image" name="featured_image" type="file" accept="image/*" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                            <x-input-error class="mt-2" :messages="$errors->get('featured_image')" />
                            <p class="mt-1 text-sm text-gray-600">{{ __('JPG, PNG, GIF up to 2MB. Leave empty to keep current image.') }}</p>
                        </div>

                        <!-- Publishing Options -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Published Status -->
                            <div>
                                <x-input-label for="is_published" :value="__('Status')" />
                                <select id="is_published" name="is_published" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="0" {{ old('is_published', $news->is_published) == '0' ? 'selected' : '' }}>📝 Save as Draft</option>
                                    <option value="1" {{ old('is_published', $news->is_published) == '1' ? 'selected' : '' }}>🚀 Published</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('is_published')" />
                            </div>

                            <!-- Published Date -->
                            <div>
                                <x-input-label for="published_at" :value="__('Publish Date')" />
                                <x-text-input id="published_at" name="published_at" type="datetime-local" class="mt-1 block w-full" :value="old('published_at', $news->published_at?->format('Y-m-d\TH:i'))" />
                                <x-input-error class="mt-2" :messages="$errors->get('published_at')" />
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('news.show', $news) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                                ← Cancel
                            </a>
                            
                            <div class="flex space-x-3">
                                <button type="submit" name="action" value="draft" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                                    📝 Save as Draft
                                </button>
                                <button type="submit" name="action" value="publish" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    ✨ Update Article
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-set publish status based on button clicked
        document.addEventListener('DOMContentLoaded', function() {
            const draftBtn = document.querySelector('button[value="draft"]');
            const publishBtn = document.querySelector('button[value="publish"]');
            const statusSelect = document.getElementById('is_published');
            
            draftBtn.addEventListener('click', function() {
                statusSelect.value = '0';
            });
            
            publishBtn.addEventListener('click', function() {
                statusSelect.value = '1';
            });
        });
    </script>
</x-app-layout>
