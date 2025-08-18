<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                👤 {{ $user->name }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Users</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- User Profile -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-start space-x-6">
                        <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-24 h-24 rounded-full object-cover">
                        <div class="flex-1">
                            <div class="flex items-center space-x-3 mb-2">
                                <h3 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h3>
                                @if($user->isAdmin())
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                        👑 Admin
                                    </span>
                                @endif
                            </div>
                            <div class="space-y-1 text-sm text-gray-600">
                                <p><strong>Email:</strong> {{ $user->email }}</p>
                                <p><strong>Username:</strong> @{{ $user->username }}</p>
                                @if($user->birthday)
                                    <p><strong>Birthday:</strong> {{ $user->birthday->format('F j, Y') }} ({{ $user->birthday->age }} years old)</p>
                                @endif
                                <p><strong>Joined:</strong> {{ $user->created_at->format('F j, Y') }} ({{ $user->created_at->diffForHumans() }})</p>
                            </div>
                            @if($user->about_me)
                                <div class="mt-4">
                                    <h4 class="font-medium text-gray-900 mb-2">About</h4>
                                    <p class="text-gray-700">{{ $user->about_me }}</p>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-col space-y-2">
                            <a href="{{ route('profile.show', $user) }}" target="_blank" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-center">
                                View Public Profile
                            </a>
                            @if($user->id !== auth()->id())
                                <form method="POST" action="{{ route('admin.users.toggle-admin', $user) }}" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                                        {{ $user->isAdmin() ? 'Remove Admin' : 'Make Admin' }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $user->books()->count() }}</div>
                        <div class="text-sm text-gray-600">Books in Library</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $user->reviews()->count() }}</div>
                        <div class="text-sm text-gray-600">Reviews Written</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-purple-600">{{ $user->books()->wherePivot('status', 'read')->count() }}</div>
                        <div class="text-sm text-gray-600">Books Read</div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-center">
                        <div class="text-3xl font-bold text-orange-600">{{ $user->books()->wherePivot('status', 'currently_reading')->count() }}</div>
                        <div class="text-sm text-gray-600">Currently Reading</div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Recent Reviews -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">⭐ Recent Reviews</h3>
                        <div class="space-y-4">
                            @forelse($user->reviews()->with('book')->latest()->take(5)->get() as $review)
                                <div class="border-l-4 border-blue-500 pl-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $review->book->title }}</h4>
                                            <div class="text-yellow-400">{{ str_repeat('⭐', $review->stars) }}</div>
                                            @if($review->review)
                                                <p class="text-sm text-gray-600 mt-1">{{ Str::limit($review->review, 100) }}</p>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No reviews yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Reading List -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📚 Reading List</h3>
                        <div class="space-y-4">
                            @forelse($user->books()->latest()->take(5)->get() as $book)
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $book->cover_image_url }}" alt="{{ $book->title }}" class="w-12 h-16 object-cover rounded">
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $book->title }}</h4>
                                        <p class="text-sm text-gray-600">by {{ $book->author }}</p>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                            @if($book->pivot->status === 'read') bg-green-100 text-green-800
                                            @elseif($book->pivot->status === 'currently_reading') bg-blue-100 text-blue-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $book->pivot->status)) }}
                                        </span>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No books in library yet</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
