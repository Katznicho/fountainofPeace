<div class="overflow-x-auto">

    @if ($transactions->isEmpty())
        <p class="text-center text-gray-500 py-4">No records found.</p>
    @else
        <table id="transactionTable"
            class="min-w-full divide-y divide-gray-200 shadow-md border border-gray-300 rounded-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone
                        Number</th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount
                    </th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment
                        Mode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount
                    </th>
                    {{-- description --}}
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Description</th>
                    <!-- Add more table headers as needed -->
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($transactions as $transaction)
                    {{-- if no record exists display no records --}}


                    <tr>

                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->phone_number }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->amount }}</td>

                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->type }}</td>

                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->payment_mode }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->amount }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->description }}</td>
                        <!-- Add more table data columns as needed -->
                    </tr>
                @endforeach
            </tbody>
        </table>

    @endif
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#transactionTable').DataTable({
                "paging": true,
                "ordering": true,
                "info": true,
                "searching": true,
                "lengthChange": true,
                "language": {
                    "paginate": {
                        "previous": "&lt;",
                        "next": "&gt;"
                    },
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "Showing 0 to 0 of 0 entries",
                    "lengthMenu": "Show _MENU_ entries",
                    "search": "Search:"
                }
            });
        });
    </script>
@endpush
