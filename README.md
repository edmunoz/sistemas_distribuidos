SISTEMAS DISTRIBUIDOS

Descripción del problema

Se implementó una plataforma que almacena las facturas electrónicas que generan diferentes empresas por ejemplo mi comisariato, tia, supermaxi, etc la cual contendrá millones de registros por lo cual se pretende implementar un sistema distribuido que permita hacer la consulta de una manera eficiente y rápida para el usuario final.

Middleware

Se utilizó ActiveMQ ya que ofrece ventajas significativas respecto a los complejos servicios de administración de cola de mensajes y a los servicios de mensajería hospedados bajo licencia y se puede minimizar la carga administrativa que supone ejecutar y escalar un clúster de mensajería de gran disponibilidad y al ser open source se evitan los costos de pagar una licencia se dispone de una gran comunidad que contribuye con ayuda voluntaria.    

Persistencia de colas de mensajes en base de datos con JDBC: ActiveMQ tiene soporte para poder almacenar mensajes en la mayoría de bases de datos. 

Implementación

Este aplicación permite la consulta de las facturas de un determinado cliente, esta consulta es con su id o Número de factura. La aplicación cuenta con un elevado número de usuarios almacenados en una base de datos relacional MySQL, evaluaremos la actividad del usuario para saber cómo interactúa con la aplicación y conseguir que nuestro sistema sea flexible y minimice el tiempo de respuesta. Para implementar  hacemos uso de ActiveMQ. 
Cada vez que la aplicación detecte una acción de un usuario como “Consulta por Nº Factura” es enviado un mensaje a nuestro intermediario de mensajes con la información de dicha acción.

##Ejecución del meddleware (Active MQ)
* sudo ./pache-activemq-5.9.0/bin/activemq start
* http://localhost:8161/admin
* usuario: admin
* clave: admin


##Ejecución aplicación de lado del cliente(Laravel)

* sudo /opt/lampp/lampp start
* google-chrome http://localhost/sistemas_distribuidos/portal/public/auth/login


##Ejecución utilizando archivo make file

Ubicarnos en la consola donde se encuentrra el archivo Makefile 
y ejecutar el siguiente comando:
* make



