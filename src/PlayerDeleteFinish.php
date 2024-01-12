<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>プレイヤー削除完了画面</title>
    <link rel="stylesheet" href="css/Finish.css">
</head>
<body>
    <main class="wrapper">
        <section class="body">
        <?php
            require 'db-connect.php';
            $player_id = $_POST['player_id'];
            $club_name = $_POST['club_name'];
            $player_name = $_POST['player_name'];

            $sql = $pdo->prepare("DELETE FROM Player WHERE player_id = ?");
            $sql->execute([$player_id]);

            echo '<label style="color:red;">選手を削除しました。</label>';

            $path1 = "./image/{$club_name}/{$player_name}";
            $imageDirectory = 'image/' . $club_name . '/' . $player_name . '/';

            if (file_exists($path1)) {
                // ディレクトリが存在する場合のみ画像を削除
                $images = glob($imageDirectory . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);
                foreach ($images as $image) {
                    unlink($image);
                }
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
