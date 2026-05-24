📚 Plugin Quản Lý Học Sinh – WordPress

Đề tài môn Phần Mềm Mã Nguồn Mở | Trường Đại học Điện Lực | Lớp D18CNPM5


🎯 Tên đề tài
Xây dựng chức năng Cập nhật và Tìm kiếm Học sinh sử dụng mã nguồn mở WordPress

🌐 Giới thiệu hệ thống
Plugin WordPress quản lý thông tin học sinh, được xây dựng bằng PHP tích hợp trực tiếp vào WordPress Admin. Hệ thống cho phép:

➕ Thêm học sinh mới với đầy đủ thông tin
✏️ Sửa thông tin học sinh
🗑️ Xóa học sinh khỏi hệ thống
🔍 Tìm kiếm real-time theo tên hoặc mã học sinh
📊 Tự động tính tổng điểm, điểm trung bình và xếp loại học lực
📈 Thống kê tổng số học sinh và điểm trung bình toàn trường


👥 Danh sách thành viên
STTHọ và tênMSSV1Trần Lợi Nhân238103103182Lê Văn Tùng238103103253Lê Trung Sơn23810310352

📋 Phân công nhiệm vụ
Thành viênNhiệm vụTrần Lợi NhânNghiên cứu lý thuyết (PHP, MySQL, WordPress, XAMPP). Cài đặt và cấu hình môi trường XAMPP, WordPressLê Văn TùngXây dựng kiến trúc plugin, lập trình db.php, form.php, admin.php. Tích hợp bảo mật nonce và phân quyềnLê Trung SơnXây dựng giao diện table.php, tích hợp DataTables. Viết báo cáo và demo chương trình

🛠️ Công nghệ sử dụng
Công nghệPhiên bảnMục đíchWordPress6.xNền tảng CMS mã nguồn mởPHP8.xNgôn ngữ lập trình backendMySQL / MariaDB8.xHệ quản trị cơ sở dữ liệuXAMPPMới nhấtMôi trường phát triển localhostDataTables1.13.6Thư viện bảng dữ liệu JavaScriptjQueryTích hợp sẵn WPXử lý DOM và AJAX

⚙️ Hướng dẫn cài đặt
I. Cài đặt XAMPP

Download XAMPP tại: https://www.apachefriends.org/download.html
Cài đặt XAMPP (mặc định vào C:\xampp)
Mở XAMPP Control Panel, nhấn Start cho Apache và MySQL

II. Tạo Database trong phpMyAdmin

Truy cập http://localhost/phpmyadmin/
Tạo database mới tên d18cnpm5, charset utf8mb4_unicode_ci

III. Cài đặt WordPress

Download WordPress tại: https://wordpress.org/download/
Giải nén, copy toàn bộ vào C:\xampp\htdocs\wordpress
Truy cập http://localhost/wordpress trên trình duyệt
Điền thông tin kết nối database:

Database name: d18cnpm5
Username: root
Password: (để trống)
Host: localhost


Hoàn tất wizard cài đặt, đăng nhập WordPress Admin

IV. Cài đặt Plugin
bash# Clone repository
git clone https://github.com/Toi-sai-roi/MaNguonMo.git

# Copy folder plugin vào WordPress
# Windows:
xcopy /E /I MaNguonMo\wp-content\plugins\qlhs C:\xampp\htdocs\wordpress\wp-content\plugins\qlhs
Hoặc tải thủ công: copy folder qlhs vào wp-content/plugins/

▶️ Hướng dẫn chạy project

Mở XAMPP Control Panel, bật Apache và MySQL
Truy cập http://localhost/wordpress/wp-admin
Đăng nhập bằng tài khoản Admin
Vào Plugins → Installed Plugins
Tìm "Quản lý học sinh" → nhấn Activate
Menu "Quản lý Học Sinh" xuất hiện ở sidebar trái → nhấn vào để sử dụng


📁 Cấu trúc thư mục Plugin
qlhs/
├── qlhs.php              # File chính, entry point của plugin
├── README.md             # Tài liệu hướng dẫn
└── includes/
    ├── db.php            # Kết nối CSDL, các hàm truy vấn
    ├── admin.php         # Đăng ký menu quản trị WordPress
    ├── form.php          # Xử lý logic CRUD và render form
    └── table.php         # Render bảng danh sách và thống kê

📖 Tài liệu tham khảo

Tài liệu thiết kế website với mã nguồn mở WordPress – Studocu
PHP Official Documentation
WordPress Plugin Handbook
MySQL 8.0 Reference Manual
DataTables Documentation



📅 Hà Nội, tháng 05 năm 2026