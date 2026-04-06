<x-guest-layout>
    <div class="flex flex-col lg:flex-row min-h-screen bg-black relative">

        {{-- COLUMNA IZQUIERDA (COLLAGE) --}}
        <div class="absolute inset-0 lg:relative lg:flex lg:w-1/2 z-0">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/login-collage.png') }}" alt="Movie Collage"
                    class="w-full h-full object-cover opacity-40 lg:opacity-60">
                <div
                    class="absolute inset-0 bg-black/70 lg:bg-transparent lg:bg-gradient-to-r lg:from-transparent lg:via-transparent lg:to-black">
                </div>
            </div>
        </div>

        {{-- COLUMNA DERECHA: FORMULARIO --}}
        <div class="w-full lg:w-1/2 flex flex-col bg-transparent lg:bg-black relative z-20 min-h-screen">

            {{--
        Este contenedor interno es el secreto:
        - 'flex-grow' toma todo el espacio.
        - 'items-center' y 'justify-center' centran el contenido.
        - 'pt-24' (o pt-32) asegura que el contenido no empiece debajo del Nav.
    --}}
            <div class="flex-grow flex flex-col justify-center items-center px-8 md:px-16 lg:px-24 pt-24 pb-12">

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="max-w-md w-full mx-auto space-y-5">
                    @csrf

                    <div class="mb-8 text-center lg:text-left">
                        <p class="text-gray-400 text-xs uppercase tracking-[0.3em] font-black mb-2 opacity-70">
                            ¡Bienvenido de Nuevo!
                        </p>
                        <h2 class="text-4xl md:text-5xl font-black text-white tracking-tighter uppercase leading-none">
                            INICIAR <span class="text-red-600">SESIÓN</span>
                        </h2>
                    </div>

                    {{-- Input Email --}}
                    <div class="space-y-2">
                        <label for="email"
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Correo
                            Electrónico:</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus
                            class="block w-full bg-gray-900/40 border border-gray-700 text-white focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all py-3.5 px-4 rounded-xl placeholder-gray-600"
                            placeholder="tu@correo.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500" />
                    </div>

                    {{-- Input Contraseña --}}
                    <div class="space-y-2">
                        <label for="password"
                            class="block text-[10px] font-black text-gray-400 uppercase tracking-widest">Contraseña:</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required
                                class="block w-full bg-gray-900/40 border border-gray-700 text-white focus:ring-2 focus:ring-red-600 focus:border-transparent transition-all py-3.5 px-4 pr-12 rounded-xl placeholder-gray-600"
                                placeholder="••••••••">

                            <button type="button" onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 hover:text-red-500 transition-all">
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.644.75.75 0 01.127-.145c.427-.478 2.05-2.223 4.54-3.535C8.357 6.963 10.457 6.25 12 6.25s3.643.713 5.3 1.742c2.49 1.312 4.113 3.057 4.54 3.535a.75.75 0 01.127.145c.348.423.348.86 0 1.284-.427.478-2.05 2.223-4.54 3.535C15.643 17.037 13.543 17.75 12 17.75s-3.643-.713-5.3-1.742c-2.49-1.312-4.113-3.057-4.54-3.535a.75.75 0 01-.127-.145z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-500" />
                    </div>

                    <div class="flex justify-end pt-1">
                        @if (Route::has('password.request'))
                            <a class="text-[10px] font-black uppercase tracking-widest text-gray-500 hover:text-red-600 transition-colors"
                                href="{{ route('password.request') }}">
                                ¿Olvidaste tu clave?
                            </a>
                        @endif
                    </div>

                    <div class="pt-4">
                        <button type="submit"
                            class="w-full bg-red-700 hover:bg-red-600 text-white font-black py-4 rounded-xl transition-all shadow-lg shadow-red-900/20 transform hover:-translate-y-1 uppercase tracking-widest text-[11px]">
                            INICIAR SESIÓN
                        </button>
                    </div>

                    <div class="pt-8 text-center">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-gray-600">
                            ¿No tienes una cuenta?
                            <a href="{{ route('register') }}"
                                class="text-red-500 hover:text-white transition-colors ml-2 underline underline-offset-4 decoration-red-900">
                                Regístrate gratis
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.822 7.822L21 21m-2.278-2.278L15.07 15.07M15.07 15.07a3.5 3.5 0 01-4.949-4.949l4.949 4.949z" />';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.644.75.75 0 01.127-.145c.427-.478 2.05-2.223 4.54-3.535C8.357 6.963 10.457 6.25 12 6.25s3.643.713 5.3 1.742c2.49 1.312 4.113 3.057 4.54 3.535a.75.75 0 01.127.145c.348.423.348.86 0 1.284-.427.478-2.05 2.223-4.54 3.535C15.643 17.037 13.543 17.75 12 17.75s-3.643-.713-5.3-1.742c-2.49-1.312-4.113-3.057-4.54-3.535a.75.75 0 01-.127-.145z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />';
            }
        }
    </script>
</x-guest-layout>
