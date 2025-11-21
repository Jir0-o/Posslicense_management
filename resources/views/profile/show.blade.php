@extends('layouts.master')
@section('content')
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

        <!-- Wrapper for Dark Mode -->
    <div id="profile-container">
    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form')

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            <div class="mt-10 sm:mt-0">
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
    </div>
</x-app-layout>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // Check if dark mode is enabled
    const isDarkMode = document.body.classList.contains('dark-mode');

    // Apply dark mode styles to all necessary parts
    const elementsToStyle = [
        document.body,
        document.querySelector('header'),
        document.querySelector('.max-w-7xl'),
    ];

    elementsToStyle.forEach((el) => {
        if (isDarkMode && el) {
            el.classList.add('dark-mode');
        } else if (el) {
            el.classList.remove('dark-mode');
        }
    });
});
</script>
@endsection
