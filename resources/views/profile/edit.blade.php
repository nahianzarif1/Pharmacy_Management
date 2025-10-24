<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Left: user card -->
                <div class="lg:col-span-1">
                    <div class="bg-white p-6 rounded-lg shadow">
                        <div class="flex items-center space-x-4">
                            <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center text-2xl text-gray-500">{{ strtoupper(substr($user->full_name ?? $user->username,0,1)) }}</div>
                            <div>
                                <div class="text-lg font-semibold">{{ $user->full_name ?? $user->username }}</div>
                                <div class="text-sm text-gray-500">{{ '@' . $user->username }}</div>
                                <div class="mt-2 text-sm text-gray-600">{{ $user->email ?? 'No email provided' }}</div>
                            </div>
                        </div>

                        <div class="mt-6">
                            <h4 class="text-sm font-medium text-gray-700">Account</h4>
                            <ul class="mt-2 text-sm text-gray-600 space-y-1">
                                <li>Role: <strong class="text-gray-800">{{ ucfirst($user->role ?? 'pharmacist') }}</strong></li>
                                <li>Phone: <strong class="text-gray-800">{{ $user->phone ?? '-' }}</strong></li>
                                <li>Member since: <strong class="text-gray-800">{{ optional($user->created_at)->format('M d, Y') }}</strong></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Right: forms -->
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-6 rounded-lg shadow">
                        @include('profile.partials.update-profile-information-form')
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="bg-white p-6 rounded-lg shadow">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
