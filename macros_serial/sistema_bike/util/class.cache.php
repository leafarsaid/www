<?php
/*
Criado por Antonio Campos
CHANGELOG
04-01-2008
-> Primeiro release!
*/
class Cache{

function Cache($nome_arquivo)
{
//Direct�rio onde queremos guardar os ficheiros de cache
$this->directorio_cache = "cache/"; //Agora vamos come�ar a contruir uma string que ir� conter o nome so script que vamos fazer cache

$this->pagina = $_SERVER['SCRIPT_NAME']."/";
//se existir uma query string vamos concatenar a mesma com o nome do ficheiro

if (isset($_SERVER['QUERY_STRING']))
{
$this->pagina=$this->pagina.$_SERVER['QUERY_STRING'];

}
}
function Inicio()
{
//Gerar o nome do ficheiro de cache correspondente � p�gina que estamos

//O MD5 � s� para evitar que o nome contenha careteres inv�lidos por exemplo ? e & comuns nas query strings

//coloquei a extenss�o html podem colocar o que quiserem

$this->ficheiro_cache = $this->directorio_cache . $this->nome_arquivo . '.html';
//md5($this->pagina)

//Verificar se o ficheiro j� existe na cache

if (file_exists($this->ficheiro_cache))

{

//se j� existir l�-mos o mesmo e geramos o output

readfile($this->ficheiro_cache);

//como j� fizemos output n�o queremos que mais nada seja executado!

exit();

}

//se chegar aqui � porque o ficheiro n�o existia em cache e temos que o criar

//esta fun��o cria um buffer onde � colocado o outup que � igualmente enviado ao cliente

ob_start();

}

function Fim()

{

// Como n�o exise o ficheiro na cache vamos cria-lo e abrir em modo w (w de write)

$fp = fopen($this->ficheiro_cache, 'w');

//Escrevemos o conteudo do buffer no novo ficheiro de cache

@fwrite($fp, ob_get_contents());

//Esta parte n�o � necess�ria � s� escrever no fim do ficheiro a data e hora em que o mesmo foi gerado

$hora = date('h:i:s, j-m-Y');

@fwrite($fp, "<!� Cache - $this->pagina - $hora �>");

//fechamos o apontador para o ficheiro

@fclose($fp);

//e fechamos tamb+em o buffer criado

ob_end_flush();

}

function Limpar()

{

//criamos um apontador para o directorio onde esta guardada a cache

if ($handle = $this->directorio_cache)

{

//um ciclo que percorre todos os ficheiros

while (false !== ($file = readdir($handle)))

{

//evitar um erro!!

if ($file != '.' and $file != '..')

{

//S� uma informa��o

echo 'Apagado �> '.$file . '<br>';

//apagar cada um dos ficheiros

unlink($this->directorio_cache . '/' . $file);
}
}
//fechamos o apontador
closedir($handle);

}
}
}
?>
