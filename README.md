# Food Order System 🍔

![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.2-7952B3?logo=bootstrap)

A complete restaurant management system with admin panel for food ordering, inventory management, and order processing.

## ✨ Key Features

### Admin Dashboard
- 📊 Real-time statistics (categories, foods, orders, revenue)
- 👨‍💼 Admin management (CRUD operations)
- 🔐 Secure login with session management

### Food Management
- 🍕 Add/update/delete food items with images
- 🏷️ Categorize foods (active/featured status)
- 📝 Detailed food descriptions and pricing

### Order System
- 🛒 Process customer orders
- 📦 Track order status (Ordered → On Delivery → Delivered)
- 📱 Customer details management

### Category Management
- 🗂️ Organize food by categories
- 🖼️ Category images with automatic renaming
- 🔄 Toggle featured/active status

## 🛠️ Tech Stack
- **Frontend**: HTML5, CSS3, Bootstrap
- **Backend**: PHP
- **Database**: MySQL
- **Security**: MD5 password hashing, session management
- **File Handling**: Image uploads with validation

## 🗄️ Database Schema
Key tables:
- `tbl_admin` (admin credentials)
- `tbl_category` (food categories)
- `tbl_food` (menu items)
- `tbl_order` (customer orders)

## 🚀 Installation

### Prerequisites
- PHP 8.0+
- MySQL 8.0+
- Apache/Nginx web server
- php-mysql extension

### Setup Steps
1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/food-order-system.git
