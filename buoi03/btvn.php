<?php

// =========================
// 1. KHỞI TẠO DỮ LIỆU
// =========================

$rooms = [
    "101", "102", "103", "104",
    "201", "202", "203", "204"
];

$requestTypes = [
    "Đặt phòng",
    "Mượn thiết bị"
];

$errors = [];

$nguoiYeuCau = "";
$loaiYeuCau = "";
$phong = "";
$ngaySuDung = "";
$gioBatDau = "";
$gioKetThuc = "";
$mucDich = "";

$booking = null;


// =========================
// 2. HÀM LÀM SẠCH DỮ LIỆU
// =========================

function cleanInput($data)
{
    return trim($data);
}


// =========================
// 3. HÀM KIỂM TRA NGÀY
// =========================

function isValidDate($date)
{
    $d = DateTime::createFromFormat("Y-m-d", $date);

    return $d && $d->format("Y-m-d") === $date;
}


// =========================
// 4. HÀM XÁC ĐỊNH TRẠNG THÁI
// =========================

function xacDinhTrangThai($loaiYeuCau, $ngaySuDung)
{
    $ngayHienTai = date("Y-m-d");

    if ($ngaySuDung < $ngayHienTai) {
        return "Không hợp lệ";
    }

    if (
        $loaiYeuCau == "Đặt phòng" ||
        $loaiYeuCau == "Mượn thiết bị"
    ) {
        return "Chờ duyệt";
    }

    return "Không xác định";
}


// =========================
// 5. XỬ LÝ FORM
// =========================

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Nhận dữ liệu từ form
    $nguoiYeuCau = cleanInput($_POST["nguoiYeuCau"] ?? "");
    $loaiYeuCau = cleanInput($_POST["loaiYeuCau"] ?? "");
    $phong = cleanInput($_POST["phong"] ?? "");
    $ngaySuDung = cleanInput($_POST["ngaySuDung"] ?? "");
    $gioBatDau = cleanInput($_POST["gioBatDau"] ?? "");
    $gioKetThuc = cleanInput($_POST["gioKetThuc"] ?? "");
    $mucDich = cleanInput($_POST["mucDich"] ?? "");


    // =========================
    // 6. VALIDATION NGƯỜI YÊU CẦU
    // =========================

    if ($nguoiYeuCau === "") {

        $errors["nguoiYeuCau"] = "Vui lòng nhập người yêu cầu.";

    } elseif (mb_strlen($nguoiYeuCau) < 2) {

        $errors["nguoiYeuCau"] =
            "Tên người yêu cầu phải có ít nhất 2 ký tự.";

    } elseif (mb_strlen($nguoiYeuCau) > 50) {

        $errors["nguoiYeuCau"] =
            "Tên người yêu cầu không được quá 50 ký tự.";
    }


    // =========================
    // 7. VALIDATION LOẠI YÊU CẦU
    // =========================

    if ($loaiYeuCau === "") {

        $errors["loaiYeuCau"] =
            "Vui lòng chọn loại yêu cầu.";

    } elseif (!in_array($loaiYeuCau, $requestTypes, true)) {

        $errors["loaiYeuCau"] =
            "Loại yêu cầu không hợp lệ.";
    }


    // =========================
    // 8. VALIDATION PHÒNG
    // =========================

    if ($phong === "") {

        $errors["phong"] = "Vui lòng chọn phòng.";

    } elseif (!in_array($phong, $rooms, true)) {

        $errors["phong"] = "Phòng không hợp lệ.";
    }


    // =========================
    // 9. VALIDATION NGÀY
    // =========================

    if ($ngaySuDung === "") {

        $errors["ngaySuDung"] =
            "Vui lòng chọn ngày sử dụng.";

    } elseif (!isValidDate($ngaySuDung)) {

        $errors["ngaySuDung"] =
            "Ngày sử dụng không đúng định dạng.";

    } elseif ($ngaySuDung < date("Y-m-d")) {

        $errors["ngaySuDung"] =
            "Không được chọn ngày đã qua.";
    }


    // =========================
    // 10. VALIDATION GIỜ
    // =========================

    if ($gioBatDau === "") {

        $errors["gioBatDau"] =
            "Vui lòng chọn giờ bắt đầu.";

    }

    if ($gioKetThuc === "") {

        $errors["gioKetThuc"] =
            "Vui lòng chọn giờ kết thúc.";

    }


    // Kiểm tra giờ bắt đầu và kết thúc
    if (
        $gioBatDau !== "" &&
        $gioKetThuc !== "" &&
        $gioBatDau >= $gioKetThuc
    ) {

        $errors["gioKetThuc"] =
            "Giờ kết thúc phải sau giờ bắt đầu.";
    }


    // =========================
    // 11. VALIDATION MỤC ĐÍCH
    // =========================

    if ($mucDich === "") {

        $errors["mucDich"] =
            "Vui lòng nhập mục đích.";

    } elseif (mb_strlen($mucDich) < 5) {

        $errors["mucDich"] =
            "Mục đích phải có ít nhất 5 ký tự.";

    } elseif (mb_strlen($mucDich) > 200) {

        $errors["mucDich"] =
            "Mục đích không được quá 200 ký tự.";
    }


    // =========================
    // 12. NẾU KHÔNG CÓ LỖI
    // =========================

    if (empty($errors)) {

        $trangThai = xacDinhTrangThai(
            $loaiYeuCau,
            $ngaySuDung
        );

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
    }
}


// =========================
// 13. HÀM HIỂN THỊ AN TOÀN
// =========================

function e($value)
{
    return htmlspecialchars(
        $value,
        ENT_QUOTES,
        "UTF-8"
    );
}

?>

<!DOCTYPE html>
<html lang="vi">

<head>

    <meta charset="UTF-8">

    <title>Quản lý yêu cầu Booking</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f5f5f5;
        }

        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 25px;
        }

        h1 {
            margin-top: 0;
        }

        label {
            display: block;
            margin-top: 12px;
            font-weight: bold;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        textarea {
            height: 80px;
        }

        button {
            margin-top: 15px;
            padding: 9px 18px;
            cursor: pointer;
        }

        .error {
            color: #c00;
            font-size: 14px;
            margin-top: 4px;
        }

        .success {
            padding: 10px;
            margin-top: 20px;
            border: 1px solid #aaa;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background: #eee;
        }

    </style>

</head>

<body>

<div class="container">

    <h1>Quản lý yêu cầu Booking</h1>

    <form method="POST" action="">

        <!-- Người yêu cầu -->
        <label for="nguoiYeuCau">
            Người yêu cầu
        </label>

        <input
            type="text"
            id="nguoiYeuCau"
            name="nguoiYeuCau"
            value="<?= e($nguoiYeuCau) ?>"
        >

        <?php if (isset($errors["nguoiYeuCau"])): ?>

            <div class="error">
                <?= e($errors["nguoiYeuCau"]) ?>
            </div>

        <?php endif; ?>


        <!-- Loại yêu cầu -->
        <label for="loaiYeuCau">
            Loại yêu cầu
        </label>

        <select id="loaiYeuCau" name="loaiYeuCau">

            <option value="">
                -- Chọn loại yêu cầu --
            </option>

            <?php foreach ($requestTypes as $type): ?>

                <option
                    value="<?= e($type) ?>"
                    <?= $loaiYeuCau === $type ? "selected" : "" ?>
                >
                    <?= e($type) ?>
                </option>

            <?php endforeach; ?>

        </select>

        <?php if (isset($errors["loaiYeuCau"])): ?>

            <div class="error">
                <?= e($errors["loaiYeuCau"]) ?>
            </div>

        <?php endif; ?>


        <!-- Phòng -->
        <label for="phong">
            Phòng
        </label>

        <select id="phong" name="phong">

            <option value="">
                -- Chọn phòng --
            </option>

            <?php foreach ($rooms as $room): ?>

                <option
                    value="<?= e($room) ?>"
                    <?= $phong === $room ? "selected" : "" ?>
                >
                    Phòng <?= e($room) ?>
                </option>

            <?php endforeach; ?>

        </select>

        <?php if (isset($errors["phong"])): ?>

            <div class="error">
                <?= e($errors["phong"]) ?>
            </div>

        <?php endif; ?>


        <!-- Ngày -->
        <label for="ngaySuDung">
            Ngày sử dụng
        </label>

        <input
            type="date"
            id="ngaySuDung"
            name="ngaySuDung"
            value="<?= e($ngaySuDung) ?>"
        >

        <?php if (isset($errors["ngaySuDung"])): ?>

            <div class="error">
                <?= e($errors["ngaySuDung"]) ?>
            </div>

        <?php endif; ?>


        <!-- Giờ bắt đầu -->
        <label for="gioBatDau">
            Giờ bắt đầu
        </label>

        <input
            type="time"
            id="gioBatDau"
            name="gioBatDau"
            value="<?= e($gioBatDau) ?>"
        >

        <?php if (isset($errors["gioBatDau"])): ?>

            <div class="error">
                <?= e($errors["gioBatDau"]) ?>
            </div>

        <?php endif; ?>


        <!-- Giờ kết thúc -->
        <label for="gioKetThuc">
            Giờ kết thúc
        </label>

        <input
            type="time"
            id="gioKetThuc"
            name="gioKetThuc"
            value="<?= e($gioKetThuc) ?>"
        >

        <?php if (isset($errors["gioKetThuc"])): ?>

            <div class="error">
                <?= e($errors["gioKetThuc"]) ?>
            </div>

        <?php endif; ?>


        <!-- Mục đích -->
        <label for="mucDich">
            Mục đích
        </label>

        <textarea
            id="mucDich"
            name="mucDich"
        ><?= e($mucDich) ?></textarea>

        <?php if (isset($errors["mucDich"])): ?>

            <div class="error">
                <?= e($errors["mucDich"]) ?>
            </div>

        <?php endif; ?>


        <button type="submit">
            Gửi yêu cầu
        </button>

    </form>


    <?php if ($booking !== null): ?>

        <div class="success">
            Yêu cầu đã được tiếp nhận và đang chờ xử lý.
        </div>

        <h2>Thông tin yêu cầu</h2>

        <table>

            <tr>
                <th>Người yêu cầu</th>
                <td><?= e($booking["nguoiYeuCau"]) ?></td>
            </tr>

            <tr>
                <th>Loại yêu cầu</th>
                <td><?= e($booking["loaiYeuCau"]) ?></td>
            </tr>

            <tr>
                <th>Phòng</th>
                <td><?= e($booking["phong"]) ?></td>
            </tr>

            <tr>
                <th>Ngày sử dụng</th>
                <td><?= e($booking["ngaySuDung"]) ?></td>
            </tr>

            <tr>
                <th>Thời gian</th>
                <td>
                    <?= e($booking["gioBatDau"]) ?>
                    -
                    <?= e($booking["gioKetThuc"]) ?>
                </td>
            </tr>

            <tr>
                <th>Mục đích</th>
                <td><?= e($booking["mucDich"]) ?></td>
            </tr>

            <tr>
                <th>Trạng thái</th>
                <td><?= e($booking["trangThai"]) ?></td>
            </tr>

        </table>

    <?php endif; ?>

</div>

</body>

</html>