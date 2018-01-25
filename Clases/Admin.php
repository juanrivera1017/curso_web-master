<?php
	class Admin{
		private $host;
		private $user;
		private $pass;
		private $db;
		//el dooble guion bajo siempre antecede construct
		public function __construct($datos){
				$this->host=$datos['host'];
				$this->user=$datos['user'];
				$this->pass=$datos['pass'];
				$this->db=$datos['db'];
		}

		function getLogin($u,$p){
				$R['estado']="OK";
				try {
						$conn= new PDO('mysql:host='.$this->host.';dbname='.$this->db,$this->user,$this->pass);
						//debug.log($conn);
						$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
						$sql=$conn->prepare("SELECT * FROM admin where usuario= :Usuario and pass= :Pass");
			
						$sql->execute(array('Usuario'=>$u,'Pass'=>$p));
						$R['filas']= $sql->rowCount();
						if($R['filas']>0){
							$R['datos']= $sql->fetchAll();
						}
						$conn=null;
				} catch (PDOException $e) {
					$R['estado']="Error".$e->getMessage();
				}
				return $R;
		}
	}

?>
