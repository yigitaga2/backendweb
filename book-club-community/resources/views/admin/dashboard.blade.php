<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            👑 {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Users Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-3xl text-blue-600">👥</div>
                            <div class="ml-4">
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['total_users'] }}</div>
                                <div class="text-sm text-gray-600">Total Users</div>
                                <div class="text-xs text-green-600">+{{ $stats['new_users_this_month'] }} this month</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Books Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-3xl text-green-600">📚</div>
                            <div class="ml-4">
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['total_books'] }}</div>
                                <div class="text-sm text-gray-600">Total Books</div>
                                <div class="text-xs text-blue-600">{{ $stats['total_reviews'] }} reviews</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- News Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-3xl text-purple-600">📰</div>
                            <div class="ml-4">
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['published_news'] }}</div>
                                <div class="text-sm text-gray-600">Published News</div>
                                <div class="text-xs text-gray-500">{{ $stats['total_news'] }} total</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contacts Stats -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="text-3xl text-orange-600">📧</div>
                            <div class="ml-4">
                                <div class="text-2xl font-bold text-gray-900">{{ $stats['unread_contacts'] }}</div>
                                <div class="text-sm text-gray-600">Unread Messages</div>
                                <div class="text-xs text-gray-500">{{ $stats['total_contacts'] }} total</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">🚀 Quick Actions</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <a href="{{ route('admin.users.index') }}" class="flex flex-col items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition duration-150">
                            <div class="text-2xl text-blue-600 mb-2">👥</div>
                            <div class="text-sm font-medium text-blue-900">Manage Users</div>
                        </a>
                        <a href="{{ route('admin.contacts.index') }}" class="flex flex-col items-center p-4 bg-orange-50 rounded-lg hover:bg-orange-100 transition duration-150">
                            <div class="text-2xl text-orange-600 mb-2">📧</div>
                            <div class="text-sm font-medium text-orange-900">View Messages</div>
                        </a>
                        <a href="{{ route('admin.news.create') }}" class="flex flex-col items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition duration-150">
                            <div class="text-2xl text-purple-600 mb-2">📰</div>
                            <div class="text-sm font-medium text-purple-900">Create News</div>
                        </a>
                        <a href="{{ route('admin.faq.create') }}" class="flex flex-col items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition duration-150">
                            <div class="text-2xl text-green-600 mb-2">❓</div>
                            <div class="text-sm font-medium text-green-900">Add FAQ</div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Recent Users -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">👥 Recent Users</h3>
                        <div class="space-y-3">
                            @forelse($recent_users as $user)
                                <div class="flex items-center space-x-3">
                                    <img src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" class="w-10 h-10 rounded-full object-cover">
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                    <div class="text-xs text-gray-400">{{ $user->created_at->diffForHumans() }}</div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No recent users</p>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View all users →</a>
                        </div>
                    </div>
                </div>

                <!-- Recent Contact Messages -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📧 Recent Messages</h3>
                        <div class="space-y-3">
                            @forelse($recent_contacts as $contact)
                                <div class="border-l-4 {{ $contact->is_read ? 'border-gray-300' : 'border-blue-500' }} pl-3">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900">{{ $contact->subject }}</div>
                                            <div class="text-sm text-gray-600">from {{ $contact->name }}</div>
                                        </div>
                                        <div class="text-xs text-gray-400">{{ $contact->created_at->diffForHumans() }}</div>
                                    </div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-center py-4">No recent messages</p>
                            @endforelse
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('admin.contacts.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View all messages →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
