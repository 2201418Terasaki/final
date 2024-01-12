<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プレイヤー登録完了画面</title>
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
        $club = $_POST['club'];
        $name = $_POST['name'];
        $nationality = $_POST['nationality'];
        $position = $_POST['position'];
        $path = "./image/{$club}";
        $path1 = "./image/{$club}/{$name}";

        if (!file_exists($path)) {
            mkdir("./image/{$club}", 0777);
        }

        if (!file_exists($path1)) {
            mkdir("./image/{$club}/{$name}", 0777);
        }

        $target_dir = $path1 . "/";

        // ファイルが複数アップロードされた場合の処理
        $numFiles = count($_FILES['files']['name']);
        $uploadOk = 1;

        for ($i = 0; $i < $numFiles; $i++) {
            $currentFile = $_FILES['files']['tmp_name'][$i];
            $currentTarget = $target_dir . basename($_FILES['files']['name'][$i]);

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

        if ($uploadOk == 0) {
            echo '<label>写真なしで</label>';
        } else {
            echo '<label>追加に成功しました</label>';
            // クラブ名からクラブIDを探す
            $club_id_query = $pdo->prepare('SELECT club_id FROM Club WHERE club_name = ?');
            $club_id_query->execute([$club]);
            $club_id = $club_id_query->fetchColumn();

            $sql = $pdo->prepare('INSERT INTO Player(player_name, club_id, nationality, position) VALUES (?, ?, ?, ?)');
            $sql->execute([$name, $club_id, $nationality, $position]);
        }
    ?>
    </section>
    <section class="foot">
        <form action="index.php" method="post">
            <button class="register" type="submit">選手一覧へ</button>
        </form>
    </section>
</main>
</body>
</html>
