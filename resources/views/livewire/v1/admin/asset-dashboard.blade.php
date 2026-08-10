  <div class="row mb-3">
      <div class="col-lg-12 d-flex justify-content-between align-items-center">
          <h3 class="fw-bold mb-0">
              <i class="fa-solid fa-laptop"></i>
              Assets Statistics
          </h3>
          <a href="{{ route('hardware.assets.index') }}" class="btn btn-primary">
              <i class="fa fa-list me-1"></i>
              View Assets List
          </a>
      </div>
  </div>

  <div class="row g-3 mb-4">

      <div class="col-6 col-lg-3">
          <div class="card stat-card shadow-sm h-100">
              <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                      <div class="stat-icon bg-primary bg-opacity-10">
                          <i class="fa fa-laptop text-primary"></i>
                      </div>
                      <span class="badge bg-primary bg-opacity-10 text-primary small">All</span>
                  </div>
                  <h3 class="fw-bold mb-0">{{ $assetStats['total'] ?? 0 }}</h3>
                  <p class="text-muted small mb-0 mt-1">Total Assets</p>
              </div>
          </div>
      </div>

      <div class="col-6 col-lg-3">
          <div class="card stat-card shadow-sm h-100">
              <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                      <div class="stat-icon bg-secondary bg-opacity-10">
                          <i class="fa fa-laptop-medical text-secondary"></i>
                      </div>
                      <span class="badge bg-secondary bg-opacity-10 text-secondary small">Spare</span>
                  </div>
                  <h3 class="fw-bold mb-0">{{ $assetStats['available'] }}</h3>
                  <p class="text-muted small mb-0 mt-1">Spare</p>
              </div>
          </div>
      </div>

      <div class="col-6 col-lg-3">
          <div class="card stat-card shadow-sm h-100">
              <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                      <div class="stat-icon bg-warning bg-opacity-10">
                          <i class="fa fa-user text-warning"></i>
                      </div>
                      <span class="badge bg-warning bg-opacity-10 text-warning small">WIP</span>
                  </div>
                  <h3 class="fw-bold mb-0">{{ $assetStats['assigned'] }}</h3>
                  <p class="text-muted small mb-0 mt-1">Assigned</p>
              </div>
          </div>
      </div>

      <div class="col-6 col-lg-3">
          <div class="card stat-card shadow-sm h-100">
              <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-start mb-3">
                      <div class="stat-icon bg-danger bg-opacity-10">
                          <i class="fa fa-skull text-danger"></i>
                      </div>
                      <span class="badge bg-danger bg-opacity-10 text-danger small">Damaged</span>
                  </div>
                  <h3 class="fw-bold mb-0">{{ $assetStats['damaged'] }}</h3>
                  <p class="text-muted small mb-0 mt-1">Damaged</p>
              </div>
          </div>
      </div>

  </div>
  <div class="row g-3 mb-4">

      {{-- ===================== BAR CHART ===================== --}}
      <div class="col-lg-8">
          <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
              <div class="card-body p-4">
                  <div class="d-flex justify-content-between align-items-center mb-4">
                      <div>
                          <h6 class="fw-bold mb-0">Assets This Week</h6>
                          <small class="text-muted">Assets per day</small>
                      </div>
                      <span class="badge bg-primary bg-opacity-10 text-primary">Last 7 days</span>
                  </div>

                  {{-- Bar Chart --}}
                  @php $maxVal = $weeklyAssetData->max('count') ?: 1; @endphp
                  <div class="d-flex align-items-end justify-content-between gap-2" style="height: 120px;">
                      @foreach ($weeklyAssetData as $day)
                          @php $height = max(4, ($day['count'] / $maxVal) * 100); @endphp
                          <div class="d-flex flex-column align-items-center flex-fill">
                              <small class="text-muted mb-1" style="font-size: 10px;">{{ $day['count'] }}</small>
                              <div class="bar-chart-bar w-100 bg-primary"
                                  style="height: {{ $height }}%; opacity: {{ $day['day'] === now()->format('D') ? '1' : '.5' }};">
                              </div>
                              <small class="text-muted mt-1" style="font-size: 10px;">{{ $day['day'] }}</small>
                          </div>
                      @endforeach
                  </div>

                  {{-- Status breakdown --}}
                  <hr class="my-3">
                  <div class="row g-2 text-center">
                      <div class="col-3">
                          <div class="fw-bold text-secondary">{{ $assetStats['available'] }}</div>
                          <small class="text-muted" style="font-size: 11px;">Available</small>
                      </div>
                      <div class="col-3">
                          <div class="fw-bold text-success">{{ $assetStats['maintenance'] }}</div>
                          <small class="text-muted" style="font-size: 11px;">Maintenance</small>
                      </div>
                      <div class="col-3">
                          <div class="fw-bold text-warning">{{ $assetStats['assigned'] }}</div>
                          <small class="text-muted" style="font-size: 11px;">Assigned</small>
                      </div>
                      <div class="col-3">
                          <div class="fw-bold text-danger">{{ $assetStats['damaged'] }}</div>
                          <small class="text-muted" style="font-size: 11px;">Damaged</small>
                      </div>
                  </div>
              </div>
          </div>
      </div>


      <div class="col-lg-4">
          <div class="card border-0 shadow-sm h-100" style="border-radius: 16px;">
              <div class="card-body p-4">
                  <h6 class="fw-bold mb-1">Top Assigners</h6>
                  <small class="text-muted d-block mb-4">Most assets assigned</small>

                  @forelse ($topAssigners as $index => $assigner)
                      @php
                          $colors = ['bg-warning', 'bg-secondary', 'bg-danger'];
                          $bgColor = $colors[$index] ?? 'bg-primary';
                      @endphp
                      <div class="d-flex align-items-center gap-3 mb-3 p-2 rounded-3" style="background: #f8f9fa;">
                          <div class="position-relative">
                              <div class="agent-avatar {{ $bgColor }} bg-opacity-20 text-dark">
                                  {{ strtoupper(substr($assigner->name, 0, 2)) }}
                              </div>
                              @if ($index === 0)
                                  <span class="position-absolute top-0 start-100 translate-middle"
                                      style="font-size: 10px;">🏆</span>
                              @endif
                          </div>
                          <div class="flex-fill">
                              <div class="fw-bold small">{{ $assigner->name }}</div>
                              <small class="text-muted">{{ $assigner->assigned_by_assets_count }} assets
                                  assigned</small>
                          </div>
                          <span class="badge {{ $bgColor }} bg-opacity-20 text-dark fw-bold">
                              #{{ $index + 1 }}
                          </span>
                      </div>
                  @empty
                      <div class="text-center text-muted py-4">
                          <i class="fa fa-users fa-2x d-block mb-2 opacity-25"></i>
                          <small>No data yet</small>
                      </div>
                  @endforelse
              </div>
          </div>
      </div>

  </div>


  <div class="row g-3">
      <div class="col-lg-8">
          <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
              <div class="card-body p-4 pb-0">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                      <h6 class="fw-bold mb-0">Recent Assets</h6>
                      <a href="" class="btn btn-sm btn-outline-primary rounded-pill">
                          View All <i class="fa fa-arrow-right ms-1"></i>
                      </a>
                  </div>
              </div>
              <div class="table-responsive">
                  <table class="table table-hover align-middle mb-0">
                      <thead class="table-light">
                          <tr>
                              <th class="ps-4 small text-muted fw-normal">#</th>
                              <th class="small text-muted fw-normal">Serial Number</th>
                              <th class="small text-muted fw-normal">Assign To</th>
                              <th class="small text-muted fw-normal">Assign By</th>
                              <th class="small text-muted fw-normal">Branch</th>
                              <th class="small text-muted fw-normal">Status</th>
                              <th class="small text-muted fw-normal pe-4">Date</th>
                          </tr>
                      </thead>
                      <tbody>
                          @forelse ($assetAssignment as $assignment)
                              <tr class="ticket-row">
                                  <td class="ps-4">
                                      <span
                                          class="badge bg-light text-dark border">#{{ $assignment->asset->asset_tag }}</span>
                                  </td>
                                  <td style="max-width: 180px;">
                                      <a href=""
                                          class="text-decoration-none text-dark fw-bold text-truncate d-block"
                                          title="{{ $assignment->asset->serial_number }}">
                                          {{ $assignment->asset->serial_number }}
                                      </a>
                                      <small
                                          class="text-muted">{{ $assignment->asset->category?->name ?? '-' }}</small>
                                  </td>
                                  <td class="small">{{ $assignment->user->name ?? '-' }}</td>
                                  <td class="small">{{ $assignment->assigner->name ?? '-' }}</td>
                                  <td class="small">
                                      <span
                                          class="badge bg-light text-dark border">{{ $assignment->asset->branch?->name ?? '-' }}</span>
                                  </td>
                                  <td>
                                      {{-- ✅ استخدام Enum --}}
                                      <span class="badge rounded-pill px-2 {{ $assignment->status->badge() }}">
                                          {{ $assignment->status->label() }}
                                      </span>
                                  </td>
                                  <td class="text-muted small pe-4">
                                      {{ $assignment->created_at->format('d M') }}<br>
                                      <span
                                          style="font-size:10px;">{{ $assignment->created_at->diffForHumans() }}</span>
                                  </td>
                              </tr>
                          @empty
                              <tr>
                                  <td colspan="6" class="text-center text-muted py-4">
                                      <i class="fa fa-inbox fa-2x d-block mb-2 opacity-25"></i>
                                      No assets yet
                                  </td>
                              </tr>
                          @endforelse
                      </tbody>
                  </table>
              </div>
          </div>
      </div>

      <div class="col-lg-4">
          <div class="card border-0 shadow-sm" style="border-radius: 16px; overflow: hidden;">
              <div class="card-head p-4 pb-0">
                  <div class="d-flex justify-content-between align-items-center mb-3">
                      <h6 class="fw-bold mb-0">Leavers Assets</h6>
                      <a href="" class="btn btn-sm btn-outline-primary rounded-pill">
                          View All <i class="fa fa-arrow-right ms-1"></i>
                      </a>
                  </div>

              </div>
              <div class="card-body">
                  <ul>
                      @forelse ($leavers as $asset)
                          <li class="d-flex justify-content-between align-items-center mb-3">
                              <div class="d-flex align-items-center">
                                  <i class="fa fa-user-times text-danger me-2"></i>
                                  {{ $asset->user->name }}
                              </div>
                              <span
                                  class="badge rounded-pill px-2 badge-light text-dark">{{ $asset->created_at->format('d M') }}
                              </span>


                          </li>
                      @empty
                          <li>
                              No leavers
                          </li>
                      @endforelse
                  </ul>
              </div>
          </div>
      </div>
  </div>
