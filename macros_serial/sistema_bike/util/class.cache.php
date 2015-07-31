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
//Directório onde queremos guardar os ficheiros de cache
$this->directorio_cache = "cache/"; //Agora vamos começar a contruir uma string que irá conter o nome so script que vamos fazer cache

$this->pagina = $_SERVER['SCRIPT_NAME']."/";
//se existir uma query string vamos concatenar a mesma com o nome do ficheiro

if (isset($_SERVER['QUERY_STRING']))
{
$this->pagina=$this->pagina.$_SERVER['QUERY_STRING'];

}
}
function Inicio()
{
//Gerar o nome do ficheiro de cache correspondente à página que estamos

//O MD5 é só para evitar que o nome contenha careteres inválidos por exemplo ? e & comuns nas query strings

//coloquei a extenssão html podem colocar o que quiserem

$this->ficheiro_cache = $this->directorio_cache . $this->nome_arquivo . '.html';
//md5($this->pagina)

//Verificar se o ficheiro já existe na cache

if (file_exists($this->ficheiro_cache))

{

//se já existir lê-mos o mesmo e geramos o output

readfile($this->ficheiro_cache);

//como já fizemos output não queremos que mais nada seja executado!

exit();

}

//se chegar aqui é porque o ficheiro não existia em cache e temos que o criar

//esta função cria um buffer onde é colocado o outup que é igualmente enviado ao cliente

ob_start();

}

function Fim()

{

// Como não exise o ficheiro na cache vamos cria-lo e abrir em modo w (w de write)

$fp = fopen($this->ficheiro_cache, 'w');

//Escrevemos o conteudo do buffer no novo ficheiro de cache

@fwrite($fp, ob_get_contents());

//Esta parte não é necessária é só escrever no fim do ficheiro a data e hora em que o mesmo foi gerado

$hora = date('h:i:s, j-m-Y');

@fwrite($fp, "<!– Cache - $this->pagina - $hora –>");

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

//Só uma informação

echo 'Apagado –> '.$file . '<br>';

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
