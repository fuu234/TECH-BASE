<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
</head>
<body>

<?php

//データベースへ接続
$dsn='データベース名';
$user='ユーザー名';
$password='パスワード';
$pdo=new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

//テーブル作成
$sql="CREATE TABLE IF NOT EXISTS tbtest4"
."("
."id INT AUTO_INCREMENT PRIMARY KEY,"
."name char(32),"
."comment TEXT,"
."date DATETIME,"
."pass char(32)"
.");";
$stmt=$pdo->query($sql);

//新規投稿
if(!empty($_POST["name"]) and !empty($_POST["comment"]) and !empty($_POST["pass"]) and empty($_POST["number"])){
  $sql = $pdo -> prepare("INSERT INTO tbtest4 (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
  $sql -> bindParam(':name', $name, PDO::PARAM_STR);
  $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
  $sql -> bindParam(':date', $date, PDO::PARAM_STR);
  $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);

  $name=$_POST["name"];
  $comment=$_POST["comment"];
  $date=date("Y/m/d H:i:s");
  $pass=$_POST["pass"];
  $sql -> execute();
}

//削除
if(!empty($_POST["send_delete"]) and !empty($_POST["delete"]) and !empty($_POST["delete_pass"])){
//pass確認
  $sql = 'SELECT * FROM tbtest4';
  $stmt = $pdo->query($sql);
  $results = $stmt->fetchAll();
  foreach ($results as $row){
    if($row['id']==$_POST["delete"]){
      if($row['pass']==$_POST["delete_pass"]){

        $id=$_POST["delete"];
        $sql='delete from tbtest4 where id=:id';
        $stmt=$pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      }
    }
  }
}

//編集選択
if(!empty($_POST["send_hensyu"]) and !empty($_POST["hensyu"]) and !empty($_POST["hensyu_pass"])){
//pass確認
  $sql = 'SELECT * FROM tbtest4';
  $stmt = $pdo->query($sql);
  $results = $stmt->fetchAll();
  foreach ($results as $row){
    if($row['id']==$_POST["hensyu"]){
      if($row['pass']==$_POST["hensyu_pass"]){

        $hensyu_element_name=$row['name'];
        $hensyu_element_come=$row['comment'];
        $hensyu_element_pass=$row['pass'];
      }
    }
  }
}

//編集実行
if(!empty($_POST["number"])){
//pass確認
  $sql = 'SELECT * FROM tbtest4';
  $stmt = $pdo->query($sql);
  $results = $stmt->fetchAll();
  foreach ($results as $row){
    if($row['id']==$_POST["number"]){
      if($row['pass']==$_POST["pass"]){

	$id =$_POST["number"];
	$name =$_POST["name"];
	$comment =$_POST["comment"];
	$date =date("Y/m/d H:i:s");
	$pass =$_POST["pass"];
	$sql = 'update tbtest4 set name=:name,comment=:comment,date=:date,pass=:pass where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':date', $date, PDO::PARAM_STR);
	$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
      }
    }
  }
}

?>


<form action="5-1.php" method="post">

  <p>【 投稿フォーム 】</p>
  <p>名前:　　　　
     <input type="text" name="name" value="<?php
            if(!empty($_POST["hensyu"]) and !empty($_POST["hensyu_pass"])){
              if($row['pass']==$_POST["hensyu_pass"]){
                echo $hensyu_element_name;
              } else{
              }
            }

            ?>" size="25"></p>

  <p>コメント:　　
     <input type="text" name="comment" value="<?php
            if(!empty($_POST["hensyu"]) and !empty($_POST["hensyu_pass"])){
              if($row['pass']==$_POST["hensyu_pass"]){
                echo $hensyu_element_come;
              } else{
              }
            }

            ?>" size="25"><br>

     <input type="hidden" name="number" value="<?php
            if(!empty($_POST["hensyu"]) and !empty($_POST["hensyu_pass"])){
              if($row['pass']==$_POST["hensyu_pass"]){
                echo $_POST["hensyu"];
              } else{
              }
            }

                                             ?>" >
  <p>パスワード:　
     <input type="text" name="pass" value="<?php
            if(!empty($_POST["hensyu"]) and !empty($_POST["hensyu_pass"])){
              if($row['pass']==$_POST["hensyu_pass"]){
                echo $hensyu_element_pass;
              } else{
              }
            }

            ?>" size="25"></p>

     <input type="submit" name="send" value="送信">

</form>

<form action="5-1.php" method="post">

  <p>【 削除フォーム 】</p>
  <p>投稿番号:　　
     <input type="text" name="delete" value="" size="25"></p>
  <p>パスワード:　
     <input type="text" name="delete_pass" size="25"></p>
     <input type="submit" name="send_delete" value="削除">

</form>

<form action="5-1.php" method="post">

  <p>【 編集フォーム 】</p>
  <p>投稿番号:　　
     <input type="text" name="hensyu" value="" size="25"></p>
  <p>パスワード:　
     <input type="text" name="hensyu_pass" size="25"></p>
     <input type="submit" name="send_hensyu" value="編集">

</form>

<?php

//出力
$sql = 'SELECT * FROM tbtest4';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
  //$rowの中にはテーブルのカラム名が入る
  echo $row['id'].',';
  echo $row['name'].',';
  echo $row['comment'].',';
  echo $row['date'].'<br>';
}

?>

</body>
</html>