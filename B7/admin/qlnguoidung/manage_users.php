<?php if (isset($_GET['message']) && $_GET['message'] === 'success'): ?>
    <div style="background-color: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border: 1px solid #c3e6cb; border-radius: 5px;">
        Người dùng đã được xóa thành công!
    </div>
<?php elseif (isset($_GET['message']) && $_GET['message'] === 'error'): ?>
    <div style="background-color: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border: 1px solid #f5c6cb; border-radius: 5px;">
        Có lỗi xảy ra, vui lòng thử lại!
    </div>
<?php endif; ?>
    