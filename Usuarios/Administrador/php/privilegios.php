<?php
session_start();
	session_id();
	
	if(!isset($_SESSION['id'])){
		header("location:../../../index.php");
		exit;
	}else{
		if($_SESSION['numTipoUsuario']!=1){
		header("location:../../../index.php");
		exit;
		}
	}

			include ("../../../Php/conexion.php"); 
			if(isset($_POST['Ingresar'])){ 
				if(empty($_POST['A1'])){
					$A1=0;
				}else{
					$A1=$_POST['A1'];
				}
				
				if(empty($_POST['A2'])){
					$A2=0;
				}else{
					$A2=$_POST['A2'];
				}
				
				if(empty($_POST['A3'])){
					$A3=0;
				}else{
					$A3=$_POST['A3'];
				}
				
				if(empty($_POST['A4'])){
					$A4=0;
				}else{
					$A4=$_POST['A4'];
				}
				
				if(empty($_POST['A5'])){
					$A5=0;
				}else{
					$A5=$_POST['A5'];
				}
				
				if(empty($_POST['AD1'])){
					$AD1=0;
				}else{
					$AD1=$_POST['AD1'];
				}
		
				$consultaAlumno="UPDATE tipousuario SET p1='$A1', p2='$A2', p3='$A3', aC='$A4', aM='$A5', AD1='$AD1' WHERE IdTipoUsuario='2'";
				$queryAlumno=mysqli_query($conex,$consultaAlumno);
				
				if(empty($_POST['C1'])){
					$C1=0;
				}else{
					$C1=$_POST['C1'];
				}
				
				if(empty($_POST['C2'])){
					$C2=0;
				}else{
					$C2=$_POST['C2'];
				}
				
				if(empty($_POST['C3'])){
					$C3=0;
				}else{
					$C3=$_POST['C3'];
				}
				
				if(empty($_POST['C4'])){
					$C4=0;
				}else{
					$C4=$_POST['C4'];
				}
				
				if(empty($_POST['C5'])){
					$C5=0;
				}else{
					$C5=$_POST['C5'];
				} 
				$sqlPromotor="UPDATE tipousuario SET p1='$C1', p2='$C2', p3='$C3', p4='$C4', p5='$C5' WHERE IdTipoUsuario='4'";
				$promotorQuery=mysqli_query($conex,$sqlPromotor);
				
				if(empty($_POST['B1'])){
					$B1=0;
				}else{
					$B1=$_POST['B1'];
				}
				
				if(empty($_POST['B2'])){
					$B2=0;
				}else{
					$B2=$_POST['B2'];
				}
				
				if(empty($_POST['B3'])){
					$B3=0;
				}else{
					$B3=$_POST['B3'];
				}
				
				if(empty($_POST['B4'])){
					$B4=0;
				}else{
					$B4=$_POST['B4'];
				}
				
				if(empty($_POST['B5'])){
					$B5=0;
				}else{
					$B5=$_POST['B5'];
				}
				
				if(empty($_POST['B6'])){
					$B6=0;
				}else{
					$B6=$_POST['B6'];
				}
				
				if(empty($_POST['B7'])){
					$B7=0;
				}else{
					$B7=$_POST['B7'];
				}
				
				if(empty($_POST['B8'])){
					$B8=0;
				}else{
					$B8=$_POST['B8'];
				}
				
				if(empty($_POST['B9'])){
					$B9=0;
				}else{
					$B9=$_POST['B9'];
				}
				
				if(empty($_POST['B0'])){
					$B0=0;
				}else{
					$B0=$_POST['B0'];
				}
				
				if(empty($_POST['nuevoAlum'])){
					$alum=0;
				}else{
					$alum=$_POST['nuevoAlum'];
				}
				
				if(empty($_POST['BD'])){
					$BD=0;
				}else{
					$BD=$_POST['BD'];
				}
				
				if(empty($_POST['aM'])){
					$aM=0;
				}else{
					$aM=$_POST['aM'];
				}
				
				$sqlAuxiliar="UPDATE tipousuario SET p1='$B1', p2='$B2', p3='$B3', P4='$B4',p5='$B5', p6='$B6', p7='$B7', P8='$B8', p9='$B9', P0='$B0', aC='$alum', AD1='$BD' , aM='$aM' WHERE IdTipoUsuario='3'";
				$auxiliarQuery=mysqli_query($conex,$sqlAuxiliar);
			
			}
			
			header("location:../privilegios.php");
?>