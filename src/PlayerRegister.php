<!DOCTYPE html>
<html lang="ja">
	<head>    
	<meta charset="UTF-8">
		<title>プレイヤー登録画面</title>
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
                <h3>選手登録</h3>
            </section>
            <form action = "PlayerRegisterFinish.php" method = "post" enctype="multipart/form-data">
                <section class="body">
                    <div class="image">
                        <label>画像：</label>
                        <span id="imagePreviews" width=""></span>
                        <input type="button" id="loadFileXml" value="画像" class="imageButton" onclick="document.getElementById('fileInput').click();" />
                        <input type="file" style="display:none;" name="files[]" id="fileInput" multiple="multiple" onchange="previewImages()">
                    </div>
                    <div>
                        <label>選手名　　：</label>
                        <input class="input-box-number" type="text" style="padding: 5px;" placeholder=選手名 required="required" name="name" maxlength="50">
                    </div>
                        
                    <div>
                    <label>クラブ名　：</label>
                        <select name="club" class="input-box-option" style="padding: 5px;" required="required">
                          <option value="マンチェスターシティ" selected>マンチェスターシティ</option>
                          <?php
                          $sql=$pdo->query('select * from Club where club_flag=1');
                          
                        foreach($sql as $row){
                            echo  '<option value="'.$row['club_name'].'">'.$row['club_name'].'</option>';
                        }
                          ?>
                        </select>
                    </div>
                    <div>
                        <label>国籍　　　：</label>
                        <input name="nationality" class="input-box" type="text" style="padding: 5px;" placeholder="国籍を入力してください" maxlength="50" required="required">
                    </div>
                    <div>
                        <label>ポジション：</label>
                        <select name="position" class="input-box-option" style="padding: 5px;" required="required">
                          <option selected value="">選んでください</option>
                          <option value="FW">FW</option>
                          <option value="MF">MF</option>
                          <option value="DF">DF</option>
                          <option value="GK">GK</option>
                         </select>
                    </div>
                </section>
                <section class="foot">
                    <button class="back" onclick="location.href='index.php'" type="submit">戻る</button>
                    <button class="register" type="submit">登録</button>
                </section>
            </form>
        </div>
    </body>
</html>