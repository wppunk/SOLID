<?php
/*
 * D – The Dependency Inversion Principle(Принцип инверсии зависимостей)
 */

interface EBook {
	public function read();
}

class EBookReader {

	private $book;

	public function __construct( EBook $book ) {
		$this->book = $book;
	}

	public function read() {
		return $this->book->read();
	}

}

class PDFBook implements EBook {

	public function read() { /*...*/
	}

}

class MobiBook implements EBook {

	public function read() { /*...*/
	}

}