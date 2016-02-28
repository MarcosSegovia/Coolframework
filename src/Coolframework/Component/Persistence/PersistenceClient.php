<?php

namespace Coolframework\Component\Persistence;

interface PersistenceClient
{
	public function prepare($statement_to_prepare);

	public function bindValue($parameter, $value);

	public function execute();

	public function executeAndRetrieve();

	public function query(
		$query_to_execute,
		$array_with_values_to_bind = null
	);

	public function select(
		$table,
		$array_of_condition_value = null
	);

	public function insert(
		$table,
		$array_of_column_value
	);

	public function update(
		$table,
		$array_of_column_value
	);

	public function delete(
		$table,
		$array_of_condition_value = null
	);
}
