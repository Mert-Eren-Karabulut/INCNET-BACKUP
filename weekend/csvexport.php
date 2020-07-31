<?
$csv_list = array(array('Student ID', 'Student Name', 'Bus Name', 'Departure Date', 'Arrival Date'),
									array($list_student_id, $list_student_name, $list_bus_name, $list_dep_date, $list_arr_date));
$csv_file = fopen('list.csv', 'w');
foreach ($csv_list as $csv_fields){
	fputcsv($csv_file, $csv_fields);
}
fclose($csv_file);
?>
