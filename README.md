# osekai-db
database class for working on a database using prepared queries with mysqli - by @mulraf
# Usage
## execSimpleSelect
`Database::execSimpleSelect([string]query)`

Selects from database. Should not use user-input 

### Examples:
Select all from database
```php
Database::execSimpleSelect("SELECT * FROM Medals");
```

## execSelect
`Database::execSelect([string]query, [string]types, [array]inputs)`

Selects from database using prepared statement. Here is where you use user input

### Examples:
Get row from ID
```php
$id = $_GET['id'];
Database::execSelect("SELECT * FROM Users WHERE id = ?", "i", array($id));
// "i" for int
```
Get row from two different IDs
```php
$osu_id = 2;
$discord_id = 70828730997551104;
Database::execSelect("SELECT * FROM Users WHERE OsuId = ? AND DiscordId = ?", "ii", array($osu_id, $discord_id)); 
```

## execOperation
`Database::execOperation([string]query, [string]types, [array]inputs);`

Similar to execSelect, though runs an operation

### Examples:
Update value in database
```php
$id = 2;
$newUsername = "cool username!";
Database::execOperation("UPDATE `Users` SET `Username` = ? WHERE `UserID` = ?", "si", array($newUsername, $id)); 
```
Insert pageview into analytics database
```php
// $countryCode = ?;
// $currentApp = ?;
// $urlQuery = ?;
// $url = ?;
Database::execOperation("INSERT INTO StatsPageViews (date, location, app, query, url) VALUES (CURRENT_TIMESTAMP, ?, ?, ?, ?)", "ssss", array($countryCode, $currentApp, $urlQuery, $url));
```
