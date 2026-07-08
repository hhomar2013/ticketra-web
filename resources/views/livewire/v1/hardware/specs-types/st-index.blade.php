<div>
    @switch($action)
        @case('edit')
            @livewire('v1.hardware.specs-types.st-create', ['id' => $attribute_id])
        @break

        @case('create')
            @livewire('v1.hardware.specs-types.st-create')
        @break

        @case('index')
            <div>

                {{-- Header --}}
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div>
                        <h6 class="fw-bold mb-0">{{ __('Specifications Types') }}</h6>
                        <small class="text-muted">{{ __('Manage Specifications Types') }}</small>
                    </div>
                    <button wire:click="changeAction('create')"
                        class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
                        <i class="fas fa-plus me-1"></i> {{ __('Add Specification Type') }}
                    </button>
                </div>

                @if (count($attributes))
                    <div class="border rounded-3 overflow-hidden">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background: #f9fafb;">
                                <tr>
                                    <th class="ps-4 py-3 text-muted small fw-600" style="width: 60px;">#</th>
                                    <th class="py-3 text-muted small fw-600">{{ __('Name') }}</th>
                                    <th class="py-3 text-muted small fw-600">{{ __('Value Type') }}</th>
                                    <th class="py-3 text-muted small fw-600">{{ __('Status') }}</th>
                                    <th class="py-3 text-muted small fw-600">{{ __('Publish') }}</th>
                                    <th class="py-3 pe-4 text-muted small fw-600 text-end">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($attributes as $key => $attribute)
                                    <tr>
                                        <td class="ps-4">
                                            <span class="badge bg-light text-muted border"
                                                style="font-size: 11px;">{{ $key + 1 }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center gap-2">
                                                <div
                                                    style="width: 34px; height: 34px; border-radius: 10px;
                                        background: rgba(13,110,253,.1);
                                        display: flex; align-items: center; justify-content: center;
                                        font-size: 13px; font-weight: 700; color: #0d6efd;">
                                                    {{ strtoupper(substr($attribute->name, 0, 2)) }}
                                                </div>
                                                <span class="fw-bold small">{{ $attribute->name }}</span>
                                            </div>
                                        </td>
                                        <td class="text-muted small">
                                            {{ $attribute->type ? \Illuminate\Support\Str::limit($attribute->type, 50) : '—' }}
                                        </td>
                                        <td>
                                            @if ($attribute->is_active ?? true)
                                                <span class="badge rounded-pill px-3"
                                                    style="background: #d1e7dd; color: #0f5132; font-size: 11px;">
                                                    <i class="fa fa-circle me-1" style="font-size: 7px;"></i>
                                                    {{ __('Active') }}
                                                </span>
                                            @else
                                                <span class="badge rounded-pill px-3"
                                                    style="background: #e2e3e5; color: #41464b; font-size: 11px;">
                                                    {{ __('Inactive') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="ps-4">
                                            @livewire('switcher', ['model' => $attribute, 'field' => 'is_active', 'dispatch' => 'refreshAttributes'], key('attr-' . $attribute->id))
                                        </td>
                                        <td class="pe-4 text-end">
                                            <button wire:click="editAttribute({{ $attribute->id }})"
                                                class="btn btn-sm rounded-pill px-3 me-1"
                                                style="background: rgba(13,110,253,.08); color: #0d6efd;
                                           border: 1px solid rgba(13,110,253,.15); font-size: 12px;">
                                                <i class="fas fa-edit me-1"></i> {{ __('Edit') }}
                                            </button>
                                            <button onclick="confirmDelete({{ $attribute->id }}, 'delete-specs')"
                                                class="btn btn-sm rounded-pill px-3"
                                                style="background: rgba(220,53,69,.08); color: #dc3545;
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
                        <div style="font-size: 48px; margin-bottom: 12px;">🗂️</div>
                        <h6 class="fw-bold text-dark mb-1">{{ __('No Specification Types yet') }}</h6>
                        <p class="small mb-3">{{ __('Add your first Specification Type to get started') }}</p>
                        <button wire:click="changeAction('create')" class="btn btn-primary btn-sm rounded-pill px-4">
                            <i class="fas fa-plus me-1"></i> {{ __('Add Specification Type') }}
                        </button>
                    </div>
                @endif

            </div>

            @default
        @endswitch
    </div>
    @push('js')
        <script src="{{ asset('assets/js/confirmDelete.js') }}"></script>
    @endpush
