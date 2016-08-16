all:
	sudo /opt/lampp/lampp start
	google-chrome http://localhost/sistemas_distribuidos/portal/public/auth/login
	google-chrome http://localhost:8161/admin/