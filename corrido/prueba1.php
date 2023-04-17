<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>Ejemplo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<style type="text/css">
<!--
.TIT {
font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 10px;
font-weight: bold;
color: #FFFFFF;
}
.CONT {
font-family: Verdana, Arial, Helvetica, sans-serif;
font-size: 9px;
font-weight: normal;
color: #333333;
}
-->
</style>
</head>

<body>
<table width="300" border="0" cellspacing="1" cellpadding="0" bgcolor="#000000">
<tr bgcolor="#993333" class="TIT">
<td>ID</td>
<td>Nombre</td>
<td>DNI</td>
</tr>
<tr bgcolor="#CCCCCC" class="CONT" onMouseOver="this.style.cursor='hand';this.style.cursor='pointer';" onClick="alert(this.getElementsByTagName('td')[0].innerHTML);alert(this.innerHTML)">
<td>15</td><td>Pepe</td><td>151515152</td>
</tr>
<tr bgcolor="#CCCCCC" class="CONT" onMouseOver="this.style.cursor='hand';this.style.cursor='pointer';" onClick="alert(this.getElementsByTagName('td')[0].innerHTML);document.getElementById('mostrar').innerHTML='<table><tr class=&quot;CONT&quot;>'+this.innerHTML+'</tr></table>'">
<td>16</td><td>Marta</td><td>184565562</td>
</tr>
<tr bgcolor="#CCCCCC" class="CONT" onMouseOver="this.style.cursor='hand';this.style.cursor='pointer';" onClick="alert(this.getElementsByTagName('td')[0].innerHTML);document.getElementById('mostrar').innerHTML='<table><tr class=&quot;CONT&quot;>'+(((this.innerHTML).split('</td><td>').join(' - ')).split('</TD><TD>').join(' - ')).split('</TD>\r\n<TD>').join(' - ')+'</tr></table>'">
<td>17</td><td>Carlo</td><td>264584123</td>
</tr>
</tr>
<tr bgcolor="#CCCCCC" class="CONT" onMouseOver="this.style.cursor='hand';this.style.cursor='pointer';" onClick="alert(this.getElementsByTagName('td')[0].innerHTML);alert('<table><tr class=&quot;CONT&quot;>'+(((this.innerHTML).split('</td><td>').join(' - ')).split('</TD><TD>').join(' - ')).split('</TD>\r\n<TD>').join(' - ')+'</tr></table>')">
<td>17</td><td>Carlo</td><td>264584123</td>
</tr>
</table>
<div id="mostrar" class="CONT"></div>
</body>
</html>