<x-public-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-900">⭐ Community Reviews</h1>
                    <p class="text-gray-600 mt-2">See what our community thinks about their favorite books</p>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('reviews.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search reviews by book title, author, or reviewer name..." class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div>
                            <select name="stars" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">All Ratings</option>
                                <option value="5" {{ request('stars') === '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 stars)</option>
                                <option value="4" {{ request('stars') === '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4 stars)</option>
                                <option value="3" {{ request('stars') === '3' ? 'selected' : '' }}>⭐⭐⭐ (3 stars)</option>
                                <option value="2" {{ request('stars') === '2' ? 'selected' : '' }}>⭐⭐ (2 stars)</option>
                                <option value="1" {{ request('stars') === '1' ? 'selected' : '' }}>⭐ (1 star)</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                🔍 Search
                            </button>
                            <a href="{{ route('reviews.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Reviews Grid -->
            @if($reviews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($reviews as $review)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition duration-300">
                            <div class="p-6">
                                <!-- Book Info -->
                                <div class="flex items-start space-x-4 mb-4">
                                    <img src="{{ $review->book->cover_image_url }}" alt="{{ $review->book->title }}" class="w-16 h-20 object-cover rounded">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900 mb-1">
                                            <a href="{{ route('books.show', $review->book) }}" class="hover:text-blue-600 transition duration-150">
                                                {{ $review->book->title }}
                                            </a>
                                        </h3>
                                        <p class="text-sm text-gray-600">by {{ $review->book->author }}</p>
                                    </div>
                                </div>
                                
                                <!-- Review Info -->
                                <div class="border-t border-gray-200 pt-4">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <img src="{{ $review->user->profile_photo_url }}" alt="{{ $review->user->name }}" class="w-8 h-8 rounded-full object-cover">
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900">
                                                    <a href="{{ route('profile.show', $review->user) }}" class="hover:text-blue-600">
                                                        {{ $review->user->name }}
                                                    </a>
                                                </h4>
                                                <div class="text-yellow-400 text-sm">{{ str_repeat('⭐', $review->rating) }}</div>
                                            </div>
                                        </div>
                                        <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                    </div>
                                    
                                    @if($review->review)
                                        <p class="text-gray-700 text-sm leading-relaxed">{{ Str::limit($review->review, 150) }}</p>
                                        @if(strlen($review->review) > 150)
                                            <a href="{{ route('books.show', $review->book) }}#review-{{ $review->id }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium mt-2 inline-block">
                                                Read full review →
                                            </a>
                                        @endif
                                    @else
                                        <p class="text-gray-500 text-sm italic">No written review, just a rating.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $reviews->withQueryString()->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <div class="text-6xl mb-4">⭐</div>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">No Reviews Found</h2>
                        <p class="text-gray-600 mb-6">
                            @if(request()->filled('search') || request()->filled('stars'))
                                Try adjusting your search criteria to find more reviews.
                            @else
                                Be the first to write a review and help others discover great books!
                            @endif
                        </p>
                        <div class="flex justify-center space-x-4">
                            <a href="{{ route('books.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                📚 Browse Books
                            </a>
                            @auth
                                <a href="{{ route('library.index') }}" class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                    📖 My Library
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endif

            <!-- Call to Action -->
            @guest
                <div class="mt-8 bg-blue-50 rounded-lg p-6 text-center">
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Join Our Community!</h3>
                    <p class="text-blue-800 mb-4">Sign up to write reviews, build your library, and connect with fellow book lovers.</p>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        🚀 Sign Up Now
                    </a>
                </div>
            @endguest
        </div>
    </div>
</x-public-layout>
