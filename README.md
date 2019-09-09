# SOLID Principles
SOLID — мнемонический акроним, введённый Майклом Фэзерсом (Michael Feathers) для первых пяти принципов, названных Робертом Мартином в начале 2000-х, которые означали пять основных принципов объектно-ориентированного программирования и проектирования.

## Для чего нужны принципы SOLID? ##
Принципы SOLID — это набор правил, которые необходимо применять во время работы над программным обеспечением(ПО) для его улучшения.

Удевительно то, что принципы были сформулированы несколько десятков лет назад и до сих пор актуальны. Это может говорить только о их еффективности.

## S – The Single Responsibility Principle (Принцип единственной ответственности) ##
Каждый класс выполняет лишь одну задачу.

![The Single Responsibility Principle](images/The%20Single%20Responsibility%20Principle.png)

Очень простой, но в тоже время очень и очень важный принцип. Необходимо следить в вашем ПО, чтобы каждый класс или интерфейс не был перегружен лишней логикой и выполнял только одну задачу.

Часто при правке багов и хотфиксов нарушается этот принцип. В случае хотфиксов нужно занести это в технический долг и выполнить его в ближайшее время.

### Example
```php
class Order {

	public function calculateTotalSum() {/*...*/}

	public function getItems() {/*...*/}

	public function getItemCount() {/*...*/}

	public function addItem( $item ) {/*...*/}

	public function deleteItem( $item ) {/*...*/}

	public function printOrder() {/*...*/}

	public function showOrder() {/*...*/}

	public function load() {/*...*/}

	public function save() {/*...*/}

	public function update() {/*...*/}

	public function delete() {/*...*/}
	
}
```

```php
class Order {

	public function calculateTotalSum() {/*...*/}

	public function getItems() {/*...*/}

	public function getItemCount() {/*...*/}

	public function addItem( $item ) {/*...*/}

	public function deleteItem( $item ) {/*...*/}
	
}

class OrderRepository {

	public function load( $orderID ) {/*...*/}

	public function save( $order ) {/*...*/}

	public function update( $order ) {/*...*/}

	public function delete( $order ) {/*...*/}
	
}

class OrderViewer {

	public function printOrder( $order ) {/*...*/}

	public function showOrder( $order ) {/*...*/}
	
}
```
## O – The Open Closed Principle (Принцип открытости/закрытости) ##

Классы должны быть открыты для расширения и закрыты для модификации.

![The Open Closed Principle](images/The%20Open%20Closed%20Principle.png)
В идеальном мире это для добавление нового функционала нужно добавлять новый код, а не изменять старый.

Багфикс, рефакторинг и улучшение производительности это не нарушение этого принципа. Принцип гласит именно про изменение логики работы ПО.

### Example

```php
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

	public function save( $order ) {/*...*/}

	public function update( $order ) {/*...*/}

	public function delete( $order ) {/*...*/}
	
}
```

```php
interface IOrderSource {

	public function load( $orderID );

	public function save( $order );

	public function update( $order );

	public function delete( $order );
	
}

class MySQLOrderSource implements IOrderSource {

	public function load( $orderID ) {/*...*/}

	public function save( $order ) {/*...*/}

	public function update( $order ) {/*...*/}

	public function delete( $order ) {/*...*/}
	
}

class ApiOrderSource implements IOrderSource {

	public function load( $orderID ) {/*...*/}

	public function save( $order ) {/*...*/}

	public function update( $order ) {/*...*/}

	public function delete( $order ) {/*...*/}
	
}

class OrderRepository {
	
	private $source;

	public function __constructor( IOrderSource $source ) {
		$this->source = $source;
	}

	public function load( $orderID ) {
		return $this->source->load( $orderID );
	}

	public function save( $order ) {/*...*/}

	public function update( $order ) {/*...*/}
	
}
```

## L – The Liskov Substitution Principle (Принцип подстановки Барбары Лисков) ##

Наследники должны повторять поведение родительского класса и должны вести себя без сюрпризов.

![The Liskov Substitution Principle](images/The%20Liskov%20Substitution%20Principle.png)

### Example ###

```php
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
```

```php
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
```
## I – The Interface Segregation Principle (Принцип разделения интерфейса) ##

Много мелких интерфейсов лучше, чем один большой.

![The Interface Segregation Principle](images/The%20Interface%20Segregation%20Principle.png)

```php
interface Bird {
	
	public function eat();

	public function fly();
	
}

class Duck implements Bird {

	public function eat() {/*...*/}

	public function fly() {/*...*/}
	
}

class Penguin implements Bird {
	
	public function eat() {/*...*/}

	public function fly() {/* exception */}
	
}
```

```php
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
	
	public function eat() {/*...*/}

	public function fly() {/*...*/}
	
}

class Penguin implements Bird, RunningBird {
	
	public function eat() {/*...*/}
	public function run() {/*...*/}
	
}
```

## D – The Dependency Inversion Principle (Принцип инверсии зависимостей) ##

Зависимость на абстракциях, нет зависимостей на что-то конкретное.

![The Dependency Inversion Principle](images/The%20Dependency%20Inversion%20Principle.png)

Самое простое решение начать применять этот принцип это писать тесты т.к. при их написании тестов необходимо мокать какие-то данные и как итог: проще переписать класс, чем написать на него тест.

### Example ###

```php
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
```

```php
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

	public function read() {/*...*/}

}

class MobiBook implements EBook {

	public function read() {/*...*/}

}
```

## Основные триггеры того, что принципы SOLID нарушены: ##

- Оператор switch
- Большое кол-во констант
- new внутри методов класса
- instanseof

## Часть проблем решает применение паттернов проектирования: ##

Найболее полулярные паттерны в PHP:
- Strategy
- State
- Chain of Responsibility
- Visitor
- Decorator
- Composition
- Factory