
#  COIN - Smart, Secure & Scalable Payment Broadcasting Platform

COIN is a next-generation digital payment solution that allows **1-to-N transactions**, meaning a single sender can securely send money to multiple recipients in one action. Designed for businesses, organizations, and individual users, COIN not only saves time but also enhances transparency, security, and financial insight through a blockchain-based backend and smart wallet functionality.

---

##  Problem Statement

Most conventional digital payment systems are limited to **1-to-1** or **N-to-1** transactions. This becomes inefficient for tasks such as:
- Sending salaries to multiple employees
- Distributing funds to groups (e.g., NGOs, charities)
- Managing repetitive transfers

These platforms also lack financial visualization, smart savings, and advanced security mechanisms like blockchain.

---

##  Project Description

COIN solves these limitations by enabling:
- **1-to-N broadcast payments**
- **Blockchain-backed tamper-proof data storage**
- **Smart Wallet** that auto-saves round-off amounts
- **User dashboards** with charts & transaction insights
- **Voice-assisted transactions** for accessibility

---

## Key Features

- 1-to-N Transaction Broadcasting
- Private Blockchain Integration for Data Integrity
- Real-Time Analytics and Visual Dashboards
- CoinID: Unique identifier for every user
- Smart Wallet with Auto-Saving Mechanism
- Voice Command Integration
- Real-Time Transaction Notifications
- Secure Authentication with SHA-512 & Hashing

---

##  Tech Stack

| Layer            | Technology                           |
|------------------|--------------------------------------|
| **Frontend**     | HTML, CSS, JavaScript, Bootstrap     |
| **Backend**      | PHP                                  |
| **Database**     | MySQL                                |
| **Security**     | SHA-512, Hashing                     |
| **Blockchain**   | Custom Private Blockchain Layer      |
| **Charts**       | Chart.js                             |

---

##  Smart Wallet Logic

- Rounds up each transaction amount:
  - If amount > ₹100 → round to nearest 5
  - If amount > ₹1000 → round to nearest 10
- The difference is saved into the **Smart Wallet**
- Wallet balance can be:
  - Sent to other users
  - Donated to charity
  - Transferred to a bank account
- Wallet becomes active only when balance > ₹50 and user enables it in settings

---

##  Potential Real-World Impact

- **Time-Saving** for bulk payments
- **Efficient Payroll** handling for businesses
- **Trust & Transparency** in aid distribution (NGOs/charities)
- **Insightful Dashboards** for personal finance tracking
- **Tamper-Proof Data** via blockchain

---

## Visualization

Integrated with **Chart.js** to provide:
- Total Sent/Received Amounts
- Top Senders/Receivers
- Transaction Frequency Trends
- Smart Wallet Growth

---

## Voice Assistance

Use voice commands to:
- Check balance
- Send money
- View analytics

---

## Run Locally

Follow these steps to run the project on your local machine:

1. ### Clone the Repository
   ```bash
   git clone https://github.com/Shyam1719/Coin_Pay.git
   ```

2. ### Install XAMPP
   - Download and install **XAMPP** from [https://www.apachefriends.org](https://www.apachefriends.org)
   - Launch the **XAMPP Control Panel**

3. ### Start Servers
   - Start **Apache Server**
   - Start **MySQL Server**
     
4.  ### Project Setup
   - Copy or move the project folder (`coin/`) into your:
     ```
     C:\xampp\htdocs\
     ```
5. ### Import the Database
   - Open **phpMyAdmin** via [http://localhost/phpmyadmin](http://localhost/phpmyadmin)
   - Click on `Import`  
   - Navigate to the project folder → `assets/database` → select the `wallet.sql` file  
   - Import the database into your MySQL server

6. ### Run the Project
   - Open your browser and navigate to:
     ```
     http://localhost/coin/
     ```

> ⚠️ **Make sure** your database credentials in `db_connection.php` match your local MySQL setup (usually user: `root`, password: empty).

---
