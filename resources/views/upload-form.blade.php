<!-- uploades.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Uploads') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 ">
                    <!-- upload-form.blade.php -->

                    <form action="{{ route('upload') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="csv_files[]" multiple>
                        <button type="submit">Upload</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <!-- Back Button -->


    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
        <x-primary-button type="submit">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        </x-primary-button>
    </div>
</x-app-layout>
