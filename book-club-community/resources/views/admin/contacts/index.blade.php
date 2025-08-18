<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📧 {{ __('Contact Messages') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filters -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form method="GET" action="{{ route('admin.contacts.index') }}" class="flex flex-col md:flex-row gap-4">
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search messages by name, email, subject, or content..." class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        </div>
                        <div>
                            <select name="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">All Messages</option>
                                <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread Only</option>
                                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read Only</option>
                            </select>
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                🔍 Search
                            </button>
                            <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Messages List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-900">Messages ({{ $contacts->total() }})</h3>
                    </div>

                    @if($contacts->count() > 0)
                        <div class="space-y-4">
                            @foreach($contacts as $contact)
                                <div class="border rounded-lg p-4 {{ $contact->is_read ? 'bg-gray-50' : 'bg-blue-50 border-blue-200' }}">
                                    <div class="flex justify-between items-start">
                                        <div class="flex-1">
                                            <div class="flex items-center space-x-3 mb-2">
                                                <h4 class="text-lg font-semibold text-gray-900">{{ $contact->subject }}</h4>
                                                @if(!$contact->is_read)
                                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                        🆕 New
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="flex items-center space-x-4 text-sm text-gray-600 mb-3">
                                                <span><strong>From:</strong> {{ $contact->name }}</span>
                                                <span><strong>Email:</strong> {{ $contact->email }}</span>
                                                <span><strong>Sent:</strong> {{ $contact->created_at->format('M j, Y \a\t g:i A') }}</span>
                                            </div>
                                            <p class="text-gray-700">{{ Str::limit($contact->message, 200) }}</p>
                                        </div>
                                        <div class="flex flex-col space-y-2 ml-4">
                                            <a href="{{ route('admin.contacts.show', $contact) }}" class="px-3 py-1 bg-blue-600 text-white rounded text-sm hover:bg-blue-700 text-center">
                                                View Full
                                            </a>
                                            <form method="POST" action="{{ route('admin.contacts.toggle-read', $contact) }}" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="w-full px-3 py-1 bg-gray-600 text-white rounded text-sm hover:bg-gray-700">
                                                    {{ $contact->is_read ? 'Mark Unread' : 'Mark Read' }}
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this message?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="w-full px-3 py-1 bg-red-600 text-white rounded text-sm hover:bg-red-700">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $contacts->withQueryString()->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="text-6xl mb-4">📧</div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No messages found</h3>
                            <p class="text-gray-500">
                                @if(request()->filled('search') || request()->filled('status'))
                                    Try adjusting your search criteria.
                                @else
                                    No contact messages have been received yet.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
