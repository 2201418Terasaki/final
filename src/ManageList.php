<!DOCTYPE html>
<html lang="ja  ">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品一覧</title>
    <link rel="stylesheet" href="css/List.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js" type="text/javascript"></script>
</head>
<body>
    <?php
    require 'db-connect.php';
    
                echo '<header>';
                echo '<img style="user-select: none;" src="img/logo.png" class="logo" alt="" width="100" height="65">';
                echo '</header>';

                echo '<main class="wrapper">';
                echo    '<section class="head">';
                echo        '<h1>選手一覧</h1>';
                echo    '</section>';
                echo    '<section class="body">';
                
                $delete = "return confirm('削除しますか？')";
                echo '<table><thead><tr><th width="8%">選手ID</th><th  width="18%">選手名</th><th  width="10%">国籍</th><th  width="7%">ポジション</th><th  width="5%">在庫</th><th width="20%">商品画像</th><th width="20%">商品説明</th><th  width="10%">動作</th></tr></thead>';
                    echo '<tbody>';
                    foreach ($pdo->query('SELECT goods. * , category_name FROM goods INNER JOIN categories ON goods.category_id = categories.category_id') as $row) {
                        echo '<tr>';
                            $category=$row['category_name'];
                            $id=$row['goods_name'];
                            $path="./img/{$category}";
                            $path1="./img/{$category}/{$id}";
                            if(!file_exists($path)){
                                mkdir("./img/{$category}", 0777);
                            }
                            if(!file_exists($path1)){
                                mkdir("./img/{$category}/{$id}", 0777);
                            }
                            echo '<td class="center"  style="word-break: break-word">'.$row['goods_id'].'</td>';
                            echo '<td style="word-break: break-word">'.$row['goods_name'].'</td>';
                            echo '<td style="word-break: break-word">'.$row['category_name'].'</td>';
                            echo '<td style="word-break: break-word"><strong>'.$row['price'].'</strong></td>';
                            echo '<td class="center" style="word-break: break-word">'.$row['count'].'</td>';
                            echo '<td style="word-break: break-word">';
                            $imageDirectory = 'img/' . $category . '/'.$id.'/';
                        
                            // 画像ファイルを取得
                            $images = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                        
                            if (!empty($images)) {
                                foreach ($images as $image) {
                                    $fileName = basename($image);
                                    echo '<a style="cursor:zoom-in;" href="' . $image . '" data-lightbox="group"><img src="' . $image . '" alt="' . $fileName . '" width="65" height="65"></a>';
                                }
                            } else {
                                echo 'No images';
                            }
                            echo '</td>';
                            echo '<td style="word-break: break-word">'.$row['exp'].'</td>';
                            echo '<td class="center">';
                                echo '<form action="ManageUpdate.php" method="post">';
                                    echo '<input type="hidden" name="id" value="'.$row['goods_id'].'">';
                                    echo '<button class="up" type ="submit">更新</button>';
                                echo '</form>';
                                echo '<form action="ManageDeleteFinish.php" method="post">';
                                    echo '<input type="hidden" name="delcategory" value="'.$row['category_name'].'">';
                                    echo '<input type="hidden" name="delname" value="'.$row['goods_name'].'">';
                                    echo '<input type="hidden" name="delid" value="'.$row['goods_id'].'">';
                                    echo '<button onclick="'.$delete.'" class="del" type ="submit">削除</button>';
                                echo '</form>';
                        echo '</td></tr>';
                    }
                    echo '</tbody>';
                echo '</table>';
            echo '</section>';
            echo '<section class="foot">';
            echo     '<form action="ManageRegister.php" method="post">';
            echo         '<button class="register" type="submit">登録</button>';
            echo     '</form>';
            echo '</section>';
            echo '</main>';
        ?>
    </main>
</body>
</html>