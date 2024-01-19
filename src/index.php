<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>2023~2024プレミアリーグ選手一覧</title>
    <link rel="stylesheet" href="css/List.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script>
    <?php 
require 'nav.html';
?>
</head>
<body>
    <?php

    require 'db-connect.php';
                echo '<main class="wrapper">';
                echo    '<section class="head">';
                echo        '<h3>プレミアリーグ選手一覧</h3>';
                echo    '</section>';
                echo    '<section class="body">';
                
                $delete = "return confirm('削除しますか？')";
                echo '<table><thead><tr><th width="15%">選手画像(クリックで拡大)</th><th  width="15%">選手名</th><th  width="15%">国籍</th><th  width="15%">ポジション</th><th  width="15%">クラブ名</th><th></th><th  width="10%">動作</th><th></th></tr></thead>';
                    echo '<tbody>';
                    foreach ($pdo->query('SELECT Player. * , club_name FROM Player INNER JOIN Club ON Player.club_id = Club.club_id where club_flag=1') as $row) {
                        echo '<tr>';
                            $clubname=$row['club_name'];
                            $player=$row['player_name'];
                            $path="./image/{$clubname}";
                            $path1="./image/{$clubname}/{$player}";
                            if(!file_exists($path)){
                                mkdir("./image/{$clubname}", 0777);
                            }
                            if(!file_exists($path1)){
                                mkdir("./image/{$clubname}/{$player}", 0777);
                            }
        
                            $imageDirectory = 'image/' . $clubname . '/'.$player.'/';
                            // 画像ファイルを取得
                            $images = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                            echo'<td style="word-break: break-word">';
                            if (!empty($images)) {
                                foreach ($images as $image) {
                                    $fileName = basename($image);
                                   
                                    echo '<a style="cursor:zoom-in;" href="' . $image . '" data-lightbox="group"><img src="' . $image . '" alt="' . $fileName . '" width="65" height="65"></a>';
                                   
                                }
                            } else {
                               echo 'No image';
                            }
                            echo'</td>';
                           
                            echo '<td class="center" style="word-break: break-word">'.$row['player_name'].'</td>';
                            echo '<td class="center" style="word-break: break-word">'.$row['nationality'].'</td>';
                            echo '<td class="center" style="word-break: break-word"><strong>'.$row['position'].'</strong></td>';
                            echo '<td class="center" style="word-break: break-word">'.$row['club_name'].'</td>';
                            echo '<td style="word-break: break-word" width="5%">';
                            echo '</td>';

                            echo '<td class="center">';
                                echo '<form action="PlayerUpdate.php" method="post">';
                                    echo '<input type="hidden" name="id" value="'.$row['player_id'].'">';
                                    echo '<input type="hidden" name="position" value="'.$row['position'].'">';
                                    echo '<input type="hidden" name="nationality" value="'.$row['nationality'].'">';
                                    echo '<button class="up" type ="submit">更新</button>';
                                echo '</form>';
                                echo '<form action="PlayerDeleteFinish.php" method="post">';
                                    echo '<input type="hidden" name="club_name" value="'.$row['club_name'].'">';
                                    echo '<input type="hidden" name="player_name" value="'.$row['player_name'].'">';
                                    echo '<input type="hidden" name="player_id" value="'.$row['player_id'].'">';
                                    echo '<button onclick="'.$delete.'" class="del" type ="submit">削除</button>';
                                echo '</form>';
                        echo '</td><td></td></tr>';
                    }
                    echo '</tbody>';
                echo '</table>';
            echo '</section>';
            echo '<section class="foot">';
            echo     '<form action="PlayerRegister.php" method="post">';
            echo         '<button class="register" type="submit">選手登録</button>';
            echo     '</form>';
            echo '</section>';
            echo '</main>';
        ?>
    </main>
</body>
</html>