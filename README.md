# Discord-uWuFication
Discord-uWuFication is a small discord webhook written in PHP to parse an RSS feed trough and 'UwUfy' the contents, after this it gets posted in Discord.
## Requirements
- PHP 7.3+ 
- PHP-xml
- PHP-curl

## Running the webhook 

Change the webhook in ```src/run.php``` to your desired webhooks
```
$conns->addHook("https://discord.com/api/webhooks/xyz/xyz");
```
Run the webhook by using docker or execute the ```run.php``` file found in src/ with PHP
#
### example
![Example](https://i.imgur.com/T48Mxez.png)

#
Also checkout [Twitter-UwUFication!](https://github.com/Artemixed/Twitter-uWuFication)
