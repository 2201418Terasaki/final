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
                $Ocategory=$_POST['oldclub'];
                $Oname=$_POST['oldname'];
                $OldPath="./image/{$Ocategory}";
                $OldPath1="./image/{$Ocategory}/{$Oname}";
                $imageDirectory = $path1.'/';
                $OldimageDirectory = 'image/' . $Ocategory . '/'.$Oname.'/';
                $images = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                $Oimages = glob($OldimageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                
                    
                    if(!file_exists($path)){
                        mkdir("./image/{$club}", 0777);
                    }
                    if(!file_exists($path1)){
                        mkdir("./image/{$club}/{$name}", 0777);
                    }
                $target_dir = $path1."/";

                // ファイルが複数アップロードされた場合の処理
                $numFiles = count($_FILES['files']['name']);
                $numOldFiles = count($Oimages);
                
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
                if($uploadOk == 1){
                    if(file_exists($OldPath1)){
                        foreach ($Oimages as $Oimage) {
                            unlink($Oimage);
                        }
                    }
                }else{
                        foreach ($Oimages as $i => $file) {
                            rename($file, $path1.'/'.pathinfo($file,PATHINFO_FILENAME).'.'.pathinfo($file,PATHINFO_EXTENSION));

                        }
                }
                echo '<label>更新に成功しました</label>';
                $club_id_query = $pdo->prepare('SELECT club_id FROM Club WHERE club_name = ?');
                $club_id_query->execute([$club]);
                $club_id = $club_id_query->fetchColumn();

                $sql=$pdo->prepare('update Player set player_name = ?,club_id = ?,nationality = ?,position=? where player_id=?');
                $sql->execute([$_POST['name'], $club_id,$_POST['nationality'],$_POST['position'],$_POST['id']]);
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
