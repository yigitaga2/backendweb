<x-public-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center">
                        <div>
                            <h1 class="text-3xl font-bold text-gray-900">❓ Frequently Asked Questions</h1>
                            <p class="text-gray-600 mt-2">Find answers to common questions about our book community</p>
                        </div>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.faq.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    ➕ Add FAQ
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            </div>

            <!-- FAQ List -->
            @if($faqs->count() > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="divide-y divide-gray-200">
                        @foreach($faqs as $faq)
                            <div class="p-6" x-data="{ open: false }">
                                <div class="flex justify-between items-start">
                                    <button @click="open = !open" class="flex-1 text-left focus:outline-none group">
                                        <div class="flex items-center justify-between">
                                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition duration-150">
                                                {{ $faq->question }}
                                            </h3>
                                            <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </div>
                                    </button>
                                    
                                    @auth
                                        @if(auth()->user()->isAdmin())
                                            <div class="flex space-x-2 ml-4">
                                                <a href="{{ route('faq.edit', $faq) }}" class="text-gray-500 hover:text-blue-600 transition duration-150">
                                                    ✏️
                                                </a>
                                                <form method="POST" action="{{ route('faq.destroy', $faq) }}" class="inline" onsubmit="return confirm('Are you sure you want to delete this FAQ?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-500 hover:text-red-600 transition duration-150">
                                                        🗑️
                                                    </button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                                
                                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform scale-100" x-transition:leave-end="opacity-0 transform scale-95" class="mt-4">
                                    <div class="prose prose-gray max-w-none">
                                        {!! nl2br(e($faq->answer)) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-12 text-center">
                        <div class="text-6xl mb-4">❓</div>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">No FAQs Yet</h2>
                        <p class="text-gray-600 mb-6">We're working on building a comprehensive FAQ section to help answer your questions!</p>
                        @auth
                            @if(auth()->user()->isAdmin())
                                <a href="{{ route('admin.faq.create') }}" class="inline-flex items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    ➕ Create First FAQ
                                </a>
                            @endif
                        @endauth
                    </div>
                </div>
            @endif

            <!-- Help Section -->
            <div class="mt-8 bg-blue-50 rounded-lg p-6">
                <h2 class="text-lg font-semibold text-blue-900 mb-2">Still have questions?</h2>
                <p class="text-blue-800 mb-4">Can't find what you're looking for? We're here to help!</p>
                <a href="{{ route('contact.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                    📧 Contact us →
                </a>
            </div>
        </div>
    </div>

    <script>
        // Auto-expand first FAQ if there's only one
        document.addEventListener('DOMContentLoaded', function() {
            const faqs = document.querySelectorAll('[x-data]');
            if (faqs.length === 1) {
                // This would auto-expand the first FAQ, but Alpine.js handles it
            }
        });
    </script>
</x-public-layout>
