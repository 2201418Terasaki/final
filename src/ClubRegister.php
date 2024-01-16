<!DOCTYPE html>
<html lang="ja">
	<head>    
	<meta charset="UTF-8">
		<title>クラブ登録画面</title>
        <link rel="stylesheet" href="css/Register.css">
        <script src="./script/Register.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
	</head>
	<body>
    <?php
    require 'db-connect.php';
    ?>
        <div class="wrapper">
            <section class="head">
                <h3>クラブ登録</h3>
            </section>
            <form action = "ClubRegisterFinish.php" method = "post" enctype="multipart/form-data">
                <section class="body">
                    <div class="image">
                        <label>画像：</label>
                        <span id="imagePreviews" width=""></span>
                        <input type="button" id="loadFileXml" value="画像" class="imageButton" onclick="document.getElementById('fileInput').click();" />
                        <input type="file" style="display:none;" name="files[]" id="fileInput" multiple="multiple" onchange="previewImages()">
                    </div>
                    <div>
                        <label>クラブ名　　　：</label>
                        <input class="input-box-number" type="text" style="padding: 5px;" placeholder=クラブ名 required="required" name="name" maxlength="50">
                    </div>
                        
                    <div>
                    <!--<label>ホームタウン　：</label>
                <input name="hometown" class="input-box" type="text" style="padding: 5px;" placeholder="ホームタウンを入力してください" maxlength="50" required="required">
                    </div>-->
                    <div>
                        <label>監督　　　　　：</label>
                        <input name="manager" class="input-box" type="text" style="padding: 5px;" placeholder="監督名を入力してください" maxlength="50" required="required">
                    </div>
                    <div>
                        <label>公式サイト　　：</label>
                        <input name="site" class="input-box" type="text" style="padding: 5px;" placeholder="公式サイトを入力してください(任意)" maxlength="500" >
                    </div>
                </section>
                <section class="foot">
                    <button class="back" onclick="location.href='Clubmanage.php'" type="submit">戻る</button>
                    <button class="register" type="submit">登録</button>
                </section>
            </form>
        </div>
    </body>
</html>