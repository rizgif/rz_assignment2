<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Transactions') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Display CRUD buttons -->
                    <div class="mb-4">
                        <x-primary-button>
                        <a href="{{ route('transactions.create') }}" class="btn btn-primary">Add Transaction</a>
                        </x-primary-button>
                    </div>
                    <!-- Display transactions data -->
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Amount</th>

                                <!-- Add other columns if needed -->
                                <th>Actions</th> <!-- Add Actions column -->
                            </tr>
                        </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($transactions as $transaction)
                                <tr>
                                    <td>{{ $transaction->date }}</td>
                                    <td>{{ $transaction->name }}</td>
                                    <td>{{ $transaction->amount }}</td>

                                    <!-- Add other columns if needed -->
                                    <td>
                                        <!-- Edit Button -->
                                        <x-secondary-button>
                                            <a href="{{ route('transactions.edit', $transaction->id) }}"
                                                class="btn btn-primary">Edit</a>
                                        </x-secondary-button>
                                        <!-- Delete Button -->
                                        <form action="{{ route('transactions.destroy', $transaction->id) }}"
                                            method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <x-danger-button type="submit">
                                                {{ __('Delete') }}
                                            </x-danger-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
        <x-primary-button type="submit">
        <a href="{{ url()->previous() }}" class="btn btn-primary">Back</a>
        </x-primary-button>
    </div>
</x-app-layout>
