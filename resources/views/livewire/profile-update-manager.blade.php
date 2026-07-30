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

    {{-- Profile Picture Upload --}}
    <div class="mb-4">
        <label class="form-label fw-semibold text-gray-700">Profile Picture</label>
        <div class="d-flex align-items-center gap-3">
            @if ($photo_preview_visible && $photo_preview_url)
                <img src="{{ $photo_preview_url }}" alt="Preview"
                     class="rounded-circle object-fit-cover border border-2 border-indigo-200"
                     style="width: 80px; height: 80px;">
            @elseif (!empty(auth()->user()->avatar_path))
                <img src="{{ asset('storage/' . auth()->user()->avatar_path) }}" alt="Avatar"
                     class="rounded-circle object-fit-cover border border-2 border-indigo-200"
                     style="width: 80px; height: 80px;">
            @else
                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white"
                     style="width: 80px; height: 80px; background: linear-gradient(135deg, #6366f1, #7c3aed); font-size: 1.8rem;">
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
            <label class="form-label fw-semibold text-gray-700">Username</label>
            <input type="text" wire:model="username" class="form-control" placeholder="Your username">
            @error('username') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold text-gray-700">Major</label>
            <input type="text" wire:model="major" class="form-control" placeholder="e.g. Computer Science">
            @error('major') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="col-md-4">
            <label class="form-label fw-semibold text-gray-700">Academic Year</label>
            <select wire:model="academic_year" class="form-select">
                <option value="">Select year</option>
                @foreach (['Freshman', 'Sophomore', 'Junior', 'Senior', 'Graduate', 'Postgraduate'] as $year)
                    <option value="{{ $year }}">{{ $year }}</option>
                @endforeach
            </select>
            @error('academic_year') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="col-12">
            <label class="form-label fw-semibold text-gray-700">University Name</label>
            <input type="text" wire:model="university_name" class="form-control" placeholder="e.g. Stanford University">
            @error('university_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
    </div>

    {{-- Social Accounts (Plain Text Info) --}}
    <div class="mt-4">
        <label class="form-label fw-semibold text-gray-700">🔗 Connected Social Accounts</label>
        <div class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-facebook text-primary"></i></span>
                    <input type="text" wire:model="facebook" class="form-control" placeholder="Facebook handle / @username">
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-tiktok text-dark"></i></span>
                    <input type="text" wire:model="tiktok" class="form-control" placeholder="TikTok handle / @username">
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-instagram text-danger"></i></span>
                    <input type="text" wire:model="instagram" class="form-control" placeholder="Instagram handle / @username">
                </div>
            </div>
        </div>
        <small class="text-muted">These are display-only information about your social accounts.</small>
    </div>

    {{-- Submit Button --}}
    <div class="mt-4 d-flex justify-content-end">
        <button type="button" wire:click="save" wire:loading.attr="disabled"
                class="btn px-5 py-2 fw-semibold text-white border-0"
                style="background: linear-gradient(135deg, #6366f1, #7c3aed); border-radius: 10px; transition: all 0.2s;">
            <span wire:loading.remove wire:target="save">
                <i class="bi bi-check2-circle me-1"></i>Save Changes
            </span>
            <span wire:loading wire:target="save">
                <span class="spinner-border spinner-border-sm me-1" role="status"></span>Saving...
            </span>
        </button>
    </div>
</div>
