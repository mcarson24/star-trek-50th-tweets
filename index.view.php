<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<title></title>
	</head>
	<body>
		<table>
			<thead>
				<tr>
					<th scope="col">Timestamp</th>
					<th scope="col">Tweet</th>
				</tr>
				<tbody>
					<?php foreach ($tweets as $tweet) : ?>
						<?php $tweet = new App\Tweet($tweet); ?>
						<tr>
							<td style="width: 25%;"><?= $tweet->time() ?></td>
							<td><?= $tweet->text() ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</thead>
		</table>
	</body>
</html>