<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Tính tiền tài liệu</title>
</head>
<body>



<form method="post">
    <label>Chọn tài liệu:</label>
    <select name="taiLieu">
        <option value="Sách lập trình">Sách lập trình</option>
        <option value="Giáo trình PHP">Giáo trình PHP</option>
        <option value="Giáo trình Java">Giáo trình Java</option>
        <option value="Giáo trình C++">Giáo trình C++</option>
    </select>

    <br><br>

    <label>Số lượng:</label>
    <input type="number" name="soLuong" min="1">

    <br><br>

    <label>Đơn giá:</label>
    <input type="number" name="donGia" min="0">

    <br><br>

    <input type="submit" name="tinh" value="Tính tiền">


</form>

<?php
if (isset($_POST['tinh'])) {

    $taiLieu = $_POST['taiLieu'];
    $soLuong = $_POST['soLuong'];
    $donGia = $_POST['donGia'];

    $thanhTien = $soLuong * $donGia;

    
    echo "Tài liệu: " . $taiLieu . "<br>";
    echo "Số lượng: " . $soLuong . "<br>";
    echo "Đơn giá: " . $donGia . " VNĐ<br>";
    echo "Thành tiền: " . $thanhTien . " VNĐ";
}
?>

</body>
</html>