<?php
/*
 * O – The Open Closed Principle (Принцип открытости/закрытости)
 */

interface IOrderSource {
	public function load( $orderID );

	public function save( $order );

	public function update( $order );

	public function delete( $order );
}

class MySQLOrderSource implements IOrderSource {
	public function load( $orderID ) {/*...*/
	}

	public function save( $order ) {/*...*/
	}

	public function update( $order ) {/*...*/
	}

	public function delete( $order ) {/*...*/
	}
}

class ApiOrderSource implements IOrderSource {
	public function load( $orderID ) {/*...*/
	}

	public function save( $order ) {/*...*/
	}

	public function update( $order ) {/*...*/
	}

	public function delete( $order ) {/*...*/
	}
}

class OrderRepository {
	private $source;

	public function __constructor( IOrderSource $source ) {
		$this->source = $source;
	}

	public function load( $orderID ) {

		return $this->source->load( $orderID );
	}

	public function save( $order ) {/*...*/
	}

	public function update( $order ) {/*...*/
	}
}