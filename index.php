
<?php
session_start();
require("./function/convKanaToKanji.php");
require("./function/convRomajiToKanji.php");

$checkOK = false;
$access_deny = false;
$show_text = "";
if (!empty($_POST)) {
    if (isset($_POST["romaji-input"])) {
        if (isset($_SESSION["token"]) && $_SESSION["token"] == $_POST["token"]) {
            $checkOK = true;
            $romaji_input = $_POST["romaji-input"];
            $show_text .= "<div class='font2-0'>Romaji: ".$romaji_input."</div><br>";

            $kana = getConvRomajiToKanaString($romaji_input);
            $show_text .= "<div class='font2-0'>Kana: ".$kana."</div><br>";

            $kanjiArray = getConvKanaToKanjiList($kana);
            //print_r($kanjiArray);

            $i=0;
            $trans_set = "";
            while ($i<=255) {
                if (empty($kanjiArray[$i][1][0])) break;
                
                $trans_set .= $kanjiArray[$i][1][0];
                $i++;
            }

            $show_text .= "<div class='font2-0'>Kanji: ".$trans_set."</div>";
        } else {
            $access_deny = true;
        }
    }
}

$TOKEN_LENGTH = 16;
$tokenByte = openssl_random_pseudo_bytes($TOKEN_LENGTH);
$token = bin2hex($tokenByte);
$_SESSION['token'] = $token;
//echo "<br>".$_SESSION["token"]."<br>";
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <link rel="stylesheet" href="./assets/css/base.css">
    </head>
    <body>
        <?php 
        if ($access_deny) {
            die("<div class='access-deny font3-0'>Access denied.</div>");
        }
        ?>
        
            <form action="" method="POST" >
                <label class="font2-0">
                    Romaji
                    <input type="text" name="romaji-input" placeholder="ローマ字を入力してください。">
                </label>
                <input type="hidden" name="token" value="<?=$_SESSION["token"]?>">
                <input type="submit" value="send">
            </form>
        <?php if ($checkOK): ?>
            <?php echo $show_text; ?>
        <?php endif; ?>
    </body>
</html>
<?php
exit();
?>