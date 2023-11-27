## Get back to the design menu

- Go to \resources\views\layouts\sections\menu
- Toggle between verticalMenu.blade.php and verticalMenuBK.blade.php to check the template controls.
- Use "php artisan migrate:fresh --seed" command to create the initial data needed for the system.
- Super admin credentials are: Email:(admin@admin.com), Password:(admin), Change them.


## When adding a new module
- Go to seeders and find the permissions file
- Add the permissions as listed and migrate/seed to database
