
<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard HomeFix
            </h2>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    type="submit"
                    class="px-4 py-2 bg-red-600 hover:bg-red-700
                           text-white text-sm font-semibold rounded-lg
                           transition duration-200"
                >
                    Logout
                </button>
            </form>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Welcome Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-2">
                        Selamat Datang di HomeFix!
                    </h3>

                    <p class="text-gray-600 mb-4">
                        Halo, {{ Auth::user()->name }}.
                        Kamu berhasil login ke HomeFix.
                    </p>

                    <div class="inline-flex items-center px-3 py-2 rounded-lg
                                bg-blue-50 text-blue-700 text-sm font-medium">
                        Role: {{ ucfirst(Auth::user()->role) }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
