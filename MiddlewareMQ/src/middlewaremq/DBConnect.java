package middlewaremq;


import java.sql.*;
import java.util.ArrayList;
import java.util.List;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 *
 * @author desarrollo3
 */
public class DBConnect {
    private Connection connection;
    private Statement statement;
    private ResultSet rs;
    
    String url = "jdbc:mysql://108.167.133.34:3306/";
    String username = "connie_zapec";
    String dbName = "connie_factelectzapec";
    String password = "z@p3cc0nni3";
    String driver = "com.mysql.jdbc.Driver";


    public DBConnect(){
        try{
            Class.forName(driver).newInstance();
            Connection conn =  DriverManager.getConnection(url+dbName,username,password);
            statement = conn.createStatement();		            
        }catch(Exception e){
            System.out.println("Error: " + e.getMessage());
        }
    }
    
    //0992719133001
    public List<Document> get_documents(String cedula){
        List<Document> documents = new ArrayList<Document>();
        try{
            String query = "SELECT * FROM documento_electronico WHERE ruc_cedula = " + cedula + ";";
            this.rs = this.statement.executeQuery(query);
            while(rs.next()){
                Document document = new Document();
                document.id = this.rs.getString("id");
                document.tipo = this.rs.getString("tipo");
                document.fecha = this.rs.getString("fecha");
                document.numero = this.rs.getString("numero");
                document.fechaAutorizacion = this.rs.getString("fechaAutorizacion");
                document.ruc_cedula = this.rs.getString("ruc_cedula");
                document.archivo_pdf = this.rs.getString("archivo_pdf");
                document.archivo_xml = this.rs.getString("archivo_xml");
                documents.add(document);
            }
            
        }catch(Exception e){            
            System.out.println("Error: " + e.getMessage());
        }
        return documents;
    }
    
    
}
