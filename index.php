<?php
    Function calc($size, $speed, $speed_unit, $size_unit){
        // birim çevirme işlemi için iki değişken ($convert_speed & $convert_size) tanımladım. 
        // her şey 'mb/(mb/sec)' ten çevrilerek hesaplanıyor.
        // kullanıcıdan gelen veriye göre fonksiyon değerleri değişmekte.
        $convert_speed = 1; // varsayılan birim olarak mb/sec aldım
        if ($speed_unit == "kb/sec") {
            $convert_speed = 1024; // mb/sec -> kb/sec
        }
        if ($speed_unit == "gb/sec") {
            $convert_speed = 1/1024; // mb/sec -> gb/sec
        }
        if ($speed_unit == "mbps") {
            $speed = ($speed * 128); // Mbps olarak gelen hız değeri kb/sec'e dönüştürüldü.
            $convert_speed = 1024; // $speed değişkeni kb/sec olduğu için $convert_speed=1024 olur.
        }

        $convert_size = 1; // varsayılan birim mb
        if ($size_unit == "kb") {
            $convert_size = 1024; // mb -> kb
        }
        if ($size_unit == "gb") {
            $convert_size = 1/1024; // mb -> gb
        }
        
        // matematiksel işlemler
        // floor() -> alt değere yuvarlamak için kullanılan fonksiyon. örn: floor(1,5) = 1;
        $x      = $convert_speed * $convert_size * $size / $speed;
        $second = ($x) % 60;
        $minute = floor($x / 60) % 60;
        $hour   = floor($x / 60 / 60) % 60;
        $day    = floor($x / 60 / 60 / 24) % 24;
        $month  = floor($x / 60 / 60 / 24 / 30) % 30;
        $year   = floor($x / 60 / 60 / 24 / 30 /12) % 12;

        // sonucu ekrana yaz
        echo "$year years, $month months, $day days, $hour hours, $minute minute, $second seconds";
        return;
    }
    
    if ($_POST) { // eğer veri gönderildiyse çalış

        // html formundan gelen -yani kullanıcıdan gelen- verileri php'ye aktar.
        $file_size      = $_POST["size"];
        $download_speed = $_POST["speed"];
        $speed_unit     = $_POST["select_speed_unit"];
        $size_unit      = $_POST["select_size_unit"];

        // eğer gelen değer sıfırdan küçük ise hata ver
        if ($file_size < 0 || $download_speed < 0) {
            echo "ERROR";
            return;
        }

        // kullanıcıdan gelen verileri yukarda tanımlanan fonksiyonda çalıştır
        calc($file_size, $download_speed, $speed_unit, $size_unit);
    }
?>