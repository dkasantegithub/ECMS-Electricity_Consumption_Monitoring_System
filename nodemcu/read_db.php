<!DOCTYPE html>
<html>
	<head>
		<style>
			table {
				border-collapse: collapse;
				width: 100%;
				color: #1f5380;
				font-family: monospace;
				font-size: 20px;
				text-align: left;
			} 
			th {
				background-color: #1f5380;
				color: white;
			}
			tr:nth-child(even) {background-color: #f2f2f2}
		</style>
	</head>
	<?php
		//Creates new record as per request
		//Connect to database
		$hostname = "127.0.0.1:3308";		//example = localhost or 192.168.0.0
		$username = "root";		//example = root
		$password = "";	
		$dbname = "ecms";
		// Create connection
		$conn = mysqli_connect($hostname, $username, $password, $dbname);
		// Check connection
		if (!$conn) {
			die("Connection failed !!!");
		} 
	?>
	<body>
		<table>
			<tr>
				<th>id</th> 
				<th>energy_consumed</th> 
				<th>date</th>
				<th>time</th>
			</tr>	
			<?php
				$table = mysqli_query($conn, "SELECT id, energy_consumed, date, time FROM econsumed"); //nodemcu_ldr_table = Youre_table_name
				while($row = mysqli_fetch_array($table))
				{
			?>
			<tr>
				<td><?php echo $row["id"]; ?></td>
				<td><?php echo $row["energy_consumed"]; ?></td>
				<td><?php echo $row["date"]; ?></td>
				<td><?php echo $row["time"]; ?></td>
			</tr>
			<?php
				}
			?>
		</table>
	</body>
</html>