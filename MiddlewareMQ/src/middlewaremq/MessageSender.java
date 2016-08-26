/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package middlewaremq;
import java.util.List;
import java.util.Random;
import javax.jms.Connection;
import javax.jms.DeliveryMode;
import javax.jms.Destination;
import javax.jms.JMSException;
import javax.jms.MessageProducer;
import javax.jms.Session;
import javax.jms.TextMessage;
import org.apache.activemq.ActiveMQConnection;
import org.apache.activemq.ActiveMQConnectionFactory;
/**
 *
 * @author desarrollo3
 */
public class MessageSender {
    
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
        final MessageSender messageSender = new MessageSender();
        DBConnect contect = new DBConnect();
        List<Document> documents = contect.get_documents("0992719133001");
        for (int i = 0; i < documents.size(); i++) {
            Document document = documents.get(i);
            messageSender.sendMessage(document.toString(), session, producer);
        }
        /*
        for (int i = 1; i <= MESSAGES_TO_SEND; i++) {
            final UserAction userActionToSend = getRandomUserAction();
            messageSender.sendMessage(userActionToSend.getActionAsString(), session, producer);
        }*/
    }
 
    private void sendMessage(String message, Session session, MessageProducer producer) throws JMSException {
        final TextMessage textMessage = session.createTextMessage(message);
        producer.send(textMessage);
    }
    
    
  
 
    private static UserAction getRandomUserAction() {
        final int userActionNumber = (int) (RANDOM.nextFloat() * UserAction.values().length);
        return UserAction.values()[userActionNumber];
    }

 
}
