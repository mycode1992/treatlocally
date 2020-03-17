<?php
$da = date_default_timezone_set('America/Chicago');
$date= date('Y-m-d-G.i');
header("Content-type: application/vnd.ms-excel; name='excel'");
header("Content-Disposition: attachment; filename=$date.xls");
header("Pragma: no-cache");
?>
<table id="" class="table table-bordered table-striped table-hover">
<thead>

<tr>
<th>S.No</th>
<th>First Name</th>
<th>Last name</th>
<!-- <th>Subscriber IP</th> -->
<th>Email</th>
<th>Phone no</th>
<th>Status</th>

</tr>
</thead>
<tbody>
@foreach($data as $key=>$rs)

<tr>
<td>{{ $key+1 }}</td>
<td>{{ $rs->tl_userdetail_firstname }}</td>
<td>{{ $rs->tl_userdetail_lastname }}</td>
 <td>{{ $rs->email }}</td> 
 <td>{{ $rs->tl_userdetail_phoneno }}</td> 

<td> 
<?php if($rs->status=='1')
{
$success='btn-success';
$admintext='Active';
}
else
{
$success='btn-danger';
$admintext='Deactive';
}
?>
<button type="button" class="btn btn-block <?php echo $success; ?> btn-flat" readonly>                   
<?php echo $admintext;?>
</button>
</td>
</tr>
@endforeach
</tbody>

</table>
