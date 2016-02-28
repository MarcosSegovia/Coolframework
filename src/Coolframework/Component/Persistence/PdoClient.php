<?php

namespace Coolframework\Component\Persistence;

use Coolframework\Component\Persistence\Exception\PdoClientException;
use PDO;
use PDOException;
use PDOStatement;

class PdoClient implements PersistenceClient
{
	private $pdo;
	/** @var  PDOStatement */
	private $actual_statement;

	public function __construct(PDO $a_pdo)
	{
		$this->pdo = $a_pdo;
	}

	public function prepare($statement_to_prepare)
	{
		try
		{
			$this->actual_statement = $this->pdo->prepare($statement_to_prepare);
		}
		catch (PDOException $e)
		{
			throw new PdoClientException('There was an error when trying to prepare a query statement: ' . $e->getMessage());
		}
	}

	public function bindValue(
		$parameter,
		$value
	)
	{
		try
		{
			$this->actual_statement->bindValue($parameter, $value);
		}
		catch (PDOException $e)
		{
			throw new PdoClientException('There was an error when trying to bind a value: ' . $e->getMessage());
		}
	}

	public function execute()
	{
		try
		{
			$this->actual_statement->execute();
		}
		catch (PDOException $e)
		{
			throw new PdoClientException('There was an error when trying to execute a PDO Statement ' . $e->getMessage());
		}
	}

	public function executeAndRetrieve()
	{
		try
		{
			$this->actual_statement->execute();

			return $this->actual_statement->fetchAll();
		}
		catch (PDOException $e)
		{
			throw new PdoClientException('There was an error when trying to execute a PDO Statement ' . $e->getMessage());
		}
	}

	public function query(
		$query_to_execute,
		$array_with_values_to_bind = NULL
	)
	{
		try
		{
			return $this->pdo->query($query_to_execute);
		}
		catch (PDOException $e)
		{
			throw new PdoClientException('There was an error when trying to execute a PDO Statement ' . $e->getMessage());
		}
	}

	public function select(
		$table,
		$array_of_condition_value = NULL
	)
	{
		$sql_statement = "SELECT * FROM $table";
		$sql_statement .= is_null($array_of_condition_value) ? '' : ' WHERE ';

		$add_and = FALSE;

		if (is_null($array_of_condition_value))
		{
			$array_of_condition_value = array();
		}

		foreach ($array_of_condition_value as $key => $value)
		{
			if ($add_and)
			{
				$sql_statement .= ' AND ';
			}
			else
			{
				$add_and = TRUE;
			}

			$sql_statement .= "$key = :$key";
		}

		try
		{
			$statement_processed = $this->pdo->prepare($sql_statement);

			foreach ($array_of_condition_value as $key => $value)
			{
				$statement_processed->bindValue(':' . $key, $value);
			}

			$statement_processed->execute();

			return $statement_processed->fetchAll();
		}
		catch (PDOException $e)
		{
			throw new PdoClientException('There was an error when trying to update a table: ' . $e->getMessage());
		}

	}

	public function insert(
		$table,
		$array_of_column_value
	)
	{
		$sql_statement = "INSERT INTO $table";

		$columns_string = '(';
		$values_string  = 'VALUES (';
		$add_comma      = FALSE;

		foreach ($array_of_column_value as $key => $val)
		{
			if ($add_comma)
			{
				$columns_string .= ', ';
				$values_string .= ', ';
			}
			else
			{
				$add_comma = TRUE;
			}

			$columns_string .= "$key";
			$values_string .= ":$key";
		}

		$sql_statement .= $columns_string . ') ';
		$sql_statement .= $values_string . ')';

		try
		{
			$statement_processed = $this->pdo->prepare($sql_statement);

			foreach ($array_of_column_value as $key => $value)
			{
				$statement_processed->bindValue(':' . $key, $value);
			}

			$statement_processed->execute();
		}
		catch (PDOException $e)
		{
			throw new PdoClientException('There was an error when trying to insert in a table: ' . $e->getMessage());
		}
	}

	public function update(
		$table,
		$array_of_column_value
	)
	{
		$sql_statement = "UPDATE $table SET ";

		$add_comma  = FALSE;
		$set_string = '';

		foreach ($array_of_column_value as $key => $value)
		{
			if ($add_comma)
			{
				$set_string .= ', ';
			}
			else
			{
				$add_comma = TRUE;
			}

			$set_string .= "$key = :$key";
		}

		$sql_statement .= $set_string;

		try
		{
			$statement_processed = $this->pdo->prepare($sql_statement);

			foreach ($array_of_column_value as $key => $value)
			{
				$statement_processed->bindValue(':' . $key, $value);
			}

			$statement_processed->execute();

		}
		catch (PDOException $e)
		{
			throw new PdoClientException('There was an error when trying to update a table: ' . $e->getMessage());
		}

	}

	public function delete(
		$table,
		$array_of_condition_value = NULL
	)
	{
		$sql_statement = "DELETE FROM $table";
		$sql_statement .= is_null($array_of_condition_value) ? '' : ' WHERE ';

		$add_and = FALSE;

		if (is_null($array_of_condition_value))
		{
			$array_of_condition_value = array();
		}

		foreach ($array_of_condition_value as $key => $value)
		{
			if ($add_and)
			{
				$sql_statement .= ' AND ';
			}
			else
			{
				$add_and = TRUE;
			}

			$sql_statement .= "$key = :$key";
		}

		try
		{
			$statement_processed = $this->pdo->prepare($sql_statement);

			foreach ($array_of_condition_value as $key => $value)
			{
				$statement_processed->bindValue(':' . $key, $value);
			}

			$statement_processed->execute();
		}
		catch (PDOException $e)
		{
			throw new PdoClientException('There was an error when trying to update a table: ' . $e->getMessage());
		}
	}

	public function __destruct()
	{
		unset($this->pdo);
	}
}
