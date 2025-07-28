run: server queue
	
server:
	php artisan ser &
queue:
	php artisan queue:work &
queue-faile:
	php artisan queue:failed