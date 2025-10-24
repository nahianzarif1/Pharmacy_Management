<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Medicine</h2>
            <a href="{{ route('medicines.show', $medicine) }}" class="text-sm text-gray-600 hover:text-gray-900">Back to details</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-alert />

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('medicines.update', $medicine) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Medicine Name</label>
                            <input id="name" name="name" type="text" required value="{{ old('name', $medicine->name) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="generic_name" class="block text-sm font-medium text-gray-700">Generic Name</label>
                            <input id="generic_name" name="generic_name" type="text" value="{{ old('generic_name', $medicine->generic_name) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('generic_name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="medicine_type_id" class="block text-sm font-medium text-gray-700">Medicine Type</label>
                            <select id="medicine_type_id" name="medicine_type_id" required class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach($medicineTypes as $type)
                                    <option value="{{ $type->id }}" {{ $type->id == old('medicine_type_id', $medicine->medicine_type_id) ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('medicine_type_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                            <input id="unit" name="unit" type="text" value="{{ old('unit', $medicine->unit) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('unit') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="strength" class="block text-sm font-medium text-gray-700">Strength</label>
                            <input id="strength" name="strength" type="text" value="{{ old('strength', $medicine->strength) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('strength') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="price_per_unit" class="block text-sm font-medium text-gray-700">Price per Unit</label>
                            <input id="price_per_unit" name="price_per_unit" type="number" step="0.01" required value="{{ old('price_per_unit', $medicine->price_per_unit) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('price_per_unit') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label for="reorder_level" class="block text-sm font-medium text-gray-700">Reorder Level</label>
                            <input id="reorder_level" name="reorder_level" type="number" value="{{ old('reorder_level', $medicine->reorder_level) }}" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                            @error('reorder_level') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="col-span-1 md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded border-gray-300 shadow-sm focus:ring-indigo-500 focus:border-indigo-500">{{ old('description', $medicine->description) }}</textarea>
                            @error('description') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-6 space-x-3">
                        <a href="{{ route('medicines.show', $medicine) }}" class="px-4 py-2 bg-gray-200 rounded text-sm text-gray-700">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">Update Medicine</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
