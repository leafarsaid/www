<?
if ($_SESSION['logado']>0 || $_SESSION['logado']==null) exit();
if (isset($_POST['submit'])) {
    $alert = "ERRO:\\n\\nFalha ao limpar tempos";
    $sql = "DELETE FROM t01_tempos";
    //
    if ($obj_controle->executa($sql)) {
        $alert = "SUCESSO:\\n\\nRegistros apagados";
    }
    echo "<script>alert('".$alert."');</script>";
}
?>

<form name="limpa" method="post" onsubmit="if (confirm('Você tem certeza que deseja apagar todos os regstros de tempo dessa prova??')) { if (confirm('Pense bem!!')) return(true) }">
<input type="submit" name="submit" value="Armagedom - Apagar todos os registros de tempos" />
</form>