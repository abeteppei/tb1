<?php
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

	$sql = "CREATE TABLE IF NOT EXISTS tbtest"
	." ("
	. "id INT AUTO_INCREMENT PRIMARY KEY,"
	. "name char(32),"
	. "comment TEXT,"
	. "date char(32),"
	. "password char(32)"
	." );";
	$stmt = $pdo->query($sql);
//新規投稿
if($_POST['hidden']==null&&$_POST['button1']!=null&&$_POST['name']!=null&&$_POST['str']!=null){   	
    $postDate=date("Y/m/d H:i:s");
    $name1=$_POST['name'];
    $str=$_POST['str'];
    $xxx=$_POST['xxx'];
	//データベースへの書き込み
	$sql = $pdo -> prepare("INSERT INTO tbtest (name, comment, date, password) VALUES (:name, :comment, :date, :password)");
	$sql -> bindParam(':name', $name, PDO::PARAM_STR);
	$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $sql -> bindParam(':password', $password, PDO::PARAM_STR);
	$name = $name1;
	$comment = $str; 
	$date = $postDate;
	$password = $xxx;
	$sql -> execute();
	}
//編集番号
if($_POST['button2']!=null&&$_POST['editnum']!=null){
    $xxx=$_POST['xxx'];
    $id=$_POST['editnum'];
    
    $sql = 'SELECT * FROM tbtest WHERE id='.$id;
    $stmt = $pdo->prepare($sql);                  
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); 
    $stmt->execute();                             
    $results = $stmt->fetchAll(); 
    
	foreach($results as $row){
	   if($row['password']!=$xxx){
	       echo "パスワードが違います<br>";
	}else{
	    $ename=$row['name'];
	    $estr=$row['comment'];
	    $hidden=$id;
	}
}}
//編集
if($_POST['hidden']!=null&&$_POST['button1']!=null&&$_POST['name']!=null&&$_POST['str']!=null){
    
    $id = $_POST['hidden']; 
	$name = $_POST['name'];
	$comment = $_POST['str']; 
	$sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':name', $name, PDO::PARAM_STR);
	$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
}
//削除
if($_POST['button3']!=null&&$_POST['delete']!=null){
    $deleteNum=$_POST['delete'];
    $xxx=$_POST['xxx'];
    
$sql = 'SELECT * FROM tbtest WHERE id='.$deleteNum;
    $stmt = $pdo->prepare($sql);                  
    $stmt->bindParam(':id', $deleteNum, PDO::PARAM_INT); 
    $stmt->execute();                             
    $results = $stmt->fetchAll(); 
    
    foreach($results as $row){
        if($row['password']!=$xxx){
            echo "パスワードが違います<br>";
        }else{
            $sql = 'delete from tbtest where id=:id';
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':id', $deleteNum, PDO::PARAM_INT);
	        $stmt->execute();
            $results = $stmt->fetchAll(); 
        }
    }
}
//データベースの表示
$sql = 'SELECT * FROM tbtest';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
	
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].',';
	echo $row['date'].'<br>';
	echo "<hr>";
	    
	}
	
	if($_POST['omg']!=null&&$_POST['xxx']==999999999){
	    $sql = 'DROP TABLE tbtest';
		$stmt = $pdo->query($sql);
	}elseif($_POST['omg']!=null){
	    echo "パスワードが違います<br>";
	}
?>
<form action="" method="post">
    password:<input type="ste" name="xxx"><br>
    name:<input type="str" name="name" value="<?php echo $ename ?>">
    comment:<input type="str" name="str" value="<?php echo $estr ?>">
    <input type="submit" value="送信" name="button1"><br>
    <input type="hidden" value="<?php echo $hidden ?>" name="hidden"><br>
    edit:<input type="number" name="editnum">
    <input type="submit" value="編集" name="button2"><br>
    delete:<input type="number" name="delete">
    <input type="submit" value="削除" name="button3">  <input type="submit" name="omg" value="テーブル削除">
</form>
