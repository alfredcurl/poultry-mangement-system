# Migration Guide: Coffee Shop → Poultry Management System

## Overview
This document outlines the transformation of the Laravel coffee e-commerce application into a comprehensive Poultry Management System.

## Changes Summary

### 1. Database Migrations

#### New Migrations Created
All new migrations are dated 2025-11-25 for easy identification:

1. `2025_11_25_120000_create_birds_table.php`
2. `2025_11_25_120100_create_mortality_records_table.php`
3. `2025_11_25_120200_create_egg_production_table.php`
4. `2025_11_25_120300_create_feeds_table.php`
5. `2025_11_25_120400_create_medications_table.php`
6. `2025_11_25_120500_create_feed_usage_table.php`
7. `2025_11_25_120600_create_medication_usage_table.php`
8. `2025_11_25_120700_create_expenses_table.php`

#### Modified Migrations
- `2022_08_02_142955_create_products_table.php` - Updated to support egg products

### 2. Models Created

New models in `app/Models/`:
- `Bird.php` - Bird inventory management
- `MortalityRecord.php` - Mortality tracking
- `EggProduction.php` - Egg production records
- `Feed.php` - Feed inventory
- `Medication.php` - Medication inventory
- `FeedUsage.php` - Feed consumption tracking
- `MedicationUsage.php` - Medication administration tracking
- `Expense.php` - Operational expenses

Modified models:
- `Product.php` - Updated fillable fields for egg products

### 3. Controllers Created

New controllers in `app/Http/Controllers/`:
- `BirdController.php` - Bird CRUD operations
- `MortalityController.php` - Mortality record management
- `EggProductionController.php` - Production tracking and reports
- `FeedController.php` - Feed inventory and usage
- `MedicationController.php` - Medication inventory and usage
- `ExpenseController.php` - Expense management
- `ReportController.php` - Dashboard and comprehensive reports

### 4. Routes Updated

File: `routes/web.php`

Added new route groups:
- `/birds/*` - Bird management routes
- `/mortality/*` - Mortality tracking routes
- `/egg-production/*` - Production management routes
- `/feeds/*` - Feed management routes
- `/medications/*` - Medication management routes
- `/expenses/*` - Expense management routes
- `/reports/*` - Reporting and analytics routes

New chart endpoint:
- `/chart/egg_production_chart` - Weekly egg production visualization

### 5. Seeders Modified

File: `database/seeders/ProductSeeder.php`
- Replaced coffee products with egg products
- Added 5 egg product variants (small, medium, large, extra-large, mixed)

## Migration Steps

### Step 1: Backup Current Database
```bash
# Backup your current database before proceeding
mysqldump -u username -p database_name > backup_before_migration.sql
```

### Step 2: Run New Migrations
```bash
# Run all new migrations
php artisan migrate

# If you want to start fresh (WARNING: This will delete all data)
php artisan migrate:fresh --seed
```

### Step 3: Update Product Data
If you have existing products and want to keep them:
```sql
-- Add default values for new columns
UPDATE products SET 
    egg_size = 'medium',
    quantity_per_unit = 30
WHERE egg_size IS NULL;
```

Or run the seeder to replace with egg products:
```bash
php artisan db:seed --class=ProductSeeder
```

### Step 4: Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

### Step 5: Test the Application
```bash
php artisan serve
```

Visit:
- Customer view: `http://localhost:8000/product`
- Admin dashboard: `http://localhost:8000/reports/dashboard`

## Data Migration Considerations

### Existing Orders
- Existing orders will continue to work
- They reference products by ID, so ensure product IDs remain consistent
- Or update order records to reference new egg products

### Existing Users
- All user accounts remain unchanged
- Admin users can access new poultry management features
- Customer users can continue to place orders for eggs

### Existing Transactions
- Transaction records remain for historical profit/loss reporting
- New expense tracking complements existing transaction system

## Feature Mapping

### Before (Coffee Shop) → After (Poultry Farm)

| Coffee Shop Feature | Poultry Farm Feature |
|-------------------|---------------------|
| Coffee Products | Egg Products (by size) |
| Product Stock | Egg Inventory |
| Orders | Egg Sales Orders |
| Transactions | Financial Tracking + Expenses |
| - | Bird Inventory |
| - | Mortality Tracking |
| - | Egg Production Recording |
| - | Feed Management |
| - | Medication Management |
| - | Comprehensive Reports |

## New Admin Capabilities

1. **Inventory Management**
   - Track live bird inventory
   - Monitor feed and medication stock
   - Low stock alerts

2. **Production Tracking**
   - Daily egg collection recording
   - Production reports (daily/monthly/yearly)
   - Damaged vs. good egg tracking

3. **Health Management**
   - Mortality recording and analysis
   - Medication administration tracking
   - Cause of death documentation

4. **Financial Management**
   - Comprehensive expense tracking
   - Profit & Loss reports
   - Cost analysis by category

5. **Analytics**
   - Dashboard with key metrics
   - Production trends
   - Sales analysis
   - Inventory status

## Testing Checklist

After migration, test the following:

### Customer Functions
- [ ] Browse egg products
- [ ] Add products to cart
- [ ] Place orders
- [ ] View order history
- [ ] Upload payment proof
- [ ] Leave product reviews

### Admin Functions
- [ ] View dashboard
- [ ] Add bird batch
- [ ] Record mortality
- [ ] Record daily egg production
- [ ] Add feed stock
- [ ] Record feed usage
- [ ] Add medication stock
- [ ] Record medication usage
- [ ] Add expenses
- [ ] View profit/loss report
- [ ] View sales reports
- [ ] View inventory report
- [ ] Approve/reject orders

## Rollback Plan

If you need to rollback to the original coffee shop system:

```bash
# Restore database from backup
mysql -u username -p database_name < backup_before_migration.sql

# Rollback migrations (if needed)
php artisan migrate:rollback --step=8

# Restore original files from git
git checkout HEAD -- routes/web.php
git checkout HEAD -- database/seeders/ProductSeeder.php
git checkout HEAD -- app/Models/Product.php

# Remove new files
rm app/Models/Bird.php
rm app/Models/MortalityRecord.php
rm app/Models/EggProduction.php
rm app/Models/Feed.php
rm app/Models/Medication.php
rm app/Models/FeedUsage.php
rm app/Models/MedicationUsage.php
rm app/Models/Expense.php
rm app/Http/Controllers/BirdController.php
rm app/Http/Controllers/MortalityController.php
rm app/Http/Controllers/EggProductionController.php
rm app/Http/Controllers/FeedController.php
rm app/Http/Controllers/MedicationController.php
rm app/Http/Controllers/ExpenseController.php
rm app/Http/Controllers/ReportController.php
```

## Next Steps

1. **Create Views**: You'll need to create Blade templates for all the new features
2. **Add Policies**: Implement authorization policies for admin-only features
3. **Add Validation**: Enhance form validation rules
4. **Create Tests**: Write unit and feature tests
5. **Add Images**: Add egg product images to `public/product/` directory
6. **Customize UI**: Update branding from coffee to poultry theme

## Support

For questions or issues during migration:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Review migration output for errors
3. Verify database schema matches expectations
4. Test with sample data before production use

## Notes

- All new features are admin-only by default (protected by `can:is_admin` middleware)
- Customer-facing features (product browsing, ordering) remain unchanged in structure
- The system maintains backward compatibility with existing user authentication
- All monetary values use decimal(10,2) for precision
- Dates are properly cast in models for easy manipulation
