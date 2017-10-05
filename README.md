# Micro-service
Web service dev, PHP and MySQL with MVC pattern

## Notice

## Installation
1. Open connection.php and edit with your database settings
2. On your database, open a SQL terminal paste this and execute:

```sql
CREATE TABLE `wp_clients` (
  `id` int(11) NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `vendorId` int(11) NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

CREATE TABLE `wp_vendors` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `email` varchar(255) COLLATE utf8_bin NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updatedAt` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `defaultVendor` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


```


## Usage
First parameter is the controller to use, second action to trigger and the rest of needed parameters like id, name, email, etc.
yourpath.com/?controller=clients&action=index 
yourpath.com/?controller=clients&action=show&id=x
yourpath.com/?controller=users&action=add&roles_id=1&username=miname&dateOfBirth=2000-06-05%2000:00:00&firstname=papap&lastname=popo&pass=1234&phone=565656&email=nono@d.com&current_role=1

