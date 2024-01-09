<?php session_start(); ?>
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
                location.href='ManageList.php';
            }
        </script>
	</head>
	<body>
    <?php
    require 'db-connect.php';
    if(isset($_SESSION['manager'])){
    ?>
        <header>
        <img style="user-select: none;" src="img/logo.png" class="logo" alt="" width="100" height="65">
            <nav class="logout">
                <a href="ManageLogin.php">ログアウト</a>
            </nav>
        </header>
        <div class="wrapper">
            <section class="head">
                <h2>商品更新</h2>
            </section>
            <?php
                $l = "location.href='ManageList.php'";
                $file = "fileInput";
                $s = "this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g,'$1');";
                $pdo=new PDO($connect, USER, PASS);
                $sql=$pdo->prepare('select goods. * , category_name from goods inner join categories on goods.category_id = categories.category_id where goods_id=?');
	            $sql->execute([$_POST['id']]);
                foreach($sql as $row){
                    echo '<form action = "ManageUpdateFinish.php" method = "post" enctype="multipart/form-data">';
                    echo     '<input type="hidden" name="id" value="'.$row['goods_id'].'">';
                    echo     '<input type="hidden" name="OldCategory" value="'.$row['category_id'].'">';
                    echo     '<input type="hidden" name="OldName" value="'.$row['goods_name'].'">';
                    echo     '<section class="body">';
                    echo         '<div class="image">';
                    echo             '<label>画像：</label>';
                    $category=$row['category_name'];
                    $id=$row['goods_name'];
                    $imageDirectory = 'img/' . $category . '/'.$id.'/';
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
                    echo             '<label>個数：</label><input  class="input-box-number" type="text" style="padding: 5px;" placeholder="個数" required="required" name="piece" maxlength="4" oninput="'.$s.'" value="'.$row['count'].'"/>個';
                    echo         '</div>'; 
                    echo         '<div>';
                    echo         '<label>カテゴリ：</label>';
                    echo             '<select name="category" class="input-box-option" style="padding: 5px;">';
                    echo               '<option value="'.$row['category_id'].'" selected>'.$row['category_name'].'</option>';
                                        $cate =[
                                            1 => '家具',
                                            2 => 'ゲーム機',
                                            3 => '家電',
                                            4 => '靴',
                                            5 => 'おもちゃ',
                                            6 => 'スマートフォン',
                                            7 => '服',
                                            8 => '本'
                                        ];
                                        foreach($cate as $CateId => $CateName){
                    echo               '<option value="'.$CateId.'">'.$CateName.'</option>';
                                        }
                    echo             '</select>';
                    echo         '</div>';
                    echo         '<div>';
                    echo             '<label>商品名：</label><input name="name" class="input-box" type="text" style="padding: 5px;" placeholder="商品名を入力してください" value="'.$row['goods_name'].'" required="required">';
                    echo         '</div>';
                    echo         '<div>';
                    echo             '<label>販売単価：</label><input type="text" class="input-box-number" style="padding: 5px;" placeholder="単価" required="required" name="price" maxlength="6" oninput="'.$s.'" value="'.$row['price'].'"/>円';
                    echo         '</div>';
                    echo         '<div class="explain">';
                    echo             '<label>商品説明：</label><br><textarea name="explain" class="input-box-explain" style="padding: 5px;" placeholder="商品説明を入力してください" required="required" cols="100" rows="5" name="explain" maxlength="200">'.$row['exp'].'</textarea>';
                    echo         '</div>';
                    echo     '</section>';
                    echo     '<section class="foot">';
                    echo         '<input type="button" value="戻る" class="register" onclick="'.$l.'">';
                    echo         '<button class="register" type="submit">更新</button>';
                    echo     '</section>';
                    echo '</form>';
                }
            ?>
        </div>
        <?php
    }else{
        echo '<header>';
        echo '<img style="user-select: none;" src="img/logo.png" class="logo" alt="" width="100" height="65">';
        echo '</header>';
        echo '<main class="WrapperFinish">';
        echo '<section class="BodyFinish">';
        echo    '<label style="color:red;">ログインしてください</label>';
        echo '</section>';
        echo '<section class="FootFinish">';
        echo '<form action="ManageLogin.php" method="post">';
        echo     '<input type="hidden" name="logout">';
        echo     '<button class="register" type="submit">ログイン</button>';
        echo '</form>';
        echo '</section>';
        echo '</main>';
    }
    ?>
    </body>
</html>
