<?php
//вывод ошибок
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
 
define('DB_HOST',           'localhost');
define('DB_NAME',           'rutira_db');
define('DB_USER',           'admin');
define('DB_PASS',           '09141964');
$db_link = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$res = mysqli_query($db_link, 'SELECT * FROM menu');
if ($res === false) { echo "mysqli_query. An error occurred."; }

$rows = array();
//переменные базы в массив
while ($row = mysqli_fetch_assoc($res)) { 
	$rows[$row['id_parent']][] = $row; //echo  $row['title']." - ".$row['id']." - ".$row['id_parent'].'<br/>';
}

//получить иерархию
$start = microtime(true);
get_childs(0, $rows);
echo '<br/>' . (microtime(true) - $start);

function get_childs($parent, &$rows){
	if (isset($rows[$parent]))	{return false;}
	echo '<ul>';
	foreach($rows[$parent] AS $row) {
		echo $row['title'];
		$str = "<a href=".$row['url'].">".$row['title']."</a>";
		echo $str;
		
		echo '<li>';
		echo $row['url']." - ".$row['title'];
		
		/* $str = "<a href=".$row['url'].">".$row['title']."</a>"; 
		if (isset($row['url'])) 
			{ 
			$str = "<a href=".$row['url'].">".$row['title']."</a>"; 
			}
		else
			{
			$str=$row['title'];
			}; 
		echo $str; //$row['title']; */
		
		get_childs($row['id'], $rows);
		echo '</li>';
	}
	echo '</ul>';
}

?> 


<?php
/*
class Url_nav // класс для создания навигации
{
 var $link_and_text_list; // массив ссылок 
 var $delitmer; //разделитель ссылок 
 
// добавление элемента 
function add_item($title, $s_url)
{
 $n=sizeof($this->link_and_text_list);
 $this->link_and_text_list[$n]['title']=trim($title);
 $this->link_and_text_list[$n]['url']=trim($s_url);
}
 
// создание навигации из спец. массива 
function nav_create()
{
 $links_arr=$this->link_and_text_list;
 $str = "";
 $c=sizeof($links_arr);
 for ($i=0; $i<$c; $i++)
 {
 if (!$links_arr[$i]['url'])
 {
 $str .= $links_arr[$i]['title'];
 } else {
 $str .= "<a href=".$links_arr[$i]['url']." target="._self.">".$links_arr[$i]['title']."</a>";
 $str .= "<a href=".$links_arr[$i]['url']." target="._self.">".$links_arr[$i]['title']."</a>";
 }
 if ($i<$c-1)
 {
 $str .= $this->delitmer;
 }
 }
return $str;
echo $str;

}

// создание заголовка 
function title_create(){
 $links_arr = array_reverse($this->link_and_text_list);
 $str = "";
 $c = sizeof($links_arr);
 for ($i=0; $i<$c; $i++){
 $str .= $links_arr[$i]['title'];
	if ($i<$c-1){
		 $str .= $this->delitmer;
	}
 }
return "<title>".$str."</title>";
}
}

// Пример использования 
$nav = new Url_nav(); // создание нового экземпляра класса
$nav -> delitmer = " < "; // установка разделителя
$nav -> add_item("items 1", "?b=1"); // добавление элементов
$nav -> add_item("items 2", "?b=2");
$nav -> add_item("items 3", "?b=3");
$nav -> add_item("items 4", "?b=4");
$nav -> add_item("items 5", "");
echo $nav-> title_create(); // создание и вывод заголовка
$nav -> delitmer = " > "; // изменение разделителя
echo $nav -> nav_create(); // создание и вывод панели навигации со ссылками
*/
?> 
