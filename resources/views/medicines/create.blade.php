<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Add New Medicine') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg">
                <div class="px-6 py-6 sm:p-8">
                    @if ($errors->any())
                        <div class="mb-6">
                            <div class="font-medium text-red-600">{{ __('Please fix the following errors:') }}</div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    @if (isset($showTypeWarning) && $showTypeWarning)
                        <div class="mb-6 rounded-md bg-yellow-50 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-yellow-800">No Medicine Types Available</h3>
                                    <div class="mt-2 text-sm text-yellow-700">
                                        <p>Please <a href="{{ route('medicine-types.create') }}" class="font-medium underline hover:text-yellow-600">create a medicine type</a> first before adding a new medicine.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('medicines.store') }}" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="sku" class="block text-sm font-medium text-gray-700">SKU</label>
                                <div class="mt-1">
                                    <input id="sku" name="sku" type="text" value="{{ old('sku') }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Medicine Name</label>
                                <div class="mt-1">
                                    <input id="name" name="name" type="text" value="{{ old('name') }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label for="generic_name" class="block text-sm font-medium text-gray-700">Generic Name</label>
                            <div class="mt-1">
                                <input id="generic_name" name="generic_name" type="text" value="{{ old('generic_name') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="medicine_type_id" class="block text-sm font-medium text-gray-700">Medicine Type</label>
                            <div class="mt-1">
                                <select id="medicine_type_id" name="medicine_type_id" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    @foreach($medicineTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('medicine_type_id', $medicineTypes->first()->id) == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="unit" class="block text-sm font-medium text-gray-700">Unit</label>
                                <div class="mt-1">
                                    <input id="unit" name="unit" type="text" value="{{ old('unit') }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., tablet, bottle">
                                </div>
                            </div>

                            <div>
                                <label for="strength" class="block text-sm font-medium text-gray-700">Strength</label>
                                <div class="mt-1">
                                    <input id="strength" name="strength" type="text" value="{{ old('strength') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" placeholder="e.g., 500mg">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="price_per_unit" class="block text-sm font-medium text-gray-700">Price per Unit</label>
                                <div class="mt-1">
                                    <input id="price_per_unit" name="price_per_unit" type="number" step="0.01" min="0" value="{{ old('price_per_unit') }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div>
                                <label for="reorder_level" class="block text-sm font-medium text-gray-700">Reorder Level</label>
                                <div class="mt-1">
                                    <input id="reorder_level" name="reorder_level" type="number" min="0" value="{{ old('reorder_level', 0) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <input id="is_active" name="is_active" type="checkbox" value="1" class="h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label for="is_active" class="ml-2 block text-sm text-gray-700">Active</label>
                        </div>

                        <div class="flex items-center justify-end space-x-3">
                            <a href="{{ route('medicines.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Cancel</a>
                            <button type="submit"class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Create Medicine</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Type Modal (hidden by default) -->
    <div id="add-type-modal" class="fixed inset-0 z-40 hidden items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h3 class="text-lg font-medium mb-4">Add Medicine Type</h3>
            <div id="add-type-errors" class="text-sm text-red-600 mb-2"></div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input id="new-type-name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Description (optional)</label>
                <textarea id="new-type-description" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"></textarea>
            </div>
            <div class="flex justify-end space-x-3">
                <button id="cancel-add-type" class="px-4 py-2 rounded-md bg-white border border-gray-300 text-sm">Cancel</button>
                <button id="save-add-type" class="px-4 py-2 rounded-md bg-indigo-600 text-white text-sm">Save</button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addBtn = document.getElementById('add-type-btn');
            const modal = document.getElementById('add-type-modal');
            const cancelBtn = document.getElementById('cancel-add-type');
            const saveBtn = document.getElementById('save-add-type');
            const nameInput = document.getElementById('new-type-name');
            const descInput = document.getElementById('new-type-description');
            const errorsDiv = document.getElementById('add-type-errors');
            const select = document.getElementById('medicine_type_id');

            addBtn.addEventListener('click', () => {
                errorsDiv.innerHTML = '';
                nameInput.value = '';
                descInput.value = '';
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });

            cancelBtn.addEventListener('click', () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            });

            saveBtn.addEventListener('click', async () => {
                errorsDiv.innerHTML = '';
                const name = nameInput.value.trim();
                const description = descInput.value.trim();
                if (!name) {
                    errorsDiv.textContent = 'Name is required.';
                    return;
                }

                saveBtn.disabled = true;
                try {
                    const res = await fetch('{{ route('medicine-types.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ name, description })
                    });

                    if (res.status === 201 || res.ok) {
                        const data = await res.json();
                        // add option and select it
                        const opt = document.createElement('option');
                        opt.value = data.id;
                        opt.textContent = data.name;
                        select.appendChild(opt);
                        select.value = data.id;
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    } else {
                        const json = await res.json();
                        if (json.errors) {
                            const msgs = Object.values(json.errors).flat().join(' ');
                            errorsDiv.textContent = msgs;
                        } else if (json.message) {
                            errorsDiv.textContent = json.message;
                        } else {
                            errorsDiv.textContent = 'Failed to add type.';
                        }
                    }
                } catch (e) {
                    errorsDiv.textContent = 'Network error. Try again.';
                } finally {
                    saveBtn.disabled = false;
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
