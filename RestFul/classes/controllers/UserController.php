<?php
	
		
	class UserController{
		
		
		protected $gdb;
		
		function __construct(){
			
			
			$this->gdb = userSPDO::singleton();
       		$this->gdb->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
       		$this->gdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		}
		
		public function usuarios($request) {
        	
			if (strtolower($request->method) == 'get' && count($request->url_elements) == 1) {
            	
				
				try {

					$consulta_sql = $this->gdb->prepare("SELECT * FROM usuarios");
					$consulta_sql->execute();
					$result = $consulta_sql->fetchAll(PDO::FETCH_ASSOC);
					
					return $result;
				
				}catch(PDOException $e) {
					
					return "Error: " . $e->getMessage();
					
				}
			
        	}else if(strtolower($request->method) != 'get') {
            	
				return "Error: " . $request->method . " no permitido";
        	
			}else {
            	
				return "Error";
        	
			}
   		 }
		
		
		
		
		public function registro($request){ //Metodo para registrar un nuevo usuario en la base de datos de la aplicacion.
		
			if (strtolower($request->method) == 'post' && count($request->url_elements) == 1) {
			
				$consulta= "INSERT INTO usuarios (id_usuario,Nombre,Apellido,Usuario,Password) VALUES (?,?,?,?,?);";
			
				$consulta_sql = $this->gdb->prepare($consulta);
				
				$consulta_sql->bindParam(1,$_POST["id_usuario"]);
				$consulta_sql->bindParam(2,$_POST["Nombre"]);
				$consulta_sql->bindParam(3,$_POST["Apellido"]);
				$consulta_sql->bindParam(4,$_POST["Usuario"]);
				$consulta_sql->bindParam(5,$_POST["Password"]);
				
				$consulta_sql->execute();
				
				
				return "Has introducido un usuario!!";
			
			}else if(strtolower($request->method) != 'post') {
            
				return "Error: " . $request->method . " no permés";
        	
			}else{
            
            	return "Error: No se tienen que pasar parametros en la URL";
        	
			}
			   
		}
		
		public function actualizar($request){ //Metodo para actualizar el registro de un usuario en la base de datos de la aplicacion.
			
			if (strtolower($request->method) == 'put' && count($request->url_elements) == 5) {
			
				$id_user = $request->parameters['id_usuario'];
				$name = $request->parameters['Nombre'];
				$lastname = $request->parameters['Apellido'];
				$user = $request->parameters['Usuario'];
				$passwd = $request->parameters['Password'];
		
				$consulta= "UPDATE usuarios SET Nombre =:Nombre, Usuario =:Usuario, Password =:Password WHERE id_usuario = :id_usuario";
				
				$consulta_sql = $this->gdb->prepare($consulta);

				$consulta_sql->bindValue(":id_usuario",$id_user);
				$consulta_sql->bindValue(":Nombre",$name);
				$consulta_sql->bindValue(":Usuario",$user);
				$consulta_sql->bindValue(":Password",$passwd);
				
				$consulta_sql->execute();
				
				
				return "Se ha actualizado un usuario."; 
		
			}else if(strtolower($request->method) != 'put') {
            	
				return "Error: " . $request->method . " no permés";
        	
			}else{
            
            	return "Error: Sobran o faltan parametros";
        	}
			
		}
		
		public function login($request){ //Metodo para hacer login de un usuario en la base de datos de la aplicacion.
	
			if (strtolower($request->method) == 'post' && count($request->url_elements) == 1) {
			
				try{
					
					$consulta= "SELECT * FROM usuarios WHERE Usuario = ? AND Password = ?";
					
					$consulta_sql = $this->gdb->prepare($consulta);
					
					$consulta_sql->bindParam(1,$_POST['Usuario']);
					$consulta_sql->bindParam(2,$_POST['Password']);
					
					$consulta_sql->execute();
					
					$consulta_sql->fetch(PDO::FETCH_ASSOC);
							
					$Filas= $consulta_sql->RowCount();
				   
						if($Filas >= 1){
						
							//return true;
							return "Usuario logueado correctamente.";
							
						}else{
							
							//return false;
							return "Error de Autentificacion.";
							
						}
		
				  }catch (Exception $ex){
					  
					  print "Hay el siguiente error:".$ex->getMessage();
					  
				 }
				 
				return "Usuari logeado.";
			
			}else if(strtolower($request->method) != 'post') {
            	return $url;
				return "Error: " . $request->method . " no permitido";
        	
			}else{
            
            	return "Error: No se tienen que pasar parametros en la URL";
        	
			} 
			
		}
		
		public function borrar($request){//Metodo para borrar el registro de un usuario en la base de datos de la aplicacion.
		
			if (strtolower($request->method) == 'delete' && count($request->url_elements) == 1) {
			
				$Usuario = $request->parameters['Usuario'];
		
				$consulta= "DELETE FROM usuarios WHERE Usuario = :Usuario";
				
				$consulta_sql = $this->gdb->prepare($consulta);
				
				$consulta_sql->bindValue(":Usuario",$Usuario);
				
				$consulta_sql->execute();
				
				
				return "Has borrado un usuario.";
		
			}else if(strtolower($request->method) != 'delete') {
            	
				return "Error: " . $request->method . " no permitido";
        	
			}else{
            
            	return "Error: Solo introduce el nombre del usuario.";
        	}
			   
		}
	}
		
	   
		
		
		
		
		
	   