<x-public-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Featured Image -->
                @if($news->featured_image)
                    <img src="{{ $news->featured_image_url }}" alt="{{ $news->title }}" class="w-full h-64 md:h-80 object-cover">
                @else
                    <div class="w-full h-64 md:h-80 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                        <span class="text-white text-6xl">📰</span>
                    </div>
                @endif

                <div class="p-6 md:p-8">
                    <!-- Article Header -->
                    <div class="mb-6">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center text-sm text-gray-500">
                                <span>{{ $news->published_at->format('F j, Y') }}</span>
                                <span class="mx-2">•</span>
                                <span>by {{ $news->user->name }}</span>
                                @if(!$news->is_published)
                                    <span class="mx-2">•</span>
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        📝 Draft
                                    </span>
                                @endif
                            </div>
                            
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <div class="flex space-x-2">
                                        <a href="{{ route('news.edit', $news) }}" class="inline-flex items-center px-3 py-1 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            ✏️ Edit
                                        </a>
                                        <form method="POST" action="{{ route('news.destroy', $news) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this article?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1 border border-red-300 rounded-md text-sm font-medium text-red-700 bg-white hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                🗑️ Delete
                                            </button>
                                        </form>
                                    </div>
                                @endif
                            @endauth
                        </div>
                        
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight">{{ $news->title }}</h1>
                    </div>

                    <!-- Article Content -->
                    <div class="prose prose-lg max-w-none">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                    <!-- Article Footer -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <img src="{{ $news->user->profile_photo_url }}" alt="{{ $news->user->name }}" class="w-12 h-12 rounded-full object-cover">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $news->user->name }}</p>
                                    <p class="text-sm text-gray-500">Article Author</p>
                                </div>
                            </div>
                            
                            <div class="text-sm text-gray-500">
                                Published {{ $news->published_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <a href="{{ route('news.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                            ← Back to News
                        </a>
                    </div>
                </div>
            </div>

            <!-- Related Articles (if we want to add this later) -->
            <div class="mt-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">More News</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach(\App\Models\News::published()->where('id', '!=', $news->id)->latest()->take(2)->get() as $relatedNews)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition duration-300">
                            @if($relatedNews->featured_image)
                                <img src="{{ $relatedNews->featured_image_url }}" alt="{{ $relatedNews->title }}" class="w-full h-32 object-cover">
                            @else
                                <div class="w-full h-32 bg-gradient-to-r from-blue-400 to-purple-500 flex items-center justify-center">
                                    <span class="text-white text-2xl">📰</span>
                                </div>
                            @endif
                            
                            <div class="p-4">
                                <div class="text-sm text-gray-500 mb-2">{{ $relatedNews->published_at->format('M j, Y') }}</div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    <a href="{{ route('news.show', $relatedNews) }}" class="hover:text-blue-600 transition duration-150">
                                        {{ $relatedNews->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 text-sm">{{ Str::limit(strip_tags($relatedNews->content), 80) }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
