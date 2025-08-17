<x-public-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Profile Header -->
                    <div class="flex flex-col md:flex-row items-start md:items-center space-y-4 md:space-y-0 md:space-x-6 mb-8">
                        <div class="flex-shrink-0">
                            <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-32 h-32 rounded-full object-cover border-4 border-gray-200">
                        </div>
                        <div class="flex-1">
                            <h1 class="text-3xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-lg text-gray-600">@{{ $user->username }}</p>
                            @if($user->birthday)
                                <p class="text-sm text-gray-500 mt-1">
                                    🎂 Born {{ $user->birthday->format('F j, Y') }}
                                    ({{ $user->birthday->age }} years old)
                                </p>
                            @endif
                            <div class="flex items-center space-x-4 mt-3">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                    📚 Book Lover
                                </span>
                                @if($user->isAdmin())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        👑 Admin
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- About Me Section -->
                    @if($user->about_me)
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 mb-3">About Me</h2>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-700 leading-relaxed">{{ $user->about_me }}</p>
                            </div>
                        </div>
                    @endif

                    <!-- Reading Stats -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-blue-50 rounded-lg p-6 text-center">
                            <div class="text-3xl font-bold text-blue-600">{{ $user->books()->count() }}</div>
                            <div class="text-sm text-blue-800 font-medium">Books in Library</div>
                        </div>
                        <div class="bg-green-50 rounded-lg p-6 text-center">
                            <div class="text-3xl font-bold text-green-600">{{ $user->reviews()->count() }}</div>
                            <div class="text-sm text-green-800 font-medium">Reviews Written</div>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-6 text-center">
                            <div class="text-3xl font-bold text-purple-600">{{ $user->books()->wherePivot('status', 'read')->count() }}</div>
                            <div class="text-sm text-purple-800 font-medium">Books Read</div>
                        </div>
                    </div>

                    <!-- Recent Reviews -->
                    @if($user->reviews()->count() > 0)
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Reviews</h2>
                            <div class="space-y-4">
                                @foreach($user->reviews()->with('book')->latest()->take(3)->get() as $review)
                                    <div class="border rounded-lg p-4 bg-gray-50">
                                        <div class="flex items-start space-x-4">
                                            <img src="{{ $review->book->cover_image_url }}" alt="{{ $review->book->title }}" class="w-16 h-20 object-cover rounded">
                                            <div class="flex-1">
                                                <h3 class="font-semibold text-gray-900">{{ $review->book->title }}</h3>
                                                <p class="text-sm text-gray-600">by {{ $review->book->author }}</p>
                                                <div class="flex items-center mt-2">
                                                    <div class="text-yellow-400">{{ $review->stars }}</div>
                                                    <span class="ml-2 text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                                </div>
                                                @if($review->review)
                                                    <p class="mt-2 text-gray-700 text-sm">{{ Str::limit($review->review, 150) }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Currently Reading -->
                    @php
                        $currentlyReading = $user->books()->wherePivot('status', 'currently_reading')->get();
                    @endphp
                    @if($currentlyReading->count() > 0)
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Currently Reading</h2>
                            <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
                                @foreach($currentlyReading as $book)
                                    <div class="text-center">
                                        <img src="{{ $book->cover_image_url }}" alt="{{ $book->title }}" class="w-full h-32 object-cover rounded-lg shadow-md">
                                        <p class="text-sm font-medium text-gray-900 mt-2">{{ Str::limit($book->title, 20) }}</p>
                                        <p class="text-xs text-gray-600">{{ Str::limit($book->author, 20) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Contact/Edit Button -->
                    <div class="text-center pt-6 border-t border-gray-200">
                        @auth
                            @if(auth()->id() === $user->id)
                                <a href="{{ route('profile.edit') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    ✏️ Edit My Profile
                                </a>
                            @else
                                <p class="text-gray-600">
                                    Want to connect? Send {{ $user->name }} a message through our contact form!
                                </p>
                            @endif
                        @else
                            <p class="text-gray-600">
                                <a href="{{ route('register') }}" class="text-blue-600 hover:text-blue-800 underline">Join our community</a> 
                                to connect with {{ $user->name }} and other book lovers!
                            </p>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
