<?php

//U need to set ur database data
$host_name = 'localhost' ;
$user = 'root' ;
$password = '';
$db_name = 'CHANGE HERE' ;
$conn;


try {
    $conn = new PDO('mysql:host='.$host_name.';dbname='.$db_name, $user, $password);
    
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
    }

    



        //Funcional
    function execInsertNoticia($conn, $titulo, $corpo, $publicacao, $categoria) {

        $sql = "INSERT INTO `noticias` (`id`, `titulo`, `corpo`, `publicacao`, `categoria`) VALUES (NULL,".$titulo.",".$corpo.",". $publicacao ."," .$categoria.")";  
        $conn->prepare($sql);
      
        

    }

    function verificaTitulo($conn, $titulo)
    {
        $query = "SELECT * FROM noticias WHERE titulo LIKE .$titulo.";
        $conn ->query($query);
        
    }

    /* function execInsertFrase($conn, $conteudo, $link) {

        $sql = "INSERT INTO `frases` (`id`, `conteudo`, `link`) VALUES (NULL,".$conteudo."," .$link.")";  
        $conn->prepare($sql);
        

    } */


            //START Função Delete Noticias com mais de X dias 
            function deleteNoticia( $conn, $intervalo, $metrica){
                //$intervalo valor inteiro 
                //métrica Valores Admissiveis MINUTE,HOUR,DAY         
                $sql = "DELETE FROM `noticias` WHERE publicacao < DATE_SUB(curdate(), INTERVAL ".$intervalo." ".$metrica.")";
                $conn->query($sql); 
            }

            
            function getFraseNoticia($conn){

                if (rand(0,1000)%2){
                    print_r("noticia: ". getNoticia($conn, "Desporto"));
                } else {
                    print_r("Motivação: ". getFrase($conn));
                }
             

                 

            }

    

        
            //FINISH função deleteNoticia X dias


          

            


            function getNoticia($conn, $categoria)
            {
            $sql= "SELECT titulo FROM noticias WHERE categoria LIKE '". $categoria ."' ORDER BY RAND() LIMIT 1";
            
            $query = $conn->query($sql);
           // $query->execute();

            if (!$query) {
                $resposta=  "Erro na execução do comando SQL. ";
              
            } else {
                $resposta =  $query->fetchAll(PDO::FETCH_ASSOC);
                foreach ( $query = $conn->query($sql) as $row) {
                    $resposta = $row['titulo'];
                }
            }

            //$query->fetchAll(PDO::FETCH_ASSOC);
                return $resposta;
            }

            //Get frase
            function getFrase($conn)
            {
            
            $sql = "SELECT conteudo FROM frases ORDER BY RAND() LIMIT  1";
          

            $query = $conn->query($sql);

            if (!$query) {
                $resposta =  "Erro na execução do comando SQL. ";
              
            } else {
                $resposta =  $query->fetchAll(PDO::FETCH_OBJ);
                foreach ( $query = $conn->query($sql) as $row) {
                    $resposta = $row['conteudo'];
                }
            }
            return $resposta;
            }


            
           



            function tratarData($str) {
                return date('Y-m-d H:i:s', strtotime($str));
            }

           


        
    
    

    
    

?>