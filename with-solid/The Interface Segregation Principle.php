<?php
/*
 * I – The Interface Segregation Principle(Принцип разделения интерфейса)
 */

interface Bird {
	public function eat();
}

interface FlyingBird {
	public function fly();
}

interface RunningBird {
	public function run();
}

class Duck implements Bird, FlyingBird {
	public function eat() { /*...*/
	}

	public function fly() { /*...*/
	}
}

class Penguin implements Bird, RunningBird {
	public function eat() { /*...*/
	}

	public function run() { /*...*/
	}
}