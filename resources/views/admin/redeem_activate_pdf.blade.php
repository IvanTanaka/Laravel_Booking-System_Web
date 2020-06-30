<!DOCTYPE html>
<html>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
        <h5>Laporan Redeem Untuk Transfer</h4>
        <h6>{{Carbon\Carbon::now()}}</h6>
	</center>
 
	<table class='table table-bordered'>
		<thead>
			<tr>
				<th>No</th>
				<th>Bank</th>
				<th>Account Number</th>
				<th>Amount</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			@php $i=1 @endphp
			@foreach($redeems as $redeem)
			<tr>
                <td>{{ $i++ }}</td>
                <td>{{$redeem->bank_account->bank}}</td>
                <td>{{$redeem->bank_account->account_number}}</td>
                <td>Rp {{number_format($redeem->amount,0,",",".")}},00</td>
                <td></td>
			</tr>
			@endforeach
		</tbody>
	</table>
 
</body>
</html>