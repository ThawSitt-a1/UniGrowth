<div>
    {{-- Success Flash Message --}}
    @if (session()->has('message'))
        <div class="alert alert-success d-flex align-items-center gap-2 py-3 px-4 mb-4 rounded-3 small" role="alert">
            <i class="bi bi-check-circle-fill flex-shrink-0"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger py-3 px-4 mb-4 rounded-3 small">
            <ul class="list-unstyled mb-0">
                @foreach ($errors->all() as $error)
                    <li><i class="bi bi-exclamation-triangle me-1"></i>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <style>
        /* Component-scoped — inherits profile page design tokens */
        .profile-livewire .profile-form-label {
            color: var(--text-strong, #334155);
            font-weight: 600;
        }
        .profile-livewire .profile-avatar-preview {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--border-brand, #e0e7ff);
        }
        .profile-livewire .profile-avatar-fallback {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 1.8rem;
            background: var(--gradient-brand, linear-gradient(135deg, #6366f1, #7c3aed));
            color: #fff;
        }
        .profile-livewire .input-group-text {
            background-color: var(--bg-elevated, #f1f5f9);
            border-color: var(--border-default, #e2e8f0);
            color: var(--text-body, #475569);
            transition: background-color var(--duration-normal, 0.25s) var(--ease-out, ease),
                        border-color var(--duration-normal, 0.25s) var(--ease-out, ease);
        }
        .profile-livewire .input-group .form-control {
            border-color: var(--border-default, #e2e8f0);
        }
        .profile-livewire .btn-save-profile {
            background: var(--gradient-brand, linear-gradient(135deg, #6366f1, #7c3aed));
            color: #fff;
            border: none;
            border-radius: var(--radius-md, 10px);
            padding: 0.5rem 1.25rem;
            font-weight: 600;
            transition: transform var(--duration-fast, 0.15s) var(--ease-out, ease),
                        box-shadow var(--duration-fast, 0.15s) var(--ease-out, ease);
        }
        .profile-livewire .btn-save-profile:hover {
            transform: translateY(-1px);
            box-shadow: var(--shadow-brand, 0 6px 20px rgba(99, 102, 241, 0.28));
            color: #fff;
        }
    </style>

    <div class="profile-livewire">
    {{-- Profile Picture Upload --}}
    <div class="mb-4">
        <label class="form-label profile-form-label">Profile Picture</label>
        <div class="d-flex align-items-center gap-3">
            @if ($photo_preview_visible && $photo_preview_url)
                <img src="{{ $photo_preview_url }}" alt="Preview"
                     class="profile-avatar-preview">
            @elseif (!empty(auth()->user()->avatar_path))
                <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}" alt="Avatar"
                     class="profile-avatar-preview">
            @else
                <div class="profile-avatar-fallback">
                    {{ strtoupper(substr($username ?: 'U', 0, 1)) }}
                </div>
            @endif
            <div>
                <input type="file" wire:model.live="profile_photo" accept="image/jpeg,image/png"
                       class="form-control form-control-sm">
                <small class="text-muted">Max size 2MB. Formats: JPG, PNG.</small>
            </div>
        </div>
        @error('profile_photo')
            <small class="text-danger mt-1 d-block">{{ $message }}</small>
        @enderror
    </div>

    {{-- Grid Input Fields --}}
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label profile-form-label">Username</label>
            <input type="text" wire:model="username" class="form-control" placeholder="Your username">
            @error('username') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label profile-form-label">Major</label>
            <input type="text" wire:model="major" class="form-control" placeholder="e.g. Computer Science">
            @error('major') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label profile-form-label">Academic Year</label>
<select wire:model="academic_year" class="form-select">
                <option value="">Select year</option>
                @foreach (['1st Year', '2nd Year', '3rd Year', '4th Year', '5th Year', 'Graduate'] as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
            @error('academic_year') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="col-12">
            <label class="form-label profile-form-label">University Name</label>
            <input type="text" wire:model="university_name" class="form-control" placeholder="e.g. Stanford University">
            @error('university_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>

{{-- Profile Description --}}
    <div class="mt-4">
        <label class="form-label profile-form-label">📝 About / Description</label>
        <textarea wire:model="description" rows="3" class="form-control" maxlength="1000"
                  placeholder="Write a short introduction about yourself, your interests, and your goals..."></textarea>
        <small class="text-muted">Share a brief description about yourself. This may be shown on your public profile.</small>
        @error('description') <small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Submit Button --}}
    <div class="mt-4 d-flex justify-content-end">
        <button type="button" wire:click="save" wire:loading.attr="disabled"
                class="btn btn-save-profile px-5">
            <span wire:loading.remove wire:target="save">
                <i class="bi bi-check2-circle me-1"></i>Save Changes
            </span>
            <span wire:loading wire:target="save">
                <span class="spinner-border spinner-border-sm me-1" role="status"></span>Saving...
            </span>
        </button>
    </div>
    </div>
</div>
