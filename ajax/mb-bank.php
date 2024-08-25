<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bank = $_POST["forbank"];
    $magd = $_POST["magiaodich"];
   // $hinhthucck = $_POST["hinhthucck"];
    $time = $_POST["time1"];
    $noidung = $_POST["noidung"];
    $name_gui = $_POST["name_gui"];
    $sotiengd = $_POST["amount"];
    $name_nhan = $_POST["name_nhan"];
    $stk_nhan = $_POST["stk"];
    $banknhan = $_POST["bank"];
    $tennganhang= $_POST["code1"];
    $kihieu= $_POST["code"];
    $logo= $_POST["code0"];
    $namebanknhan = $tennganhang . " (" . $kihieu . ")";
    $tong = $namebanknhan." - ".$stk_nhan ;
    $thoigianhientai = $_POST["thoigianhientai"] ?? "minhkhoi";
    $filePath = 'images/mbbank_phoi_vip.png';
    $fontPath = 'font/';
    $image = imagecreatefrompng($filePath);

    if (!is_numeric($sotiengd)) {
        http_response_code(405);
        echo "số tiền  không dùng ký tự đặc biệt !.";
    } else {
    function removeAccentsAndUpperCase($str) {
    $str = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
    $str = strtoupper($str);
    return $str;
    }    
    function canlephai($image, $fontsize, $y, $textColor, $font, $text) {
        $fontSize = $fontsize;
        $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
        $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
        $x = imagesx($image) - 80 - $textWidth- 39;
        imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
    }

    function canletrai($image, $fontsize, $y, $textColor, $font, $text) {
        $fontSize = $fontsize;
        imagettftext($image, $fontSize, 0, 220, $y, $textColor, $font, $text);
    }
     

    function canchinhgiua($image, $fontsize, $y, $textColor, $font, $text) {
        $fontSize = $fontsize;
        $textBoundingBox = imagettfbbox($fontSize, 0, $font, $text);
        $textWidth = $textBoundingBox[2] - $textBoundingBox[0];
        $imageWidth = imagesx($image);
        $x = ($imageWidth - $textWidth) / 2;
        imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
    }
    function canbentren($image, $x, $y, $color, $fontPath, $text, $fontSize)
    {
        imagettftext($image, $fontSize, 0, $x, $y, $color, $fontPath, $text);
    }
  
    function canle($image, $fontsize,$x, $y, $textColor, $font, $text) {
        $fontSize = $fontsize;
        imagettftext($image, $fontSize, 0, $x, $y, $textColor, $font, $text);
    }
    
    
    
   // canlephai($image, 37, 1605, imagecolorallocate($image, 0, 0, 0), $fontPath . '/AvertaStd/AvertaStd-Regular.otf', $hinhthucck);
   
     function canvip($image, $x, $y, $logo, $newWidth, $newHeight, $fontsize, $textColor, $font, $text) {
    // Kiểm tra tệp ảnh chính
    if (!is_resource($image) || get_resource_type($image) !== 'gd') {
        http_response_code(500);
        echo "Invalid image resource provided.";
        exit;
    }

    // Kiểm tra tệp ảnh logo
    if (!file_exists($logo)) {
        http_response_code(404);
        echo "File not found: $logo";
        exit;
    }

    // Load ảnh từ đường dẫn
    $icon = imagecreatefrompng($logo);

    if (!$icon) {
        http_response_code(500);
        echo "Failed to create image from file: $logo";
        exit;
    }

    // Tạo một ảnh mới với kích thước thay đổi
    $resizedIcon = imagecreatetruecolor($newWidth, $newHeight);
    imagealphablending($resizedIcon, false);
    imagesavealpha($resizedIcon, true);
    imagecopyresampled($resizedIcon, $icon, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($icon), imagesy($icon));

    // Chèn ảnh vào hình ảnh chính
    imagecopy($image, $resizedIcon, $x, $y, 0, 0, $newWidth, $newHeight);

    // In văn bản
    $fontSize = $fontsize;
    // Điều chỉnh vị trí của văn bản nếu cần thiết để nó không bị chồng lấn với logo
    $textX = $x + $newWidth + 10 + 13; // Ví dụ: văn bản được đặt bên phải của logo
    $textY = $y + $newHeight / 2 + 10; // Ví dụ: văn bản được căn giữa theo chiều cao của logo
    imagettftext($image, $fontSize, 0, $textX, $textY, $textColor, $font, $text);
   
    // Giải phóng bộ nhớ đối tượng ảnh
    imagedestroy($icon);
    imagedestroy($resizedIcon);
}
canvip($image, 188, 1170, $logo, 60, 60, 33, imagecolorallocate($image, 29, 41, 53), $fontPath . '/AvertaStd/AvertaStd-Regular.otf', $tong);

        
        
        
    canchinhgiua($image, 30, 862, imagecolorallocate($image, 94, 98,101),$fontPath . '/AvertaStd/AvertaStd-Regular.ttf', $time);
    //FULL 128
    
      canle($image, 31,695,1547, imagecolorallocate($image,22,39,47), $fontPath . '/AvertaStd/AvertaStd-Semibold.otf', $magd);
    
    canle($image, 34,280, 1291, imagecolorallocate($image, 27, 35, 46), $fontPath . '/AvertaStd/AvertaStd-Regular.otf', $noidung);
    
    
    
    //canlephai($image, 37, 1220, imagecolorallocate($image, 0, 0, 0), $fontPath . '/AvertaStd/AvertaStd-Regular.otf', $stk_gui);
    
      canchinhgiua($image, 66, 773, imagecolorallocate($image,18, 31, 206), $fontPath . '/AvertaStd/AvertaStd-Semibold.otf', number_format($sotiengd, 0, ',', ',') . ' VND');
      
      
    canlephai($image, 28, 1450, imagecolorallocate($image, 29,43,54), $fontPath . '/AvertaStd/AvertaStd-Bold.otf', removeAccentsAndUpperCase($name_gui));
    
    
    //canle($image, 30,672, 1450, imagecolorallocate($image, 29,43,54), $fontPath . '/AvertaStd/AvertaStd-Bold.otf', removeAccentsAndUpperCase($name_gui));
  
    
    
    function canbentren2($image, $x, $y, $logo, $newWidth, $newHeight) {
            // Kiểm tra tệp ảnh
            if (!file_exists($logo)) {
                http_response_code(404);
                echo "File not found: $logo";
                exit;
            }

            // Load ảnh từ đường dẫn
            $icon = imagecreatefrompng($logo);

            if (!$icon) {
                http_response_code(500);
                echo "Failed to create image from file: $logo";
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
    
    
    
    
    
    
    
  //  canle($image, 38,385, 1109, imagecolorallocate($image, 44, 44, 44), $fontPath . '/AvertaStd/AvertaStd-Bold.otf', removeAccentsAndUpperCase($name_nhan));
    //full 46
     canchinhgiua($image, 40, 1109, imagecolorallocate($image, 46, 46, 46), $fontPath . '/AvertaStd/AvertaStd-Bold.otf', removeAccentsAndUpperCase($name_nhan));
    //full 46
    
    //canle($image, 33,280, 1207 , imagecolorallocate($image, 29, 42, 201), $fontPath . '/AvertaStd/AvertaStd-Regular.otf', $tong);
    //51
    
   // canle($image, 33.2, 325,1206, imagecolorallocate($image, 26,39,206), $fontPath . '/AvertaStd/AvertaStd-Regular.otf', $namebanknhan);
    // canle($image, 32, 320,1205, imagecolorallocate($image, 26,39,47), $fontPath . '/AvertaStd/AvertaStd-Regular.otf', $namebanknhan);
    
    
    
    canbentren($image, 160, 95, imagecolorallocate($image, 0, 0 ,0), $fontPath . '/AvertaStd/AvertaStd-Bold.otf', $thoigianhientai, 40);
    //regular font
   // canbentren2($image, 170, 1170,$logo, 63, 44);
    ob_start();
    imagejpeg($image);
    $imageData = ob_get_clean();
    $base64 = base64_encode($imageData);
    echo $base64;
    imagedestroy($image);
}
} else {
    http_response_code(405);
    echo 'ERROR CONTACT TO TRONGTHAO';
}
?>
