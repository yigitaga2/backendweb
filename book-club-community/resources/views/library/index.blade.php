<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📚 {{ __('My Library') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('books.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                    🔍 Browse Books
                </a>
                <a href="{{ route('books.create') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                    ➕ Add Book
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Library Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ auth()->user()->books()->count() }}</div>
                        <div class="text-sm text-gray-600">Total Books</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-orange-600">{{ auth()->user()->books()->wherePivot('status', 'want_to_read')->count() }}</div>
                        <div class="text-sm text-gray-600">Want to Read</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">{{ auth()->user()->books()->wherePivot('status', 'currently_reading')->count() }}</div>
                        <div class="text-sm text-gray-600">Currently Reading</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ auth()->user()->books()->wherePivot('status', 'read')->count() }}</div>
                        <div class="text-sm text-gray-600">Read</div>
                    </div>
                </div>
            </div>

            <!-- Search and Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('library.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search your library by title or author..." class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div>
                            <select name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">All Books</option>
                                <option value="want_to_read" {{ request('status') === 'want_to_read' ? 'selected' : '' }}>Want to Read</option>
                                <option value="currently_reading" {{ request('status') === 'currently_reading' ? 'selected' : '' }}>Currently Reading</option>
                                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                🔍 Search
                            </button>
                            <a href="{{ route('library.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
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
                                <p class="text-gray-600 mb-3">by {{ $book->author }}</p>
                                
                                <!-- Status Badge -->
                                <div class="mb-3">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                        @if($book->pivot->status === 'read') bg-purple-100 text-purple-800
                                        @elseif($book->pivot->status === 'currently_reading') bg-green-100 text-green-800
                                        @else bg-orange-100 text-orange-800 @endif">
                                        @if($book->pivot->status === 'read') ✅ Read
                                        @elseif($book->pivot->status === 'currently_reading') 📖 Currently Reading
                                        @else 📚 Want to Read @endif
                                    </span>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex items-center justify-between">
                                    <form method="POST" action="{{ route('library.update', $book) }}" class="flex-1 mr-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                            <option value="want_to_read" {{ $book->pivot->status === 'want_to_read' ? 'selected' : '' }}>Want to Read</option>
                                            <option value="currently_reading" {{ $book->pivot->status === 'currently_reading' ? 'selected' : '' }}>Currently Reading</option>
                                            <option value="read" {{ $book->pivot->status === 'read' ? 'selected' : '' }}>Read</option>
                                        </select>
                                    </form>
                                    
                                    <form method="POST" action="{{ route('library.destroy', $book) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Remove this book from your library?')">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="mt-2 text-xs text-gray-500">
                                    Added {{ $book->pivot->created_at->diffForHumans() }}
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
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">Your Library is Empty</h2>
                        <p class="text-gray-600 mb-6">
                            @if(request()->filled('search') || request()->filled('status'))
                                No books match your current filters. Try adjusting your search.
                            @else
                                Start building your personal library by adding books you want to read!
                            @endif
                        </p>
                        <div class="flex justify-center space-x-4">
                            <a href="{{ route('books.index') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                🔍 Browse Books
                            </a>
                            <a href="{{ route('books.create') }}" class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition duration-150 ease-in-out">
                                ➕ Add New Book
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
