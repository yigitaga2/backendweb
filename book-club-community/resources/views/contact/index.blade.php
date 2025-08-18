<x-public-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-900">📧 Contact Us</h1>
                    <p class="text-gray-600 mt-2">Have a question or suggestion? We'd love to hear from you!</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Contact Form -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-xl font-semibold text-gray-900 mb-4">Send us a message</h2>
                        
                        <form method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                            @csrf

                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <!-- Email -->
                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                            </div>

                            <!-- Subject -->
                            <div>
                                <x-input-label for="subject" :value="__('Subject')" />
                                <x-text-input id="subject" name="subject" type="text" class="mt-1 block w-full" :value="old('subject')" required placeholder="What's this about?" />
                                <x-input-error class="mt-2" :messages="$errors->get('subject')" />
                            </div>

                            <!-- Message -->
                            <div>
                                <x-input-label for="message" :value="__('Message')" />
                                <textarea id="message" name="message" rows="6" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required placeholder="Tell us what's on your mind...">{{ old('message') }}</textarea>
                                <x-input-error class="mt-2" :messages="$errors->get('message')" />
                            </div>

                            <!-- Submit Button -->
                            <div>
                                <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                                    📧 Send Message
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="space-y-6">
                    <!-- Quick Info -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Get in touch</h2>
                            <div class="space-y-4">
                                <div class="flex items-start space-x-3">
                                    <div class="text-blue-600 text-xl">📧</div>
                                    <div>
                                        <h3 class="font-medium text-gray-900">Email</h3>
                                        <p class="text-gray-600">We'll respond within 24 hours</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <div class="text-green-600 text-xl">⚡</div>
                                    <div>
                                        <h3 class="font-medium text-gray-900">Quick Response</h3>
                                        <p class="text-gray-600">Most questions answered same day</p>
                                    </div>
                                </div>
                                <div class="flex items-start space-x-3">
                                    <div class="text-purple-600 text-xl">📚</div>
                                    <div>
                                        <h3 class="font-medium text-gray-900">Book Community</h3>
                                        <p class="text-gray-600">Join our growing community of readers</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- FAQ Link -->
                    <div class="bg-blue-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-blue-900 mb-2">Check our FAQ first</h3>
                        <p class="text-blue-800 mb-4">You might find your answer in our frequently asked questions.</p>
                        <a href="{{ route('faq.index') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                            ❓ Browse FAQ →
                        </a>
                    </div>

                    <!-- Community Info -->
                    <div class="bg-green-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-green-900 mb-2">Join our community</h3>
                        <p class="text-green-800 mb-4">Connect with fellow book lovers and discover your next great read.</p>
                        @guest
                            <a href="{{ route('register') }}" class="inline-flex items-center text-green-600 hover:text-green-800 font-medium">
                                🚀 Sign up now →
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-green-600 hover:text-green-800 font-medium">
                                📚 Go to dashboard →
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
