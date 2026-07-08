<div>
    <div class="welcome-card p-4 mb-4 shadow-sm">
        <div class="d-flex align-items-center justify-content-between">
            <div style="position: relative; z-index: 1;">

                <h4 class="text-white fw-bold mb-1">
                    {{ __('Agent Tracking') }}
                </h4>
                <p class="text-white text-opacity-75 mb-3 small">
                    {{ __('Get Asset From Agent') }}
                </p>
            </div>
            <div class="d-none d-md-block text-white" style="position: relative; z-index: 1;">
                <a wire:click="export" class="btn btn-light btn-sm rounded-pill">
                    <i class="fa-solid fa-download me-1"></i> {{ __('Download Agent App') }}
                </a>
            </div>
        </div>
    </div>


    <div class="row">


        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-primary bg-opacity-10">
                            <i class="fa-solid fa-laptop text-primary"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary small">{{ __('Total Assets') }}</span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $this->assets->count() }}</h3>
                    <p class="text-muted small mb-0 mt-1">{{ __('Total Assets') }}</p>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card stat-card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-primary bg-opacity-10">
                            <i class="fa-brands fa-windows text-primary"></i>
                        </div>
                        <span
                            class="badge bg-primary bg-opacity-10 text-primary small">{{ __('Installed Apps') }}</span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $this->assets->pluck('apps_count')->sum() }}</h3>
                    <p class="text-muted small mb-0 mt-1">{{ __('Apps Count') }}</p>
                </div>
            </div>
        </div>


        {{-- Search Area --}}
        <div class="d-flex justify-content-between align-items-center mb-3 mt-4">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="fa-solid fa-list me-2 text-primary"></i>{{ __('Monitored Devices List') }}
            </h5>
            <div class="search-wrap" style="min-width: 300px; position: relative;">
                <i class="fa fa-search s-ico"
                    style="position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #9ca3af; pointer-events: none;"></i>
                <input type="text" wire:model.live="search" class="form-control rounded-pill ps-5"
                    placeholder="{{ __('Search by Name, Serial Number') }}"
                    style="padding-top: 8px; padding-bottom: 8px; border: 1.5px solid #e5e7eb; font-size: 13px;">
            </div>
        </div>

        <div class="table-wrap shadow-sm mt-2">
            <table class="table table-hover table-responsive align-middle mb-0">
                <thead style="background: #f9fafb;">
                    <tr>
                        <th class="ps-4 py-3 text-muted small" style="width: 55px;">#</th>
                        <th class="py-3 text-muted small">{{ __('Computer & User Name') }}</th>
                        <th class="py-3 text-muted small">{{ __('Manufacturer') }}</th>
                        <th class="py-3 text-muted small">{{ __('Model') }}</th>
                        <th class="py-3 text-muted small">{{ __('Serial Number') }}</th>
                        <th class="py-3 text-muted small">{{ __('OS Name') }}</th>
                        <th class="py-3 text-muted small">{{ __('OS Version') }}</th>
                        <th class="py-3 text-muted small">{{ __('Activation') }}</th>
                        <th class="py-3 text-muted small">{{ __('Last Sync At') }}</th>
                        <th class="py-3 pe-4 text-muted small text-end">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->assets as $key => $asset)
                        <tr>
                            <td class="ps-4">
                                <span class="badge bg-light text-muted border" style="font-size: 11px;">
                                    {{ $key + 1 }}
                                </span>
                            </td>
                            <td>
                                <span class="fw-bold small font-monospace">{{ $asset->computer_name }}</span>
                            </td>
                            <td>
                                <span class="text-muted small font-monospace">{{ $asset->manufacturer }}</span>
                            </td>

                            <td>
                                <span class="small">
                                    <i class="fa fa-building me-1 text-muted opacity-50"></i>
                                    {{ $asset->model }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $asset->serial_number }}</td>
                            <td class="text-muted small">{{ $asset->os_name }}</td>
                            <td class="text-muted small">{{ $asset->os_version }}</td>
                            <td>
                                <span
                                    class="badge {{ strtolower($asset->windows_activation) === 'licensed' ? 'bg-success' : 'bg-warning' }}">{{ $asset->windows_activation ?? '—' }}</span>
                            </td>
                            <td class="text-muted small">{{ $asset->last_sync_at }}</td>

                            <td class="pe-4 text-end action-drop">
                                <div class="dropdown {{ $loop->remaining < 2 ? 'dropup' : '' }}">
                                    <button class="btn btn-sm rounded-pill px-3"
                                        style="background: #f3f4f6; border: 1px solid #e5e7eb; color: #374151;"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-ellipsis-h"></i>
                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ route('hardware.assets-online.show', $asset->id) }}">
                                                <i class="fa-solid fa-eye text-info"></i>
                                                {{ __('Show All Info') }}
                                            </a>
                                        </li>
                                        <li>
                                            <button class="dropdown-item"
                                                onclick="confirmDelete({{ $asset->id }}, 'delete-asset')">
                                                <i class="fas fa-trash text-danger"></i>
                                                {{ __('Delete') }}
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $this->assets->links() }}
        </div>
        {{-- End Of Table --}}

    </div>
