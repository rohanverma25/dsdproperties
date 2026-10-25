<!-- Modal -->
     <style>
        label.error { color: red; font-size: 14px; }
    </style>

<!-- Modal Backdrop -->
<div id="rentReceiptBackdrop" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<!-- Modal -->
<div id="rentReceiptModal" class="fixed inset-0 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-6 overflow-auto max-h-[95vh]">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Rent Receipt Form</h2>
            <button id="closeRentReceiptModal" class="text-gray-600 hover:text-red-600 text-xl">&times;</button>
        </div>

        <form id="rentReceiptForm" method="POST" action="{{ route('rent-receipt.generate') }}" target="_blank" class="space-y-4">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label>Tenant Name</label>
                    <input name="tenant_name" type="text" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label>Owner Name</label>
                    <input name="owner_name" type="text" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label>Rent Amount</label>
                    <input name="rent_amount" type="number" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label>Owner PAN</label>
                    <input name="owner_pan" type="text" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label>Rented Property Address</label>
                    <textarea name="rented_property_address" class="w-full border rounded px-3 py-2" required></textarea>
                </div>
                <div>
                    <label>Owner Address</label>
                    <textarea name="owner_address" class="w-full border rounded px-3 py-2" required></textarea>
                </div>
                <div>
                    <label>Receipt Start Date</label>
                    <input name="receipt_start_date" type="date" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label>Receipt End Date</label>
                    <input name="receipt_end_date" type="date" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            <div class="text-right">
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">Generate Now</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        // Modal logic
        $('#openRentReceiptModal').on('click', function () {
            $('#rentReceiptBackdrop, #rentReceiptModal').removeClass('hidden');
        });

        $('#closeRentReceiptModal, #rentReceiptBackdrop').on('click', function () {
            $('#rentReceiptBackdrop, #rentReceiptModal').addClass('hidden');
        });

        // jQuery validation
        $('#rentReceiptForm').validate();
    });
</script>