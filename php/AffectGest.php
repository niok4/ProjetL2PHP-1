<?php
include('../BDD/DataBaseLogin.inc.php');
include("./AffectGestFonc.php");

$connexion = new mysqli($server, $user, $passwd, $db);
	
if($connexion->connect_error)
{
  echo('Erreur de connexion('.$connexion->connect_errno.') '.$connexion->connect_error);
}
$selectSQL = "SELECT * FROM Utilisateur WHERE role = 'Utilisateur' and idUtilisateur NOT IN (SELECT idGestionnaire FROM Gestionnaire) ";

$res_t = $connexion->query($selectSQL);
 if(!$res_t){
   echo 'Retrieval of data from Database Failed - #'.mysqli_errno().': '.mysqli_error();
 }else{
?>
<table border="2">
 <thead>
   <tr>
     <th>Nom</th>
     <th>Prenom</th>
     <th>e-mail</th>
   </tr>
 </thead>
 <tbody>
 <form method="post" action="AffectGest.php">
   <?php
       while( $row = mysqli_fetch_assoc( $res_t ) ){
         echo "<tr><td>{$row['nom']}</td><td>{$row['prenom']}</td><td>{$row['email']}</td><td><button type='submit' name='envoiValeur' value={$row['idUtilisateur']}>Voilà</button></td></tr>\n";
       }
   ?>
  </form>
 </tbody>
</table>
<?php
}
if(!empty($_POST['envoiValeur'])){
  assertGest((int)$_POST['envoiValeur']);
}
?>

