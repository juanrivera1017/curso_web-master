<?php
	class Pelicula{
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

		function inserta($titulo,$sinopsis,$imagen){
				$R['estado']="OK";
				try {
						$conn= new PDO('mysql:host='.$this->host.';dbname='.$this->db,$this->user,$this->pass);
						//debug.log($conn);
						$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
						$sql=$conn->prepare("INSERT INTO peliculas(titulo,sinopsis,ruta,comentarios) VALUES(:Titulo,:Sinopsis,:Imagen,'Comentarios: ')");
						$sql->execute(array('Titulo'=>$titulo,'Sinopsis'=>$sinopsis,'Imagen'=>$imagen));
						/*
						$sql->execute(array('Titulo'=>$titulo,'Sinopsis'=>$sinopsis,'Imagen'=>$imagen));
						$R['filas']= $sql->rowCount();
						if($R['filas']>0){
							$R['datos']= $sql->fetchAll();
						} */
						$conn=null;
				} catch (PDOException $e) {
					$R['estado']="Error".$e->getMessage();
				}
				return $R;
		}

		function consulta($id){
				$R['estado']="OK";
				try {
						$conn= new PDO('mysql:host='.$this->host.';dbname='.$this->db,$this->user,$this->pass);
						//debug.log($conn);
						$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
						if($id=='0'){
								$sql=$conn->query("SELECT * FROM peliculas");
						}else{
							$sql=$conn->prepare("SELECT * FROM peliculas where id= :Id");
							$sql->execute(array('Id'=>$id));
						}

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

		function addComentario($id,$comentario){
				$R['estado']="OK";
				try {
						$conn= new PDO('mysql:host='.$this->host.';dbname='.$this->db,$this->user,$this->pass);
						//debug.log($conn);
						$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
						$sql=$conn->prepare("UPDATE peliculas SET comentarios=CONCAT(comentarios,'#',:Comentario) WHERE id=:Id");
						$sql->execute(array('Comentario'=>$comentario,'Id'=>$id));
						$conn=null;
				} catch (PDOException $e) {
					$R['estado']="Error".$e->getMessage();
				}
				return $R;
		}
	}

?>