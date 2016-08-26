/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package middlewaremq;

import javax.jms.JMSException;

/**
 *
 * @author desarrollo3
 */
public class MiddlewareMQ {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) throws JMSException {
        final MessageSender messageSender = new MessageSender();
        messageSender.sendMessages();
    }
}
