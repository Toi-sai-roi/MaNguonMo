# 📚 Plugin Quản Lý Học Sinh – WordPress

**Đề tài môn**: Phần Mềm Mã Nguồn Mở | **Trường**: Đại học Điện Lực | **Lớp**: D18CNPM5

### 🎯 Tên đề tài

> Xây dựng chức năng Cập nhật và Tìm kiếm Học sinh sử dụng mã nguồn mở WordPress.

### 🌐 Giới thiệu hệ thống

Plugin WordPress quản lý thông tin học sinh, được xây dựng thuần túy bằng PHP tích hợp trực tiếp vào hệ thống WordPress Admin. Hệ thống cho phép:

* ➕ Thêm học sinh mới với đầy đủ thông tin.
* ✏️ Sửa thông tin học sinh.
* 🗑️ Xóa học sinh khỏi hệ thống.
* 🔍 Tìm kiếm real-time theo tên hoặc mã học sinh.
* 📊 Tự động tính tổng điểm, điểm trung bình và xếp loại học lực.
* 📈 Thống kê tổng số học sinh và điểm trung bình toàn trường.

---

## 👥 Danh sách thành viên

| STT | Họ và tên | MSSV |
| --- | --- | --- |
| **1** | Trần Lợi Nhân | 23810310318 |
| **2** | Lê Văn Tùng | 23810310325 |
| **3** | Lê Trung Sơn | 23810310352 |

---

## 📋 Phân công nhiệm vụ

| Thành viên | Nhiệm vụ |
| --- | --- |
| **Trần Lợi Nhân** | Nghiên cứu lý thuyết (PHP, MySQL, WordPress, XAMPP). Cài đặt và cấu hình môi trường XAMPP, WordPress. |
| **Lê Văn Tùng** | Xây dựng kiến trúc plugin, lập trình `db.php`, `form.php`, `admin.php`. Tích hợp bảo mật nonce và phân quyền. |
| **Lê Trung Sơn** | Xây dựng giao diện `table.php`, tích hợp DataTables. Viết báo cáo và demo chương trình. |

---

## 🛠️ Công nghệ sử dụng

| Công nghệ | Phiên bản | Mục đích |
| --- | --- | --- |
| **WordPress** | 6.x | Nền tảng CMS mã nguồn mở |
| **PHP** | 8.x | Ngôn ngữ lập trình backend |
| **MySQL / MariaDB** | 8.x | Hệ quản trị cơ sở dữ liệu |
| **XAMPP** | Mới nhất | Môi trường phát triển localhost |
| **DataTables** | 1.13.6 | Thư viện bảng dữ liệu JavaScript |
| **jQuery** | Tích hợp sẵn WP | Xử lý DOM và AJAX |

---

## ⚙️ Hướng dẫn cài đặt

### Yêu cầu hệ thống

* XAMPP (Apache + MySQL + PHP 8.x)
* WordPress 6.x
* Trình duyệt web bất kỳ

### Các bước cài đặt

#### 1. Cài đặt XAMPP

* Tải XAMPP tại: [apachefriends.org](https://www.apachefriends.org)
* Cài đặt và khởi động **Apache** + **MySQL** trong XAMPP Control Panel.

#### 2. Cài đặt WordPress

* Tải WordPress tại: [wordpress.org/download](https://wordpress.org/download)
* Giải nén vào thư mục: `C:\xampp\htdocs\wordpress`
* Tạo database mới trong phpMyAdmin: [http://localhost/phpmyadmin](https://www.google.com/search?q=http://localhost/phpmyadmin)
* Truy cập [http://localhost/wordpress](https://www.google.com/search?q=http://localhost/wordpress) và hoàn tất các bước cài đặt (wizard).

#### 3. Cài đặt Plugin

Sử dụng Git Bash hoặc Command Prompt để clone repository:

```bash
# Clone repository về máy
git clone https://github.com/Toi-sai-roi/MaNguonMo.git

```

Di chuyển thư mục plugin vào source code WordPress:

* **Cách 1 (Dùng lệnh):**
```bash
cp -r MaNguonMo/wp-content/plugins/qlhs C:\xampp\htdocs\wordpress\wp-content\plugins

```


* **Cách 2 (Thủ công):** Copy toàn bộ folder `qlhs` dán trực tiếp vào thư mục `wp-content/plugins/` của WordPress.

---

## ▶️ Hướng dẫn chạy project

1. Mở **XAMPP Control Panel**, bật **Apache** và **MySQL**.
2. Truy cập đường dẫn: [http://localhost/wordpress/wp-admin](https://www.google.com/search?q=http://localhost/wordpress/wp-admin)
3. Đăng nhập bằng tài khoản Admin.
4. Vào **Plugins** → **Installed Plugins**.
5. Tìm plugin **"Quản lý học sinh"** → nhấn **Activate**.
6. Menu **"Quản lý Học Sinh"** sẽ xuất hiện ở thanh sidebar bên trái → nhấn vào để sử dụng.

---

## 📁 Cấu trúc thư mục Plugin

```text
qlhs/
├── qlhs.php          # File chính, entry point của plugin
└── includes/
    ├── db.php        # Kết nối CSDL, các hàm truy vấn
    ├── admin.php     # Đăng ký menu quản trị WordPress
    ├── form.php      # Xử lý logic CRUD và render form
    └── table.php     # Render bảng danh sách và thống kê

```

---

📅 *Hà Nội, tháng 05 năm 2026*
