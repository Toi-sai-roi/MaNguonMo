<?php
function qlhs_render_table()
{
    $results = qlhs_get_all('');
    $stats = qlhs_stats();
?>
    <div class="qlhs-stats">
        <div class="qlhs-stat-item" style="border-left: 4px solid #667eea;">
            <div class="qlhs-stat-number"><?= $stats['total'] ?></div>
            <div class="qlhs-stat-label">👥 Tổng số học sinh</div>
        </div>
        <div class="qlhs-stat-item" style="border-left: 4px solid #4caf50;">
            <div class="qlhs-stat-number"><?= round($stats['avg'], 2) ?></div>
            <div class="qlhs-stat-label">📈 Điểm TB toàn trường</div>
        </div>
    </div>

    <div class="qlhs-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h2 class="qlhs-card-title" style="margin: 0; padding: 0; border: none;">📋 Danh sách học sinh</h2>
            <button type="button" id="toggle-form-btn" class="qlhs-btn qlhs-btn-success">➕ Thêm học sinh mới</button>
        </div>

        <?php if (empty($results)): ?>
            <div class="qlhs-empty">
                <div class="qlhs-empty-icon">📚</div>
                <p>Chưa có học sinh nào trong cơ sở dữ liệu.</p>
            </div>
        <?php else: ?>
            <div style="overflow-x: auto;">
                <table class="qlhs-table" id="qlhs-main-table">
                    <thead>
                        <tr>
                            <th>Mã HS</th>
                            <th>Họ Tên</th>
                            <th>Ngày sinh</th>
                            <th>Giới tính</th>
                            <th>Toán</th>
                            <th>Lý</th>
                            <th>Hóa</th>
                            <th>Tổng</th>
                            <th>ĐTB</th>
                            <th>Xếp loại</th>
                            <th class="no-sort" style="text-align: center;">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $r):
                            $badge = $r->GioiTinh == 'Nam' ? 'qlhs-badge-male' : 'qlhs-badge-female';
                            $del_url = wp_nonce_url('?page=ql-hoc-sinh&action=delete&id=' . $r->id, 'qlhs_delete_' . $r->id);
                            $dtb = round(($r->DiemToan + $r->DiemLy + $r->DiemHoa) / 3, 2);

                            if ($dtb >= 8.0) {
                                $xeploai = '<span style="background:#e8f5e9;color:#2e7d32;padding:6px 12px;border-radius:20px;font-weight:600;font-size:12px;white-space:nowrap;">🏆 Giỏi</span>';
                            } elseif ($dtb >= 6.5) {
                                $xeploai = '<span style="background:#fff3e0;color:#e65100;padding:6px 12px;border-radius:20px;font-weight:600;font-size:12px;white-space:nowrap;">👍 Khá</span>';
                            } elseif ($dtb >= 5.0) {
                                $xeploai = '<span style="background:#fffde7;color:#f57f17;padding:6px 12px;border-radius:20px;font-weight:600;font-size:12px;white-space:nowrap;">📘 TB</span>';
                            } else {
                                $xeploai = '<span style="background:#ffebee;color:#c62828;padding:6px 12px;border-radius:20px;font-weight:600;font-size:12px;white-space:nowrap;">⚠️ Yếu</span>';
                            }
                        ?>
                            <tr>
                                <td><strong><?= esc_html($r->MaHS) ?></strong></td>
                                <td style="font-weight: 500; color: #222;"><?= esc_html($r->HoTen) ?></td>
                                <td><?= date('d/m/Y', strtotime($r->NgaySinh)) ?></td>
                                <td><span class="qlhs-badge <?= $badge ?>"><?= esc_html($r->GioiTinh) ?></span></td>
                                <td><span class="qlhs-score"><?= esc_html($r->DiemToan) ?></span></td>
                                <td><span class="qlhs-score"><?= esc_html($r->DiemLy) ?></span></td>
                                <td><span class="qlhs-score"><?= esc_html($r->DiemHoa) ?></span></td>
                                <td><span class="qlhs-total"><?= esc_html($r->TongDiem) ?></span></td>
                                <td><span class="qlhs-score" style="background: #eef2ff; color: #4f46e5; font-weight: 700;"><?= $dtb ?></span></td>
                                <td><?= $xeploai ?></td>
                                <td class="qlhs-actions" style="justify-content: center;">
                                    <a href="?page=ql-hoc-sinh&action=edit&id=<?= $r->id ?>" class="qlhs-action-btn qlhs-action-edit">✏️ Sửa</a>
                                    <a href="<?= esc_url($del_url) ?>" class="qlhs-action-btn qlhs-action-delete" onclick="return confirm('Xóa học sinh này?')">🗑️ Xóa</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        jQuery(document).ready(function($) {
            // Kiểm tra và kích hoạt bảng DataTables nếu tồn tại dữ liệu
            if ($('#qlhs-main-table').length) {
                $('#qlhs-main-table').DataTable({
                    "pageLength": 10,
                    "ordering": true,
                    "order": [
                        [7, "desc"]
                    ],
                    "columnDefs": [
                        {
                            "orderable": false,
                            "targets": "no-sort"
                        }
                    ],
                    "lengthClass": "qlhs-select-custom",
                    "language": {
                        "sLengthMenu": "Xem _MENU_ mục",
                        "sZeroRecords": "Không tìm thấy học sinh nào",
                        "sInfo": "Hiển thị từ _START_ đến _END_ trong tổng số _TOTAL_ mục",
                        "sInfoEmpty": "Hiển thị từ 0 đến 0 trong tổng số 0 mục",
                        "sSearch": "", 
                        "sSearchPlaceholder": "🔍 Tìm kiếm học sinh nhanh...", 
                        "oPaginate": {
                            "sPrevious": "Trước",
                            "sNext": "Tiếp"
                        }
                    }
                });
            }

            // Logic xử lý Click đóng mở thu gọn form mượt mà
            $('#toggle-form-btn').on('click', function(e) {
                e.preventDefault();
                var formContainer = $('#qlhs-form-container');

                if (formContainer.is(':visible')) {
                    formContainer.slideUp(250);
                    $(this).text('➕ Thêm học sinh mới').removeClass('qlhs-btn-secondary').addClass('qlhs-btn-success');
                } else {
                    formContainer.slideDown(250);
                    $(this).text('▲ Thu gọn Form').removeClass('qlhs-btn-success').addClass('qlhs-btn-secondary');
                }
            });
        });
    </script>
<?php
}

function qlhs_trang()
{
    qlhs_handle_actions();
    global $message, $edit;

    echo '<div class="qlhs-wrap">';
    echo '<div class="qlhs-header"><h1>Hệ thống quản lý Học sinh</h1></div>';
    echo $message;
    qlhs_render_form($edit);
    qlhs_render_table();
    echo '</div>';
}