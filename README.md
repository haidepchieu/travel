# Chestnut Travel - Tour Booking Platform

Dự án website du lịch và đặt tour (Travel & Tour Booking Platform) được xây dựng theo kiến trúc hiện đại, lấy cảm hứng và chức năng từ [Chestnut Travel](https://chestnuttravel.net/).

Hệ thống quản trị Backend được xây dựng hoàn toàn bằng **Laravel 12 + Filament v3** với giao diện trực quan, hỗ trợ kéo thả lịch trình hàng ngày (Daily Itinerary), quản lý ảnh gallery, các gói giá tour (Tự lái, Easy Rider...), điểm đến và quản lý đơn đặt tour.

---

## �� Thông Tin Truy Cập & Tài Khoản

- **Admin Panel URL**: [http://localhost:8090/admin](http://localhost:8090/admin)
  - **Email**: `admin@chestnuttravel.net`
  - **Mật khẩu**: `admin123`
- **phpMyAdmin (Quản lý Database trực quan)**: [http://localhost:8091](http://localhost:8091)
  - **Server**: `mysql` (hoặc để mặc định)
  - **Username**: `root` (mật khẩu: `root`) hoặc `travel` (mật khẩu: `travel_secret`)
- **Frontend Trang chủ**: [http://localhost:8090](http://localhost:8090)
- **MySQL Database**:
  - Host: `127.0.0.1` (khi kết nối từ máy chủ / DBeaver / Navicat)
  - Port: `3307`
  - Database: `travel_db`
  - Username: `travel`
  - Password: `travel_secret`

---

## 🛠 Cấu Trúc Hệ Thống (Filament v3)

### 1. Quản Lý Tour (`TourResource`)
- **Thông tin cơ bản**: Tiêu đề tour, tự động sinh slug URL, khẩu hiệu / badge (`Best Seller`), điểm đến, thể loại hoạt động, số ngày / số đêm (`duration_days`, `duration_nights`), điểm đón, số lượng khách tối đa, phương tiện di chuyển.
- **Lịch trình theo ngày (`Itineraries` - Filament Repeater)**:
  - Cho phép thêm từng ngày (`Day 1`, `Day 2`...)
  - Tiêu đề chặng đường (ví dụ: `Hà Giang - Quản Bạ - Yên Minh`)
  - Bữa ăn bao gồm (`Breakfast, Lunch, Dinner`)
  - Chỗ ở / Homestay / Khách sạn
  - Nội dung chi tiết các điểm tham quan theo ngày (RichEditor)
  - Hỗ trợ sắp xếp thứ tự kéo thả, thu gọn (Collapsible), nhân bản ngày (Clone).
- **Gói giá & Dịch vụ (`Pricing & Packages`)**:
  - Giá gốc & Giá khuyến mãi
  - Danh sách gói giá linh hoạt (Repeater: ví dụ gói *Tự lái xe máy 110cc* vs gói *Easy Rider có tài xế riêng*)
  - Điểm nổi bật (Highlights tags)
  - Dịch vụ bao gồm (Inclusions tags) & Không bao gồm (Exclusions tags)
- **Hình ảnh & Gallery**:
  - Ảnh đại diện chính (Cover / Featured image kèm bộ công cụ crop/xoay ảnh Filament)
  - Thư viện ảnh chi tiết (Multiple Gallery upload, kéo thả sắp xếp thứ tự hiển thị)

### 2. Quản Lý Điểm Đến (`DestinationResource`)
- Hà Giang, Hạ Long, Ninh Bình, Sapa, Cao Bằng...
- Ảnh cover, cẩm nang giới thiệu điểm đến (RichEditor), trạng thái nổi bật, đếm số lượng tour tự động.

### 3. Thể Loại / Hoạt Động (`ActivityResource`)
- Easy Rider, Phượt xe máy tự lái, Trekking leo núi, Du thuyền vịnh, Tour văn hóa ẩm thực...

### 4. Quản Lý Đơn Đặt Tour (`TourBookingResource`)
- Mã đặt tour tự sinh (`CNT-XXXXXX`)
- Thông tin khách hàng (Họ tên, Email, Số điện thoại / WhatsApp, Khách sạn đón)
- Chi tiết chuyến đi (Tour đã chọn, Ngày khởi hành, Số lượng người lớn / trẻ em, Yêu cầu đặc biệt về phòng/ăn uống)
- Trạng thái thanh toán (Chờ thanh toán, Đặt cọc, Đã thanh toán, Hoàn tiền) với Badge màu sắc
- Trạng thái đơn (Chờ xác nhận, Đã xác nhận, Hoàn thành, Đã hủy)

---

## 🐳 Hướng Dẫn Vận Hành Docker

Dự án `travel` hoạt động độc lập, không bị xung đột cổng mạng với các dự án khác (như `vetaweb`):

### Khởi động hệ thống:
```bash
cd /home/hieu/Projects/travel
docker compose up -d
```

### Dừng hệ thống:
```bash
docker compose down
```

### Chạy các lệnh Artisan bên trong container:
```bash
# Xem danh sách routes
docker exec -it travel_app php artisan route:list

# Chạy migrate lại khi cần
docker exec -it travel_app php artisan migrate

# Nạp lại dữ liệu mẫu
docker exec -it travel_app php artisan db:seed
```

---

## 📦 Công Nghệ Sử Dụng
- **PHP**: 8.2-FPM với đầy đủ extension `intl`, `pdo_mysql`, `gd`, `zip`, `mbstring`, `bcmath`, `exif`
- **Framework**: Laravel 12
- **Admin**: Filament v3 (Livewire 3, AlpineJS, TailwindCSS bên trong Filament)
- **Web Server**: Nginx Alpine (Port 8090)
- **Database**: MySQL 8.0 (Port 3307)
- **phpMyAdmin**: Port 8091
