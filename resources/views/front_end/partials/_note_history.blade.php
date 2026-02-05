{{-- NOTE HISTORY Section --}}
<div class="note-history-section" style="margin-top: 20px;">
    <div class="info-card" style="display: flex; gap: 15px; align-items: flex-start;">
        <div class="info-icon" style="background: #FFC107; min-width: 50px; height: 50px; display: flex; align-items: center; justify-content: center; border-radius: 8px;">
            <i class="fas fa-history" style="color: #fff; font-size: 20px;"></i>
        </div>
        <div class="info-content" style="flex: 1; background: #fff; padding: 15px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <label style="font-weight: 600; color: #333; margin: 0; font-size: 14px;">{{ __('messages.note_history') ?? 'NOTE HISTORY' }}</label>
                <button type="button" class="btn btn-sm btn-primary add-note-btn" data-visit-id="{{ $visit->id }}" style="font-size: 12px; padding: 4px 12px;">
                    <i class="fas fa-plus"></i> {{ __('messages.add_note') ?? 'Add Note' }}
                </button>
            </div>

            {{-- Add Note Form (hidden by default) --}}
            <div class="add-note-form" id="add-note-form-{{ $visit->id }}" style="display: none; margin-bottom: 15px; padding: 12px; background: #f8f9fa; border-radius: 6px;">
                <form class="submit-note-form" data-visit-id="{{ $visit->id }}">
                    @csrf
                    <div class="form-group mb-2">
                        <label style="font-size: 13px; font-weight: 600; margin-bottom: 5px; display: block;">{{ __('messages.note') ?? 'Note' }}</label>
                        <textarea class="form-control note-textarea" rows="3" placeholder="{{ __('messages.enter_note') ?? 'Enter your note here...' }}" required style="font-size: 13px;"></textarea>
                    </div>
                    <div style="display: flex; gap: 8px; justify-content: flex-end;">
                        <button type="button" class="btn btn-sm btn-secondary cancel-note-btn" style="font-size: 12px;">{{ __('messages.cancel') ?? 'Cancel' }}</button>
                        <button type="submit" class="btn btn-sm btn-primary" style="font-size: 12px;">{{ __('messages.save') ?? 'Save' }}</button>
                    </div>
                </form>
            </div>
            
            @php
                $noteHistory = $visit->noteHistory ?? collect();
            @endphp
            
            @if($noteHistory->count() > 0)
                <div class="notes-list notes-list-{{ $visit->id }}" style="max-height: 300px; overflow-y: auto;">
                    @foreach($noteHistory as $noteItem)
                    <div class="note-item" style="border-bottom: 1px solid #eee; padding: 12px 0; margin-bottom: 10px;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                            <div style="flex: 1;">
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                                    <span style="font-size: 12px; color: #666;">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ web_date_in_timezone($noteItem->created_at, 'd-M-Y h:i A') }}
                                    </span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 5px;">
                                    <span style="font-size: 12px; color: #666;">
                                        <i class="fas fa-user"></i>
                                        <strong>{{ __('messages.created_by') ?? 'Created by' }}:</strong> {{ $noteItem->creator->name ?? 'N/A' }}
                                    </span>
                                </div>
                            </div>
                            @if($noteItem->visit_status)
                            @php
                                $statusBadgeClass = match (strtolower($noteItem->visit_status)) {
                                    'visited' => 'success',
                                    'cancelled' => 'danger',
                                    'rescheduled' => 'warning',
                                    default => 'primary'
                                };
                            @endphp
                            <span class="badge bg-{{ $statusBadgeClass }}" style="font-size: 11px;">
                                {{ ucfirst($noteItem->visit_status) }}
                            </span>
                            @endif
                        </div>
                        <div style="color: #333; font-size: 13px; line-height: 1.6;">
                            {{ $noteItem->note }}
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="notes-list notes-list-{{ $visit->id }}">
                    <span style="color: #999; font-size: 13px;">{{ __('messages.no_note_history') ?? 'No note history available' }}</span>
                </div>
            @endif
        </div>
    </div>
</div>
