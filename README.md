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

### Пример

Есть класс Order в котором описана логика работы с заказом.

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

Необходимо разделить его на несколько классов и выделить логику работы с базой и отображением в отдельные классы

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

### Пример

У нас есть класс OrderRepository. В его методе load описана работа получения заказа из БД.

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

Когда появляется необходимость получать заказы не только с базы, а например с API, то можно поступить следующим образом:
1. Создать интерфейс IOrderSource
2. Сделать 2 класса MySQLOrderSource и ApiOrderSource, которые выполняют данный интерфейс
3. И передавать в конструктор класса OrderRepository инстанс, который реализует интерфейс IOrderSource.

Таким образом мы можем легко добавлять новый источник заказов просто реализовав класс с интерфейсом IOrderSource. 

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

### Пример ###

У нас есть класс LessonRepository, который в методе getAll возвращает массив всех уроков из файла. Появилась необходимость получать уроки из БД. Создаем класс DatabaseLessonRepository, наследуем его от LessonRepository и переписываем метод getAll.

```php
class LessonRepository {
	
    //return array of lesson through file system.
	public function getAll() {
		return $files;
	}
	
}

class DatabaseLessonRepository extends LessonRepository {
	
    //return a Collection type instead of array
	public function getAll() {
		return Lesson::all();
	}
	
}
```

В методе getAll у класса DatabaseLessonRepository вместо коллекции мы должны вернуть массив

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

### Пример ###

У нас есть интерфейс Bird, который имеет методы eat и fly. Когда в коде появляется Penguin, который не умеет летать нужно бросить Exception.

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

Вместо Exception лучше разделить интерфейсы для птицы на Bird, FlyingBird и RunningBird.

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

### Пример ###

У нас есть класс EBookReader, который принимает в коструктор объект класса PDFBook и в методе read - читает его. Когда появляется необходимость читать не только из PDF-файла класс необходимо изменять. 

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

Лучше сделать интерфейс EBook с методом read. И тогда в EBookReader мы сможем передавать любые объекты, которые реализовывают интерфейс EBook.  

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