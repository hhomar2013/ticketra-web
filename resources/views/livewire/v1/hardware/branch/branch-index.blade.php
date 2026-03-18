<div>

    @switch($action)

    {{-- ══════ EDIT ══════ --}}
    @case('edit')
        @livewire('v1.hardware.branch.branch-create', ['id' => $branchId])
    @break

    {{-- ══════ CREATE ══════ --}}
    @case('create')
        @livewire('v1.hardware.branch.branch-create')
    @break

    {{-- ══════ INDEX ══════ --}}
    @case('index')
    <div>

        {{-- Header --}}
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h6 class="fw-bold mb-0">{{ __('Branches') }}</h6>
                <small class="text-muted">{{ __('Manage your organization branches') }}</small>
            </div>
            <button wire:click="changeAction('create')"
                class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm">
                <i class="fas fa-plus me-1"></i> {{ __('Add Branch') }}
            </button>
        </div>

        {{-- Table --}}
        @if(count($branches))
            <div class="border rounded-3 overflow-hidden">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background: #f9fafb;">
                        <tr>
                            <th class="ps-4 py-3 text-muted fw-600 small" style="width: 60px;">#</th>
                            <th class="py-3 text-muted fw-600 small">{{ __('Branch Name') }}</th>
                            <th class="py-3 text-muted fw-600 small">{{ __('Location') }}</th>
                            <th class="py-3 text-muted fw-600 small">{{ __('Status') }}</th>
                            <th class="py-3 pe-4 text-muted fw-600 small text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($branches as $key => $branch)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-light text-muted border"
                                    style="font-size: 11px;">{{ $key + 1 }}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div style="width: 34px; height: 34px; border-radius: 10px;
                                        background: rgba(13,110,253,.1);
                                        display: flex; align-items: center; justify-content: center;
                                        font-size: 13px; font-weight: 700; color: #0d6efd;">
                                        {{ strtoupper(substr($branch->name, 0, 2)) }}
                                    </div>
                                    <span class="fw-bold small">{{ $branch->name }}</span>
                                </div>
                            </td>
                            <td class="text-muted small">
                                @if($branch->location)
                                    <i class="fa fa-location-dot me-1 opacity-50"></i>
                                    {{ $branch->location }}
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                            <td>
                                @if($branch->is_active ?? true)
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
                            <td class="pe-4 text-end">
                                <button
                                    wire:click="editBranch({{ $branch->id }})"
                                    class="btn btn-sm rounded-pill px-3 me-1"
                                    style="background: rgba(13,110,253,.08); color: #0d6efd;
                                           border: 1px solid rgba(13,110,253,.15); font-size: 12px;"
                                    title="{{ __('Edit') }}">
                                    <i class="fas fa-edit me-1"></i> {{ __('Edit') }}
                                </button>
                                <button
                                    onclick="confirmDelete({{ $branch->id }}, 'delete-branch')"
                                    class="btn btn-sm rounded-pill px-3"
                                    style="background: rgba(220,53,69,.08); color: #dc3545;
                                           border: 1px solid rgba(220,53,69,.15); font-size: 12px;"
                                    title="{{ __('Delete') }}">
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
                <div style="font-size: 48px; margin-bottom: 12px;">🏢</div>
                <h6 class="fw-bold text-dark mb-1">{{ __('No branches yet') }}</h6>
                <p class="small mb-3">{{ __('Add your first branch to get started') }}</p>
                <button wire:click="changeAction('create')"
                    class="btn btn-primary btn-sm rounded-pill px-4">
                    <i class="fas fa-plus me-1"></i> {{ __('Add Branch') }}
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
