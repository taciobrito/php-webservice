<!DOCTYPE html>
<html>
<head>
	<title>Teste</title>
</head>
<body>

	<table class="table">
		<tr>
			<td>#</td>
			<td>Nome</td>
			<td>Turno</td>
		</tr>
		<?php 
			foreach ($medicos as $key => $value) {
		?>
				<tr>
					<td><?php echo $value->id; ?></td>
					<td><?php echo $value->nome; ?></td>
					<td><?php echo $value->turno; ?></td>
				</tr>
		<?php 
			} 
		?>
	</table>
</body>
</html>