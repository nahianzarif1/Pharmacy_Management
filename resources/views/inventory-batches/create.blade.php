<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Create Inventory Batch') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <x-alert />

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('inventory-batches.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Medicine</label>
                        <input type="hidden" name="medicine_id" id="medicine_id" value="{{ optional($selectedMedicine)->id }}">
                        <input type="text" id="medicine_search" name="medicine_search" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Type medicine name or SKU" value="{{ optional($selectedMedicine)->name }}" autocomplete="off">

                        <div id="medicine_results" class="border rounded mt-1 bg-white hidden max-h-60 overflow-auto"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Batch No</label>
                            <input type="text" name="batch_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" name="quantity" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" value="0" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Received Date</label>
                            <input type="date" name="received_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Expiry Date</label>
                            <input type="date" name="expiry_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Unit Cost</label>
                            <input type="number" step="0.01" name="unit_cost" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        </div>
                    </div>

                    <div class="mt-6 flex items-center justify-between">
                        <button type="submit"class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">Save Batch</button>
                        <a href="{{ route('inventory-batches.index') }}" class="text-gray-500">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @php
        // precompute JSON-safe list to avoid Blade parsing issues with inline collections
        $initialItems = $medicines->map->only(['id','sku','name','generic_name']);
    @endphp

    <script>
        (function(){
            const input = document.getElementById('medicine_search');
            const hidden = document.getElementById('medicine_id');
            const results = document.getElementById('medicine_results');
            let timeout = null;

            // preload medicines passed from controller (precomputed above)
            const initialItems = {!! $initialItems->toJson() !!};

            function renderList(items){
                if(!items || !items.length){ results.classList.add('hidden'); results.innerHTML = ''; return; }
                results.innerHTML = items.map(i => `<div data-id="${i.id}" class="px-3 py-2 hover:bg-gray-100 cursor-pointer">${i.sku} - <strong>${i.name}</strong> <div class="text-xs text-gray-500">${i.generic_name || ''}</div></div>`).join('');
                results.classList.remove('hidden');
            }

            // show full list on focus (so users can pick without typing)
            input.addEventListener('focus', function(){
                if(input.value.trim().length === 0){ renderList(initialItems); }
            });

            input.addEventListener('input', function(e){
                const q = e.target.value.trim();
                hidden.value = '';
                if(timeout) clearTimeout(timeout);
                if(q.length < 2){
                    // if empty, show initial list; otherwise hide
                    if(q.length === 0) { renderList(initialItems); } else { results.classList.add('hidden'); }
                    return;
                }
                timeout = setTimeout(() => {
                    fetch(`{{ url('/api/medicines/search') }}?q=${encodeURIComponent(q)}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' }})
                        .then(r => r.json())
                        .then(data => renderList(data))
                        .catch(() => { results.classList.add('hidden'); });
                }, 250);
            });

            results.addEventListener('click', function(e){
                let el = e.target;
                while(el && !el.dataset.id) el = el.parentElement;
                if(!el) return;
                const id = el.dataset.id;
                hidden.value = id;
                // set input text to selected label
                input.value = el.textContent.trim();
                results.classList.add('hidden');
            });

            // click outside to close
            document.addEventListener('click', function(e){
                if(!results.contains(e.target) && e.target !== input){ results.classList.add('hidden'); }
            });
        })();
    </script>
</x-app-layout>