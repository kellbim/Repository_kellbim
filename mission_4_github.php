<HTML>
<head>
<meta charset="UTF-8"/>
</head>
<title>ご意見板</title>
<body>
コメントしていってね。</br>
<?php
#<!--まずはデータベースへの接続を行う-->
$dsn = 'データベース名';
//databasename
$user=? 'ユーザー名';
//ユーザー名
$password='パスワード';
//パスワード

$pdo = new PDO($dsn,$user,$password);
//PDO=命令
$sql = "CREATE TABLE table3"
//新しくテーブルを作る
."("
."id INT AUTO_INCREMENT PRIMARY KEY," //INT:数値型（そのフィールドには数値しか入力できない）フィールド名,データの型の順番
//PRIMARY KEYは必ず指定しよう
."name char(32)," //char:文字列型（そのフィールドには文字列しか入力できない）
."comment TEXT," //TEXT:テキスト型（そのフィールドにはテキストしか入力できない）
."hizuke char(32),"
."pass TEXT"
.");";

$stmt = $pdo->query($sql);

$edit = $_POST["edit"];
$pass3 = $_POST["pass3"];

 
if(isset($_POST["button3"])){
	if(preg_match("/^[0-9]+$/",$edit)){
	$sql2 ='SELECT*FROM table3';
	$results = $pdo -> query($sql2);
		foreach($results as $row){
 			if($row['id'] == $edit and $row['pass'] == $pass3){
				$simedit[0] =$row['id'];
				$simedit[1] =$row['name'];					
				$simedit[2] =$row['comment'];
			}elseif($row['id'] == $edit and $row['pass'] != $pass3){
				echo "パスワードが違います。";
			}else{
			}
		}
	}else{
	}
}
?>
<form action="mission_4.php" method="POST">
お名前    <input type="text" name="name"  value="<?php echo $simedit[1]; ?>" placeholder="名無し"/></br>
メッセージ<input type="text" name="comment" value="<?php echo $simedit[2]; ?>" placeholder="コメント"/></br>
パスワード<input type="text" name="pass1" placeholder="パスワード"/>
<input type="hidden" name="hidden" value="<?php echo $simedit[0]; ?>" />
 <input type="submit" name="button1"  value="送信"/></br>
</form>
<form action="mission_4.php" method="POST">
削除      <input type="text" name="delete" placeholder="削除対象番号" />
<input type="text" name="pass2" placeholder="パスワード"/>
<input type="submit" name="button2" value="削除"/>
</form>
<form action="mission_4.php" method="POST">
編集	　<input type="text" name="edit" placeholder="編集対象番号"/>
<input type="text" name="pass3" placeholder="パスワード"/>
<input type="submit" name="button3" value="編集"/>
</form>
<?php
 $comment = $_POST["comment"];
 $name = $_POST["name"];
 $date = date('Y年m月d日　H時i分s秒');
 $delete = $_POST["delete"];
 $edit = $_POST["edit"];
 $hidden = $_POST["hidden"];
 $pass1 = $_POST["pass1"];
 $pass2 = $_POST["pass2"];
 $pass3 = $_POST["pass3"];

if(isset($_POST["button1"])){
 	if ($hidden == ""){	
		if ($comment ==""or $name ==""or $pass1 =="") {

 			echo "</br></br></br></br>";
		
 		}elseif($comment=="完成！" and $name!=NULL and $pass1!=NULL) {


 			echo $name."さんおめでとう！</br></br></br>";
			$sql = $pdo->prepare("INSERT INTO table3 (name,comment,hizuke,pass) VALUES(:name,:comment,:hizuke,:pass)");
			$sql -> bindParam(':name',$name,PDO::PARAM_STR);
			$sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
			$sql -> bindParam(':hizuke',$date,PDO::PARAM_STR);
			$sql -> bindParam(':pass',$pass1,PDO::PARAM_STR);

			$sql->execute();

		}else{
 
			echo $name."さん、ご入力ありがとうございます。</br>".$date."に".$comment."を受け付けました。</br></br>";
			//ここでSQLを準備する。prepareでテーブル名（name,comment）のそれぞれに対して:name と :comment というパラメータを与えている。(idは勝手に指定されている)
			$sql = $pdo->prepare("INSERT INTO table3 (name,comment,hizuke,pass) VALUES(:name,:comment,:hizuke,:pass)");
			$sql -> bindParam(':name',$name,PDO::PARAM_STR);
			$sql -> bindParam(':comment',$comment,PDO::PARAM_STR);
			$sql -> bindParam(':hizuke',$date,PDO::PARAM_STR);
			$sql -> bindParam(':pass',$pass1,PDO::PARAM_STR);
		
			$sql->execute();
		}
	}else{
	echo $hidden."番を編集しました。</br></br></br>";
		$id =$hidden;
		$nm =$name;
		$kome =$comment;
		$sql ="update table3 set name='$nm',comment='$kome' where id =$id";
		$result =$pdo->query($sql);
	}
}elseif(isset($_POST["button2"])){
	if(preg_match("/^[0-9]+$/",$delete)){
	$sql2 ='SELECT*FROM table3';
	$results = $pdo -> query($sql2);
		foreach($results as $row){
 			if($row['id'] == $delete and $row['pass'] == $pass2){
				echo $delete."番を削除しました。</br></br></br>";
				$id = $delete;		
				$sql="delete from table3 where id =$id";
				$result = $pdo->query($sql);
			}else{}
		}
	}else{
	}
}

$sql2 ='SELECT*FROM table3';
$results = $pdo -> query($sql2);
foreach($results as $row){
//$rowの中にはテーブルのカラム名が入る。
echo $row['id'].' ';
echo $row['name'].' ';
echo $row['comment'].' ';
echo $row['hizuke'].'<br>';
}
?> 
</body>
</HTML>
