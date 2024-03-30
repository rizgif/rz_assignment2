<!-- reports.blade.php -->

<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Report') }}
      </h2>
  </x-slot>

  <div class="py-6">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900">
                  <!-- Add a form to select the year and generate report -->
                  <form action="{{ route('reports.generate') }}" method="GET">
                      @csrf
                      <div class="mb-4">
                          <label for="year" class="block text-sm font-medium text-gray-700">Select Year:</label>
                          <select name="year" id="year" class="form-select mt-1 block w-full">
                              @foreach ($years as $year)
                                  <option value="{{ $year }}">{{ $year }}</option>
                              @endforeach
                          </select>
                      </div>
                      <button type="submit" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Generate Report</button>
                  </form>
                  <!-- End of form -->
              </div>
          </div>
      </div>
  </div>
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-4">
      <a href="{{ url()->previous() }}" class="btn btn-primary">&lt; Back</a>
  </div>
</x-app-layout>
