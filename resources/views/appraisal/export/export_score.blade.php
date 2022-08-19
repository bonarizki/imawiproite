<table>
	<thead>
		<tr>
			<th rowspan="2"> No </th>
            <th rowspan="2"> Level </th>
			<th rowspan="2"> Headcount </th>
			<th colspan="6"> Overall Job Performance Rating </th>
		</tr>
		<tr>
			<th> Not Scored </th>
			<th> OSC<br>(1 - 1.4) </th>
            <th> ECC<br>(1.5 - 2.3) </th>
            <th> HVC<br>(2.4 - 3.1) </th>
            <th> MCE<br>(3.2 - 4) </th>
            <th> USC<br>(4.1 - 5) </th>
		</tr>
	</thead>
	<tbody>
		<?php $i = 1; ?>
		@foreach($data1 as $d)
			<tr>
				<td>{{ $i++ }}</td>
				<td>{{ $d->grade_group_name }}</td>
				<td>{{ $d->headcount }}</td>
				<td>{{ $d->not_scored }}</td>
				<td>{{ $d->osc }}</td>
				<td>{{ $d->ecc }}</td>
				<td>{{ $d->hvc }}</td>
				<td>{{ $d->mce }}</td>
				<td>{{ $d->usc }}</td>
			</tr>
		@endforeach
	</tbody>
</table>
<br>
<br>
<table>
	<thead>
		<tr>
            <th rowspan="1" colspan="2"> SAP<br>(Significantly Above Plan) </th>
            <th rowspan="1"> OP<br>(On Plan) </th>
            <th rowspan="1" colspan="2"> BP<br>(Below Plan) </th>
        </tr>
        <tr>
            <th> OSC<br>(1 - 1.4) </th>
            <th> ECC<br>(1.5 - 2.3) </th>
            <th> HVC<br>(2.4 - 3.1) </th>
            <th> MCE<br>(3.2 - 4) </th>
            <th> USC<br>(4.1 - 5) </th>
        </tr>
	</thead>
	<tbody>
		<tr>
			<td>{{ $data2->osc }}</td>
			<td>{{ $data2->ecc }}</td>
			<td>{{ $data2->hvc }}</td>
			<td>{{ $data2->mce }}</td>
			<td>{{ $data2->usc }}</td>
		</tr>
	</tbody>
</table>