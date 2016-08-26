all:
	sudo /opt/lampp/lampp start
	sudo ./apache-activemq-5.9.0/bin/activemq start
	google-chrome http://localhost/sistemas_distribuidos/portal/public/auth/login
	google-chrome http://localhost:8161/admin