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

/*funciones de fecha - obtiene el día*/
function getDay($date) {
	$explode = explode("-", $date);
	return $explode[2];
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
function getPage() {
	if(isset($_GET["page"]) and is_numeric($_GET["page"])) {
		return $_GET["page"];
	} else {
		return 1;
	}
}

function slug($string) {		
	$characters = array(
		"Á" => "A", "Ç" => "c", "É" => "e", "Í" => "i", "Ñ" => "n", "Ó" => "o", "Ú" => "u", 
		"á" => "a", "ç" => "c", "é" => "e", "í" => "i", "ñ" => "n", "ó" => "o", "ú" => "u",
		"à" => "a", "è" => "e", "ì" => "i", "ò" => "o", "ù" => "u", "ã" => "a", "¿" => "", 
		"?" =>  "", "¡" =>  "", "!" =>  "", ": " => "-"
	);
	
	$string = strtr($string, $characters); 
	$string = strtolower(trim($string));
	$string = preg_replace("/[^a-z0-9-]/", "-", $string);
	$string = preg_replace("/-+/", "-", $string);

	
	if(substr($string, strlen($string) - 1, strlen($string)) === "-") {
		$string = substr($string, 0, strlen($string) - 1);
	}
	
	return $string;
}

function isSearch() {
	if(isset($_GET["buscar"])) {
		
		/*values form*/
		$where = Array();
		$query = "";
		
		if(isset($_GET["search_query"]) and $_GET["search_query"] != "") {
			$where[0] = "id_request in (select id_request from keywords2requests where id_keyword in (select id_keyword from keywords where value like '%" . clean($_GET["search_query"]) ."%')) ";
		}
		
		if(isset($_GET["search_folio"]) and $_GET["search_folio"] != "") {
			$where[1] = "folio='" . clean($_GET["search_folio"]) ."'";
		}
		
		if(isset($_GET["category"]) and $_GET["category"] != "0") {
			$where[2] = "id_category=" . clean($_GET["category"]);
		}
		
		if(isset($_GET["dependency"]) and $_GET["dependency"] != "0") {
			$where[3] = "id_dependecy=" . clean($_GET["dependency"]);
		}
		
		if(isset($_GET["organization"]) and $_GET["organization"] != "0") {
			$where[4] = "id_organization=" . clean($_GET["organization"]);
		}
		
		if(isset($_GET["year"]) and $_GET["year"] != "0") {
			$where[5] = "year(date_published)=" . clean($_GET["year"]);
		}
		
		if(count($where) > 1) {
			if(isset($where[0])) {
				$query .= "where " . $where[0];
				
				if(isset($where[1])) {
					$query .= "or " . $where[1];
				}
			} elseif(isset($where[1])) {
				$query .= "where " . $where[1];
			} else {
				foreach($where as $wher) {
					die(var_dump($wher));
				}
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}

function clean($string) {
	$string = str_replace("'", "", $string);
	$string = str_replace("\'", "", $string);
	$string = str_replace("''", "", $string);
	
	return $string;
}
