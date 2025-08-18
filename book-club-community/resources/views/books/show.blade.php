<x-public-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Book Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row gap-8">
                        <!-- Book Cover -->
                        <div class="lg:w-1/3">
                            <img src="{{ $book->cover_image_url }}" alt="{{ $book->title }}" class="w-full max-w-sm mx-auto rounded-lg shadow-lg">
                        </div>
                        
                        <!-- Book Information -->
                        <div class="lg:w-2/3">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $book->title }}</h1>
                                    <p class="text-xl text-gray-600 mb-4">by {{ $book->author }}</p>
                                </div>
                                <a href="{{ route('books.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Books</a>
                            </div>
                            
                            <!-- Book Metadata -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                                @if($book->genre)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Genre:</span>
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 ml-2">
                                            {{ $book->genre }}
                                        </span>
                                    </div>
                                @endif
                                
                                @if($book->published_year)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Published:</span>
                                        <span class="text-sm text-gray-900 ml-2">{{ $book->published_year }}</span>
                                    </div>
                                @endif
                                
                                @if($book->pages)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">Pages:</span>
                                        <span class="text-sm text-gray-900 ml-2">{{ $book->pages }}</span>
                                    </div>
                                @endif
                                
                                @if($book->isbn)
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">ISBN:</span>
                                        <span class="text-sm text-gray-900 ml-2">{{ $book->isbn }}</span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Rating -->
                            <div class="mb-6">
                                <div class="flex items-center space-x-4">
                                    <div class="text-2xl text-yellow-400">
                                        @if($book->reviews()->count() > 0)
                                            {{ str_repeat('⭐', round($book->reviews()->avg('stars'))) }}
                                            <span class="text-lg text-gray-600 ml-2">
                                                {{ number_format($book->reviews()->avg('stars'), 1) }}/5
                                            </span>
                                        @else
                                            <span class="text-gray-400">No ratings yet</span>
                                        @endif
                                    </div>
                                    <span class="text-sm text-gray-500">({{ $book->reviews()->count() }} reviews)</span>
                                </div>
                            </div>
                            
                            <!-- Library Actions -->
                            @auth
                                <div class="mb-6">
                                    @if($userBook)
                                        <div class="flex items-center space-x-4">
                                            <span class="text-green-600 font-medium">✓ In your library</span>
                                            <form method="POST" action="{{ route('library.update', $book) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <select name="status" onchange="this.form.submit()" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm text-sm">
                                                    <option value="want_to_read" {{ $userBook->pivot->status === 'want_to_read' ? 'selected' : '' }}>Want to Read</option>
                                                    <option value="currently_reading" {{ $userBook->pivot->status === 'currently_reading' ? 'selected' : '' }}>Currently Reading</option>
                                                    <option value="read" {{ $userBook->pivot->status === 'read' ? 'selected' : '' }}>Read</option>
                                                </select>
                                            </form>
                                            <form method="POST" action="{{ route('library.destroy', $book) }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Remove this book from your library?')">
                                                    Remove from Library
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="flex space-x-2">
                                            <form method="POST" action="{{ route('library.store') }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                <input type="hidden" name="status" value="want_to_read">
                                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                    📚 Want to Read
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('library.store') }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                <input type="hidden" name="status" value="currently_reading">
                                                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                    📖 Currently Reading
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('library.store') }}" class="inline">
                                                @csrf
                                                <input type="hidden" name="book_id" value="{{ $book->id }}">
                                                <input type="hidden" name="status" value="read">
                                                <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                                                    ✅ Read
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <div class="mb-6 p-4 bg-blue-50 rounded-lg">
                                    <p class="text-blue-800">
                                        <a href="{{ route('login') }}" class="font-medium underline">Sign in</a> to add this book to your library and write reviews!
                                    </p>
                                </div>
                            @endauth
                            
                            <!-- Description -->
                            @if($book->description)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                                    <p class="text-gray-700 leading-relaxed">{{ $book->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Write Review Section -->
            @auth
                @php
                    $userReview = $book->reviews()->where('user_id', auth()->id())->first();
                @endphp

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        @if($userReview)
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Your Review</h3>
                            <div class="bg-blue-50 rounded-lg p-4 mb-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="text-yellow-400 text-lg">{{ str_repeat('⭐', $userReview->stars) }}</div>
                                    <span class="text-sm text-gray-500">{{ $userReview->created_at->diffForHumans() }}</span>
                                </div>
                                @if($userReview->review)
                                    <p class="text-gray-700">{{ $userReview->review }}</p>
                                @endif
                            </div>

                            <!-- Edit Review Form -->
                            <form method="POST" action="{{ route('reviews.update', $userReview) }}" class="space-y-4" x-data="{ editing: false }">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="book_id" value="{{ $book->id }}">

                                <div x-show="!editing">
                                    <button type="button" @click="editing = true" class="text-blue-600 hover:text-blue-800 font-medium">
                                        ✏️ Edit Review
                                    </button>
                                </div>

                                <div x-show="editing" class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                                        <div class="flex space-x-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <input type="radio" name="stars" value="{{ $i }}" id="edit-star-{{ $i }}" class="sr-only" {{ $userReview->stars == $i ? 'checked' : '' }}>
                                                <label for="edit-star-{{ $i }}" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400 transition-colors">⭐</label>
                                            @endfor
                                        </div>
                                    </div>

                                    <div>
                                        <label for="edit-review" class="block text-sm font-medium text-gray-700 mb-2">Review (optional)</label>
                                        <textarea name="review" id="edit-review" rows="4" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Share your thoughts about this book...">{{ $userReview->review }}</textarea>
                                    </div>

                                    <div class="flex space-x-3">
                                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            ✨ Update Review
                                        </button>
                                        <button type="button" @click="editing = false" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('reviews.destroy', $userReview) }}" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Are you sure you want to delete your review?')">
                                    🗑️ Delete Review
                                </button>
                            </form>
                        @else
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Write a Review</h3>
                            <form method="POST" action="{{ route('reviews.store') }}" class="space-y-4">
                                @csrf
                                <input type="hidden" name="book_id" value="{{ $book->id }}">

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating *</label>
                                    <div class="flex space-x-1" x-data="{ rating: 0 }">
                                        @for($i = 1; $i <= 5; $i++)
                                            <input type="radio" name="stars" value="{{ $i }}" id="star-{{ $i }}" class="sr-only" x-model="rating">
                                            <label for="star-{{ $i }}" class="cursor-pointer text-2xl transition-colors" :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300'" @click="rating = {{ $i }}">⭐</label>
                                        @endfor
                                    </div>
                                    @error('stars')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="review" class="block text-sm font-medium text-gray-700 mb-2">Review (optional)</label>
                                    <textarea name="review" id="review" rows="4" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" placeholder="Share your thoughts about this book...">{{ old('review') }}</textarea>
                                    @error('review')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 font-medium">
                                    ⭐ Submit Review
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endauth

            <!-- Reviews Section -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Reviews ({{ $book->reviews()->count() }})</h2>

                    @if($book->reviews()->count() > 0)
                        <div class="space-y-6">
                            @foreach($book->reviews as $review)
                                <div class="border-b border-gray-200 pb-6 last:border-b-0">
                                    <div class="flex items-start space-x-4">
                                        <img src="{{ $review->user->profile_photo_url }}" alt="{{ $review->user->name }}" class="w-12 h-12 rounded-full object-cover">
                                        <div class="flex-1">
                                            <div class="flex items-center justify-between mb-2">
                                                <div>
                                                    <h4 class="font-medium text-gray-900">
                                                        <a href="{{ route('profile.show', $review->user) }}" class="hover:text-blue-600">
                                                            {{ $review->user->name }}
                                                        </a>
                                                    </h4>
                                                    <div class="text-yellow-400">{{ str_repeat('⭐', $review->stars) }}</div>
                                                </div>
                                                <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                            </div>
                                            @if($review->review)
                                                <p class="text-gray-700">{{ $review->review }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-4xl mb-4">⭐</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No reviews yet</h3>
                            <p class="text-gray-500">Be the first to review this book!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Interactive star rating for new reviews
        document.addEventListener('DOMContentLoaded', function() {
            const starInputs = document.querySelectorAll('input[name="stars"]');
            const starLabels = document.querySelectorAll('label[for^="star-"]');

            starLabels.forEach((label, index) => {
                label.addEventListener('mouseenter', function() {
                    highlightStars(index + 1);
                });

                label.addEventListener('click', function() {
                    starInputs[index].checked = true;
                });
            });

            // For edit form
            const editStarInputs = document.querySelectorAll('input[name="stars"][id^="edit-star"]');
            const editStarLabels = document.querySelectorAll('label[for^="edit-star-"]');

            editStarLabels.forEach((label, index) => {
                label.addEventListener('mouseenter', function() {
                    highlightEditStars(index + 1);
                });

                label.addEventListener('click', function() {
                    editStarInputs[index].checked = true;
                    highlightEditStars(index + 1);
                });
            });

            function highlightStars(rating) {
                starLabels.forEach((label, index) => {
                    if (index < rating) {
                        label.classList.remove('text-gray-300');
                        label.classList.add('text-yellow-400');
                    } else {
                        label.classList.remove('text-yellow-400');
                        label.classList.add('text-gray-300');
                    }
                });
            }

            function highlightEditStars(rating) {
                editStarLabels.forEach((label, index) => {
                    if (index < rating) {
                        label.classList.remove('text-gray-300');
                        label.classList.add('text-yellow-400');
                    } else {
                        label.classList.remove('text-yellow-400');
                        label.classList.add('text-gray-300');
                    }
                });
            }
        });
    </script>
</x-public-layout>
