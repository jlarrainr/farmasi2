<html>
<head>
<title>Ejemplo de DOM</title>
<script language="JavaScript">
function dibujarTabla()
{
TABLA = document.createElement('table');
TBODY = document.createElement('tbody');
FILA = document.createElement('tr');
COLUMNA1 = document.createElement('td');
COLUMNA1.setAttribute('className','negrita');
COLUMNA1.setAttribute('class','negrita');
TEXTO1 = document.createTextNode('celda 1');
COLUMNA1.appendChild(TEXTO1);
COLUMNA2 = document.createElement('td');
COLUMNA2.setAttribute('className','negrita');
COLUMNA2.setAttribute('class','negrita');
TEXTO2 = document.createTextNode('celda 2');
COLUMNA2.appendChild(TEXTO2);
FILA.appendChild(COLUMNA1);
FILA.appendChild(COLUMNA2);
TBODY.appendChild(FILA);
TABLA.appendChild(TBODY);
document.getElementById('enlace').appendChild(TABLA);
}
</script>
<style>
.negrita
{
font-weight: bold;
}
</style>
</head>
<body>
<span style="cursor:pointer; text-decoration: underline;" onclick="javascript:dibujarTabla();">Comenzar</span>
<div id="enlace"></div>
</body>
</html>
