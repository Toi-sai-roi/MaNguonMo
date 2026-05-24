<?php
register_activation_hook(dirname(__FILE__) . '/../qlhs.php', 'qlhs_tao_bang');
function qlhs_tao_bang() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'tblhosinh';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        MaHS varchar(20) NOT NULL,
        HoTen varchar(100) NOT NULL,
        NgaySinh date NOT NULL,
        GioiTinh varchar(10),
        DiemToan float, DiemLy float, DiemHoa float, TongDiem float,
        PRIMARY KEY (id)
    ) $charset_collate;";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function qlhs_get_table() {
    global $wpdb;
    return 'tblhosinh';
}

function qlhs_get_all($search = '') {
    global $wpdb;
    $table = qlhs_get_table();
    $like = '%' . $wpdb->esc_like($search) . '%';
    return $wpdb->get_results($wpdb->prepare(
        "SELECT * FROM $table WHERE HoTen LIKE %s OR MaHS LIKE %s ORDER BY id DESC",
        $like, $like
    ));
}

function qlhs_get_one($id) {
    global $wpdb;
    $table = qlhs_get_table();
    return $wpdb->get_row($wpdb->prepare("SELECT * FROM $table WHERE id = %d", $id));
}

function qlhs_save($data, $id = 0) {
    global $wpdb;
    $table = qlhs_get_table();
    if ($id > 0) {
        $wpdb->update($table, $data, ['id' => $id]);
        return 'updated';
    }
    $wpdb->insert($table, $data);
    return 'inserted';
}

function qlhs_check_duplicate($mahs, $id = 0) {
    global $wpdb;
    $table = qlhs_get_table();
    if ($id > 0) {
        return $wpdb->get_var($wpdb->prepare(
            "SELECT COUNT(*) FROM $table WHERE MaHS = %s AND id != %d", $mahs, $id
        ));
    }
    return $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table WHERE MaHS = %s", $mahs
    ));
}

function qlhs_delete($id) {
    global $wpdb;
    $wpdb->delete(qlhs_get_table(), ['id' => $id]);
}

function qlhs_stats() {
    global $wpdb;
    $table = qlhs_get_table();
    return [
        'total' => $wpdb->get_var("SELECT COUNT(*) FROM $table"),
        // Logic mới: Tính trung bình chính xác của Điểm trung bình của từng học sinh
        'avg'   => $wpdb->get_var("SELECT AVG((DiemToan + DiemLy + DiemHoa) / 3) FROM $table"),
    ];
}