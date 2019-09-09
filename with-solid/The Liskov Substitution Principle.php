<?php
/*
 * L – The Liskov Substitution Principle (Принцип подстановки Барбары Лисков)
 */

interface LessonRepositoryInterface {
	public function getAll(): array;
}

class FilesystemLessonRepository implements LessonRepositoryInterface {
	public function getAll(): array {
		return $files;
	}
}

class DatabaseLessonRepository implements LessonRepositoryInterface {
	public function getAll(): array {
		return Lesson::all()->toArray();
	}
}