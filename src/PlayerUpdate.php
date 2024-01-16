<?php session_start(); ?>
<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta http-equiv="Cache-Control" content="no-cache">
		<meta charset="UTF-8">
		<title>プレイヤー更新画面</title>
        <link rel="stylesheet" href="css/Update.css">
        <script src="./script/Update.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script>
            function goBack() {
                location.href='index.php';
            }
        </script>
	</head>
	<body>
    <?php
    require 'db-connect.php';
    ?>
        
        <div class="wrapper">
            <section class="head">
                <h3>選手更新</h3>
            </section>
            <?php
                 echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
                $l = "location.href='index.php'";
                $file = "fileInput";
                $sql=$pdo->prepare('select Player. * , club_name from Player inner join Club on Player.club_id = Club.club_id where player_id=?');
	            $sql->execute([$_POST['id']]);
            
                foreach($sql as $row){
                    echo '<form action = "PlayerUpdateFinish.php" method = "post" enctype="multipart/form-data">';
                    echo     '<input type="hidden" name="id" value="'.$row['player_id'].'">';
                    echo     '<input type="hidden" name="oldclub" value="'.$row['club_name'].'">';
                    echo     '<input type="hidden" name="oldname" value="'.$row['player_name'].'">';
                    echo     '<section class="body">';
                    echo         '<div class="image">';
                    echo             '<label>画像：</label>';
                    $club_name=$row['club_name'];
                    $name=$row['player_name'];
                    $nationality=$_POST['nationality'];
                    $position=$_POST['position'];
                    $imageDirectory = 'image/' . $club_name . '/'.$name.'/';
                    $images = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                    if (!empty($images)) {
                        foreach ($images as $image) {
                            $fileName = basename($image);
                        echo '<img src="' . $image . '" class="UpdatedImages" alt="' . $fileName . '" width="65" height="65">';
                        }
                    }else{
                        echo 'No images';
                    }
                    echo             '<label style="margin-left: 20px;">新しい画像：</label>';
                    echo             '<span id="imagePreviews" width=""></span>';
                    echo             '<input type="button" id="loadFileXml" value="画像" class="imageButton" onclick="document.getElementById(\'' . $file . '\').click();" />';
                    echo             '<input type="file" style="display:none;" name="files[]" id="fileInput" multiple="multiple" onchange="previewImages()">';
                    echo         '</div>';
                    echo '<div>';
                    echo '<label>選手名　　：</label>';
                    echo '<input class="input-box-number" type="text" value="'.$name.'" style="padding: 5px;" placeholder=選手名 required="required" name="name" maxlength="50">';
                    echo '</div>';
                    
                    echo         '<div>';
                    echo         '<label>クラブ名　：</label>';
                    echo             '<select name="club" class="input-box-option" style="padding: 5px;">';
                    echo               '<option value="'.$row['club_name'].'" selected>'.$row['club_name'].'</option>';
                    $sql=$pdo->query('select * from Club where club_flag=1');  
                    foreach($sql as $row){
                    echo  '<option value="'.$row['club_name'].'">'.$row['club_name'].'</option>';
                    }
                    echo             '</select>';
                    echo         '</div>';
                    echo         '<div>';
                    echo             '<label>国籍　　　：</label><input name="nationality" class="input-box" type="text"value="'.$nationality.'" style="padding: 5px;" placeholder="商品名を入力してください" value="'.$row['goods_name'].'" required="required"maxlength="50">';
                    echo         '</div>';
                    echo '<div>';
                    echo '<label>ポジション：</label>';
                    echo '<select name="position" class="input-box-option" style="padding: 5px;" required="required">';
                    echo '<option value="'.$position.'" selected>'.$position.'</option>';
                    echo '<option value="FW">FW</option>';
                    echo '<option value="MF">MF</option>';
                    echo '<option value="DF">DF</option>';
                    echo '<option value="GK">GK</option>';     
                    echo '</select>';
                    echo '</div>';

                    echo     '</section>';
                    echo     '<section class="foot">';
                    echo         '<input type="button" value="戻る" class="back" onclick="'.$l.'">';
                    echo         '<button class="register" type="submit">更新</button>';
                    echo     '</section>';
                    echo '</form>';
                }
            ?>
        </div>
    </body>
</html>
