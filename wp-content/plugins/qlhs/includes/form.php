<?php
function qlhs_handle_actions() {
    global $message, $edit;
    $message = '';
    $edit = null;

    // 1. Kiểm tra quyền của user hiện tại
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
        check_admin_referer('qlhs_delete_' . $_GET['id']);
        qlhs_delete(intval($_GET['id']));
        $message = '<div class="qlhs-alert qlhs-alert-success">✅ Đã xóa học sinh thành công!</div>';
    }

    if (isset($_POST['save'])) {
        check_admin_referer('qlhs_save_student');
        $id   = intval($_POST['id']);
        $mahs = sanitize_text_field($_POST['MaHS']);

        if (qlhs_check_duplicate($mahs, $id)) {
            $message = '<div class="qlhs-alert qlhs-alert-error">❌ Mã học sinh đã tồn tại!</div>';
        } else {
            $toan = floatval($_POST['DiemToan']);
            $ly   = floatval($_POST['DiemLy']);
            $hoa  = floatval($_POST['DiemHoa']);
            $data = [
                'MaHS'      => $mahs,
                'HoTen'     => sanitize_text_field($_POST['HoTen']),
                'NgaySinh'  => sanitize_text_field($_POST['NgaySinh']),
                'GioiTinh'  => sanitize_text_field($_POST['GioiTinh']),
                'DiemToan'  => $toan,
                'DiemLy'    => $ly,
                'DiemHoa'   => $hoa,
                'TongDiem' => $toan + $ly + $hoa,
            ];
            $result  = qlhs_save($data, $id);
            $message = $result === 'updated'
                ? '<div class="qlhs-alert qlhs-alert-success">✅ Đã cập nhật thông tin học sinh!</div>'
                : '<div class="qlhs-alert qlhs-alert-success">✅ Đã thêm học sinh mới!</div>';
        }
    }

    if (isset($_GET['action']) && $_GET['action'] == 'edit' && isset($_GET['id'])) {
        $edit = qlhs_get_one(intval($_GET['id']));
    }
}

function qlhs_render_form($edit) {
    // Nếu đang bấm "Sửa" ($edit có dữ liệu) thì bắt buộc phải hiện form ngay. 
    // Nếu vào trang bình thường (Thêm mới) thì ẩn đi chờ click nút JavaScript mới bung ra.
    $display_style = $edit ? 'block' : 'none';
    ?>
    <div id="qlhs-form-container" class="qlhs-card" style="display: <?= $display_style ?>; margin-bottom: 30px;">
        <h2 class="qlhs-card-title"><?= $edit ? '✏️ Sửa thông tin học sinh' : '➕ Thêm học sinh mới' ?></h2>
        <form method="POST" action="">
            <?= wp_nonce_field('qlhs_save_student', '_wpnonce', true, false) ?>
            <input type="hidden" name="id" value="<?= $edit ? esc_attr($edit->id) : 0 ?>">

            <div class="qlhs-form-grid">
                <div class="qlhs-form-group">
                    <label>Mã học sinh</label>
                    <input type="text" name="MaHS" value="<?= $edit ? esc_attr($edit->MaHS) : '' ?>" placeholder="VD: HS001" required>
                </div>
                <div class="qlhs-form-group">
                    <label>Họ và Tên</label>
                    <input type="text" name="HoTen" value="<?= $edit ? esc_attr($edit->HoTen) : '' ?>" placeholder="Nhập họ tên đầy đủ" required>
                </div>
                <div class="qlhs-form-group">
                    <label>Ngày sinh</label>
                    <input type="date" name="NgaySinh" value="<?= $edit ? esc_attr($edit->NgaySinh) : '' ?>" required>
                </div>
                <div class="qlhs-form-group">
                    <label>Giới tính</label>
                    <select name="GioiTinh">
                        <option value="Nam" <?= $edit && $edit->GioiTinh == 'Nam' ? 'selected' : '' ?>>👨 Nam</option>
                        <option value="Nữ"  <?= $edit && $edit->GioiTinh == 'Nữ'  ? 'selected' : '' ?>>👩 Nữ</option>
                    </select>
                </div>
                <div class="qlhs-form-group full-width">
                    <label>Điểm số</label>
                    <div class="qlhs-score-group">
                        <input type="number" step="0.1" min="0" max="10" name="DiemToan" value="<?= $edit ? esc_attr($edit->DiemToan) : '0' ?>" placeholder="Toán">
                        <input type="number" step="0.1" min="0" max="10" name="DiemLy"   value="<?= $edit ? esc_attr($edit->DiemLy)   : '0' ?>" placeholder="Lý">
                        <input type="number" step="0.1" min="0" max="10" name="DiemHoa"  value="<?= $edit ? esc_attr($edit->DiemHoa)  : '0' ?>" placeholder="Hóa">
                    </div>
                </div>
            </div>

            <div style="margin-top: 25px; display: flex; gap: 12px;">
                <button type="submit" name="save" class="qlhs-btn qlhs-btn-primary">💾 Lưu thông tin</button>
                <a href="?page=ql-hoc-sinh" class="qlhs-btn qlhs-btn-secondary">❌ Hủy bỏ</a>
            </div>
        </form>
    </div>
    <?php
}