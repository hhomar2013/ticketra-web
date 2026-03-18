<div class="p-4">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users Managment') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @can('manage users')
                    @if (session()->has('message'))
                    <div class="bg-green-200 text-green-800 p-2 rounded mb-4">
                        {{ session('message') }}
                    </div>
                    @endif

                    <form wire:submit.prevent="{{ $editingUserId ? 'updateUser' : 'createUser' }}" class="mb-6">
                        <x-input-label for="name" value="{{ __('Name') }}" />
                        <x-text-input wire:model.live="name" id="name" class="form-control" type="text" name="name" required autofocus autocomplete="name" />
                        <br>
                        <x-input-label for="name" value="{{ __('Email') }}" />
                        <x-text-input wire:model.live="email" id="email" class="form-control" type="email" name="email" required autofocus autocomplete="username" />
                        <br>
                        @if (!$editingUserId)
                        <x-input-label for="password" value="{{ __('Password') }}" />
                        <x-text-input wire:model="password" id="password" class="form-control" type="password" name="password" required autocomplete="new-password" />
                        @endif
                        <br>
                        <x-input-label for="name" value="{{ __('Department') }}" />
                        <select wire:model.live="category_id" class="form-control">
                            <option value="">{{ __('Choose department') }}</option>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <br>
                        <x-input-label for="name" value="{{ __('Role') }}" />
                        <select wire:model.live="role" class="form-control">
                            <option value="">{{ __('Choose Role') }}</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                        <br><br>
                        {{-- <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded">
                            {{ $editingUserId ? __('Update') : __('Save') }}
                        </button> --}}

                        <x-primary-button class="ms-3">
                            {{ $editingUserId ? __('Update') : __('Save') }}
                        </x-primary-button>

                        @if($name || $email )
                        <button type="button" wire:click.prevent="resetForm()" class="btn btn-danger rounded">
                            {{ __('Cancel') }}
                        </button>
                        @endif
                    </form>

                    <div class="mb-4">
                        <label>{{ __('Sort By Role') }}:</label>
                        <select wire:model="searchRole" wire:change="loadUsers" class="form-control">
                            <option value="">{{ __('All') }}</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <table class="table-auto w-full bg-white dark:bg-gray-800 text-black dark:text-white">
                        <thead>
                            <tr>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Email') }}</th>
                                <th>{{__('Role')}}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->roles->pluck('name')->join(', ') }}</td>
                                <td>
                                    <button wire:click="editUser({{ $user->id }})" class="btn btn-warning rounded btn-sm">
                                        <i class="fa-solid fa-pen-nib"></i>
                                    </button>
                                    <button wire:click="deleteUser({{ $user->id }})" class="btn btn-danger rounded btn-sm">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <p class="text-red-600">{{ __('You need permission to open this page') }}</p>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
