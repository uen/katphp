<?php
// https://github.com/vrondakis/katphp
class DB{
	static $db = null;
	
	static function Connect($str, $username, $password){
		$options = [
			PDO::ATTR_PERSISTENT => false
		];
		
		try{
			DB::$db = @new PDO($str, $username, $password, $options);
			DB::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION ); // For debugging
			
		}
		catch(exception $e){
			die($e->getMessage());
			return false;
		}

		return true;
	}

	static function IsAlive(){
		if(!DB::$db){
			die('Database connection died; Contact Support.');
			exit();
		}
	}

	static function Query($str, $a = null){
		DB::IsAlive();
		$stat = DB::$db->prepare($str);
		if(!$stat){
			die(DB::$db->errorInfo());
		}	

		if(!$stat->execute($a)){
			die($stat->errorInfo());
		}

		$result = $stat->fetchAll(PDO::FETCH_ASSOC);

		return $result;
	}
	
	static function Insert($t, $a){
		$ka = [];
		$va = [];
		$values = [];
	
		foreach($a as $k=>$v){
			$ka[] = $k;
			$va[] = ':'.$k;
			$values[':'.$k] = $v;
		}

		$q = "INSERT INTO ".$t." (".implode( ',', $ka ).") VALUES(".implode(',', $va).")";
		$st = DB::$db->prepare($q);
		$st->execute($a);

		return DB::$db->lastInsertId();
	}
	
	static function QueryRow($str, $a=null){ 
		$result = DB::Query($str,$a);	
		if($result){
			return reset($result);
		} 
	}

	static function QueryValue($str, $a=null){
		$result = DB::QueryRow($str,$a);
		if($result){
			$resa = reset($result);
			if($resa){
				return $resa;
			}
		}	
	}
	static function QueryDelete($str, $a = null){
		DB::IsAlive();
		$stat = DB::$db->prepare($str);
		if(!$stat){
			die(DB::$db->errorInfo());
		}	
		if(!$stat->execute($a)){
			die($stat->errorInfo());
		}
		
		return true;
	}
}

