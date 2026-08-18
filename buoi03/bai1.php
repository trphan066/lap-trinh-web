<!DOCTYPE html>
<html lang="vi">
<head>
<meta charset="UTF-8">
<title>Form liên hệ</title>
<style>
  body { font-family: Arial, sans-serif; max-width: 500px; margin: 40px auto; }
  label { display: block; margin-top: 12px; font-weight: bold; }
  input, select, textarea { width: 100%; padding: 6px; margin-top: 4px; box-sizing: border-box; }
  .error { color: red; font-size: 14px; margin-top: 2px; }
  .success { color: green; font-weight: bold; margin-top: 16px; }
  button { margin-top: 16px; padding: 8px 16px; }
</style>
</head>
<body>

<h2>Liên hệ</h2>

<form id="contactForm">
  <label>Họ tên</label>
  <input type="text" id="hoTen">
  <div class="error" id="errHoTen"></div>

  <label>Email</label>
  <input type="text" id="email">
  <div class="error" id="errEmail"></div>

  <label>Chủ đề</label>
  <input type="text" id="chuDe">

  <label>Nội dung</label>
  <textarea id="noiDung" rows="4"></textarea>
  <div class="error" id="errNoiDung"></div>

  <label>Ảnh đại diện</label>
  <input type="file" id="anhDaiDien">
  <div class="error" id="errAnh"></div>

  <button type="submit">Gửi liên hệ</button>
  <div class="success" id="successMsg"></div>
</form>

<script>
document.getElementById("contactForm").addEventListener("submit", function(e) {
  e.preventDefault(); // chặn form gửi đi theo cách mặc định, để mình tự xử lý bằng JS

  // Lấy dữ liệu người dùng đã nhập
  const hoTen = document.getElementById("hoTen").value.trim();
  const email = document.getElementById("email").value.trim();
  const noiDung = document.getElementById("noiDung").value.trim();
  const fileInput = document.getElementById("anhDaiDien");
  const file = fileInput.files[0]; // file đầu tiên được chọn (nếu có)

  // Xóa các thông báo lỗi cũ trước khi kiểm tra lại
  document.getElementById("errHoTen").textContent = "";
  document.getElementById("errEmail").textContent = "";
  document.getElementById("errNoiDung").textContent = "";
  document.getElementById("errAnh").textContent = "";
  document.getElementById("successMsg").textContent = "";

  let hopLe = true; //  đánh dấu form có hợp lệ hay không

  // Điều kiện 1: họ tên không được rỗng
  if (hoTen === "") {
    document.getElementById("errHoTen").textContent = "Vui lòng nhập họ tên.";
    hopLe = false;
  }

  // Điều kiện 2: email phải đúng định dạng (dùng regex đơn giản)
  const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!regexEmail.test(email)) {
    document.getElementById("errEmail").textContent = "Email không đúng định dạng.";
    hopLe = false;
  }

  // Điều kiện 3: nội dung không được rỗng
  if (noiDung === "") {
    document.getElementById("errNoiDung").textContent = "Vui lòng nhập nội dung.";
    hopLe = false;
  }

  // Kiểm tra ảnh đại diện: 3 điều kiện bắt buộc
  if (!file) {
    // Điều kiện a: phải chọn file
    document.getElementById("errAnh").textContent = "Vui lòng chọn ảnh đại diện.";
    hopLe = false;
  } else {
    const dinhDangChoPhep = ["image/jpeg", "image/jpg", "image/png"];
    // Điều kiện b: đúng định dạng JPG, JPEG, PNG
    if (!dinhDangChoPhep.includes(file.type)) {
      document.getElementById("errAnh").textContent = "Chỉ cho phép file JPG, JPEG, PNG.";
      hopLe = false;
    }
    // Điều kiện c: dung lượng tối đa 2MB (2 * 1024 * 1024 byte)
    else if (file.size > 2 * 1024 * 1024) {
      document.getElementById("errAnh").textContent = "Dung lượng ảnh tối đa 2MB.";
      hopLe = false;
    }
  }

  // Nếu có lỗi thì dừng lại, dữ liệu đã nhập vẫn còn nguyên vì mình không gọi form.reset()
  if (!hopLe) return;

  // Nếu mọi thứ hợp lệ thì hiển thị thông báo thành công
  document.getElementById("successMsg").textContent = "Gửi liên hệ thành công!";
  this.reset(); // chỉ xóa trắng form khi thành công
});
</script>

</body>
</html>