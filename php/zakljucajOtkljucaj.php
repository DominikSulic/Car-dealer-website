<?php
$trenutniStatus=$_POST["status"];
$idKorisnika=$_POST["idKor"];

if($trenutniStatus==1){
    $suprotniStatus=0;
}
else{
    $suprotniStatus=1;
};
$upit="UPDATE korisnik SET Zakljucan=".$suprotniStatus." WHERE ID_Korisnik=".$idKorisnika."";
require_once "baza.php";
if($rezultat = upit($upit)){
}
else{
    echo "Neuspjesno obavljeno";
};

?>