<?php
function getArray($text, $pos = NULL) {
	$text = ltrim($text, "{");
	$text = rtrim($text, "}");
	$data = explode(",", $text);

	if($pos !== NULL) {
		return $data[$pos];
	} else {
		return $data;
	}
}

function getTotalArray($text) {
	$text = ltrim($text, "{");
	$text = rtrim($text, "}");
	$data = explode(",", $text);
	
	return count($data);
}

function getRoute($pos = false) {
	
	$route = explode("/", substr($_SERVER["REQUEST_URI"], 1));
	
	if($pos) {
		if(isset($route[$pos])) {
			return $route[$pos];
		} else {
			return false;
		}
	}
	
	return $route;
}

function getSlug() {
	if(isset($_GET["slug"])) {
		return $_GET["slug"];
	} else {
		return false;
	}
}

function getURL(){
	$url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	return $url;
}

/*funciones de fecha - obtiene el año*/
function getYear($date) {
	$explode = explode("-", $date);
	return $explode[0];
}

/*funciones de fecha - obtiene el mes*/
function getMonth($date) {
	$explode = explode("-", $date);
	return $explode[1];
}

/*obtiene los limites offset de la pagina*/
function getOffset($limit) {
	if(isset($_GET["page"]) and is_numeric($_GET["page"])) {
		return $_GET["page"] * $limit - $limit;
	} else {
		return 0;
	}
}

/*obtiene el numero de paginas totales*/
function getPages($limit, $count) {
	return round($count/$limit);
}

/*obtiene la pgina actual*/
public function getPage() {
	if(isset($_GET["page"]) and is_numeric($_GET["page"])) {
		return $_GET["page"];
	} else {
		return 1;
	}
}
