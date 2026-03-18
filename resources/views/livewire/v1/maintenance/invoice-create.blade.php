<div>

    <div class="card">
        <div class="card-header">
            <div class="d-flex align-items-center justify-content-between">
                <h5 class="card-title fw-semibold mb-0"> {{ __('Maintenance') }} </h5>
                <button wire:click="back" class="btn btn-danger"> <i class="fas fa-arrow-left"></i> </button>
            </div>


        </div>
        <div class="card-body">
            <form wire:submit="save">
                <h1 class="text-danger"> {{ '#' . $invoiceNumber }}</h1>
                <div class="row">
                    <div class="col-lg-4">
                        <label for="">{{ __('Suppliers') }}</label>
                        <select class="form-control " wire:model.live="supplier_id">
                            <option value="">{{ __('Select Supplier') }}</option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->brand_name }}</option>
                            @endforeach

                        </select>
                    </div>

                    <div class="col-lg-4">
                        <label for="invoice_date">{{ __('Invoice date') }}</label>
                        <input type="date" class="form-control" name="" id="invoice_date"
                            wire:model.live="invoice_date" />
                    </div>
                </div>

                <hr>
                <div>
                    <div class="input-group">
                        <input type="text" wire:model.live="search" wire:keydown.enter="searchInAsset"
                            class="form-control" placeholder="Search...">
                        <button wire:click.prevent="searchInAsset" class="btn btn-outline-secondary">Search</button>
                    </div>
                    @if (!empty($search))
                        <ul class="list-group mt-2 shadow-sm">
                            {{-- استبدل isNotEmpty() بـ count() > 0 --}}
                            @if (count($results) > 0)
                                @foreach ($results as $result)
                                    <li class="list-group-item list-group-item-action cursor-pointer p-0"
                                        wire:click.prevent="select({{ $result }})">

                                        @php
                                            // فحص إذا كان العنصر مختاراً
                                            $isSelected = collect($select_list)->contains('id', $result['id']);
                                        @endphp

                                        <div
                                            class="d-flex align-items-center p-2 {{ $isSelected ? 'bg-success text-white' : '' }}">
                                            <div class="flex-grow-1">
                                                <strong>{{ __('Asset Tag') }}:</strong>
                                                {{ $result['asset_tag'] ?? $result->asset_tag }} <br>
                                                <small class="{{ $isSelected ? 'text-white-50' : 'text-muted' }}">
                                                    {{ __('Serial number') }}:
                                                    {{ $result['serial_number'] ?? $result->serial_number }}
                                                </small>
                                            </div>

                                            @if ($isSelected)
                                                <i class="fas fa-check-circle"></i>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            @else
                                <li class="list-group-item text-muted text-center py-3">
                                    {{ __('No results found') }}
                                </li>
                            @endif
                        </ul>
                    @endif


                    <table class="table table-hover table-sm border">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">{{ __('Asset tag') }}</th>
                                <th scope="col">{{ __('Serial number') }}</th>
                                <th scope="col"><i class="fa fa-cogs"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($select_list as $key => $list)
                                <tr>
                                    <th scope="row">{{ $key + 1 }}</th>
                                    <td>{{ $list['asset_tag'] }}</td>
                                    <td>{{ $list['serial_number'] }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-danger"
                                            wire:click.prevent="deleteItem({{ $list['id'] }})"><i
                                                class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>


                    @if ($select_list)
                        <hr>
                        <button class="btn btn-danger" wire:click.prevent="clearList">{{ __('clear List') }} </button>

                        <button class="btn btn-primary" type="submit">{{ __('Save Order') }} </button>
                    @endif
                </div>
                {{-- Seach form --}}



            </form>





        </div>
    </div>


</div>
@push('js')
    <script src="{{ asset('assets/js/confirmDelete.js') }}"></script>
@endpush
