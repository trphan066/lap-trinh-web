<?php

// Mảng lưu danh sách các yêu cầu booking
$bookings = [];


// Hàm xác định trạng thái yêu cầu
function xacDinhTrangThai($loaiYeuCau, $ngaySuDung)
{
    $ngayHienTai = date("Y-m-d");

    // Nếu ngày sử dụng đã qua
    if ($ngaySuDung < $ngayHienTai) {
        return "Không hợp lệ";
    }

    // Nếu là đặt phòng hoặc mượn thiết bị
    if ($loaiYeuCau == "Đặt phòng" || $loaiYeuCau == "Mượn thiết bị") {
        return "Chờ duyệt";
    }

    return "Không xác định";
}


// Kiểm tra người dùng gửi form
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Nhận dữ liệu từ form
    $nguoiYeuCau = $_POST["nguoiYeuCau"];
    $loaiYeuCau = $_POST["loaiYeuCau"];
    $phong = $_POST["phong"];
    $ngaySuDung = $_POST["ngaySuDung"];
    $gioBatDau = $_POST["gioBatDau"];
    $gioKetThuc = $_POST["gioKetThuc"];
    $mucDich = $_POST["mucDich"];


    // Kiểm tra giờ
    if ($gioBatDau >= $gioKetThuc) {
        $trangThai = "Giờ không hợp lệ";
    } else {

        // Gọi hàm xác định trạng thái
        $trangThai = xacDinhTrangThai(
            $loaiYeuCau,
            $ngaySuDung
        );
    }


    // Tạo booking
    $booking = [
        "nguoiYeuCau" => $nguoiYeuCau,
        "loaiYeuCau" => $loaiYeuCau,
        "phong" => $phong,
        "ngaySuDung" => $ngaySuDung,
        "gioBatDau" => $gioBatDau,
        "gioKetThuc" => $gioKetThuc,
        "mucDich" => $mucDich,
        "trangThai" => $trangThai
    ];


    // Thêm booking vào mảng
    $bookings[] = $booking;
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Quản lý Booking</title>


    <style>

        body {
    font-family: Arial;
    margin: 30px;
}

form {
    width: 500px;
}

input, select, button {
    width: 100%;
    padding: 8px;
    margin: 5px 0 15px;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    border: 1px solid #ccc;
    padding: 8px;
    text-align: left;
}

button {
    cursor: pointer;
}

    </style>

</head>


<body>

<div class="container">


    <h1>
        HỆ THỐNG QUẢN LÝ PHÒNG THỰC HÀNH VÀ THIẾT BỊ
    </h1>


    <p class="subtitle">
        Quản lý yêu cầu đặt phòng và mượn thiết bị
    </p>


    <!-- FORM -->

    <h2>
        Tạo yêu cầu đặt phòng / mượn thiết bị
    </h2>


    <form method="POST">


        <!-- Người yêu cầu -->

        <label>
            Người yêu cầu:
        </label>

        <input
            type="text"
            name="nguoiYeuCau"
            placeholder="Nhập họ và tên"
            required
        >


        <!-- Loại yêu cầu -->

        <label>
            Loại yêu cầu:
        </label>

        <select name="loaiYeuCau" required>

            <option value="">
                -- Chọn loại yêu cầu --
            </option>

            <option value="Đặt phòng">
                Đặt phòng
            </option>

            <option value="Mượn thiết bị">
                Mượn thiết bị
            </option>

        </select>


        <!-- Chọn phòng -->

        <label>
            Chọn phòng:
        </label>

        <select name="phong" required>

            <option value="">
                -- Chọn phòng --
            </option>

            <option value="101">Phòng 101</option>
            <option value="102">Phòng 102</option>
            <option value="103">Phòng 103</option>
            <option value="104">Phòng 104</option>

            <option value="201">Phòng 201</option>
            <option value="202">Phòng 202</option>
            <option value="203">Phòng 203</option>
            <option value="204">Phòng 204</option>

        </select>


        <!-- Ngày và giờ -->

        <div class="row">

            <div>

                <label>
                    Ngày sử dụng:
                </label>

                <input
                    type="date"
                    name="ngaySuDung"
                    required
                >

            </div>


            <div>

                <label>
                    Giờ bắt đầu:
                </label>

                <input
                    type="time"
                    name="gioBatDau"
                    required
                >

            </div>

        </div>


        <label>
            Giờ kết thúc:
        </label>

        <input
            type="time"
            name="gioKetThuc"
            required
        >


        <!-- Mục đích -->

        <label>
            Mục đích:
        </label>

        <textarea
            name="mucDich"
            placeholder="Nhập mục đích sử dụng phòng"
            required
        ></textarea>


        <button type="submit">
            Gửi yêu cầu
        </button>

    </form>


    <!-- DANH SÁCH -->

    <h2>
        Danh sách yêu cầu booking
    </h2>


    <?php if (count($bookings) > 0): ?>


        <table>

            <tr>

                <th>STT</th>

                <th>Người yêu cầu</th>

                <th>Loại yêu cầu</th>

                <th>Phòng</th>

                <th>Ngày</th>

                <th>Thời gian</th>

                <th>Mục đích</th>

                <th>Trạng thái</th>

            </tr>


            <?php foreach ($bookings as $index => $booking): ?>


                <tr>

                    <td>
                        <?php echo $index + 1; ?>
                    </td>


                    <td>
                        <?php
                        echo htmlspecialchars(
                            $booking["nguoiYeuCau"]
                        );
                        ?>
                    </td>


                    <td>
                        <?php
                        echo htmlspecialchars(
                            $booking["loaiYeuCau"]
                        );
                        ?>
                    </td>


                    <td>
                        Phòng
                        <?php
                        echo htmlspecialchars(
                            $booking["phong"]
                        );
                        ?>
                    </td>


                    <td>
                        <?php
                        echo htmlspecialchars(
                            $booking["ngaySuDung"]
                        );
                        ?>
                    </td>


                    <td>

                        <?php
                        echo htmlspecialchars(
                            $booking["gioBatDau"]
                        );
                        ?>

                        -

                        <?php
                        echo htmlspecialchars(
                            $booking["gioKetThuc"]
                        );
                        ?>

                    </td>


                    <td>
                        <?php
                        echo htmlspecialchars(
                            $booking["mucDich"]
                        );
                        ?>
                    </td>


                    <td>

                        <?php if ($booking["trangThai"] == "Chờ duyệt"): ?>

                            <span class="status waiting">
                                Chờ duyệt
                            </span>

                        <?php else: ?>

                            <span class="status invalid">

                                <?php
                                echo htmlspecialchars(
                                    $booking["trangThai"]
                                );
                                ?>

                            </span>

                        <?php endif; ?>

                    </td>

                </tr>


            <?php endforeach; ?>


        </table>


    <?php else: ?>


        <p class="empty">
            Chưa có yêu cầu booking nào.
        </p>


    <?php endif; ?>


</div>

</body>

</html>