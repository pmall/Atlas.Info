# Atlas.Info

## Getting Started

### Instantiation

Create an information-discovery object with a corresponding connection:

```php
use Atlas\Info\Info;
use Atlas\Pdo\Connection;

$connection = Connection::new('sqlite::memory:');
$info = Info::new($connection);
```

### Fetching Table Names

To get an array of table names from the current schema, call `fetchTableNames()`.

```php
$tableNames = $info->fetchTableNames();
foreach ($tableNames as $tableName) {
    echo $tableName . PHP_EOL;
}
```

You can also indicate that you want table names from another schema:

```php
$tableNames = $info->fetchTableNames('schema_name');
```

### Fetching Column Defintions

To get an array of column definitions in a table, call `fetchColumns()`.

```php
<?php
$columns = $info->fetchColumns('table_name'); // or 'schema_name.table_name'
foreach ($columns as $name => $def) {
    echo "Column $name is of type "
       . $def['type']
       . " with a size of "
       . $def['size']
       . PHP_EOL;
}
?>
```

Each element is itself an array, with the following keys:

- `name`: (string) The column name

- `type`: (string) The column data type.  Data types are as reported by the database.

- `size`: (?int) The column size (character length for strings, or numeric precision for numbers).

- `scale`: (?int) The number of decimal places for the column, if any.

- `notnull`: (bool) Is the column marked as `NOT NULL`?

- `default`: (mixed) The default value for the column. Note that this will be `null` if the underlying database uses an SQL expression instead of a literal string or number.

- `autoinc`: (bool) Is the column auto-incremented?

- `primary`: (bool) Is the column part of the primary key?

### Fetching Autoincrement Sequence Name

To fetch the name of the primary key autoincrement sequence on a PostgreSQL table, call `fetchAutoincSequence()` with the table name.

```php
<?php
$sequence = $info->fetchAutoincSequence('table_name');
// => 'table_name_id_seq'
?>
```

On systems other than PostgreSQL, this will return `null`.
