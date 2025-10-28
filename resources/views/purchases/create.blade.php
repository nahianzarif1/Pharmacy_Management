<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('New Purchase') }}</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <x-alert />
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('purchases.store') }}" id="purchase-form">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Supplier</label>
                            <select name="supplier_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                                <option value="">Select supplier</option>
                                @foreach($suppliers as $s)
                                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Invoice No</label>
                            <input type="text" name="invoice_no" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Purchase Date</label>
                            <input type="date" name="purchase_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
                        </div>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-md font-semibold mb-2">Items</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200" id="items-table">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Medicine</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Batch No</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Unit Cost</th>
                                        <th class="px-4 py-2"></th>
                                    </tr>
                                </thead>
                                <tbody id="item-rows" class="bg-white divide-y divide-gray-200"></tbody>
                            </table>
                        </div>
                        <button type="button" id="add-row" class="mt-3 inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm rounded">Add Item</button>
                    </div>

                    <div class="flex items-center justify-end gap-3">
                        <a href="{{ route('purchases.index') }}" class="px-4 py-2 border rounded">Cancel</a>
                        <button class="px-4 py-2 bg-green-600 text-white rounded">Save Purchase</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const medicines = @json($medicines->map(fn($m)=>['id'=>$m->id,'label'=>$m->sku.' - '.$m->name]));
        const itemRows = document.getElementById('item-rows');
        const addRowBtn = document.getElementById('add-row');

        function newRow(idx){
            const options = medicines.map(m=>`<option value="${m.id}">${m.label}</option>`).join('');
            return `<tr>
                <td class="px-4 py-2">
                    <select name="items[${idx}][medicine_id]" class="w-full border rounded px-2 py-1" required>
                        <option value="">Select</option>
                        ${options}
                    </select>
                </td>
                <td class="px-4 py-2"><input name="items[${idx}][batch_no]" class="w-full border rounded px-2 py-1" placeholder="Batch"/></td>
                <td class="px-4 py-2"><input type="number" min="1" value="1" name="items[${idx}][quantity]" class="w-full border rounded px-2 py-1" required/></td>
                <td class="px-4 py-2"><input type="number" step="0.01" min="0" value="0" name="items[${idx}][unit_cost]" class="w-full border rounded px-2 py-1" required/></td>
                <td class="px-4 py-2 text-right"><button type="button" class="text-red-600 remove-row">Remove</button></td>
            </tr>`;
        }

        function refreshRemoveHandlers(){
            document.querySelectorAll('.remove-row').forEach(btn=>{
                btn.onclick = (e)=>{
                    const tr = e.target.closest('tr');
                    tr?.remove();
                }
            })
        }

        addRowBtn.onclick = ()=>{
            const idx = itemRows.children.length;
            itemRows.insertAdjacentHTML('beforeend', newRow(idx));
            refreshRemoveHandlers();
        }

        // start with one row
        addRowBtn.click();
    </script>
</x-app-layout>
