<x-public-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">📰 Book Club News</h1>
                            <p class="text-gray-600 mt-2">Stay updated with the latest from our book community</p>
                        </div>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('news.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    ✏️ Create News
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>

            <!-- News Grid -->
            @if($news->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($news as $article)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition duration-300">
                            @if($article->featured_image)
                                <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                    <span class="text-white text-4xl">📰</span>
                                </div>
                            @endif
                            
                            <div class="p-6">
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <span>{{ $article->published_at->format('M j, Y') }}</span>
                                    <span class="mx-2">•</span>
                                    <span>by {{ $article->user->name }}</span>
                                </div>
                                
                                <h2 class="text-xl font-semibold text-gray-900 mb-3">
                                    <a href="{{ route('news.show', $article) }}" class="hover:text-blue-600 transition duration-150">
                                        {{ $article->title }}
                                    </a>
                                </h2>
                                
                                <p class="text-gray-600 mb-4">{{ Str::limit(strip_tags($article->content), 120) }}</p>
                                
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('news.show', $article) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        Read more →
                                    </a>
                                    
                                    @auth
                                        @if(auth()->user()->isAdmin())
                                            <div class="flex space-x-2">
                                                <a href="{{ route('news.edit', $article) }}" class="text-gray-500 hover:text-blue-600">
                                                    ✏️
                                                </a>
                                                <form method="POST" action="{{ route('news.destroy', $article) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this article?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-500 hover:text-red-600">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $news->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <div class="text-6xl mb-4">📰</div>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">No News Yet</h2>
                        <p class="text-gray-600 mb-6">Be the first to know when we publish our latest book community updates!</p>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('news.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    ✏️ Create First Article
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
