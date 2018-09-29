<?php

class db    {
    const HOST = "localhost";
    const USER = "root";
    const PASSWORD = "autoset";
    const DB_NAME = "vote";
    const TABLE_NAME = "member";
    public $mysqli;

    function __construct()
    {
        $this->mysqli = new mysqli(self::HOST, self::USER, self::PASSWORD, self::DB_NAME);

        if ($this->mysqli->connect_errno) {
            printf("Connect failed: %s\n", $this->mysqli->connect_error);
            exit();
        }

    }

}

class work  {
    //db에 html으로 부터 전달받은 값 저장

    function db_update($db)    {
        $elect = $_POST['vote'];
        switch ($elect) {
            case "김대권":
                $id = 0;
                break;
            case "정야망":
                $id = 1;
                break;
            case "강희망":
                $id = 2;
                break;
        }
        $sql = "UPDATE memeber SET vote = vote + 1 WHERE id = $id;";
        if($db->mysqli->query($sql))    {
            echo "<script>location.href = 'voting_form.html'</script>";
        }
        else
            echo "쿼리 전송이 실패 되었습니다.";
    }

    function db_select($db)    {

        // 총 표의 개수
        $chong = 0;

        // 김대권의 표의 개수
        $kim = 0;

        // 정야망의 표의 개수
        $ya = 0;

        // 정희망의 표의 개수
        $jung = 0;

        // 총 표의 개수와 각 각 후보의 표의 개수
        $sql = "SELECT * FROM memeber";
        $result = $db->mysqli->query($sql);

        // 한 행씩 가지고 오기
        for ($i = 0; $i < $result->field_count; $i++)  {
            $row = $result->fetch_array();

            $chong = $chong + $row[2];

            switch ($row[0])   {
                case 0:
                    $kim = $row[2];
                    break;
                case 1:
                    $ya = $row[2];
                    break;
                case 2:
                    $jung = $row[2];
                    break;
            }

        }

        $height = 100;
        $text = $_GET['text'];



        switch ($text)   {
            case "김대관":
                $width = $kim / $chong * 600;
                $per = $kim / $chong * 100;
                $im = imagecreatetruecolor($width, $height);
                $white = imagecolorallocate($im, 255, 255, 255);
                $blue = imagecolorallocate($im, 0, 0, 255);
                imagefill($im, 0, 0 ,$blue);
                imagestring($im, 50, 0, 0, $kim." ".ceil($per)."%", $white);
                break;


            case "정야망":
                $width = $ya / $chong * 600;
                $per = $ya / $chong * 100;
                $im = imagecreatetruecolor($width, $height);
                $white = imagecolorallocate($im, 255, 255, 255);
                $black = imagecolorallocate($im, 0, 0, 0);
                imagefill($im, 0, 0 ,$black);
                imagestring($im, 50, 0, 0, $ya." ".ceil($per)."%", $white);
                break;


            case "정희망":
                $width = $jung / $chong * 600;
                $per = $jung / $chong * 100;
                $im = imagecreatetruecolor($width, $height);
                $white = imagecolorallocate($im, 255, 255, 255);
                $red = imagecolorallocate($im, 255, 0, 0);
                imagefill($im, 0, 0 ,$red);
                imagestring($im, 50, 0, 0, $jung." ".ceil($per)."%", $white);
                break;
        }

        header('Content-type: image/png');
        imagepng($im);
        imagedestroy($im);


    }
}

$db = new db();
$obj = new work();
if(isset($_GET['text']))    {
    $obj->db_select($db);
} else  {
    $obj->db_update($db);
}


