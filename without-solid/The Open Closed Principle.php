<?php
/*
 * O – The Open Closed Principle (Принцип открытости/закрытости)
 */

class OrderRepository {
	public function load( $orderID ) {
		$pdo       = new PDO(
			$this->config->getDsn(),
			$this->config->getDBUser(),
			$this->config->getDBPassword()
		);
		$statement = $pdo->prepare( "SELECT * FROM `orders` WHERE id=:id" );
		$statement->execute( array( ":id" => $orderID ) );

		return $query->fetchObject( "Order" );
	}

	public function save( $order ) {/*...*/
	}

	public function update( $order ) {/*...*/
	}

	public function delete( $order ) {/*...*/
	}
}