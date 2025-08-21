<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ❓ {{ __('Create FAQ Item') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.faq.store') }}" class="space-y-6">
                        @csrf

                        <!-- Question -->
                        <div>
                            <x-input-label for="question" :value="__('Question')" />
                            <x-text-input id="question" name="question" type="text" class="mt-1 block w-full" :value="old('question')" required autofocus placeholder="Enter the frequently asked question" />
                            <x-input-error class="mt-2" :messages="$errors->get('question')" />
                        </div>

                        <!-- Answer -->
                        <div>
                            <x-input-label for="answer" :value="__('Answer')" />
                            <textarea id="answer" name="answer" rows="6" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Provide a clear and helpful answer...">{{ old('answer') }}</textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('answer')" />
                        </div>

                        <!-- Category and Sort Order -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <x-input-label for="category_id" :value="__('Category')" />
                                <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                    <option value="">Select a category</option>
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                            </div>

                            <div>
                                <x-input-label for="sort_order" :value="__('Sort Order (optional)')" />
                                <x-text-input id="sort_order" name="sort_order" type="number" min="1" class="mt-1 block w-full" :value="old('sort_order')" placeholder="Leave empty for auto-ordering" />
                                <x-input-error class="mt-2" :messages="$errors->get('sort_order')" />
                            </div>
                        </div>

                        <!-- Publication Status -->
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-600">{{ __('Publish immediately') }}</span>
                            </label>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('admin.faq.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-gray-700 hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                                ← Cancel
                            </a>
                            
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                ❓ Create FAQ
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips -->
            <div class="mt-6 bg-blue-50 rounded-lg p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-3">💡 Tips for Creating FAQ Items</h3>
                <ul class="text-blue-800 space-y-2 text-sm">
                    <li>• Write questions from the user's perspective</li>
                    <li>• Keep answers clear, concise, and helpful</li>
                    <li>• Use simple language that everyone can understand</li>
                    <li>• Include relevant links or examples when helpful</li>
                    <li>• Review and update FAQ items regularly</li>
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
