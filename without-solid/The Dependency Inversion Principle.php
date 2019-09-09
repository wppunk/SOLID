<?php
/*
 * D – The Dependency Inversion Principle(Принцип инверсии зависимостей)
 */

class EBookReader {

	private $book;

	public function __construct( PDFBook $book ) {
		$this->book = $book;
	}

	public function read() {
		return $this->book->read();
	}

}

class PDFBook {

	public function read() { /*...*/
	}
}
