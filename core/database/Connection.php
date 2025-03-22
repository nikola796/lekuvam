<?php
class Connection
{
	public static function make($connect) {
		try {
			return new PDO(
				$connect['host'] . '; dbname=' . $connect['db_name'],
				$connect['user'],
				$connect['password'],
				$connect['option']
			);
		} catch (Exception $e) {
			die( $e->getMessage());
		}
	}
}