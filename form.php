<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta charset="utf-8">
	<style type="text/css">
		body
		{
			font-family: "Centaur Regular";
		}
		input[type=number], input[type=submit]
		{
			border-radius: 25px;
		}
	</style>
</head>
<body>
<form action="#" method="post">
	value1 : <input type="number" name = "1" ><br>
	value2 : <input type="number" name = "2"><br>
	value3 : <input type="number" name = "3"><br>
	value4 : <input type="number" name = "4"><br>
	<br>
	<input type="submit" name="gg"/>
</form>

<?
	if($_POST['gg']!=null){
		$v1=$_POST['1'];
		$v2=$_POST['2'];
		$v3=$_POST['3'];
		$v4=$_POST['4'];
			$data = array ('left-weight,left-distance,right-weight,right-distance,class',
				'5,1,3,2,L',
				'4,2,3,1,B',
				'3,5,2,1,R',
				''.$v1.','.$v2.','.$v3.','.$v4.',?');
			$fp = fopen('balance_csv.csv', 'w');
			foreach($data as $line){
			$val = explode(",",$line);
			fputcsv($fp, $val);
			}
			fclose($fp);
			// save file csv to arff-file
			// -L last set last attribute is a normial value
			$cmd = 'java -classpath "weka.jar" weka.core.converters.CSVLoader -N "last" balance_csv.csv > balance_unseen_test.arff ';
			exec($cmd,$output);
			// run unseen data -p 5 is class attribute
			$cmd1 = 'java -classpath "weka.jar" weka.classifiers.trees.J48 -T "balance_unseen_test.arff" -l "balance.model" -p 5'; // show output prediction
			exec($cmd1,$output1);
			$result="";
			for ($i=0;$i<sizeof($output1);$i++)
			{
				trim($output1[$i]);
			}
			echo "<script> alert('ข้อมูลที่ป้อนของคุณคือ $v1 $v2 $v3 $v4 \\n ผลลัพธ์ที่ได้จากการทำนายคือ ".substr($output1[8], 27,1)." \\n ที่ความน่าจะเป็นที่ ".substr($output1[8], 30)."')</script>";
	}
?>

</body>
</html>