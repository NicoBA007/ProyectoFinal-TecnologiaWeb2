<x-app-layout>

    <div class="py-12 bg-gray-950 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-gray-800 to-gray-700 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000">
                </div>

                <div class="relative p-6 sm:p-10 bg-gray-900 border border-gray-800 shadow-2xl sm:rounded-2xl">
                    <div class="max-w-xl">
                        <div class="flex items-center gap-2 mb-6 text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs font-bold uppercase tracking-widest">Datos de cuenta</span>
                        </div>
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>

            <div class="relative group">
                <div
                    class="absolute -inset-0.5 bg-gradient-to-r from-gray-800 to-gray-700 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000">
                </div>

                <div class="relative p-6 sm:p-10 bg-gray-900 border border-gray-800 shadow-2xl sm:rounded-2xl">
                    <div class="max-w-xl">
                        <div class="flex items-center gap-2 mb-6 text-red-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs font-bold uppercase tracking-widest">Seguridad</span>
                        </div>
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>

            <div class="relative">
                <div class="p-6 sm:p-10 bg-gray-950 border border-red-900/20 shadow-xl sm:rounded-2xl">
                    <div class="max-w-xl">
                        <div class="flex items-center gap-2 mb-6 text-red-800">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z"
                                    clip-rule="evenodd" />
                            </svg>
                            <span class="text-xs font-bold uppercase tracking-widest text-red-900">Zona Crítica</span>
                        </div>
                        <div class="opacity-75 hover:opacity-100 transition-opacity">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>