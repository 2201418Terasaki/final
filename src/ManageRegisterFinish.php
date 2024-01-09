<?php session_start(); ?>
<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品登録完了画面</title>
    <link rel="stylesheet" href="css/Finish.css">
    <script src="./script/Register.js"></script>
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
    <main class="wrapper">
        <section class="body">
        <?php
                $categories = array(
                    1 => '家具',
                    2 => 'ゲーム機',
                    3 => '家電',
                    4 => '靴',
                    5 => 'おもちゃ',
                    6 => 'スマートフォン',
                    7 => '服',
                    8 => '本'
                );
                $key=$_POST['category'];
                $category=$categories[$key];
                $name=$_POST['name'];
                $path="./img/{$category}";
                $path1="./img/{$category}/{$name}";
                if(!file_exists($path)){
                    mkdir("./img/{$category}", 0777);
                }
                if(!file_exists($path1)){
                    mkdir("./img/{$category}/{$name}", 0777);
                }
                $target_dir = $path1."/";

                // ファイルが複数アップロードされた場合の処理
                $numFiles = count($_FILES['files']['name']);

                for ($i = 0; $i < $numFiles; $i++) {
                    $currentFile = $_FILES['files']['tmp_name'][$i];
                    $currentTarget = $target_dir . basename($_FILES['files']['name'][$i]);

                    $uploadOk = 1;
                    $imageFileType = strtolower(pathinfo($currentTarget, PATHINFO_EXTENSION));

                    if (file_exists($currentTarget)) {
                        $uploadOk = 0;
                    }

                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "PNG") {
                        $uploadOk = 0;
                    }

                    if ($uploadOk == 1) {
                        move_uploaded_file($currentFile, $currentTarget);
                    }
                }
                if($uploadOk == 0){
                    echo '<label>写真なしで</label>';
                }
                echo '<label>追加に成功しました</label>';
                $pdo = new PDO($connect, USER, PASS);
                $sql=$pdo->prepare('insert into goods(category_id,goods_name,price,register_date,count,exp) value (?,?,?,?,?,?)');
                $sql->execute([$_POST['category'],$_POST['name'],$_POST['price'],date("Y/m/d",time()),$_POST['piece'],$_POST['explain']]);
                ?>
        </section>
        <section class="foot">
            <form action="ManageList.php" method="post">
                <button class="register" type="submit">商品一覧へ</button>
            </form>
        </section>
    </main>
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
