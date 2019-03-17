<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta charset="utf-8">
		<link rel="stylesheet" media="screen" type="text/css" href="/css/style.css" />
		<link rel="stylesheet" type="text/css" href="/css/css_f.css" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ulogin.ru/js/ulogin.js"></script>
    
	<title>rutira.ru Главная</title>
</head>
<body>
<h1> <a href="https://www.rutira.ru"> Главная страница </a></h1>
<!-- <p> https://www.rutira.ru </p> -->
<?php
// Ошибки обработки  - отображать
ini_set('display_errors',1);
error_reporting(E_ALL);
// Если авторизация браузера производилась - открываем сессию
	if (isset($_REQUEST[session_name()])) session_start();
// Если в форму ввели email
	$login = isset($_POST['login']) ? $_POST['login'] : '';

$client_id = '775379640375-64p1ofk80ei8k0v764dh8rflbni4os7c.apps.googleusercontent.com'; // Client ID
$client_secret = 'UtIzNnLHgHG0MKgTck9OsGj1'; // Client secret
$redirect_uri = 'https://rutira.ru'; // Redirect URI
$url = 'https://accounts.google.com/o/oauth2/auth';



// Авторизация --------------------------------------------------------------------------------------
$params = array(
    'redirect_uri'  => $redirect_uri,
    'response_type' => 'code',
    'client_id'     => $client_id,
    'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
);
// Авторизация  -ссылка
	//echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Авторизация Google</a></p>';
	echo '<p>Войти</p>';
	echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '"> <img src="img/img_google_128.png"  width="32" height="32" alt="Войти с аккаунтом Google"> </a></p>';
	
	
if (isset($_GET['code'])) {
    $result = false;
    $params = array(
        'client_id'     => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri'  => $redirect_uri,
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code']
	
	);
	//echo '<p>'.$_GET['code'].'</p>';
	
    $url = 'https://accounts.google.com/o/oauth2/token';
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($curl);
    curl_close($curl);
    $tokenInfo = json_decode($result, true);

    if (isset($tokenInfo['access_token'])) {
        $params['access_token'] = $tokenInfo['access_token'];
        $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);
        if (isset($userInfo['id'])) {
            $userInfo = $userInfo;
            $result = true;
        }
		
		
		if ($result) {
			$_SESSION['user'] = $userInfo;
			$uid = $userInfo['id'];
			$provider = $userInfo['link'];
			$name = $userInfo['name'];
			$email=$userInfo['email'];

			echo "Пользователь авторизован" . '<br />';
			echo "Имя: " . $name . '<br />';
			echo "Email: " . $email . '<br />';
			echo '<img src="' . $userInfo['picture'] . '"  width="32" height="32" />'; echo "<br />";
			//echo "Социальный ID пользователя: " . $userInfo['id'] . '<br />';
			//echo "UserName: " . $userInfo['name'] . '<br />';
			//echo "Email: " . $userInfo['email'] . '<br />';
			//echo "Ссылка на профиль пользователя: " . $userInfo['link'] . '<br />';
			//echo "Пол пользователя: " . $userInfo['gender'] . '<br />';
			//echo '<img src="' . $userInfo['picture'] . '" />'; echo "<br />";
			
			$login = $email;
			$password = md5(md5(trim($email)));
			
			//!подключение к базе данных 1
			$sql_link=mysqli_connect("localhost", "admin", "09141964", "rutira_db");
			$sql =  "SELECT id FROM users WHERE name='".mysqli_real_escape_string($sql_link, $login )."'";
			$query = mysqli_query($sql_link,$sql);
			
				// проверяем, не сущестует ли пользователя с таким именем
				if(mysqli_num_rows($query) > 0){
						echo "Пользователь с таким логином уже существует в базе данных". '<br />';
						// //!если пользователь уже существует то присваиваем ему информацию из базы
						// $user_row = mysql_fetch_assoc($result);
						// session_start();
						// $_SESSION['id'] = $user_row['id'];
						// $_SESSION['provider'] = $user_row['provider'];
						// $_SESSION['uid'] = $user_row['uid'];
						// $_SESSION['name'] = $user_row['name'];
					}
					else {
						echo "Сохранение данных пользователя.". '<br />';
						$sql = 'INSERT INTO users (uid, provider, name, email, pwd) VALUES ("'.$uid.'", "'.$provider.'", "'.$name.'",  "'.$email.'",  "'.$password.'")';
						mysqli_query($sql_link,$sql);
						// session_start();
						// //!если такого пользователя нету в базе данных заносим информацию в базу
						// $user_id = mysql_insert_id();
						// $_SESSION['id'] = $user_id;
						// $_SESSION['provider'] = $provider;
						// $_SESSION['uid'] = $uid;
						// $_SESSION['name'] = $name;
						
						//header("Location: index.php"); exit();
					};	
				
				// //!подключение к базе данных 2
				// //$db = mysql_pconnect('localhost', 'admin', '09141964', 128);
				// //mysql_select_db('rutira_db');
				// if($uid){
					// $sql = 'SELECT * FROM users WHERE uid = "'.$uid.'"';
					// $result = mysql_query($sql);
					// session_start();
					// //!если такого пользователя нету в базе данных заносим информацию в базу
						// if((mysql_num_rows($result)) == 0){
							// //echo "Социальный ID пользователя: " . $userInfo['id'] . '<br />';
							// $sql = 'INSERT INTO users (uid, provider, name, email) VALUES ("'.$uid.'", "'.$provider.'", "'.$name.'",  "'.$email.'")';
							// mysql_query($sql);
							// $user_id = mysql_insert_id();
							// $_SESSION['id'] = $user_id;
							// $_SESSION['provider'] = $provider;
							// $_SESSION['uid'] = $uid;
							// $_SESSION['name'] = $name;
						// }
						// //!если пользователь уже существует то присваиваем ему информацию из базы
						// else{
							// $user_row = mysql_fetch_assoc($result);
							// session_start();
							// $_SESSION['id'] = $user_row['id'];
							// $_SESSION['provider'] = $user_row['provider'];
							// $_SESSION['uid'] = $user_row['uid'];
							// $_SESSION['name'] = $user_row['name'];
						// }
						// //!редирект на главную страницу
						// Header('Location: /');
					// }
			
			
		}
    }
}
// Данные пользователя в форме
	if (isset($_POST['name'])) {
		$name = $_POST['name'];
		}
		else {
		$name = '';
		}
?>


<form action="<?=$_SERVER['PHP_SELF']?>">
E-mail: <input name="login" type="text"  value="<?=isset($_POST['login']) ? $login : ''?>" alt="Submit" width="328" height="14" required><br>
<!--E-mail: <input name="login" type="text"  value="<?=$login?>" alt="Submit" width="328" height="14" required><br> -->
<!-- Не прикреплять к IP <input type="checkbox" name="not_attach_ip"><br> -->
<input name="submit" type="submit" value="OK">
</form>

<!--
<form method="POST">
Пользователь: <input name="login" type="text" required><br>
Пароль: <input name="password" type="password" required><br>
Не прикреплять к IP(не безопасно) <input type="checkbox" name="not_attach_ip"><br>
<input name="submit" type="submit" value="OK">
</form>
-->

</body>
</html>
		
