<!DOCTYPE html>
<html lang="ja">
	<head>
    <meta http-equiv="Cache-Control" content="no-cache">
		<meta charset="UTF-8">
		<title>商品更新画面</title>
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
                <h3>クラブ更新</h3>
            </section>
            <?php
                 echo '<input type="hidden" name="id" value="'.$_POST['id'].'">';
                $l = "location.href='Clubmanage.php'";
                $file = "fileInput";
                $sql=$pdo->prepare('select * from Club  where club_id=?');
	            $sql->execute([$_POST['id']]);
            
                foreach($sql as $row){
                    echo '<form action = "ClubUpdateFinish.php" method = "post" enctype="multipart/form-data">';
                    echo     '<input type="hidden" name="id" value="'.$row['club_id'].'">';
                    echo     '<input type="hidden" name="name" value="'.$row['club_name'].'">';
                    echo     '<section class="body">';
                    echo         '<div class="image">';
                    echo             '<label>画像：</label>';
                    $club_name=$row['club_name'];
                    $hometown=$row['club_town'];
                    $manager=$row['club_manager'];
                    $site=$row['club_url'];
                    $imageDirectory = 'image/' . $club_name . '/';
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
                    echo         '<div>';
                    echo         '<label>監督名　　：</label>';
                    echo             '<input name="manager" class="input-box" type="text"value="'.$manager.'" style="padding: 5px;" placeholder="監督名を入力してください" required="required"maxlength="50">';
                 
                    echo         '</div>';
                    echo         '<div>';
                    echo             '<label>公式サイト：</label><input name="site" value="'.$site.'" class="input-box" type="text" style="padding: 5px;" placeholder="公式サイトを入力してください"  required="required"maxlength="500">';
                    echo         '</div>';
            

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
