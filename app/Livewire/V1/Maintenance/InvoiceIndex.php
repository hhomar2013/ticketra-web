<?php

namespace App\Livewire\V1\Maintenance;

use App\Models\MaintenanceHeadInvoice;
use Livewire\Component;

class InvoiceIndex extends Component
{

    public function createOrder()
    {
        return redirect()->route('maintenance.invoices.create');
    }

    public function render()
    {
        $invoices = MaintenanceHeadInvoice::query()->with('items')->get();
        return view('livewire.v1.maintenance.invoice-index', ['invoices' => $invoices]);
    }
}
