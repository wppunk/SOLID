<?php
/*
 * I – The Interface Segregation Principle(Принцип разделения интерфейса)
 */

interface Bird {
	public function eat();

	public function fly();
}

class Duck implements Bird {
	public function eat() { /*...*/
	}

	public function fly() { /*...*/
	}
}

class Penguin implements Bird {
	public function eat() {/*...*/
	}

	public function fly() { /* exception */
	}
}