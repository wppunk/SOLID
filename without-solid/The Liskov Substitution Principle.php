<?php
/*
 * L – The Liskov Substitution Principle (Принцип подстановки Барбары Лисков)
 */

class LessonRepository {
	public function getAll() {
		return $files;
	}
}

class DatabaseLessonRepository extends LessonRepository {
	public function getAll() {
		return Lesson::all();
	}
}