<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bank = $_POST["forbank"];
    $magd = $_POST["magiaodich"];
    $hinhthucck = $_POST["hinhthucck"] ?? "";
    $time = $_POST["time1"];
    $noidung = $_POST["noidung"];
    $sotiengd = $_POST["amount"];
    $name_nhan = $_POST["name_nhan"];
    $stk_nhan = $_POST["stk"];
    $banknhan = $_POST["bank"];
    $giochuyen = $_POST["giochuyen"] ?? "trongthao";
    $filePath = 'images/techcombank1.png'; // Đảm bảo đường dẫn này đúng
    $fontPath = 'font/';
    $imagePath = $_POST["pin"];// Đảm bảo đường dẫn này đúng

    // Kiểm tra tệp ảnh
    if (!file_exists($filePath)) {
        http_response_code(404);
        echo "File not found: $filePath";
        exit;
    }

    $image = imagecreatefrompng($filePath);

    if (!$image) {
        http_response_code(500);
        echo "Failed to create image from file: $filePath";
        exit;
    }

    if (!is_numeric($sotiengd)) {
        http_response_code(405);
        echo "Ngu, số tiền mà dùng ký tự đặc biệt!";
        exit;
    } else {
        function canlephai($image, $fontsize, $y, $textColor, $font, $text){
            $fontSize = $fontsize;
            $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
            $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
            $x = imagesx($image) - 80 - $textWidth;
            imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
        }

        function canletrai($image, $fontsize, $y, $textColor, $font, $text, $x_tcb){
            $fontSize = $fontsize;
            imagettftext($image, $fontSize, 0, $x_tcb, $y, $textColor, $font, $text);
        }

        function canchinhgiua($image, $fontsize, $y, $textColor, $font, $text) {
            $fontSize = $fontsize;
            $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
            $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
            $imageWidth = imagesx($image);
            $x = ($imageWidth - $textWidth) / 2;
            imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
        }

        function canbentren($image, $x, $y, $color, $fontPath, $text, $fontSize) {
            imagettftext($image, $fontSize, 0, $x, $y, $color, $fontPath, $text);
        }

        function canbentren2($image, $x, $y, $imagePath, $newWidth, $newHeight) {
            // Kiểm tra tệp ảnh
            if (!file_exists($imagePath)) {
                http_response_code(404);
                echo "File not found: $imagePath";
                exit;
            }

            // Load ảnh từ đường dẫn
            $icon = imagecreatefrompng($imagePath);

            if (!$icon) {
                http_response_code(500);
                echo "Failed to create image from file: $imagePath";
                exit;
            }

            // Tạo một ảnh mới với kích thước thay đổi
            $resizedIcon = imagecreatetruecolor($newWidth, $newHeight);
            imagealphablending($resizedIcon, false);
            imagesavealpha($resizedIcon, true);
            imagecopyresampled($resizedIcon, $icon, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($icon), imagesy($icon));

            // Chèn ảnh vào hình ảnh chính
            imagecopy($image, $resizedIcon, $x, $y, 0, 0, $newWidth, $newHeight);

            // Giải phóng bộ nhớ đối tượng ảnh
            imagedestroy($icon);
            imagedestroy($resizedIcon);
        }

        canletrai($image, 135, 2230, imagecolorallocate($image, 0, 0, 0), $fontPath.'/San Francisco/SanFranciscoDisplay-Semibold.otf', 'tới '.$name_nhan, 150);
        canletrai($image, 137, 2435, imagecolorallocate($image, 0, 0, 0), $fontPath.'/San Francisco/SanFranciscoDisplay-Semibold.otf', number_format($sotiengd, 0, ',', ','), 580);
        canletrai($image, 87, 2920, imagecolorallocate($image, 0, 0, 0), $fontPath.'/San Francisco/SanFranciscoDisplay-Semibold.otf', $banknhan, 155);
        canletrai($image, 87, 3050, imagecolorallocate($image, 0, 0, 0), $fontPath.'/San Francisco/SanFranciscoDisplay-Semibold.otf', $stk_nhan, 155);
        canletrai($image, 87, 3470, imagecolorallocate($image, 0, 0, 0), $fontPath.'/San Francisco/SanFranciscoDisplay-Semibold.otf', $noidung, 155);
        canletrai($image, 87, 3900, imagecolorallocate($image, 0, 0, 0), $fontPath.'/San Francisco/SanFranciscoDisplay-Semibold.otf', $time, 155);
        canletrai($image, 87, 4320, imagecolorallocate($image, 0, 0, 0), $fontPath.'/San Francisco/SanFranciscoDisplay-Semibold.otf', $magd, 155);
        canbentren($image, 125, 175, imagecolorallocate($image, 0, 0, 0), $fontPath . '/San Francisco/SanFranciscoDisplay-Semibold.otf', $giochuyen, 74);
        canbentren2($image, 2280, 60, $imagePath, 160, 160); // Chỉnh kích thước về 100x100

        ob_start();
        imagejpeg($image);
        $imageData = ob_get_clean();
        $base64 = base64_encode($imageData);
        echo $base64;
        imagedestroy($image);
    }
} else {
    http_response_code(405);
    echo 'ERROR CONTACT TO THANHDIEU';
}
?>
