<x-public-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">📚 Book Collection</h1>
                            <p class="text-gray-600 mt-2">Discover your next great read from our community library</p>
                        </div>
                        @auth
                            <a href="{{ route('books.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                ➕ Add Book
                            </a>
                        @endauth
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('books.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search books by title, author, publisher, or ISBN..." class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div>
                            <select name="publisher" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">All Publishers</option>
                                @foreach($publishers as $publisher)
                                    <option value="{{ $publisher }}" {{ request('publisher') === $publisher ? 'selected' : '' }}>{{ $publisher }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                🔍 Search
                            </button>
                            <a href="{{ route('books.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Books Grid -->
            @if($books->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                    @foreach($books as $book)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg hover:shadow-md transition duration-300">
                            <a href="{{ route('books.show', $book) }}">
                                <img src="{{ $book->cover_image_url }}" alt="{{ $book->title }}" class="w-full h-64 object-cover">
                            </a>
                            
                            <div class="p-4">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                    <a href="{{ route('books.show', $book) }}" class="hover:text-blue-600 transition duration-150">
                                        {{ $book->title }}
                                    </a>
                                </h3>
                                <p class="text-gray-600 mb-2">by {{ $book->author }}</p>

                                @if($book->publisher)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mb-2">
                                        {{ $book->publisher }}
                                    </span>
                                @endif

                                @if($book->publication_date)
                                    <p class="text-sm text-gray-500 mb-3">Published: {{ $book->publication_date->format('Y') }}</p>
                                @endif
                                
                                <div class="flex items-center justify-between">
                                    <div class="text-sm text-gray-500">
                                        ⭐ {{ $book->reviews()->avg('stars') ? number_format($book->reviews()->avg('stars'), 1) : 'No ratings' }}
                                        ({{ $book->reviews()->count() }} reviews)
                                    </div>
                                    
                                    @auth
                                        @if(!auth()->user()->books()->where('book_id', $book->id)->exists())
                                            <form method="POST" action="{{ route('library.store') }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                <input type="hidden" name="status" value="want_to_read">
                                                <button type="submit" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    + Add to Library
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-green-600 text-sm font-medium">✓ In Library</span>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $books->withQueryString()->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <div class="text-6xl mb-4">📚</div>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">No Books Found</h2>
                        <p class="text-gray-600 mb-6">
                            @if(request()->filled('search') || request()->filled('genre'))
                                Try adjusting your search criteria or browse all books.
                            @else
                                Be the first to add books to our community library!
                            @endif
                        </p>
                        @auth
                            <a href="{{ route('books.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                ➕ Add First Book
                            </a>
                        @endauth
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
