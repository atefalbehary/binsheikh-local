# Test Accounts - Demo Credentials

This document contains the credentials for all testing accounts created for the application.

## 🧪 Test Accounts Overview

All test accounts use the same password for convenience: **password123**

---

## 👤 Regular User Account

- **Email:** `testuser@demo.com`
- **Password:** `password123`
- **User Type:** User (Role: 2)
- **Status:** Active & Verified
- **Phone:** +974 11111111

### Description
Regular user account for testing standard user features like browsing properties, making bookings, favorites, etc.

---

## 🏢 Agent Account

- **Email:** `testagent@demo.com`
- **Password:** `password123`
- **User Type:** Agent (Role: 3)
- **Status:** Active & Verified
- **Phone:** +974 22222222

### Description
Agent account for testing agent-specific features like managing reservations, property listings, and client interactions.

---

## 🏛️ Agency Account

- **Email:** `testagency@demo.com`
- **Password:** `password123`
- **User Type:** Agency (Role: 4)
- **Status:** Active & Verified
- **Phone:** +974 33333333

### Description
Agency account for testing agency-specific features like managing multiple agents, viewing all agency reservations, and employee management.

---

## 🔑 Quick Reference

| Type   | Email                   | Password     | Role |
|--------|-------------------------|--------------|------|
| User   | testuser@demo.com       | password123  | 2    |
| Agent  | testagent@demo.com      | password123  | 3    |
| Agency | testagency@demo.com     | password123  | 4    |

---

## 📝 Notes

1. All accounts are pre-verified and active, so you can login immediately without email/phone verification
2. The phone numbers are dummy numbers for testing purposes
3. To create more test accounts, you can run the seeder again or modify it as needed:
   ```bash
   php artisan db:seed --class=TestAccountsSeeder
   ```
4. The seeder file is located at: `database/seeders/TestAccountsSeeder.php`

---

## 🔄 Recreating Test Accounts

If you need to recreate these accounts (e.g., after resetting the database), simply run:

```bash
php artisan db:seed --class=TestAccountsSeeder
```

---

**Created:** 2026-01-27

