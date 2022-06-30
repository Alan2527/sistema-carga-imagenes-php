<?php
    $conexion = mysqli_connect("localhost", "root", "", "intranet3");

    if(!empty($_POST['nombre'])) {
        $nombre=$_POST['nombre'];

        if(!empty($_POST['id'])) {
            $id_maximo = $_POST['id'];
            mysqli_query($conexion, "UPDATE persona SET nombre='$nombre' WHERE id='$id_maximo'");
            echo 'SE HA ACTUALIZADO LA INFORMACIÓN CON EXITO<br>';
        }else {
            $sql=mysqli_query($conexion, "SELECT id FROM persona WHERE nombre='$nombre'");
            if($row=mysqli_fetch_array($sql)) {
                echo 'NO SE PERMITEN DATOS DUPLICADOS EN LA BASE DE DATOS<br><br>';
            }else{
                mysqli_query($conexion, "INSERT INTO persona (nombre) VALUES ('$nombre')");
                $ss=mysqli_query($conexion, "SELECT MAX(id) as id_maximo FROM persona");
                if($rr=mysqli_fetch_array($ss)) {
                    $id_maximo=$rr['id_maximo'];
                }
                echo "SE HA REGISTRADO LA INFORMACIÓN CON EXITO";
            }
        }

        $nameimagen = $_FILES['imagen']['name'];
        $tmpimagen = $_FILES['imagen']['tmp_name'];
        $urlnueva = "imagen/foto_".$id_maximo.".jpg";
        if(is_uploaded_file($tmpimagen)) {
            copy($tmpimagen, $urlnueva);
            echo 'IMAGEN CARGADA CON EXITO';
        }else{
            echo 'ERROR AL CARGAR LA IMAGEN';
        }    
    }
?>

<form name="form" action="" method="post" enctype="multipart/form-data">
    NOMBRE <br>
    <input type="text" name="nombre" autocomplete="off" required value=""><br><br>
    SELECCIONAR IMAGEN 
    <input type="file" name="imagen" id="imagen"><br><br>
    <button type="submit">ACEPTAR</button>
</form>

<table width="100%" border="1" rules="all">
    <tr>
        <td>IMAGEN</td>
        <td>NOMBRE</td>
        <td>EDITAR</td>
    </tr>
<?php
    $ss = mysqli_query($conexion, "SELECT * FROM persona ORDER BY nombre");
    while($rr = mysqli_fetch_array($ss)){
?>
<tr>
    <td>
        <center>
            <img src="imagen/foto_<?php echo $rr['id']; ?>.jpg" width="100px" height="100px" alt="">
        </center>
    </td>
    <td><?php echo $rr['nombre']; ?></td>
    <td>
        <center>   
        <form name="form" action="" method="post" enctype="multipart/form-data">
             NOMBRE <br>
         <input type="hidden" name="id" value="<?php echo $rr['0']; ?>">    
         <input type="text" name="nombre" autocomplete="off" required value=""><br><br>
             SELECCIONAR IMAGEN 
        <input type="file" name="imagen" id="imagen"><br><br>
        <button type="submit">ACEPTAR</button>
        </form>
        </center>
    </td>
</tr>
<?php } ?>
</table>