<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📰 {{ __('News Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Manage News Articles</h3>
                        <a href="{{ route('admin.news.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                            ➕ Add News Article
                        </a>
                    </div>
                    
                    <form method="GET" action="{{ route('admin.news.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search news by title or content..." class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
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
                            <a href="{{ route('admin.news.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- News List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">News Articles ({{ $news->total() }})</h3>
                    </div>

                    @if($news->count() > 0)
                        <div class="space-y-4">
                            @foreach($news as $article)
                                <div class="border rounded-lg p-4 {{ $article->is_published ? 'bg-green-50 border-green-200' : 'bg-yellow-50 border-yellow-200' }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-2">
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $article->title }}</h4>
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $article->is_published ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                                    {{ $article->is_published ? '✅ Published' : '📝 Draft' }}
                                                </span>
                                            </div>
                                            <div class="flex items-center space-x-4 text-sm text-gray-600 mb-3">
                                                <span><strong>Author:</strong> {{ $article->user->name }}</span>
                                                <span><strong>Category:</strong> {{ $article->category->name ?? 'Uncategorized' }}</span>
                                                <span><strong>Created:</strong> {{ $article->created_at->format('M j, Y') }}</span>
                                                @if($article->published_at)
                                                    <span><strong>Published:</strong> {{ $article->published_at->format('M j, Y') }}</span>
                                                @endif
                                            </div>
                                            <p class="text-gray-700">{{ Str::limit(strip_tags($article->content), 200) }}</p>
                                        </div>
                                        <div class="flex flex-col space-y-2 ml-4">
                                            <a href="{{ route('news.show', $article) }}" target="_blank" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700 text-center">
                                                👁️ View
                                            </a>
                                            <a href="{{ route('admin.news.edit', $article) }}" class="px-3 py-1 bg-yellow-600 text-white rounded text-sm hover:bg-yellow-700 text-center">
                                                ✏️ Edit
                                            </a>
                                            <form method="POST" action="{{ route('admin.news.destroy', $article) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this news article?')">
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
                            {{ $news->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📰</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No news articles found</h3>
                            <p class="text-gray-500 mb-6">
                                @if(request()->filled('search') || request()->filled('status'))
                                    Try adjusting your search criteria.
                                @else
                                    Start by creating your first news article.
                                @endif
                            </p>
                            <a href="{{ route('admin.news.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                ➕ Create First Article
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
