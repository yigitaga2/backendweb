<x-public-layout>
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">
                    Welcome to Book Club Community
                </h1>
                <p class="text-xl md:text-2xl mb-8 text-blue-100">
                    Discover, discuss, and share your love for books with fellow readers
                </p>
                <div class="space-x-4">
                    @guest
                        <a href="{{ route('register') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition duration-300">
                            Join Our Community
                        </a>
                        <a href="{{ route('login') }}" class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition duration-300">
                            Sign In
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition duration-300">
                            Go to Dashboard
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">What We Offer</h2>
                <p class="text-lg text-gray-600">Everything you need to enhance your reading experience</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6">
                    <div class="bg-blue-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C20.832 18.477 19.246 18 17.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Extensive Book Catalog</h3>
                    <p class="text-gray-600">Browse through thousands of books across all genres and discover your next favorite read.</p>
                </div>

                <div class="text-center p-6">
                    <div class="bg-green-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Community Reviews</h3>
                    <p class="text-gray-600">Share your thoughts and read reviews from other book lovers to make informed reading choices.</p>
                </div>

                <div class="text-center p-6">
                    <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2">Personal Reading Lists</h3>
                    <p class="text-gray-600">Keep track of books you want to read, are currently reading, and have completed.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest News Section -->
    <div class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Latest Book News</h2>
                <p class="text-lg text-gray-600">Stay updated with the latest from the literary world</p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Placeholder news items -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gradient-to-r from-blue-400 to-blue-600"></div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">Welcome to Our Community!</h3>
                        <p class="text-gray-600 mb-4">Join thousands of book lovers in our growing community. Share reviews, discover new books, and connect with fellow readers.</p>
                        <span class="text-sm text-gray-500">Just now</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gradient-to-r from-green-400 to-green-600"></div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">Reading Challenge 2025</h3>
                        <p class="text-gray-600 mb-4">Set your reading goals for the year and track your progress. Challenge yourself to read more books than ever before!</p>
                        <span class="text-sm text-gray-500">2 days ago</span>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="h-48 bg-gradient-to-r from-purple-400 to-purple-600"></div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-2">Book Club Features</h3>
                        <p class="text-gray-600 mb-4">Explore all the amazing features our platform offers, from personal reading lists to community discussions.</p>
                        <span class="text-sm text-gray-500">1 week ago</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>