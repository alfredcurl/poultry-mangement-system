# Poultry Management System

This Laravel application has been transformed from a coffee e-commerce system into a comprehensive **Poultry Management System** for managing poultry farms, egg production, sales, and operations.

## Features

### Customer Features
- **Browse & Buy Eggs**: Customers can browse different egg products (small, medium, large, extra-large) and place orders
- **Order Tracking**: Track order status and history
- **User Profile**: Manage personal information and view order history
- **Reviews**: Leave reviews for egg products

### Admin Features

#### 1. **Bird Management**
- Add and track bird batches (type, breed, quantity, age)
- Monitor bird status (active, sold, deceased)
- Track acquisition costs and dates
- View current bird inventory with mortality adjustments

#### 2. **Mortality Tracking**
- Record bird deaths with date, count, and cause
- Automatic validation against current bird quantities
- Historical mortality records
- Monthly mortality reports

#### 3. **Egg Production Management**
- Daily egg collection recording
- Track damaged vs. good eggs
- Automatic calculation of usable eggs
- Daily, monthly, and yearly production reports
- Production tracking per bird batch

#### 4. **Feed Management**
- Feed inventory tracking (type, quantity, supplier)
- Feed purchase recording with costs
- Feed usage tracking per bird batch
- Remaining stock calculations
- Low stock alerts
- Expiry date monitoring

#### 5. **Medication Management**
- Medication inventory (vaccines, antibiotics, vitamins)
- Track medication purchases and costs
- Record medication administration to bird batches
- Remaining stock calculations
- Low stock alerts
- Expiry date monitoring

#### 6. **Expense Tracking**
- Record various operational expenses (utilities, labor, maintenance, transport)
- Categorize expenses by type
- Receipt number tracking
- Monthly expense reports
- Expense analysis by category

#### 7. **Sales Management**
- Track egg sales to customers
- Order approval/rejection workflow
- Payment verification
- Sales reports (daily, monthly, yearly)
- Revenue tracking

#### 8. **Reports & Analytics**
- **Dashboard**: Overview of key metrics (today's production, monthly sales, bird count, mortality)
- **Profit & Loss Report**: Comprehensive P&L with income vs. all expenses
- **Sales Reports**: Detailed sales analysis by period
- **Inventory Reports**: Current stock levels for birds, feeds, medications, and eggs
- **Production Reports**: Egg production trends and analysis
- **Expense Reports**: Expense breakdown by category

## Database Structure

### New Tables Created

1. **birds** - Bird inventory management
   - bird_type, breed, quantity, acquisition_date, acquisition_cost, age_in_weeks, status

2. **mortality_records** - Track bird deaths
   - bird_id, death_date, number_of_deaths, cause_of_death

3. **egg_production** - Daily egg collection
   - bird_id, production_date, eggs_collected, damaged_eggs, good_eggs

4. **feeds** - Feed inventory
   - feed_name, feed_type, supplier, quantity_in_kg, unit_price, total_cost, purchase_date, expiry_date

5. **medications** - Medication inventory
   - medication_name, medication_type, supplier, quantity, unit, unit_price, total_cost, purchase_date, expiry_date

6. **feed_usage** - Track feed consumption
   - feed_id, bird_id, usage_date, quantity_used_kg

7. **medication_usage** - Track medication administration
   - medication_id, bird_id, administration_date, quantity_used, administered_by, reason

8. **expenses** - Operational expenses
   - expense_type, description, amount, expense_date, paid_to, receipt_number

### Modified Tables

1. **products** - Modified for egg products
   - Added: egg_size, quantity_per_unit
   - Removed: orientation
   - Modified: price (now decimal), image (nullable)

2. **users, orders, transactions** - Retained with existing structure for authentication and sales

## Installation & Setup

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Environment Setup
```bash
cp .env.example .env
php artisan key:generate
```

### 3. Database Configuration
Update `.env` with your database credentials:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=poultry_management
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Run Migrations
```bash
php artisan migrate:fresh
```

### 5. Seed Database
```bash
php artisan db:seed --class=RoleSeeder
php artisan db:seed --class=UserSeeder
php artisan db:seed --class=ProductSeeder
php artisan db:seed --class=BankSeeder
php artisan db:seed --class=PaymentSeeder
php artisan db:seed --class=NoteSeeder
php artisan db:seed --class=StatusSeeder
php artisan db:seed --class=CategorySeeder
```

### 6. Run Application
```bash
php artisan serve
npm run dev
```

## Routes Overview

### Customer Routes
- `/` - Landing page
- `/product` - Browse egg products
- `/order/make_order/{product}` - Place order
- `/order/order_history` - View order history

### Admin Routes (Requires Admin Role)

#### Bird Management
- `/birds` - View all birds
- `/birds/create` - Add new bird batch
- `/birds/edit/{bird}` - Edit bird batch

#### Mortality
- `/mortality` - View mortality records
- `/mortality/create` - Record mortality

#### Egg Production
- `/egg-production` - View production records
- `/egg-production/create` - Record daily production
- `/egg-production/daily-report` - Daily report
- `/egg-production/monthly-report` - Monthly report
- `/egg-production/yearly-report` - Yearly report

#### Feed Management
- `/feeds` - View feed inventory
- `/feeds/create` - Add feed stock
- `/feeds/usage` - View feed usage
- `/feeds/usage/create` - Record feed usage

#### Medication Management
- `/medications` - View medication inventory
- `/medications/create` - Add medication stock
- `/medications/usage` - View medication usage
- `/medications/usage/create` - Record medication usage

#### Expenses
- `/expenses` - View expenses
- `/expenses/create` - Add expense
- `/expenses/monthly-report` - Monthly expense report

#### Reports
- `/reports/dashboard` - Main dashboard
- `/reports/profit-loss` - Profit & Loss report
- `/reports/sales` - Sales reports
- `/reports/inventory` - Inventory report

## Models & Relationships

### Bird Model
- Has many: MortalityRecords, EggProduction, FeedUsage, MedicationUsage
- Methods: `getCurrentQuantity()` - calculates current birds after mortality

### Feed Model
- Has many: FeedUsage
- Methods: `getRemainingQuantity()` - calculates remaining stock

### Medication Model
- Has many: MedicationUsage
- Methods: `getRemainingQuantity()` - calculates remaining stock

### EggProduction Model
- Belongs to: Bird
- Auto-calculates good_eggs on save

## Key Features

### Automatic Calculations
- **Current Bird Quantity**: Automatically subtracts mortality from initial quantity
- **Good Eggs**: Automatically calculated as (eggs_collected - damaged_eggs)
- **Remaining Stock**: Feed and medication stock automatically calculated based on usage
- **Profit/Loss**: Automatically calculated from sales and all expense categories

### Validation
- Mortality count cannot exceed current bird quantity
- Feed/medication usage cannot exceed available stock
- Damaged eggs cannot exceed collected eggs
- Expiry dates must be after purchase dates

### Low Stock Alerts
- Dashboard shows feeds with less than 50kg remaining
- Dashboard shows medications with less than 10 units remaining

## Technology Stack
- **Framework**: Laravel 9.x
- **Database**: MySQL
- **Frontend**: Blade Templates, Bootstrap
- **Authentication**: Laravel built-in auth

## Default Users
After seeding, you can login with:
- **Admin**: Check UserSeeder for admin credentials
- **Customer**: Register new account

## Future Enhancements
- Mobile app for field workers
- Automated alerts for low stock and expiring items
- Integration with accounting software
- Batch QR code tracking
- Weather data integration for production analysis
- Predictive analytics for egg production
- Automated feed scheduling

## Support
For issues or questions, please refer to the Laravel documentation or create an issue in the repository.

## License
This project maintains the original license structure.
