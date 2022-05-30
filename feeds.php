
<!-- <meta http-equiv="refresh" content="10" > AUTO_REFRESH -->
<link rel="stylesheet" href="css/styles.css">
<input class="col text-center btn btn-dark " type="button" value="ForçarReload" onClick="document.location.reload(true)"> <!-- Botao Refresh -->


<?php

require_once 'config.php';


/* RSS Feeds a consumir BEGIN */

$jn="http://feeds.jn.pt/JN-Ultimas";
$feedArrJN=json_decode(json_encode(simplexml_load_file($jn, "SimpleXMLElement", LIBXML_NOCDATA)),true);

/* RSS Feeds a consumir END */



/* Feed Jornal de Noticias BEGIN */
if(isset($feedArrJN['channel'])){
   

    if(isset($feedArrJN['channel']['item'])){
        echo "<div class='container'>";
        foreach ($feedArrJN['channel']['item'] as $list){
            $descricao = "";
            $sendDataHora = "";
           
            if(!empty ($list['description'])){
                $descricao = $list['description'];
                $rssDate = tratarData($list['pubDate']);               
            }
           
                //MOSTRAR DADOS DO XML
                /* echo "<div class='item'>";
                echo "<a href='".$list['link']."' target='_blank'><h2>".$list['title']."</h2></a>";
                echo "<div class='desc'>".$descricao."</div>";
                echo "<div class='desc'>".$rssDate."</div>";
                echo "<div class='desc'>"."Categoria:".$list['category']."</div>";
                echo "<br></div>"; */
                //MOSTRAR DADOS XML END

                
                //Verificar se a noticia já existe
                if(!isset($e)){
                    //verifica se ja existem registos
                    $select = $conn->prepare("SELECT titulo FROM noticias WHERE titulo = :titulo");
                    $select->bindParam(':titulo', $list['title']);
                    $select->execute();
                    
                    if($select->rowCount() > 0){
                        //se ja existirem linhas na BD nao faz nada.
                    } else {
                        //Securly insert into database
                    
                        
                        /* execInsertNoticia($conn, $list['title'], $descricao, $rssDate, $list['category']); */
                        
                        $sql = "INSERT INTO `noticias` (`id`, `titulo`, `corpo`, `publicacao`, `categoria`) VALUES (NULL, :titulo, :corpo, :publicacao, :categoria)";    
                        $query = $conn->prepare($sql);
                   
                        $query->execute(array(
                            ':titulo' => $list['title'],
                            ':corpo' => $descricao,
                            ':publicacao' =>$rssDate,
                            ':categoria' =>$list['category']
                               
                       
                            ));
                       // execInsert($conn, $list['title'], $descricao, $rssDate, $list['category']);
                       
                        
                        }
                }

                    //Verificar END 

                    //DELETE > 2 DAYS

                    deleteNoticia($conn, 2, "DAY");

                    //DELETE ($pdo, int-nr de dias, metrica)
        }
        echo "</div>";
    }else{
        echo "Invalid Feed Link";
    }
}else{
    echo "Invalid Feed";
}
/* Feed Jornal de Noticias END */


