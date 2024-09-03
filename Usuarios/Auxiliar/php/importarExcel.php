<?php
/*PARTE DEL CÓDIGO CONSULTADO Y TOMADO EN LA PÁGINA: 
https://evilnapsis.com/2019/03/20/importar-datos-de-un-excel-a-una-base-de-datos-mysql-con-php/ 
*/
include ("../../../Php/conexion.php");
include "class.upload.php";
if(isset($_FILES["name"])){
	$up = new Upload($_FILES["name"]);
	if($up->uploaded){
		$up->Process("./uploads/");
		if($up->processed){
            /// leer el archivo excel
            require_once '../../../librerias/PHPExcel/Classes/PHPExcel.php';
            $archivo = "uploads/".$up->file_dst_name;
            $inputFileType = PHPExcel_IOFactory::identify($archivo);
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
            $objPHPExcel = $objReader->load($archivo);
            $sheet = $objPHPExcel->getSheet(0); 
            $highestRow = $sheet->getHighestRow(); 
            $highestColumn = $sheet->getHighestColumn();
			
			$sql="DROP TABLE dalumn";
			mysqli_query($conex,$sql);
			$sql1="DROP TABLE dclist";
			mysqli_query($conex,$sql1);
            
			$sqldalumn="CREATE TABLE `dalumn` (
						  `id_dalumn` int(11) NOT NULL  PRIMARY KEY  AUTO_INCREMENT,
						  `aluctr` char(10) NOT NULL,
						  `aluapp` char(25) NOT NULL,
						  `aluapm` char(25) NOT NULL,
						  `alunom` char(50) NOT NULL,
						  `alusex` char(1) NOT NULL,
						  `alucur` char(18) NOT NULL ) ;";
			mysqli_query($conex,$sqldalumn);
			
			$sqldclist=" CREATE TABLE `dclist` (
				  `id_DCLIST` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
				  `aluctr` char(10) NOT NULL,
				  `pdocve` int(11) NOT NULL,
				  `carcve` int(11) NOT NULL,
				  `clinpe` int(2) NOT NULL,
				  `paqcve` varchar(4) DEFAULT NULL ) ;";
			mysqli_query($conex,$sqldclist);
			
		
			for ($row = 2; $row <= $highestRow; $row++){ 
                $x_aluctr = $sheet->getCell("A".$row)->getValue();
                $x_alupp = $sheet->getCell("B".$row)->getValue();
                $x_alupm = $sheet->getCell("C".$row)->getValue();
                $x_alunom = $sheet->getCell("D".$row)->getValue();
                $x_alusex = $sheet->getCell("E".$row)->getValue();
                $x_alucurp = $sheet->getCell("F".$row)->getValue();
				$x_aluperiodo = $sheet->getCell("G".$row)->getValue();
				$x_alucarrera = $sheet->getCell("H".$row)->getValue();
				$x_alusemestre = $sheet->getCell("I".$row)->getValue();
                $sql = "insert into dalumn (aluctr, aluapp, aluapm, alunom, alusex, alucur) value ";
                $sql .= " (\"$x_aluctr\",\"$x_alupp\",\"$x_alupm\",\"$x_alunom\",\"$x_alusex\",\"$x_alucurp\")";
			   $conex->query($sql);
			   
				$sql1 = "insert into dclist (aluctr, pdocve, carcve, clinpe) value ";
				$sql1 .= " (\"$x_aluctr\",\"$x_aluperiodo\",\"$x_alucarrera\",\"$x_alusemestre\")";
              //echo( $sql1);
			   $conex->query($sql1);
            }
    	unlink($archivo);
        }	

}
}
header("location:../exportacionSQL.php");
?>