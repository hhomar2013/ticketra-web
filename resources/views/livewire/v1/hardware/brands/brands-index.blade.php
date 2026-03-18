<div>
    @switch($action)
    @case('create')
    @livewire('v1.hardware.brands.brands-create')
    @break
    @case('index')
    <div>
        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h6 class="fw-bold mb-0">{{ __('Brands') }}</h6>
                <small class="text-muted">{{ __('Manage your hardware brands and models') }}</small>
            </div>
            <button type="submit" wire:click="createBrand" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
                <i class="fas fa-plus me-1"></i> {{ __('Add Brand') }}
            </button>
        </div>

        @if(count($brands))
        <div class="border rounded-3 overflow-hidden">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th class="ps-4 py-3 text-muted small" style="width: 60px;">#</th>
                        <th class="py-3 text-muted small">{{ __('Brand Name') }}</th>
                        <th class="py-3 text-muted small">{{ __('Models') }}</th>
                        <th class="py-3 pe-4 text-muted small text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $key => $brand)
                    <tr>
                        <td class="ps-4">
                            <span class="badge bg-light text-muted border" style="font-size: 11px;">{{ $key + 1 }}</span>
                        </td>

                        {{-- Brand Name + Avatar --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                @if($brand->logo)
                                <img src="{{ asset('storage/' . $brand->logo) }}" alt="{{ $brand->name }}" style="width: 34px; height: 34px; border-radius: 10px;
                                               object-fit: contain; border: 1px solid #e5e7eb;
                                               padding: 3px; background: #fff;">
                                @else
                                <div style="width: 34px; height: 34px; border-radius: 10px;
                                        background: rgba(13,110,253,.1);
                                        display: flex; align-items: center; justify-content: center;
                                        font-size: 13px; font-weight: 700; color: #0d6efd;">
                                    {{ strtoupper(substr($brand->name, 0, 2)) }}
                                </div>
                                @endif
                                <span class="fw-bold small">{{ $brand->name }}</span>
                            </div>
                        </td>



                        {{-- Models Count --}}
                        <td>
                            <a href="{{ route('hardware.brands.models', ['id' => $brand->id]) }}" class="d-inline-flex align-items-center gap-1 text-decoration-none" style="background: rgba(13,110,253,.08); color: #0d6efd;
                                       border: 1px solid rgba(13,110,253,.15);
                                       border-radius: 20px; padding: 4px 12px; font-size: 12px; font-weight: 600;">
                                <i class="fa fa-cubes" style="font-size: 11px;"></i>
                                {{ $brand->typeModels->count() }} {{ __('Models') }}
                            </a>
                        </td>

                        {{-- Actions --}}
                        <td class="pe-4 text-end">
                            <button wire:click="editBrand({{ $brand->id }})" class="btn btn-sm rounded-pill px-3 me-1" style="background: rgba(13,110,253,.08); color: #0d6efd;
                                       border: 1px solid rgba(13,110,253,.15); font-size: 12px;">
                                <i class="fas fa-edit me-1"></i> {{ __('Edit') }}
                            </button>
                            <button onclick="confirmDelete({{ $brand->id }}, 'delete-brand')" class="btn btn-sm rounded-pill px-3" style="background: rgba(220,53,69,.08); color: #dc3545;
                                       border: 1px solid rgba(220,53,69,.15); font-size: 12px;">
                                <i class="fas fa-trash me-1"></i> {{ __('Delete') }}
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @else
        <div class="text-center py-5 text-muted">
            <div style="font-size: 48px; margin-bottom: 12px;">🏷️</div>
            <h6 class="fw-bold text-dark mb-1">{{ __('No brands yet') }}</h6>
            <p class="small mb-3">{{ __('Add your first brand to get started') }}</p>
            <button wire:click="changeAction('create') " class="btn btn-primary btn-sm rounded-pill px-4">
                <i class="fas fa-plus me-1"></i> {{ __('Add Brand') }}
            </button>
        </div>
        @endif

    </div>
    @break

    @default

    @endswitch
</div>

@push('js')
<script src="{{ asset('assets/js/confirmDelete.js') }}"></script>
@endpush
