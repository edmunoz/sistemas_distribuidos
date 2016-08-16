/*
 * Prueba Proyecto Sistemas Distribuidos Productor Mensajes
 */

package actimemqproducer;


import java.util.*;
import javax.jms.*;
import javax.jms.JMSException;
import javax.jms.MessageProducer;
import javax.jms.Queue;
import javax.jms.Session;
import javax.jms.TextMessage;
import org.apache.activemq.ActiveMQConnection;
import org.apache.activemq.ActiveMQConnectionFactory;

/**
 *
 * @author MiguelMise
 */
public class ActimeMQProducer {

    public enum UserAction {
 
        CONFIGURACION("IR A OPCIONES DE CONFIGURACION"),
        PORTADA("VER PORTADA"),
        LOGIN("ACCEDER A LA APLICACION"),
        SUGERENCIA("ENVIAR SUGERENCIA");
 
        private final String userAction;
 
        private UserAction(String userAction) {
            this.userAction = userAction;
        }
 
        public String getActionAsString() {
            return this.userAction;
        }
    }
 
    private static final Random RANDOM = new Random(System.currentTimeMillis());
 
    private static final String URL = "tcp://localhost:61616";
 
    private static final String USER = ActiveMQConnection.DEFAULT_USER;
 
    private static final String PASSWORD = ActiveMQConnection.DEFAULT_PASSWORD;
 
    private static final String DESTINATION_QUEUE = "APLICATION1.QUEUE";
 
    private static final boolean TRANSACTED_SESSION = true;
    
    private static final int MESSAGES_TO_SEND = 20;
 
    public void sendMessages() throws JMSException {
 
        final ActiveMQConnectionFactory connectionFactory = new ActiveMQConnectionFactory(USER, PASSWORD, URL);
        Connection connection = connectionFactory.createConnection();
        connection.start();
 
        final Session session = connection.createSession(TRANSACTED_SESSION, Session.AUTO_ACKNOWLEDGE);
        final Destination destination = session.createQueue(DESTINATION_QUEUE);
 
        final MessageProducer producer = session.createProducer(destination);
        producer.setDeliveryMode(DeliveryMode.PERSISTENT);
 
        sendMessages(session, producer);
        session.commit();
 
        session.close();
        connection.close();
 
        System.out.println("Mensajes enviados correctamente");
    }
 
    private void sendMessages(Session session, MessageProducer producer) throws JMSException {
        final ActimeMQProducer messageSender = new ActimeMQProducer();
        for (int i = 1; i <= MESSAGES_TO_SEND; i++) {
            final UserAction userActionToSend = getRandomUserAction();
            messageSender.sendMessage(userActionToSend.getActionAsString(), session, producer);
        }
    }
 
    private void sendMessage(String message, Session session, MessageProducer producer) throws JMSException {
        final TextMessage textMessage = session.createTextMessage(message);
        producer.send(textMessage);
    }
 
    private static UserAction getRandomUserAction() {
        final int userActionNumber = (int) (RANDOM.nextFloat() * UserAction.values().length);
        return UserAction.values()[userActionNumber];
    }
 
    public static void main(String[] args) throws JMSException {
        final ActimeMQProducer messageSender = new ActimeMQProducer();
        messageSender.sendMessages();
    }
 
}
    

