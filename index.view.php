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
						<?php $items = explode(',', $tweet); ?>
						<tr>
							<td><?= $items[0] ?></td>
							<td><?= convert_link($items[2]) ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</thead>
		</table>
	</body>
</html>