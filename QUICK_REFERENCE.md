# Quick Reference Guide - Poultry Management System

## 🚀 Quick Start

```bash
# Your server should already be running
# If not, start it with:
php artisan serve

# Then visit: http://localhost:8000
```

## 📍 Important URLs

### Admin Dashboard
- **Main Dashboard:** http://localhost:8000/home
- **Customers:** http://localhost:8000/home/customers

### Poultry Management
- **Birds:** http://localhost:8000/birds
- **Mortality:** http://localhost:8000/mortality
- **Egg Production:** http://localhost:8000/egg-production
- **Feeds:** http://localhost:8000/feeds
- **Medications:** http://localhost:8000/medications
- **Expenses:** http://localhost:8000/expenses

### Sales & Products
- **Egg Products:** http://localhost:8000/product
- **Orders:** http://localhost:8000/order/order_data
- **Transactions:** http://localhost:8000/transaction

## 🎯 Common Tasks

### Daily Operations

**1. Record Egg Production:**
- Go to: `/egg-production/create`
- Select bird batch
- Enter eggs collected and damaged
- System auto-calculates good eggs

**2. Record Feed Usage:**
- Go to: `/feeds/usage/create`
- Select feed and bird batch
- Enter quantity used
- System validates against available stock

**3. Check Dashboard:**
- Go to: `/home`
- View today's production
- Check low stock alerts
- Monitor pending orders

### Weekly Tasks

**1. Review Production:**
- Go to: `/egg-production/daily-report`
- Check production trends
- Identify any issues

**2. Check Inventory:**
- Feeds: `/feeds`
- Medications: `/medications`
- Reorder if low stock

### Monthly Tasks

**1. Review Reports:**
- Monthly Production: `/egg-production/monthly-report`
- Monthly Expenses: `/expenses/monthly-report`
- Check profit/loss trends

**2. Record Mortality (if any):**
- Go to: `/mortality/create`
- Select bird batch
- Enter death count and cause

### As Needed

**1. Add New Bird Batch:**
- Go to: `/birds/create`
- Enter type, breed, quantity, age
- Record acquisition cost

**2. Add Feed Stock:**
- Go to: `/feeds/create`
- Enter feed details and quantity
- Record purchase cost

**3. Add Medication:**
- Go to: `/medications/create`
- Enter medication details
- Record purchase cost

**4. Record Expense:**
- Go to: `/expenses/create`
- Select expense type
- Enter amount and details

## 📊 Dashboard Metrics Explained

### Today's Eggs
- Shows eggs collected today (good eggs only)
- Click to view production records

### Monthly Sales
- Total revenue from egg sales this month
- Click to view all orders

### Active Birds
- Current bird count (adjusted for mortality)
- Click to manage bird inventory

### Monthly Mortality
- Number of bird deaths this month
- Click to view mortality records

### Pending Orders
- Orders awaiting approval/processing
- Check regularly to process orders

### Low Stock Alerts
- Feeds < 50kg
- Medications < 10 units
- Reorder when alerted

## 🗂️ File Structure

```
N-M-Poultry-Farm/
├── app/
│   ├── Http/Controllers/
│   │   ├── BirdController.php
│   │   ├── MortalityController.php
│   │   ├── EggProductionController.php
│   │   ├── FeedController.php
│   │   ├── MedicationController.php
│   │   ├── ExpenseController.php
│   │   └── ReportController.php
│   └── Models/
│       ├── Bird.php
│       ├── MortalityRecord.php
│       ├── EggProduction.php
│       ├── Feed.php
│       ├── Medication.php
│       ├── FeedUsage.php
│       ├── MedicationUsage.php
│       └── Expense.php
├── database/
│   ├── migrations/
│   │   ├── 2025_11_25_120000_create_birds_table.php
│   │   ├── 2025_11_25_120100_create_mortality_records_table.php
│   │   ├── 2025_11_25_120200_create_egg_production_table.php
│   │   ├── 2025_11_25_120300_create_feeds_table.php
│   │   ├── 2025_11_25_120400_create_medications_table.php
│   │   ├── 2025_11_25_120500_create_feed_usage_table.php
│   │   ├── 2025_11_25_120600_create_medication_usage_table.php
│   │   └── 2025_11_25_120700_create_expenses_table.php
│   └── seeders/
│       └── ProductSeeder.php (updated with eggs)
├── resources/views/
│   ├── home/
│   │   └── index.blade.php (updated)
│   └── partials/
│       ├── home/
│       │   └── home_admin.blade.php (updated dashboard)
│       └── sidebar.blade.php (updated navigation)
├── routes/
│   └── web.php (updated with new routes)
├── README.md
├── MIGRATION_GUIDE.md
├── TRANSFORMATION_SUMMARY.md
└── SETUP_COMPLETE.md
```

## 🔑 Key Concepts

### Bird Batches
- Each batch represents a group of birds
- Track by type (Layer/Broiler) and breed
- Monitor age and status

### Current Quantity
- Automatically calculated
- Original quantity - total deaths
- Always up-to-date

### Good Eggs
- Automatically calculated
- Eggs collected - damaged eggs
- Used for sales

### Stock Levels
- Feeds: Original - total usage
- Medications: Original - total usage
- Real-time tracking

### Profit/Loss
- Revenue: Egg sales
- Expenses: Feeds + Meds + Birds + Operations
- Profit = Revenue - Expenses

## ⚠️ Important Notes

1. **Add Birds First:** Before recording production or mortality
2. **Daily Production:** Record every day for accurate trends
3. **Stock Validation:** System prevents using more than available
4. **Mortality Validation:** Can't exceed current bird count
5. **Admin Only:** All poultry features require admin role

## 🎨 Customization

### Change Currency
Edit: `resources/views/partials/home/home_admin.blade.php`
Find: `₦` and replace with your currency symbol

### Adjust Low Stock Thresholds
Edit: `app/Http/Controllers/HomeController.php`
- Feeds: Line with `< 50` (currently 50kg)
- Medications: Line with `< 10` (currently 10 units)

### Add More Egg Products
Run: `php artisan tinker`
```php
App\Models\Product::create([
    'product_name' => 'Your Product Name',
    'egg_size' => 'large',
    'quantity_per_unit' => 30,
    'description' => 'Description here',
    'price' => 350.00,
    'stock' => 100,
    'discount' => 0,
    'image' => 'product/image.jpg'
]);
```

## 📱 Mobile Access

The system is responsive and works on mobile devices:
- Access from phone/tablet
- Same URL: http://your-server-ip:8000
- All features available

## 🔐 Security

- All poultry routes protected by admin middleware
- Customer routes protected by auth middleware
- Data validation on all inputs
- SQL injection protection (Laravel ORM)

## 💾 Backup

Regular backups recommended:

```bash
# Database backup
php artisan db:backup

# Or manual:
mysqldump -u username -p database_name > backup.sql
```

## 🆘 Troubleshooting

### Dashboard shows 0 for everything
- **Cause:** No data entered yet
- **Solution:** Start adding birds and recording production

### Low stock alerts not showing
- **Cause:** Stock levels above threshold
- **Solution:** This is normal, alerts show when stock is low

### Can't access poultry features
- **Cause:** Not logged in as admin
- **Solution:** Login with admin account (role_id = 1)

### Routes not found
- **Cause:** Cache issue
- **Solution:** Run `php artisan route:clear`

## 📞 Support

For issues:
1. Check Laravel logs: `storage/logs/laravel.log`
2. Review documentation files
3. Check database connections in `.env`

---

**Happy Farming! 🐔🥚**
