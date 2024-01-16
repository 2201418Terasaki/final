<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>クラブ管理</title>
    <link rel="stylesheet" href="css/manage.css">
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
                echo        '<h3>クラブ管理</h3>';
                echo    '</section>';
                echo    '<section class="body">';
                
                $delete = "return confirm('削除しますか？')";
                echo '<table><thead><tr><th width="15%">エンブレム</th><th  width="15%">クラブ名</th><!--<th  width="20%">ホームタウン</th>--><th  width="15%">監督</th><th  width="15%">公式サイト</th><th></th><th  width="10%">動作</th><th></th></tr></thead>';
                    echo '<tbody>';
                    foreach ($pdo->query('SELECT * from Club where club_flag=1') as $row) {
                        echo '<tr>';
                            $clubname=$row['club_name'];
                            $path="./image/{$clubname}";
                            if(!file_exists($path)){
                                mkdir("./image/{$clubname}", 0777);
                            }
                            $imageDirectory = 'image/' . $clubname . '/';
                            // 画像ファイルを取得
                            $images = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                            echo'<td style="word-break: break-word">';
                            if (!empty($images)) {
                                foreach ($images as $image) {
                                    $fileName = basename($image);
                                  
                                    echo '<a style="cursor:zoom-in;" href="' . $image . '" data-lightbox="group"><img src="' . $image . '" alt="' . $fileName . '" width="100" height="65"></a>';
                                   
                                }
                            } else {
                               echo 'No image';
                            }
                            echo'</td>';
                           
                            echo '<td class="center" style="word-break: break-word">'.$row['club_name'].'</td>';
                          /*  echo '<td class="center" style="word-break: break-word">'.$row['club_town'].'</td>';*/
                            echo '<td class="center" style="word-break: break-word"><strong>'.$row['club_manager'].'</strong></td>';
                            echo '<td class="center" style="word-break: break-word"><a href="'.htmlspecialchars($row['club_url']).'">'.htmlspecialchars($row['club_url']).'</a></td>';
                            echo '<td style="word-break: break-word" width="5%">';
                            echo '</td>';

                            echo '<td class="center">';
                                echo '<form action="ClubUpdate.php" method="post">';
                                    echo '<input type="hidden" name="id" value="'.$row['club_id'].'">';
                                    echo '<button class="up" type ="submit">更新</button>';
                                echo '</form>';
                                echo '<form action="ClubDeleteFinish.php" method="post">';
                                    echo '<input type="hidden" name="club_id" value="'.$row['club_id'].'">';
                                    echo '<button onclick="'.$delete.'" class="del" type ="submit">削除</button>';
                                echo '</form>';
                        echo '</td><td></td></tr>';
                    }
                    echo '</tbody>';
                echo '</table>';
            echo '</section>';
            echo '<section class="foot">';
            echo     '<form action="ClubRegister.php" method="post">';
            echo         '<button class="register" type="submit">クラブ登録</button>';
            echo     '</form>';
            echo '</section>';
            echo '</main>';
        ?>
    </main>
</body>
</html>