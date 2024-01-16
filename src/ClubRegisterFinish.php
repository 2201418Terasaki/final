<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>クラブ登録完了画面</title>
    <link rel="stylesheet" href="css/Finish.css">
    <script src="./script/Register.js"></script>
</head>
<body>
<?php
    require 'db-connect.php';
?>
   
<main class="wrapper">
    <section class="body">
    <?php
        $name = $_POST['name'];
        $hometown = '';
        $manager = $_POST['manager'];
        $site=$_POST['site'];
        $path = "./image/{$name}";
        if (!file_exists($path)) {
            mkdir("./image/{$name}", 0777);
        }

        $target_dir = $path . "/";

        // ファイルが複数アップロードされた場合の処理
        $numFiles = count($_FILES['files']['name']);
        $uploadOk = 1;

        for ($i = 0; $i < $numFiles; $i++) {
            $currentFile = $_FILES['files']['tmp_name'][$i];
            $currentTarget = $target_dir . basename($_FILES['files']['name'][$i]);

            $imageFileType = strtolower(pathinfo($currentTarget, PATHINFO_EXTENSION));
            //ファイルが存在する
            if (file_exists($currentTarget)) {
                $uploadOk = 0;
            }
            //指定された形式ではない
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" && $imageFileType != "PNG") {
                $uploadOk = 2;
            }

            if ($uploadOk == 1) {
                move_uploaded_file($currentFile, $currentTarget);
            }
        }

        if ($uploadOk == 0) {
            echo '<label>指定された形式で登録してください</label>';
        } else {
            echo '<label>追加に成功しました</label>';
            
            $sql = $pdo->prepare('INSERT INTO Club(club_name,club_manager, club_url) VALUES ( ?, ?, ?)');
            $sql->execute([$name,$manager, $site]);
        }
    ?>
    </section>
    <section class="foot">
        <form action="Clubmanage.php" method="post">
            <button class="register" type="submit">クラブ一覧へ</button>
        </form>
    </section>
</main>
</body>
</html>
