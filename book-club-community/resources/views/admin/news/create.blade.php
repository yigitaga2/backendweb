<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📰 {{ __('Create News Article') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Title -->
                        <div>
                            <x-input-label for="title" :value="__('Title')" />
                            <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required autofocus placeholder="Enter an engaging news title" />
                            <x-input-error class="mt-2" :messages="$errors->get('title')" />
                        </div>

                        <!-- Slug -->
                        <div>
                            <x-input-label for="slug" :value="__('URL Slug')" />
                            <x-text-input id="slug" name="slug" type="text" class="mt-1 block w-full" :value="old('slug')" required placeholder="url-friendly-slug" />
                            <x-input-error class="mt-2" :messages="$errors->get('slug')" />
                            <p class="mt-1 text-sm text-gray-600">This will be used in the URL. Use lowercase letters, numbers, and hyphens only.</p>
                        </div>

                        <!-- Content -->
                        <div>
                            <x-input-label for="content" :value="__('Content')" />
                            <textarea id="content" name="content" rows="12" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Write your news article content here...">{{ old('content') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                            <p class="mt-1 text-sm text-gray-600">You can use HTML tags for formatting.</p>
                        </div>

                        <!-- Featured Image -->
                        <div>
                            <x-input-label for="featured_image" :value="__('Featured Image (optional)')" />
                            <input id="featured_image" name="featured_image" type="file" accept="image/*" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" />
                            <x-input-error class="mt-2" :messages="$errors->get('featured_image')" />
                            <p class="mt-1 text-sm text-gray-600">Upload a featured image for your news article (JPG, PNG, GIF, max 2MB).</p>
                        </div>

                        <!-- Publication Settings -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-600">{{ __('Publish immediately') }}</span>
                                </label>
                            </div>

                            <div>
                                <x-input-label for="published_at" :value="__('Publish Date (optional)')" />
                                <x-text-input id="published_at" name="published_at" type="datetime-local" class="mt-1 block w-full" :value="old('published_at')" />
                                <x-input-error class="mt-2" :messages="$errors->get('published_at')" />
                                <p class="mt-1 text-sm text-gray-600">Leave empty to use current date/time.</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.news.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                                ← Cancel
                            </a>
                            
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                📰 Create Article
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips -->
            <div class="mt-6 bg-blue-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">💡 Tips for Writing News Articles</h3>
                <ul class="text-blue-800 space-y-2 text-sm">
                    <li>• Write compelling headlines that grab attention</li>
                    <li>• Start with the most important information</li>
                    <li>• Use clear, concise language</li>
                    <li>• Include relevant images to enhance the story</li>
                    <li>• Proofread before publishing</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        // Auto-generate slug from title
        document.getElementById('title').addEventListener('input', function() {
            const title = this.value;
            const slug = title.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            document.getElementById('slug').value = slug;
        });
    </script>
</x-app-layout>
