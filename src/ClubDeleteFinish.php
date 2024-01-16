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
            $club_id = $_POST['club_id'];
            $sql = $pdo->prepare("UPDATE Club SET club_flag=0 WHERE club_id = ?");
            $sql->execute([$club_id]);

            echo '<label style="color:red;">クラブを削除しました。</label>';
        ?>
        </section>
        <section class="foot">
            <form action="Clubmanage.php" method="post">
                <button class="register" type="submit">クラブ管理へ</button>
            </form>
        </section>
    </main>
</body>
</html>
