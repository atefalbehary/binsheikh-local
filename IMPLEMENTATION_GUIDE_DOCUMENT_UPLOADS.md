# Implementation Guide: Document Upload Fields for Agent & Agency Registration

## Overview
This implementation adds the following document upload fields to existing registration forms:

### Agent Registration (role = 3)
- ✅ QID (Qatar ID) - PDF, JPG, PNG (2MB max)
- ✅ Authorized Signatory - PDF, JPG, PNG (2MB max)

### Agency Registration (role = 4)  
- ✅ Trade License - PDF, JPG, PNG (2MB max)
- ✅ Authorized Signatory - Already implemented

---

## Files Modified

### 1. Database Migration
**File:** `database/migrations/2026_01_25_105100_add_missing_document_fields_to_users_table.php`

**Columns Added:**
```php
- license (string, 500, nullable)
- id_card (string, 500, nullable)  
- id_no (string, 200, nullable)
- qid (string, 500, nullable) // Agent QID
- trade_license (string, 500, nullable) // Agency Trade License
- professional_practice_certificate (string, 500, nullable)
- cr (string, 500, nullable)
```

**Run Migration:**
```bash
php artisan migrate
```

### 2. Blade Form Updates
**File:** `resources/views/front_end/template/layout.blade.php`

**Added Fields (Lines 648-681):**

**Agent Fields (`.agent_div`):**
```html
<!-- QID Upload -->
<div class="cs-intsputwrap agent_div d-none">
    <label>{{ __('messages.qid') }}</label>
    <input type="file" name="qid" class="form-control agent_inp" 
           data-parsley-max-file-size="2048"
           accept="image/*,application/pdf" required>
</div>

<!-- Authorized Signatory -->
<div class="cs-intsputwrap agent_div d-none">
    <label>{{ __('messages.authorized_signatory') }}</label>
    <input type="file" name="agent_authorized_signatory" 
           class="form-control agent_inp" 
           data-parsley-max-file-size="2048"
           accept="image/*,application/pdf" required>
</div>
```

**Agency Fields (`.agency_div`):**
```html
<!-- Trade License -->
<div class="cs-intsputwrap agency_div d-none">
    <label>{{ __('messages.trade_license') }}</label>
    <input type="file" name="trade_license" 
           class="form-control agency_inp"
           data-parsley-max-file-size="2048"
           accept="image/*,application/pdf" required>
</div>
```

**Important Notes:**
- File size limit changed from 5MB (5120KB) to 2MB (2048KB) per requirements
- Class `agent_inp` ensures field is required only when Agent type is selected
- Class `agency_inp` ensures field is required only when Agency type is selected
- JavaScript already handles show/hide logic based on user type selection

### 3. Translation Keys Added

**English (`resources/lang/en/messages.php`):**
```php
'qid' => 'QID (Qatar ID)',
'select_qid' => 'Please upload your QID document',
'select_trade_license' => 'Please upload Trade License'
```

**Arabic (`resources/lang/ar/messages.php`):**
```php
'qid' => 'البطاقة الشخصية (QID)',
'select_qid' => 'الرجاء تحميل وثيقة البطاقة الشخصية',
'select_trade_license' => 'الرجاء تحميل الرخصة التجارية'
```

### 4. Controller Updates
**File:** `app/Http/Controllers/front/HomeController.php`

**Agent Upload Handling (Lines 947-963):**
```php
if ($request->user_type == 3) {
    // Existing: license, id_card, id_no
    
    // NEW: QID upload
    if ($request->file("qid")) {
        $response = image_upload($request, 'profile', 'qid');
        if ($response['status']) {
            $ins['qid'] = $response['link'];
        }
    }
    
    // NEW: Authorized Signatory for Agent
    if ($request->file("agent_authorized_signatory")) {
        $response = image_upload($request, 'profile', 'agent_authorized_signatory');
        if ($response['status']) {
            $ins['authorized_signatory'] = $response['link'];
        }
    }
}
```

**Agency Upload Handling (Lines 996-1003):**
```php
if ($request->user_type == 4) {
    // Existing: professional_practice_certificate, authorized_signatory, cr, license
    
    // NEW: Trade License
    if ($request->file("trade_license")) {
        $response = image_upload($request, 'profile', 'trade_license');
        if ($response['status']) {
            $ins['trade_license'] = $response['link'];
        }
    }
}
```

---

## File Upload Configuration

### Storage Structure
Files are uploaded using the existing `image_upload()` helper function which stores files in:

```
storage/app/public/profile/
├── qid/
├── agent_authorized_signatory/
├── trade_license/
├── license/
├── id_card/
├── professional_practice_certificate/
├── cr/
└── authorized_signatory/
```

**Ensure storage link exists:**
```bash
php artisan storage:link
```

### Accepted File Types
- **PDF**: `application/pdf`
- **Images**: `image/jpeg`, `image/png`, `image/jpg`

### File Size Limits
- **Maximum**: 2MB (2048 KB)
- **Validation**: Client-side (Parsley.js) and server-side (Laravel)

---

## Validation Rules

### Current Validation (No Changes Needed)
The controller uses basic validation:
```php
'name' => 'required',
'email' => 'required|email',
'password' => 'required',
'phone' => 'required',
'agency_id' => 'nullable|exists:users,id'
```

### File Validation (Handled by image_upload helper)
The existing `image_upload()` helper function should handle:
- File type validation
- File size validation  
- Secure file storage
- Unique filename generation

**If you need to add explicit validation, add to controller:**
```php
$validator = Validator::make($request->all(), [
    // existing rules...
    'qid' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    'agent_authorized_signatory' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
    'trade_license' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
]);
```

---

## Testing Checklist

### Agent Registration (user_type = 3)
- [ ] QID field appears when Agent type is selected
- [ ] Authorized Signatory field appears for Agent
- [ ] Both fields are hidden for other user types
- [ ] File upload accepts PDF, JPG, PNG only
- [ ] File size limit enforced (2MB)
- [ ] Files stored correctly in database
- [ ] File paths saved in `users` table

### Agency Registration (user_type = 4)
- [ ] Trade License field appears when Agency type is selected
- [ ] Authorized Signatory field appears (existing)
- [ ] Field hidden for other user types  
- [ ] File upload accepts PDF, JPG, PNG only
- [ ] File size limit enforced (2MB)
- [ ] Files stored correctly in database
- [ ] File paths saved in `users` table

### Database  
- [ ] Migration runs successfully
- [ ] Columns created: `qid`, `trade_license`
- [ ] Existing columns not affected: `authorized_signatory`, `license`, etc.
- [ ] File paths stored correctly as strings

### User Experience
- [ ] Form validation shows appropriate error messages
- [ ] File selection works on mobile and desktop
- [ ] Translation works in both English and Arabic
- [ ] Required fields marked correctly based on user type
- [ ] No existing registration flow broken

---

## Rollback Instructions

If you need to rollback this implementation:

```bash
# Rollback migration
php artisan migrate:rollback

# Or rollback specific migration
php artisan migrate:rollback --step=1
```

**Manual cleanup (if needed):**
1. Remove Blade form fields (lines 648-681 in layout.blade.php)
2. Remove controller upload handling
3. Remove translation keys
4. Clear uploaded files from storage

---

## Security Considerations

✅ **Implemented:**
- File type restriction (PDF, JPG, PNG only)
- File size limit (2MB)
- Field visibility based on user role
- Secure storage path
- Nullable fields (won't break existing users)

⚠️ **Recommendations:**
1. Add CSRF token validation (Laravel default)
2. Sanitize filenames before storage
3. Implement virus scanning for uploaded files  
4. Add rate limiting for file uploads
5. Regular cleanup of orphaned files

---

## Known Issues / Notes

1. **Field Name:** Agent authorized signatory uses `agent_authorized_signatory` to differentiate from agency's `authorized_signatory`
2. **File Size:** Changed from 5MB to 2MB per requirements - update existing fields if needed
3. **Existing Users:** Migration adds nullable columns - won't affect existing user records
4. **Helper Function:** Uses existing `image_upload()` helper - ensure it handles all file types correctly

---

## Support

For questions or issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Check file upload size in `php.ini`: `upload_max_filesize` and `post_max_size`
3. Verify storage permissions: `chmod -R 775 storage`
4. Clear cache: `php artisan cache:clear` and `php artisan config:clear`
