Laravel E-Commerce MVP

An educational **MVP e-commerce project** built with Laravel 12 + Sail.  
The goal was to design a scalable shop backend with clean architecture, enums for state machines, and a minimal UI powered by TailwindCSS.

> ⚠️ This is not a production store. It’s a learning project that demonstrates how to structure a real-world Laravel shop.

---

## ✨ Features

- 📦 **Product catalog**
    - Admin CRUD (create/edit/delete)
    - Image upload & stock management
- 🛒 **Shopping Cart**
    - Add, update, remove, clear items
    - Quantity validation with stock limits
- 📝 **Checkout flow**
    - Snapshotting product data (name + price at checkout)
    - Customer details + shipping address
- 🔐 **Order lifecycle with Enums**
    - `OrderStatus` → Cart, Pending, Paid, Completed, Cancelled
    - `PaymentStatus` → Pending, Paid, Refunded, Failed
    - `ShipmentStatus` → None, Processing, Shipped, In Transit, Delivered
- 🧑‍💻 **Admin panel for orders**
    - Ship, Deliver, Cancel actions (with policies & guards)
- 💳 **Mock Payments**
    - Fake provider with buttons: success / fail / cancel
    - Webhook simulation for marking orders as paid
- 🎨 **Frontend**
    - TailwindCSS + Vite build
    - Responsive product cards & order pages

---

## 🛠️ Tech Stack

- **Backend:** Laravel 12 + Sail (Dockerized)
- **Database:** MySQL 8
- **Frontend:** Blade + TailwindCSS + Alpine.js
- **Architecture:** Policies, Enums, Transactional services

---

## 🚀 Getting Started

Clone the repo and spin it up with Laravel Sail:

```bash
git clone https://github.com/kievski-roman/vapeShop
cd vapeshop

cp .env.example .env
# configure DB credentials if needed

# Start containers
./vendor/bin/sail up -d

# Run migrations & seeders
./vendor/bin/sail artisan migrate --seed

# Install frontend
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
"# basic" 
