@extends('seller.layouts.app')
@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div style="max-width:640px;">
    <div class="sp-card">
        <div class="sp-card-header">
            <span class="sp-card-title">Profile Information</span>
        </div>
        <div class="sp-card-body">
            <form method="POST" action="{{ route('seller.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div style="display:flex;align-items:center;gap:20px;margin-bottom:24px;padding-bottom:20px;border-bottom:1px solid #e2e8f0;">
                    @if($seller->profile_photo && file_exists(public_path($seller->profile_photo)))
                        <img src="{{ asset($seller->profile_photo) }}" alt="" style="width:72px;height:72px;border-radius:50%;object-fit:cover;border:3px solid #e2e8f0;">
                    @else
                        <div style="width:72px;height:72px;border-radius:50%;background:#011f4b;display:flex;align-items:center;justify-content:center;font-size:26px;font-weight:700;color:#fff;flex-shrink:0;">
                            {{ strtoupper(substr($seller->name,0,1)) }}
                        </div>
                    @endif
                    <div>
                        <label class="sp-label">Change Profile Photo</label>
                        <input type="file" name="profile_photo" accept="image/*" class="sp-input" style="padding:6px;">
                        <div class="sp-hint">JPG/PNG, max 2MB</div>
                    </div>
                </div>

                <div class="sp-form-row cols-2">
                    <div>
                        <label class="sp-label">Full Name <span class="req" style="color:#dc2626;">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $seller->name) }}" class="sp-input {{ $errors->has('name') ? 'error' : '' }}" required>
                        @error('name') <div class="sp-error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="sp-label">Email (cannot change)</label>
                        <input type="email" value="{{ $seller->email }}" class="sp-input" disabled style="background:#f8fafc;color:#94a3b8;">
                    </div>
                </div>

                <div class="sp-form-row cols-2">
                    <div>
                        <label class="sp-label">Phone <span class="req" style="color:#dc2626;">*</span></label>
                        <input type="tel" name="phone" value="{{ old('phone', $seller->phone) }}" class="sp-input {{ $errors->has('phone') ? 'error' : '' }}" required>
                        @error('phone') <div class="sp-error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="sp-label">WhatsApp Number</label>
                        <input type="tel" name="whatsapp" value="{{ old('whatsapp', $seller->whatsapp) }}" class="sp-input" placeholder="If different from phone">
                    </div>
                </div>

                <div class="sp-form-row">
                    <div>
                        <label class="sp-label">City</label>
                        <input type="text" name="city" value="{{ old('city', $seller->city) }}" class="sp-input">
                    </div>
                </div>

                <div class="sp-form-row">
                    <div>
                        <label class="sp-label">About / Agency Bio</label>
                        <textarea name="about" class="sp-textarea">{{ old('about', $seller->about) }}</textarea>
                    </div>
                </div>

                <hr style="margin:20px 0;border:none;border-top:1px solid #e2e8f0;">
                <div style="font-size:13.5px;font-weight:600;color:#011f4b;margin-bottom:14px;">Change Password</div>

                <div class="sp-form-row cols-2">
                    <div>
                        <label class="sp-label">New Password</label>
                        <input type="password" name="password" class="sp-input {{ $errors->has('password') ? 'error' : '' }}" placeholder="Leave blank to keep current">
                        @error('password') <div class="sp-error-msg">{{ $message }}</div> @enderror
                    </div>
                    <div>
                        <label class="sp-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="sp-input" placeholder="Re-enter new password">
                    </div>
                </div>

                <div style="display:flex;gap:12px;margin-top:8px;">
                    <button type="submit" class="sp-btn sp-btn-primary">Save Changes</button>
                    <a href="{{ route('seller.dashboard') }}" class="sp-btn sp-btn-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
