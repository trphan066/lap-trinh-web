<?php


$students = [
    [
        "name" => "Nguyen ky",
        "midterm" => 9,
        "final" => 9
    ],
    [
        "name" => "Nguyen Hong Mai",
        "midterm" => 5,
        "final" => 5
    ],
    [
        "name" => "Dang Quang Trung",
        "midterm" => 6.5,
        "final" => 5.7
    ]
];


function calculateAverage($student) {
    return ($student["midterm"] + $student["final"]) / 2;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    
</head>

<body>



<table border="1" cellpadding="8">

    <tr>
        <th>Ten sinh vien</th>
        <th>giua ky</th>
        <th>cuoi ky</th>
        <th>diem tb</th>
        <th>Ket qua</th>
    </tr>

    <?php foreach ($students as $student): ?>

        <?php
        $average = calculateAverage($student);

        // Kiểm tra kết quả
        if ($average >= 5) {
            $result = "Đạt";
        } else {
            $result = "Chưa đạt";
        }
        ?>

        <tr>
            <td>
                <?php echo htmlspecialchars($student["name"]); ?>
            </td>

            <td>
                <?php echo $student["midterm"]; ?>
            </td>

            <td>
                <?php echo $student["final"]; ?>
            </td>

            <td>
                <?php echo $average; ?>
            </td>

            <td>
                <?php echo $result; ?>
            </td>
        </tr>

    <?php endforeach; ?>

</table>

</body>
</html>