<div>
    {{-- Header Card --}}
    <div class="welcome-card p-4 mb-4 shadow-sm">
        <div class="d-flex align-items-center justify-content-between">
            <div style="position: relative; z-index: 1;">
                <h4 class="text-white fw-bold mb-1">
                    <i class="fa-solid fa-desktop me-2"></i>{{ __('Asset Specifications & Software') }}
                </h4>
                <p class="text-white text-opacity-75 mb-0 small">
                    {{ __('Detailed system specs and list of installed apps retrieved from Agent.') }}
                </p>
            </div>
            <div style="position: relative; z-index: 1;">
                <a href="{{ route('hardware.assets-online.index') }}" class="btn btn-light btn-sm rounded-pill px-3">
                    <i class="fa fa-arrow-left me-1"></i> {{ __('Back to Tracking') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Info Cards Row --}}
    <div class="row g-3 mb-4">
        {{-- Device Summary --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-3 bg-primary bg-opacity-10 text-primary rounded-3 me-3">
                            <i class="fa-solid fa-laptop fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">{{ $asset->computer_name }}</h6>
                            <small class="text-muted">{{ $asset->manufacturer }} / {{ $asset->model }}</small>
                        </div>
                    </div>
                    <hr class="text-muted opacity-25">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">{{ __('Mac Address') }}:</span>
                        <span class="fw-semibold small font-monospace text-dark">{{ $asset->mac_address ?? '—' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">{{ __('Windows Activation') }}:</span>
                        <span
                            class="badge {{ strtolower($asset->windows_activation) === 'licensed' ? 'bg-success' : 'bg-warning' }}">{{ $asset->windows_activation ?? '—' }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">{{ __('Serial Number') }}:</span>
                        <span class="fw-semibold small font-monospace">{{ $asset->serial_number }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">{{ __('Last Sync') }}:</span>
                        <span
                            class="fw-semibold small text-primary">{{ $asset->last_sync_at ? \Carbon\Carbon::parse($asset->last_sync_at)->diffForHumans() : '—' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- OS Info --}}
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="p-3 bg-success bg-opacity-10 text-success rounded-3 me-3">
                            <i class="fa-brands fa-windows fs-4"></i>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">{{ $asset->os_name ?? __('Unknown OS') }}</h6>
                            <small class="text-muted">{{ __('Version') }}: {{ $asset->os_version ?? '—' }}</small>
                        </div>
                    </div>
                    <hr class="text-muted opacity-25">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">{{ __('Platform') }}:</span>
                        <span
                            class="fw-semibold small">{{ str_contains(strtolower($asset->os_name), 'windows') ? 'Windows Client' : 'Other' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-muted small">{{ __('Sync Timestamp') }}:</span>
                        <span class="fw-semibold small text-muted">{{ $asset->last_sync_at ?? '—' }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Apps Count --}}
        <div class="col-12 col-md-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <div class="d-flex align-items-center">
                            <div class="p-3 bg-info bg-opacity-10 text-info rounded-3 me-3">
                                <i class="fa-solid fa-cubes fs-4"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0">{{ __('Installed Applications') }}</h6>
                                <small class="text-muted">{{ __('Total reported programs') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="text-center py-2">
                        <h2 class="fw-bold text-primary mb-0 font-monospace">{{ $asset->apps_count }}</h2>
                        <span
                            class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill mt-1">{{ __('Software Installed') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Specs & Apps Section --}}
    <div class="row g-4">
        {{-- Hardware Specifications --}}
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <h5 class="fw-bold mb-0">
                        <i class="fa-solid fa-microchip me-2 text-primary"></i>{{ __('Hardware Specs') }}
                    </h5>
                </div>
                <div class="card-body px-4 pb-4">
                    @if ($asset->hardware_specs)
                        <div class="list-group list-group-flush">
                            {{-- CPU --}}
                            @if (isset($asset->hardware_specs['cpu']))
                                <div class="list-group-item border-0 px-0 py-3">
                                    <div class="d-flex align-items-start">
                                        <div class="p-2 bg-light rounded text-secondary me-3">
                                            <i class="fa-solid fa-microchip fs-5"></i>
                                        </div>
                                        <div>
                                            <span
                                                class="d-block text-muted small fw-bold text-uppercase">{{ __('Processor (CPU)') }}</span>
                                            <span
                                                class="fw-semibold text-dark">{{ $asset->hardware_specs['cpu'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- RAM --}}
                            @if (isset($asset->hardware_specs['ram_gb']))
                                <div class="list-group-item border-0 px-0 py-3">
                                    <div class="d-flex align-items-start">
                                        <div class="p-2 bg-light rounded text-secondary me-3">
                                            <i class="fa-solid fa-memory fs-5"></i>
                                        </div>
                                        <div>
                                            <span
                                                class="d-block text-muted small fw-bold text-uppercase">{{ __('Memory (RAM)') }}</span>
                                            <span class="fw-semibold text-dark">{{ $asset->hardware_specs['ram_gb'] }}
                                                GB RAM</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- GPU --}}
                            @if (isset($asset->hardware_specs['gpu']))
                                <div class="list-group-item border-0 px-0 py-3">
                                    <div class="d-flex align-items-start">
                                        <div class="p-2 bg-light rounded text-secondary me-3">
                                            <i class="fa-solid fa-gamepad fs-5"></i>
                                        </div>
                                        <div>
                                            <span
                                                class="d-block text-muted small fw-bold text-uppercase">{{ __('Graphics (GPU)') }}</span>
                                            <span
                                                class="fw-semibold text-dark">{{ $asset->hardware_specs['gpu'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Storage Disks --}}
                            @if (isset($asset->hardware_specs['disks']) && is_array($asset->hardware_specs['disks']))
                                <div class="list-group-item border-0 px-0 py-3">
                                    <div class="d-flex align-items-start">
                                        <div class="p-2 bg-light rounded text-secondary me-3">
                                            <i class="fa-solid fa-hard-drive fs-5"></i>
                                        </div>
                                        <div class="w-100">
                                            <span
                                                class="d-block text-muted small fw-bold text-uppercase">{{ __('Storage Disks') }}</span>
                                            <div class="row g-2 mt-1">
                                                @foreach ($asset->hardware_specs['disks'] as $disk)
                                                    <div class="col-12">
                                                        <div
                                                            class="p-2 bg-light rounded-3 d-flex justify-content-between align-items-center">
                                                            <span class="small fw-semibold"><i
                                                                    class="fa-solid fa-hdd me-1 opacity-50"></i> Disk
                                                                {{ $disk['DeviceId'] ?? '#' }}</span>
                                                            <span
                                                                class="badge bg-dark text-light">{{ $disk['MediaType'] ?? 'Drive' }}</span>
                                                            <span
                                                                class="small fw-bold text-primary">{{ $disk['SizeGB'] ?? '0' }}
                                                                GB</span>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-circle-info fs-1 mb-2 opacity-50"></i>
                            <p class="mb-0">{{ __('No hardware specifications synchronized yet.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Installed Applications List --}}
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0">
                            <i class="fa-solid fa-list-check me-2 text-primary"></i>{{ __('Installed Apps') }}
                        </h5>
                        <div style="width: 200px;">
                            <input type="text" class="form-control form-control-sm rounded-pill"
                                placeholder="{{ __('Search apps...') }}" id="appSearchInput"
                                onkeyup="filterAppsList()">
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 pb-4">
                    @if ($asset->installed_apps && count($asset->installed_apps) > 0)
                        <div class="table-responsive" style="max-height: 480px; overflow-y: auto;">
                            <table class="table table-hover align-middle mb-0" id="appsTable">
                                <thead class="sticky-top bg-white" style="z-index: 5;">
                                    <tr>
                                        <th class="py-2 text-muted small border-bottom" style="width: 50px;">#</th>
                                        <th class="py-2 text-muted small border-bottom">{{ __('App Name') }}</th>
                                        <th class="py-2 text-muted small border-bottom text-end"
                                            style="width: 120px;">{{ __('Version') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asset->installed_apps as $index => $app)
                                        <tr class="app-row">
                                            <td><span
                                                    class="badge bg-light text-dark border font-monospace">{{ $index + 1 }}</span>
                                            </td>
                                            <td class="app-name fw-semibold text-dark small">
                                                {{ $app['DisplayName'] ?? '—' }}</td>
                                            <td class="text-end"><span
                                                    class="badge bg-dark text-light font-monospace">{{ $app['DisplayVersion'] ?? '—' }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fa-solid fa-cubes fs-1 mb-2 opacity-50"></i>
                            <p class="mb-0">{{ __('No applications data found.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Missing Drivers Section --}}
    <div class="row g-4 mt-3">
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
                    <h5 class="fw-bold mb-0">
                        <i class="fa-solid fa-triangle-exclamation me-2 text-warning"></i>{{ __('Missing Drivers') }}
                    </h5>
                </div>
                <div class="card-body px-4 pb-4">
                    @if ($asset->missing_drivers && count($asset->missing_drivers) > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead style="background: #f9fafb;">
                                    <tr>
                                        <th class="py-2 text-muted small" style="width: 50px;">#</th>
                                        <th class="py-2 text-muted small">{{ __('Name') }}</th>
                                        <th class="py-2 text-muted small">{{ __('Description') }}</th>
                                        <th class="py-2 text-muted small">{{ __('Device ID') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($asset->missing_drivers as $index => $driver)
                                        <tr>
                                            <td>
                                                <span
                                                    class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 font-monospace">
                                                    {{ $loop->iteration }}
                                                </span>
                                            </td>
                                            <td class="fw-semibold text-dark small">
                                                {{ $driver['Name'] ?? '—' }}
                                            </td>
                                            <td class="text-muted small">
                                                {{ $driver['Description'] ?? '—' }}
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark font-monospace small">
                                                    {{ $driver['DeviceId'] ?? '—' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fa-solid fa-circle-check fs-2 text-success mb-2"></i>
                            <p class="mb-0 fw-semibold text-success">
                                {{ __('All drivers are properly installed. No missing drivers detected!') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Frontend app list search/filtering --}}
    <script>
        function filterAppsList() {
            var input = document.getElementById("appSearchInput");
            var filter = input.value.toLowerCase();
            var table = document.getElementById("appsTable");
            if (!table) return;
            var rows = table.getElementsByClassName("app-row");

            for (var i = 0; i < rows.length; i++) {
                var nameCol = rows[i].getElementsByClassName("app-name")[0];
                if (nameCol) {
                    var textVal = nameCol.textContent || nameCol.innerText;
                    if (textVal.toLowerCase().indexOf(filter) > -1) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</div>
