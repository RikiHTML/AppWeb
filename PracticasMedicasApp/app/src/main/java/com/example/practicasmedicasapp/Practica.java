package com.example.practicasmedicasapp;

import androidx.room.Entity;
import androidx.room.PrimaryKey;

@Entity
public class Practica {
    @PrimaryKey(autoGenerate = true)
    public int id;

    public String nombreEstudiante;
    public String descripcion;
    public String implementos;
    public String rutaFoto;
    public String fecha;
}