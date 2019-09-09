<?php
/*
 * S – The Single Responsibility Principle (Принцип единственной ответственности)
 */

class Order {
	public function calculateTotalSum() {/*...*/
	}

	public function getItems() {/*...*/
	}

	public function getItemCount() {/*...*/
	}

	public function addItem( $item ) {/*...*/
	}

	public function deleteItem( $item ) {/*...*/
	}
}

class OrderRepository {
	public function load( $orderID ) {/*...*/
	}

	public function save( $order ) {/*...*/
	}

	public function update( $order ) {/*...*/
	}

	public function delete( $order ) {/*...*/
	}
}

class OrderViewer {
	public function printOrder( $order ) {/*...*/
	}

	public function showOrder( $order ) {/*...*/
	}
}