{{--
====================================================================
RANK TIERS MODAL — lifetime score tiers
====================================================================
Shown when a user clicks a rank title badge on a leaderboard.
Invoke with: @include('partials.rank-tiers')
--}}
<div class="modal fade" id="rankTiersModal" tabindex="-1" aria-labelledby="rankTiersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius: 16px; border: none; overflow: hidden;">
            <div class="modal-header border-0" style="background: linear-gradient(135deg, #6366f1, #7c3aed);">
                <h5 class="modal-title fw-bold text-white" id="rankTiersModalLabel">
                    <i class="bi bi-stars me-2"></i>Rank Tiers
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-3">
                    Your rank is based on your <strong>lifetime score</strong> — the total marks you've earned from correct quiz answers since day one.
                </p>
                <div class="d-flex flex-column gap-2" id="rankTiersList">
                    @php
                        $tiers = method_exists(\App\Auth\Models\User::class, 'rankTiers')
                            ? \App\Auth\Models\User::rankTiers()
                            : [
                                ['title' => 'Guru', 'min' => 10000, 'max' => null, 'icon' => '👑'],
                                ['title' => 'Grandmaster', 'min' => 5000, 'max' => 9999, 'icon' => '🏆'],
                                ['title' => 'Master', 'min' => 2000, 'max' => 4999, 'icon' => '🥇'],
                                ['title' => 'Expert', 'min' => 500, 'max' => 1999, 'icon' => '🥈'],
                                ['title' => 'Beginner', 'min' => 0, 'max' => 499, 'icon' => '🌱'],
                            ];
                    @endphp
                    @foreach ($tiers as $tier)
                        <div class="d-flex align-items-center gap-3 p-3 rounded-3"
                             style="border: 1px solid #e5e7eb; background: {{ (isset($tier['current']) && $tier['current']) ? '#eef2ff' : '#fff' }};">
                            <div class="flex-grow-1">
                                <p class="fw-bold mb-0" style="color: #1f2937;">{{ $tier['title'] }}</p>
                                <small class="text-muted">
                                    {{ $tier['min'] }} – {{ $tier['max'] === null ? '∞' : number_format($tier['max']) }} points
                                </small>
                            </div>
                            @if (!empty($tier['current']))
                                <span class="badge" style="background: #6366f1; color: #fff;">Current</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
