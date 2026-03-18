<div>
    @push('styles')
    <style>
        /* ── Page Header ── */
        .history-header {
            background: linear-gradient(135deg, #0d6efd 0%, #0047c4 100%);
            border-radius: 20px;
            padding: 24px 28px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }
        .history-header::before {
            content: ''; position: absolute;
            top: -30px; right: -30px;
            width: 140px; height: 140px;
            border-radius: 50%; background: rgba(255,255,255,.07);
        }
        .history-header::after {
            content: ''; position: absolute;
            bottom: -20px; right: 80px;
            width: 90px; height: 90px;
            border-radius: 50%; background: rgba(255,255,255,.05);
        }

        /* ── Section Title ── */
        .section-title {
            display: flex; align-items: center; gap: 10px;
            margin-bottom: 20px;
        }
        .section-title .s-icon {
            width: 36px; height: 36px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; flex-shrink: 0;
        }
        .section-title h6 {
            font-size: 14px; font-weight: 700; color: #111827; margin: 0;
        }
        .section-title small { font-size: 12px; color: #9ca3af; }

        /* ── Timeline Scroll ── */
        .timeline-scroll {
            display: flex;
            gap: 0;
            overflow-x: auto;
            padding-bottom: 16px;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
        }
        .timeline-scroll::-webkit-scrollbar { height: 4px; }
        .timeline-scroll::-webkit-scrollbar-track { background: #f3f4f6; border-radius: 10px; }
        .timeline-scroll::-webkit-scrollbar-thumb { background: #0d6efd; border-radius: 10px; }
        .timeline-scroll { scrollbar-width: thin; scrollbar-color: #0d6efd #f3f4f6; }

        /* ── Timeline Item ── */
        .tl-item {
            flex-shrink: 0;
            width: 260px;
            position: relative;
            padding-right: 32px;
        }
        .tl-item:last-child { padding-right: 0; }

        /* Connector line */
        .tl-item:not(:last-child)::after {
            content: '';
            position: absolute;
            top: 28px; right: 0;
            width: 32px; height: 2px;
            background: linear-gradient(90deg, #e5e7eb, #0d6efd);
        }
        /* Arrow */
        .tl-item:not(:last-child)::before {
            content: '›';
            position: absolute;
            top: 18px; right: -2px;
            font-size: 20px; color: #0d6efd;
            font-weight: 700; line-height: 1;
            z-index: 1;
        }

        .tl-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            overflow: hidden;
            transition: transform .2s, box-shadow .2s;
        }
        .tl-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 28px rgba(0,0,0,.1) !important;
        }

        .tl-card-top {
            padding: 14px 16px 10px;
            border-bottom: 1px solid #f3f4f6;
            display: flex; align-items: center; justify-content: space-between;
        }
        .tl-num {
            width: 26px; height: 26px; border-radius: 8px;
            background: linear-gradient(135deg, #0d6efd, #0047c4);
            color: #fff; font-size: 11px; font-weight: 700;
            display: flex; align-items: center; justify-content: center;
        }
        .tl-action-badge {
            font-size: 11px; font-weight: 700; padding: 4px 10px;
            border-radius: 20px; background: #111827; color: #fff;
        }

        .tl-card-body { padding: 14px 16px; }
        .tl-desc {
            font-size: 13px; color: #374151; line-height: 1.55;
            margin-bottom: 10px; min-height: 40px;
        }

        .tl-meta { display: flex; flex-direction: column; gap: 6px; }
        .tl-meta-row {
            display: flex; align-items: center; gap: 6px;
            font-size: 12px; color: #6b7280;
        }
        .tl-meta-row i { font-size: 11px; color: #9ca3af; width: 12px; }

        .tl-status {
            display: inline-flex; align-items: center; gap: 5px;
            background: rgba(13,110,253,.08); color: #0d6efd;
            border-radius: 20px; padding: 3px 10px;
            font-size: 11px; font-weight: 600;
        }

        .tl-card-footer {
            padding: 10px 16px;
            background: #f9fafb;
            border-top: 1px solid #f3f4f6;
            display: flex; align-items: center; justify-content: space-between;
        }

        /* ── Transfer Cards ── */
        .tl-card.transfer {
            border-top: 3px solid #dc3545;
        }
        .tl-num.transfer {
            background: linear-gradient(135deg, #dc3545, #a71d2a);
        }
        .transfer-route {
            display: flex; align-items: center; gap: 8px;
            margin: 8px 0;
        }
        .transfer-branch {
            background: #f3f4f6; border-radius: 8px;
            padding: 6px 10px; font-size: 12px; font-weight: 600;
            color: #374151; flex: 1; text-align: center;
        }
        .transfer-arrow {
            color: #dc3545; font-size: 16px; flex-shrink: 0;
        }

        /* ── Empty ── */
        .tl-empty {
            text-align: center; padding: 40px 20px; color: #9ca3af;
        }
    </style>
    @endpush

    {{-- ══════ Page Header ══════ --}}
    <div class="history-header shadow-sm">
        <div class="d-flex align-items-center justify-content-between" style="position: relative; z-index: 1;">
            <div class="d-flex align-items-center gap-3">
                <div style="width: 48px; height: 48px; border-radius: 14px;
                    background: rgba(255,255,255,.15); display: flex; align-items: center;
                    justify-content: center; font-size: 22px;">
                    💻
                </div>
                <div>
                    <p class="text-white text-opacity-75 mb-0 small">{{ __('Asset History') }}</p>
                    <h5 class="text-white fw-bold mb-0" style="font-family: monospace;">
                        {{ $assets->asset_tag }}
                    </h5>
                </div>
            </div>
            {{-- ✅ نفس wire:click --}}
            <button wire:click="backToAssets"
                class="btn btn-sm rounded-pill px-3 fw-bold"
                style="background: rgba(255,255,255,.15); color: #fff;
                       border: 1px solid rgba(255,255,255,.25); font-size: 13px;">
                <i class="fas fa-arrow-left me-1"></i> {{ __('Back') }}
            </button>
        </div>
    </div>

    {{-- ══════ History Timeline ══════ --}}
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px; overflow: hidden;">
        <div class="card-body p-4">

            <div class="section-title">
                <div class="s-icon" style="background: rgba(13,110,253,.1);">
                    <i class="fa fa-clock-rotate-left text-primary" style="font-size: 14px;"></i>
                </div>
                <div>
                    <h6>{{ __('Activity History') }}</h6>
                    <small>{{ $assets->history->count() }} {{ __('records') }}</small>
                </div>
            </div>

            @if($assets->history->count())
                <div class="timeline-scroll">
                    {{-- ✅ نفس الـ loop بالظبط --}}
                    @foreach ($assets->history as $key => $history)
                        <div class="tl-item">
                            <div class="tl-card shadow-sm">

                                <div class="tl-card-top">
                                    <div class="tl-num">{{ $key + 1 }}</div>
                                    <span class="tl-action-badge">{{ $history->action }}</span>
                                </div>

                                <div class="tl-card-body">
                                    <p class="tl-desc">{{ $history->description }}</p>
                                    <div class="tl-meta">
                                        <div class="tl-meta-row">
                                            <i class="fa fa-circle-dot"></i>
                                            <span class="text-muted">{{ __('Status') }}:</span>
                                            <span class="tl-status">
                                                {{ $history->new_status }}
                                            </span>
                                        </div>
                                        <div class="tl-meta-row">
                                            <i class="fa fa-user"></i>
                                            <span class="text-muted">{{ __('By') }}:</span>
                                            <span class="fw-bold text-dark">{{ $history->performer->name }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="tl-card-footer">
                                    <span style="font-size: 11px; color: #9ca3af;">
                                        <i class="far fa-calendar me-1"></i>
                                        {{-- ✅ نفس format --}}
                                        {{ \Carbon\Carbon::parse($history->created_at)->format('Y/m/d D') }}
                                    </span>
                                    <span style="font-size: 11px; color: #9ca3af;">
                                        <i class="far fa-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($history->created_at)->format('h:i A') }}
                                    </span>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="tl-empty">
                    <div style="font-size: 40px; margin-bottom: 10px;">📋</div>
                    <p class="small mb-0">{{ __('No history records yet') }}</p>
                </div>
            @endif

        </div>
    </div>

    {{-- ══════ Transfers Timeline ══════ --}}
    @if ($assets->Transfer->count() > 0)
        <div class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
            <div class="card-body p-4">

                <div class="section-title">
                    <div class="s-icon" style="background: rgba(220,53,69,.1);">
                        <i class="fa fa-right-left" style="font-size: 14px; color: #dc3545;"></i>
                    </div>
                    <div>
                        <h6>{{ __('Transfer History') }}</h6>
                        <small>{{ $assets->Transfer->count() }} {{ __('transfers') }}</small>
                    </div>
                </div>

                <div class="timeline-scroll">
                    {{-- ✅ نفس الـ loop بالظبط --}}
                    @foreach ($assets->Transfer as $key => $transfer)
                        <div class="tl-item">
                            <div class="tl-card transfer shadow-sm">

                                <div class="tl-card-top">
                                    <div class="tl-num transfer">{{ $key + 1 }}</div>
                                    <span style="font-size: 11px; font-weight: 700;
                                        background: rgba(220,53,69,.1); color: #dc3545;
                                        border-radius: 20px; padding: 4px 10px;">
                                        {{ __('Transfer') }}
                                    </span>
                                </div>

                                <div class="tl-card-body">
                                    {{-- ✅ نفس fromBranch / toBranch / user --}}
                                    <div class="transfer-route">
                                        <div class="transfer-branch">
                                            <div style="font-size: 10px; color: #9ca3af; margin-bottom: 2px;">FROM</div>
                                            {{ $transfer->fromBranch->name }}
                                        </div>
                                        <i class="fa fa-arrow-right transfer-arrow"></i>
                                        <div class="transfer-branch">
                                            <div style="font-size: 10px; color: #9ca3af; margin-bottom: 2px;">TO</div>
                                            {{ $transfer->toBranch->name }}
                                        </div>
                                    </div>
                                    <div class="tl-meta mt-2">
                                        <div class="tl-meta-row">
                                            <i class="fa fa-user"></i>
                                            <span class="text-muted">{{ __('By') }}:</span>
                                            <span class="fw-bold text-dark">{{ $transfer->user->name }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="tl-card-footer">
                                    <span style="font-size: 11px; color: #9ca3af;">
                                        <i class="far fa-calendar me-1"></i>
                                        {{-- ✅ نفس format --}}
                                        {{ \Carbon\Carbon::parse($transfer->created_at)->format('Y/m/d D') }}
                                    </span>
                                    <span style="font-size: 11px; color: #9ca3af;">
                                        <i class="far fa-clock me-1"></i>
                                        {{ \Carbon\Carbon::parse($transfer->created_at)->format('h:i A') }}
                                    </span>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>
    @endif

</div>
