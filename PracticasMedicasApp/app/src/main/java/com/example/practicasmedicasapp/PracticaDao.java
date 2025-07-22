package com.example.practicasmedicasapp;

import androidx.room.Dao;
import androidx.room.Insert;
import androidx.room.Query;

import java.util.List;

@Dao
public interface PracticaDao {
    @Insert
    void insertar(Practica practica);

    @Query("SELECT * FROM Practica ORDER BY fecha DESC")
    List<Practica> obtenerTodas();
}