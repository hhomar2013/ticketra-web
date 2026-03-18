<div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title fw-semibold mb-0"> {{ __('Maintenance') }} </h5>
                <button wire:click="createOrder" class="btn btn-primary"> <i class="fas fa-plus"></i> Create Maintenance
                    Order</button>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover table-sm border">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Number</th>
                        <th scope="col"><i class="fa fa-cogs"></i></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $key => $invoice)
                        <tr>
                            <th scope="row">{{ $key + 1 }}</th>
                            <td>{{ $invoice->invoice_number }}</td>
                            <td>
                                <button class="btn btn-sm btn-success" wire:click="editInvoice({{ $invoice->id }})"><i
                                        class="fas fa-edit"></i></button>
                                <button class="btn btn-sm btn-danger"
                                    onclick="confirmDelete({{ $invoice->id }}, 'delete-invoice')"><i
                                        class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>


        </div>
    </div>


</div>
@push('js')
    <script src="{{ asset('assets/js/confirmDelete.js') }}"></script>
@endpush
