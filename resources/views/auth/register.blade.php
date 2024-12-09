<x-guest-layout>
    <form method="POST" action="{{ route('register') }}" class="max-w-lg mx-auto p-6">
        @csrf
    
        <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">{{ __('Register') }}</h2>
    
        <div class="grid grid-cols-1 gap-4">
            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
    
            <!-- Username -->
            <div>
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>
    
            <!-- Email Address -->
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>
    
            <!-- Phone Number -->
            <div>
                <x-input-label for="phoneNum" :value="__('Phone Number')" />
                <x-text-input id="phoneNum" class="block mt-1 w-full" type="text" name="phoneNum" :value="old('phoneNum')" required autocomplete="tel" />
                <x-input-error :messages="$errors->get('phoneNum')" class="mt-2" />
            </div>
    
            <!-- Role -->
            <div>
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" class="block mt-1 w-full rounded-md border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="" {{ old('role') == '' ? 'selected' : '' }}>Select Role</option>
                    <option value="kafa" {{ old('role') == 'kafa' ? 'selected' : '' }}>KAFA</option>
                    <option value="muip" {{ old('role') == 'muip' ? 'selected' : '' }}>MUIP</option>
                    <option value="guardian" {{ old('role') == 'guardian' ? 'selected' : '' }}>Guardian</option>
                    <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>
            
    
            <!-- IC Number -->
            <div>
                <x-input-label for="icNum" :value="__('IC Number')" />
                <x-text-input id="icNum" class="block mt-1 w-full" type="text" name="icNum" :value="old('icNum')" required autocomplete="icNum" />
                <x-input-error :messages="$errors->get('icNum')" class="mt-2" />
            </div>
    
            <!-- Address -->
            <div>
                <x-input-label for="address" :value="__('Address')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" :value="old('address')" required autocomplete="address" />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>
    
            <!-- Gender -->
            <div>
                <x-input-label for="gender" :value="__('Gender')" />
                <select id="gender" name="gender" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    <option value="">{{ __('Select Gender') }}</option>
                    <option value="male">{{ __('Male') }}</option>
                    <option value="female">{{ __('Female') }}</option>
                    <option value="other">{{ __('Other') }}</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>
    
            <!-- Race -->
            <div>
                <x-input-label for="race" :value="__('Race')" />
                <x-text-input id="race" class="block mt-1 w-full" type="text" name="race" :value="old('race')" required autocomplete="race" />
                <x-input-error :messages="$errors->get('race')" class="mt-2" />
            </div>
    
            <!-- Age -->
            <div>
                <x-input-label for="age" :value="__('Age')" />
                <x-text-input id="age" class="block mt-1 w-full" type="number" name="age" :value="old('age')" required autocomplete="age" />
                <x-input-error :messages="$errors->get('age')" class="mt-2" />
            </div>
    
            <!-- Password -->
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>
    
            <!-- Confirm Password -->
            <div>
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>
    
        <div class="flex items-center justify-end mt-6">
            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
    
            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
    
</x-guest-layout>
