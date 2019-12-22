<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Download Time Calculator v3.0</title>
    <style type="text/css">
        body{
            background-color: #3C4556;
        }
        input[type=number], select {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .content{
            border-radius: 5px;
            background-color: #465165;
            padding: 20px;
            margin: 20px;
            display: block;
            color: white;
        }

        .result{
            min-height: 65px;
            height: auto;
        }

        .main{
            margin: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        

    </style>
</head>
<body class="center">
    <div class="main">
        <div class="content">
            <table>
                <form action="" method="post">
                    <tr>
                        <td>File Size:</td>
                        <td><input type="number" name="size" id="size" placeholder="" required></td>
                        <td>
                            <select name="select_size_unit">
                                <option value="kb">kb</option>
                                <option value="mb" selected>mb</option>
                                <option value="gb">gb</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Avg. Download Speed:</td>
                        <td><input type="number" name="speed" id="speed" placeholder="" required></td>
                        <td>
                            <select name="select_speed_unit">
                                <option value="kb/sec" selected>kb/sec</option>
                                <option value="mb/sec">mb/sec</option>
                                <option value="gb/sec">gb/sec</option>
                                <option value="mbps">Mbps</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" id="submit" value="Calculate!"></td>
                        <td></td>
                    </tr>
                </form>
            </table>
        </div>
        <div class="content text-center result">
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
        </div>
    </div>
</body>
</html>


