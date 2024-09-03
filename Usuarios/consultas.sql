SELECT * FROM dalumn,dcarre,dclist,actividadalumno,grupos,actividadesextraescolares,datosalumno 
WHERE 
dalumn.aluctr=Id_NumControlAlumno
AND id_AlumnoCTR=Id_NumControlAlumno 
AND dclist.aluctr=Id_NumControlAlumno 
AND datosalumno.id_AlumnoCTR 
AND dcarre.Carcve=dclist.carcve 
AND Id_Grupos=IdGrupo 
AND Estatus!='Negado'


SELECT 
da.aluctr AS numControl, 
da.alunom AS nombre, 
da.aluapp AS apePaterno, 
da.aluapm AS apeMaterno,
dca.Carnom AS carrera,
dc.clinpe AS semestre, 
dal.telefonoAvanzadoAlumno AS telefono,
dal.correoAvanzadoAlumno AS correo,
aa.horarioAcademico AS horario, 
gp.nombreGrupo AS grupo,
gp.horaGrupo AS hora,
dal.alergia AS alerta,
aa.Estatus AS estatus,
aa.nombreCertificado AS documento
FROM dalumn AS da
INNER JOIN dclist AS dc ON dc.aluctr=da.aluctr
INNER JOIN dcarre AS dca ON dca.Carcve=dc.carcve
INNER JOIN datosalumno AS dal ON dal.id_AlumnoCTR=da.aluctr
INNER JOIN actividadalumno AS aa ON aa.Id_NumControlAlumno=da.aluctr
INNER JOIN grupos AS gp ON gp.Id_Grupos=aa.IdGrupo