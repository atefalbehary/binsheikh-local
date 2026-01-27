# Auth Window Icon Positioning Fix - Arabic RTL Support

## Issue
When the Arabic language was selected in the auth window (login/registration modal), the input field icons were appearing in the center instead of on the right side where they should be for RTL (Right-to-Left) layout. The English version had correct icon placement on the left side.

## Root Cause
1. The HTML `lang` attribute was hardcoded to "en" instead of dynamically using the `$locale` variable
2. The `registration-form-fixes.css` file had icon positioning rules that forced all icons to the left side without RTL considerations
3. No RTL-specific CSS rules existed to override icon positioning for Arabic language

## Changes Made

### 1. Fixed HTML Lang Attribute
**File:** `resources/views/front_end/template/layout.blade.php`
- **Line 14:** Changed `<html lang="en">` to `<html lang="{{ $locale }}">`
- **Why:** This ensures the browser correctly identifies the page language, allowing CSS selectors like `html[lang="ar"]` to work properly

### 2. Added RTL Icon Support
**File:** `public/front-assets/css/registration-form-fixes.css`

#### Input Field Icons (lines 196-207)
```css
/* RTL (Arabic) - Icon alignment on the right */
html[lang="ar"] .main-register .cs-intputwrap i {
    left: auto;
    right: 20px;
}

/* Adjust input padding for RTL to accommodate right-side icon */
html[lang="ar"] .main-register .cs-intputwrap input[type="text"],
html[lang="ar"] .main-register .cs-intputwrap input[type="email"],
html[lang="ar"] .main-register .cs-intputwrap input[type="password"] {
    padding: 10px 50px 10px 20px;
}
```

#### Phone Verification Button (lines 17-22, 52-56)
```css
/* RTL (Arabic) - Verify button on the left */
html[lang="ar"] .view-view-button-verify-phone {
    right: auto;
    left: 10px;
}

/* RTL (Arabic) - Adjust phone input padding */
html[lang="ar"] .cs-intputwrap input[name="phone"] {
    padding: 10px 50px 10px 70px !important;
}
```

#### Password Toggle Button (lines 251-256, 260-264)
```css
/* RTL (Arabic) - Password toggle on the left */
html[lang="ar"] .main-register .view-pass {
    right: auto;
    left: 14px;
}

/* RTL (Arabic) - Adjust password input padding */
html[lang="ar"] .main-register .pass-input-wrap input {
    padding: 10px 20px 10px 45px !important;
}
```

## How It Works

### English (LTR - Left to Right)
- Icons appear on the **left** side of input fields
- Text flows from left to right
- Buttons (verify, password toggle) are on the **right** side

### Arabic (RTL - Right to Left)
- Icons appear on the **right** side of input fields (correct for RTL)
- Text flows from right to left
- Buttons (verify, password toggle) are on the **left** side (end position in RTL)
- Input padding is adjusted to prevent text from overlapping with icons/buttons

## Visual Layout

### English (Before & After - No Change)
```
┌─────────────────────────────────┐
│ 🔒 [Password text........] 👁️ │
│ icon                     toggle │
└─────────────────────────────────┘
```

### Arabic (Before - BROKEN)
```
┌─────────────────────────────────┐
│  [........نص كلمة المرور] 🔒   │
│           icon in center        │
└─────────────────────────────────┘
```

### Arabic (After - FIXED)
```
┌─────────────────────────────────┐
│👁️ [نص كلمة المرور........] 🔒  │
│toggle                    icon   │
└─────────────────────────────────┘
```

## Testing
To test the fix:
1. Open the website
2. Click "Sign In" or "Register" button to open the auth modal
3. Switch language to Arabic using the language toggle
4. Verify that:
   - All input field icons (user, email, lock, phone) are on the **right** side
   - The password toggle (eye icon) is on the **left** side
   - The phone verify button is on the **left** side
   - Text doesn't overlap with icons
5. Switch back to English and verify icons remain on the **left** side

## Files Modified
1. `resources/views/front_end/template/layout.blade.php` - Line 14
2. `public/front-assets/css/registration-form-fixes.css` - Multiple sections

## Impact
- ✅ English version: No change, icons remain correctly positioned on the left
- ✅ Arabic version: Icons now correctly positioned on the right
- ✅ No breaking changes to existing functionality
- ✅ Proper RTL support throughout the auth modal
