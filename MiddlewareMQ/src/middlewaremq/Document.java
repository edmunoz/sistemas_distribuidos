/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package middlewaremq;

/**
 *
 * @author desarrollo3
 */
public class Document implements java.io.Serializable{
    public String id;
    public String fecha;
    public String tipo;
    public String numero;
    public String ruc_cedula;
    public String fechaAutorizacion;
    public String archivo_pdf;
    public String archivo_xml;

    public String getId() {
        return id;
    }

    public void setId(String id) {
        this.id = id;
    }

    public String getFecha() {
        return fecha;
    }

    public void setFecha(String fecha) {
        this.fecha = fecha;
    }

    public String getTipo() {
        return tipo;
    }

    public void setTipo(String tipo) {
        this.tipo = tipo;
    }

    public String getNumero() {
        return numero;
    }

    public void setNumero(String numero) {
        this.numero = numero;
    }

    public String getRuc_cedula() {
        return ruc_cedula;
    }

    public void setRuc_cedula(String ruc_cedula) {
        this.ruc_cedula = ruc_cedula;
    }

    public String getFechaAutorizacion() {
        return fechaAutorizacion;
    }

    public void setFechaAutorizacion(String fechaAutorizacion) {
        this.fechaAutorizacion = fechaAutorizacion;
    }

    public String getArchivo_pdf() {
        return archivo_pdf;
    }

    public void setArchivo_pdf(String archivo_pdf) {
        this.archivo_pdf = archivo_pdf;
    }

    public String getArchivo_xml() {
        return archivo_xml;
    }

    public void setArchivo_xml(String archivo_xml) {
        this.archivo_xml = archivo_xml;
    }

    @Override
    public String toString() {
        String data = this.id + this.fecha + this.tipo + this.numero + this.ruc_cedula + this.fechaAutorizacion + this.archivo_pdf + this.archivo_xml;
        return data;
    }
    
}
