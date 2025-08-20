<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ❓ {{ __('FAQ Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Manage FAQ Items</h3>
                        <a href="{{ route('admin.faq.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                            ➕ Add FAQ Item
                        </a>
                    </div>
                    
                    <form method="GET" action="{{ route('admin.faq.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search FAQ by question or answer..." class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div>
                            <select name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">All Status</option>
                                <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                                <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                🔍 Search
                            </button>
                            <a href="{{ route('admin.faq.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- FAQ List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">FAQ Items ({{ $faqs->total() }})</h3>
                    </div>

                    @if($faqs->count() > 0)
                        <div class="space-y-4">
                            @foreach($faqs as $faq)
                                <div class="border rounded-lg p-4 {{ $faq->is_published ? 'bg-green-50 border-green-200' : 'bg-yellow-50 border-yellow-200' }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-2">
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $faq->question }}</h4>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $faq->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $faq->is_published ? '✅ Published' : '📝 Draft' }}
                                                </span>
                                            </div>
                                            <div class="flex items-center space-x-4 text-sm text-gray-600 mb-3">
                                                <span><strong>Order:</strong> {{ $faq->order }}</span>
                                                <span><strong>Created:</strong> {{ $faq->created_at->format('M j, Y') }}</span>
                                                <span><strong>Updated:</strong> {{ $faq->updated_at->format('M j, Y') }}</span>
                                            </div>
                                            <div class="bg-gray-100 rounded p-3">
                                                <p class="text-gray-700"><strong>Answer:</strong> {{ Str::limit($faq->answer, 200) }}</p>
                                            </div>
                                        </div>
                                        <div class="flex flex-col space-y-2 ml-4">
                                            <a href="{{ route('faq.index') }}#faq-{{ $faq->id }}" target="_blank" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700 text-center">
                                                👁️ View
                                            </a>
                                            <a href="{{ route('admin.faq.edit', $faq) }}" class="px-3 py-1 bg-yellow-600 text-white rounded text-sm hover:bg-yellow-700 text-center">
                                                ✏️ Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.faq.destroy', $faq) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this FAQ item?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                                                    🗑️ Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $faqs->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">❓</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No FAQ items found</h3>
                            <p class="text-gray-500 mb-6">
                                @if(request()->filled('search') || request()->filled('status'))
                                    Try adjusting your search criteria.
                                @else
                                    Start by creating your first FAQ item.
                                @endif
                            </p>
                            <a href="{{ route('admin.faq.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                ➕ Create First FAQ
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
