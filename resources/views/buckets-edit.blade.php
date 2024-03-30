<!-- resources/views/buckets/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Bucket') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Update Bucket Form -->
                    <form method="POST" action="{{ route('buckets.update', $bucket->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Category Input -->
                        <div class="mt-4">
                            <label for="category" class="block font-medium text-sm text-gray-700">Category:</label>
                            <input type="text" name="category" id="category" value="{{ $bucket->category }}"
                                required autofocus />
                        </div>

                        <!-- Description Input -->
                        <div class="mt-4">
                            <label for="description"
                                class="block font-medium text-sm text-gray-700">Description:</label>
                            <input type="text" name="description" id="description" value="{{ $bucket->description }}"
                                required />
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-4">
                                Update Bucket
                            </button>
                        </div>

                        <!-- Back Button -->
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
                            <x-primary-button type="submit">
                            <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
                            </x-primary-button>
                        </div>

                    </form>
                    <!-- End of Update Bucket Form -->


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
