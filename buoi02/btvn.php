<?php

$devices = [];

if (isset($_POST["them"])) {

    $ten = $_POST["ten"];
    $soLuong = $_POST["soLuong"];
    $phong = $_POST["phong"];

    $devices[] = [
        "ten" => $ten,
        "soLuong" => $soLuong,
        "phong" => $phong
    ];
}

// Hàm kiểm tra tình trạng
function kiemTra($soLuong)
{
    if ($soLuong > 0) {
        return "Còn thiết bị";
    } else {
        return "Hết thiết bị";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Quản lý thiết bị</title>
</head>

<body>

<h2>QUẢN LÝ THIẾT BỊ PHÒNG THỰC HÀNH</h2>

<form method="post">

    Tên thiết bị:
    <input type="text" name="ten">

    Số lượng:
    <input type="number" name="soLuong" min="0">

    Phòng:
    <select name="phong">
        <option value="Phòng 101">Phòng 101</option>
        <option value="Phòng 102">Phòng 102</option>
        <option value="Phòng 103">Phòng 103</option>
    </select>

    <input type="submit" name="them" value="Thêm">

</form>

<br>

<table border="1" cellpadding="8">
    <tr>
        <th>STT</th>
        <th>Tên thiết bị</th>
        <th>Số lượng</th>
        <th>Phòng</th>
        <th>Tình trạng</th>
    </tr>

<?php

$stt = 1;

foreach ($devices as $device) {

    echo "<tr>";

    echo "<td>" . $stt . "</td>";

    echo "<td>" . htmlspecialchars($device["ten"]) . "</td>";

    echo "<td>" . $device["soLuong"] . "</td>";

    echo "<td>" . $device["phong"] . "</td>";

    echo "<td>" . kiemTra($device["soLuong"]) . "</td>";

    echo "</tr>";

    $stt++;
}

?>

</table>

</body>
</html>