<?php

    ////////////////////////////////////////////
    // サマリデータ登録ロジック
    ////////////////////////////////////////////
    // 起動パラメータ
    // 		1.月単位のデータ投入
    // 		2.単位のデータ投入
    // 		3.時間単位のデータ投入
    ////////////////////////////////////////////


    ////////////////////
    // t_summary_m
    ////////////////////
    $sql_Del_M =  "DELETE FROM `t_summary_m`							";
    $sql_Del_M .= " WHERE DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%Y%m') <= LEFT(v_YYYYMM, 6);	";
    
    $sql_M  = "";
    $sql_M .= "INSERT INTO `t_summary_m`(								";
    $sql_M .= "	`v_YYYYMM`,												";
    $sql_M .= "	`d_a_temperature`,										";
    $sql_M .= "	`d_a_humidity`,											";
    $sql_M .= "	`d_a_pressure`,											";
    $sql_M .= "	`d_a_Illuminance`,										";
    $sql_M .= "	`v_memo`												";
    $sql_M .= ")														";
    $sql_M .= "SELECT													";
    $sql_M .= "	DATE_FORMAT(d_datetime, '%Y%m') AS 'v_YYYYMM',			";
    $sql_M .= "	avg(d_temperature) AS d_temperature,					";
    $sql_M .= "	avg(d_humidity) AS d_humidity,							";
    $sql_M .= "	avg(d_pressure) AS d_pressure,							";
    $sql_M .= "	avg(d_Illuminance) AS d_Illuminance,					";
    $sql_M .= "	null													";
    $sql_M .= "FROM														";
    $sql_M .= "	t_data1													";
    $sql_M .= "WHERE													";
    $sql_M .= "	DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%Y%m') <= LEFT(v_YYYYMMDD, 6)	";
    $sql_M .= "group by 												";
    $sql_M .= "	DATE_FORMAT(d_datetime, '%Y%m')							";
    $sql_M .= ";														";
    
    ////////////////////
    // t_summary_d
    ////////////////////
    $sql_Del_D =  "DELETE FROM `t_summary_d` 							";
    $sql_Del_D .= " WHERE DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%Y%m%d') <= v_YYYYMMDD;	";
    
    $sql_D  = "INSERT INTO `t_summary_d`(								";
    $sql_D .= "	`v_YYYYMMDD`,											";
    $sql_D .= "	`d_a_temperature`,										";
    $sql_D .= "	`d_a_humidity`,											";
    $sql_D .= "	`d_a_pressure`,											";
    $sql_D .= "	`d_a_Illuminance`,										";
    $sql_D .= "	`v_memo`												";
    $sql_D .= ")														";
    $sql_D .= "SELECT													";
    $sql_D .= "	DATE_FORMAT(d_datetime, '%Y%m%d') AS 'v_YYYYMMDD',		";
    $sql_D .= "	avg(d_temperature) AS d_temperature,					";
    $sql_D .= "	avg(d_humidity) AS d_humidity,							";
    $sql_D .= "	avg(d_pressure) AS d_pressure,							";
    $sql_D .= "	avg(d_Illuminance) AS d_Illuminance,					";
    $sql_D .= "	null													";
    $sql_D .= "FROM														";
    $sql_D .= "	t_data1													";
    $sql_D .= "WHERE													";
    $sql_D .= "	DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%Y%m%d') <= v_YYYYMMDD			";
    $sql_D .= "group by 												";
    $sql_D .= "	DATE_FORMAT(d_datetime, '%Y%m%d')						";
    $sql_D .= ";														";


    ////////////////////
    // t_summary_h
    ////////////////////
    $sql_Del_H  = "DELETE FROM `t_summary_h`							";
    $sql_Del_H .= " WHERE DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%Y%m%d') <= LEFT(v_YYYYMMDDHH, 8);	";
    
    
    $sql_H  = "INSERT INTO `t_summary_h`(								";
    $sql_H .= "	`v_YYYYMMDDHH`,											";
    $sql_H .= "	`v_HH`,													";
    $sql_H .= "	`d_a_temperature`,										";
    $sql_H .= "	`d_a_humidity`,											";
    $sql_H .= "	`d_a_pressure`,											";
    $sql_H .= "	`d_a_Illuminance`,										";
    $sql_H .= "	`v_memo`												";
    $sql_H .= ")														";
    $sql_H .= "SELECT													";
    $sql_H .= "	DATE_FORMAT(d_datetime, '%Y%m%d%H') AS 'v_YYYYMMDDHH',	";
    $sql_H .= "	DATE_FORMAT(d_datetime, '%H') AS 'v_HH',		        ";
    $sql_H .= "	avg(d_temperature) AS d_temperature,					";
    $sql_H .= "	avg(d_humidity) AS d_humidity,							";
    $sql_H .= "	avg(d_pressure) AS d_pressure,							";
    $sql_H .= "	avg(d_Illuminance) AS d_Illuminance,					";
    $sql_H .= "	null													";
    $sql_H .= "FROM														";
    $sql_H .= "	t_data1													";
    $sql_H .= "WHERE													";
    $sql_H .= "	DATE_FORMAT(DATE_SUB(CURDATE(), INTERVAL 1 DAY), '%Y%m%d') <= v_YYYYMMDD			";
    $sql_H .= "group by 												";
    $sql_H .= "	DATE_FORMAT(d_datetime, '%Y%m%d%H')						";
    $sql_H .= ";														";
    
    
    if(!isset($argv[1]))
    {
		echo "Error:-1:パラメータは1〜3のいずれかを指定してください" . "\n";
		return -1;
    }
    $param = $argv[1];
    echo "param:" . $param . "\n";

    $dSQL = "";
    $iSQL = "";
    
    switch($param)
    {
		case 1:
		    $dSQL = $sql_Del_M;
		    $iSQL = $sql_M;
		    //echo "\n" . "sql_M:" . "\n" . $iSQL . "\n";
		    break;
		case 2:
		    $dSQL = $sql_Del_D;
		    $iSQL = $sql_D;
		    //echo "\n" . "sql_D:" . "\n" . $iSQL . "\n";
		    break;
		case 3:
		    $dSQL = $sql_Del_H;
		    $iSQL = $sql_H;
		    //echo "\n" . "sql_H:" . "\n" . $iSQL . "\n";
		    break;
		default :
		    echo "Error:-1:1〜3以外のパラメータが指定されました" . "\n";
		    return -1;
	}

	require_once(__DIR__ . "/libs/db_util.php");
	$db_name = "db_kumikomi";
	$dbh = initDB($db_name);

	if($dbh)
	{
	}

    ////////////////////
    // deleteSQL実行
    ////////////////////
	$stmt = $dbh->prepare($dSQL);

	if (!$stmt)
	{
		echo "Error:-1:DB接続エラーです1" . "\n";
		var_dump($dbh->errorInfo());
		return -1;
	}
	$flag = $stmt->execute();
	echo "flag = " . $flag . "\n";
	if (!$flag)
	{
		echo "Error:-1:DB接続エラーです2" . "\n";
		var_dump($dbh->errorInfo());
		return -1;
	}

    ////////////////////
    // insertSQL実行
    ////////////////////
	$stmt = $dbh->prepare($iSQL);

	if (!$stmt)
	{
		echo "Error:-1:DB接続エラーです3" . "\n";
		var_dump($dbh->errorInfo());
		return -1;
	}
	$flag = $stmt->execute();
	echo "flag = " . $flag . "\n";
	if (!$flag)
	{
		echo "Error:-1:DB接続エラーです4" . "\n";
		var_dump($dbh->errorInfo());
		return -1;
	}

	echo "Done:0:正常終了" . "\n";
?>
