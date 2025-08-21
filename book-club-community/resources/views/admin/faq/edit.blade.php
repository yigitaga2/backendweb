<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ❓ {{ __('Edit FAQ Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.faq.update', $faq) }}" class="space-y-6">
                        @csrf
                        @method('PATCH')

                        <!-- Question -->
                        <div>
                            <x-input-label for="question" :value="__('Question')" />
                            <x-text-input id="question" name="question" type="text" class="mt-1 block w-full" :value="old('question', $faq->question)" required autofocus placeholder="Enter the frequently asked question" />
                            <x-input-error class="mt-2" :messages="$errors->get('question')" />
                        </div>

                        <!-- Answer -->
                        <div>
                            <x-input-label for="answer" :value="__('Answer')" />
                            <textarea id="answer" name="answer" rows="6" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Provide a clear and helpful answer...">{{ old('answer', $faq->answer) }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('answer')" />
                        </div>

                        <!-- Category and Sort Order -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="category_id" :value="__('Category')" />
                                <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select a category</option>
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $faq->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                            </div>

                            <div>
                                <x-input-label for="sort_order" :value="__('Sort Order (optional)')" />
                                <x-text-input id="sort_order" name="sort_order" type="number" min="1" class="mt-1 block w-full" :value="old('sort_order', $faq->sort_order)" placeholder="Leave empty for auto-ordering" />
                                <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                            </div>
                        </div>

                        <!-- Publication Status -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $faq->is_published) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Published') }}</span>
                            </label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.faq.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                                ← Cancel
                            </a>
                            
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                ✨ Update FAQ
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Additional Actions -->
            <div class="mt-6 bg-red-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-red-900 mb-3">🗑️ Danger Zone</h3>
                <p class="text-red-800 text-sm mb-4">Once you delete this FAQ item, it cannot be recovered.</p>
                <form method="POST" action="{{ route('admin.faq.destroy', $faq) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this FAQ item? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                        🗑️ Delete FAQ Item
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
