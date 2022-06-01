extract folder inside xampp/htdocs or wamp/htdocs
on config/database and adjust database connectivity
import database inside root dir (api.sql)

now open browser:

type :

	1. localhost/api/user/index.php    -GET-  - list all users
	2. localhost/api/user/create.php   -POST- {} payload
	3. localhost/api/user/view.php     -POST- {id:2} payload
	4. localhost/api/user/delete	   -POST- {id:12} payload