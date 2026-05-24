@php
    $d = $note->updated_at->format('M j');
    $pinIcon = $note->pinned ? '📌' : '';
@endphp
<div class="note-card"
     data-id="{{ $note->id }}"
     style="background:{{ $note->color }}"
     onclick="openModal({{ $note->id }}, '{{ addslashes($note->title) }}', '{{ addslashes($note->body) }}', '{{ $note->color }}', {{ $note->pinned ? 'true' : 'false' }})">
    @if($note->pinned)
    <span class="pin-badge">📌</span>
    @endif
    <div class="note-card-title">{{ $note->title ?: '(no title)' }}</div>
    <div class="note-card-body">{{ $note->body }}</div>
    <div class="note-meta">
        <span class="note-date">{{ $d }}</span>
        <div class="note-actions">
            <button class="action-btn" title="{{ $note->pinned ? 'Unpin' : 'Pin' }}"
                onclick="togglePin({{ $note->id }}, {{ $note->pinned ? 'true' : 'false' }}, event)">
                {{ $note->pinned ? '📍' : '📌' }}
            </button>
            <button class="action-btn danger" title="Delete"
                onclick="deleteNote({{ $note->id }}, event)">🗑</button>
        </div>
    </div>
</div>
