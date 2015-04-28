    <?php
    
	class userSPDO extends PDO{

        private static $instance=null;

		 CONST driver ='mysql:host=localhost;dbname=2daw16_restful_alejandro';
		 CONST user='2daw16_root';
		 CONST password='123456';
         
		 public function __construct(){          
		 
		 try{
			 
			parent::__construct(self::driver,self::user,self::password);
			
		 }catch(PDOException $e){
			 
		 	echo 'Connexion Erronea: ' . $e->getMessage();}
		
		}

        static function singleton(){
			
            if(self::$instance == null){
				
                self::$instance = new self();
				
            }
			
            return self::$instance;
        }
    }
    
