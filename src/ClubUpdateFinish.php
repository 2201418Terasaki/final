<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>クラブ更新完了画面</title>
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
                  $club = $_POST['id'];
                  $name = $_POST['name'];
                  $manager = $_POST['manager'];
                  $site = $_POST['site'];
                  $path = "./image/{$name}";
                
              
                $imageDirectory = $path.'/';
              
                $images = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
              
                
                    
                    if(!file_exists($path)){
                        mkdir("./image/{$club}", 0777);
                    }
                 
                $target_dir = $path."/";

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

                    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                        $uploadOk = 0;
                    }

                    if ($uploadOk == 1) {
                        move_uploaded_file($currentFile, $currentTarget);
                    }
                }
            
                echo '<label>更新に成功しました</label>';
       
                $sql=$pdo->prepare('update Club set club_manager = ?,club_url = ? where club_id=?');
                $sql->execute([$_POST['manager'],$_POST['site'],$_POST['id']]);
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
