<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                📧 {{ $contact->subject }}
            </h2>
            <a href="{{ route('admin.contacts.index') }}" class="text-blue-600 hover:text-blue-800">← Back to Messages</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Message Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Header -->
                    <div class="border-b border-gray-200 pb-4 mb-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="text-2xl font-bold text-gray-900 mb-2">{{ $contact->subject }}</h3>
                                <div class="flex items-center space-x-4 text-sm text-gray-600">
                                    <span><strong>From:</strong> {{ $contact->name }}</span>
                                    <span><strong>Email:</strong> 
                                        <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-800">{{ $contact->email }}</a>
                                    </span>
                                    <span><strong>Sent:</strong> {{ $contact->created_at->format('F j, Y \a\t g:i A') }}</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                @if(!$contact->is_read)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                        🆕 New Message
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                        ✅ Read
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Message Content -->
                    <div class="mb-6">
                        <h4 class="text-lg font-semibold text-gray-900 mb-3">Message:</h4>
                        <div class="bg-gray-50 rounded-lg p-4 border">
                            <p class="text-gray-700 whitespace-pre-wrap leading-relaxed">{{ $contact->message }}</p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-200">
                        <div class="flex space-x-3">
                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                📧 Reply via Email
                            </a>
                            <form method="POST" action="{{ route('admin.contacts.toggle-read', $contact) }}" class="inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition duration-150 ease-in-out">
                                    {{ $contact->is_read ? '📭 Mark as Unread' : '✅ Mark as Read' }}
                                </button>
                            </form>
                        </div>
                        <form method="POST" action="{{ route('admin.contacts.destroy', $contact) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this message? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                                🗑️ Delete Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="mt-6 bg-blue-50 rounded-lg p-6">
                <h4 class="text-lg font-semibold text-blue-900 mb-3">💡 Quick Actions</h4>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <h5 class="font-medium text-blue-800 mb-2">Email Templates</h5>
                        <div class="space-y-2">
                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}&body=Hi {{ $contact->name }},%0D%0A%0D%0AThank you for contacting Book Club Community. We appreciate your message and will get back to you soon.%0D%0A%0D%0ABest regards,%0D%0ABook Club Community Team" 
                               class="block text-sm text-blue-600 hover:text-blue-800">📧 Thank you reply</a>
                            <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}&body=Hi {{ $contact->name }},%0D%0A%0D%0AThank you for your question about Book Club Community. Here's the information you requested:%0D%0A%0D%0A[Your response here]%0D%0A%0D%0ABest regards,%0D%0ABook Club Community Team" 
                               class="block text-sm text-blue-600 hover:text-blue-800">❓ Question response</a>
                        </div>
                    </div>
                    <div>
                        <h5 class="font-medium text-blue-800 mb-2">Message Info</h5>
                        <div class="text-sm text-blue-700">
                            <p><strong>Received:</strong> {{ $contact->created_at->diffForHumans() }}</p>
                            <p><strong>Status:</strong> {{ $contact->is_read ? 'Read' : 'Unread' }}</p>
                            <p><strong>Message ID:</strong> #{{ $contact->id }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
