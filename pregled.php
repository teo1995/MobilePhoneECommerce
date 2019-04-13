
<!DOCTYPE html>
<html lang="hr‐HR">
<head>
<meta charset="UTF‐8" />
<link rel="stylesheet" href="stil.css" >

<head>
<title> Pregled </title>


</head>

<h1> Pregled podataka u tablici </h1>

<form method="POST">
<input type="text" name="trazi" value="<?php if(isset($_POST['trazi'])){echo $_POST['trazi'];} ?>" />
<button type="submit">Pronađi</button>
</form>  

<?php
$dbo = new mysqli("127.0.0.1", "root", "", "owp2018");
$dbo->query("SET NAMES 'utf8'");
$trazi = (isset($_POST['trazi']) ? $_POST['trazi'] : null);
if (isset($_POST['submit-form']) &&  isset($_POST["trazi"])) {
		$upit_pretrazivanje = "SELECT * FROM student WHERE IME LIKE ('%".$trazi."%') OR PREZIME LIKE ('%".$trazi."%') ";
		$res = $dbo->query($upit_pretrazivanje);
}else{
	$upit_dohvatiStudenta = "SELECT * FROM student " ;
	$res = $dbo->query($upit_dohvatiStudenta);
}


 
?>
<body>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Ime</th>
            <th>Prezime</th>
			<th>MTBR</th>
        </tr>
    </thead>
    <tbody>
        <?php while( $red = $res->fetch_array()) : ?>
        <tr>
            <td><?php echo $red[0]; ?></td>
            <td><?php echo $red[1]; ?></td>
            <td><?php echo $red[2]; ?></td>
			<td><?php echo $red[3]; ?></td>
        </tr>
        <?php endwhile ?>
		
    </tbody>
	</table>
	

  

</body>
</html>


