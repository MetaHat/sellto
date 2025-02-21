---

## **📌 Salesperson Management System**  

A web-based **Salesperson Management System** that allows salespersons to submit client visit reports, track approvals, and manage users via an admin panel with email notifications.  

### **🚀 Features**
### **🔹 Salesperson Panel**
- Login using **email/username & password**  
- **Two-Factor Authentication (2FA) via Email OTP** *(Admin-controlled)*  
- Submit client visit reports with **photo uploads (1-3 images mandatory)**  
- Track report status (**Pending, Approved, Rejected**)  
- Receive **email notifications on submission, approval, or rejection**  
- View report submission history with **filters (date range, status, etc.)**  

### **🔹 Admin Panel**
- **Secure Login** with optional **2FA for selected salespersons**  
- Dashboard with **total visits, approvals, rejections, and pending approvals**  
- Manage salesperson reports (**view, filter, approve/reject with comments**)  
- Add, Edit, Delete **Salespersons** (auto-email login credentials on creation)  
- **Export reports** in CSV/PDF format  
- **Login Attempt Logs** to track failed/successful logins  
- **SMTP Settings Management** *(Configure email notifications easily)*  

---
## **Demo Admin Credentials**
 - **Username** - admin@example.com
 - **Password** - admin123

## **📂 Project Structure**
```
/salesperson-management-system
│── /admin
│   ├── dashboard.php
│   ├── login.php
│   ├── manage_salespersons.php
│   ├── view_reports.php
│   ├── export_reports.php
│── /salesperson
│   ├── index.php
│   ├── submit_report.php
│   ├── view_reports.php
│── /uploads
│   ├── (Stores client visit images)
│── /includes
│   ├── config.php
│   ├── functions.php
│── installer.php  # Auto-installer for database setup
│── database.sql  # SQL schema file
│── .htaccess
│── README.md
```

---

## **📦 Installation Guide**
### **Step 1: Clone the Repository**
```sh
git clone https://github.com/metahat/sellto.git
cd sellto
```

### **Step 2: Configure the Database**
1. Create a **MySQL Database** manually (or let the installer create it).  
2. Open `database.sql` and import it into your database using **phpMyAdmin** or CLI:  
   ```sh
   mysql -u your_db_user -p your_db_name < database.sql
   ```
3. OR, use the **automatic installer**:
   - Visit `http://yourdomain.com/installer.php`
   - Enter database credentials and click **Install System**  

### **Step 3: Configure SMTP for Emails**
Edit `smtp_settings.php` after installation:
```php
$smtp_host = "your_smtp_host";
$smtp_user = "your_email@example.com";
$smtp_pass = "your_password";
$smtp_port = 587; // or 465 for SSL
```

### **Step 4: Run the Project**
- **Localhost:** Place files in `htdocs` and access via `http://localhost/salesperson-management-system/`  
- **Live Server:** Upload to a domain and access via `http://yourdomain.com/`  

---

## **🔒 Security Features**
- **Password Hashing:** Bcrypt encryption for login security.  
- **CSRF Protection:** Secure form submissions.  
- **SQL Injection Protection:** Uses prepared statements.  
- **Login Logs:** Tracks login attempts and IP addresses.  

---

## **📜 License**
This project is **open-source** under the **MIT License**. Feel free to modify and use it.  

---

## **👨‍💻 Contributions**
Pull requests are welcome! To contribute:  
1. Fork the repository  
2. Create a new branch (`git checkout -b feature-name`)  
3. Commit changes (`git commit -m "Added feature XYZ"`)  
4. Push to the branch (`git push origin feature-name`)  
5. Submit a Pull Request  

---

## **📧 Contact**
For queries or support, reach out to:  
📩 **Email:** siddhartha69009@gmail.com  
🌐 **Website:** [tohost.in](https://tohost.in/)  

---
