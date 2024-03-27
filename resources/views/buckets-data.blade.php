<!-- buckets-data.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buckets') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                   
                    <!-- Replace this with your reports content -->
                    <h3 class="text-lg font-semibold mb-4">Buckets</h3>
                    <p>This is a placeholder for the content of your buckets page. You can add your buckets data here.</p>
                    <!-- End of reports content -->
                </div>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
        <a href="{{ url()->previous() }}" class="btn btn-primary">&lt; Back</a>
    </div>
</x-app-layout>
