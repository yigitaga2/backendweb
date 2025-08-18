<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create FAQ') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('faq.store') }}" class="space-y-6">
                        @csrf

                        <!-- Question -->
                        <div>
                            <x-input-label for="question" :value="__('Question')" />
                            <x-text-input id="question" name="question" type="text" class="mt-1 block w-full" :value="old('question')" required autofocus placeholder="What question do users frequently ask?" />
                            <x-input-error class="mt-2" :messages="$errors->get('question')" />
                        </div>

                        <!-- Answer -->
                        <div>
                            <x-input-label for="answer" :value="__('Answer')" />
                            <textarea id="answer" name="answer" rows="8" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Provide a clear and helpful answer...">{{ old('answer') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('answer')" />
                        </div>

                        <!-- Publishing Options -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Published Status -->
                            <div>
                                <x-input-label for="is_published" :value="__('Status')" />
                                <select id="is_published" name="is_published" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                    <option value="0" {{ old('is_published') == '0' ? 'selected' : '' }}>📝 Save as Draft</option>
                                    <option value="1" {{ old('is_published', '1') == '1' ? 'selected' : '' }}>✅ Publish</option>
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('is_published')" />
                            </div>

                            <!-- Sort Order -->
                            <div>
                                <x-input-label for="sort_order" :value="__('Sort Order (optional)')" />
                                <x-text-input id="sort_order" name="sort_order" type="number" min="0" class="mt-1 block w-full" :value="old('sort_order')" placeholder="Leave empty for auto-order" />
                                <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                                <p class="mt-1 text-sm text-gray-600">{{ __('Lower numbers appear first') }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('faq.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                                ← Cancel
                            </a>
                            
                            <div class="flex space-x-3">
                                <button type="submit" name="action" value="draft" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                                    📝 Save Draft
                                </button>
                                <button type="submit" name="action" value="publish" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    ✅ Create FAQ
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
